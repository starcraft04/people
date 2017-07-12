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
use App\Http\Requests\DashboardCreateRequest;
use App\Http\Requests\DashboardUpdateRequest;
use App\Http\Controllers\Auth\AuthUsersForDataView;

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
    Session::put('url','dashboard-all-view');

		return view('dashboard/load', compact('authUsersForDataView'));
	}

  public function load_chart(AuthUsersForDataView $authUsersForDataView)
	{
    $authUsersForDataView->userCanView('tools-activity-all-view');
    Session::put('url','dashboard-all-view');

		return view('dashboard/load_chart', compact('authUsersForDataView'));
	}

}
