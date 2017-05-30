<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectUpdateRequest extends Request
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
			'customer_name' => 'required|max:255',
            'project_name' => 'required|max:255',
            'task_name' => 'required|max:255'
        ];
    }
}
