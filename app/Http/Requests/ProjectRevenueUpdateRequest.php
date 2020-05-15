<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\ProjectRevenue;

class ProjectRevenueUpdateRequest extends FormRequest
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
        $id = $this->route('id');
        $revenue = ProjectRevenue::find($id);
        $project_id = $revenue->project_id;
        $year = $this->year;
        $product_code = $this->product_code;
        return [
            'project_id' => 'unique:project_revenues,project_id,'.$id.',id,year,'.$year.',product_code,'.$product_code,
            'year' => 'required|unique:project_revenues,year,'.$id.',id,project_id,'.$project_id.',product_code,'.$product_code,
            'product_code' => 'required|unique:project_revenues,product_code,'.$id.',id,year,'.$year.',project_id,'.$project_id,
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
