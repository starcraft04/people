<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ProjectCreateRequest extends FormRequest
{
    /**
     * Determine if the project is authorized to make this request.
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
        $customer_id = $this->customer_id;
        $meta_activity = $this->meta_activity;

        return [

          'project_name' => 'required|max:255|unique:projects,project_name,NULL,id,customer_id,'.$customer_id,
          'customer_id' => 'required|max:255',
          'project_practice' =>'required|max:255',
          'project_type' =>'required|max:255',
          'project_status' =>'required|max:255',
          'project_status' =>'required|max:255',
          'otl_project_code' => 'nullable|max:255',
          'comments' => 'nullable|max:255',
          'meta_activity' => 'max:255',
          'LoE_onshore' => 'nullable|numeric',
          'LoE_nearshore' => 'nullable|numeric',
          'LoE_offshore' => 'nullable|numeric',
          'LoE_contractor' => 'nullable|numeric',
          'revenue' => 'nullable|numeric',
          'win_ratio' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
          'otl_project_code.unique' => 'This OTL project code and meta-activity already exists in the database.',
          'project_name.unique' => 'This project name and customer name already exists in the database.',
        ];
    }
}
