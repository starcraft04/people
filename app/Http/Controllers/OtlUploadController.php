<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Entrust;
use App\Project;
use App\Customer;
use App\Http\Requests\OtlUploadRequest;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ActivityRepository;
class OtlUploadController extends Controller
{
  protected $userRepository;
  public function __construct(UserRepository $userRepository, ProjectRepository $projectRepository, ActivityRepository $activityRepository)
  {
    $this->userRepository = $userRepository;
    $this->projectRepository = $projectRepository;
    $this->activityRepository = $activityRepository;
  }
  public function getForm()
  {
    return view('dataFeed/otlupload');
  }
  public function help()
  {
    return view('dataFeed/otlupload_help');
  }
  public function postForm(OtlUploadRequest $request)
  {
    $color = [
      'error' => 'text-danger',
      'info' => 'text-info',
      'update' => 'text-warning',
      'add' => 'text-primary'
    ];

    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = '';

    $messages = [];

    // now we will need a association between months written in letters and numbers because in the activites table it is in numbers and in the excel file it is in letters
    $months_converted = [
      "jan" => 1,
      "feb" => 2,
      "mar" => 3,
      "apr" => 4,
      "may" => 5,
      "jun" => 6,
      "jul" => 7,
      "aug" => 8,
      "sep" => 9,
      "oct" => 10,
      "nov" => 11,
      "dec" => 12
    ];


    //First we need to get all employees for this manager
    $all_users = $this->userRepository->getAllUsersFromManager(Auth::user()->id);
    // Then we extract only the ids of the users reporting to the auth user
    $users_id = [];
    foreach ($all_users as $key => $user) {
      array_push($users_id,$user['id']);
    }
    //dd($users_id);

    $file = $request->file('uploadfile');
    if($file->isValid())
    {
      $filename = $file->getClientOriginalName();
      $fileextension = $file->getClientOriginalExtension();

      $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);

      // Now we need to check we have the right columns
      $headerRow = $sheet->first()->keys()->toArray();
      $columns_needed = ["customer_name","project_name","meta_activity","employee_name","year","month","converted_time","unit"];

      // If the columns are not all present then we have an error and go back
      if ($headerRow != $columns_needed) {
        array_push($messages,['status'=>'error',
          'user' =>'',
          'msg'=>'Some columns are required but not present in the file, please see the sample file and upload again.']);
        return view('dataFeed/otlupload',  compact('messages','color'));
      }

      // This command helps getting a view on what we get from $sheet
      //$sheet->dd();

      $result = $sheet->toArray();

      //dd($result);

      foreach ($result as $row){
        $userInDB = $this->userRepository->getByName($row['employee_name']);
        $projectInDBnum = $this->projectRepository->getByOTLnum($row['project_name'],$row['meta_activity']);

        // Checking if the user is in DB
        if (empty($userInDB)){
          if (!in_array(['status'=>'error','msg'=>'User is not in DB','user' =>$row['employee_name']],$messages,TRUE)) {
            array_push($messages,['status'=>'error',
            'msg'=>'User is not in DB',
            'user' =>$row['employee_name']
            ]);
          }
          continue;
        }
        // END check user

        // Checking if you have the rights to modify this user
        if (!Entrust::can('otl-upload-all') && !in_array($userInDB->id,$users_id)){
          if (!in_array(['status'=>'error','msg'=>'User not your employee','user' =>$row['employee_name']],$messages,TRUE)) {
            array_push($messages,['status'=>'error',
            'msg'=>'User not your employee',
            'user' =>$row['employee_name']
            ]);
          }
          continue;
        }

        if (!array_key_exists(strtolower($row['month']),$months_converted)){
          if (!in_array(['status'=>'error','user' =>'','msg'=>'Month '.$row['month'].' is not a correct value, it should be in the form Jan, Feb, Mar, ...'],$messages,TRUE)) {
            array_push($messages,['status'=>'error',
            'user' =>'',
            'msg'=> 'Month '.$row['month'].' is not a correct value, it should be in the form Jan, Feb, Mar, ...'
            ]);
          }
          continue;
        }

        //dd($projectInDBnum);

        // Checking if the project is in DB
        if ($projectInDBnum != 1){
          if (!in_array(['status'=>'error','mgr'=>$userInDB->managers->first()->name,'msg'=>'this Prime code and META activity is not found in the DB.','user' =>$row['employee_name'],'customer_prime' => $row['customer_name'],'prime_code' => $row['project_name'],'meta' => $row['meta_activity'],'year' => $row['year']],$messages,TRUE)) {
            array_push($messages,['status'=>'error',
              'mgr'=>$userInDB->managers->first()->name,
              'msg'=>'this Prime code and META activity is not found in the DB.',
              'user' =>$row['employee_name'],
              'customer_prime' => $row['customer_name'],
              'prime_code' => $row['project_name'],
              'meta' => $row['meta_activity'],
              'year' => $row['year']
              ]);
            }
          continue;
        }
        else {
          // Only if we can find 1 instance of a mix of otl_project_code and meta-activity then we enter the activity
          $projectInDB = $this->projectRepository->getByOTL($row['project_name'],$row['meta_activity']);
          $projectInDB->otl_validated = 1;
          $projectInDB->save();
        }
        // END check project

        // If User AND Project is found in DB then we can update the activities
        $activity = [];
        // Now we need to check if we need to update or create an activity
        $activity['year'] = $row['year'];
        // We need to check first that a month has well been entered
        
        $activity['month'] = $months_converted[strtolower($row['month'])];
        $activity['user_id'] = $userInDB->id;
        $activity['project_id'] = $projectInDB->id;
        $activity['task_hour'] = $row['converted_time'];
        $activity['from_otl'] = 1;
        $activityInDB = $this->activityRepository->checkIfExists($activity);
        if (!$activityInDB){
          $this->activityRepository->create($activity);
        } else {
          $this->activityRepository->update($activityInDB->id,$activity);
        }
        // END assign activities
      }
    }

    if (isset($request->create_in_db)) {
      $create_records = TRUE;
    }

    array_multisort(array_column($messages, 'user'), SORT_ASC, $messages);

    foreach ($messages as $key => &$value) {
      if (isset($value['prime_code'])) {
        $user_project = Project::select('projects.id as project_id','customers.name as customer_name','projects.project_name as project_name')
              ->leftjoin('customers','projects.customer_id','=','customers.id')
              ->leftjoin('activities','projects.id','=','activities.project_id')
              ->leftjoin('users','users.id','=','activities.user_id')
              ->where('activities.year',$value['year'])
              ->where('users.name',$value['user'])
              ->whereNull('projects.otl_project_code')
              ->groupBy('projects.id')
              ->get()->toArray();
        $value['user_projects'] = $user_project;
      }
    }

    //dd($messages);

    $customers_list = Customer::orderBy('name')->lists('name','id');
    $customers_list->prepend('', '');

    \Session::flash('success', 'File uploaded');
  return view('dataFeed/otlupload',  compact('messages','color','create_records','customers_list'));
  }
  public function postFormCreate(Request $request)
  {

    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
		$result->result = 'success';
    $result->msg = 'Records added successfully';

    $inputs = $request->all();
    $datas = json_decode($inputs['data']);
    dd($datas);
    // datas is in the following form:
      /* array:2 [
        0 => {
          +"samba_lead_domain": "Security"
          +"customer_samba": "GlaxoSmithKline plc"
          +"customer_dolphin": "70"
          +"project_name": "GSK USB Scanning Device"
          +"assigned_user": "9"
          +"samba_id": "70165805"
          +"order_intake": "540990"
          +"opportunity_owner": "Mike Christodoulou"
          +"creat_date": "2018-12-13"
          +"close_date": "2019-10-25"
          +"samba_stage": "2 Qualification"
          +"win_ratio": "10"
        }
        1 => {...
        }
      ] */

    // Now we will loop through the datas
    // First we need to check if the projects already exists
    foreach ($datas as $key => $data) {
      // Let's assign the right column names
      $project_inputs = [];
      $project_inputs['samba_lead_domain'] = trim($data->samba_lead_domain);
      $project_inputs['customer_id'] = $data->customer_dolphin;
      $project_inputs['project_name'] = trim($data->project_name);
      $project_inputs['samba_id'] = trim($data->samba_id);
      $project_inputs['revenue'] = $data->order_intake;
      $project_inputs['samba_opportunit_owner'] = trim($data->opportunity_owner);
      $project_inputs['estimated_start_date'] = $data->creat_date;
      $project_inputs['estimated_end_date'] = $data->close_date;
      $project_inputs['samba_stage'] = trim($data->samba_stage);
      $project_inputs['win_ratio'] = $data->win_ratio;
      $project_inputs['meta_activity'] = null;
      $project_inputs['otl_project_code'] = null;
      $project_inputs['project_type'] = 'Pre-sales';

      // Let's check if we can find in the DB a record with the same project name and customer id
      $project_count = $this->projectRepository->getByNameCustomernum($project_inputs['project_name'],$project_inputs['customer_id']);
      if ($project_count>0) {
        $project = $this->projectRepository->getByNameCustomer($project_inputs['project_name'],$project_inputs['customer_id']);
        $project_inputs_update['samba_lead_domain'] = $project_inputs['samba_lead_domain'];
        $project_inputs_update['samba_id'] = $project_inputs['samba_id'];
        $project_inputs_update['revenue'] = $project_inputs['revenue'];
        $project_inputs_update['samba_opportunit_owner'] = $project_inputs['samba_opportunit_owner'];
        $project_inputs_update['estimated_start_date'] = $project_inputs['estimated_start_date'];
        $project_inputs_update['estimated_end_date'] = $project_inputs['estimated_end_date'];
        $project_inputs_update['samba_stage'] = $project_inputs['samba_stage'];
        $project_inputs_update['win_ratio'] = $project_inputs['win_ratio'];
        $project = $this->projectRepository->update($project->id,$project_inputs_update);
      } else {
        $project = $this->projectRepository->create($project_inputs);
      }
      // Now we need to assign the user
      $activity_inputs['year'] = $year;
      $activity_inputs['month'] = 1;
      $activity_inputs['project_id'] = $project->id;
      $activity_inputs['user_id'] = $data->assigned_user;
      $activity_inputs['task_hour'] = 0;

      // Let's check if we can find in the DB a record with the same activity
      $activity_count = $this->activityRepository->getByYMPUnum($activity_inputs['year'],$activity_inputs['month'],$activity_inputs['project_id'],$activity_inputs['user_id']);
      if ($activity_count>0) {
      } else {
        $activity = $this->activityRepository->create($activity_inputs);
      }
    }

		return json_encode($result);
  }
}
