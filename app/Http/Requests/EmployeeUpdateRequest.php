<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmployeeUpdateRequest extends Request
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
		$id = $this->id;
		
        return [
			'employee_name' => 'required|max:255|unique:employees,employee_name,' . $id,
			'manager_id' => 'required|max:10'
        ];
    }
}
