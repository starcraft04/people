<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Auth;
use DB;
use App\User;
use App\Project;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileToolsController extends Controller
{
    public function __construct()
    {
    }

    public function ajax_git_pull()
    {
        if (Auth::user()->name == 'admin') {
            $path = base_path();
            $output = shell_exec('git -C '.$path.' pull');
            $output .= shell_exec('php '.$path.DIRECTORY_SEPARATOR.'artisan migrate');
            echo $output;
        }
    }

    public function ajax_env_app_debug($bool)
    {
        if (Auth::user()->name == 'admin') {
            if ($bool == 'true') {
                $this->setEnvironmentValue('APP_DEBUG', 'true');
            } elseif ($bool == 'false') {
                $this->setEnvironmentValue('APP_DEBUG', 'false');
            }
        }
    }

    protected function setEnvironmentValue($key, $newValue, $delim = '')
    {
        $path = base_path('.env');
        // get old value from current env
        // but we need to treat the special case for APP_DEBUG returning 1 for true and nothing for false
        if ($key == 'APP_DEBUG') {
            if (env($key) == 1) {
                $oldValue = 'true';
            } else {
                $oldValue = 'false';
            }
        } else {
            $oldValue = env($key);
        }

        // was there any change?
        if ($oldValue === $newValue) {
            return;
        }

        // rewrite file content with changed data
        if (file_exists($path)) {
            // replace current value with new value
            file_put_contents(
                $path, str_replace(
                    $key.'='.$delim.$oldValue.$delim,
                    $key.'='.$delim.$newValue.$delim,
                    file_get_contents($path)
                )
            );
        }

        // Reload the cached config
        if (file_exists(\App::getCachedConfigPath())) {
            Artisan::call('config:cache');
        }
    }

    public function db_cleanup(Request $request)
    {
        if (Auth::user()->name == 'admin') {
            $result = new \stdClass();
            $result->result = 'success';
            $result->msg = 'DB updated successfully';

            $inputs = $request->all();

            $year = $inputs['year'];

            if (!empty($year)) {
                Activity::where('year','<',$year)->delete();
            }

            $projects = DB::table('projects')
                        ->select('projects.id AS id','activities.id AS activity_id')
                        ->leftjoin('activities','projects.id','=','activities.project_id')
                        ->whereNull('activities.id')
                        ->get();
            
            foreach ($projects as $key => $project) {
                DB::table('actions')->where('project_id',$project->id)->delete();
                DB::table('projects_comments')->where('project_id',$project->id)->delete();
                DB::table('project_revenues')->where('project_id',$project->id)->delete();
                $loes = DB::table('project_loe')->where('project_id',$project->id)->get();
                foreach ($loes as $key => $loe) {
                    DB::table('project_loe_consultant')->where('project_loe_id',$loe->id)->delete();
                    DB::table('project_loe_history')->where('project_loe_id',$loe->id)->delete();
                    DB::table('project_loe_site')->where('project_loe_id',$loe->id)->delete();
                }
                Project::destroy($project->id);
            }

            return json_encode($result);
        }
    }

    public function factory_reset()
    {
        if (Auth::user()->name == 'admin') {
            $result = new \stdClass();
            $result->result = 'success';
            $result->msg = 'DB updated successfully';

            $factory_reset = DB::table('users_users')->delete();
            $factory_reset = DB::table('skill_user')->delete();
            $factory_reset = DB::table('skills')->delete();
            $factory_reset = DB::table('samba_users')->delete();
            $factory_reset = DB::table('samba_names')->delete();
            $factory_reset = DB::table('revenues')->delete();
            $factory_reset = DB::table('project_revenues')->delete();
            $factory_reset = DB::table('consulting_pricing')->delete();
            $factory_reset = DB::table('project_loe_consultant')->delete();
            $factory_reset = DB::table('project_loe_history')->delete();
            $factory_reset = DB::table('project_loe_site')->delete();
            $factory_reset = DB::table('project_loe')->delete();
            $factory_reset = DB::table('projects_comments')->delete();
            $factory_reset = DB::table('password_resets')->delete();
            $factory_reset = DB::table('customers_other_names')->delete();
            $factory_reset = DB::table('cluster_user')->delete();
            $factory_reset = DB::table('actions')->delete();
            $factory_reset = DB::table('activities')->delete();
            $factory_reset = DB::table('projects')->delete();
            $factory_reset = DB::table('customers')->delete();
            $factory_reset = DB::table('model_has_roles')->where('model_id','!=',1)->delete();
            $factory_reset = DB::table('model_has_permissions')->where('model_id','!=',1)->delete();
            $factory_reset = DB::table('role_has_permissions')->where('role_id','!=',1)->delete();
            $factory_reset = DB::table('roles')->where('id','!=',1)->delete();
            $factory_reset = DB::table('users')->where('id','!=',1)->delete();
            $factory_reset = DB::table('role_has_permissions')->where('permission_id','>',10)->delete();
            $factory_reset = DB::table('role_has_permissions')->insert(['permission_id'=>52,'role_id'=>1]);

            $user = User::find(1);
            $user->update_password('Welcome1',true);

            //User::where('id','!=',1)->delete();
            return json_encode($result);
        }
    }
}
