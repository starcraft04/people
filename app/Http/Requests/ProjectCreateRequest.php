<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
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
        $customer_name = $this->customer_name;
        $project_name = $this->project_name;
		return [
			'customer_name' => 'required|max:255',
            'project_name' => 'required|max:255',
            'task_name' => 'required|max:255|unique:projects,task_name,NULL,id,customer_name,'.$customer_name.',project_name,'.$project_name
		];
    }
}
