<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Auth;

class ProductFavourites extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'products_favourites';

    protected $fillable = ['user_id','product_id','created_at','updated_at'];

    public static function productsFor_FAV($favLIST)
    {
        $allProducts = DB::table('products as PROD')
                            ->join('categories as CAT','PROD.category_id','CAT.id')
                            ->leftJoin('categories as PCAT','CAT.parent_id','PCAT.id')
                            ->join('manufacturer as M','PROD.manufacturer_id','M.id')
                            ->leftJoin('special_options_products as SOP','SOP.product_id','PROD.id')
                            ->leftJoin('badges_products as BP','BP.product_id','PROD.id')
                            ->leftJoin('badges as B','B.id','BP.badge_id')
                            ->whereIn('PROD.id',$favLIST)
                            ->where('PROD.status',1)
                            ->select(
                                'PROD.id as prod_id',
                                'PROD.sku as prod_sku',
                                'PROD.title as prod_title',
                                'PROD.slug as prod_slug',
                                'PROD.category_id as prod_cat_id',
                                'PROD.manufacturer_id as prod_mnf_id',
                                'PROD.excerpt as prod_excerpt',
                                'PROD.body as prod_body',
                                'PROD.specification as prod_specification',
                                'PROD.image as prod_image',
                                'PROD.video as prod_video',
                                'PROD.status as prod_status',
                                'PROD.featured as prod_featured',
                                'PROD.product_price as prod_price',
                                'PROD.product_discount as prod_discount',
                                'PROD.product_price_with_discount as prod_price_with_discount',
                                'PROD.product_discount as prod_discount',
                                'PROD.product_vat as prod_vat',
                                'PROD.meta_description as prod_meta_description',
                                'PROD.meta_keywords as prod_meta_keywords',
                                'PROD.created_at as prod_created_at',
                                'PROD.updated_at as prod_updated_at',
                                'CAT.parent_id as cat_parent_id',
                                'CAT.name as cat_name',
                                'CAT.slug as cat_slug',
                                'CAT.cat_image as cat_image',
                                'CAT.published as cat_published',
                                'CAT.use_product_price as cat_use_product_price',
                                'PCAT.id as pcat_id',
                                'PCAT.name as pcat_name',
                                'PCAT.slug as pcat_slug',
                                'M.id as mnf_id',
                                'M.name as mnf_name',
                                'M.import_id as mnf_import_id',
                                'B.title as b_title',
                                'B.color as b_color',
                                'B.text_color as b_text_color',
                                DB::raw('count(SOP.product_id) as sop_count')
                            )
                            ->groupBy('PROD.id')
                            ->paginate(16);

        return $allProducts;
    }

    public static function addFAVtiDB($favList)
    {

    	$ulogovan = Auth::user();

    	// DELETE sve FAV proizvode
    	$favourites_DELETEall = ProductFavourites::where('user_id',$ulogovan->id)->delete();

    	// ako ima proizvoda u FAV sess upisujem u DB
        if (count($favList) > 0):

            for ($fdb=0; $fdb < count($favList); $fdb++) {

            	// INSER proizvoda u FAV
                $favourites_INSERT = ProductFavourites::insert([
                	'user_id' => $ulogovan->id,
                	'product_id' => $favList[$fdb]
                ]);
                
            }

        endif;

        return count($favList);

    }
}
