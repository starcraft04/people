<?php

namespace App\Repositories;

use App\Cluster;
use App\User;
use Auth;
use Datatables;
use DB;
use Entrust;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getById($id)
    {
        return $this->user->findOrFail($id);
    }

    public function getByName($name)
    {
        return $this->user->where('name', $name)->first();
    }

    public function create(array $inputs)
    {
        $user = new $this->user;

        return $this->save($user, $inputs);
    }

    public function update($id, array $inputs)
    {
        return $this->save($this->getById($id), $inputs);
    }

    private function save(User $user, array $inputs)
    {
        // Required fields
        if (isset($inputs['name'])) {
            $user->name = $inputs['name'];
        }
        if (isset($inputs['email'])) {
            $user->email = $inputs['email'];
        }
        // Password special case
        if (isset($inputs['password']) && trim($inputs['password']) != '') {
            $user->password = bcrypt($inputs['password']);
        }
        // Nullable
        if (isset($inputs['country'])) {
            $user->country = $inputs['country'];
        }
        if (isset($inputs['region'])) {
            $user->region = $inputs['region'];
        }
        if (isset($inputs['domain'])) {
            $user->domain = $inputs['domain'];
        }
        if (isset($inputs['management_code'])) {
            $user->management_code = $inputs['management_code'];
        }
        if (isset($inputs['job_role'])) {
            $user->job_role = $inputs['job_role'];
        }
        if (isset($inputs['employee_type'])) {
            $user->employee_type = $inputs['employee_type'];
        }
        if (isset($inputs['activity_status'])) {
            $user->activity_status = $inputs['activity_status'];
        }
        if (isset($inputs['date_started'])) {
            $user->date_started = $inputs['date_started'];
        }
        if (isset($inputs['date_ended'])) {
            $user->date_ended = $inputs['date_ended'];
        }
        // Boolean
        if (isset($inputs['from_otl'])) {
            $user->from_otl = $inputs['from_otl'];
        }
        $user->is_manager = isset($inputs['is_manager']) ? $inputs['is_manager'] : 0;

        $user->save();

        // Now we have to treat the manager
        if (isset($inputs['manager_id'])) {
            /* We need first to check that there is not already a manager defined in which case we have to delete it
            *   Because we want to remove all traces of previous managers, we do a detach without giving
            *   the manager_id as parameter.
            **/
            $user->managers()->detach();
            /* Now we need to create the link in the pivot table
            *   For this we have a function defined in our model User.php called managers()
            *   We only need to say we want to attach the manager_id to this user_id.
            **/
            $user->managers()->attach($inputs['manager_id']);
        } else {
            // In this case, we need to remove any trace of manager for this user
            $user->managers()->detach();
        }

        // Now we need to save the roles
        if (isset($inputs['roles'])) {
            DB::table('role_user')->where('user_id', $user->id)->delete();
            foreach ($inputs['roles'] as $key => $value) {
                $user->attachRole($value);
            }
        } else {
            DB::table('role_user')->where('user_id', $user->id)->delete();
        }

        // Now we need to save the clusters
        if (isset($inputs['managed_cluster'])) {
            //DB::table('cluster_user')->where('user_id',$user->id)->delete();
            $user->clusters()->delete();
            foreach ($inputs['managed_cluster'] as $key => $value) {
                $cluster = new Cluster;
                $cluster->user_id = $user->id;
                $cluster->cluster_owner = $value;
                $cluster->save();
            }
        } else {
            //DB::table('cluster_user')->where('user_id',$user->id)->delete();
            $user->clusters()->delete();
        }

        return $user;
    }

    public function destroy($id)
    {
        $user = $this->getById($id);
        $my_employees = $user->employees()->count();

        if ($my_employees > 0) {
            return ['status'=>'error', 'msg'=>'User is manager of other users'];
        }
        $user->managers()->detach();
        $user->delete();

        return $user;
    }

    public function getListOfUsers($exclude_contractors)
    {
        /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
         *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
         *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
         *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
         **/
        $userList = DB::table('users')
    ->select('users.id', 'users.name','users.email','users.is_manager', 'users.region',
    'users.country', 'users.domain', 'users.management_code', 'users.job_role','users.from_otl',
    'users.employee_type', 'users_users.manager_id', 'u2.name AS manager_name', 'users.activity_status', 'users.date_started', 'users.date_ended')
    ->leftjoin('users_users', 'users.id', '=', 'users_users.user_id')
    ->leftjoin('users AS u2', 'u2.id', '=', 'users_users.manager_id');
        if (Auth::user()->id != 1) {
            $userList->where('users.id', '!=', '1');
        }
        if (! Entrust::can('user-view-all')) {
            $userList->where('users_users.manager_id', '=', Auth::user()->id);
        }
        if ($exclude_contractors == '1') {
            $userList->where('users.employee_type', '!=', 'contractor');
        }
        $data = Datatables::of($userList)->make(true);

        return $data;
    }

    public function getMyManagersList($id)
    {
        $data = $this->user->findOrFail($id)->managers()->select('manager_id', 'name')->get();

        return $data;
    }

    public function getManagersList()
    {
        return $this->user->where('is_manager', '=', '1')->pluck('name', 'id');
    }

    public function getAllUsersList()
    {
        return $this->user->pluck('name', 'id');
    }

    public function getAllUsersFromManager($id)
    {
        $result = [];
        $manager = $this->user->findOrFail($id)->toArray();
        array_push($result, $manager);
        $data = $this->user->findOrFail($id)->employees->toArray();
        foreach ($data as $key => $value) {
            if ($value['is_manager'] == '1') {
                $team = $this->getAllUsersFromManager($value['id']);
                $result = array_merge($result, $team);
            } else {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function getAllUsersListNoManagers()
    {
        return $this->user->where('is_manager', '!=', '1')->where('id', '!=', '1')->pluck('name', 'id');
    }

    public function getTheoreticalCapacity($where = null)
    {
        /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
         *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
         *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
         *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
         **/
        $data = 0;

        if (! empty($where['user'])) {
            $data = count($where['user']) * config('options.dashboard_load_chart_theoretical');
        } elseif (! empty($where['manager'])) {
            foreach ($where['manager'] as $w) {
                $data = $data + $this->getById($w)->employees()->count();
            }
            $data = $data * config('options.dashboard_load_chart_theoretical');
        } else {
            $managers = $this->getManagersList();
            foreach ($managers as $key => $value) {
                $data = $data + $this->getById($key)->employees()->count();
            }
            $data = $data * config('options.dashboard_load_chart_theoretical');
        }
        $theoretical = [$data, $data, $data, $data, $data, $data, $data, $data, $data, $data, $data, $data];

        return $theoretical;
    }

    public function getCountries($id)
    {
        $countries = DB::table('users')
    ->select('cluster_country.country')
    ->leftjoin('cluster_user', 'cluster_user.user_id', '=', 'users.id')
    ->leftjoin('cluster_country', 'cluster_user.cluster_id', '=', 'cluster_country.cluster_id')
    ->where('users.id', '=', $id)
    ->groupBy('country')
    ->pluck('country');

        return $countries;
    }
}
