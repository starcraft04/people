<?php
namespace App\Http\Controllers;
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


    $file = $request->file('uploadfile');
    if($file->isValid())
    {
      $filename = $file->getClientOriginalName();
      $fileextension = $file->getClientOriginalExtension();
      $year = explode(".", $filename)[0];
      $year_short = substr($year, -2); 

      $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);
      // This command helps getting a view on what we get from $sheet
      //$sheet->dd();
      $result = $sheet->toArray();

      //dd($result);

      // At the end of the foreach, I will have the following:
      //  $months_in_excel = [
      //    ["excel" => "jan_17, "db" => 1,"year"=>2017],
      //    ["excel" => "mar_17, "db" => 3,"year"=>2017],
      //    ["excel" => "jun_17, "db" => 6,"year"=>2017]
      //  ]
      $months_in_excel = [];
      foreach (config('select.month') as $key => $month){
        if (isset($result[0][strtolower($month).'_'.$year_short])) {
          array_push($months_in_excel,["excel" => strtolower($month).'_'.$year_short, "db" => $key,"year"=>$year]);
        }
      }
      //dd($months_in_excel);

      $messages = [];
      // $i corresponds to the line in the excel file and because the column title is on line 1, we start with $i = 2
      $i = 2;
      foreach ($result as $row){
        array_push($messages,['status'=>'info','msg'=>'BEGIN LINE '.$i]);
        $userInDB = $this->userRepository->getByName($row['employee_name']);
        $projectInDBnum = $this->projectRepository->getByOTLnum($row['project_name'],$row['meta_activity']);

        // Checking if the user is in DB
        if (empty($userInDB)){
          array_push($messages,['status'=>'error','msg'=>'LINE '.$i.': User '.$row['employee_name'].' not in DB']);
          continue;
        }
        else {
          array_push($messages,['status'=>'info','msg'=>'LINE '.$i.': User '.$row['employee_name'].' already in DB']);
        }
        // END check user
        
        
        // First we need to check that we do not have a line with only 0
        $num_of_month_positive = 0;
        foreach ($months_in_excel as $month) {
          if ($row[$month['excel']] > 0) {
            $num_of_month_positive++;
          }
        }
        // Checking if the project is in DB
        if ($projectInDBnum != 1){
          if ($num_of_month_positive > 0) {
            array_push($messages,['status'=>'error',
              'msg'=>'LINE '.$i.': '.$userInDB->managers->first()->name.' - '.$row['employee_name'].
              ' -> <b>Customer</b>: <u>'.$row['customer_name'].'</u> / <b>OTL code</b>: <u>'.$row['project_name'].'</u> / <b>META</b>: <u>'.$row['meta_activity'].'</u>']);
          }
          continue;
        }
        else {
          // Only if we can find 1 instance of a mix of otl_project_code and meta-activity then we enter the activity
          array_push($messages,['status'=>'info','msg'=>'LINE '.$i.': Found '.$projectInDBnum.' instance of '.$row['project_name'].' with meta '.$row['meta_activity']]);
          $projectInDB = $this->projectRepository->getByOTL($row['project_name'],$row['meta_activity']);
          $projectInDB->otl_validated = 1;
          $projectInDB->save();
        }
        // END check project

        // If User AND Project is found in DB then we can update the activities
        if ($num_of_month_positive > 0) {
          foreach ($months_in_excel as $month) {
            if ($row[$month['excel']] > 0) {
              $activity = [];
              // Now we need to check if we need to update or create an activity
              $activity['year'] = $month['year'];
              $activity['month'] = $month['db'];
              $activity['user_id'] = $userInDB->id;
              $activity['project_id'] = $projectInDB->id;
              $activity['task_hour'] = $row[$month['excel']] / config('options.time_trak')['hours_in_day'];
              $activity['from_otl'] = 1;
              $activityInDB = $this->activityRepository->checkIfExists($activity);
              if (!$activityInDB){
                $this->activityRepository->create($activity);
                array_push($messages,['status'=>'add','msg'=>'LINE '.$i.': Activity '.$month['excel'].' created in DB']);
              } else {
                $this->activityRepository->update($activityInDB->id,$activity);
                array_push($messages,['status'=>'update','msg'=>'LINE '.$i.': Activity '.$month['excel'].' updated in DB']);
              }
            }
          }
        }
        // END assign activities

        array_push($messages,['status'=>'info','msg'=>'END LINE '.$i]);
        $i += 1;
      }
    }
  return view('dataFeed/otlupload',  compact('messages','color'))->with('success','File processed');
  }
}
