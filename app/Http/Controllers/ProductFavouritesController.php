<?php

namespace App\Http\Controllers;

use App\Product;
use App\Categor;
use App\ProductFavourites;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Auth;

class ProductFavouritesController extends Controller
{
    public function favList()
    {

        // FAV proizvodi
        $favSESS = Session::get('fav');

        $favLIST = array();

        if ($favSESS):
            $favLIST = $favSESS;
        endif;

        $productsFor_FAV = ProductFavourites::productsFor_FAV($favLIST);

        return view('favourites.index', compact('favLIST','productsFor_FAV'));

    }


    public function favEvent(Request $request)
    {

        // FAV sesija
        $favOLD = Session::get('fav');


        // proizvod
        $prodID = request('prodID');

        $favList = array();
        $favList = $favOLD;

        if ($favOLD):

            // proveravam da li je proizvod u FAV
            if (in_array($prodID, $favList)):

                for ($f=0; $f < count($favList); $f++) { 

                    // ako jeste, REMOVE
                    if ($favList[$f] == $prodID):
                        // sklanjam proizvod iz FAV
                        unset($favList[$f]);
                    endif;

                }

                $favList = array_values($favList);

            else:

                // FAV ima proizvoda
                // ADD proizvod u FAV
                array_push($favList,$prodID);

            endif;

        else:

            $favList = array();

            // FAV je prazan
            // ADD proizvod u FAV
            array_push($favList,$prodID);

        endif;

        // kreiram novu sesiju za fav
        Session::forget('fav',$favList);
        Session::put('fav',$favList);


        if (Auth::check()):

            $addFAVtoDB = ProductFavourites::addFAVtiDB($favList);

            return $addFAVtoDB;

        endif;




        return count($favList);

    }
}
