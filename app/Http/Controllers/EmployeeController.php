<?php 

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;

use App\Repositories\EmployeeRepository;

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
		$employees = $this->employeeRepository->getPaginate($this->nbrPerPage);
		$links = $employees->setPath('')->render();
		return view('employees/index', compact('employees', 'links'));
	}

	public function create(EmployeeRepository $employeeRepository)
	{
		$manager_list = $employeeRepository->getAllManagersList();
		//\Debugbar::info($manager_list);
		return view('employees/create')->with('manager_list',$manager_list);
	}

	public function store(EmployeeCreateRequest $request)
	{
		$employee = $this->employeeRepository->store($request->all());

		return redirect('employee')->withOk("The employee " . $employee->first_name . " " . $employee->last_name . " has been created.");
	}

	public function show(Employee $managers, $id)
	{
		$employee = $this->employeeRepository->getById($id);
		
		$manager_name = $managers::find($employee->manager_id)->employee->employee_name;
		//\Debugbar::info($manager);

		return view('employees/show',  compact('employee'))->with('manager_name',$manager_name);
	}

	public function edit($id)
	{
		$employee = $this->employeeRepository->getById($id);

		return view('employees/edit',  compact('employee'));
	}

	public function update(EmployeeUpdateRequest $request, $id)
	{
		$this->employeeRepository->update($id, $request->all());
		
		return redirect('employee')->withOk("The employee " . $request->input('first_name') . " " .  $request->input('last_name') . " has been modified.");
	}

	public function destroy($id)
	{
		$this->employeeRepository->destroy($id);

		return redirect()->back();
	}

}