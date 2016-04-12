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
        $employee = new Employee;
		return $employee->employeeTablePaginate($n);
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
    
	public function getAllManagersList()
	{
        $employee = new Employee;
        $managers = $employee->getAllManagers();
		$result = Array();
		foreach ($managers as $manager)
		{
			$result[$manager->id] = $manager->name;
		}
        return $result;
	}
}