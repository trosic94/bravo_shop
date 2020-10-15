<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BannersClient extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'banners_clients';

	public static function allBannersClients()
    {
    	$allClients = DB::table('banners_clients as BANC')
    						->get();

    	return $allClients;
    }
}
