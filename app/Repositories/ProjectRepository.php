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

  public function getByOTL($otl_project_code,$meta_activity)
	{
		return $this->project->where('otl_project_code', $otl_project_code)->where('meta_activity', $meta_activity)->first();
	}
  public function getByOTLnum($otl_project_code,$meta_activity)
	{
		return $this->project->where('otl_project_code', $otl_project_code)->where('meta_activity', $meta_activity)->count();
	}
  public function create(Array $inputs)
  {
    $project = new $this->project;
    $inputs['created_by_user_id'] = Auth::user()->id;
    return $this->save($project, $inputs);
  }

  public function update($id, Array $inputs)
	{
		return $this->save($this->getById($id), $inputs);
	}

	private function save(Project $project, Array $inputs)
	{
    // Required fields
    if (isset($inputs['project_name'])) {$project->project_name = $inputs['project_name'];}
    if (isset($inputs['customer_id'])) {$project->customer_id = $inputs['customer_id'];}

    // OTL project code and meta activity can be empty and then it needs to be entered as null
    if (isset($inputs['meta_activity'])) {
      if (trim($inputs['meta_activity']) == '') {
        $project->meta_activity = null;
      } else {
        $project->meta_activity = $inputs['meta_activity'];
      }
    }

    if (isset($inputs['otl_project_code'])) {
      if (trim($inputs['otl_project_code']) == '') {
        $project->otl_project_code = null;
      } else {
        $project->otl_project_code = $inputs['otl_project_code'];
      }
    }

    // Nullable
    if (isset($inputs['project_type'])) {$project->project_type = $inputs['project_type'];}
    if (isset($inputs['activity_type'])) {$project->activity_type = $inputs['activity_type'];}
    if (isset($inputs['region'])) {$project->region = $inputs['region'];}
    if (isset($inputs['country'])) {$project->country = $inputs['country'];}
    if (isset($inputs['customer_location'])) {$project->customer_location = $inputs['customer_location'];}
    if (isset($inputs['comments'])) {$project->comments = $inputs['comments'];}
    if (isset($inputs['description'])) {$project->description = $inputs['description'];}
    if (isset($inputs['technology'])) {$project->technology = $inputs['technology'];}
    if (isset($inputs['estimated_start_date'])) {$project->estimated_start_date = $inputs['estimated_start_date'];}
    if (isset($inputs['estimated_end_date'])) {$project->estimated_end_date = $inputs['estimated_end_date'];}
    if (isset($inputs['LoE_onshore']) && $inputs['LoE_onshore'] != '') {$project->LoE_onshore = $inputs['LoE_onshore'];}
    if (isset($inputs['LoE_nearshore']) && $inputs['LoE_nearshore'] != '') {$project->LoE_nearshore = $inputs['LoE_nearshore'];}
    if (isset($inputs['LoE_offshore']) && $inputs['LoE_offshore'] != '') {$project->LoE_offshore = $inputs['LoE_offshore'];}
    if (isset($inputs['LoE_contractor']) && $inputs['LoE_contractor'] != '') {$project->LoE_contractor = $inputs['LoE_contractor'];}
    if (isset($inputs['gold_order_number'])) {$project->gold_order_number = $inputs['gold_order_number'];}
    if (isset($inputs['product_code'])) {$project->product_code = $inputs['product_code'];}
    if (isset($inputs['revenue']) && $inputs['revenue'] != '') {$project->revenue = $inputs['revenue'];}
    if (isset($inputs['project_status'])) {$project->project_status = $inputs['project_status'];}
    if (isset($inputs['win_ratio']) && $inputs['win_ratio'] != '') {$project->win_ratio = $inputs['win_ratio'];}
    if (isset($inputs['created_by_user_id'])) {$project->created_by_user_id = $inputs['created_by_user_id'];}

    // Boolean
    if (isset($inputs['otl_validated'])) {$project->otl_validated = $inputs['otl_validated'];}

    $project->save();

    return $project;
	}

	public function destroy($id)
	{
    $project = $this->getById($id);
    $project->delete();

    return $project;
	}

  public function getListOfProjects($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $projectList = $this->project
      ->select( 'projects.id','customers.name AS customer_name','project_name','otl_project_code','project_type','activity_type','project_status','meta_activity','region',
                'country','technology','description','estimated_start_date','estimated_end_date','comments','LoE_onshore','LoE_nearshore',
                'LoE_offshore','LoE_contractor','gold_order_number','product_code','revenue','win_ratio')
      ->leftjoin('customers','projects.customer_id','=','customers.id');

    if (isset($where['unassigned']) && $where['unassigned'] == 'true') {
      $projectList->doesntHave('activities');
      //$projectList->groupBy('projects.id');
    }
    elseif (isset($where['unassigned']) && $where['unassigned'] == 'false') {
      $projectList->has('activities');
    }
    $data = Datatables::of($projectList)->make(true);
    return $data;
  }

  public function getAllProjectsList()
  {
    return $this->project->lists('project_name','id');
  }

  public function getListOfProjectsMissingInfo($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $projectList = $this->project
      ->select( 'u2.name AS manager_name','users.id AS user_id','users.name','projects.id','customers.name AS customer_name','projects.project_name','projects.otl_project_code','projects.project_type',
                'projects.activity_type','projects.project_status','projects.meta_activity','projects.region',
                'projects.country','projects.technology','projects.description','projects.estimated_start_date','projects.estimated_end_date',
                'projects.comments','projects.LoE_onshore','projects.LoE_nearshore',
                'projects.LoE_offshore','projects.LoE_contractor','projects.gold_order_number','projects.product_code','projects.revenue','projects.win_ratio');
    $projectList->leftjoin('activities','project_id','=','projects.id');
    $projectList->leftjoin('users','user_id','=','users.id');
    $projectList->leftjoin('users_users', 'users.id', '=', 'users_users.user_id');
    $projectList->leftjoin('users AS u2', 'u2.id', '=', 'users_users.manager_id');
    $projectList->leftjoin('customers','projects.customer_id','=','customers.id');
    $projectList->whereRaw("(project_type = '' or activity_type = '' or project_status = '')");
    $projectList->groupBy('users.name','projects.id');


    $data = Datatables::of($projectList)->make(true);
    return $data;
  }

  public function getListOfProjectsMissingOTL($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $projectList = $this->project
      ->select( 'u2.name AS manager_name','users.id AS user_id','users.name','projects.id','customers.name AS customer_name','projects.project_name','projects.otl_project_code','projects.project_type',
                'projects.activity_type','projects.project_status','projects.meta_activity','projects.region',
                'projects.country','projects.technology','projects.description','projects.estimated_start_date','projects.estimated_end_date',
                'projects.comments','projects.LoE_onshore','projects.LoE_nearshore',
                'projects.LoE_offshore','projects.LoE_contractor','projects.gold_order_number','projects.product_code','projects.revenue','projects.win_ratio');
    $projectList->leftjoin('activities','project_id','=','projects.id');
    $projectList->leftjoin('users','user_id','=','users.id');
    $projectList->leftjoin('users_users', 'users.id', '=', 'users_users.user_id');
    $projectList->leftjoin('users AS u2', 'u2.id', '=', 'users_users.manager_id');
    $projectList->leftjoin('customers','projects.customer_id','=','customers.id');
    $projectList->whereRaw("(otl_project_code = '' or meta_activity = '' or otl_project_code IS NULL or meta_activity IS NULL)");
    $projectList->groupBy('users.name','projects.id');


    $data = Datatables::of($projectList)->make(true);
    return $data;
  }

  public function getListOfProjectsLost($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $projectList = $this->project
      ->select( 'u2.name AS manager_name','users.id AS user_id','users.name','projects.id','customers.name AS customer_name','projects.project_name','projects.otl_project_code','projects.project_type',
                'projects.activity_type','projects.project_status','projects.meta_activity','projects.region',
                'projects.country','projects.technology','projects.description','projects.estimated_start_date','projects.estimated_end_date',
                'projects.comments','projects.LoE_onshore','projects.LoE_nearshore',
                'projects.LoE_offshore','projects.LoE_contractor','projects.gold_order_number','projects.product_code','projects.revenue','projects.win_ratio');
    $projectList->leftjoin('activities','project_id','=','projects.id');
    $projectList->leftjoin('users','user_id','=','users.id');
    $projectList->leftjoin('users_users', 'users.id', '=', 'users_users.user_id');
    $projectList->leftjoin('users AS u2', 'u2.id', '=', 'users_users.manager_id');
    $projectList->leftjoin('customers','projects.customer_id','=','customers.id');
    $projectList->whereRaw("(win_ratio = 0)");
    $projectList->groupBy('users.name','projects.id');


    $data = Datatables::of($projectList)->make(true);
    return $data;
  }

  public function getListOfProjectsAll($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $projectList = $this->project
      ->select( 'u2.name AS manager_name','users.name','projects.id','customers.name AS customer_name','projects.project_name','projects.otl_project_code','projects.project_type',
                'projects.activity_type','projects.project_status','projects.meta_activity','projects.region',
                'projects.country','projects.technology','projects.description','projects.estimated_start_date','projects.estimated_end_date',
                'projects.comments','projects.LoE_onshore','projects.LoE_nearshore',
                'projects.LoE_offshore','projects.LoE_contractor','projects.gold_order_number','projects.product_code','projects.revenue','projects.win_ratio');
    $projectList->leftjoin('activities','project_id','=','projects.id');
    $projectList->leftjoin('users','user_id','=','users.id');
    $projectList->leftjoin('users_users', 'users.id', '=', 'users_users.user_id');
    $projectList->leftjoin('users AS u2', 'u2.id', '=', 'users_users.manager_id');
    $projectList->leftjoin('customers','projects.customer_id','=','customers.id');
    $projectList->groupBy('users.name','projects.id');

    $data = Datatables::of($projectList)->make(true);
    return $data;
  }

}
