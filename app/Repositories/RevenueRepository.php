<?php

namespace App\Repositories;

use App\Revenue;
use Datatables;
use DB;
use Entrust;
use Auth;


class RevenueRepository
{

    public function __construct()
    {

    }

    public function getRevenuesPerCustomer($customer_name)
    {

        $revenueList = DB::table('revenues');
        $revenueList->select('customers.name AS customer_name', 'product_code', 'year', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
        $revenueList->leftjoin('customers', 'customers.id', '=', 'revenues.customer_id');
        $revenueList->where('customers.name','=',$customer_name);
        $revenueList->orderBy('product_code');
        
        $data = $revenueList->get();
        
        return $data;
    }

}