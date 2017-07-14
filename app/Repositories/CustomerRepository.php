<?php

namespace App\Repositories;

use App\Customer;
use Datatables;
use DB;
use Entrust;
use Auth;

class CustomerRepository
{

  protected $customer;

  public function __construct(Customer $customer)
  {
    $this->customer = $customer;
  }

  public function getById($id)
  {
    return $this->customer->findOrFail($id);
  }

  public function create(Array $inputs)
  {
    $customer = new $this->customer;
    return $this->save($customer, $inputs);
  }

  public function update($id, Array $inputs)
  {
    return $this->save($this->getById($id), $inputs);
  }

  private function save(Customer $customer, Array $inputs)
  {
    // Required fields
    if (isset($inputs['name'])) {$customer->name = $inputs['name'];}
    if (isset($inputs['cluster_owner'])) {$customer->cluster_owner = $inputs['cluster_owner'];}

    $customer->save();

    return $customer;
  }

  public function destroy($id)
  {
    $customer = $this->getById($id);
    $customer->delete();

    return $customer;
  }

  public function getListOfCustomers()
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $customerList = DB::table('customers')
    ->select( 'id', 'name','cluster_owner');
    $data = Datatables::of($customerList)->make(true);
    return $data;
  }

}
