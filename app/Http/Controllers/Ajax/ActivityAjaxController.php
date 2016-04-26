<?php 

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\ActivityRepository;
use Datatables;

class ActivityAjaxController extends Controller 
{
    protected $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
	}

	public function getActivityPerEmployee($employee_id,$month)
	{
        $return = $this->activityRepository->getActivityPerEmployee($employee_id,$month);
        $data = Datatables::of($return)->make(true);
		return $data;
	}
	public function getActivityPerProject($employee_id,$month)
	{
        $return = $this->activityRepository->getActivityPerProject($employee_id,$month);
        $data = Datatables::of($return)->make(true);
		return $data;
	}

}