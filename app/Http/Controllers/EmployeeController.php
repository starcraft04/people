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
		$employees = $this->employeeRepository->getPaginate($this->nbrPerPage);
		$links = $employees->setPath('')->render();
		return view('employees/index', compact('employees', 'links'));
	}

	public function create()
	{
		$manager_list = $this->employeeRepository->getAllManagersList();
		//\Debugbar::info($manager_list);
		return view('employees/create')->with('manager_list',$manager_list);
	}

	public function store(EmployeeCreateRequest $request)
	{
		$employee = $this->employeeRepository->store($request->all());

		return redirect('employee')->withOk("The employee " . $employee->name . " has been created.");
	}

	public function show(Employee $managers, $id)
	{
		$employee = $this->employeeRepository->getById($id);
		$manager_name = $managers::find($employee->manager_id)->manager->name;
		//\Debugbar::info($manager);

		return view('employees/show',  compact('employee'))->with('manager_name',$manager_name);
	}

	public function edit($id)
	{
		$employee = $this->employeeRepository->getById($id);
        //\Debugbar::info($employee->is_manager);
        $manager_list = $this->employeeRepository->getAllManagersList();
		return view('employees/edit',  compact('employee'))->with('manager_list',$manager_list);
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