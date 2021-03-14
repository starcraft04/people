<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    public function __construct()
    {
    }

    public function isco()
    {
        return view('offer/isco');
    }

}
