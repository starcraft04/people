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
			'first_name' => 'required|max:255|unique:employees,first_name,' . $id,
			'manager_id' => 'max:10'
        ];
    }
}
