<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerOtherName;
use App\Http\Requests\RevenueUploadRequest;
use App\Revenue;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelToArray;

class RevenueUploadController extends Controller
{
    public function __construct()
    {
    }

    public function getForm()
    {
        return view('dataFeed/revenueupload');
    }

    public function postForm(RevenueUploadRequest $request)
    {
        $color = [
            'error' => 'text-danger',
            'info' => 'text-info',
            'update' => 'text-warning',
            'add' => 'text-primary',
        ];

        $file = $request->file('uploadfile');

        if ($file->isValid()) {
            $messages = [];
            $customers_missing = [];
            // In case we send a CSV file, the worksheet name is : Worksheet
            $reader = new ImportExcelToArray();
            $reader->startingRow = 6;
            $temp = Excel::import($reader,$file);
            $result = $reader->sheetData['05-Revenues_FPC_Customer'];

            $columns_needed_minimum = ['customer_name', 'fpc'];

            // Now we need to check we have the right columns
            $headerRow = $reader->getHeaders('05-Revenues_FPC_Customer');

            // Now we need to check all the columns headers that are used for the month and year
            $months_in_file = [];
            $available_months = config('select.available_months');
            $all_years = [];

            foreach ($headerRow as $key => $column_name) {
                $column = explode('_', $column_name);
                if (in_array($column[0], $available_months) && ctype_digit($column[1])) {
                    array_push($months_in_file, $column_name);
                    if (! in_array($column[1], $all_years)) {
                        array_push($all_years, $column[1]);
                    }
                }
            }
            //dd($all_years);
            //dd($months_in_file);
            //dd($result);

            // If the columns are not all present then we have an error and go back
            if ($reader->checkMinHeaders('05-Revenues_FPC_Customer',$columns_needed_minimum)) {
                // Now we need to rearrange the table so that we have a column year and 12 columns month
                $result_organised = [];
                foreach ($result as $key => $row) {
                    // First we need to check that the row is not empty
                    if (! empty($row)) {
                        foreach ($all_years as $key => $year) {
                            $new_row = [];
                            $new_row['customer_name'] = $row['customer_name'];
                            $new_row['fpc'] = $row['fpc'];
                            $new_row['year'] = '20'.$year;
                            foreach ($row as $header => $value) {
                                if (in_array($header, $months_in_file)) {
                                    $header_exploded = explode('_', $header);
                                    $month = $header_exploded[0];
                                    $year_short = $header_exploded[1];
                                    if ($year_short == $year) {
                                        $new_row[$month] = round($value, 2);
                                    }
                                }
                            }
                            array_push($result_organised, $new_row);
                        }
                    }
                }
                //dd($result_organised);
                foreach ($result_organised as $key => $row) {
                    $customer_found = false;
                    // Let s see if the customer is in Dolphin DB
                    $Customer_in_dolphin = Customer::where('name', $row['customer_name'])->first();

                    if (!$Customer_in_dolphin) {
                        $Customer_in_dolphin_other_name = CustomerOtherName::where('other_name', $row['customer_name'])->first();
                        if (!$Customer_in_dolphin_other_name) {
                            if (! in_array($row['customer_name'], $customers_missing)) {
                                array_push($customers_missing, $row['customer_name']);
                            }
                        } else {
                            // Customer found in Other names DB
                            $customer_found = true;
                            $customer_id = $Customer_in_dolphin_other_name->customer_id;
                        }
                    } else {
                        // Customer found in customers DB
                        $customer_found = true;
                        $customer_id = $Customer_in_dolphin->id;
                    }

                    // If we found the customer in either table, then we can save the record
                    if ($customer_found) {
                        $revenue = Revenue::firstOrNew([
                            'customer_id' => $customer_id,
                            'product_code' => $row['fpc'],
                            'year' => $row['year'],
                        ]);
                        foreach (config('select.available_months') as $key => $month) {
                            if (isset($row[$month])) {
                                $revenue->$month = $row[$month];
                            }
                        }
                        $revenue->save();
                    }
                }
            } else {
                array_push($messages, [
                    'status' => 'error',
                    'msg' => 'Some columns are required but not present in the file, please see what is needed and upload again.',
                ]);

                return view('dataFeed/revenueupload', compact('messages', 'color'));
            }
            $customers_list = Customer::orderBy('name')->pluck('name', 'id');
            \Session::flash('success', 'File uploaded');

            return view('dataFeed/revenueupload', compact('customers_list', 'customers_missing', 'messages', 'color'));
        }
    }
}
