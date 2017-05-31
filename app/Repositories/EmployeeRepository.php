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
    
	public function getByName($name)
	{
		return $this->employee->where('name', $name)->first();
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}
    
    public function createIfNotFound(Array $inputs)
	{
        $employee = $this->employee->where('name', $inputs['name'])->first();
        
        if (isset($employee)){
            return $employee;
        }
        else{
            return $this->store($inputs);
        }
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	} 
    public function getDomainList()
	{
        return $this->employee->where('domain','<>','null')->select('domain AS text')->groupBy('domain')->get();
	}
    public function getManagerList()
	{
        return $this->employee->where('is_manager','=','1')->select('id','name AS text')->groupBy('name')->get();
	}
    public function getSubDomainList()
	{
        return $this->employee->where('subdomain','<>','null')->select('subdomain AS text')->groupBy('subdomain')->get();
	}
    public function getJobRoleList()
	{
        return $this->employee->where('job_role','<>','null')->select('job_role AS text')->groupBy('job_role')->get();
	}
}