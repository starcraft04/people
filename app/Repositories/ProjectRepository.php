<?php

namespace App\Repositories;

use App\Project;
use Datatables;
use DB;
use Entrust;
use Auth;

class ProjectRepository
{

  protected $project;

  public function __construct(Project $project)
	{
		$this->project = $project;
	}

  public function getById($id)
	{
		return $this->project->findOrFail($id);
	}

  public function createIfNotFound(Array $inputs)
  {
    $project = $this->project->where([
      ['customer_name', $inputs['customer_name']],
      ['otl_project_code', $inputs['otl_project_code']],
      ['meta_activity', $inputs['meta_activity']],
      ['task_name', $inputs['task_name']],
      ])->first();

    if (!isset($project)){
        $project = new $this->project;
        return $this->save($project, $inputs);
    }
    else {
      return $project;
    }
  }

  public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	private function save(Project $project, Array $inputs)
	{

    // Required fields
		$project->customer_name = $inputs['customer_name'];
    $project->project_name = $inputs['project_name'];
    $project->task_name = $inputs['task_name'];
    $project->meta_activity = $inputs['meta_activity'];
    $project->otl_project_code = $inputs['otl_project_code'];
    // Nullable
    if (isset($inputs['project_type'])) {$project->project_type = $inputs['project_type'];}
    if (isset($inputs['task_category'])) {$project->task_category = $inputs['task_category'];}
    if (isset($inputs['region'])) {$project->region = $inputs['region'];}
    if (isset($inputs['country'])) {$project->country = $inputs['country'];}
    if (isset($inputs['customer_location'])) {$project->customer_location = $inputs['customer_location'];}
    if (isset($inputs['domain'])) {$project->domain = $inputs['domain'];}
    if (isset($inputs['estimated_start_date'])) {$project->estimated_start_date = $inputs['estimated_start_date'];}
    if (isset($inputs['estimated_end_date'])) {$project->estimated_end_date = $inputs['estimated_end_date'];}
    if (isset($inputs['LoE_onshore'])) {$project->LoE_onshore = $inputs['LoE_onshore'];}
    if (isset($inputs['LoE_nearshore'])) {$project->LoE_nearshore = $inputs['LoE_nearshore'];}
    if (isset($inputs['LoE_offshore'])) {$project->LoE_offshore = $inputs['LoE_offshore'];}
    if (isset($inputs['LoE_contractor'])) {$project->LoE_contractor = $inputs['LoE_contractor'];}
    if (isset($inputs['gold_order_number'])) {$project->gold_order_number = $inputs['gold_order_number'];}
    if (isset($inputs['product_code'])) {$project->product_code = $inputs['product_code'];}
    if (isset($inputs['revenue'])) {$project->revenue = $inputs['revenue'];}
    if (isset($inputs['project_status'])) {$project->project_status = $inputs['project_status'];}
    if (isset($inputs['win_ratio'])) {$project->comments = $inputs['win_ratio'];}

    // Boolean
    if (isset($inputs['from_otl'])) {$project->from_otl = $inputs['from_otl'];}

    $project->save();

    return $project;
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
    return 'success';
	}

  public function getListOfProjects()
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/
    $projectList = DB::table('projects')
      ->select( 'projects.id', 'projects.name','projects.email','projects.is_manager', 'projects.region',
                'projects.country', 'projects.domain', 'projects.management_code', 'projects.job_role',
                'projects.employee_type','projects_projects.manager_id','u2.name AS manager_name')
      ->leftjoin('projects_projects', 'projects.id', '=', 'projects_projects.project_id')
      ->leftjoin('projects AS u2', 'u2.id', '=', 'projects_projects.manager_id');
    $data = Datatables::of($projectList)->make(true);
    return $data;
  }

  public function getMyManagersList($id)
	{
    $data = $this->project->findOrFail($id)->managers()->select('manager_id','name')->get();
    return $data;
	}

  public function getManagersList()
	{
    return $this->project->where('is_manager', '=','1')->lists('name','id');
	}
}
