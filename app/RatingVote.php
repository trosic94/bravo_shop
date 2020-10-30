<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class RatingVote extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'rating_votes';

    protected $fillable = ['user_id','user_ip','product_id','rating_id','rating_value'];

    public static function productRate($productID)
    {
        //PRODUCT data
        $productRate = RatingVote::where('product_id',$productID)
        							->avg('rating_value');

        return $productRate;
    }

    public static function ratingComments($productID)
    {
        $ratingComments = DB::table('rating_votes as RV')
        					->join('users as U','U.id','RV.user_id')
        					->where('RV.product_id',$productID)
        					->where('RV.comment_status',1)
        					->select(
        						'RV.comment as prod_comment',
                                'U.name as u_name',
        						'U.last_name as u_last_name'
        					)
        					->orderBy('RV.updated_at','DESC')
        					->get();

        return $ratingComments;
    }

    public static function allRatingCommentsForProduct($productID)
    {
        $allRatingData = DB::table('rating_votes as RV')
                            ->join('users as U','U.id','RV.user_id')
                            ->leftJoin('rating_options as RO','RO.id','RV.rating_id')
                            ->leftJoin('products as P','P.id','RV.product_id')
                            ->where('RV.product_id',$productID)
                            ->select(
                                'RV.id as rv_id',
                                'U.id as u_id',
                                'U.name as u_name',
                                'RV.user_ip as rv_user_ip',
                                'U.last_name as u_last_name',
                                'P.title as p_title',
                                'P.id as p_id',
                                'RO.name as ro_name',
                                'RV.rating_value as rv_rating_value',
                                'RV.comment as rv_comment',
                                'RV.comment_status as rv_comment_status',
                                'RV.created_at as rv_created_at',
                                'RV.updated_at as rv_updated_at'
                            )
                            ->orderBy('RV.updated_at', 'DESC')
                            ->get();

        return $allRatingData;
    }


    public static function allRatingData($ratingVoteID)
    {
        $allRatingData = DB::table('rating_votes as RV')
                            ->join('users as U','U.id','RV.user_id')
                            ->leftJoin('rating_options as RO','RO.id','RV.rating_id')
                            ->leftJoin('products as P','P.id','RV.product_id')
                            ->where('RV.id',$ratingVoteID)
                            ->select(
                                'RV.id as rv_id',
                                'U.id as u_id',
                                'U.name as u_name',
                                'RV.user_ip as rv_user_ip',
                                'U.last_name as u_last_name',
                                'P.title as p_title',
                                'P.id as p_id',
                                'RO.name as ro_name',
                                'RV.rating_value as rv_rating_value',
                                'RV.comment as rv_comment',
                                'RV.comment_status as rv_comment_status',
                                'RV.created_at as rv_created_at',
                                'RV.updated_at as rv_updated_at'
                            )
                            ->first();

        return $allRatingData;
    }

    public static function sendRateCommentInfo($notification)
    {
            Mail::send('emails.rate-comment', $notification, function($message) use ($notification)
            {
                $message->to(setting('shop.shop_admin_mail'),setting('company.company_name'))
                        ->from(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->bcc('webmaster@onestopmarketing.rs', 'OSM')
                        ->sender(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->replyTo(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->subject(trans('shop.email_rate_comment_confirmation').' '.$notification['product']->title);
            });
    }
}
