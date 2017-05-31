<?php 

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;

use App\Repositories\EmployeeRepository;
use App\Employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller {

    protected $employeeRepository;

    protected $nbrPerPage = 10;

    public function __construct(EmployeeRepository $employeeRepository)
    {
		$this->employeeRepository = $employeeRepository;
        $this->employee_type = ['onshore','nearshore','offshore','contractor'];
	}
	public function getList()
	{
        $position = ['main_title'=>'Employee','second_title'=>'list',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee','url'=>'#']
                ]
            ];
		return view('employee/list')->with('position',$position);
	}
    
	public function show($id)
	{
        $position = ['main_title'=>'Employee','second_title'=>'info',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee','url'=>'#']
                ]
            ];
        $employee = $this->employeeRepository->getById($id);
		return view('employee/show',  compact('employee'))->with('position',$position);
	}
	public function getForm()
	{
        $position = ['main_title'=>'Employee','second_title'=>'create',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee create','url'=>'']
                ]
            ];
		$manager_list = $this->employeeRepository->getManagersList();
        $employee_type = $this->employee_type;
		//\Debugbar::info($manager_list);
		return view('employee/create', compact('manager_list','employee_type'))->with('position',$position);
	}
    
	public function postForm(EmployeeCreateRequest $request)
	{
        $inputs = $request->all();
        $employee = $this->employeeRepository->createIfNotFound($inputs);
        return redirect('employeeForm')->withOk('Record \''.$inputs['name'].'\' created !');
	}
    
	public function getFormUpdate($id)
	{
        $position = ['main_title'=>'Employee','second_title'=>'update',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee update','url'=>'']
                ]
            ];
		$manager_list = $this->employeeRepository->getManagersList();
        $employee_type = $this->employee_type;
        $employee = $this->employeeRepository->getById($id);
		//\Debugbar::info($manager_list);
		return view('employee/update', compact('manager_list','employee_type','id','employee'))->with('position',$position);
	}    

	public function postFormUpdate(EmployeeUpdateRequest $request, $id)
	{
        $inputs = $request->all();
        $employee = $this->employeeRepository->update($id, $inputs);
        return redirect('employeeFormUpdate/'.$id)->withOk('Record \''.$inputs['name'].'\' updated !');
	}
    
	public function destroy($id)
	{
		$this->employeeRepository->destroy($id);

		return redirect()->back();
	}

}