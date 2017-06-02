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
	public function getFormCreate()
	{
        $position = ['main_title'=>'Employee','second_title'=>'create',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee create','url'=>'']
                ]
            ];
		$manager_list = $this->employeeRepository->getManagersList();
		//\Debugbar::info($manager_list);
		return view('employee/create_update', compact('manager_list'))->with('position',$position)->with('action','create');
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
    $employee = $this->employeeRepository->getById($id);
		//\Debugbar::info($manager_list);
		return view('employee/create_update', compact('manager_list','employee'))->with('position',$position)->with('action','update');
	}

  public function postFormCreate(EmployeeCreateRequest $request)
	{
        $inputs = $request->all();
        $employee = $this->employeeRepository->createIfNotFound($inputs);
        return redirect('employeeList')->withOk('Record <b>'.$inputs['name'].'</b> created !');
	}

	public function postFormUpdate(EmployeeUpdateRequest $request, $id)
	{
        $inputs = $request->all();
        $employee = $this->employeeRepository->update($id, $inputs);
        return redirect('employeeList')->withOk('Record <b>'.$inputs['name'].'</b> updated !');
	}

	public function delete($id)
	{
        $name = $this->employeeRepository->getById($id)->name;
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $result->result = true;
        $result->msg = '';
        try {
            $employee = $this->employeeRepository->destroy($id);
        }
        catch (\Illuminate\Database\QueryException $ex){
            $result->result = false;
            $result->msg = 'Message:</BR>'.$ex->getMessage();
            return json_encode($result);
        }
		//\Debugbar::info($manager_list);
        $result->msg = 'Record <b>'.$name.'</b> deleted successfully';
		return json_encode($result);
	}

  public function ListOfEmployees()
  {
    return $this->employeeRepository->getListOfEmployees();
  }

}
