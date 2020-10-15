<?php

namespace App;

use App\Banner;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


use Carbon\Carbon;

class Banner extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'banners';

	public static function bannerDATA($id)
    {
    	$banner = DB::table('banners as BAN')
    						->where('id',$id)
    						->first();

    	return $banner;
    }

	public static function bannerDATAfull($id)
    {
    	$banner = DB::table('banners as BAN')
    						->join('banners_clients as BANC','BANC.id','BAN.client_id')
    						->join('banners_positions as BANP','BANP.id','BAN.position_id')
    						->join('banners_track_impressions as BANI','BANI.banner_id','BAN.id')
    						->where('BAN.id',$id)
    						->select(
    							'BAN.id as ban_id',
    							'BAN.name as ban_name',
    							'BAN.url as ban_url',
    							'BAN.target as ban_target',
    							'BAN.image as ban_image',
    							'BAN.start_date as ban_start_date',
    							'BAN.end_date as ban_end_date',
    							'BAN.description as ban_description',
    							'BAN.position_id as ban_position_id',
    							'BAN.client_id as ban_client_id',
    							'BAN.created_at as ban_created_at',
    							'BAN.updated_at as ban_updated_at',
    							'BANC.name as banc_name',
    							'BANP.name as banp_name',
    							'BANI.impression_count as bani_imp_count'
    						)
    						->first();

    	return $banner;
    }

	public static function allBannersByPosition($positionID)
    {
    	$sada = Carbon::now();

    	$banners = DB::table('banners as BAN')
    						->join('banners_clients as BANC','BANC.id','BAN.client_id')
    						->join('banners_positions as BANP','BANP.id','BAN.position_id')
    						->join('banners_track_impressions as BANI','BANI.banner_id','BAN.id')
    						->where('BAN.start_date','<',$sada)
    						->where('BAN.end_date','>',$sada)
    						->where('BAN.position_id',$positionID)
    						->select(
    							'BAN.id as ban_id',
    							'BAN.name as ban_name',
    							'BAN.url as ban_url',
    							'BAN.target as ban_target',
    							'BAN.image as ban_image',
    							'BAN.start_date as ban_start_date',
    							'BAN.end_date as ban_end_date',
    							'BAN.description as ban_description',
    							'BAN.position_id as ban_position_id',
    							'BAN.client_id as ban_client_id',
    							'BAN.created_at as ban_created_at',
    							'BAN.updated_at as ban_updated_at',
    							'BANC.name as banc_name',
    							'BANP.name as banp_name',
    							'BANI.impression_count as bani_imp_count'
    						)
    						//->random(1);
    						->get();

    	return $banners;
    }
}
