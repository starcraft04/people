<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerUploadRequest;

class CustomerUploadController extends Controller
{
    public function __construct()
    {
    }

    public function getForm()
    {
        return view('dataFeed/customerupload');
    }

    public function postForm(CustomerUploadRequest $request)
    {
        $color = [
      'error' => 'text-danger',
      'info' => 'text-info',
      'update' => 'text-warning',
      'add' => 'text-primary',
    ];

        $result = new \stdClass();
        $result->result = 'success';
        $result->msg = '';

        $messages = [];

        $file = $request->file('uploadfile');
        if ($file->isValid()) {
            $filename = $file->getClientOriginalName();
            $fileextension = $file->getClientOriginalExtension();

            $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);

            //$sheet->dd();

            // Now we need to check we have the right columns
            $headerRow = $sheet->first()->keys()->toArray();
            $columns_needed = ['pl_cluster_owner', 'pl_country_owner', 'pl_customer_name'];

            //dd($headerRow);

            // If the columns are not all present then we have an error and go back
            if (array_intersect($headerRow, $columns_needed) != $columns_needed) {
                array_push($messages, ['status'=>'error', 'msg'=>'Some columns are required but not present in the file, please see the sample file and upload again.']);

                return view('dataFeed/customerupload', compact('messages', 'color'));
            }

            // This command helps getting a view on what we get from $sheet
            //$sheet->dd();

            $result = $sheet->toArray();

            //dd($result);

            foreach ($result as $row) {
                $customer_count = Customer::where('name', $row['pl_customer_name'])->count();
                if ($customer_count == 0) {
                    $customer = new Customer;
                    $customer->cluster_owner = $row['pl_cluster_owner'];
                    $customer->country_owner = $row['pl_country_owner'];
                    $customer->name = $row['pl_customer_name'];
                    $customer->save();
                } else {
                    $customer = Customer::where('name', $row['pl_customer_name'])->first();
                    $customer->cluster_owner = $row['pl_cluster_owner'];
                    $customer->country_owner = $row['pl_country_owner'];
                    $customer->save();
                }
            }
        }

        \Session::flash('success', 'File uploaded');

        return view('dataFeed/customerupload', compact('messages', 'color'));
    }
}
