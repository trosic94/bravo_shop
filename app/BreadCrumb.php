<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use URL;

use App\Category;

class BreadCrumb extends Model
{
    public static function makeBC($currentCAT,$catFromURL,$productDATA)
    {

        // SLUG for BreadCrumb
        $slug = array(
            '0' => array(
                'slug' => URL::to('/'),
                'title' => trans('shop.title_home'),
                'active' => '',
            ),
        );

        $bcCNT = 1;

        $catForBreadcrumb = array();
        $parentURL = $slug[0]['slug'];

        // kreiram BC za kategorije izmedju PRVE i AKTIVNE, ako postoje
        if ($catFromURL):

            foreach ($catFromURL as $key => $catSLUG) {


                $catForBreadcrumb = DB::table('categories as CAT')
                                        ->leftJoin('categories as PCAT','CAT.parent_id','PCAT.id')
                                        ->where('CAT.slug',$catSLUG)
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

                if ($catForBreadcrumb):

                    $parentURL = $parentURL.'/'.$catForBreadcrumb->pcat_slug;

                    $slug[$bcCNT] = array(
                        'slug' => $parentURL.'/'.$catForBreadcrumb->slug,
                        'title' => $catForBreadcrumb->name,
                        'active' => '',
                    );


                    $bcCNT++;

                endif;

            }

        endif;
        

        if (!$productDATA):

	        // Kreiram BC za AKTIVNU kategoriju --------------------------
	        $parentURL = $parentURL.'/'.$currentCAT->pcat_slug;

	        $slug[$bcCNT] = array(
	                'slug' => $parentURL.'/'.$currentCAT->slug,
	                'title' => $currentCAT->name,
	                'active' => 'active',
	            );

    	else:

	        // Kreiram BC za odabrani PROIZVOD ---------------------------
	        $parentURL = $parentURL.'/'.$currentCAT->slug;

	        $slug[$bcCNT] = array(
	                'slug' => $parentURL.'/'.$productDATA->prod_slug,
	                'title' => $productDATA->prod_title,
	                'active' => 'active',
	            );

    	endif;

        return $slug;

    }
}
