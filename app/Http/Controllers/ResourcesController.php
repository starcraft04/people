<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Action;
use App\Activity;
use App\Comment;
use App\Customer;
use App\Http\Controllers\Auth\AuthUsersForDataView;
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

class ResourcesController extends Controller
{
    //

    protected $activityRepository;
    protected $userRepository;
    protected $projectRepository;

    public function __construct(ActivityRepository $activityRepository, UserRepository $userRepository, ProjectRepository $projectRepository)
    {
        $this->activityRepository = $activityRepository;
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
    }

    public function show(AuthUsersForDataView $authUsersForDataView){
        $authUsersForDataView->userCanView('tools-activity-all-view');
        Session::put('url', 'toolsActivities');
        $table_height = Auth::user()->table_height;

        return view('resourcesGap.resources', compact('authUsersForDataView', 'table_height'));
    }

    public function show_users($domain,$year,$val,AuthUsersForDataView $authUsersForDataView){
        $authUsersForDataView->userCanView('tools-activity-all-view');
        Session::put('url', 'toolsActivities');
        $table_height = Auth::user()->table_height;

        if($val == 1)
        {
            return view('resourcesGap.gap_details', compact('domain','year','authUsersForDataView', 'table_height'));
        }
        if($val == 0){
            return view('resourcesGap.gap_projects', compact('domain','year','authUsersForDataView', 'table_height'));
        }
    }

    public function Lists(Request $request)
    {
        $domains = [];
        $input = $request->all();

         $unassigned = $this->activityRepository->getListOfActivitiesPerUserOnUnassigned($input);
         $zzzUsers = $this->activityRepository->getListOfActivitiesPerZZZUser($input);

         if($input['checkbox_closed'] == 1){
            foreach ($unassigned as $key => $value) {
            // code...
           if(sizeof($zzzUsers) > 0){
             foreach ($zzzUsers as $key => $Zvalue) {
                $new_practice = str_replace(' ','_',$value->practice);
                // code...
                if($value->practice !== null){
                    if(str_contains($Zvalue->name,$new_practice) !== false){
                    $value->m1_com_sum =  round(($Zvalue->m1_com_sum - $value->m1_com_sum),1);
                    $value->m2_com_sum =  round(($Zvalue->m2_com_sum - $value->m2_com_sum),1);
                    $value->m3_com_sum =  round(($Zvalue->m3_com_sum - $value->m3_com_sum),1);
                    $value->m4_com_sum =  round(($Zvalue->m4_com_sum - $value->m4_com_sum),1);
                    $value->m5_com_sum =  round(($Zvalue->m5_com_sum - $value->m5_com_sum),1);
                    $value->m6_com_sum =  round(($Zvalue->m6_com_sum - $value->m6_com_sum),1);
                    $value->m7_com_sum =  round(($Zvalue->m7_com_sum - $value->m7_com_sum),1);
                    $value->m8_com_sum =  round(($Zvalue->m8_com_sum - $value->m8_com_sum),1);
                    $value->m9_com_sum =  round(($Zvalue->m9_com_sum - $value->m9_com_sum),1);
                    $value->m10_com_sum = round(($Zvalue->m10_com_sum -$value->m10_com_sum),1);
                    $value->m11_com_sum = round(($Zvalue->m11_com_sum -$value->m11_com_sum),1);
                    $value->m12_com_sum = round(($Zvalue->m12_com_sum -$value->m12_com_sum),1);
                    $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);
                    }
                    else{

                    $value->m1_com_sum = round(0 - (($value->m1_com_sum)/17),1);
                    $value->m2_com_sum = round(0 - (($value->m2_com_sum)/17),1);
                    $value->m3_com_sum = round(0 - (($value->m3_com_sum)/17),1);
                    $value->m4_com_sum = round(0 - (($value->m4_com_sum)/17),1);
                    $value->m5_com_sum = round(0 - (($value->m5_com_sum)/17),1);
                    $value->m6_com_sum = round(0 - (($value->m6_com_sum)/17),1);
                    $value->m7_com_sum = round(0 - (($value->m7_com_sum)/17),1);
                    $value->m8_com_sum = round(0 - (($value->m8_com_sum)/17),1);
                    $value->m9_com_sum = round(0 - (($value->m9_com_sum)/17),1);
                    $value->m10_com_sum = round(0 - (($value->m10_com_sum)/17),1);
                    $value->m11_com_sum = round(0 - (($value->m11_com_sum)/17),1);
                    $value->m12_com_sum = round(0 - (($value->m12_com_sum)/17),1);
                        $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);                  
                    }
                    break;
                    
                }
                else{
                    $value->m1_com_sum = round(0 - (($value->m1_com_sum)/17),1);
                    $value->m2_com_sum = round(0 - (($value->m2_com_sum)/17),1);
                    $value->m3_com_sum = round(0 - (($value->m3_com_sum)/17),1);
                    $value->m4_com_sum = round(0 - (($value->m4_com_sum)/17),1);
                    $value->m5_com_sum = round(0 - (($value->m5_com_sum)/17),1);
                    $value->m6_com_sum = round(0 - (($value->m6_com_sum)/17),1);
                    $value->m7_com_sum = round(0 - (($value->m7_com_sum)/17),1);
                    $value->m8_com_sum = round(0 - (($value->m8_com_sum)/17),1);
                    $value->m9_com_sum = round(0 - (($value->m9_com_sum)/17),1);
                    $value->m10_com_sum = round(0 - (($value->m10_com_sum)/17),1);
                    $value->m11_com_sum = round(0 - (($value->m11_com_sum)/17),1);
                    $value->m12_com_sum = round(0 - (($value->m12_com_sum)/17),1);
                    $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);
                }
                

            }
           }
           else{
                    $value->m1_com_sum =round(0 - (($value->m1_com_sum)/17),1);
                    $value->m2_com_sum =round(0 - (($value->m2_com_sum)/17),1);
                    $value->m3_com_sum =round(0 - (($value->m3_com_sum)/17),1);
                    $value->m4_com_sum = round(0 - (($value->m4_com_sum)/17),1);
                    $value->m5_com_sum = round(0 - (($value->m5_com_sum)/17),1);
                    $value->m6_com_sum = round(0 - (($value->m6_com_sum)/17),1);
                    $value->m7_com_sum = round(0 - (($value->m7_com_sum)/17),1);
                    $value->m8_com_sum = round(0 - (($value->m8_com_sum)/17),1);
                    $value->m9_com_sum = round(0 - (($value->m9_com_sum)/17),1);
                    $value->m10_com_sum = round(0 - (($value->m10_com_sum)/17),1);
                    $value->m11_com_sum = round(0 - (($value->m11_com_sum)/17),1);
                    $value->m12_com_sum = round(0 - (($value->m12_com_sum)/17),1);
                    $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);

           }
        }
         }
         else{
            foreach ($unassigned as $key => $value) {
            // code...
           if(sizeof($zzzUsers) > 0){
             foreach ($zzzUsers as $key => $Zvalue) {
                $new_practice = str_replace(' ','_',$value->practice);
                // code...
                if($value->practice !== null){
                    if(str_contains($Zvalue->name,$new_practice) !== false){
                    $value->m1_com_sum = $Zvalue->m1_com_sum - $value->m1_com_sum;
                    $value->m2_com_sum = $Zvalue->m2_com_sum - $value->m2_com_sum;
                    $value->m3_com_sum = $Zvalue->m3_com_sum - $value->m3_com_sum;
                    $value->m4_com_sum = $Zvalue->m4_com_sum - $value->m4_com_sum;
                    $value->m5_com_sum = $Zvalue->m5_com_sum - $value->m5_com_sum;
                    $value->m6_com_sum = $Zvalue->m6_com_sum - $value->m6_com_sum;
                    $value->m7_com_sum = $Zvalue->m7_com_sum - $value->m7_com_sum;
                    $value->m8_com_sum = $Zvalue->m8_com_sum - $value->m8_com_sum;
                    $value->m9_com_sum = $Zvalue->m9_com_sum - $value->m9_com_sum;
                    $value->m10_com_sum = $Zvalue->m10_com_sum - $value->m10_com_sum;
                    $value->m11_com_sum = $Zvalue->m11_com_sum - $value->m11_com_sum;
                    $value->m12_com_sum = $Zvalue->m12_com_sum - $value->m12_com_sum;
                    $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);
                    }
                    else{

                    $value->m1_com_sum = 0 - $value->m1_com_sum;
                    $value->m2_com_sum = 0 - $value->m2_com_sum;
                    $value->m3_com_sum = 0 - $value->m3_com_sum;
                    $value->m4_com_sum = 0 - $value->m4_com_sum;
                    $value->m5_com_sum = 0 - $value->m5_com_sum;
                    $value->m6_com_sum = 0 - $value->m6_com_sum;
                    $value->m7_com_sum = 0 - $value->m7_com_sum;
                    $value->m8_com_sum = 0 - $value->m8_com_sum;
                    $value->m9_com_sum = 0 - $value->m9_com_sum;
                    $value->m10_com_sum = 0 - $value->m10_com_sum;
                    $value->m11_com_sum = 0 - $value->m11_com_sum;
                    $value->m12_com_sum = 0 - $value->m12_com_sum;
                        $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);           
                    }
                    break;
                    
                }
                else{
                    $value->m1_com_sum = 0 - $value->m1_com_sum;
                    $value->m2_com_sum = 0 - $value->m2_com_sum;
                    $value->m3_com_sum = 0 - $value->m3_com_sum;
                    $value->m4_com_sum = 0 - $value->m4_com_sum;
                    $value->m5_com_sum = 0 - $value->m5_com_sum;
                    $value->m6_com_sum = 0 - $value->m6_com_sum;
                    $value->m7_com_sum = 0 - $value->m7_com_sum;
                    $value->m8_com_sum = 0 - $value->m8_com_sum;
                    $value->m9_com_sum = 0 - $value->m9_com_sum;
                    $value->m10_com_sum = 0 - $value->m10_com_sum;
                    $value->m11_com_sum = 0 - $value->m11_com_sum;
                    $value->m12_com_sum = 0 - $value->m12_com_sum;
                    $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);
                }
                

            }
           }
           else{
                    $value->m1_com_sum = 0 - $value->m1_com_sum;
                    $value->m2_com_sum = 0 - $value->m2_com_sum;
                    $value->m3_com_sum = 0 - $value->m3_com_sum;
                    $value->m4_com_sum = 0 - $value->m4_com_sum;
                    $value->m5_com_sum = 0 - $value->m5_com_sum;
                    $value->m6_com_sum = 0 - $value->m6_com_sum;
                    $value->m7_com_sum = 0 - $value->m7_com_sum;
                    $value->m8_com_sum = 0 - $value->m8_com_sum;
                    $value->m9_com_sum = 0 - $value->m9_com_sum;
                    $value->m10_com_sum = 0 - $value->m10_com_sum;
                    $value->m11_com_sum = 0 - $value->m11_com_sum;
                    $value->m12_com_sum = 0 - $value->m12_com_sum;
                    $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);

           }
        }
         }



         $data = Datatables::of($unassigned)->make(true);
         return $data;
    }

    // public function ListsFTE(Request $request)
    // {
    //     $domains = [];
    //     $input = $request->all();

    //      $unassigned = $this->activityRepository->getListOfActivitiesPerUserOnUnassigned($input);
    //      $zzzUsers = $this->activityRepository->getListOfActivitiesPerZZZUser($input);
    //      foreach ($unassigned as $key => $value) {
    //         // code...
    //        if(sizeof($zzzUsers) > 0){
    //          foreach ($zzzUsers as $key => $Zvalue) {
    //             $new_practice = str_replace(' ','_',$value->practice);
    //             // code...
    //             if($value->practice !== null){
    //                 if(str_contains($Zvalue->name,$new_practice) !== false){
    //                 $value->m1_com_sum = round((($Zvalue->m1_com_sum )/17)- $value->m1_com_sum,1);
    //                 $value->m2_com_sum = round((($Zvalue->m2_com_sum )/17)- $value->m2_com_sum,1);
    //                 $value->m3_com_sum = round((($Zvalue->m3_com_sum )/17)- $value->m3_com_sum,1);
    //                 $value->m4_com_sum = round((($Zvalue->m4_com_sum )/17)- $value->m4_com_sum,1);
    //                 $value->m5_com_sum = round((($Zvalue->m5_com_sum )/17)- $value->m5_com_sum,1);
    //                 $value->m6_com_sum = round((($Zvalue->m6_com_sum )/17)- $value->m6_com_sum,1);
    //                 $value->m7_com_sum = round((($Zvalue->m7_com_sum )/17)- $value->m7_com_sum,1);
    //                 $value->m8_com_sum = round((($Zvalue->m8_com_sum )/17)- $value->m8_com_sum,1);
    //                 $value->m9_com_sum = round((($Zvalue->m9_com_sum )/17)- $value->m9_com_sum,1);
    //                 $value->m10_com_sum = round((($Zvalue->m10_com_sum)/17) - $value->m10_com_sum,1);
    //                 $value->m11_com_sum = round((($Zvalue->m11_com_sum)/17) - $value->m11_com_sum,1);
    //                 $value->m12_com_sum = round((($Zvalue->m12_com_sum)/17) - $value->m12_com_sum,1);
    //                 $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);
    //                 }
    //                 else{

    //                 $value->m1_com_sum = round(0 - (($value->m1_com_sum)/17),2);
    //                 $value->m2_com_sum = round(0 - (($value->m2_com_sum)/17),2);
    //                 $value->m3_com_sum = round(0 - (($value->m3_com_sum)/17),2);
    //                 $value->m4_com_sum = round(0 - (($value->m4_com_sum)/17),2);
    //                 $value->m5_com_sum = round(0 - (($value->m5_com_sum)/17),2);
    //                 $value->m6_com_sum = round(0 - (($value->m6_com_sum)/17),2);
    //                 $value->m7_com_sum = round(0 - (($value->m7_com_sum)/17),2);
    //                 $value->m8_com_sum = round(0 - (($value->m8_com_sum)/17),2);
    //                 $value->m9_com_sum = round(0 - (($value->m9_com_sum)/17),2);
    //                 $value->m10_com_sum = round(0 - (($value->m10_com_sum)/17),2);
    //                 $value->m11_com_sum = round(0 - (($value->m11_com_sum)/17),2);
    //                 $value->m12_com_sum = round(0 - (($value->m12_com_sum)/17),2);
    //                     $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);                    }
                    
    //             }
    //             else{
    //                 $value->m1_com_sum = round(0 - (($value->m1_com_sum)/17),1);
    //                 $value->m2_com_sum = round(0 - (($value->m2_com_sum)/17),1);
    //                 $value->m3_com_sum = round(0 - (($value->m3_com_sum)/17),1);
    //                 $value->m4_com_sum = round(0 - (($value->m4_com_sum)/17),1);
    //                 $value->m5_com_sum = round(0 - (($value->m5_com_sum)/17),1);
    //                 $value->m6_com_sum = round(0 - (($value->m6_com_sum)/17),1);
    //                 $value->m7_com_sum = round(0 - (($value->m7_com_sum)/17),1);
    //                 $value->m8_com_sum = round(0 - (($value->m8_com_sum)/17),1);
    //                 $value->m9_com_sum = round(0 - (($value->m9_com_sum)/17),1);
    //                 $value->m10_com_sum = round0(0 - (($value->m10_com_sum)/17),1);
    //                 $value->m11_com_sum = round0(0 - (($value->m11_com_sum)/17),1);
    //                 $value->m12_com_sum = round0(0 - (($value->m12_com_sum)/17),1);
    //                 $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);
    //             }
                

    //         }
    //        }
    //        else{
    //                 $value->m1_com_sum =round(0 - (($value->m1_com_sum)/17),1);
    //                 $value->m2_com_sum =round(0 - (($value->m2_com_sum)/17),1);
    //                 $value->m3_com_sum =round(0 - (($value->m3_com_sum)/17),1);
    //                 $value->m4_com_sum = round(0 - (($value->m4_com_sum)/17),1);
    //                 $value->m5_com_sum = round(0 - (($value->m5_com_sum)/17),1);
    //                 $value->m6_com_sum = round(0 - (($value->m6_com_sum)/17),1);
    //                 $value->m7_com_sum = round(0 - (($value->m7_com_sum)/17),1);
    //                 $value->m8_com_sum = round(0 - (($value->m8_com_sum)/17),1);
    //                 $value->m9_com_sum = round(0 - (($value->m9_com_sum)/17),1);
    //                 $value->m10_com_sum = round(0 - (($value->m10_com_sum)/17),1);
    //                 $value->m11_com_sum = round(0 - (($value->m11_com_sum)/17),1);
    //                 $value->m12_com_sum = round(0 - (($value->m12_com_sum)/17),1);
    //                 $value->sum = round(($value->m1_com_sum+$value->m2_com_sum+$value->m3_com_sum+$value->m4_com_sum+$value->m5_com_sum+$value->m6_com_sum+$value->m7_com_sum+$value->m8_com_sum+$value->m9_com_sum+$value->m10_com_sum+$value->m11_com_sum+$value->m12_com_sum)/12,1);

    //        }
    //     }




    //      $data = Datatables::of($unassigned)->make(true);
    //      return $data;
    // }

    // public function resourceGap(){

    // }
    public function getResources($year){
        // $arr = DB::table('activities')
        //         ->join('projects','activities.project_id','=','projects.id')
        //         ->join('users','activities.user_id','=','users.id')
        //         ->select('users.name','projects.project_name','activities.month','activities.task_hour')
        //         ->where('year','>','2020')
        //         ->get('users.name','projects.project_name','activities.month','activities.task_hour')
        //         ->sum('a.task_hour');

        // my query
        // SELECT u.domain, a.year, a.month,p.project_name,sum(a.task_hour) from activities as a INNER JOIN projects as p on a.project_id = p.id INNER JOIN users as u on a.user_id = u.id where a.year = 2020 AND p.project_name LIKE 'unassigned' GROUP BY u.domain , a.month

        $all_data_from_DB_project =  Activity::select('users.domain','activities.year','projects.project_name',
            DB::raw('SUM(CASE WHEN activities.month = 1 then activities.task_hour END) As Jan'),
            DB::raw('SUM(CASE WHEN activities.month = 2 then activities.task_hour END) As Feb'),
            DB::raw('SUM(CASE WHEN activities.month = 3 then activities.task_hour END) As Mar'),
            DB::raw('SUM(CASE WHEN activities.month = 4 then activities.task_hour END) As Apr'),
            DB::raw('SUM(CASE WHEN activities.month = 5 then activities.task_hour END) As May'),
            DB::raw('SUM(CASE WHEN activities.month = 6 then activities.task_hour END) As Jun'),
            DB::raw('SUM(CASE WHEN activities.month = 7 then activities.task_hour END) As Jul'),
            DB::raw('SUM(CASE WHEN activities.month = 8 then activities.task_hour END) As Aug'),
            DB::raw('SUM(CASE WHEN activities.month = 9 then activities.task_hour END) As Sep'),
            DB::raw('SUM(CASE WHEN activities.month = 10 then activities.task_hour END) As Oct'),
            DB::raw('SUM(CASE WHEN activities.month = 11 then activities.task_hour END) As Nov'),
            DB::raw('SUM(CASE WHEN activities.month = 12 then activities.task_hour END) As Des'))
        ->leftjoin('projects','projects.id','=','activities.project_id')
        ->leftjoin('users','users.id','=','activities.user_id')
        ->groupBy('users.domain')
        ->where('users.is_manager','=',0)
        ->where('activities.year','=',$year)
        ->where('projects.project_name','LIKE','unassigned')
        ->get();

        $all_data_from_DB_ZZZ = Activity::select('users.domain','activities.year','projects.project_name','users.name',
            DB::raw('SUM(CASE WHEN activities.month = 1 then activities.task_hour END) As Jan'),
            DB::raw('SUM(CASE WHEN activities.month = 2 then activities.task_hour END) As Feb'),
            DB::raw('SUM(CASE WHEN activities.month = 3 then activities.task_hour END) As Mar'),
            DB::raw('SUM(CASE WHEN activities.month = 4 then activities.task_hour END) As Apr'),
            DB::raw('SUM(CASE WHEN activities.month = 5 then activities.task_hour END) As May'),
            DB::raw('SUM(CASE WHEN activities.month = 6 then activities.task_hour END) As Jun'),
            DB::raw('SUM(CASE WHEN activities.month = 7 then activities.task_hour END) As Jul'),
            DB::raw('SUM(CASE WHEN activities.month = 8 then activities.task_hour END) As Aug'),
            DB::raw('SUM(CASE WHEN activities.month = 9 then activities.task_hour END) As Sep'),
            DB::raw('SUM(CASE WHEN activities.month = 10 then activities.task_hour END) As Oct'),
            DB::raw('SUM(CASE WHEN activities.month = 11 then activities.task_hour END) As Nov'),
            DB::raw('SUM(CASE WHEN activities.month = 12 then activities.task_hour END) As Des'))
        ->join('projects','projects.id','=','activities.project_id')
        ->join('users','users.id','=','activities.user_id')
        ->groupBy('users.domain')
        ->where('activities.year','=',$year)
        ->where('users.is_manager','=',0)
        ->where('users.name','LIKE','%ZZZ%')
        ->get();
        
        $dd =[];
        
        foreach ($all_data_from_DB_project as $key => $value) {
            // code...
            foreach ($all_data_from_DB_ZZZ as $key => $Zvalue) {
                // code...

                if($value->domain !== null){
                    if(str_contains($Zvalue->name,strtoupper($value->domain)) !== false){
                    $value->Jan = $value->Jan - $Zvalue->Jan;
                    $value->Feb = $value->Feb - $Zvalue->Feb;
                    $value->Mar = $value->Mar - $Zvalue->Mar;
                    $value->Apr = $value->Apr - $Zvalue->Apr;
                    $value->Jun = $value->Jun - $Zvalue->Jun;
                    $value->Jul = $value->Jul - $Zvalue->Jul;
                    $value->Aug = $value->Aug - $Zvalue->Aug;
                    $value->Sep = $value->Sep - $Zvalue->Sep;
                    $value->Oct = $value->Oct - $Zvalue->Oct;
                    $value->Nov = $value->Nov - $Zvalue->Nov;
                    $value->Des = $value->Des - $Zvalue->Des;


                    }
                }

            }
        }

     return json_encode($all_data_from_DB_project);

    }

    public function get_users_on_unassigned_by_practices(Request $request)
    {
        $domains = [];
        $input = $request->all();

         $unassigned = $this->activityRepository->list_gaps($input);

         return $unassigned;
        


    }
    public function get_projects_on_zzz_by_practices(Request $request)
    {
        $domains = [];
        $input = $request->all();

         $unassigned = $this->activityRepository->list_gaps_zzz($input);

         return $unassigned;
        
        

    }

}