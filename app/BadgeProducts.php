<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BadgeProducts extends Model
{
    protected $table = 'badges_products';

    protected $fillable = ['badge_id','product_id'];

	public static function badgeByProductID($productID)
    {
    	$productBadage = BadgeProducts::where('product_id',$productID)
    									->join('badges as B','B.id','badges_products.badge_id')
										->select(
											'badges_products.badge_id as bp_badge_id',
											'B.title as b_title',
											'B.description as b_description',
											'B.color as b_color',
											'B.text_color as b_text_color',
											'B.image as b_image'
										)
										->first();

    	return $productBadage;
    }

    //relacije
    public function badges()
    {
        return $this->hasOne('App\Badge','id','badge_id');
    }
    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
}
