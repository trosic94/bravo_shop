<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSpotlight extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'app_spotlight';

    public static function useLOY()
    {

    	$useLOY_DATA = AppSpotlight::all();

    	$useLOY = $useLOY_DATA->active;

    	return $useLOY;
    }
}
