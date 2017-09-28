<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
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

  public function clusterboard(UserRepository $userRepository,ActivityRepository $activityRepository,RevenueRepository $revenueRepository)
  {
    $temp_table = new ProjectTableRepository('table_temp_a','table_temp_b');
    $countries = $userRepository->getCountries(Auth::user()->id);
    $customers = [];

    foreach ($countries as $country) {
      $customers_temp = $activityRepository->getCustomersPerCountry($country,5);
      foreach ($customers_temp as $customer_temp) {
        array_push($customers,['name'=>$customer_temp->name,'country'=>$customer_temp->country]);
      }
    }

    //dd($customers);

    $activities = [];
    $revenues = [];


    foreach ($customers as $customer) {
      if(!isset($activities[$customer['country']])){
        $activities[$customer['country']]= [];
        }
      if(!isset($activities[$customer['country']][$customer['name']])){
        $activities[$customer['country']][$customer['name']]= [];
        } 
      $activities_temp = $activityRepository->getActivitiesPerCustomer($customer['name'],'table_temp_b');
      foreach ($activities_temp as $activitie_temp) {
        array_push($activities[$customer['country']][$customer['name']],$activitie_temp);
      }

      if(!isset($revenues[$customer['name']])){
        $revenues[$customer['name']]= [];
        }
      $revenues_temp = $revenueRepository->getRevenuesPerCustomer($customer['name']);
      foreach ($revenues_temp as $revenue_temp) {
        array_push($revenues[$customer['name']],$revenue_temp); 
      }
    }

    unset($temp_table);

    //dd($revenues);

    return view('dashboard/clusterboard', compact('activities','revenues'));
  }

}
