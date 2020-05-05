<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerOtherName;

class CustomerOtherNameController extends Controller
{

  public function addNameAjax(Request $request)
	{
    $inputs = $request->all();
    $result = new \stdClass();

    $otherName = CustomerOtherName::where('other_name',$inputs['other_name'])->first();

    if (count($otherName) > 0) {
      $result->result = 'error';
      $result->msg = 'This name is already found in the DB';
    } else {
      $insert_result = CustomerOtherName::create($inputs);
      $result->result = 'success';
      $result->msg = 'Added in DB';
    }
    
    return json_encode($result);
  }

}
