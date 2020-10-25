<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Banner;
use App\Category;
use App\Post;
use App\Page;

class ZaposlenjeController extends Controller
{
    public function index()
	{
        $title = 'Zaposlenje';
        $metaTitle = 'Zaposlenje';
		$slug = array(
            '0' => array(
                'slug' => '/',
                'title' => trans('shop.title_home'),
                'active' => '',
            ),
            '1' => array(
                'slug' => trans('shop.slug_url_zaposlenje'),
                'title' => trans('shop.slug_title_zaposlenje'),
                'active' => 'active',
            )
        );
        // Current category
    
        
    	return view('zaposlenje',compact('title','slug','metaTitle'));
    }

    public function getKonkursi()
    {
        $title = 'Zaposlenje';
        $metaTitle = 'Zaposlenje';
		$slug = array(
            '0' => array(
                'slug' => '/',
                'title' => trans('shop.title_home'),
                'active' => '',
            ),
            '1' => array(
                'slug' => 'zaposlenje',
                'title' => 'Zaposlenje',
                'active' => 'active',
            )
        );
        $konkursi = array();
        $konkursi = DB::table('konkursi as KON')
        ->select(DB::raw('DATE_FORMAT(KON.vazi_do,"%d.%m.%Y.") as vazi_do'),
            'KON.naslov as naslov',
            'KON.mesto_rada as mesto'            
        )
        ->whereRaw('KON.vazi_do >= CURDATE()')
        ->orderBy('KON.vazi_do','ASC')->get();

        //dd($konkursi);          
        $page = Page::where('slug','zaposlenje_page')->first();

    



        return view('zaposlenje',compact('title','slug','metaTitle','konkursi','page'));

    }

}
