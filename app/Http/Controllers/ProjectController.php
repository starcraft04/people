<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
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
		return view('project/create_update')->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $project = $this->projectRepository->getById($id);

		return view('project/create_update', compact('project'))->with('action','update');
	}

  public function postFormCreate(ProjectCreateRequest $request)
	{
    $inputs = $request->all();
    $result = $this->projectRepository->create($inputs);
    return redirect('projectList')->with($result->result,$result->msg);
	}

	public function postFormUpdate(ProjectUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $result = $this->projectRepository->update($id, $inputs);
    return redirect('projectList')->with($result->result,$result->msg);
	}

	public function delete($id)
	{
    $result = $this->projectRepository->destroy($id);
		return json_encode($result);
	}

  public function ListOfprojects()
  {
    return $this->projectRepository->getListOfProjects();
  }
}
