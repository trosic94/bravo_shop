<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\RatingOption;
use App\RatingVote;

class RatingOptionController extends Controller
{
 	public function rateEvent(Request $request)
    {

    	$ulogovan = Auth::user();

		$ip = $request->ip();
		$req = json_encode($request->all());

		$ratingVote = array([
			'user_id' => $ulogovan->id,
			'product_id' => request('productID'),
			'rating_id' => request('rateID'),
			'rating_value' => request('rateVAL'),
			'comment' => null,
			'comment_status' => 0
		]);

		return json_encode($ratingVote);
    }
}
