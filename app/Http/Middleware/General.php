<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Action;
use DB;

class General
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $num_of_actions = Action::where('assigned_user_id',Auth::user()->id)->get()->count();
        $top_actions = DB::table('actions')
            ->select('created_by.name AS user_name','actions.name AS action_name','actions.estimated_end_date AS end_date','actions.severity AS severity','actions.project_id AS project_id','projects.project_name AS project_name','customers.name AS customer_name')
            ->leftjoin('users AS created_by', 'actions.user_id', '=', 'created_by.id')
            ->leftjoin('projects', 'actions.project_id', '=', 'projects.id')
            ->leftjoin('customers', 'projects.customer_id', '=', 'customers.id')
            ->where('assigned_user_id',Auth::user()->id)
            ->where('status','!=','CLOSED')
            ->orderBy('actions.estimated_end_date')
            ->limit(config('options.num_of_actions_navbar'))->get();
        \View::share('num_of_actions_logged_in_user',$num_of_actions);
        \View::share('top_actions',$top_actions);

        return $next($request);
    }
}