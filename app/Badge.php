<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'badges';

	public static function allBadges()
    {
    	$allBadges = Badge::select(
    					'badges.id as b_id',
    					'badges.title as b_title',
    					'badges.description as b_description'
    				)
    				->get();

    	return $allBadges;
    }


    //relacije
    public function productBadges()
    {
        return $this->hasOne('App\BadgeProducts','badge_id','id');
    }
}
