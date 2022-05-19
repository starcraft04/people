<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
use Session;

class skillbaseApiController extends Controller
{
    //

    public function listOfActiveUsers()
    {
        $activeUsers = User::where('activity_status','active')->get(['name','email','pimsid','ftid','management_code','activity_status'])->toArray();
        return json_encode($activeUsers);
    }

//List of Users skills
    public function listOfUserSkillsAPI(Request $request)
    {
        if(isset($request->email)){
            $skillList = DB::table('skills')
          ->select( 'skills.domain', 'skills.subdomain', 'skills.technology', 'skills.skill', 'm.name AS manager_name', 'm.email AS manager_email', 'u.email AS user_email', 'u.name AS user_name','u.activity_status AS user_activity', 'u.region', 'u.country','u.pimsid','u.ftid','u.job_role', 'u.employee_type', 'skill_user.rating', 'skills.id AS skill_id')
          ->leftjoin('skill_user', 'skills.id', '=', 'skill_user.skill_id')
          ->leftjoin('users AS u', 'u.id', '=', 'skill_user.user_id')
          ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
          ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
          ->where(array(
            'skills.certification'=>0,
            'u.email'=>$request->email,
        ))->get();
        return json_encode($skillList);


  }else{
    $skillList = array(
        'Respond'=>'please provide an email',
    );
    return json_encode($skillList);


  }
        
        // if (! Auth::user()->can('tools-usersskills-view-all')) {
        //     $skillList->where('u.id', '=', Auth::user()->id);
        // // }
        // $data = Datatables::of($skillList)->make(true);

    }

public function listOfUserCertificatesAPI(Request $request)
    {

       if(isset($request->email)){
            $skillList = DB::table('skills')
          ->select( 'skills.domain', 'skills.subdomain', 'skills.technology', 'skills.skill', 'm.name AS manager_name', 'm.email AS manager_email', 'u.email AS user_email', 'u.name AS user_name','u.activity_status AS user_activity', 'u.region', 'u.country','u.pimsid','u.ftid','u.job_role', 'u.employee_type', 'skill_user.rating', 'skills.id AS skill_id')
          ->leftjoin('skill_user', 'skills.id', '=', 'skill_user.skill_id')
          ->leftjoin('users AS u', 'u.id', '=', 'skill_user.user_id')
          ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
          ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
          ->where(array(
            'skills.certification'=>1,
            'u.email'=>$request->email,
        ))->get();
        return json_encode($skillList);


  }else{
    $skillList = array(
        'Respond'=>'please provide an email',
    );
    return json_encode($skillList);


  }
    }



public function activeUserCertificatesAPI()
    {

        $skillList = DB::table('skills')
          ->select( 'skills.domain','skills.created_at','skills.subdomain', 'skills.technology', 'skills.skill', 'm.name AS manager_name', 'm.email AS manager_email', 'u.email AS user_email', 'u.name AS user_name','u.management_code AS management_code','u.activity_status AS user_activity', 'u.region', 'u.country','u.pimsid','u.ftid','u.job_role', 'u.employee_type', 'skill_user.rating', 'skills.id AS skill_id')
          ->leftjoin('skill_user', 'skills.id', '=', 'skill_user.skill_id')
          ->leftjoin('users AS u', 'u.id', '=', 'skill_user.user_id')
          ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
          ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
          ->where(array(
            'skills.certification'=>1,
            'u.activity_status'=>'active',
        ))->get()->toArray();


      return json_encode($skillList);

    }


//add active people for both
    public function activeUserCertificatesAPIDashboard()
    {

        $skillList = DB::table('skills')
          ->select( 'skills.domain','skills.created_at','skills.subdomain', 'skills.technology', 'skills.skill', 'm.name AS manager_name', 'm.email AS manager_email', 'u.email AS user_email', 'u.name AS user_name','u.management_code AS management_code','u.activity_status AS user_activity', 'u.region', 'u.country','u.pimsid','u.ftid','u.job_role', 'u.employee_type', 'skill_user.rating', 'skills.id AS skill_id')
          ->leftjoin('skill_user', 'skills.id', '=', 'skill_user.skill_id')
          ->leftjoin('users AS u', 'u.id', '=', 'skill_user.user_id')
          ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
          ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
          ->where(array(
            'skills.certification'=>1
        ))->get()->toArray();


      return json_encode($skillList);

    }

    public function activeUserSkillsAPIDashboard()
    {

        $skillList = DB::table('skills')
          ->select( 'skills.domain','skills.created_at','skills.subdomain', 'skills.technology', 'skills.skill', 'm.name AS manager_name', 'm.email AS manager_email', 'u.email AS user_email', 'u.name AS user_name','u.management_code AS management_code','u.activity_status AS user_activity', 'u.region', 'u.country','u.pimsid','u.ftid','u.job_role', 'u.employee_type', 'skill_user.rating', 'skills.id AS skill_id')
          ->leftjoin('skill_user', 'skills.id', '=', 'skill_user.skill_id')
          ->leftjoin('users AS u', 'u.id', '=', 'skill_user.user_id')
          ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
          ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
          ->where(array(
            'skills.certification'=>0
        ))->get()->toArray();


      return json_encode($skillList);

    }



public function activeUserSkillsAPI()
    {

        $skillList = DB::table('skills')
          ->select( 'skills.domain','skills.created_at','skills.subdomain','skills.created_at','skills.created_at','skills.technology', 'skills.skill', 'm.name AS manager_name', 'm.email AS manager_email', 'u.email AS user_email', 'u.name AS user_name','u.management_code AS management_code','u.activity_status AS user_activity', 'u.region', 'u.country','u.pimsid','u.ftid','u.job_role', 'u.employee_type', 'skill_user.rating', 'skills.id AS skill_id')
          ->leftjoin('skill_user', 'skills.id', '=', 'skill_user.skill_id')
          ->leftjoin('users AS u', 'u.id', '=', 'skill_user.user_id')
          ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
          ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
          ->where(array(
            'skills.certification'=>0,
            'u.activity_status'=>'active',
        ))->get()->toArray();


      return json_encode($skillList);

    }






}
