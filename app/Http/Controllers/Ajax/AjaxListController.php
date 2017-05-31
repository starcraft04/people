<?php 

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Datatables;
use DB;

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
        $employee = DB::table('employee')
            ->select('employee.id', 'employee.name', 'employee.manager_id','manager.name AS manager_name','employee.is_manager', 'employee.region', 'employee.country', 'employee.domain', 'employee.subdomain', 'employee.management_code', 'employee.job_role', 'employee.employee_type')
            ->join('employee AS manager', 'employee.manager_id','=','manager.id')->where('employee.name','<>','MANAGER');
        $data = Datatables::of($employee)->make(true);
		return $data;
	}
}
