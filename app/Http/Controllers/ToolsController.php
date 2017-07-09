<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Customers;
use App\Http\Controllers\Controller;
use DB;
use Entrust;
use Auth;
use Session;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ActivityRepository;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;

class ToolsController extends Controller {

  protected $activityRepository;
  protected $userRepository;
  protected $projectRepository;

  public function __construct(ActivityRepository $activityRepository,UserRepository $userRepository,ProjectRepository $projectRepository)
  {
    $this->activityRepository = $activityRepository;
    $this->userRepository = $userRepository;
    $this->projectRepository = $projectRepository;
	}

	public function activities()
	{
    $today = date("Y");
    $years = [];
    $manager_selected = '';
    $user_selected = '';

    $options = array(
        'validate_all' => true,
        'return_type' => 'both'
    );
    list($validate, $allValidations) = Entrust::ability(null,array('activities-view','activities-edit','activities-delete','activities-create'),$options);
    $perms = json_encode($allValidations['permissions']);


    foreach(config('select.year')  as $key => $value){
      if ($value == date("Y")) {$selected = 'selected';} else {$selected = '';}
      array_push($years,['id'=>$value,'value'=>$value,'selected'=>$selected]);
    }

    if (Entrust::can('tools-activity-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      $manager_list = $this->userRepository->getManagersList();
      $user_list = $this->userRepository->getAllUsersListNoManagers();
      $manager_select_disabled = 'false';
      $user_select_disabled = 'false';
    }
    elseif (Auth::user()->is_manager == 1) {
      $manager_list = [Auth::user()->id => Auth::user()->name];
      $user_list = Auth::user()->employees()->lists('name','user_id');
      $manager_selected = Auth::user()->id;
      $manager_select_disabled = 'true';
      $user_select_disabled = 'false';
    }
    else {
      $my_manager = Auth::user()->managers()->first();
      if ($my_manager) {
        $manager_list = [$my_manager->id => $my_manager->name];
        $manager_selected = $my_manager->id;
      } else {
        $manager_list = [0 => 'none'];
      }
      $user_list = [Auth::user()->id => Auth::user()->name];
      $user_selected = Auth::user()->id;
      $manager_select_disabled = 'true';
      $user_select_disabled = 'true';
    }

    Session::put('url','toolsActivities');
		return view('tools/list', compact('manager_list','today','years','manager_select_disabled','manager_selected','user_select_disabled','user_selected','user_list','perms'));
	}

  public function projectsAssignedAndNot()
  {
    $year = date("Y");
    $manager_list = [];
    if (Entrust::can('tools-activity-all-edit')){
      $user_id_for_update = '0';
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_id_for_update = '0';
    }
    else {
      $user_id_for_update = Auth::user()->id;
    }
    Session::put('url','toolsProjectsAssignedAndNot');
    //dd(Session::get('url'));
    return view('tools/projects_assigned_and_not', compact('manager_list','year','user_id_for_update'));
  }

  public function projectsMissingInfo()
  {
    $year = date("Y");
    $manager_list = [];
    if (Entrust::can('tools-activity-all-edit')){
      $user_id_for_update = '0';
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_id_for_update = '0';
    }
    else {
      $user_id_for_update = '0';
    }
    Session::put('url','toolsProjectsMissingInfo');
    return view('tools/projects_missing_info', compact('manager_list','year','user_id_for_update'));
  }

  public function projectsMissingOTL()
  {
    $year = date("Y");
    $manager_list = [];
    if (Entrust::can('tools-activity-all-edit')){
      $user_id_for_update = '0';
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_id_for_update = '0';
    }
    else {
      $user_id_for_update = '0';
    }
    Session::put('url','toolsProjectsMissingOTL');
    return view('tools/projects_missing_otl', compact('manager_list','year','user_id_for_update'));
  }

  public function projectsAll()
  {
    $year = date("Y");
    $manager_list = [];
    if (Entrust::can('tools-activity-all-edit')){
      $user_id_for_update = '0';
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_id_for_update = '0';
    }
    else {
      $user_id_for_update = Auth::user()->id;
    }
    Session::put('url','toolsProjectsAll');
    return view('tools/projects_all', compact('manager_list','year','user_id_for_update'));
  }

  public function projectsLost()
  {
    $year = date("Y");
    $manager_list = [];
    if (Entrust::can('tools-activity-all-edit')){
      $user_id_for_update = '0';
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_id_for_update = '0';
    }
    else {
      $user_id_for_update = '0';
    }
    Session::put('url','toolsProjectsLost');
    return view('tools/projects_lost', compact('manager_list','year','user_id_for_update'));
  }

	public function getFormCreate($year)
	{
    $edit_project_name = '';
    $edit_otl_name = '';
    $user_selected = '';
    $meta_activity_select_disabled = 'false';
    $project_type_select_disabled = 'false';
    $activity_type_select_disabled = 'false';
    $project_status_select_disabled = 'false';
    $region_select_disabled = 'false';
    $country_select_disabled = 'false';

    $created_by_user_id = Auth::user()->id;

    if (Entrust::can('tools-activity-all-view')){
      $user_list = $this->userRepository->getAllUsersListNoManagers();
      $user_select_disabled = 'false';
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_list = Auth::user()->employees()->lists('name','user_id');
      $user_select_disabled = 'false';
    }
    else {
      $user_list = [Auth::user()->id => Auth::user()->name];
      $user_selected = Auth::user()->id;
      $user_select_disabled = 'true';
    }

    $customers_list = Customers::orderBy('customer_name')->lists('customer_name','customer_name');
    $customers_list->prepend('', '');
    //dd($customers_list);

		return view('tools/create_update', compact('year','edit_project_name','edit_otl_name','customers_list',
      'user_list','user_selected','user_select_disabled','created_by_user_id',
      'meta_activity_select_disabled','project_type_select_disabled','activity_type_select_disabled','project_status_select_disabled',
      'region_select_disabled','country_select_disabled'))
      ->with('action','create');
	}

  public function postFormCreate(ProjectCreateRequest $request)
	{
    $inputs = $request->all();

    //dd($inputs);
    $start_end_date = explode(' - ',$inputs['estimated_date']);
    $inputs['estimated_start_date'] = trim($start_end_date[0]);
    $inputs['estimated_end_date'] = trim($start_end_date[1]);

    $project = $this->projectRepository->create($inputs);

    // Here I will test if a user has been selected or not
    if (!empty($inputs['user_id'])) {
      foreach ($inputs['month'] as $key => $value){
        $inputsActivities = [
          'year' => $inputs['year'],
          'month' => $key,
          'project_id' => $project->id,
          'user_id' => $inputs['user_id'],
          'task_hour' => $value,
          'from_otl' => 0
        ];
        $activity = $this->activityRepository->create($inputsActivities);
      }
    }

    if (!empty(Session::get('url'))){
      $redirect = Session::get('url');
    } else {
      $redirect = 'toolsActivities';
    }

    return redirect($redirect)->with('success','New project created successfully');
	}

  public function getFormUpdate($user_id,$project_id,$year)
	{
    // Here we setup all the disabled fields to be disabled
    $project_name_disabled = 'disabled';
    $customer_name_select_disabled = 'true';
    $otl_name_disabled = 'disabled';
    $meta_activity_select_disabled = 'true';
    $project_type_select_disabled = 'true';
    $activity_type_select_disabled = 'true';
    $project_status_select_disabled = 'true';
    $region_select_disabled = 'true';
    $country_select_disabled = 'true';
    $user_select_disabled = 'true';
    $customer_location_disabled = 'disabled';
    $technology_disabled = 'disabled';
    $description_disabled = 'disabled';
    $comments_disabled = 'disabled';
    $estimated_date_disabled = 'disabled';
    $LoE_onshore_disabled = 'disabled';
    $LoE_nearshore_disabled = 'disabled';
    $LoE_offshore_disabled = 'disabled';
    $LoE_contractor_disabled = 'disabled';
    $gold_order_disabled = 'disabled';
    $product_code_disabled = 'disabled';
    $revenue_disabled = 'disabled';
    $win_ratio_disabled = 'disabled';
    $show_change_button = false;

    // Here we find the information about the project
    $project = $this->projectRepository->getById($project_id);

    if (Entrust::can('tools-all_projects-edit') || (isset($project->created_by_user_id) && (Auth::user()->id == $project->created_by_user_id))) {
      $project_name_disabled = '';
      $customer_name_select_disabled = 'false';
      $otl_name_disabled = '';
      $meta_activity_select_disabled = 'false';
      $project_type_select_disabled = 'false';
      $activity_type_select_disabled = 'false';
      $project_status_select_disabled = 'false';
      $region_select_disabled = 'false';
      $country_select_disabled = 'false';
      $user_select_disabled = 'false';
      $customer_location_disabled = '';
      $technology_disabled = '';
      $description_disabled = '';
      $comments_disabled = '';
      $estimated_date_disabled = '';
      $LoE_onshore_disabled = '';
      $LoE_nearshore_disabled = '';
      $LoE_offshore_disabled = '';
      $LoE_contractor_disabled = '';
      $gold_order_disabled = '';
      $product_code_disabled = '';
      $revenue_disabled = '';
      $win_ratio_disabled = '';
    }

    if ($project->otl_validated == 1) {
      $otl_name_disabled = 'disabled';
      $meta_activity_select_disabled = 'true';
    }

    $user_list = [];

    $customers_list = Customers::orderBy('customer_name')->lists('customer_name','customer_name');
    $customers_list->prepend('', '');

    // Here we will define if we can select a user for this project and activity or not
    // Attention, we need to prevent in the user_list to have ids when already assigned to a project
    if (Entrust::can('tools-activity-all-edit')){
      $user_list_temp = $this->userRepository->getAllUsersListNoManagers();

      if ($user_id == '0') {
        foreach ($user_list_temp as $key => $value){
          if ($this->activityRepository->user_assigned_on_project($year,$key,$project_id) == 0){
            $user_list[$key] = $value;
          }
        }
        $user_select_disabled = 'false';
        $user_selected = '';
      } else {
        $user_list = $user_list_temp;
        $user_select_disabled = 'true';
        $user_selected = $user_id;
      }
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_list_temp = Auth::user()->employees()->lists('name','user_id');

      if ($user_id == '0') {
        foreach ($user_list_temp as $key => $value){
          if ($this->activityRepository->user_assigned_on_project($year,$key,$project_id) == 0){
            $user_list[$key] = $value;
          }
        }
        $user_select_disabled = 'false';
        $user_selected = '';
      } else {
        $user_list = $user_list_temp;
        $user_select_disabled = 'true';
        $user_selected = $user_id;
      }
    }
    else {
      $user_list = [Auth::user()->id => Auth::user()->name];
      if ($user_id == '0') {
        $user_select_disabled = 'true';
        $user_selected = '';
      } else {
        $user_select_disabled = 'true';
        $user_selected = $user_id;
      }
    }

    $created_by_user_name = isset($project->created_by_user_id) ? $this->userRepository->getById($project->created_by_user_id)->name : 'Admin';

    $activities = [];
    $from_otl = [];

    if ($user_id != '0') {
      $user = $this->userRepository->getById($user_id);
      $activity_forecast = $this->activityRepository->getByOTL($year,$user->id,$project->id, 0);
      $activity_OTL = $this->activityRepository->getByOTL($year,$user->id,$project->id, 1);
    }

    for ($i = 1; $i <= 12; $i++) {
      if (isset($activity_OTL[$i])){
        $activities[$i] = $activity_OTL[$i];
        $from_otl[$i] = 'disabled';
      } elseif (isset($activity_forecast[$i])){
        $activities[$i] = $activity_forecast[$i];
        $from_otl[$i] = '';
      } else {
        $activities[$i] = '0';
        $from_otl[$i] = '';
      }
    }

    for ($i = 1; $i <= 12; $i++) {
      if (isset($activity_OTL[$i])){
        $otl[$i] = $activity_OTL[$i];
      } else {
        $otl[$i] = 0;
      }
      if (isset($activity_forecast[$i])){
        $forecast[$i] = $activity_forecast[$i];
      } else {
        $forecast[$i] = 0;
      }
    }

    $loe_list = $this->activityRepository->getListOfActivitiesPerUserForProject(['project_id'=>$project_id]);
    //dd($loe_list);

    //here is the check to see if we need the change user button
    $has_otl_activities = $this->activityRepository->getNumberOfOTLPerUserAndProject($user_id,$project_id);
    if (Entrust::can('tools-user_assigned-change') && $user_id != 0 && $has_otl_activities == 0){
      $show_change_button = true;
    }

		return view('tools/create_update', compact('user_id','project','year','activities','from_otl','forecast','otl','loe_list','show_change_button','customers_list',
    'project_name_disabled',
    'customer_name_select_disabled',
    'otl_name_disabled',
    'meta_activity_select_disabled',
    'project_type_select_disabled',
    'activity_type_select_disabled',
    'project_status_select_disabled',
    'region_select_disabled',
    'country_select_disabled',
    'user_select_disabled',
    'customer_location_disabled',
    'technology_disabled',
    'description_disabled',
    'comments_disabled',
    'estimated_date_disabled',
    'LoE_onshore_disabled',
    'LoE_nearshore_disabled',
    'LoE_offshore_disabled',
    'LoE_contractor_disabled',
    'gold_order_disabled',
    'product_code_disabled',
    'revenue_disabled',
    'win_ratio_disabled',
    'show_change_button',
      'user_list','user_selected','user_select_disabled','created_by_user_name'))
      ->with('action','update');
	}

	public function postFormUpdate(ProjectUpdateRequest $request)
	{
    if (!empty(Session::get('url'))){
      $redirect = Session::get('url');
    } else {
      $redirect = 'toolsActivities';
    }

    $inputs = $request->all();
    //dd($inputs);

    // Now we need to check if the user has been flagged for remove from project
    if ($inputs['action'] == 'Remove') {
      $activity = $this->activityRepository->removeUserFromProject($inputs['user_id'],$inputs['project_id']);
      return redirect($redirect)->with('success','User removed from project successfully');
    }

    $start_end_date = explode(' - ',$inputs['estimated_date']);
    $inputs['estimated_start_date'] = trim($start_end_date[0]);
    $inputs['estimated_end_date'] = trim($start_end_date[1]);

    $project = $this->projectRepository->update($inputs['project_id'],$inputs);

    // if user_id_url = 0 then it is only project update and we don't need to add or update tasks
    if ($inputs['user_id_url'] != 0 && Entrust::can('tools-user_assigned-remove')) {
      // Let's check first if we changed the user
      if ($inputs['user_id_url'] != $inputs['user_id']){
        // Let's check if the user we changed to has already some activities on this project
        $has_activities = $this->activityRepository->getNumberPerUserAndProject($inputs['user_id'],$inputs['project_id']);
        if ($inputs['user_id'] == ''){
          return redirect($redirect)->with('error','You must select at least a new user');
        } elseif ($has_activities > 0) {
          return redirect($redirect)->with('error','The user you have selected already has activities for this project');
        } else {
          foreach ($inputs['month'] as $key => $value){
            $inputs_new = $inputs;
            $inputs_new['month'] = $key;
            $inputs_new['task_hour'] = $value;
            $inputs_new['from_otl'] = 0;
            $activity = $this->activityRepository->assignNewUser($inputs_new['user_id_url'],$inputs_new);
          }
          return redirect($redirect)->with('success','New user assigned successfully');
        }
      }
    }

    if (!empty($inputs['user_id'])){
      foreach ($inputs['month'] as $key => $value){
        $inputs_new = $inputs;
        $inputs_new['month'] = $key;
        $inputs_new['task_hour'] = $value;
        $inputs_new['from_otl'] = 0;
        $activity = $this->activityRepository->createOrUpdate($inputs_new);
      }
    }

    return redirect($redirect)->with('success','Project updated successfully');
	}
}
