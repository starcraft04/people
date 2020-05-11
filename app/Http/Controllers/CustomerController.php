<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Role;
use Auth;
use Datatables;
use DB;
use Entrust;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
    }

    public function getList()
    {
        return view('customer/list');
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        return view('customer/show', compact('customer'));
    }

    public function getFormCreate()
    {
        return view('customer/create_update')->with('action', 'create');
    }

    public function getFormUpdate($id)
    {
        $customer = Customer::find($id);

        return view('customer/create_update', compact('customer'))->with('action', 'update');
    }

    public function postFormCreate(customerCreateRequest $request)
    {
        $inputs = $request->only('name', 'cluster_owner');
        $customer = Customer::create($inputs);

        return redirect('customerList')->with('success', 'Record created successfully');
    }

    public function postFormUpdate(customerUpdateRequest $request, $id)
    {
        $inputs = $request->only('name', 'cluster_owner');
        $customer = Customer::find($id);
        $customer->update($inputs);

        return redirect('customerList')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        if (count(Customer::find($id)->projects) > 0) {
            $result->result = 'error';
            $result->msg = 'Record cannot be deleted because some projects are associated to it.';

            return json_encode($result);
        } else {
            $customer = Customer::destroy($id);
            $result->result = 'success';
            $result->msg = 'Record deleted successfully';

            return json_encode($result);
        }
    }

    public function listOfCustomers()
    {
        $customerList = Customer::select('id', 'name', 'cluster_owner');
        $data = Datatables::of($customerList)->make(true);

        return $data;
    }
}
