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
      $filenametemp = explode(".", $filename);
      $yearmonth = explode("-", $filenametemp[0]);

      config(['excel.import.startRow' => 2 ]);
      $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);
      // This command helps getting a view on what we get from $sheet
      //$sheet->dd();
      $result = $sheet->get();

      // dd($result);

      $messages = [];
      $i = 1;
      foreach ($result as $row){
        array_push($messages,['status'=>'BEGIN LINE '.$i,'msg'=>'************************']);
        $missing = 0;
        $userInDB = $this->userRepository->getByName($row->employee_name);
        $projectInDBnum = $this->projectRepository->getByOTLnum($row->project_name,$row->meta_activity);

        if (empty($userInDB)){
          array_push($messages,['status'=>'error','msg'=>'LINE '.$i.': User '.$row->employee_name.' not in DB']);
          $missing = 1;
        }
        else {
          array_push($messages,['status'=>'info','msg'=>'LINE '.$i.': User '.$row->employee_name.' already in DB']);
        }
        if ($projectInDBnum > 1){
          array_push($messages,['status'=>'error',
              'msg'=>'LINE '.$i.': Found '.$projectInDBnum.' instance for user '.$row->employee_name.' of </BR><div style="padding-left:5em;">Customer: '.$row->customer_name.' </BR> OTL code: '.$row->project_name.' </BR> META: '.$row->meta_activity.'</div>']);
        }
        elseif ($projectInDBnum == 1) {
          // Only if we can find 1 instance of a mix of otl_project_code and meta-activity then we enter the activity
          array_push($messages,['status'=>'info','msg'=>'LINE '.$i.': Found '.$projectInDBnum.' instance of '.$row->project_name.' with meta '.$row->meta_activity]);
          $projectInDB = $this->projectRepository->getByOTL($row->project_name,$row->meta_activity);
          $project_input = [];
          $project_input['otl_validated'] = 1;
          $this->projectRepository->update($projectInDB->id,$project_input);
          if ($missing == 0) {
            $activity = [];
            // Now we need to check if we need to update or create an activity
            $activity['year'] = $yearmonth[0];
            $activity['month'] = $yearmonth[1];
            $activity['user_id'] = $userInDB->id;
            $activity['project_id'] = $projectInDB->id;
            $activity['task_hour'] = $row->original_time / config('options.time_trak')['hours_in_day'];
            $activity['from_otl'] = 1;
            $activityInDB = $this->activityRepository->checkIfExists($activity);
            if (!$activityInDB){
              $this->activityRepository->create($activity);
              array_push($messages,['status'=>'add','msg'=>'LINE '.$i.': Activity created in DB']);
            } else {
              $this->activityRepository->update($activityInDB->id,$activity);
              array_push($messages,['status'=>'update','msg'=>'LINE '.$i.': Activity updated in DB']);
            }
          }
        }
        else {
          array_push($messages,['status'=>'error',
            'msg'=>'LINE '.$i.': Found '.$projectInDBnum.' instance for user '.$row->employee_name.' of </BR><div style="padding-left:5em;">Customer: '.$row->customer_name.' </BR> OTL code: '.$row->project_name.' </BR> Meta: '.$row->meta_activity.'</div>']);
        }
        array_push($messages,['status'=>'END LINE '.$i,'msg'=>'************************']);
        $i += 1;
      }
    }

return view('dataFeed/otlupload',  compact('messages','color'))->with('success','File processed');
}
}
