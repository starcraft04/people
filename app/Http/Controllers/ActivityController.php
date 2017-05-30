<?php 

namespace App\Http\Controllers;

use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\ActivityUpdateRequest;

use App\Repositories\ActivityRepository;
use App\Activity;
use App\Employee;
use App\Project;

use Illuminate\Http\Request;

class ActivityController extends Controller {

    protected $activityRepository;

    protected $nbrPerPage = 10;

    public function __construct(ActivityRepository $activityRepository)
    {
		$this->activityRepository = $activityRepository;
	}
	public function index()
	{
		$activity = $this->activityRepository->getPaginate($this->nbrPerPage);
		$links = $activity->setPath('')->render();
		return view('activity/index', compact('activity', 'links'));
	}

	public function create()
	{
        $employee_list = Employee::where('id', '!=','1')->lists('name','id');
        $project_list = Project::all()->lists('full_name','id');
		//\Debugbar::info($manager_list);
		return view('activity/create',  compact('employee_list','project_list'));
	}

	public function store(ActivityCreateRequest $request)
	{
		$activity = $this->activityRepository->store($request->all());
		return redirect('activity')->withOk("The activity has been created.");
	}

	public function show($id)
	{
		$activity = $this->activityRepository->getById($id);
		$project = Activity::find($activity->id)->project;
        $employee = Activity::find($activity->id)->employee;
        
        //\Debugbar::info($project_list);

		return view('activity/show',  compact('activity','project','employee'));
	}

	public function edit($id)
	{
		$activity = $this->activityRepository->getById($id);
        //\Debugbar::info($activity->is_manager);
		return view('activity/edit',  compact('activity'))->with('manager_list',$manager_list);
	}

	public function update(ActivityUpdateRequest $request, $id)
	{
		$this->activityRepository->update($id, $request->all());
		return redirect('activity')->withOk("The activity has been modified.");
	}

	public function destroy($id)
	{
		$this->activityRepository->destroy($id);
		return redirect()->back();
	}

}