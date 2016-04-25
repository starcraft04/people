<?php

namespace App\Repositories;

use App\Skill;

class SkillRepository
{

    protected $skill;

    public function __construct(Skill $skill)
	{
		$this->skill = $skill;
	}

	private function save(Skill $skill, Array $inputs)
	{
		$skill->skill_type = $inputs['skill_type'];
        $skill->skill_category_name = $inputs['skill_category_name'];
        $skill->skill = $inputs['skill'];
        $skill->rank = $inputs['rank'];
        $skill->target_rank = $inputs['target_rank'];
        $skill->employee_id = $inputs['employee_id'];

        //nullable
        $skill->employee_last_assessed = isset($inputs['employee_last_assessed'])?$inputs['employee_last_assessed']:null;
        // Boolean
        $skill->from_step = isset($inputs['from_step']);
		$skill->save();
        return $skill;
	}

	public function getPaginate($n)
	{
        $skill = new Skill;
		return $skill->skillTablePaginate($n);
	}

	public function store(Array $inputs)
	{
		$skill = new $this->skill;		

		$this->save($skill, $inputs);

		return $skill;
	}

	public function getById($id)
	{
		return $this->skill->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}
    
    public function createIfNotFound(Array $inputs)
	{
        $skill = $this->skill
            ->where('skill_type', $inputs['skill_type'])
            ->where('skill_category_name', $inputs['skill_category_name'])
            ->where('skill', $inputs['skill'])
            ->where('employee_id', $inputs['employee_id'])
            ->first();
        
        if (isset($skill)){
            return $skill;
        }
        else{
            return $this->store($inputs);
        }
	}

    public function createOrUpdate(Array $inputs)
	{
        $skill = $this->skill
            ->where('skill_type', $inputs['skill_type'])
            ->where('skill_category_name', $inputs['skill_category_name'])
            ->where('skill', $inputs['skill'])
            ->where('employee_id', $inputs['employee_id'])
            ->first();
        
        if (isset($skill)){
            return $this->save($skill, $inputs);
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