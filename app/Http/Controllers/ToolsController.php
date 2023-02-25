<?php

namespace App\Http\Controllers;

use App\Action;
use App\Activity;
use App\Comment;
use App\Customer;
use App\Project;
use App\Http\Controllers\Auth\AuthUsersForDataView;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\ProjectRevenue;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Skill;
use App\User;
use App\UserSkill;
use Auth;
use Datatables;
use DB;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;

class ToolsController extends Controller
{
    protected $activityRepository;
    protected $userRepository;
    protected $projectRepository;

    public function __construct(ActivityRepository $activityRepository, UserRepository $userRepository, ProjectRepository $projectRepository)
    {
        $this->activityRepository = $activityRepository;
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
    }

    public function activities(AuthUsersForDataView $authUsersForDataView)
    {
        $authUsersForDataView->userCanView('tools-activity-all-view');
        Session::put('url', 'toolsActivities');
        $table_height = Auth::user()->table_height;

        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        $customerlink_id = $this->projectRepository->getAllSambaIDs();

        $customers_list->prepend('', '');

        return view('tools/list', compact('authUsersForDataView', 'table_height','customers_list','customerlink_id'));
    }

//get customer link id

    public function projectsAssignedAndNot()
    {
        $year = date('Y');
        $manager_list = [];
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_id_for_update = '0';
        } elseif (Auth::user()->is_manager == 1) {
            $user_id_for_update = '0';
        } else {
            $user_id_for_update = Auth::user()->id;
        }
        Session::put('url', 'toolsProjectsAssignedAndNot');
        //dd(Session::get('url'));
        return view('tools/projects_assigned_and_not', compact('manager_list', 'year', 'user_id_for_update'));
    }

    public function projectsMissingInfo()
    {
        $year = date('Y');
        $manager_list = [];
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_id_for_update = '0';
        } elseif (Auth::user()->is_manager == 1) {
            $user_id_for_update = '0';
        } else {
            $user_id_for_update = '0';
        }
        Session::put('url', 'toolsProjectsMissingInfo');

        return view('tools/projects_missing_info', compact('manager_list', 'year', 'user_id_for_update'));
    }

    public function projectsMissingOTL()
    {
        $year = date('Y');
        $manager_list = [];
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_id_for_update = '0';
        } elseif (Auth::user()->is_manager == 1) {
            $user_id_for_update = '0';
        } else {
            $user_id_for_update = '0';
        }
        Session::put('url', 'toolsProjectsMissingOTL');

        return view('tools/projects_missing_otl', compact('manager_list', 'year', 'user_id_for_update'));
    }

    public function projectsAll()
    {
        $year = date('Y');
        $manager_list = [];
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_id_for_update = '0';
        } elseif (Auth::user()->is_manager == 1) {
            $user_id_for_update = '0';
        } else {
            $user_id_for_update = Auth::user()->id;
        }
        Session::put('url', 'toolsProjectsAll');

        return view('tools/projects_all', compact('manager_list', 'year', 'user_id_for_update'));
    }

    public function projectsLost()
    {
        $year = date('Y');
        $manager_list = [];
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_id_for_update = '0';
        } elseif (Auth::user()->is_manager == 1) {
            $user_id_for_update = '0';
        } else {
            $user_id_for_update = '0';
        }
        Session::put('url', 'toolsProjectsLost');

        return view('tools/projects_lost', compact('manager_list', 'year', 'user_id_for_update'));
    }


    // create function to get the customer ic01 
    // post function with the id of the customer to retun empty array or list.
    public function getCustomerIc01(Request $request)
    {
        $inputs= $request->all();

        $customer_id = $inputs['customer_id'];

        $customer_ic01_info = DB::table('customerIC01')->where('customer_id',$customer_id)->select('id','ic01_name','ic01_code')->get();

        return $customer_ic01_info;
    }
    public function getFormCreate($year, $tab = 'tab_main')
    {
        $project_name_disabled = '';
        $customer_id_select_disabled = 'false';
        $customer_ic01='';
        $otl_name_disabled = '';
        $project_practice_disabled='false';
        $customer_ic01_disabled ='false';
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
        // $estimated_date_disabled = '';
        //START DATE
        $estimated_start_date_disabled='';
        //END DATE
        $estimated_end_date_disabled='';


        $LoE_onshore_disabled = '';
        $LoE_nearshore_disabled = '';
        $LoE_offshore_disabled = '';
        $LoE_contractor_disabled = '';
        $gold_order_disabled = '';
        $samba_options_disabled = '';
        $product_code_disabled = '';
        $revenue_disabled = '';
        $win_ratio_disabled = '';
        $show_change_button = false;

        $user_selected = '';

        $created_by_user_id = Auth::user()->id;

        if (Auth::user()->can('tools-activity-all-view')) {
            $user_list = $this->userRepository->getAllUsersList();
            $user_select_disabled = 'false';
        } elseif (Auth::user()->is_manager == 1) {
            $user_list = Auth::user()->employees()->pluck('name', 'user_id');
            $user_list->prepend(Auth::user()->name, Auth::user()->id);
            $user_select_disabled = 'false';
        } else {
            $user_list = [Auth::user()->id => Auth::user()->name];
            $user_selected = Auth::user()->id;
            $user_select_disabled = 'true';
        }

        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        $customers_list->prepend('', '');
        //dd($customers_list);

        $num_of_comments = 0;


         $year = date('Y');
        $manager_list = [];
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_id_for_update = '0';
        } elseif (Auth::user()->is_manager == 1) {
            $user_id_for_update = '0';
        } else {
            $user_id_for_update = Auth::user()->id;
        }
        $all_customer_ic01_values =[];
        return view('tools/create_update', compact('year', 'customers_list','all_customer_ic01_values',
      'user_list', 'user_selected', 'created_by_user_id','project_name_disabled',
      'project_practice_disabled',
      'customer_ic01',
      'customer_id_select_disabled',
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
      // 'estimated_date_disabled',
      'estimated_start_date_disabled',
      'estimated_end_date_disabled',
      'LoE_onshore_disabled',
      'LoE_nearshore_disabled',
      'LoE_offshore_disabled',
      'LoE_contractor_disabled',
      'gold_order_disabled',
      'samba_options_disabled',
      'product_code_disabled',
      'revenue_disabled',
      'win_ratio_disabled',
      'show_change_button',
      'num_of_comments', 'tab'
      ))
      ->with('action', 'create');
    }

    public function checkProjectExistsByName(Request $request)
    {
        $inputs = $request->all();

        $name = $inputs['project_name'];

        $response = Project::where('project_name','like','%'.$name.'%')->get(['id','project_name']);


        return $response;


    }



    public function checkPrimeExistanceOnProject(Request $request)
    {
        $inputs = $request->all();
        $project_practice = $inputs['project_practice'];
        $prime_code = $inputs['prime_code'];
        $responseWithExistsPrimeAndPractice = [];
        $responseWithExistsPrimeDiffPractice = [];

        $response =  Project::where('otl_project_code',$prime_code)->get(['id','project_name','project_practice','otl_project_code']);

        foreach($response as $key=> $value)
        {
            if($value['otl_project_code'] == $prime_code && $value['project_practice'] == $project_practice )
            {
                array_push($responseWithExistsPrimeAndPractice,$value);
                return $responseWithExistsPrimeAndPractice;
            }
            else{
                $response = [];
            }
        }

        return $response;
    }
    public function getCustomerCountryByID(Request $request)
    {
        // code...
        $inputs = $request->all();
        

        $customer_id = $inputs['customer_id'];

        $country = Customer::where('id',$customer_id)->get('country_owner');
        //print("country_owner : ".$country[0]->country_owner);
        $CON_Code = $country[0]->country_owner;

        

        $CON_ISO_2 = json_decode(Http::get('http://country.io/names.json'),true);


        $ISO_3 = json_decode(Http::get('http://country.io/iso3.json'),true);

        foreach($CON_ISO_2 as $key => $val)
        {
            if($val == $CON_Code)
            {
               // print($key." ".$val."<br>");
                foreach($ISO_3 as $key3 => $val3)
                {
                    if($key3 == $key)
                    {
                       // print($val3);
                        $result =$val3;
                    }
                }
            }
        }

        return $result;

    }
    public function postFormCreate(ProjectCreateRequest $request)
    {
        $inputs = $request->all();

        //dd($inputs);
        // $start_end_date = explode(' - ', $inputs['estimated_date']);
        $inputs['estimated_start_date'] = $inputs['estimated_start_date']; 
        $inputs['estimated_end_date'] = $inputs['estimated_end_date'];

        $project = $this->projectRepository->create($inputs);

        // Here I will test if a user has been selected or not
        if (! empty($inputs['user_id'])) {
            foreach ($inputs['month'] as $key => $value) {
                $inputsActivities = [
          'year' => $inputs['year'],
          'month' => $key,
          'project_id' => $project->id,
          'user_id' => $inputs['user_id'],
          'task_hour' => $value,
          'from_otl' => 0,
        ];
                $activity = $this->activityRepository->create($inputsActivities);
            }
        }



        // Here I will test if there is a comment
        if (! empty($inputs['project_comment'])) {
            $comment_input = [
        'user_id' => Auth::user()->id,
        'project_id' => $project->id,
        'comment' => $inputs['project_comment'],
      ];
            $comment = Comment::create($comment_input);
        }

        if (! empty(Session::get('url'))) {
            $redirect = Session::get('url');
        } else {
            $redirect = 'toolsActivities';
        }

        date_default_timezone_set('CET');
        $user = User::find(Auth::user()->id);
        $user->last_activity_update = date('Y-m-d H:i:s');
        $user->save();
        $u = Auth::user()->id;
        $pid = $project->id;
        $year = $inputs['year'];
        $year_p = intval($year);
        

        return redirect('toolsFormUpdate/0/'.$pid.'/'.$year_p)->with('success', 'New project created successfully');
    }

    public function getCustomerAndProjectBySambaID($samba_id){
        $customer_project_form_samba_id = DB::table('projects')
                                        ->Join('customers','projects.customer_id','=','customers.id')
                                        ->where('samba_id',$samba_id)
                                        ->get(['customers.name','customers.id','projects.project_name','projects.id as project_id']);

        return json_encode($customer_project_form_samba_id);

    }
     public function getProjectByCustomerId($customers_id)
    {
        // code...
        $projects = $this->projectRepository->getProjectCustomerAll($customers_id);
        return $projects;
    }

 public function getUserOnProjectForAssign(){
        $user_id = Auth::user()->id;
        $user_list;
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_list_temp = $this->userRepository->getAllUsersListForAssign();

            if ($user_id == '0') {
                foreach ($user_list_temp as $key => $value) {


                    if ($this->activityRepository->user_assigned_on_project($year, $key, $project_id) == 0) {
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
        } elseif (Auth::user()->is_manager == 1) {

            $user_list_temp = Auth::user()->employees()->get(['name', 'user_id']);
            // $user_list_temp->prepend(Auth::user()->name, Auth::user()->id);

            if ($user_id == '0') {
                foreach ($user_list_temp as $key => $value) {
                    if ($this->activityRepository->user_assigned_on_project($year, $key, $project_id) == 0) {
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
        } else {
            $user_list = [Auth::user()->id => Auth::user()->name];
            if ($user_id == '0') {
                $user_select_disabled = 'true';
                $user_selected = '';
            } else {
                $user_select_disabled = 'true';
                $user_selected = $user_id;
            }
        }

   
    return json_encode($user_list);

    }


    public function assignUserToProject(Request $request,$user_id,$project_id){
        
        $result = new \stdClass();
        $result->result = 'success';
        $inputs = $request->all();


        $year = $inputs['year'];
        $month = $inputs['month'];

if ($this->activityRepository->user_assigned_on_project($year, $user_id, $project_id) == 0) {
 $recods = Activity::create([
            'year' => $year,
            'month'=> $month,
            'project_id' => $project_id,
            'user_id' => $user_id,
            'task_hour' => 0,
            'from_otl' => 0
        ]);
            $result->msg = 'User Assigned successfully';
        }
        else{
            $result->msg = 'User Already Assigned to this project';

        }
        
       
            return json_encode($result);
    }

    //check existing prime codes

    public function checkExistingPrime(Request $request)
    {
         $inputs = $request->all();
        

        $prime_code = $inputs['prime_code'];

        $project_list = Project::where('otl_project_code',$prime_code)->get(['id','project_name']);

        return $project_list;
    }

    public function getFormUpdate($user_id, $project_id, $year, $tab = 'tab_main')
    {
        // Here we setup all the disabled fields to be disabled
        $project_name_disabled = 'disabled';
        $customer_id_select_disabled = 'disabled';
        $project_practice_disabled ='';
        $customer_ic01 ='';
        $otl_name_disabled = 'disabled';
        $meta_activity_select_disabled = '';
        $project_type_select_disabled = '';
        $activity_type_select_disabled = '';
        $project_status_select_disabled = '';
        $region_select_disabled = 'true';
        $country_select_disabled = 'true';
        $user_select_disabled = 'true';
        $customer_location_disabled = 'disabled';
        $technology_disabled = 'disabled';
        $description_disabled = 'disabled';
        $comments_disabled = 'disabled';
        // $estimated_date_disabled = 'disabled';
        $estimated_start_date_disabled = 'disabled';
        $estimated_end_date_disabled = 'disabled';
        $LoE_onshore_disabled = 'disabled';
        $LoE_nearshore_disabled = 'disabled';
        $LoE_offshore_disabled = 'disabled';
        $LoE_contractor_disabled = 'disabled';
        $gold_order_disabled = 'disabled';
        $samba_options_disabled = 'disabled';
        $product_code_disabled = 'disabled';
        $revenue_disabled = 'disabled';
        $win_ratio_disabled = 'disabled';
        $show_change_button = false;

        // Here we find the information about the project
        $project = $this->projectRepository->getById($project_id);

        if (Auth::user()->can('tools-all_projects-edit') || (isset($project->created_by_user_id) && (Auth::user()->id == $project->created_by_user_id))) {
            $project_name_disabled = 'true';
            $customer_id_select_disabled = 'false';
            $project_practice='';
            $customer_ic01='';
            $otl_name_disabled = '';
            $meta_activity_select_disabled = 'false';
            $project_type_select_disabled = '';
            $activity_type_select_disabled = '';
            $project_status_select_disabled = '';
            $region_select_disabled = 'false';
            $country_select_disabled = 'false';
            $user_select_disabled = 'false';
            $customer_location_disabled = '';
            $technology_disabled = '';
            $description_disabled = '';
            $comments_disabled = '';
            // $estimated_date_disabled = '';
            $estimated_start_date_disabled = '';
            $estimated_end_date_disabled = '';
            $LoE_onshore_disabled = '';
            $LoE_nearshore_disabled = '';
            $LoE_offshore_disabled = '';
            $LoE_contractor_disabled = '';
            $gold_order_disabled = '';
            $samba_options_disabled = '';
            $product_code_disabled = '';
            $revenue_disabled = '';
            $win_ratio_disabled = '';
        }

        if ($project->otl_validated == 1 && ! Auth::user()->can('tools-update-existing_prime_code')) {
            $otl_name_disabled = 'disabled';
            $meta_activity_select_disabled = 'true';
        }

        $user_list = [];

        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        $customers_list->prepend('', '');



        // Here we will define if we can select a user for this project and activity or not
        // Attention, we need to prevent in the user_list to have ids when already assigned to a project
        if (Auth::user()->can('tools-activity-all-edit')) {
            $user_list_temp = $this->userRepository->getAllUsersList();

            if ($user_id == '0') {
                foreach ($user_list_temp as $key => $value) {
                    if ($this->activityRepository->user_assigned_on_project($year, $key, $project_id) == 0) {
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
        } elseif (Auth::user()->is_manager == 1) {
            $user_list_temp = Auth::user()->employees()->pluck('name', 'user_id');
            $user_list_temp->prepend(Auth::user()->name, Auth::user()->id);

            if ($user_id == '0') {
                foreach ($user_list_temp as $key => $value) {
                    if ($this->activityRepository->user_assigned_on_project($year, $key, $project_id) == 0) {
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
        } else {
            $user_list = [Auth::user()->id => Auth::user()->name];
            if ($user_id == '0') {
                $user_select_disabled = 'true';
                $user_selected = '';
            } else {
                $user_select_disabled = 'true';
                $user_selected = $user_id;
            }
        }

        $created_by_user_name = isset($project->created_by_user_id) ? $project->created_by_user->name : 'Admin';

        $activities = [];
        $from_otl = [];

        if ($user_id != '0') {
            $user = $this->userRepository->getById($user_id);
            $activity_forecast = $this->activityRepository->getByOTL($year, $user->id, $project->id, 0);
            $activity_OTL = $this->activityRepository->getByOTL($year, $user->id, $project->id, 1);
        }

        for ($i = 1; $i <= 12; $i++) {
            if (isset($activity_OTL[$i])) {
                $activities[$i] = $activity_OTL[$i];
                $from_otl[$i] = 'disabled';
            } elseif (isset($activity_forecast[$i])) {
                $activities[$i] = $activity_forecast[$i];
                $from_otl[$i] = '';
            } else {
                $activities[$i] = '0';
                $from_otl[$i] = '';
            }
        }

        for ($i = 1; $i <= 12; $i++) {
            if (isset($activity_OTL[$i])) {
                $otl[$i] = $activity_OTL[$i];
            } else {
                $otl[$i] = 0;
            }
            if (isset($activity_forecast[$i])) {
                $forecast[$i] = $activity_forecast[$i];
            } else {
                $forecast[$i] = 0;
            }
        }

        //here is the check to see if we need the change user button
        $has_otl_activities = $this->activityRepository->getNumberOfOTLPerUserAndProject($user_id, $project_id);
        if (Auth::user()->can('tools-user_assigned-change') && $user_id != 0 && $has_otl_activities == 0) {
            $show_change_button = true;
        }

        $comments = Comment::where('project_id', '=', $project_id)->orderBy('updated_at', 'desc')->get();
        $num_of_comments = count($comments);

        $num_of_actions = Action::where('project_id', '=', $project_id)->get()->count();


        // all users on this project for the actions
        $users_on_project = DB::table('projects')
    ->leftjoin('activities', 'projects.id', '=', 'activities.project_id')
    ->leftjoin('users', 'users.id', '=', 'activities.user_id')
    ->select('users.id', 'users.name')
    ->where('activities.project_id', $project_id)
    ->groupBy('users.name')
    ->pluck('users.name', 'users.id');

        $customer_country = $project->customer_id;
        $country = Customer::where('id',$customer_country)->get('country_owner');
        //print("country_owner : ".$country[0]->country_owner);
        $CON_Code = $country[0]->country_owner;

        $CON_ISO_2 = json_decode(Http::get('http://country.io/names.json'),true);


        $ISO_3 = json_decode(Http::get('http://country.io/iso3.json'),true);

        foreach($CON_ISO_2 as $key => $val)
        {
            if($val == $CON_Code)
            {
               // print($key." ".$val."<br>");
                foreach($ISO_3 as $key3 => $val3)
                {
                    if($key3 == $key)
                    {
                       // print($val3);
                        $customer_country_ascii =$val3;
                    }
                }
            }
        }

        $customer_ic01 = $project->customer_ic01;
        $all_customer_ic01_values = DB::table('customerIC01')->where('customer_id',$project->customer_id)->pluck('ic01_name','ic01_code');
        // dd($project->customer_id);

        return view('tools/create_update', compact('users_on_project','num_of_actions','user_id','project','year','activities','from_otl','forecast','otl','customers_list','customer_country_ascii',
            'all_customer_ic01_values',
    'project_name_disabled',
    'customer_id_select_disabled',
    'project_practice_disabled',
    'customer_ic01',
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
    // 'estimated_date_disabled',
    'estimated_start_date_disabled',
    'estimated_end_date_disabled',
    'LoE_onshore_disabled',
    'LoE_nearshore_disabled',
    'LoE_offshore_disabled',
    'LoE_contractor_disabled',
    'gold_order_disabled',
    'samba_options_disabled',
    'product_code_disabled',
    'revenue_disabled',
    'win_ratio_disabled',
    'show_change_button',
    'num_of_comments', 'comments', 'user_list', 'user_selected', 'user_select_disabled', 'created_by_user_name', 'tab'))
      ->with('action', 'update');
    }


    

    public function postFormUpdate(ProjectUpdateRequest $request)
    {
        if (! empty(Session::get('url'))) {
            $redirect = Session::get('url');
        } else {
         $redirect = 'toolsActivities';   
        }

        $inputs = $request->all();

        // Now we need to check if the user has been flagged for remove from project
        if ($inputs['action'] == 'Remove') {
            if (Auth::user()->can('tools-user_assigned-remove')) {
                $activity = $this->activityRepository->removeUserFromProject($inputs['user_id'], $inputs['project_id'], $inputs['year']);

                return redirect($redirect)->with('success', 'User removed from project successfully');
            }

            return redirect($redirect)->with('error', 'You do not have permission to remove a user');
        }

        // $start_end_date = explode(' - ', $inputs['estimated_date']);
        $inputs['estimated_start_date'] = $inputs['estimated_start_date']; 
        $inputs['estimated_end_date'] = $inputs['estimated_end_date'];

        $project = $this->projectRepository->update($inputs['project_id'], $inputs);

        // if user_id_url = 0 then it is only project update and we don't need to add or update tasks
        if ($inputs['user_id_url'] != 0 && Auth::user()->can('tools-user_assigned-change')) {
            // Let's check first if we changed the user
            if ($inputs['user_id_url'] != $inputs['user_id']) {
                // Let's check if the user we changed to has already some activities on this project
                $has_activities = $this->activityRepository->getNumberPerUserAndProject($inputs['user_id'], $inputs['project_id']);
                if ($inputs['user_id'] == '') {
                    return redirect($redirect)->with('error', 'You must select at least a new user');
                } elseif ($has_activities > 0) {
                    return redirect($redirect)->with('error', 'The user you have selected already has activities for this project');
                } else {
                    foreach ($inputs['month'] as $key => $value) {
                        $inputs_new = $inputs;
                        $inputs_new['month'] = $key;
                        $inputs_new['task_hour'] = $value;
                        $inputs_new['from_otl'] = 0;
                        $activity = $this->activityRepository->assignNewUser($inputs_new['user_id_url'], $inputs_new);
                    }

                    return redirect($redirect)->with('success', 'New user assigned successfully');
                }
            }
        }

        if (! empty($inputs['user_id'])) {
            foreach ($inputs['month'] as $key => $value) {
                $inputs_new = $inputs;
                $inputs_new['month'] = $key;
                $inputs_new['task_hour'] = $value;
                $inputs_new['from_otl'] = 0;
                $activity = $this->activityRepository->createOrUpdate($inputs_new);
            }
        }

        // Here I will test if there is a comment
        if (! empty($inputs['project_comment'])) {
            $comment_input = [
        'user_id' => Auth::user()->id,
        'project_id' => $project->id,
        'comment' => $inputs['project_comment'],
      ];
            $comment = Comment::create($comment_input);
        }

        date_default_timezone_set('CET');
        $user = User::find(Auth::user()->id);
        $user->last_activity_update = date('Y-m-d H:i:s');
        $user->save();
        $tools = 'toolsActivities';

        return redirect($tools)->with('success', 'Project updated successfully');
    }

    public function getFormTransfer($user_id, $project_id)
    {
        return view('tools/transfer', compact('user_id', 'project_id'));
    }

    public function getFormTransferAction($user_id, $old_project_id, $new_project_id, Activity $activity)
    {
        if (! empty(Session::get('url'))) {
            $redirect = Session::get('url');
        } else {
            $redirect = 'toolsActivities';
        }

        // Now we need to look for all the activities assigned to this user and the old projects and update the project to new project
        $activity->where('user_id', $user_id)
              ->where('project_id', $old_project_id)
              ->update(['project_id' => $new_project_id]);

        return redirect($redirect)->with('success', 'User transfered to new project successfully');
    }

    public function userskillslist()
    {
        return view('tools/usersskillslist');
    }

    public function listOfUsersSkills($cert,$europe_cons,$active_cons)
    {
        $skillList = DB::table('skills')
          ->select('skill_user.id', 'skills.domain', 'skills.subdomain', 'skills.technology','u.management_code', 'skills.skill', 'm.name AS manager_name', 'm.email AS manager_email', 'u.email AS user_email', 'u.name AS user_name','u.activity_status AS user_activity', 'u.region', 'u.country','u.pimsid','u.ftid','u.job_role', 'u.employee_type', 'skill_user.rating', 'skills.id AS skill_id')
          ->leftjoin('skill_user', 'skills.id', '=', 'skill_user.skill_id')
          ->leftjoin('users AS u', 'u.id', '=', 'skill_user.user_id')
          ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
          ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
          ->where('skills.certification', '=', $cert);

        if (! Auth::user()->can('tools-usersskills-view-all')) {
            $skillList->where('u.id', '=', Auth::user()->id);
        }
         if ($active_cons == '1') {
            $skillList->where('u.activity_status', '=', 'active');
        }

        if ($europe_cons == '1') {
            $skillList->where(function($skillList) {
        $skillList->where('u.management_code','=','DPS22')
            ->orWhere('u.management_code','=','DCS58');
        });
               
        }
        $data = Datatables::of($skillList)->make(true);

        return $data;
    }

    public function listOfSkills($cert)
    {
        $skillList = DB::table('skills')
          ->select('id', 'domain', 'subdomain', 'technology', 'skill')
          ->where('certification', '=', $cert);

        $data = Datatables::of($skillList)->make(true);

        return $data;
    }

    public function userSkillDelete($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();

        // Do a check first to see if you can delete this or not
        $userskill = UserSkill::find($id);
        if ((Auth::user()->id == $userskill->user_id) or (Auth::user()->can('tools-usersskills-editall'))) {
            $userskill = UserSkill::destroy($id);
            $result->result = 'success';
            $result->msg = 'Record deleted successfully';

            return json_encode($result);
        } else {
            $result->result = 'error';
            $result->msg = 'You don\'t have the rights to delete this record';

            return json_encode($result);
        }
    }

    public function getuserskillFormCreate($id = null)
    {
        if (! empty($id)) {
            $skill = Skill::find($id);
            if ($skill->certification == 1) {
                $select = config('select.usercert_rating');
            } else {
                $select = config('select.userskill_rating');
            }

            if (Auth::user()->can('tools-usersskills-editall')) {
                $user_list = [];
                $user_list_temp = $this->userRepository->getAllUsersList();
                foreach ($user_list_temp as $key => $value) {
                    $userinskilllist = DB::table('skill_user')
              ->select('id')
              ->where('user_id', $key)
              ->where('skill_id', $id)
              ->get();
                    if (count($userinskilllist) == 0) {
                        $user_list[$key] = $value;
                    }
                }
            } else {
                $user_list = User::where('id', Auth::user()->id)->pluck('name', 'id');
            }
        } else {
            $skill = null;
            $user_list = null;
            $select = null;
        }

        return view('tools/userskill_create_update', compact('skill', 'user_list', 'select'))->with('action', 'create');
    }

    public function getuserskillFormUpdate($id)
    {
        $userskill = UserSkill::find($id);
        $skill = Skill::find($userskill->skill_id);
        if ($skill->certification == 1) {
            $select = config('select.usercert_rating');
        } else {
            $select = config('select.userskill_rating');
        }

        $user_list = User::where('id', $userskill->user_id)->pluck('name', 'id');
        if (Auth::user()->can('tools-usersskills-editall') or (Auth::user()->id == $userskill->user_id)) {
            return view('tools/userskill_create_update', compact('userskill', 'skill', 'user_list', 'select'))->with('action', 'update');
        } else {
            return redirect('toolsUsersSkills')->with('error', 'You don\'t have the rights to modify this record');
        }
    }

    public function postuserskillFormCreate(Request $request)
    {
        $inputs = $request->only('skill_id', 'user_id', 'rating');
        if (UserSkill::where('skill_id', $inputs['skill_id'])->where('user_id', $inputs['user_id'])->exists()) {
            return redirect('toolsUsersSkills')->with('error', 'This record has already been assigned');
        } else {
            $userskill = UserSkill::create($inputs);

            return redirect('toolsUsersSkills')->with('success', 'Record created successfully');
        }
    }

    public function postuserskillFormUpdate(Request $request, $id)
    {
        $inputs = $request->only('rating');

        $userskill = UserSkill::find($id);
        $userskill->update($inputs);

        return redirect('toolsUsersSkills')->with('success', 'Record updated successfully');
    }

    public function userSummary(AuthUsersForDataView $authUsersForDataView)
    {
        $authUsersForDataView->userCanView('tools-activity-all-view');
        Session::put('url', 'toolsUserSummary');
        $table_height = Auth::user()->table_height;
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $extra_info_display = 'display:none;';
        //$extra_info_display = "";

        return view('tools/userSummary', compact('authUsersForDataView', 'extra_info_display', 'table_height', 'user_id', 'user_name'));
    }

    public function userSummaryProjects(Request $request)
    {
        $inputs = $request->all();
        $activities = $this->activityRepository->getListOfActivitiesPerUser($inputs);
        foreach ($activities as $key => $activity) {
            $revenue = ProjectRevenue::where('project_id', $activity->project_id)->where('year', $activity->year)->get();
            $activity->revenue_forecast = $revenue;
        }

        return $activities;
    }


    public function checkInactiveForcast(Request $request)
    {
        $arr=[];
        
        print(date('m'));
        print(date('Y'));

        $date_ended = User::whereNotNull('date_ended')->whereYear('date_ended','>=', date('Y'))->orderBy('date_ended','DESC')->get();
        foreach($date_ended as $firstKey)
        {
            //the end date month
            $the_date = date('m',strtotime($firstKey->date_ended));
            // the end date year
            $the_date_year = date('Y',strtotime($firstKey->date_ended));
            print($firstKey->name."<br>");
            print($firstKey->date_ended."<br>");
            if($the_date_year == date('Y'))
            {
            print("--------------");
            print($firstKey->name."<br>");
            print($firstKey->date_ended."<br>");
                
            $activity_end = DB::table('activities as a')->select('u.name','p.project_name','a.month','a.task_hour','a.year')
            ->join('users as u','u.id','=','a.user_id')
            ->join('projects as p','p.id','=','a.project_id')
            ->where('a.user_id',$firstKey->id)
            ->where('a.year','>=',$the_date_year)
            ->get();


            foreach($activity_end as $key)
            {
                print($the_date."<br>");
                if($key->year == $the_date_year){
                    if($key->month > $the_date && $key->task_hour > 0)
                    print($key->month."<br>");
                    for($i = $the_date+1 ; $i <= 12; $i++)
                    {
                        $record = DB::table('activities')
                        ->where('user_id',$firstKey->id)
                        ->where('month',$i)
                        ->where('year','>=',$the_date_year)
                        ->update(['task_hour'=>0]);
                    }
                }else{
                    for($i = 1 ; $i <= 12; $i++)
                    {
                        $record = DB::table('activities')
                        ->where('user_id',$firstKey->id)
                        ->where('month',$i)
                        ->where('year','>',$the_date_year)
                        ->update(['task_hour'=>0]);
                    }   
                }

            }
            }
            // print($key->id."<br>");
            // print(date('m',strtotime($key->date_ended))."<br>");

        }

        


        
    }
    //done for now
    public function addUsersToUnassigned()
    {
        $difference = 0;
        $result = new \stdClass();
        $users_to_unassigned = DB::table('activities as a')
        ->select('u.name','p.project_Name','a.year','a.project_id','u.activity_status','u.supplier','a.month',DB::raw('SUM(a.task_hour) as sum'),'u.id')
        ->join('users as u','u.id','a.user_id')
        ->join('projects as p','p.id','a.project_id')
        ->where('u.name','not LIKE','%ZZZ%')
        ->where('a.year','>=',2022)
        ->where('u.activity_status','NOT LIKE','%inact%')
        ->where('p.project_Name','Not Like','%unassigned%')
        
        ->groupBy('u.id','a.month','a.year')
        
        ->get();

        foreach($users_to_unassigned as $user)
        {   
                if($user->sum < 17 )
            {
                $difference = 17 - $user->sum;
                print($user->project_Name.' '.$user->name.' '.$user->year."<br>");
                $load_hours_to_unassigned = Activity::updateOrCreate([
                    'user_id'=>$user->id,
                    'project_id'=>801,
                    'month'=> $user->month,
                    'year'=>$user->year
                ],
                ['task_hour'=>$difference]
            );
                 $result->result = 'success';
                 $result->id=801;
                 $result->month = $user->month;
                    $result->action = 'update';
                    $result->msg = 'Record updated successfully';
            }
            else{
                $load_hours_to_unassigned = Activity::updateOrCreate([
                    'user_id'=>$user->id,
                    'project_id'=>801,
                    'month'=> $user->month,
                    'year'=>$user->year
                ],
                ['task_hour'=>0]
            );   
                 $result->result = 'success';
                 $result->id=801;
                 $result->month = $user->month;
                 $result->action = 'update';
                 $result->msg = 'Record updated successfully';
            }
        }

        return json_encode($result->msg);
    }

    
}
