<?php

namespace App\Http\Controllers;

use App\Model\Meta;
use Illuminate\Http\Request;

class MainController extends Controller
{

	public function index(Request $request)
	{
	    $this->data["meta"] = new Meta();

		return view('layouts.main', $this->data);
	}

}
