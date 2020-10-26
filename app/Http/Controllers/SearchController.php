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


        $CATCurrent = request('CATCurrent');
        if ($CATCurrent == null):
            $CATCurrent = $storeCAT;
        endif;


        $srchString = request('PRETRAGA');
        session()->flashInput($request->input());


                // podaci za pretragu
        $mfc_SRCH = array();
        if (request('mfc') != ''):
            $mfc_SRCH = explode(',', request('mfc'));
        endif;
        
        $available_SRCH = request('available');

        $price_SRCH = array();
        if (request('price') != ''):
            $price_SRCH = explode(',', request('price'));
        endif;

        // spremam search request za priakaz na rezultatu
        $searchREQ = array();
        $searchREQ['mfc'] = $mfc_SRCH;
        $searchREQ['available'] = $available_SRCH;
        $searchREQ['price'] = $price_SRCH;

        //return $mfc_SRCH;

        //return request('price');
        //return $CATCurrent;

        // current CAT data
        $currentCAT = DB::table('categories as CAT')
                                ->leftJoin('categories as PCAT','CAT.parent_id','PCAT.id')
                                ->where('CAT.id',$CATCurrent)
                                ->select(
                                    'CAT.id as id',
                                    'CAT.name as name',
                                    'CAT.slug as slug',
                                    'CAT.parent_id as parent_id',
                                    'CAT.meta_description as meta_description',
                                    'CAT.meta_keywords as meta_keywords',
                                    'PCAT.name as pcat_name',
                                    'PCAT.slug as pcat_slug'
                                )
                                ->first();

        //return json_encode($currentCAT);

        // SLUG ---------------------------------------------------------------------------------- //
        if ($currentCAT->parent_id == null):

            $slug = array(
                '0' => array(
                    'slug' => '/',
                    'title' => trans('shop.title_home'),
                    'active' => '',
                ),
                '1' => array(
                    'slug' => trans('shop.slug_url_products'),
                    'title' => trans('shop.slug_title_products'),
                    'active' => 'active',
                )
            );
    
            elseif ($currentCAT->parent_id != null):
    
                $slug = array(
                    '0' => array(
                        'slug' => '/',
                        'title' => trans('shop.title_home'),
                        'active' => '',
                    ),
                    '1' => array(
                        'slug' => trans('shop.slug_url_products'),
                        'title' => trans('shop.slug_title_products'),
                        'active' => '',
                    ),
                    '2' => array(
                        'slug' => trans('shop.slug_url_products').'/'.$currentCAT->slug,
                        'title' => $currentCAT->name,
                        'active' => 'active',
                    )
                );
    
            endif;
        // SLUG ---------------------------------------------------------------------------------- //



        // PRETRAGA ----------------------------------------------------------------------------- //
        $builder = DB::table('products as PROD');

        $builder->join('categories as CAT','PROD.category_id','CAT.id')
                ->leftJoin('categories as PCAT','CAT.parent_id','PCAT.id')
                ->join('manufacturer as M','PROD.manufacturer_id','M.id')
                ->leftJoin('special_options_products as SOP','SOP.product_id','PROD.id')
                ->leftJoin('badges_products as BP','BP.product_id','PROD.id')
                ->leftJoin('badges as B','B.id','BP.badge_id');


        if ($currentCAT->parent_id == null):

            // nema filtera po kategoriji jer se pretrazuju svi proizvodi

        elseif ($currentCAT->parent_id != null):

            $numberOfChildCATs = Category::where('parent_id',$currentCAT->id)->count();

            if ($numberOfChildCATs > 0):
            // ako je parent cat
                // $childCATs = DB::table('categories as CAT')
                //                     ->where('parent_id',$currentCAT->id)
                //                     ->pluck('id')->toArray();

                $allChilds = Category::getAllChildCAT_IDs($currentCAT->id);

                $builder->whereIn('PROD.category_id',$allChilds);

            else:
                $builder->where('PROD.category_id',$currentCAT->id);
            endif;
        else:

            $builder->where('PROD.category_id',$currentCAT->id);

        endif;



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


        // LEFT
        $navCategory = Category::where('parent_id',$storeCAT)
                        ->with('childrenCategories')
                        ->get();

        // MANUFACTURERS
        $manufacturers = Manufacturer::manufacturersByCAT($storeCAT);

		return view('search.index', compact('favLIST','searchREZ','navCategory','manufacturers','CATCurrent'));
    }


}
