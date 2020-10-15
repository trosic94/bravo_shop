<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderItems extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'order_items';

    public static function orderItemsDATA($orderID)
    {
        $orderItemsDATA = DB::table('order_items as ORDI')
                                ->join('products as PROD','ORDI.product_id','PROD.id')
                                ->join('categories as CAT','PROD.category_id','CAT.id')
                                ->where('ORDI.order_id',$orderID)
                                ->select(
                                    'ORDI.kolicina as ordi_kolicina',
                                    'ORDI.total as ordi_total',
                                    'ORDI.description as ordi_description',
                                    'PROD.sku as prod_sku',
                                    'PROD.id as prod_id',
                                    'PROD.title as prod_title',
                                    'PROD.slug as prod_slug',
                                    'PROD.excerpt as prod_excerpt',
                                    'PROD.body as prod_body',
                                    'PROD.image as prod_image',
                                    'PROD.product_price as prod_price',
                                    'PROD.product_discount as prod_discount',
                                    'PROD.product_vat as prod_vat',
                                    'CAT.name as cat_name',
                                    'CAT.slug as cat_slug',
                                    'CAT.cat_image as cat_image'
                                )
                                ->get();

        return $orderItemsDATA;
    }

    // relacije
    public function orders()
    {
        return $this->hasOne('App\Order','id','order_id');
    }
    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
    public function material()
    {
        return $this->hasOne('App\Material','id','material_id');
    }
    public function dimension()
    {
        return $this->hasOne('App\Dimension','id','dimensions_id');
    }
    
}
