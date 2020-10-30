<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\AttributesProduct;
use App\AttributesCategory;
use App\Manufacturer;
use App\BreadCrumb;
use App\RatingOption;
use App\RatingVote;
use App\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use URL;
use Redirect;
use Auth;

class CategoryController extends Controller
{
 	public function index()
    {

        $storeCAT = Category::shopCAT();
    	
    	$title = 'Proizvodi';
    	$intro = 'Pregled svih proizvoda';

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

        // FAV proizvodi
        $favSESS = Session::get('fav');

        $favLIST = array();

        if ($favSESS):
            $favLIST = $favSESS;
        endif;

        // spremam search request za priakaz na rezultatu
        $searchREQ['mfc'] = array();
        $searchREQ['available'] = '';
        $searchREQ['price'] = array();

        // Current category
        $CATCurrent = $storeCAT;

        // aktivna kategorija PROIZVODI
    	$category = Category::where('id',$CATCurrent)->first();

        // Meta Tagovi postavljeni za odabranu kategoriju
        $metaTitle = $category->name;
        $metaDescription = $category->meta_description;
        $metaKeywords = $category->meta_keywords;

        // LEFT
        $navCategory = Category::where('parent_id',$storeCAT)
                        ->with('childrenCategories')
                        ->get();

        // MANUFACTURERS
        $manufacturers = Manufacturer::manufacturersByCAT($storeCAT);

        // svi proizvodi
        $allProducts = Product::allProducts();

    	return view('category.index', compact('intro','title','slug','searchREQ','favLIST','storeCAT','category','CATCurrent','metaTitle','metaDescription','metaKeywords',
                                                'navCategory','manufacturers',
                                                'allProducts'));
    }

    public function categories($categories)
    {
        

        $storeCAT = Category::shopCAT();

        // FAV proizvodi -------------------------- //
        $favSESS = Session::get('fav');

        $favLIST = array();

        if ($favSESS):
            $favLIST = $favSESS;
        endif;
        // FAV proizvodi -------------------------- //

        // spremam search request za priakaz na rezultatu -------- //
        $searchREQ['mfc'] = array();
        $searchREQ['available'] = '';
        $searchREQ['price'] = array();
        // spremam search request za priakaz na rezultatu -------- //

        // fetch current CAT from url
        $fullURL = explode('/', $categories);
        $catFromURL = $fullURL;

        $categorySLUG = end($catFromURL);
        array_pop($catFromURL);

        // ako postoji kategoirja sa istim SLUGom proveravam da li se slaze sa URLom ------------------------------------- //
        $categoryW_Parents = Category::where('slug',$categorySLUG)->get();

        // ako je pronadjena KATEGORIJA sa URLom $categorySLUG
        if (!$categoryW_Parents->isEmpty()):

            // ako postoji vise kategorija sa istim SLUGom, proveravam koja je "aktivna"
            $choosenCAT = Category::chkCATbyAllParent_VS_URL($categoryW_Parents,$catFromURL);

            // current CAT data
            $currentCAT = DB::table('categories as CAT')
                                    ->leftJoin('categories as PCAT','CAT.parent_id','PCAT.id')
                                    ->where('CAT.id',$choosenCAT)
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

            // saljem prazan niz zbog funkcije
            $productDATA = array();

            // kreiram BC za odabranu KATEGORIJU
            $slug = BreadCrumb::makeBC($currentCAT,$catFromURL,$productDATA);

            // page META data
            $metaTitle = $currentCAT->name;
            $metaDescription = $currentCAT->meta_description;
            $metaKeywords = $currentCAT->meta_keywords;

            // Current category
            $CATCurrent = $currentCAT->id;

            // LEFT
            $navCategory = Category::where('parent_id',$storeCAT)
                                    ->with('childrenCategories')
                                    ->get();

            // MANUFACTURERS
            $manufacturers = Manufacturer::manufacturersByCAT($currentCAT->id);

            // NADJI sve child categorije!!!! --------------------------------------- //
            $allCAT_w_Child = Category::getAllChildCAT_IDs($currentCAT->id);
            // odajem tekucu kategoriju
            array_push($allCAT_w_Child, $currentCAT->id);

            // PRODUCTS
            $productsFor_CAT = Product::productsBy_CAT_IDs($allCAT_w_Child);

            // ATRIBUTi za SVE
            $allAttributesForAll = AttributesCategory::attributesDATA_for_All();
                                      
            return view('category.category', compact('slug','favLIST','searchREQ','currentCAT','CATCurrent','metaTitle','metaDescription','metaKeywords',
                                                        'navCategory','manufacturers',
                                                        'productsFor_CAT','categoryW_Parents','allCAT_w_Child','categorySLUG','allAttributesForAll'));


        else:

            $ulogovan = Auth::user();

            $daLiMozeDaOcenjujeIKomentarise = 0;
            $daLiJeKupioProizvod = array();

            

            

            // PRODUCT data
            $productDATA = Product::productDATA_bySLUG($categorySLUG);

            $ratingOptions = RatingOption::productRating();
            $productRate = round(RatingVote::productRate($productDATA->prod_id), 1);
            $ratingComments = RatingVote::ratingComments($productDATA->prod_id);

            if (!Auth::guest()):

                $daLiJeKupioProizvod = Order::ifProductOrderedByCustomer($productDATA->prod_id,$ulogovan->id);

                if ($daLiJeKupioProizvod):

                    $daLiMozeDaOcenjujeIKomentarise = 1;

                endif;

            endif;

            $productSizes = DB::table('attributes_values as av')
                                ->leftJoin('attributes_product as ap', function($join) use ($productDATA) {
                                    $join->on('av.id', '=', 'ap.attribute_value_id');
                                    $join->where('ap.product_id', $productDATA->prod_id);
                                })->where('av.attribute_id',15)->get();

            /*$productSizes = DB::table('attributes_values as av')
                                ->join('attributes_product as ap','ap.attribute_value_id','=','av.id')
                                ->where('av.attribute_id',15)
                                ->where('ap.product_id', $productDATA->prod_id)
                                ->get();*/

            // current CAT data
            $currentCAT = DB::table('categories as CAT')
                                    ->leftJoin('categories as PCAT','CAT.parent_id','PCAT.id')
                                    ->where('CAT.id',$productDATA->prod_cat_id)
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

            // kreiram BC za odabrani PROIZVOD
            $slug = BreadCrumb::makeBC($currentCAT,$catFromURL,$productDATA);


            // page META data
            $metaTitle = $productDATA->prod_title;
            $metaDescription = $productDATA->prod_meta_description;
            $metaKeywords = $productDATA->prod_meta_keywords;

            // PRODUCT options
            $selectedAttributes = AttributesProduct::selectedAttributes_ForProduct($productDATA->prod_id);

            // ATRIBUTi za PROIZVOD
            $allAttributesForProduct = AttributesCategory::attributesDATA_for_Category($productDATA->prod_cat_id);


            // odabrane VREDNOSTI ATRIBUTA za PROIZVOD
            $odabraneVrednostiAtributaZaProizvod = AttributesProduct::selectedAttributesValue_ForProduct($productDATA->prod_id);


            // product rading
            $ratingOptions = array();
            if (setting('shop.rating') == 1):
                $ratingOptions = RatingOption::productRating();
            endif;


            return view('product.index', compact('slug','favLIST','metaTitle','metaDescription','metaKeywords',
                                                    'productDATA','selectedAttributes','allAttributesForProduct','odabraneVrednostiAtributaZaProizvod',
                                                    'catFromURL',
                                                    'ratingOptions','productSizes','ratingOptions','productRate','ratingComments','daLiJeKupioProizvod','daLiMozeDaOcenjujeIKomentarise'));


        endif;
    }

    public function findeCAT(Request $request)
    {

        $parentCAT = request('catID');
        $productType = request('productType');

        // pronadji sve CHILD categorije
        $getCATList = Category::subCatByParentID($parentCAT);

        // kreiraj HTML za select
        $catSEL_HTML = '<option value="" disabled selected>'.trans('shop.title_choose').'</option>';

        if ($getCATList):

            foreach ($getCATList as $key => $category) {
                $catSEL_HTML .= '<option value="'.$category->cat_id.'|'.$category->cat_slug.'">'.$category->cat_name.'</option>';                
            }

        endif;

        return $catSEL_HTML;
    }

    public function submitCAT(Request $request)
    {

        // site URL ---------------------------------------------------------- //
        $url = URL::to('/');

        $shopCATslug = Category::shopCAT_Slug();
        $url = $url.'/'.$shopCATslug;

        // Type URL ---------------------------------------------------------- //
        $pType = request('pType');

        switch ($pType) {
            case 'T':
                $url = $url.'/trakice';
                break;
            case 'M':
                $url = $url.'/zastitne-maske';
                break;
        }

        // choosen CAT URL --------------------------------------------------- //
        if (request('selLevel1_'.$pType)):
            $catLVL1 = explode('|', request('selLevel1_'.$pType));
            $cat1 = $catLVL1[1];
            $url = $url.'/'.$cat1;
        endif;

        if (request('selLevel2_'.$pType)):
            $catLVL2 = explode('|', request('selLevel2_'.$pType));
            $cat2 = $catLVL2[1];
            $url = $url.'/'.$cat2;
        endif;

        if (request('selLevel3_'.$pType)):
            $catLVL3 = explode('|', request('selLevel3_'.$pType));
            $cat3 = $catLVL3[1];
            $url = $url.'/'.$cat3;
        endif;


        return Redirect::to($url);
    }

}
