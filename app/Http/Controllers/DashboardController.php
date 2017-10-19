<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Customer;
use App\Http\Controllers\Controller;
use DB;
use Entrust;
use Auth;
use Session;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\RevenueRepository;
use App\Http\Requests\DashboardCreateRequest;
use App\Http\Requests\DashboardUpdateRequest;
use App\Http\Controllers\Auth\AuthUsersForDataView;
use App\Repositories\ProjectTableRepository;

class DashboardController extends Controller {

  public function __construct()
  {

	}

  public function get_weekdays($m,$y) {
    $lastday = date("t",mktime(0,0,0,$m,1,$y));
    $weekdays=0;
    for($d=29;$d<=$lastday;$d++) {
        $wd = date("w",mktime(0,0,0,$m,$d,$y));
        if($wd > 0 && $wd < 6) $weekdays++;
        }
    return $weekdays+20;
    }

  public function load(AuthUsersForDataView $authUsersForDataView)
	{
    $authUsersForDataView->userCanView('tools-activity-all-view');

		return view('dashboard/load', compact('authUsersForDataView'));
	}

  public function load_chart(AuthUsersForDataView $authUsersForDataView)
	{
    $authUsersForDataView->userCanView('tools-activity-all-view');

		return view('dashboard/load_chart', compact('authUsersForDataView'));
	}

  public function clusterboard(AuthUsersForDataView $authUsersForDataView,UserRepository $userRepository,ActivityRepository $activityRepository,RevenueRepository $revenueRepository,$year = null,$customer_id = null)
  {
    $authUsersForDataView->userCanView('tools-activity-all-view');
    if ($year == null) {
      $year = date('Y');
    }
    //dd($year);
    $temp_table = new ProjectTableRepository('table_temp_a','table_temp_b');
    $customers = [];
    if (Auth::user()->clusterboard_top < 1) {
      $top = 5;
    } else {
      $top = Auth::user()->clusterboard_top;
    }
    $clusters = Auth::user()->clusters()->lists('cluster_owner');
    //dd($clusters);
    if (count($clusters) == 0) {
      $clusters = Customer::whereNotNull('cluster_owner')->groupBy('cluster_owner')->lists('cluster_owner');
      //dd($clusters);
    }
    $customers_list = Customer::where(function ($query) use ($clusters){
      foreach ($clusters as $cluster) {
        $query->orWhere('cluster_owner', $cluster);
      }
    })->lists('name','id');
    //dd($customers_list);
    
    if (is_null($customer_id)) {
      foreach ($clusters as $cluster) {
        $customers_temp = $activityRepository->getCustomersPerCluster($cluster,$year,$top);
        foreach ($customers_temp as $customer_temp) {
          array_push($customers,['name'=>$customer_temp->name,'cluster'=>$customer_temp->cluster_owner]);
        }
      }
    } else {
      $customer_temp = Customer::find($customer_id);
      array_push($customers,['name'=>$customer_temp->name,'cluster'=>$customer_temp->cluster_owner]);
    }

    //dd($customers);

    $activities = [];
    $revenues = [];
    $activities_tot = [];
    $revenues_tot = [];
    $grand_total = [];

    foreach ($customers as $customer) {
      // Activities
      if(!isset($activities[$customer['cluster']])){
        $activities[$customer['cluster']]= [];
        }
      if(!isset($activities[$customer['cluster']][$customer['name']])){
        $activities[$customer['cluster']][$customer['name']]= [];
        } 
      $activities_temp = $activityRepository->getActivitiesPerCustomer($customer['name'],$year,'table_temp_b');
      foreach ($activities_temp as $activitie_temp) {
        array_push($activities[$customer['cluster']][$customer['name']],$activitie_temp);
      }
      $activities_tot[$customer['name']] = $activityRepository->getActivitiesPerCustomerTot($customer['name'],$year,'table_temp_b');

      // Revenues
      if(!isset($revenues[$customer['name']])){
        $revenues[$customer['name']]= [];
        }
      $revenues_temp = $revenueRepository->getRevenuesPerCustomer($customer['name'],$year);
      foreach ($revenues_temp as $revenue_temp) {
        array_push($revenues[$customer['name']],$revenue_temp); 
      }
      $revenues_tot[$customer['name']] = $revenueRepository->getRevenuesPerCustomerTot($customer['name'],$year);

      // Grand total
      if(!isset($grand_total[$customer['name']])){
        $grand_total[$customer['name']]= [];
        }
      if (isset($revenues_tot[$customer['name']]) && isset($activities_tot[$customer['name']])) {
        $grand_total[$customer['name']]['revenue'] = floatval($revenues_tot[$customer['name']]->jan)
        + floatval($revenues_tot[$customer['name']]->feb)
        + floatval($revenues_tot[$customer['name']]->mar)
        + floatval($revenues_tot[$customer['name']]->apr)
        + floatval($revenues_tot[$customer['name']]->may)
        + floatval($revenues_tot[$customer['name']]->jun)
        + floatval($revenues_tot[$customer['name']]->jul)
        + floatval($revenues_tot[$customer['name']]->aug)
        + floatval($revenues_tot[$customer['name']]->sep)
        + floatval($revenues_tot[$customer['name']]->oct)
        + floatval($revenues_tot[$customer['name']]->nov)
        + floatval($revenues_tot[$customer['name']]->dec);
        $grand_total[$customer['name']]['activity'] = floatval($activities_tot[$customer['name']]->jan_com)
          + floatval($activities_tot[$customer['name']]->feb_com)
          + floatval($activities_tot[$customer['name']]->mar_com)
          + floatval($activities_tot[$customer['name']]->apr_com)
          + floatval($activities_tot[$customer['name']]->may_com)
          + floatval($activities_tot[$customer['name']]->jun_com)
          + floatval($activities_tot[$customer['name']]->jul_com)
          + floatval($activities_tot[$customer['name']]->aug_com)
          + floatval($activities_tot[$customer['name']]->sep_com)
          + floatval($activities_tot[$customer['name']]->oct_com)
          + floatval($activities_tot[$customer['name']]->nov_com)
          + floatval($activities_tot[$customer['name']]->dec_com);
        $grand_total[$customer['name']]['div'] = $grand_total[$customer['name']]['revenue']/$grand_total[$customer['name']]['activity'];
      }
      else {
        $grand_total[$customer['name']]['div'] = null;
      }
    }

    unset($temp_table);

    //dd($activities_tot);
    //dd($revenues_tot);
    //dd($grand_total);

    return view('dashboard/clusterboard', compact('authUsersForDataView','activities','revenues','activities_tot','revenues_tot','grand_total','top','year','customers_list','customer_id'));
  }

}
