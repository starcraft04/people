<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActivityUpdateRequest extends Request
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
        return [
			'meta_activity' => 'required|max:255',
            'year' => 'required|max:4',
            'month' => 'required|max:255',
            'project_id' => 'required|max:255',
            'task_hour' => 'required|max:255',
			'employee_id' => 'required|max:255'
        ];
    }
}
