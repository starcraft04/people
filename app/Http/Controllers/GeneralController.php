<?php

namespace App\Http\Controllers;


class GeneralController extends Controller
{
    public function help()
	{
		return view('help');
	}
}