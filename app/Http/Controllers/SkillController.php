<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entrust;
use App\Skill;
use Datatables;
use App\Http\Requests\SkillCreateRequest;
use App\Http\Requests\SkillUpdateRequest;

class SkillController extends Controller {

  public function __construct()
  {
    
	}
	public function getList()
	{
		return view('skill/list');
	}

	public function listOfSkills()
  {
    $skillList = Skill::select( 'id', 'domain','subdomain','technology','skill','certification');
    $data = Datatables::of($skillList)->make(true);
    return $data;
  }

	public function show($id)
	{
    $skill = Skill::find($id);
		return view('skill/show',  compact('skill'));
	}

	public function getFormCreate()
	{
		return view('skill/create_update')->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $skill = Skill::find($id);
		return view('skill/create_update', compact('skill'))->with('action','update');
	}

	public function postFormCreate(skillCreateRequest $request)
	{
		$inputs = $request->only('domain','subdomain','technology','skill','certification');
		if (is_null($inputs["certification"])) {
			$inputs["certification"] = 0;
		}
    $skill = Skill::create($inputs);
    return redirect('skillList')->with('success','Record created successfully');
	}

	public function postFormUpdate(skillUpdateRequest $request, $id)
	{
		$inputs = $request->only('domain','subdomain','technology','skill','certification');
		if (is_null($inputs["certification"])) {
			$inputs["certification"] = 0;
		}
    $skill = Skill::find($id);
		$skill->update($inputs);

    return redirect('skillList')->with('success','Record updated successfully');
	}

	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
		
		// Include a check to see if a user has this skill or not and cannot delete in case there is a link with a user !!!

    $skill = Skill::destroy($id);
		$result->result = 'success';
    $result->msg = 'Record deleted successfully';
		return json_encode($result);
		
	}

}
