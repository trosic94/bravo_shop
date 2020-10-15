<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BannersPosition extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'banners_positions';

	public static function allBannersPositions()
    {
    	$allPositions = DB::table('banners_positions as BANP')
    						->get();

    	return $allPositions;
    }
}
