<?php

namespace App\Http\Controllers;

use App\Cluster;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionsUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\User;
use Spatie\Permission\Models\Role;
use Auth;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getList()
    {
        return view('user/list');
    }

    public function profile($id)
    {
        $user = User::find($id);
        if (Auth::user()->id != $id) {
            return redirect('userList')->with('error', 'You are not user '.$user->name.'!!!');
        }

        return view('user/profile', compact('user'));
    }

    public function updatePasswordGet(User $user)
    {
        if (Auth::user()->id != $user->id) {
            return redirect()->route('updatePasswordGet',[Auth::user()->id])->with('error', 'You are not user '.$user->name.'!!!');
        }

        return view('user/updatePassword', compact('user'));
    }

    public function updatePasswordStore(PasswordUpdateRequest $request, User $user)
    {
        $inputs = $request->only('password');

        if (Auth::user()->id != $user->id) {
            return redirect()->route('updatePasswordGet',[Auth::user()->id])->with('error', 'You are not user '.$user->name.'!!!');
        }

        $user->update_password($inputs['password'],true);

        return redirect()->route('updatePasswordGet',[Auth::user()->id])->with('success', 'Password updated')->with('user',$user);
    }

    public function passwordUpdateAjax(Request $request, User $user)
    {
        $result = new \stdClass();
        $inputs = $request->all();
        $can_reset = false;

        $manager_id = $user->managers()->first()->id;
        $auth_id = Auth::user()->id;

        if ($user->id == 1) {
            $result->result = 'error';
            $result->msg = 'You cannot reset the password of the admin!!!';
        } elseif (Auth::user()->id == $user->id) {
            $result->result = 'success';
            $result->msg = 'Password updated';
            $can_reset = true;
        } elseif ($manager_id == $auth_id) {
            $result->result = 'success';
            $result->msg = 'Password updated';
            $can_reset = true;
        } elseif (Auth::user()->can('user-view-all')) {
            $result->result = 'success';
            $result->msg = 'Password updated';
            $can_reset = true;
        } else {
            $result->result = 'error';
            $result->msg = 'You have no rights to reset the password';
        }
        if ($can_reset) {
            $user->update_password($inputs['password'],true);
        }
        return json_encode($result);
    }

    public function optionsUpdate(OptionsUpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (Auth::user()->id != $id) {
            return redirect('userList')->with('error', 'You are not user '.$user->name.'!!!');
        }
        $inputs = $request->all();
        //dd($inputs);
        $user->clusterboard_top = $inputs['clusterboard_top'];
        $user->revenue_product_codes = $inputs['revenue_product_codes'];
        $user->revenue_target = $inputs['revenue_target'];
        $user->order_target = $inputs['order_target'];
        $user->table_height = $inputs['table_height'];
        $user->save();

        return redirect('profile/'.$id)->with('success', 'Options updated successfully');
    }

    public function getFormCreate()
    {
        $defaultRole = config('select.defaultRole');

        if (Auth::user()->hasRole('Admin')) {
            $roles = Role::all()->pluck('name', 'id');
        } else {
            $roles = Role::where('id','!=',1)->pluck('name','id');
        }

        if (Auth::user()->can('role-assign')) {
            $role_select_disabled = 'false';
        } else {
            $role_select_disabled = 'true';
        }

        $manager_list = User::orderBy('name')->where('is_manager', '1')->pluck('name', 'id');
        $manager_list->prepend('', '');

        $clusters = Customer::where('cluster_owner', '!=', '')->groupBy('cluster_owner')->pluck('cluster_owner');

        return view('user/create_update', compact('manager_list', 'clusters', 'roles', 'role_select_disabled', 'defaultRole'))->with('action', 'create');
    }

    public function getFormUpdate(User $user)
    {

        if (Auth::user()->hasRole('Admin')) {
            $roles = Role::all()->pluck('name', 'id');
        } else {
            $roles = Role::where('id','!=',1)->pluck('name','id');
        }

        if (Auth::user()->can('role-assign')) {
            $role_select_disabled = 'false';
        } else {
            $role_select_disabled = 'true';
        }

        $manager_list = User::orderBy('name')->where('is_manager', '1')->pluck('name', 'id');
        $manager_list->prepend('', '');

        $manager = $user->managers()->pluck('manager_id');

        $clusters = Customer::where('cluster_owner', '!=', '')->groupBy('cluster_owner')->pluck('cluster_owner');
        $userCluster = $user->clusters()->pluck('cluster_owner')->toArray();

        $userRole = $user->getRoleNames()->toArray();

        return view('user/create_update', compact('manager_list', 'user', 'manager', 'roles', 'userRole', 'clusters', 'userCluster', 'role_select_disabled'))->with('action', 'update');
    }

    public function postFormCreate(UserCreateRequest $request)
    {
        $inputs = $request->all();
        //dd($inputs['user']);

        $user = User::create($inputs['user']);

        //dd($user);

        $user->update_password($inputs['password'],true);

        // Now we have to treat the manager
        if (isset($inputs['manager']['manager_id'])) {
            /* We need first to check that there is not already a manager defined in which case we have to delete it
            *   Because we want to remove all traces of previous managers, we do a detach without giving
            *   the manager_id as parameter.
            **/
            $user->managers()->detach();
            /* Now we need to create the link in the pivot table
            *   For this we have a function defined in our model User.php called managers()
            *   We only need to say we want to attach the manager_id to this user_id.
            **/
            $user->managers()->attach($inputs['manager']['manager_id']);
        } else {
            // In this case, we need to remove any trace of manager for this user
            $user->managers()->detach();
        }

        // Now we need to save the clusters
        if (isset($inputs['managed_clusters'])) {
            $user->clusters()->delete();
            foreach ($inputs['managed_clusters'] as $key => $value) {
                $cluster = new Cluster;
                $cluster->user_id = $user->id;
                $cluster->cluster_owner = $value;
                $cluster->save();
            }
        } else {
            //DB::table('cluster_user')->where('user_id',$user->id)->delete();
            $user->clusters()->delete();
        }

        // Now we need to save the roles
        if (isset($inputs['roles'])) {
            $user->syncRoles($inputs['roles']);
        }

        return redirect('userList')->with('success', 'Record created successfully');
    }

    public function postFormUpdate(UserUpdateRequest $request, User $user)
    {
        $inputs = $request->all();

        $user->update($inputs['user']);



        // Now we have to treat the manager
        if (isset($inputs['manager']['manager_id'])) {
            /* We need first to check that there is not already a manager defined in which case we have to delete it
            *   Because we want to remove all traces of previous managers, we do a detach without giving
            *   the manager_id as parameter.
            **/
            $user->managers()->detach();
            /* Now we need to create the link in the pivot table
            *   For this we have a function defined in our model User.php called managers()
            *   We only need to say we want to attach the manager_id to this user_id.
            **/
            $user->managers()->attach($inputs['manager']['manager_id']);
        } else {
            // In this case, we need to remove any trace of manager for this user
            $user->managers()->detach();
        }

        // Now we need to save the clusters
        if (isset($inputs['managed_clusters'])) {
            $user->clusters()->delete();
            foreach ($inputs['managed_clusters'] as $key => $value) {
                $cluster = new Cluster;
                $cluster->user_id = $user->id;
                $cluster->cluster_owner = $value;
                $cluster->save();
            }
        } else {
            //DB::table('cluster_user')->where('user_id',$user->id)->delete();
            $user->clusters()->delete();
        }

        // Now we need to save the roles
        if (isset($inputs['roles'])) {
            $user->syncRoles($inputs['roles']);
        }

        return redirect('userList')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();

        // First we need to verify that we don't try to delete ourselve.
        if (Auth::user()->id == $id) {
            $result->result = 'error';
            $result->msg = 'User '.Auth::user()->name.' cannot delete himself';

            return json_encode($result);
        }

        $user = User::find($id);

        if (count($user->employees)) {
            $result->result = 'error';
            $result->msg = 'Record cannot be deleted because some employees are associated to it.';

            return json_encode($result);
        }

        if (count($user->activities)) {
            $result->result = 'error';
            $result->msg = 'Record cannot be deleted because some activities are associated to it.';

            return json_encode($result);
        }

        $projects = $user->projects;
        if (count($projects)) {
            foreach ($projects as $project) {
                $project->created_by_user_id = 1;
                $project->save();
            }
        }

        $user->managers()->detach();
        $user->clusters()->delete();

        User::destroy($id);

        $result->result = 'success';
        $result->msg = 'Record deleted successfully';

        return json_encode($result);
    }

    public function ListOfusers($exclude_contractors = 0)
    {
        return $this->userRepository->getListOfUsers($exclude_contractors);
    }
}
