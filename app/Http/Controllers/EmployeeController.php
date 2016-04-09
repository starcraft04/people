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

	public function create()
	{
		return view('employees/create');
	}

	public function store(EmployeeCreateRequest $request)
	{
		$employee = $this->employeeRepository->store($request->all());

		return redirect('employee')->withOk("The employee " . $employee->employee_name . " has been created.");
	}

	public function show($id)
	{
		$employee = $this->employeeRepository->getById($id);

		return view('employees/show',  compact('employee'));
	}

	public function edit($id)
	{
		$employee = $this->employeeRepository->getById($id);

		return view('employees/edit',  compact('employee'));
	}

	public function update(EmployeeUpdateRequest $request, $id)
	{
		$this->employeeRepository->update($id, $request->all());
		
		return redirect('employee')->withOk("The employee " . $request->input('employee_name') . " has been modified.");
	}

	public function destroy($id)
	{
		$this->employeeRepository->destroy($id);

		return redirect()->back();
	}

}