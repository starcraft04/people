<?php 

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

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
}
