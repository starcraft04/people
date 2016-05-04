<?php 

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\SkillRepository;
use Illuminate\Http\Request;
use Datatables;

class SkillAjaxController extends Controller 
{
    protected $skillRepository;

    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
	}
    
    public function postSkillPerEmployee(Request $request)
	{
        $input = $request->all();
        $return = $this->skillRepository->getSkillPerEmployee($input);
        $data = Datatables::of($return)->make(true);
		return $data;
	}
}
