<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SambaProjectCreateRequest extends FormRequest
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

        return [

          'project_name' => 'required|max:255|unique:projects,project_name,NULL,id,customer_id,'.$customer_id,
          'customer_id' => 'required|max:255',
          'user_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
          'project_name.unique' => 'This project name and customer name already exists in the database.',
        ];
    }
}
