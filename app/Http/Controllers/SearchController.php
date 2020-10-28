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
        //zbog checkbox-a
        $categorySLUG = 'search';
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

               // Pretraga po MANUFACTURERS
        if (count($mfc_SRCH) > 0):
            $builder->whereIn('M.id',$mfc_SRCH);
        endif;

        // Pretraga po PRICE RANGEs
        if (count($searchREQ['price']) > 0):

            if (count($searchREQ['price']) == 1):

                $comparePRICE = explode('|', $searchREQ['price'][0]);

                $startPRICE1 = $comparePRICE[0];
                $endPRICE1 = $comparePRICE[1];


                $builder->whereBetween('PROD.product_price',[$startPRICE1,$endPRICE1]);

            else:

                //return $searchREQ['price'];
                switch (count($searchREQ['price'])) {
                    case 2:

                            $comparePRICE_1 = explode('|', $searchREQ['price'][0]);
                            $range1 = array($comparePRICE_1[0],$comparePRICE_1[1]);

                            $comparePRICE_2 = explode('|', $searchREQ['price'][1]);
                            $range2 = array($comparePRICE_2[0],$comparePRICE_2[1]);

                            $builder->where(function ($a) use ($range1,$range2) {
                                        $a->whereBetween('PROD.product_price',$range1)
                                        ->orWhereBetween('PROD.product_price',$range2);
                                    });

                        break;
                    
                    case 3:

                            $comparePRICE_1 = explode('|', $searchREQ['price'][0]);
                            $range1 = array($comparePRICE_1[0],$comparePRICE_1[1]);

                            $comparePRICE_2 = explode('|', $searchREQ['price'][1]);
                            $range2 = array($comparePRICE_2[0],$comparePRICE_2[1]);

                            $comparePRICE_3 = explode('|', $searchREQ['price'][2]);
                            $range3 = array($comparePRICE_3[0],$comparePRICE_3[1]);

                            $builder->where(function ($a) use ($range1,$range2,$range3) {
                                        $a->whereBetween('PROD.product_price',$range1)
                                        ->orWhereBetween('PROD.product_price',$range2)
                                        ->orWhereBetween('PROD.product_price',$range3);
                                    });

                        break;

                    case 4:

                            $comparePRICE_1 = explode('|', $searchREQ['price'][0]);
                            $range1 = array($comparePRICE_1[0],$comparePRICE_1[1]);

                            $comparePRICE_2 = explode('|', $searchREQ['price'][1]);
                            $range2 = array($comparePRICE_2[0],$comparePRICE_2[1]);

                            $comparePRICE_3 = explode('|', $searchREQ['price'][2]);
                            $range3 = array($comparePRICE_3[0],$comparePRICE_3[1]);

                            $comparePRICE_4 = explode('|', $searchREQ['price'][2]);
                            $range4 = array($comparePRICE_4[0],$comparePRICE_4[1]);

                            $builder->where(function ($a) use ($range1,$range2,$range3,$range4) {
                                        $a->whereBetween('PROD.product_price',$range1)
                                        ->orWhereBetween('PROD.product_price',$range2)
                                        ->orWhereBetween('PROD.product_price',$range3)
                                        ->orWhereBetween('PROD.product_price',$range4);
                                    });

                        break;

                    case 5:

                            $comparePRICE_1 = explode('|', $searchREQ['price'][0]);
                            $range1 = array($comparePRICE_1[0],$comparePRICE_1[1]);

                            $comparePRICE_2 = explode('|', $searchREQ['price'][1]);
                            $range2 = array($comparePRICE_2[0],$comparePRICE_2[1]);

                            $comparePRICE_3 = explode('|', $searchREQ['price'][2]);
                            $range3 = array($comparePRICE_3[0],$comparePRICE_3[1]);

                            $comparePRICE_4 = explode('|', $searchREQ['price'][2]);
                            $range4 = array($comparePRICE_4[0],$comparePRICE_4[1]);

                            $comparePRICE_5 = explode('|', $searchREQ['price'][2]);
                            $range5 = array($comparePRICE_5[0],$comparePRICE_5[1]);

                            $builder->where(function ($a) use ($range1,$range2,$range3,$range4,$range5) {
                                        $a->whereBetween('PROD.product_price',$range1)
                                        ->orWhereBetween('PROD.product_price',$range2)
                                        ->orWhereBetween('PROD.product_price',$range3)
                                        ->orWhereBetween('PROD.product_price',$range4)
                                        ->orWhereBetween('PROD.product_price',$range5);
                                    });

                        break;

                    case 5:

                            $comparePRICE_1 = explode('|', $searchREQ['price'][0]);
                            $range1 = array($comparePRICE_1[0],$comparePRICE_1[1]);

                            $comparePRICE_2 = explode('|', $searchREQ['price'][1]);
                            $range2 = array($comparePRICE_2[0],$comparePRICE_2[1]);

                            $comparePRICE_3 = explode('|', $searchREQ['price'][2]);
                            $range3 = array($comparePRICE_3[0],$comparePRICE_3[1]);

                            $comparePRICE_4 = explode('|', $searchREQ['price'][2]);
                            $range4 = array($comparePRICE_4[0],$comparePRICE_4[1]);

                            $comparePRICE_5 = explode('|', $searchREQ['price'][2]);
                            $range5 = array($comparePRICE_5[0],$comparePRICE_5[1]);

                            $comparePRICE_6 = explode('|', $searchREQ['price'][2]);
                            $range6 = array($comparePRICE_6[0],$comparePRICE_6[1]);

                            $builder->where(function ($a) use ($range1,$range2,$range3,$range4,$range5,$range6) {
                                        $a->whereBetween('PROD.product_price',$range1)
                                        ->orWhereBetween('PROD.product_price',$range2)
                                        ->orWhereBetween('PROD.product_price',$range3)
                                        ->orWhereBetween('PROD.product_price',$range4)
                                        ->orWhereBetween('PROD.product_price',$range5)
                                        ->orWhereBetween('PROD.product_price',$range6);
                                    });

                        break;

                }

            endif;

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

        return view('search.index', compact('slug','CATCurrent','searchREQ','currentCAT','favLIST','searchREZ','navCategory','manufacturers','categorySLUG'));
    }


}