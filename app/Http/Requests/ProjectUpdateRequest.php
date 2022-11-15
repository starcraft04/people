<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
        $id = $this->id;
        $meta_activity = $this->meta_activity;
        $customer_id = $this->customer_id;

        /*
            *          Forcing A Unique Rule To Ignore A Given ID:
            *
            *          Sometimes, you may wish to ignore a given ID during the unique check. For example, consider an "update profile" screen that includes the project's name, e-mail address, and location. Of course, you will want to verify that the e-mail address is unique. However, if the project only changes the name field and not the e-mail field, you do not want a validation error to be thrown because the project is already the owner of the e-mail address. You only want to throw a validation error if the project provides an e-mail address that is already used by a different project. To tell the unique rule to ignore the project's ID, you may pass the ID as the third parameter:
            *
            *          'email' => 'unique:projects,email_address,'.$project->id
            *
            *          If your table uses a primary key column name other than id, you may specify it as the fourth parameter:
            *
            *          'email' => 'unique:projects,email_address,'.$project->id.',project_id'
            **/

        return [

      'project_name' => 'required|max:255|unique:projects,project_name,'.$id.',id,customer_id,'.$customer_id,
      'customer_id' => 'required|max:255',
      'otl_project_code' => 'nullable|max:255',
      'comments' => 'nullable|max:255',
      'meta_activity' => 'nullable|max:255',
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
