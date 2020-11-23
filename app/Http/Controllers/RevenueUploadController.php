<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerOtherName;
use App\Http\Requests\RevenueUploadRequest;
use App\Revenue;
use Auth;
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
            $reader->startingRow = 1;
            $temp = Excel::import($reader,$file);
            $result = $reader->sheetData['Worksheet'];

            $customer_col_name = '2_pl_customer_name';
            $fpc_col_name = '1_financial_product_code';

            $columns_needed_minimum = [$fpc_col_name , $customer_col_name];

            // Now we need to check we have the right columns
            $headerRow = $reader->getHeaders('Worksheet');

            //dd($headerRow);

            // Now we need to check all the columns headers that are used for the month and year
            $months_in_file = [];
            $available_months = config('select.available_months');
            $all_years = [];

            //dd($available_months);

            foreach ($headerRow as $key => $column_name) {
                foreach ($available_months as $key => $month) {
                    $position = stripos($column_name,$month);
                    if ($position !== false) {
                        $year = substr($column_name,$position+4,2);
                        if (!in_array($year,$all_years)) {
                            array_push($all_years,$year);
                        }
                        $months_in_file[$column_name] = [];
                        $months_in_file[$column_name]['month'] = $month;
                        $months_in_file[$column_name]['act'] = stripos($column_name,'act')!== false?1:0;
                    }
                }
            }
            //dd(count($all_years));
            //dd($months_in_file);
            //dd($result);

            if (count($all_years) != 1) {
                array_push($messages, [
                    'status' => 'error',
                    'msg' => 'This tool can accept only 1 year per upload.',
                ]);

                return view('dataFeed/revenueupload', compact('messages', 'color'));
            } else {
                $year = '20'.$all_years[0];
            }


            // If the columns are not all present then we have an error and go back
            if ($reader->checkMinHeaders('Worksheet',$columns_needed_minimum)) {
                // Now we need to rearrange the table so that we have a column year and 12 columns month

                foreach ($result as $key => $row) {
                    $customer_found = false;
                    // Let s see if the customer is in Dolphin DB
                    $Customer_in_dolphin = Customer::where('name', $row[$customer_col_name])->first();

                    if (!$Customer_in_dolphin) {
                        $Customer_in_dolphin_other_name = CustomerOtherName::where('other_name', $row[$customer_col_name])->first();
                        if (!$Customer_in_dolphin_other_name) {
                            if (! in_array($row[$customer_col_name], $customers_missing)) {
                                array_push($customers_missing, $row[$customer_col_name]);
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
                            'product_code' => $row[$fpc_col_name],
                            'year' => $year,
                        ]);
                        foreach ($months_in_file as $key => $month) {
                            $month_name = $month['month'];
                            $month_actuals_name = $month['month'].'_actuals';
                            $revenue->$month_name = $row[$key];
                            $revenue->$month_actuals_name = $month['act'];
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
