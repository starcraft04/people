<?php 

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;

use App\Repositories\ProjectRepository;
use App\Project;

use Illuminate\Http\Request;

class ProjectController extends Controller {

    protected $projectRepository;

    protected $nbrPerPage = 10;

    public function __construct(ProjectRepository $projectRepository)
    {
		$this->projectRepository = $projectRepository;
	}
	public function index()
	{
		$project = $this->projectRepository->getPaginate($this->nbrPerPage);
		$links = $project->setPath('')->render();
		return view('project/index', compact('project', 'links'));
	}

	public function create()
	{
		return view('project/create');
	}

	public function store(ProjectCreateRequest $request)
	{
        
		$project = $this->projectRepository->store($request->all());

		return redirect('project')
            ->withOk("The project " . $project->customer_name . "-" . $project->project_name . "-" . $project->task_name . " has been created.");
	}

	public function show($id)
	{
		$project = $this->projectRepository->getById($id);
		return view('project/show',  compact('project'));
	}

	public function edit($id)
	{
		$project = $this->projectRepository->getById($id);
		return view('project/edit',  compact('project'));
	}

	public function update(ProjectUpdateRequest $request, $id)
	{
		$this->projectRepository->update($id, $request->all());
		
		return redirect('project')->withOk("The project " . $request->input('name') . " has been modified.");
	}

	public function destroy($id)
	{
		$this->projectRepository->destroy($id);

		return redirect()->back();
	}
}