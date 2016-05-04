<?php 

namespace App\Http\Controllers;

class EmployeeSkillController extends Controller 
{

    public function __construct()
    {

	}

    public function getView()
	{
        $position = ['main_title'=>'Employee','second_title'=>'skill',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee skill','url'=>'#']
                ]
            ];
		return view('employeeskill')->with('position',$position);
	}

}