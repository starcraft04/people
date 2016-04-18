<?php

namespace App\Repositories;

use App\Employee;

class EmployeeRepository
{

    protected $employee;

    public function __construct(Employee $employee)
	{
		$this->employee = $employee;
	}

	private function save(Employee $employee, Array $inputs)
	{
		$employee->name = $inputs['name'];
		$employee->manager_id = $inputs['manager_id'];
        $employee->is_manager = isset($inputs['is_manager']);
		$employee->save();
	}

	public function getPaginate($n)
	{
        $employee_list = $this->employee->with('manager')->where('name', '!=', 'MANAGER');
        return $employee_list->paginate($n);
	}
	public function getManagersList()
	{
        $manager_list = $this->employee->where('is_manager', '=','1')->lists('name','id');
        return $manager_list;
	}
    
	public function store(Array $inputs)
	{
		$employee = new $this->employee;		

		$this->save($employee, $inputs);

		return $employee;
	}

	public function getById($id)
	{
		return $this->employee->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	} 
}