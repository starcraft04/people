<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\Auth\AuthUsersForDataView;
use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardCreateRequest;
use App\Http\Requests\DashboardUpdateRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectTableRepository;
use App\Repositories\RevenueRepository;
use App\Repositories\UserRepository;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function get_weekdays($m, $y)
    {
        $lastday = date('t', mktime(0, 0, 0, $m, 1, $y));
        $weekdays = 0;
        for ($d = 29; $d <= $lastday; $d++) {
            $wd = date('w', mktime(0, 0, 0, $m, $d, $y));
            if ($wd > 0 && $wd < 6) {
                $weekdays++;
            }
        }

        return $weekdays + 20;
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

    public function dscisc(AuthUsersForDataView $authUsersForDataView, $year)
    {
        $authUsersForDataView->userCanView('tools-activity-all-view');
        $managers = config('reports.dscisc_report_managers');
        //dd($managers);
        $dscvsisc = [];
        foreach ($managers as $manager_name) {
            $dscvsisc[$manager_name] = [];
            $manager = User::where('name', $manager_name)->first();
            $employee_list = $manager->employees()->pluck('name', 'users.id');
            foreach ($employee_list as $employee_id => $employee_name) {
                $totalworkdays = DB::table('activities')
          ->select(DB::raw('SUM(activities.task_hour) as sum_task'))
          ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
          ->where('year', $year)
          ->where('activities.user_id', $employee_id)
          ->where('projects.activity_type', '!=', 'Orange absence or other')
          ->first()->sum_task;
                if ($totalworkdays == 0) {
                    continue;
                }
                $dscvsisc[$manager_name][$employee_name] = [];
                $dscvsisc[$manager_name][$employee_name]['totalworkdays'] = $totalworkdays;
                $totaliscdays = DB::table('activities')
          ->select(DB::raw('SUM(activities.task_hour) as sum_task'))
          ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
          ->where('year', $year)
          ->where('activities.user_id', $employee_id)
          ->where('projects.activity_type', 'ISC')
          ->first()->sum_task * 100 / $totalworkdays;
                $dscvsisc[$manager_name][$employee_name]['totaliscdays'] = $totaliscdays;
                $totaldscdays = DB::table('activities')
          ->select(DB::raw('SUM(activities.task_hour) as sum_task'))
          ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
          ->where('year', $year)
          ->where('activities.user_id', $employee_id)
          ->where('projects.activity_type', 'ASC')
          ->first()->sum_task * 100 / $totalworkdays;
                $dscvsisc[$manager_name][$employee_name]['totaldscdays'] = $totaldscdays;
                $dsclist = DB::table('activities')
          ->select('customers.name', 'projects.activity_type', DB::raw('((SUM(activities.task_hour)*100)/'.$totalworkdays.') as sum_task'))
          ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
          ->leftjoin('customers', 'projects.customer_id', '=', 'customers.id')
          ->where('year', $year)
          ->where('activities.user_id', $employee_id)
          ->where('projects.activity_type', 'ASC')
          ->groupBy('customers.name', 'projects.activity_type')
          ->get();
                $dscvsisc[$manager_name][$employee_name]['dsclist'] = $dsclist;
                $isclist = DB::table('activities')
          ->select('customers.name', 'projects.activity_type', DB::raw('((SUM(activities.task_hour)*100)/'.$totalworkdays.') as sum_task'))
          ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
          ->leftjoin('customers', 'projects.customer_id', '=', 'customers.id')
          ->where('year', $year)
          ->where('activities.user_id', $employee_id)
          ->where('projects.activity_type', 'ISC')
          ->groupBy('customers.name', 'projects.activity_type')
          ->get();
                $dscvsisc[$manager_name][$employee_name]['isclist'] = $isclist;
            }
        }
        //dd($dscvsisc);
        return view('dashboard/dscisc', compact('authUsersForDataView', 'year', 'dscvsisc'));
    }

    public function clusterboard(AuthUsersForDataView $authUsersForDataView, UserRepository $userRepository, ActivityRepository $activityRepository, RevenueRepository $revenueRepository, $year = null, $customer_id = 0, $domain_selected = 'all',$manager_id = 0, $user_id = 0)
    {
        if (!Auth::user()->can('cluster-view-all')) {
            $customer_id = 0;
            $user_id = Auth::user()->id;
            $manager_id = Auth::user()->managers()->first()->id;
            $customer_disabled = 'true';
            $user_disabled = 'true';
            $manager_disabled = 'true';
        } else {
            $customer_disabled = 'false';
            $user_disabled = 'false';
            $manager_disabled = 'false';
        }
        $authUsersForDataView->userCanView('tools-activity-all-view');
        if ($manager_id != 0) {
            $authUsersForDataView->manager_selected = $manager_id;
        }
        if ($user_id != 0) {
            $authUsersForDataView->user_selected = $user_id;
        }
        //dd($authUsersForDataView->year_list);
        if ($year == null) {
            $year = date('Y');
        }
        //dd($year);
        $temp_table = new ProjectTableRepository('table_temp_a');
        $customers = [];
        if (Auth::user()->clusterboard_top < 1) {
            $top = 15;
        } else {
            $top = Auth::user()->clusterboard_top;
        }
        $clusters = Auth::user()->clusters()->pluck('cluster_owner');
        //dd($clusters);
        if (count($clusters) == 0) {
            $clusters = Customer::whereNotNull('cluster_owner')->groupBy('cluster_owner')->pluck('cluster_owner');
            //dd($clusters);
        }
        $customers_list = Customer::where(function ($query) use ($clusters) {
            foreach ($clusters as $cluster) {
                $query->orWhere('cluster_owner', $cluster);
            }
        })->pluck('name', 'id');
        //dd($customers_list);

        // Here we get the list of users in cas the manager is selected
        if ($manager_id == 0 && $user_id == 0) {
            $users_list = [];
        } elseif ($manager_id == 0) {
            $users_list = [$user_id];
        } elseif ($user_id == 0) {
            $users_list_temp = User::find($manager_id)->employees()->pluck('users.id')->toArray();
            $users_list = [$manager_id];
            foreach ($users_list_temp as $user) {
                array_push($users_list,$user);
            }
        } else {
            $users_list = [$user_id];
        }

        //dd($users_list);

        if ($customer_id == 0) {
            foreach ($clusters as $cluster) {
                $customers_temp = $activityRepository->getCustomersPerCluster($cluster, $year, $top, $domain_selected,$users_list);
                foreach ($customers_temp as $customer_temp) {
                    array_push($customers, ['name'=>$customer_temp->name, 'cluster'=>$customer_temp->cluster_owner]);
                }
            }
        } else {
            $customer_temp = Customer::find($customer_id);
            array_push($customers, ['name'=>$customer_temp->name, 'cluster'=>$customer_temp->cluster_owner]);
        }

        //dd($customers);

        $activities = [];
        $revenues = [];
        $activities_tot = [];
        $revenues_tot = [];
        $grand_total = [];

        foreach ($customers as $customer) {
            // Activities
            if (! isset($activities[$customer['cluster']])) {
                $activities[$customer['cluster']] = [];
            }
            if (! isset($activities[$customer['cluster']][$customer['name']])) {
                $activities[$customer['cluster']][$customer['name']] = [];
            }
            $activities_temp = $activityRepository->getActivitiesPerCustomer($customer['name'], $year, 'table_temp_a', $domain_selected);
            //dd($activities_temp);
            foreach ($activities_temp as $activitie_temp) {
                $activitie_temp->h1 = $activitie_temp->jan_com + $activitie_temp->feb_com + $activitie_temp->mar_com + $activitie_temp->apr_com + $activitie_temp->may_com + $activitie_temp->jun_com;
                $activitie_temp->h2 = $activitie_temp->jul_com + $activitie_temp->aug_com + $activitie_temp->sep_com + $activitie_temp->oct_com + $activitie_temp->nov_com + $activitie_temp->dec_com;
                $activitie_temp->full_year = $activitie_temp->h1 + $activitie_temp->h2;
                array_push($activities[$customer['cluster']][$customer['name']], $activitie_temp);
            }
            $activities_tot[$customer['name']] = $activityRepository->getActivitiesPerCustomerTot($customer['name'], $year, 'table_temp_a', $domain_selected);
            //dd($activities_tot);
            if (!empty($activities_tot[$customer['name']])) {
                $activities_tot[$customer['name']]->h1 = $activities_tot[$customer['name']]->jan_com + $activities_tot[$customer['name']]->feb_com + $activities_tot[$customer['name']]->mar_com + $activities_tot[$customer['name']]->apr_com + $activities_tot[$customer['name']]->may_com + $activities_tot[$customer['name']]->jun_com;
                $activities_tot[$customer['name']]->h2 = $activities_tot[$customer['name']]->jul_com + $activities_tot[$customer['name']]->aug_com + $activities_tot[$customer['name']]->sep_com + $activities_tot[$customer['name']]->oct_com + $activities_tot[$customer['name']]->nov_com + $activities_tot[$customer['name']]->dec_com;
                $activities_tot[$customer['name']]->full_year = $activities_tot[$customer['name']]->h1 + $activities_tot[$customer['name']]->h2;
            }
            

            // Revenues
            if (! isset($revenues[$customer['name']])) {
                $revenues[$customer['name']] = [];
            }
            $revenues_temp = $revenueRepository->getRevenuesPerCustomer($customer['name'], $year, $domain_selected);
            //dd($revenues_temp);
            foreach ($revenues_temp as $revenue_temp) {
                $revenue_temp->h1 = $revenue_temp->jan + $revenue_temp->feb + $revenue_temp->mar + $revenue_temp->apr + $revenue_temp->may + $revenue_temp->jun;
                $revenue_temp->h2 = $revenue_temp->jul + $revenue_temp->aug + $revenue_temp->sep + $revenue_temp->oct + $revenue_temp->nov + $revenue_temp->dec;
                $revenue_temp->full_year = $revenue_temp->h1 + $revenue_temp->h2;
                array_push($revenues[$customer['name']], $revenue_temp);
            }
            
            $revenues_tot[$customer['name']] = $revenueRepository->getRevenuesPerCustomerTot($customer['name'], $year, $domain_selected);
            if (isset($revenues_tot[$customer['name']])) {
                $revenues_tot[$customer['name']]->h1 = $revenues_tot[$customer['name']]->jan + $revenues_tot[$customer['name']]->feb + $revenues_tot[$customer['name']]->mar + $revenues_tot[$customer['name']]->apr + $revenues_tot[$customer['name']]->may + $revenues_tot[$customer['name']]->jun;
                $revenues_tot[$customer['name']]->h2 = $revenues_tot[$customer['name']]->jul + $revenues_tot[$customer['name']]->aug + $revenues_tot[$customer['name']]->sep + $revenues_tot[$customer['name']]->oct + $revenues_tot[$customer['name']]->nov + $revenues_tot[$customer['name']]->dec;
                $revenues_tot[$customer['name']]->full_year = $revenues_tot[$customer['name']]->h1 + $revenues_tot[$customer['name']]->h2;
            }
            
            //dd($revenues_tot);

            // Grand total
            if (! isset($grand_total[$customer['name']])) {
                $grand_total[$customer['name']] = [];
            }
            if (isset($revenues_tot[$customer['name']])) {
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
            } else {
                $grand_total[$customer['name']]['revenue'] = 0;
            }
            if (isset($activities_tot[$customer['name']])) {
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
                
            } else {
                $grand_total[$customer['name']]['activity'] = 0;
            }
        }
        
        unset($temp_table);

        //dd($activities);
        //dd($activities_tot);
        //dd($revenues);
        //dd($revenues_tot);
        //dd($grand_total);

        return view('dashboard/clusterboard', compact('authUsersForDataView', 'activities', 'revenues', 'activities_tot', 'revenues_tot', 'grand_total', 'top', 'year', 'customers_list', 'customer_id', 'domain_selected',
                                                        'customer_disabled','manager_disabled','user_disabled'
        ));
    }

    public function revenue(AuthUsersForDataView $authUsersForDataView, UserRepository $userRepository, $year = null, $user_id = null)
    {
        $authUsersForDataView->userCanView('tools-activity-all-view');
        $table_height = Auth::user()->table_height;
        Session::put('url', 'revenuedashboard');

        if ($year == null) {
            $year = date('Y');
        }
        if ($user_id == null || $user_id == '0') {
            $user_id = Auth::user()->id;
        }
        //dd($year);
        //First we need to get all employees for this manager
        $all_users = $userRepository->getAllUsersFromManager($user_id);
        $user = User::find($user_id);
        $revenue_target = $user->revenue_target;
        //dd($revenue_target);
        $revenue_product_codes = explode(',', $user->revenue_product_codes);
        //dd($user->revenue_product_codes);
        $users_id = [];
        foreach ($all_users as $key => $user) {
            array_push($users_id, $user['id']);
        }
        //dd($revenue_product_codes);
        $revenues = DB::table('project_revenues');
        $revenues->select('users.id as user_id', 'users.name as user_name', 'projects.id as project_id', 'customers.name as customer_name', 'customers.cluster_owner as cluster_owner',
                      'projects.project_name as project_name', 'projects.project_type as project_type', 'projects.project_subtype as project_subtype', 'projects.project_status as project_status',
                      'projects.gold_order_number as gold_order', 'projects.samba_id as samba_id',
                      DB::raw('IF(projects.win_ratio IS NULL,100,projects.win_ratio) as win_ratio'),
                      'project_revenues.product_code as product_code', 'project_revenues.year as year',
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.jan,project_revenues.jan*projects.win_ratio/100),project_revenues.jan) as jan'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.feb,project_revenues.feb*projects.win_ratio/100),project_revenues.feb) as feb'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.mar,project_revenues.mar*projects.win_ratio/100),project_revenues.mar) as mar'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.apr,project_revenues.apr*projects.win_ratio/100),project_revenues.apr) as apr'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.may,project_revenues.may*projects.win_ratio/100),project_revenues.may) as may'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.jun,project_revenues.jun*projects.win_ratio/100),project_revenues.jun) as jun'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.jul,project_revenues.jul*projects.win_ratio/100),project_revenues.jul) as jul'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.aug,project_revenues.aug*projects.win_ratio/100),project_revenues.aug) as aug'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.sep,project_revenues.sep*projects.win_ratio/100),project_revenues.sep) as sep'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.oct,project_revenues.oct*projects.win_ratio/100),project_revenues.oct) as oct'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.nov,project_revenues.nov*projects.win_ratio/100),project_revenues.nov) as nov'),
                      DB::raw('IF(projects.project_status = "Pipeline",IF(projects.win_ratio IS NULL,project_revenues.dec,project_revenues.dec*projects.win_ratio/100),project_revenues.dec) as dece')
                    );
        $revenues->leftjoin('projects', 'project_revenues.project_id', '=', 'projects.id');
        $revenues->leftjoin('customers', 'projects.customer_id', '=', 'customers.id');
        $revenues->leftjoin('activities', 'activities.project_id', '=', 'projects.id');
        $revenues->leftjoin('users', 'activities.user_id', '=', 'users.id');
        //$revenues->where('users.id','=',$user['id']);
        $revenues->where('project_revenues.year', '=', $year);
        $revenues->where('projects.project_type', '!=', 'Pre-sales');
        $revenues->whereIn('users.id', $users_id);
        if ($revenue_product_codes[0] != '') {
            $revenues->whereIn('project_revenues.product_code', $revenue_product_codes);
        }
        $revenues->groupBy('project_revenues.id');
        $all_revenues = $revenues->get();
        //dd($all_revenues);
        $projects_id = [];
        $month_total['jan'] = 0;
        $month_total['feb'] = 0;
        $month_total['mar'] = 0;
        $month_total['apr'] = 0;
        $month_total['may'] = 0;
        $month_total['jun'] = 0;
        $month_total['jul'] = 0;
        $month_total['aug'] = 0;
        $month_total['sep'] = 0;
        $month_total['oct'] = 0;
        $month_total['nov'] = 0;
        $month_total['dec'] = 0;
        foreach ($all_revenues as $key => $revenue) {
            $month_total['jan'] += $revenue->jan;
            $month_total['feb'] += $revenue->feb;
            $month_total['mar'] += $revenue->mar;
            $month_total['apr'] += $revenue->apr;
            $month_total['may'] += $revenue->may;
            $month_total['jun'] += $revenue->jun;
            $month_total['jul'] += $revenue->jul;
            $month_total['aug'] += $revenue->aug;
            $month_total['sep'] += $revenue->sep;
            $month_total['oct'] += $revenue->oct;
            $month_total['nov'] += $revenue->nov;
            $month_total['dec'] += $revenue->dece;
            if (! in_array($revenue->project_id, $projects_id)) {
                array_push($projects_id, $revenue->project_id);
            }
        }
        //dd($month_total);
        $grand_total = $month_total['jan'] + $month_total['feb'] + $month_total['mar'] + $month_total['apr'] + $month_total['may'] + $month_total['jun'] +
                    $month_total['jul'] + $month_total['aug'] + $month_total['sep'] + $month_total['oct'] + $month_total['nov'] + $month_total['dec'];
        //dd($grand_total);
        $projects = DB::table('projects');
        $projects->select('users.id as user_id', 'users.name as user_name', 'projects.id as project_id', 'customers.name as customer_name', 'customers.cluster_owner as cluster_owner',
                      'projects.project_name as project_name', 'projects.project_type as project_type', 'projects.project_subtype as project_subtype', 'projects.project_status as project_status',
                      'projects.gold_order_number as gold_order', 'projects.samba_id as samba_id', 'projects.win_ratio as win_ratio'
                    );
        $projects->leftjoin('customers', 'projects.customer_id', '=', 'customers.id');
        $projects->leftjoin('activities', 'activities.project_id', '=', 'projects.id');
        $projects->leftjoin('users', 'activities.user_id', '=', 'users.id');
        $projects->where('projects.project_type', '!=', 'Pre-sales');
        $projects->where('activities.year', '=', $year);
        $projects->where('customers.name', '!=', 'Orange Business Services');
        $projects->whereIn('users.id', $users_id);
        $projects->whereNotIn('projects.id', $projects_id);
        $projects->groupBy('projects.id');
        $projects_without_revenue = $projects->get();
        //dd($projects_without_revenue);

        return view('dashboard/revenue', compact('authUsersForDataView', 'year', 'user_id', 'revenue_target', 'all_revenues', 'month_total', 'grand_total', 'projects_without_revenue', 'table_height'));
    }

    public function order(AuthUsersForDataView $authUsersForDataView, UserRepository $userRepository, $year = null, $user_id = null)
    {
        $authUsersForDataView->userCanView('tools-activity-all-view');
        $table_height = Auth::user()->table_height;
        if ($year == null) {
            $year = date('Y');
        }
        if ($user_id == null || $user_id == '0') {
            $user_id = Auth::user()->id;
        }
        //dd($year);
        //First we need to get all employees for this manager
        $all_users = $userRepository->getAllUsersFromManager($user_id);
        //dd($all_users);
        $user = User::find($user_id);
        $order_target = $user->order_target;
        //dd($order_target);

        $users_id = [];
        foreach ($all_users as $key => $user) {
            array_push($users_id, $user['id']);
        }

        $orders = DB::table('projects');
        $orders->select('users.id as user_id', 'users.name as user_name', 'projects.id as project_id', 'customers.name as customer_name', 'customers.cluster_owner as cluster_owner',
                      'projects.project_name as project_name', 'projects.project_type as project_type', 'projects.project_subtype as project_subtype', 'projects.project_status as project_status',
                      'projects.gold_order_number as gold_order', 'projects.samba_id as samba_id', 'projects.pullthru_samba_id as pullthru_samba_id', 'projects.samba_opportunit_owner as samba_opportunit_owner',
                      'projects.samba_lead_domain as samba_lead_domain', 'projects.samba_stage as samba_stage','projects.estimated_start_date as estimated_start_date','projects.estimated_end_date as estimated_end_date',
                      'projects.revenue as revenue', 'projects.samba_consulting_product_tcv as samba_consulting_product_tcv', 'projects.samba_pullthru_tcv as samba_pullthru_tcv',
                      DB::raw('IF(projects.win_ratio IS NULL,100,projects.win_ratio) as win_ratio')
                      );
        $orders->leftjoin('customers', 'projects.customer_id', '=', 'customers.id');
        $orders->leftjoin('activities', 'activities.project_id', '=', 'projects.id');
        $orders->leftjoin('users', 'activities.user_id', '=', 'users.id');
        $orders->where('projects.estimated_end_date', 'LIKE', '%'.$year.'%');
        $orders->where('projects.project_type', '=', 'Pre-sales');
        $orders->where('customers.name', '!=', 'Orange Business Services');
        $orders->whereIn('users.id', $users_id);
        $orders->groupBy('projects.id');
        $all_orders = $orders->get();
        //dd($all_orders);
        $grand_total = [];
        $grand_total_weighted = [];
        $grand_total['revenue'] = 0;
        $grand_total['samba_consulting_product_tcv'] = 0;
        $grand_total['samba_pullthru_tcv'] = 0;
        $grand_total_weighted['revenue'] = 0;
        $grand_total_weighted['samba_consulting_product_tcv'] = 0;
        $grand_total_weighted['samba_pullthru_tcv'] = 0;

        foreach ($all_orders as $key => $order) {
            $grand_total['revenue'] += $order->revenue;
            $grand_total['samba_consulting_product_tcv'] += $order->samba_consulting_product_tcv;
            $grand_total['samba_pullthru_tcv'] += $order->samba_pullthru_tcv;

            $grand_total_weighted['revenue'] += $order->revenue * $order->win_ratio / 100;
            $grand_total_weighted['samba_consulting_product_tcv'] += $order->samba_consulting_product_tcv * $order->win_ratio / 100;
            $grand_total_weighted['samba_pullthru_tcv'] += $order->samba_pullthru_tcv * $order->win_ratio / 100;
        }

        //dd($grand_total_weighted);

        return view('dashboard/order', compact('authUsersForDataView', 'user_id', 'year', 'order_target', 'all_orders', 'grand_total', 'grand_total_weighted', 'table_height'));
    }

    public function action($user_name = '')
    {
        $table_height = Auth::user()->table_height;

        return view('dashboard/action', compact('user_name', 'table_height'));
    }
}
