<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Customer;
use App\Role;
use App\Repositories\ProjectRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use DB;
use Entrust;
use Auth;

class ProjectController extends Controller {

  protected $projectRepository;

  public function __construct(ProjectRepository $projectRepository)
  {
    $this->projectRepository = $projectRepository;
	}
	public function getList()
	{
		return view('project/list');
	}

	public function show($id)
	{
    $project = $this->projectRepository->getById($id);
		return view('project/show',  compact('project'));
	}

	public function getFormCreate()
	{
    $today = date("Y-m-d");
    $customers_list = Customer::orderBy('name')->lists('name','id');
    $customers_list->prepend('', '');
		return view('project/create_update',  compact('today','customers_list'))->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $project = $this->projectRepository->getById($id);
    $customers_list = Customer::orderBy('name')->lists('name','id');
    $customers_list->prepend('', '');
		return view('project/create_update', compact('project','customers_list'))->with('action','update');
	}

  public function postFormCreate(ProjectCreateRequest $request)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->create($inputs);
    return redirect('projectList')->with('success','Record created successfully');
	}

	public function postFormUpdate(ProjectUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->update($id, $inputs);
    return redirect('projectList')->with('success','Record updated successfully');
	}

	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
    if(count(Project::find($id)->activities) > 0){
			$result->result = 'error';
			$result->msg = 'Record cannot be deleted because some activities are associated to it.';
			return json_encode($result);
		} else {
    $customer = Project::destroy($id);
		$result->result = 'success';
    $result->msg = 'Record deleted successfully';
		return json_encode($result);
		}
	}

  public function listOfprojects(Request $request)
  {
    $inputs = $request->all();
    return $this->projectRepository->getListOfProjects($inputs);
  }

  public function listOfProjectsMissingInfo(Request $request)
  {
    $inputs = $request->all();
    return $this->projectRepository->getListOfProjectsMissingInfo($inputs);
  }

  public function listOfProjectsMissingOTL(Request $request)
  {
    $inputs = $request->all();
    return $this->projectRepository->getListOfProjectsMissingOTL($inputs);
  }

  public function listOfProjectsLost(Request $request)
  {
    $inputs = $request->all();
    return $this->projectRepository->getListOfProjectsLost($inputs);
  }

  public function listOfProjectsAll(Request $request)
  {
    $inputs = $request->all();
    return $this->projectRepository->getListOfProjectsAll($inputs);
  }
}
