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
		$employee = $this->employeeRepository->getPaginate($this->nbrPerPage);
		$links = $employee->setPath('')->render();
        
		return view('employee/index', compact('employee', 'links'));
	}

	public function create()
	{
		$manager_list = Employee::where('is_manager', '=','1')->lists('name','id');
		//\Debugbar::info($manager_list);
		return view('employee/create', compact('manager_list'));
	}

	public function store(EmployeeCreateRequest $request)
	{
		$employee = $this->employeeRepository->store($request->all());

		return redirect('employee')->withOk("The employee " . $employee->name . " has been created.");
	}

	public function show(Employee $managers, $id)
	{
		$employee = $this->employeeRepository->getById($id);
		$manager_name = $managers::find(1)->manager->name;
		//\Debugbar::info($manager);

		return view('employee/show',  compact('employee','manager_name'));
	}

	public function edit($id)
	{
		$employee = $this->employeeRepository->getById($id);
        //\Debugbar::info($employee->is_manager);
        $manager_list = Employee::where('is_manager', '=','1')->lists('name','id');
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