<?php 

namespace App\Http\Controllers;

class EmployeeActivityController extends Controller 
{

    public function __construct()
    {

	}

    public function getView()
	{
        $position = ['main_title'=>'Employee','second_title'=>'activity',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee activity','url'=>'#']
                ]
            ];
		return view('employeeactivity')->with('position',$position);
	}

}