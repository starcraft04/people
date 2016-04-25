<?php

namespace App\Repositories;

use App\Activity;

class ActivityRepository
{

    protected $activity;

    public function __construct(Activity $activity)
	{
		$this->activity = $activity;
	}

	private function save(Activity $activity, Array $inputs)
	{
		$activity->year = $inputs['year'];
        $activity->month = $inputs['month'];
        $activity->project_id = $inputs['project_id'];
        $activity->employee_id = $inputs['employee_id'];
        $activity->task_hour = $inputs['task_hour'];
        // Boolean
        $activity->from_otl = isset($inputs['from_otl']);
		$activity->save();
        return $activity;
	}

	public function getPaginate($n)
	{
        $activity = new Activity;
		return $activity->activityTablePaginate($n);
	}

	public function store(Array $inputs)
	{
		$activity = new $this->activity;		

		$this->save($activity, $inputs);

		return $activity;
	}

	public function getById($id)
	{
		return $this->activity->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}
    
    public function createIfNotFound(Array $inputs)
	{
        $activity = $this->activity
            ->where('year', $inputs['year'])
            ->where('month', $inputs['month'])
            ->where('project_id', $inputs['project_id'])
            ->where('employee_id', $inputs['employee_id'])
            ->first();
        
        if (isset($activity)){
            return $activity;
        }
        else{
            return $this->store($inputs);
        }
	}
    
    public function createOrUpdate(Array $inputs)
	{
        $activity = $this->activity
            ->where('year', $inputs['year'])
            ->where('month', $inputs['month'])
            ->where('project_id', $inputs['project_id'])
            ->where('employee_id', $inputs['employee_id'])
            ->first();
        
        if (isset($activity)){
            return $this->save($activity, $inputs);
        }
        else{
            return $this->store($inputs);
        }
	}
    
	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
}