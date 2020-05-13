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
use App\Role;
use App\User;
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

    public function show($id)
    {
        $user = User::find($id);
        $manager = $this->userRepository->getMyManagersList($id);
        $userCluster = $user->clusters->pluck('cluster_owner')->toArray();

        return view('user/show', compact('user', 'manager', 'userCluster'));
    }

    public function profile($id)
    {
        $user = User::find($id);
        if (Auth::user()->id != $id) {
            return redirect('userList')->with('error', 'You are not user '.$user->name.'!!!');
        }

        return view('user/profile', compact('user'));
    }

    public function passwordUpdate(PasswordUpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (Auth::user()->id != $id) {
            return redirect('userList')->with('error', 'You are not user '.$user->name.'!!!');
        }
        $inputs = $request->only('password');
        $password = $user->update_password($inputs['password'], true);

        return redirect('profile/'.$id)->with('success', 'Password updated successfully');
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
            $roles = Role::pluck('display_name', 'id');
        } else {
            $roles = Role::where('id', '!=', '1')->pluck('display_name', 'id');
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

    public function getFormUpdate($id)
    {
        $user = User::find($id);

        if (Auth::user()->hasRole('Admin')) {
            $roles = Role::pluck('display_name', 'id');
        } else {
            $roles = Role::where('id', '!=', '1')->pluck('display_name', 'id');
        }

        if (Auth::user()->can('role-assign')) {
            $role_select_disabled = 'false';
        } else {
            $role_select_disabled = 'true';
        }

        $userRole = $user->roles->pluck('id')->toArray();

        $manager_list = User::orderBy('name')->where('is_manager', '1')->pluck('name', 'id');
        $manager_list->prepend('', '');

        $user = $this->userRepository->getById($id);
        $manager = $this->userRepository->getMyManagersList($id);

        $clusters = Customer::where('cluster_owner', '!=', '')->groupBy('cluster_owner')->pluck('cluster_owner');
        $userCluster = $user->clusters->pluck('cluster_owner')->toArray();
        //dd($userCluster);

        //\Debugbar::info($manager_list);
        return view('user/create_update', compact('manager_list', 'user', 'manager', 'roles', 'userRole', 'clusters', 'userCluster', 'role_select_disabled'))->with('action', 'update');
    }

    public function postFormCreate(UserCreateRequest $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $user = $this->userRepository->create($inputs);

        return redirect('userList')->with('success', 'Record created successfully');
    }

    public function postFormUpdate(UserUpdateRequest $request, $id)
    {
        $inputs = $request->all();
        $user = $this->userRepository->update($id, $inputs);

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
