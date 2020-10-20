<?php

namespace App\Http\Controllers;

//use TCG\Voyager\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PDO;
use Carbon\Carbon;

use App\Home;
use App\Sliders;
use App\SlidersItems;
use App\Product;
use App\SpecialOptionForProducts;
use App\Banner;

use App\Post;
use App\Category;
use App\Gallery;

class HomeController extends Controller
{
    public function index()
    {

    	// Category ----------------------------------------------
        $maxID=0;
        // Musko
        $CatID = 102;
    	$cat_Musko = Category::CatByID($CatID);

        // Zensko
        $CatID = 103;
        $cat_Zensko = Category::CatByID($CatID);
        // Distributer
        $CatID = 104;
        $cat_Distributer = Category::CatByID($CatID);


        // Benefiti ----------------------------------------------
        $oNama = Post::oNama();

        // Gallery -----------------------------------------------
        $gallery = Gallery::with('GalleryItems')->where('id',1)->first();

        // BANNERS -------------------------------------------------------------- //

        // Home Wide
        $banners_homeWide = Banner::allBannersByPosition(3);
        // Row 1
        $banners_homeRow_1 = Banner::allBannersByPosition(4);
        // Row 2
        $banners_homeRow_2 = Banner::allBannersByPosition(5);
        // Row 2 - company
        $banners_homeRow_3 = Banner::allBannersByPosition(6);

    	return view('home.index', compact('cat_Musko','cat_Zensko','cat_Distributer',
                                            'oNama','gallery','maxID','banners_homeWide','banners_homeRow_1','banners_homeRow_2','banners_homeRow_3'));
    }
}
