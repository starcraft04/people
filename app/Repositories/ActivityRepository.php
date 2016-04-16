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
		$activity->name = $inputs['name'];
		$activity->manager_id = $inputs['manager_id'];
        $activity->is_manager = isset($inputs['is_manager']);
		$activity->save();
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

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
    }