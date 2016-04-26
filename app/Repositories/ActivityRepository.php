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
    
    public function getActivityPerEmployeeLaravelWay()
	{
        $activity = $this->activity
            ->groupBy('employee_id','month')
            ->select(['employee_id','month',\DB::raw('SUM(task_hour) as sum_task_hour')])
            ->with(['employee' => function($query)
                {
                    $query->addSelect(array('id', 'name'));
                }])
            ->get();
            
        return $activity;
	}
    public function getActivityPerEmployee($where = null)
	{
        /*
        $where should be an array of array in the form of
        $where['employee_id'][0] ... [1] ...
        */
        $activity = \DB::table('activity')
            ->groupBy('employee_id','month')
            ->select(['employee_id','E.name AS employee_name','month',\DB::raw('SUM(task_hour) as sum_task_hour'),'E.domain AS domain','E.subdomain AS subdomain','E.job_role AS job_role'])
            ->havingRaw('SUM(task_hour) > 0')
            ->join('employee AS E', 'employee_id', '=', 'E.id');

        if (!empty($where['domain']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['domain'] as $w)
                {
                    $query->orWhere('E.domain',$w);
                }
            });
        }
        if (!empty($where['subdomain']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['subdomain'] as $w)
                {
                    $query->orWhere('E.subdomain',$w);
                }
            });
        }
        if (!empty($where['job_role']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['job_role'] as $w)
                {
                    $query->orWhere('E.job_role',$w);
                }
            });
        }
        if (!empty($where['month']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['month'] as $w)
                {
                    $query->orWhere('month',$w);
                }
            });
        }
        
        return $activity;
	}
    
    public function getActivityPerProject($where = null)
	{
        $activity = \DB::table('activity')
            ->groupBy('project_id','month')
            ->select(['project_id','P.customer_name AS customer_name','P.project_name AS project_name','P.meta_activity AS meta_activity','employee_id','E.name AS employee_name','month',\DB::raw('SUM(task_hour) as sum_task_hour'),'E.domain AS domain','E.subdomain AS subdomain','E.job_role AS job_role'])
            ->havingRaw('SUM(task_hour) > 0')
            ->join('employee AS E', 'employee_id', '=', 'E.id')
            ->join('project AS P', 'project_id', '=', 'P.id');
        
        if (!empty($where['domain']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['domain'] as $w)
                {
                    $query->orWhere('E.domain',$w);
                }
            });
        }
        if (!empty($where['subdomain']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['subdomain'] as $w)
                {
                    $query->orWhere('E.subdomain',$w);
                }
            });
        }
        if (!empty($where['job_role']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['job_role'] as $w)
                {
                    $query->orWhere('E.job_role',$w);
                }
            });
        }
        if (!empty($where['month']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['month'] as $w)
                {
                    $query->orWhere('month',$w);
                }
            });
        }
        if (!empty($where['meta_activity']))
        {
            $activity->where(function ($query) use ($where) {
                foreach ($where['meta_activity'] as $w)
                {
                    $query->orWhere('meta_activity',$w);
                }
            });
        }        
        return $activity;
	}
}