<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRevenueCreateRequest extends FormRequest
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
        $year = $this->year;
        $product_code = $this->product_code;
        return [
            'project_id' => 'required|unique:project_revenues,project_id,NULL,id,year,'.$year.',product_code,'.$product_code,
            'year' => 'required|unique:project_revenues,year,NULL,id,project_id,'.$project_id.',product_code,'.$product_code,
            'product_code' => 'required|unique:project_revenues,product_code,NULL,id,year,'.$year.',project_id,'.$project_id,
            'jan' => 'required',
            'feb' => 'required',
            'mar' => 'required',
            'apr' => 'required',
            'may' => 'required',
            'jun' => 'required',
            'jul' => 'required',
            'aug' => 'required',
            'sep' => 'required',
            'oct' => 'required',
            'nov' => 'required',
            'dec' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'year.unique' => 'This record needs to have a unique project, year, product code.',
            'product_code.unique' => 'This record needs to have a unique project, year, product code.',
        ];
    }
}
