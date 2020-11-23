<?php

namespace App\Repositories;

use App\Revenue;
use Auth;
use Datatables;
use DB;

class RevenueRepository
{
    public function __construct()
    {
    }

    public function getRevenuesPerCustomer($customer_name, $year, $domain)
    {
        if (isset(config('domains.domain-fpc')[$domain])) {
            $fpc = config('domains.domain-fpc')[$domain];
        } else {
            $fpc = null;
        }
        //dd($fpc);
        $revenueList = DB::table('revenues');
        $revenueList->select('customers.name AS customer_name', 'product_code', 'year', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'
        , 'jan_actuals', 'feb_actuals', 'mar_actuals', 'apr_actuals', 'may_actuals', 'jun_actuals', 'jul_actuals', 'aug_actuals', 'sep_actuals', 'oct_actuals', 'nov_actuals', 'dec_actuals');
        $revenueList->leftjoin('customers', 'customers.id', '=', 'revenues.customer_id');
        $revenueList->where('customers.name', '=', $customer_name);
        $revenueList->where('revenues.year', '=', $year);
        if ($fpc) {
            $revenueList->where(function ($query) use ($fpc) {
                foreach ($fpc as $f) {
                    $query->orWhere('product_code', $f);
                }
            });
        }
        $revenueList->orderBy('product_code');

        $data = $revenueList->get();

        return $data;
    }

    public function getRevenuesPerCustomerTot($customer_name, $year, $domain)
    {
        if (isset(config('domains.domain-fpc')[$domain])) {
            $fpc = config('domains.domain-fpc')[$domain];
        } else {
            $fpc = null;
        }

        $revenueList = DB::table('revenues');
        $revenueList->select('customers.name AS customer_name', 'year', DB::raw('sum(jan) AS jan'), DB::raw('sum(feb) AS feb'), DB::raw('sum(mar) AS mar'), DB::raw('sum(apr) AS apr'), DB::raw('sum(may) AS may'), DB::raw('sum(jun) AS jun'), DB::raw('sum(jul) AS jul'), DB::raw('sum(aug) AS aug'), DB::raw('sum(sep) AS sep'), DB::raw('sum(oct) AS oct'), DB::raw('sum(nov) AS nov'), DB::raw('sum(`dec`) AS `dec`'));
        $revenueList->leftjoin('customers', 'customers.id', '=', 'revenues.customer_id');
        $revenueList->where('customers.name', '=', $customer_name);
        $revenueList->where('revenues.year', '=', $year);
        if ($fpc) {
            $revenueList->where(function ($query) use ($fpc) {
                foreach ($fpc as $f) {
                    $query->orWhere('product_code', $f);
                }
            });
        }
        $revenueList->groupBy('revenues.customer_id');

        $data = $revenueList->first();

        return $data;
    }
}
