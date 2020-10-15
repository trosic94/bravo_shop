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

        // Trakice
        $parentCatID = 95;
    	$cat_Trakice = Category::subCatByParentID($parentCatID);

        // Maske
        $parentCatID = 96;
        $cat_ZastitneMaske = Category::subCatByParentID($parentCatID);      


        // Benefiti ----------------------------------------------
        $benefits = Post::benefits();

        // Gallery -----------------------------------------------
        $gallery = Gallery::with('GalleryItems')->where('id',1)->first();

    	return view('home.index', compact('cat_Trakice','cat_ZastitneMaske',
                                            'benefits','gallery'));
    }
}
