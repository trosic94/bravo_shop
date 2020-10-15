<?php

namespace App\Http\Controllers;

use App\CookieConfirm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

use Auth;


class CookieConfirmController extends Controller
{
    public function privacyConfirm()
    {
    	$name = 'kp_prvcy';
    	$value = 'ok';
    	$minutes = 525600;

    	Cookie::queue($name, $value, $minutes);

    	// return $prvcy;
    }
}
