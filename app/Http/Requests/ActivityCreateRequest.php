<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActivityCreateRequest extends Request
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
        $project_id = $this->project_id;
        $meta_activity = $this->meta_activity;
        $year = $this->year;
        $month = $this->month;
        $employee_id = $this->employee_id;
		return [
            'year' => 'required|max:4',
            'month' => 'required|max:255',
            'project_id' => 'required|max:255',
            'task_hour' => 'required|max:255',
			'employee_id' => 'required|max:255',
            'meta_activity' => 'required|max:255|unique:activity,meta_activity,NULL,id,project_id,'.$project_id.',year,'.$year.',month,'.$month.',employee_id,'.$employee_id
		];
    }
}
