<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Product;
use App\RatingOption;
use App\RatingVote;

class RatingOptionController extends Controller
{
 	public function rateEvent(Request $request)
    {

    	$ulogovan = Auth::user();

		$ip = $request->ip();
		$product_id = request('productID');
		$rating_id = request('rateID');
		$rating_value = request('rateVAL');

		// proveravam da li je korisnik vec ocenio proizvod ili ostavio komentar
		$DaLiJeVecOcenio = RatingVote::where('user_id',$ulogovan->id)
										->where('product_id',$product_id)
										->first();
	    

		if ($DaLiJeVecOcenio):
			if ($DaLiJeVecOcenio->rating_id == null):

				$ratingVote = array(
					'rating_id' => $rating_id,
					'rating_value' => $rating_value
				);

				// upisujem ocenu za proizvod
				$updateRate = RatingVote::where('user_id',$ulogovan->id)
											->where('product_id',$product_id)
											->update($ratingVote);

				$msg = '<div class="formOK">'.trans('shop.rate_voting_msg_ok').'</div>';

			else:

				$msg = '<div class="formERR">'.trans('shop.rate_voting_msg_err').'</div>';

			endif;

		else:

			$ratingVote = array([
				'user_id' => $ulogovan->id,
				'user_ip' => $ip,
				'product_id' => $product_id,
				'rating_id' => $rating_id,
				'rating_value' => $rating_value,
				'comment' => null,
				'comment_status' => 0
			]);

		
			$insertRate = RatingVote::insert($ratingVote);
			

			$msg = '<div class="formOK">'.trans('shop.rate_voting_msg_ok').'</div>';

		endif;



		return $msg;
    }

 	public function rateComment(Request $request)
    {
    	$ulogovan = Auth::user();

		$ip = $request->ip();
    	$product_id = request('productID');
    	$comment = request('rateCommentTXT');

		// proveravam da li je korisnik vec ocenio proizvod ili ostavio komentar
		$DaLiJeVecOcenio = RatingVote::where('user_id',$ulogovan->id)
										->where('product_id',$product_id)
										->first();

		if ($DaLiJeVecOcenio):

			if ($DaLiJeVecOcenio->comment == null):

				$ratingComment = array(
					'comment' => $comment,
				);

				// upisujem komentar za proizvod
				$updateRateComment = RatingVote::where('user_id',$ulogovan->id)
											->where('product_id',$product_id)
											->update($ratingComment);

				$msg = '<div class="formOK">'.trans('shop.rate_comment_msg_ok').'</div>';
				$status = 1;

			else:

				$msg = '<div class="formERR">'.trans('shop.rate_comment_msg_err').'</div>';
				$status = 0;

			endif;

		else:

			$ratingComment = array([
				'user_id' => $ulogovan->id,
				'user_ip' => $ip,
				'product_id' => $product_id,
				'rating_id' => null,
				'rating_value' => null,
				'comment' => $comment,
				'comment_status' => 0
			]);

			// upisujem komentar za proizvod
			$insertRateComment = RatingVote::insert($ratingComment);

			$msg = '<div class="formOK">'.trans('shop.rate_comment_msg_ok').'</div>';
			$status = 1;

		endif;

		if ($status == 1):

	        // kreiram DATUM
	        $sada = Carbon::now();
	        $order_DATETIME = date('d.m.Y H:i:s', strtotime($sada));

			$notification = array();

			// Datum i vreme slanja
			$notification['dateTime'] = $order_DATETIME;

			// Comment
			$notification['comment'] = $comment;

			// User info
			$notification['customer'] = $ulogovan;

			// Product Info
			$notification['product'] = Product::where('id',$product_id)->first();


			$sendNotification = RatingVote::sendRateCommentInfo($notification);
		endif;

    	return $msg;
    }
}
