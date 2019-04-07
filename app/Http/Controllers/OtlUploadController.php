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

    array_multisort(array_column($messages, 'user'), SORT_ASC, $messages);

    \Session::flash('success', 'File uploaded');
  return view('dataFeed/otlupload',  compact('messages','color'));
  }
}
