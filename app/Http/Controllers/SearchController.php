<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Manufacturer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Auth;
use URL;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Input;

class SearchController extends Controller
{

	public function search(Request $request)
    {
        $storeCAT = Category::shopCAT();

        $srchString = request('PRETRAGA');
        session()->flashInput($request->input());

        // PRETRAGA ----------------------------------------------------------------------------- //
        $builder = DB::table('products as PROD');

        $builder->join('categories as CAT','PROD.category_id','CAT.id')
                ->leftJoin('categories as PCAT','CAT.parent_id','PCAT.id')
                ->join('manufacturer as M','PROD.manufacturer_id','M.id')
                ->leftJoin('special_options_products as SOP','SOP.product_id','PROD.id')
                ->leftJoin('badges_products as BP','BP.product_id','PROD.id')
                ->leftJoin('badges as B','B.id','BP.badge_id');

        

        // uzimam samo AKTIVNE PROIZVODE
        $builder->where('PROD.status',1);

        // uzimam samo ako je CENA nije 0
        $builder->where('PROD.product_price','!=',0);


        if ($srchString != ''):

            $builder->where(function($query) use ($srchString){
                $query->whereRaw('LOWER(PROD.title) LIKE ? ',trim('%'.strtolower($srchString)).'%')
                ->orWhereRaw('LOWER(PROD.sku) LIKE ? ',trim('%'.strtolower($srchString)).'%')
                ->orWhereRaw('LOWER(PROD.excerpt) LIKE ? ',trim('%'.strtolower($srchString)).'%')
                ->orWhereRaw('LOWER(PROD.body) LIKE ? ',trim('%'.strtolower($srchString)).'%')
                ->orWhereRaw('LOWER(PROD.specification) LIKE ? ',trim('%'.strtolower($srchString)).'%')
                ->orWhereRaw('LOWER(CAT.name) LIKE ? ',trim('%'.strtolower($srchString)).'%');
            });

        endif;

        $searchREZ = $builder->select(
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
                                'PROD.on_stock as prod_on_stock',
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
                            ->paginate(12);


        // FAV proizvodi
        $favSESS = Session::get('fav');

        $favLIST = array();

        if ($favSESS):
            $favLIST = $favSESS;
        endif;

        // Current category
        $CATCurrent = $storeCAT;

        // LEFT
        $navCategory = Category::where('parent_id',$storeCAT)
                        ->with('childrenCategories')
                        ->get();

        // MANUFACTURERS
        $manufacturers = Manufacturer::manufacturersByCAT($storeCAT);

		return view('search.index', compact('favLIST','searchREZ','navCategory','manufacturers','CATCurrent'));
    }


}
