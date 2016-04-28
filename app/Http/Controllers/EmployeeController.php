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
	public function index()
	{
        $position = ['main_title'=>'Employee','second_title'=>'info',
             'urls'=>
                [
                    ['name'=>'home','url'=>route('home')],
                    ['name'=>'employee','url'=>'#']
                ]
            ];
		return view('employee/index')->with('position',$position);
	}

	public function create()
	{
		$manager_list = $this->employeeRepository->getManagersList();
		//\Debugbar::info($manager_list);
		return view('employee/create', compact('manager_list'));
	}

	public function store(EmployeeCreateRequest $request)
	{
		$employee = $this->employeeRepository->store($request->all());

		return redirect('employee')
            ->withOk("The employee " . $employee->name . " has been created.");
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

	public function edit($id)
	{
		$employee = $this->employeeRepository->getById($id);
        $manager_list = $this->employeeRepository->getManagersList();
		return view('employee/edit',  compact('employee','manager_list'));
	}

	public function update(EmployeeUpdateRequest $request, $id)
	{
		$this->employeeRepository->update($id, $request->all());
		
		return redirect('employee')->withOk("The employee " . $request->input('name') . " has been modified.");
	}

	public function destroy($id)
	{
		$this->employeeRepository->destroy($id);

		return redirect()->back();
	}

}