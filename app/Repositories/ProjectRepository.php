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
        $project->meta_activity = $inputs['meta_activity'];

        //nullable
        $project->project_type = isset($inputs['project_type'])?$inputs['project_type']:null;
        $project->task_category = isset($inputs['task_category'])?$inputs['task_category']:null;
        $project->region = isset($inputs['region'])?$inputs['region']:null;
        $project->country = isset($inputs['country'])?$inputs['country']:null;
        // Boolean
        $project->from_otl = isset($inputs['from_otl']);
		$project->save();
        return $project;
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
    
    public function createIfNotFound(Array $inputs)
	{
        $project = $this->project
            ->where('customer_name', $inputs['customer_name'])
            ->where('project_name', $inputs['project_name'])
            ->where('task_name', $inputs['task_name'])
            ->where('meta_activity', $inputs['meta_activity'])
            ->first();
        
        if (isset($project)){
            return $project;
        }
        else{
            return $this->store($inputs);
        }
	}

    public function createOrUpdate(Array $inputs)
	{
        $project = $this->project
            ->where('customer_name', $inputs['customer_name'])
            ->where('project_name', $inputs['project_name'])
            ->where('task_name', $inputs['task_name'])
            ->where('meta_activity', $inputs['meta_activity'])
            ->first();
        
        if (isset($project)){
            return $this->save($project, $inputs);
        }
        else{
            return $this->store($inputs);
        }
	}
    
    public function destroy($id)
	{
		$this->getById($id)->delete();
	}
    public function getMetaActivityList()
	{
        return $this->project->where('meta_activity','<>','null')->select('meta_activity AS text')->groupBy('meta_activity')->get();
	}
}