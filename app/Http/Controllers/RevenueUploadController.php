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
    $file = $request->file('uploadfile');
    if($file->isValid())
    {
      $filename = $file->getClientOriginalName();
      $fileextension = $file->getClientOriginalExtension();
      $year = explode(".", $filename)[0];
      $year_short = substr($year, -2); 

      $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);
      // This command helps getting a view on what we get from $sheet
      //$sheet->dd();
      $result = $sheet->toArray();

      dd($result);

      foreach ($result as $row){
        $customer = Customer::where('name','=',$row['pl_customer_name'])->get();
        //dd($customer[0]->id);
        $revenue = Revenue::firstOrNew(array(
          'customer_id' => $customer[0]->id,
          'product_code' => $row['product_nfps_code'],
          'year' => $year
          ));
        if (isset($row['jan'])) {$revenue->jan = $row['jan'];}
        if (isset($row['feb'])) {$revenue->jan = $row['feb'];}
        if (isset($row['mar'])) {$revenue->jan = $row['mar'];}
        if (isset($row['apr'])) {$revenue->jan = $row['apr'];}
        if (isset($row['may'])) {$revenue->jan = $row['may'];}
        if (isset($row['jun'])) {$revenue->jan = $row['jun'];}
        if (isset($row['jul'])) {$revenue->jan = $row['jul'];}
        if (isset($row['aug'])) {$revenue->jan = $row['aug'];}
        if (isset($row['sep'])) {$revenue->jan = $row['sep'];}
        if (isset($row['oct'])) {$revenue->jan = $row['oct'];}
        if (isset($row['nov'])) {$revenue->jan = $row['nov'];}
        if (isset($row['dec'])) {$revenue->jan = $row['dec'];}
        $revenue->save();
      }
    }
    return redirect('revenueupload')->with('success','File processed');
  }
}
