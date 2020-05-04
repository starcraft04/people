<?php
namespace App\Http\Controllers;
use App\Http\Requests\RevenueUploadRequest;
use App\Revenue;
use App\Customer;
use Excel;
use Config;

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
      'add' => 'text-primary'
    ];

    $file = $request->file('uploadfile');
    if($file->isValid())
    {
      $filename = $file->getClientOriginalName();
      $fileextension = $file->getClientOriginalExtension();

      // Which row is the row with the headers
      config(['excel.import.startRow' => 6]);
      // Ignore empty cells
      config(['excel.import.ignoreEmpty' => true]);

      $sheet = \Excel::selectSheets('05-Revenues_FPC_Customer')->load($file)->get();
      /* Structure of object received
        $sheet->heading is an array with all the headings
        $sheet->items is an array with all the rows and their data
        example to get the data in a cell: $sheet->items[2]->items['FPC'] where 2 is the row (starting at 0 for the first row) and FPC is the column
      */
      dd($sheet);

      $messages = [];
      // $i corresponds to the line in the excel file and because the column title is on line 1, we start with $i = 2
      $i = 2;

      foreach ($result as $row){
        $customer = Customer::where('name','=',$row['pl_customer_name'])->get();
        //dd($customer[0]->id);
        if ($customer->count()) {
          $revenue = Revenue::firstOrNew(array(
            'customer_id' => $customer[0]->id,
            'product_code' => $row['product_nfps_code'],
            'year' => $year
            ));
          if (isset($row['jan'])) {$revenue->jan = $row['jan'];}
          if (isset($row['feb'])) {$revenue->feb = $row['feb'];}
          if (isset($row['mar'])) {$revenue->mar = $row['mar'];}
          if (isset($row['apr'])) {$revenue->apr = $row['apr'];}
          if (isset($row['may'])) {$revenue->may = $row['may'];}
          if (isset($row['jun'])) {$revenue->jun = $row['jun'];}
          if (isset($row['jul'])) {$revenue->jul = $row['jul'];}
          if (isset($row['aug'])) {$revenue->aug = $row['aug'];}
          if (isset($row['sep'])) {$revenue->sep = $row['sep'];}
          if (isset($row['oct'])) {$revenue->oct = $row['oct'];}
          if (isset($row['nov'])) {$revenue->nov = $row['nov'];}
          if (isset($row['dec'])) {$revenue->dec = $row['dec'];}
          $revenue->save();
        } else {
          array_push($messages,['status'=>'error','msg'=>'LINE '.$i.': Customer '.$row['pl_customer_name'].' not in DB']);
        }
        $i += 1;
      }
    }
    \Session::flash('success', 'File uploaded');
    return view('dataFeed/revenueupload',  compact('messages','color'));
  }
}
