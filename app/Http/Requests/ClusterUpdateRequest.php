<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClusterUpdateRequest extends Request
{
  /**
  * Determine if the activity is authorized to make this request.
  *
  * @return bool
  */
  public function authorize()
  {
    return true;
  }

  /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
  public function rules()
  {

    $id = $this->route('id');
    dd($id);

    return [
      'name' => 'required|max:255|unique:clusters,name,' . $id . ',id',
      'countries' => 'required'
    ];
  }
}
