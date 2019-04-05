<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Entrust;
use DateTime;
use App\Http\Requests\SambaUploadRequest;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ActivityRepository;
use App\Customer;
class SambaUploadController extends Controller
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
    return view('dataFeed/sambaupload');
  }

  public function postForm(SambaUploadRequest $request)
  {
    $create_records = FALSE;
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
    $messages_only_errors = [];

    //First we need to get all employees for this manager
    $all_users = $this->userRepository->getAllUsersFromManager(Auth::user()->id);
    // Then we extract only the ids of the users reporting to the auth user
    $users_select = [];
    foreach ($all_users as $key => $user) {
      $users_select[$user['id']] = $user['name'];
    }
    //dd($users_select);
    //dd($request->create_in_db);
    $file = $request->file('uploadfile');
    if($file->isValid())
    {
      $filename = $file->getClientOriginalName();
      $fileextension = $file->getClientOriginalExtension();

      $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);

      // Now we need to check we have the right columns
      $headerRow = $sheet->first()->keys()->toArray();
      $columns_needed = ["opportunity_domain","account_name","public_opportunity_id","opportunity_name","opportunity_owner","created_date","close_date","stage","probability","amount_tcv"];

      //print_r($headerRow);echo "</BR>";print_r($columns_needed);die();
      //dd($headerRow);

      // If the columns are not all present then we have an error and go back
      if (array_intersect($headerRow,$columns_needed) != $columns_needed) {
        array_push($messages,['status'=>'error','msg'=>'Some columns are required but not present in the file, please see the sample file and upload again.']);
        $messages_only_errors = $messages;
        return view('dataFeed/sambaupload',  compact('messages_only_errors','messages','color'));
      }

      // This command helps getting a view on what we get from $sheet
      //$sheet->dd();

      $result = $sheet->toArray();

      //dd($result);

      // $i corresponds to the line in the excel file and because the column title is on line 1, we start with $i = 2
      $i = 2;
      foreach ($result as $row){
        // Each row will be as follow:
        /* array:10 [▼
        "opportunity_domain" => "Security"
        "account_name" => "xxx"
        "public_opportunity_id" => "1111111"
        "opportunity_name" => "xxx"
        "opportunity_owner" => "xxx"
        "created_date" => "6/29/2018"
        "close_date" => "12/31/2019"
        "stage" => "1 Pre-qualification"
        "probability" => 0.0
        "amount_tcv" => 1000000.0 */

        array_push($messages,['status'=>'info','msg'=>'---BEGIN LINE '.$i]);
        $projectInDB = $this->projectRepository->getBySambaID($row['public_opportunity_id']);

        //dd(count($projectInDB));

        // Checking if the project is in DB
        if (count($projectInDB) < 1){
          $myDateTime = DateTime::createFromFormat('m/d/Y', $row['created_date']);
          if (is_object($myDateTime)) {
            $created_date = $myDateTime->format('Y-m-d');
          }

          $myDateTime = DateTime::createFromFormat('m/d/Y', $row['close_date']);
          if (is_object($myDateTime)) {
            $close_date = $myDateTime->format('Y-m-d');
          }

          $win_ratio = intval($row['probability']*100);

          array_push($messages,['status'=>'error',
              'msg'=>'LINE '.$i.': '.' <b>Customer</b>: <u>'.$row['account_name'].'</u> / <b>Opportunity</b>: <u>'.$row['opportunity_name'].'</u> / <b>Samba ID</b>: <u>'.$row['public_opportunity_id'].'</u>'.' -> this Samba ID is not found in the DB.',
              'opportunity_domain' => $row['opportunity_domain'],
              'account_name' => $row['account_name'],
              'public_opportunity_id' => $row['public_opportunity_id'],
              'opportunity_name' => $row['opportunity_name'],
              'opportunity_owner' => $row['opportunity_owner'],
              'created_date' => $created_date,
              'close_date' => $close_date,
              'stage' => $row['stage'],
              'probability' => $win_ratio,
              'amount_tcv' => $row['amount_tcv'],
              ]);
          $i += 1;
          continue;
        }

        array_push($messages,['status'=>'info','msg'=>'LINE '.$i.': Found '.count($projectInDB).' instance of Samba ID:'.$row['public_opportunity_id']]);

        // Now we need to go through all the projects that have this samba id and update them with the new information
        foreach ($projectInDB as $key => $project) {
          $customer = $project->customer()->first();
          //dd($row['probability']);
          array_push($messages,['status'=>'update',
          'msg'=>'LINE '.$i.': '.
              ' <b>Customer</b>: <u>'.$customer->name.'</u> / <b>Opportunity</b>: <u>'.$project->project_name.'</u> / <b>Samba ID</b>: <u>'.$row['public_opportunity_id'].'</u>'.' -> project updated in the DB.']);
          $project->samba_lead_domain = $row['opportunity_domain'];
          $project->samba_opportunit_owner = $row['opportunity_owner'];

          $myDateTime = DateTime::createFromFormat('m/d/Y', $row['created_date']);
          if (is_object($myDateTime)) {
            $created_date = $myDateTime->format('Y-m-d');
            $project->estimated_start_date = $created_date;
          }

          $myDateTime = DateTime::createFromFormat('m/d/Y', $row['close_date']);
          if (is_object($myDateTime)) {
            $close_date = $myDateTime->format('Y-m-d');
            $project->estimated_end_date = $close_date;
          }

          $project->samba_stage = $row['stage'];
          $project->win_ratio = intval($row['probability']*100);
          $project->revenue = $row['amount_tcv'];
          $project->save();
        }
        // END check project
        $i += 1;
      }
    }
    
    foreach ($messages as $message){
      if ($message['status'] == 'error') {
        array_push($messages_only_errors,$message);
      }
    }
    \Session::flash('success', 'File uploaded');

    if (isset($request->create_in_db)) {
      $create_records = TRUE;
    }

    $customers_list = Customer::orderBy('name')->lists('name','id');
    $customers_list->prepend('', '');

    return view('dataFeed/sambaupload',  compact('messages_only_errors','messages','color','create_records','customers_list','users_select'));
  }

  public function postFormCreate(Request $request)
  {
    $inputs = $request->all();
    dd($inputs['data'][0]);
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
		$result->result = 'success';
    $result->msg = 'Records added successfully';
		return json_encode($result);
  }
}
