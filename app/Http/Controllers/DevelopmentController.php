<?php

namespace App\Http\Controllers;

use App\Development;
use Illuminate\Http\Request;


class DevelopmentController extends Controller
{
    public function index()
	{
		$poruka = 'Uskoro....';

		$ip = Development::get_client_ip();

		return view('development.index', compact('poruka','ip'));
	}
}
