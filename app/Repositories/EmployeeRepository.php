<?php

namespace App\Repositories;

use App\Employee;
use Datatables;
use DB;

class EmployeeRepository
{

  protected $employee;

  public function __construct(Employee $employee)
	{
		$this->employee = $employee;
	}

  public function getById($id)
	{
		return $this->employee->findOrFail($id);
	}

  public function createIfNotFound(Array $inputs)
  {
    $employee = $this->employee->where('name', $inputs['name'])->first();

    if (!isset($employee)){
        $employee = new $this->employee;
        return $this->save($employee, $inputs);
    }
    else {
      return $employee;
    }
  }

  public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	private function save(Employee $employee, Array $inputs)
	{
		$employee->name = $inputs['name'];
		$employee->manager_id = $inputs['manager_id'];
    //nullable
    $employee->country = isset($inputs['country'])?$inputs['country']:null;
    $employee->region = isset($inputs['region'])?$inputs['region']:null;
    $employee->domain = isset($inputs['domain'])?$inputs['domain']:null;
    $employee->subdomain = isset($inputs['subdomain'])?$inputs['subdomain']:null;
    $employee->management_code = isset($inputs['management_code'])?$inputs['management_code']:null;
    $employee->job_role = isset($inputs['job_role'])?$inputs['job_role']:null;
    $employee->employee_type = isset($inputs['employee_type'])?$inputs['employee_type']:null;
    // Boolean
    $employee->is_manager = isset($inputs['is_manager']);
    $employee->from_otl = isset($inputs['from_otl']);
    $employee->from_step = isset($inputs['from_step']);
    $employee->save();
    return $employee;
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
    return 'success';
	}

  public function getListOfEmployees()
  {
    //the with('my_manager') will include for each record, an array with all the data from this manager (coming from manager_id) and this was defined in the model Employee.php
    $employeeList = DB::table('employee')
        ->select('employee.id', 'employee.name', 'employee.manager_id','manager.name AS manager_name','employee.is_manager', 'employee.region', 'employee.country', 'employee.domain', 'employee.subdomain', 'employee.management_code', 'employee.job_role', 'employee.employee_type')
        ->join('employee AS manager', 'employee.manager_id','=','manager.id')->where('employee.name','<>','MANAGER');
    $data = Datatables::of($employeeList)->make(true);
    return $data;
  }

  public function getManagersList()
	{
    return $this->employee->where('is_manager', '=','1')->lists('name','id');
	}

}
