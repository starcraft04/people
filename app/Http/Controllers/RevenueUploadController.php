<?php
namespace App\Http\Controllers;
use App\Http\Requests\RevenueUploadRequest;
use App\Revenue;
use App\Customer;

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
      $year = explode(".", $filename)[0];
      $year = explode("_", $filename)[0];

      if (!checkdate ( 1 , 1 , (int)$year )) {
        return redirect('revenueupload')->with('error','File name incorrect');
      }

      $year_short = substr($year, -2); 

      $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);
      // This command helps getting a view on what we get from $sheet
      //$sheet->dd();
      $result = $sheet->toArray();

      //dd($result);

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
