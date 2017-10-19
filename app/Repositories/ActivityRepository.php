<?php

namespace App\Repositories;

use App\Activity;
use Datatables;
use DB;
use Entrust;
use Auth;
use App\Repositories\UserRepository;
use App\Repositories\ProjectTableRepository;

class ActivityRepository
{

  protected $activity;
  protected $userRepository;

  public function __construct(Activity $activity,UserRepository $userRepository)
  {
    $this->activity = $activity;
    $this->userRepository = $userRepository;
  }

  public function getById($id)
  {
    return $this->activity->findOrFail($id);
  }

  public function getByOTL($year,$user_id,$project_id, $from_otl)
  {
    return $this->activity->where('year', $year)->where('user_id', $user_id)->where('project_id', $project_id)->where('from_otl', $from_otl)->lists('task_hour','month');
  }

  public function checkIfExists($inputs)
  {
    return $this->activity
                    ->where('year', $inputs['year'])
                    ->where('month', $inputs['month'])
                    ->where('user_id', $inputs['user_id'])
                    ->where('project_id', $inputs['project_id'])
                    ->where('from_otl', $inputs['from_otl'])
                    ->first();
  }

  public function user_assigned_on_project($year,$user_id,$project_id)
  {
    return $this->activity->where('year', $year)->where('user_id', $user_id)->where('project_id', $project_id)->count();
  }

  public function create(Array $inputs)
  {
    $activity = new $this->activity;
    return $this->save($activity, $inputs);
  }

  public function update($id, Array $inputs)
  {
    return $this->save($this->getById($id), $inputs);
  }

  public function createOrUpdate($inputs)
  {
    $activity = $this->activity
            ->where('year', $inputs['year'])
            ->where('month',   $inputs['month'])
            ->where('project_id', $inputs['project_id'])
            ->where('user_id', $inputs['user_id'])
            ->where('from_otl', '1')
            ->first();

    if (!empty($activity)){
      return $activity;
    } else {
      $activity = $this->activity
              ->where('year', $inputs['year'])
              ->where('month',   $inputs['month'])
              ->where('project_id', $inputs['project_id'])
              ->where('user_id', $inputs['user_id'])
              ->first();
      if (empty($activity)){
        $activity = new $this->activity;
      }
      return $this->save($activity, $inputs);
    }
  }

  public function assignNewUser($old_user,$inputs)
  {
    $activity = $this->activity
            ->where('year', $inputs['year'])
            ->where('month',   $inputs['month'])
            ->where('project_id', $inputs['project_id'])
            ->where('user_id', $old_user)
            ->where('from_otl', '0')
            ->first();

    return $this->save($activity, $inputs);
  }

  public function removeUserFromProject($user_id,$project_id)
  {
    $activity = $this->activity
            ->where('project_id', $project_id)
            ->where('user_id', $user_id)
            ->delete();

    return $activity;
  }

  private function save(Activity $activity, Array $inputs)
  {
    // Required fields
    if (isset($inputs['year'])) {$activity->year = $inputs['year'];}
    if (isset($inputs['month'])) {$activity->month = $inputs['month'];}
    if (isset($inputs['project_id'])) {$activity->project_id = $inputs['project_id'];}
    if (isset($inputs['user_id'])) {$activity->user_id = $inputs['user_id'];}
    if (isset($inputs['task_hour'])) {$activity->task_hour = $inputs['task_hour'];}

    // Boolean
    if (isset($inputs['from_otl'])) {$activity->from_otl = $inputs['from_otl'];}

    $activity->save();

    return $activity;
  }

  public function destroy($id)
  {
    $activity = $this->getById($id);
    $activity->delete();

    return $activity;
  }

  public function getListOfActivities()
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $activityList = DB::table('activities')
    ->select( 'activities.id', 'activities.year','activities.month','activities.task_hour','activities.from_otl',
    'activities.project_id','projects.project_name','activities.user_id','users.name')
    ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
    ->leftjoin('users', 'users.id', '=', 'activities.user_id');
    $data = Datatables::of($activityList)->make(true);
    return $data;
  }
  public function getListOfActivitiesPerUser($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/


    $temp_table = new ProjectTableRepository('table_temp_a','table_temp_b');

    $activityList = DB::table('table_temp_b');

    $activityList->select('manager_id','manager_name','user_id','user_name','project_id','project_name','customer_name','year','activity_type','project_status','project_type',
                          'jan_com','jan_otl','feb_com','feb_otl','mar_com','mar_otl','apr_com','apr_otl','may_com','may_otl','jun_com','jun_otl',
                          'jul_com','jul_otl','aug_com','aug_otl','sep_com','sep_otl','oct_com','oct_otl','nov_com','nov_otl','dec_com','dec_otl'

    );

    // Checking which year to display
    if (!empty($where['year']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['year'] as $w)
                {
                    $query->orWhere('year',$w);
                }
            });
        }

    if (!empty($where['checkbox_closed']) && $where['checkbox_closed'] == 1)
    {
        $activityList->where(function($query) {
            return $query->where('project_status', '!=', 'Closed')
                    ->orWhereNull('project_status');
        }
        );
    }

    // Checking the roles to see if allowed to see all users
    if (Entrust::can('tools-activity-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      // Checking which users to show from the manager list
      if (!empty($where['user']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['user'] as $w)
                  {
                      $query->orWhere('user_id',$w);
                  }
              });
          }
      elseif (!empty($where['manager']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['manager'] as $w)
                  {
                      $query->orWhere('manager_id',$w);
                  }
              });
          }

    }
    // If the authenticated user is a manager, he can see his employees by default
    elseif (Auth::user()->is_manager == 1) {
        if (!isset($where['user'])) {
            $activityList->where('manager_id','=',Auth::user()->id);
        }
      
        if (!empty($where['user']))
            {
                $activityList->where(function ($query) use ($where) {
                    foreach ($where['user'] as $w)
                    {
                        $query->orWhere('user_id',$w);
                    }
                });
            }
    }
    // In the end, the user is not a manager and doesn't have a special role so he can only see himself
    else {
      $activityList->where('user_id','=',Auth::user()->id);
    }

    $activityList->groupBy('manager_id','manager_name','user_id','user_name','project_id','project_name','year');

    $data = Datatables::of($activityList)->make(true);

    // Destroying the object so it will remove the 2 temp tables created
    unset($temp_table);

    return $data;
  }

  public function getlistOfLoadPerUser($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $temp_table = new ProjectTableRepository('table_temp_a','table_temp_b');

    $activityList = DB::table('table_temp_b');

    $activityList->select('manager_id','manager_name','user_id','user_name','year',
                            DB::raw('ROUND(SUM(jan_com),1) AS jan_com'),
                            DB::raw('ROUND(SUM(feb_com),1) AS feb_com'),
                            DB::raw('ROUND(SUM(mar_com),1) AS mar_com'),
                            DB::raw('ROUND(SUM(apr_com),1) AS apr_com'),
                            DB::raw('ROUND(SUM(may_com),1) AS may_com'),
                            DB::raw('ROUND(SUM(jun_com),1) AS jun_com'),
                            DB::raw('ROUND(SUM(jul_com),1) AS jul_com'),
                            DB::raw('ROUND(SUM(aug_com),1) AS aug_com'),
                            DB::raw('ROUND(SUM(sep_com),1) AS sep_com'),
                            DB::raw('ROUND(SUM(oct_com),1) AS oct_com'),
                            DB::raw('ROUND(SUM(nov_com),1) AS nov_com'),
                            DB::raw('ROUND(SUM(dec_com),1) AS dec_com')
    );

    if (!empty($where['year']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['year'] as $w)
                {
                    $query->orWhere('year',$w);
                }
            });
        }

    if (!empty($where['meta_activity']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['meta_activity'] as $w)
                {
                    $query->orWhere('meta_activity',$w);
                }
            });
        }

    if (!empty($where['project_status']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['project_status'] as $w)
                {
                    $query->orWhere('project_status',$w);
                }
            });
        }

    if (!empty($where['project_type']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['project_type'] as $w)
                {
                    $query->orWhere('project_type',$w);
                }
            });
        }

    // Checking the roles to see if allowed to see all users
    if (Entrust::can('dashboard-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      if (!empty($where['user']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['user'] as $w)
                  {
                      $query->orWhere('user_id',$w);
                  }
              });
          }
      elseif (!empty($where['manager']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['manager'] as $w)
                  {
                      $query->orWhere('manager_id',$w);
                  }
              });
          }

    }
    elseif (Auth::user()->is_manager == 1) {
      $activityList->where('manager_id','=',Auth::user()->id);
      if (!empty($where['user']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['user'] as $w)
                  {
                      $query->orWhere('user_id',$w);
                  }
              });
          }
    }
    else {
      $activityList->where('user_id','=',Auth::user()->id);
    }

    $activityList->groupBy('manager_id','manager_name','user_id','user_name','year');

    $data = Datatables::of($activityList)->make(true);

    unset($temp_table);

    return $data;
  }

  public function getListOfLoadPerUserChart($where = null,$where_raw)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $data = 0;
    
    $activityList = DB::table('table_temp_b');

    $activityList->select('year',
                            DB::raw('SUM(jan_com) AS jan_com'),
                            DB::raw('SUM(feb_com) AS feb_com'),
                            DB::raw('SUM(mar_com) AS mar_com'),
                            DB::raw('SUM(apr_com) AS apr_com'),
                            DB::raw('SUM(may_com) AS may_com'),
                            DB::raw('SUM(jun_com) AS jun_com'),
                            DB::raw('SUM(jul_com) AS jul_com'),
                            DB::raw('SUM(aug_com) AS aug_com'),
                            DB::raw('SUM(sep_com) AS sep_com'),
                            DB::raw('SUM(oct_com) AS oct_com'),
                            DB::raw('SUM(nov_com) AS nov_com'),
                            DB::raw('SUM(dec_com) AS dec_com')
    );

    if (!empty($where['year']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['year'] as $w)
                {
                    $query->orWhere('year',$w);
                }
            });
        }

    // Checking the roles to see if allowed to see all users
    if (Entrust::can('dashboard-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      if (!empty($where['user']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['user'] as $w)
                  {
                      $query->orWhere('user_id',$w);
                  }
              });
          }
      elseif (!empty($where['manager']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['manager'] as $w)
                  {
                      $query->orWhere('manager_id',$w);
                  }
              });
          }
    }
    elseif (Auth::user()->is_manager == 1) {
      $activityList->where('manager_id','=',Auth::user()->id);
      if (!empty($where['user']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['user'] as $w)
                  {
                      $query->orWhere('user_id',$w);
                  }
              });
          }
    }
    else {
      $activityList->where('user_id','=',Auth::user()->id);
    }

    if (!empty($where_raw)) {
      $activityList->whereRaw($where_raw);
    }

    //dd($activityList->toSql());

    $data = $activityList->get();

    // This is in case we don't find any record then we put everything to 0
    $activityList->groupBy('year');
    if ($data [0]->year == null){
      $data [0]->year = $where['year'][0];
      $data [0]->jan_com = 0;
      $data [0]->feb_com = 0;
      $data [0]->mar_com = 0;
      $data [0]->apr_com = 0;
      $data [0]->may_com = 0;
      $data [0]->jun_com = 0;
      $data [0]->jul_com = 0;
      $data [0]->aug_com = 0;
      $data [0]->sep_com = 0;
      $data [0]->oct_com = 0;
      $data [0]->nov_com = 0;
      $data [0]->dec_com = 0;
    }

    return $data;
  }

  public function getListOfActivitiesPerUserForProject($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $temp_table = new ProjectTableRepository('table_temp_a','table_temp_b');

    $activityList = DB::table('table_temp_b');

    $activityList->select('manager_id','manager_name','user_id','user_name','user_employee_type','project_id','project_name','customer_name','year',
                          DB::Raw('(jan_com+feb_com+mar_com+apr_com+may_com+jun_com+
                          jul_com+aug_com+sep_com+oct_com+nov_com+dec_com) AS LoE')

    );

    if (!empty($where['project_id']))
        {
          $activityList->where('project_id','=',$where['project_id']);
        };

    if (!empty($where['employee_type']))
        {
          $activityList->where('user_employee_type','=',$where['employee_type']);
        };


    $activityList->groupBy('manager_id','user_id','project_id','year');
    $data = $activityList->get();
    // Destroying the object so it will remove the 2 temp tables created
    unset($temp_table);

    return $data;
  }

  public function getNumberOfOTLPerUserAndProject($user_id,$project_id){
    return $this->activity->where('user_id', $user_id)->where('project_id', $project_id)->where('from_otl',1)->count();
  }

  public function getNumberPerUserAndProject($user_id,$project_id){
    return $this->activity->where('user_id', $user_id)->where('project_id', $project_id)->count();
  }

  public function test()
  {

    /*
    This select will get a temporary table with all the records where if from_otl=0
    then it will check if there is not a record with from_otl=1 and
    if yes, will not include it.
     */

    $temp_table = new ProjectTableRepository('table_temp_a','table_temp_b');


    $activity = DB::table('table_temp_b')
    ->select('year','user_id',
        DB::raw('SUM(jan_com) AS jan_com'),
        DB::raw('SUM(feb_com) AS feb_com'),
        DB::raw('SUM(mar_com) AS mar_com'),
        DB::raw('SUM(apr_com) AS apr_com'),
        DB::raw('SUM(may_com) AS may_com'),
        DB::raw('SUM(jun_com) AS jun_com'),
        DB::raw('SUM(jul_com) AS jul_com'),
        DB::raw('SUM(aug_com) AS aug_com'),
        DB::raw('SUM(sep_com) AS sep_com'),
        DB::raw('SUM(oct_com) AS oct_com'),
        DB::raw('SUM(nov_com) AS nov_com'),
        DB::raw('SUM(dec_com) AS dec_com')
        )
    ->where('project_type','=','Project')
    ->where(function($query){
      $query->where('user_id','=','15');
      $query->orWhere('user_id','=','16');
    })
    ->groupBy('year','user_id')
    ->orderBy('user_id')
    ->get();

    $activity2 = DB::table('table_temp_b')
    ->where(function($query){
      $query->where('user_id','=','15');
      $query->orWhere('user_id','=','16');
    })
    ->get();
    $result = $activity2;

    dd($result);
  }

    public function getCustomersPerCluster($cluster,$year,$limit)
    {
        $customers = DB::table('projects');

        $customers->select('customers.name',DB::raw('sum(task_hour)'),'customers.cluster_owner');
        $customers->leftjoin('activities','activities.project_id', '=' ,'projects.id');
        $customers->leftjoin('customers','projects.customer_id', '=' ,'customers.id');
        $customers->where('customers.cluster_owner','=',$cluster);
        $customers->where('activities.year','=',$year);
        $customers->groupBy('customers.name');
        $customers->orderBy(DB::raw('sum(task_hour)'),'DESC');
        $customers->limit($limit);
        $data = $customers->get();
        return $data;
    }
    public function getActivitiesPerCustomer($customer_name,$year,$temp_table)
    {

        $activityList = DB::table($temp_table);
        $activityList->where('customer_name','=',$customer_name);
        $activityList->where('year','=',$year);
        $activityList->orderBy('country','customer_name','project_name');
        //$activityList->groupBy('project_name','user_name');
        $data = $activityList->get();
        
        return $data;
    }
    public function getActivitiesPerCustomerTot($customer_name,$year,$temp_table)
    {

        $activityList = DB::table($temp_table);
        $activityList->select('year',DB::raw('sum(jan_com) AS jan_com')
                                    ,DB::raw('sum(feb_com) AS feb_com')
                                    ,DB::raw('sum(mar_com) AS mar_com')
                                    ,DB::raw('sum(apr_com) AS apr_com')
                                    ,DB::raw('sum(may_com) AS may_com')
                                    ,DB::raw('sum(jun_com) AS jun_com')
                                    ,DB::raw('sum(jul_com) AS jul_com')
                                    ,DB::raw('sum(aug_com) AS aug_com')
                                    ,DB::raw('sum(sep_com) AS sep_com')
                                    ,DB::raw('sum(oct_com) AS oct_com')
                                    ,DB::raw('sum(nov_com) AS nov_com')
                                    ,DB::raw('sum(dec_com) AS dec_com'));
        $activityList->where('customer_name','=',$customer_name);
        $activityList->where('year','=',$year);
        $activityList->groupBy('customer_name');
        $activityList->orderBy('country','customer_name');
        $data = $activityList->first();
        //dd($data);
        
        return $data;
    }

}