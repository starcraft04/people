<?php 

namespace App\Http\Controllers;

use App\Http\Requests\StepUploadRequest;
use App\Repositories\EmployeeRepository;
use App\Repositories\SkillRepository;

class StepUploadController extends Controller 
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository,SkillRepository $skillRepository)
    {
		$this->employeeRepository = $employeeRepository;
        $this->skillRepository = $skillRepository;
	}

    public function getForm()
	{
		return view('stepupload');
	}

	public function postForm(StepUploadRequest $request)
	{
		$file = $request->file('uploadfile');

		if($file->isValid())
		{
			$chemin = config('upload.stepPath');

			$extension = $file->getClientOriginalExtension();

			$nom = $request->input('year').$request->input('half'). '.' . $extension;

			$file->move($chemin, $nom);

            $sheet = \Excel::selectSheetsByIndex(0)->load($chemin.'/'.$nom)->get();
            
            $results = [];
            
            foreach ($sheet as $row){

                $manager = [];
                $manager = $this->employeeRepository->getByName($row->supervisor_name);
                
                if (!isset($manager))
                {
                    $key = in_array($manager['name'], array_column($results, 'name'));
                    if ($key == false)
                    {
                        array_push($results,['name'=>$manager['name'],'status'=>'manager not in database']);
                    }
                    continue;
                }

                $employee = [];
                $employee['name'] = $row->last_name.','.$row->first_name;
                $employee['manager_id'] = $manager->id;
                $employee['from_otl'] = 0;
                $employee['country'] = $row->country_descr;
                $employee['region'] = $row->business_region;
                $employee['management_code'] = $row->management_code;
                //$employee['job_role'] = $row->job_role;
                $employee['from_step'] = 1;
                $employee = $this->employeeRepository->createOrUpdate($employee);

                $key = in_array($employee['name'], array_column($results, 'name'));
                if ($key == false)
                {
                    array_push($results,['name'=>$employee['name'],'status'=>'updated']);
                }  
                
                $skill = [];
                $skill['skill_type'] = $row->skill_type;
                $skill['skill_category_name'] = $row->skill_category_name;
                $skill['skill'] = $row->skill;
                $skill['rank'] = $row->rank;
                $skill['target_rank'] = $row->target_rank;
                $skill['employee_last_assessed'] = $row->employee_last_assessed_date;
                $skill['employee_id'] = $employee->id;
                $skill['from_step'] = 1;
                $skill = $this->skillRepository->createOrUpdate($skill);    
            };

            return redirect('stepupload/form')->with('ok','File uploaded !')->with('results',$results);
		}

		return redirect('stepupload/form')
			->with('error','Sorry, your file cannot be uploaded !');
	}

}