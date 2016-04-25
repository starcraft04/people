<?php 

namespace App\Http\Controllers;

use App\Http\Requests\OtlUploadRequest;
use App\Repositories\EmployeeRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ActivityRepository;

class OtlUploadController extends Controller 
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository, ProjectRepository $projectRepository, ActivityRepository $activityRepository)
    {
		$this->employeeRepository = $employeeRepository;
        $this->projectRepository = $projectRepository;
        $this->activityRepository = $activityRepository;
	}

    public function getForm()
	{
		return view('otlupload');
	}

	public function postForm(OtlUploadRequest $request)
	{
		$file = $request->file('uploadfile');

		if($file->isValid())
		{
			$chemin = config('upload.otlPath');

			$extension = $file->getClientOriginalExtension();

			$nom = $request->input('year').$request->input('month'). '.' . $extension;

			$file->move($chemin, $nom);
            
            $sheet = \Excel::selectSheetsByIndex(0)->load($chemin.'/'.$nom)->get();
            
            foreach ($sheet as $row){

                    $manager = [];
                    $manager['name'] = $row->manager_name;
                    $manager['is_manager'] = true;
                    $manager['manager_id'] = 1;
                    $manager['from_otl'] = 1;
                    $manager = $this->employeeRepository->createIfNotFound($manager);

                    $employee = [];
                    $employee['name'] = $row->employee_name;
                    $employee['manager_id'] = $manager->id;
                    $employee['from_otl'] = 1;
                    $employee = $this->employeeRepository->createIfNotFound($employee);
                    
                    $project = [];
                    $project['customer_name'] = $row->customer_name;
                    $project['project_name'] = $row->project_name;
                    $project['task_name'] = $row->task_name;
                    $project['meta_activity'] = $row->meta_activity;
                    $project['project_type'] = $row->project_type;
                    $project['task_category'] = $row->task_category;
                    $project['from_otl'] = 1;
                    $project = $this->projectRepository->createIfNotFound($project);
                    
                    $activity = [];
                    $activity['year'] = $request->input('year');
                    $activity['month'] = $request->input('month');
                    $activity['project_id'] = $project->id;
                    $activity['employee_id'] = $employee->id;
                    $activity['task_hour'] = $row->original_time;
                    $activity['from_otl'] = 1;
                    $activity = $this->activityRepository->createOrUpdate($activity);

            };

            return redirect('otlupload/form')->withOk('File uploaded !');
		}

		return redirect('otlupload/form')
			->with('error','Sorry, your file cannot be uploaded !');
	}

}