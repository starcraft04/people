<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;
use App\Role;
use App\Repositories\CustomerRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use DB;
use Entrust;
use Auth;

class CustomerController extends Controller {

  protected $customerRepository;

  public function __construct(CustomerRepository $customerRepository)
  {
    $this->customerRepository = $customerRepository;
	}
	public function getList()
	{
		return view('customer/list');
	}

	public function show($id)
	{
    $customer = $this->customerRepository->getById($id);
		return view('customer/show',  compact('customer'));
	}

	public function getFormCreate()
	{
		return view('customer/create_update')->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $customer = $this->customerRepository->getById($id);
		return view('customer/create_update', compact('customer'))->with('action','update');
	}

  public function postFormCreate(customerCreateRequest $request)
	{
    $inputs = $request->all();
    $customer = $this->customerRepository->create($inputs);
    return redirect('customerList')->with('success','Record created successfully');
	}

	public function postFormUpdate(customerUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $customer = $this->customerRepository->update($id, $inputs);
    return redirect('customerList')->with('success','Record updated successfully');
	}

	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = 'Record deleted successfully';
    $customer = $this->customerRepository->destroy($id);
		return json_encode($result);
	}

  public function listOfCustomers()
  {
    return $this->customerRepository->getListOfCustomers();
  }
}
