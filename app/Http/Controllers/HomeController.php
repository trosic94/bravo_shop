<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
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
        $CatID = 96;
    	$cat_Musko = Category::CatByID($CatID);

        // Zensko
        $CatID = 95;
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
    public function contactForm(Request $request)
    {

    	$this->validateContact($request);

    	$contact = array();

        $mailData['ime_prezime'] = request('ime');
        $mailData['email'] = request('email');
        $mailData['telefon'] = request('telefon');
    	$mailData['poruka'] = request('poruka');
    	$mailData['tst'] = request('hpASSdDGT3e5345345');

    	if ($mailData['tst'] == null):

            Mail::send('emails.contact', $mailData, function($message) use ($mailData)
            {
                $message->to(setting('shop.shop_notification_email'),'Bravo Shop')
                        ->from($mailData['email'], 'Bravo Shop')
                        //->cc('petar.medarevic@onestopmarketing.rs', 'OSM')
                        // ->bcc('webmaster@onestpmarketing.rs', 'OSM')
                        ->sender($mailData['email'], $mailData['ime'])
                        ->replyTo($mailData['email'], $mailData['ime'])
                        ->subject('Kontakt sa sajta - '. $mailData['ime'].' '.$mailData['prezime']);
            });

    	endif;

        return  redirect()->back()->with('mailSent', 'Vaša poruka je poslata. Hvala.');

    }

	public function validateContact($request)
    {
    	return $this->validate($request, [
            'ime_prezime' => 'required',
    		'email' => 'required|email',
    		'poruka' => 'required'
    	]);
    }
}
