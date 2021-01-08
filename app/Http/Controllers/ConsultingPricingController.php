<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ConsultingPricing;
use App\Http\Requests\ConsultingPricingUploadRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelToArray;

class ConsultingPricingController extends Controller
{
    
    public function upload()
    {
        return view('dataFeed/consulting_pricing');
    }

    public function uploadFile(ConsultingPricingUploadRequest $request)
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
            $bad_countries = [];
            // In case we send a CSV file, the worksheet name is : Worksheet
            $reader = new ImportExcelToArray();
            $reader->startingRow = 1;
            $temp = Excel::import($reader,$file);
            $result = $reader->sheetData['Worksheet'];

            $columns_needed_minimum = ['country' , 'role' , 'unit_costs' , 'unit_prices'];

            // Now we need to check we have the right columns
            $headerRow = $reader->getHeaders('Worksheet');

            //dd($headerRow);
            //dd($result);

            // If the columns are not all present then we have an error and go back
            if ($reader->checkMinHeaders('Worksheet',$columns_needed_minimum)) {
                foreach ($result as $key => $row) {
                    if (!in_array($row['country'],config('countries.country'))) {
                        if (!in_array($row['country'],$bad_countries)) {
                            array_push($messages, [
                                'status' => 'error',
                                'msg' => 'The country '.$row['country'].' is not part of the config. Please see the countries.php file in the config folder.',
                            ]);
                            array_push($bad_countries,$row['country']);
                        }
                    } else {
                        ConsultingPricing::updateOrCreate(
                            ['country' => $row['country'],'role' => $row['role']],
                            ['unit_cost' => $row['unit_costs'], 'unit_price' => $row['unit_prices']]
                        );
                    }
                }
            } else {
                array_push($messages, [
                    'status' => 'error',
                    'msg' => 'Some columns are required but not present in the file, please see what is needed and upload again.',
                ]);

                return view('dataFeed/revenueupload', compact('messages', 'color'));
            }
            \Session::flash('success', 'File uploaded');

            return view('dataFeed/consulting_pricing', compact('messages', 'color'));
        }
    }

}
