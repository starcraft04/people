<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use Auth;
use Datatables;
use App\Project;
use DB;
use Http;
use App\CustomerIC01;
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
        $projects_of_the_customer = Project::where('customer_id',$customer->id)->get('project_name');
        $ic01_codes = CustomerIC01::where('customer_id',$customer->id)->pluck('ic01_name','ic01_code');

        return view('customer/show', compact('customer','projects_of_the_customer','ic01_codes'));
    }

    public function getFormCreate()
    {
        $countries = json_decode(Http::get('http://country.io/names.json'),true);
        return view('customer/create_update',compact('countries'))->with('action', 'create');
    }

    public function getFormUpdate($id)
    {
        $customer = Customer::find($id);
        $countries = json_decode(Http::get('http://country.io/names.json'),true);

        return view('customer/create_update', compact('customer','countries'))->with('action', 'update');
    }

    public function postFormCreate(customerCreateRequest $request)
    {
        $inputs = $request->only('name', 'cluster_owner','country_owner');
        $customer = Customer::create($inputs);

        return redirect('customerList')->with('success', 'Record created successfully');
    }

    public function postFormUpdate(customerUpdateRequest $request, $id)
    {
        $inputs = $request->only('name', 'cluster_owner','country_owner');
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
        $customerList = Customer::select('id', 'name', 'cluster_owner','country_owner');
        
        $data = Datatables::of($customerList)->make(true);

        return $data;
    }

    public function addNewIC01Record(Request $request)
    {
        $inputs = $request->all();
        
        

        // $record = CustomerIC01::updateOrCreate(
        //     [
        //         'customer_id'=>$inputs['customer_id'],
        //         'id'=>$inputs['ic01_id']

        //     ],
        //     [
        //         'ic01_code'=>$inputs['ic01_code'],
        //         'ic01_name'=>$inputs['ic01_name']
        //     ]
        // );

        if($inputs['ic01_id'] == '-1')
        {
            $record = CustomerIC01::Create(
            [
                'customer_id'=>$inputs['customer_id'],
                'ic01_code'=>$inputs['ic01_code'],
                'ic01_name'=>$inputs['ic01_name']
            ]
        );
        }
        else{
             $record = CustomerIC01::where(['id'=>$inputs['ic01_id'],'customer_id'=>$inputs['customer_id']])->update(
            [
                'ic01_code'=>$inputs['ic01_code'],
                'ic01_name'=>$inputs['ic01_name']
            ]
        );
        }
        return json_encode($record);
    }

}
