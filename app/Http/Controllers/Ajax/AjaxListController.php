<?php 

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Datatables;

class AjaxListController extends Controller 
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository,ActivityRepository $activityRepository,ProjectRepository $projectRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->activityRepository = $activityRepository;
        $this->projectRepository = $projectRepository;
	}
    public function getAjaxListDomain()
	{
		return $this->employeeRepository->getDomainList();
	}
    public function getAjaxListManager()
	{
		return $this->employeeRepository->getManagerList();
	}
    public function getAjaxListSubDomain()
	{
		return $this->employeeRepository->getSubDomainList();
	}
    public function getAjaxListJobRole()
	{
		return $this->employeeRepository->getJobRoleList();
	}
    public function getAjaxListMetaActivity()
	{
		return $this->projectRepository->getMetaActivityList();
	}
    public function getAjaxListEmployee()
	{
        $employee = \DB::table('employee AS E')->select('E.id','E.name','E.manager_id','M.name AS manager_name','E.is_manager','E.region','E.country','E.domain','E.subdomain','E.management_code','E.job_role','E.employee_type')->join('employee AS M', 'E.manager_id', '=', 'M.id');
        $data = Datatables::of($employee)->make(true);
		return $data;
	}
}
