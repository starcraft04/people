<?php 

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\ActivityRepository;
use Illuminate\Http\Request;
use Datatables;

class ActivityAjaxController extends Controller 
{
    protected $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
	}
    
    public function postActivityPerEmployee(Request $request)
	{
        $input = $request->all();
        $return = $this->activityRepository->getActivityPerEmployee($input);
        $data = Datatables::of($return)->make(true);
		return $data;
	}
    public function postActivityPerProject(Request $request)
	{
        $input = $request->all();
        $return = $this->activityRepository->getActivityPerProject($input);
        $data = Datatables::of($return)->make(true);
		return $data;
	}
}
