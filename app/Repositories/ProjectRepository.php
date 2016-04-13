<?php

namespace App\Repositories;

use App\Project;

class ProjectRepository
{

    protected $project;

    public function __construct(Project $project)
	{
		$this->project = $project;
	}

	private function save(Project $project, Array $inputs)
	{
		$project->customer_name = $inputs['customer_name'];
		$project->project_name = $inputs['project_name'];
        $project->task_name = $inputs['task_name'];
		$project->save();
	}

	public function getPaginate($n)
	{
        $project = new Project;
		return $project->projectTablePaginate($n);
	}

	public function store(Array $inputs)
	{
		$project = new $this->project;		

		$this->save($project, $inputs);

		return $project;
	}

	public function getById($id)
	{
		return $this->project->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
}