<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use DB;
use Entrust;
use Auth;

class UserController extends Controller {

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
		return view('user/show',  compact('user'));
	}

  public function profile($id)
	{
    $user = User::find($id);
    if (Auth::user()->id != $id){
      return redirect('userList')->with('error','You are not user '.  $user->name.'!!!');
    }
		return view('user/profile',  compact('user'));
	}

  public function passwordUpdate(PasswordUpdateRequest $request, $id)
  {
    $user = User::find($id);
    if (Auth::user()->id != $id){
      return redirect('userList')->with('error','You are not user '.  $user->name.'!!!');
    }
    $inputs = $request->only('password');
    $password = $user->update_password($inputs['password'],true);
    return redirect('profile/'.$id)->with('success','Password updated successfully');
  }

	public function getFormCreate()
	{
    $defaultRole = config('select.defaultRole');

    if(Entrust::hasRole('Admin')){
      $roles = Role::lists('display_name','id');
    } else {
      $roles = Role::where('id','!=','1')->lists('display_name','id');
    }

    if (Entrust::can('role-assign')){
      $role_select_disabled = 'false';
    }
    else {
      $role_select_disabled = 'true';
    }

    $manager_list = User::orderBy('name')->where('is_manager','1')->lists('name','id');
    $manager_list->prepend('', '');

		return view('user/create_update', compact('manager_list','roles','role_select_disabled','defaultRole'))->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $user = User::find($id);

    if(Entrust::hasRole('Admin')){
      $roles = Role::lists('display_name','id');
    } else {
      $roles = Role::where('id','!=','1')->lists('display_name','id');
    }

    if (Entrust::can('role-assign')){
      $role_select_disabled = 'false';
    }
    else {
      $role_select_disabled = 'true';
    }

    $userRole = $user->roles->lists('id')->toArray();

    $manager_list = User::orderBy('name')->where('is_manager','1')->lists('name','id');
    $manager_list->prepend('', '');

    $user = $this->userRepository->getById($id);
    $manager = $this->userRepository->getMyManagersList($id);

		//\Debugbar::info($manager_list);
		return view('user/create_update', compact('manager_list','user','manager','roles','userRole','role_select_disabled'))->with('action','update');
	}

  public function postFormCreate(UserCreateRequest $request)
	{
    $inputs = $request->all();
    $user = $this->userRepository->create($inputs);
    return redirect('userList')->with('success','Record created successfully');
	}

	public function postFormUpdate(UserUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $user = $this->userRepository->update($id, $inputs);
    return redirect('userList')->with('success','Record updated successfully');
	}

	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();

    // First we need to verify that we don't try to delete ourselve.
    if (Auth::user()->id == $id){
      $result->result = 'error';
      $result->msg = 'User '.Auth::user()->name.' cannot delete himself';
      return json_encode($result);
    }

    $user = User::find($id);

    if (count($user->employees)){
			$result->result = 'error';
			$result->msg = 'Record cannot be deleted because some employees are associated to it.';
			return json_encode($result);
		}

    if (count($user->activities)){
			$result->result = 'error';
			$result->msg = 'Record cannot be deleted because some activities are associated to it.';
			return json_encode($result);
		}


    $projects = $user->projects;
    if (count($projects)){
      foreach ($projects as $project) {
        $project->created_by_user_id = 1;
        $project->save();
      }
		}

    $user->managers()->detach();

    User::destroy($id);

    $result->result = 'success';
    $result->msg = 'Record deleted successfully';

		return json_encode($result);
	}

  public function ListOfusers()
  {
    return $this->userRepository->getListOfUsers();
  }

}
