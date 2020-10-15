<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'product_images';

    protected $fillable = ['product_id','status','created_at','updated_at'];

	public static function productGalleryByProdID($productID)
    {
    	$productGallery = ProductImages::where('product_id',$productID)
										->select(
											'product_images.id as pi_id',
											'product_images.product_id as pi_product_id',
											'product_images.image as pi_image',
											'product_images.image_order as pi_order',
											'product_images.status as pi_status'
										)
										->get();

    	return $productGallery;
    }

    //relacije
    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
}
