<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'manufacturer';

    protected $fillable = ['name','image','description','import_id','created_at','updated_at'];

    public static function manufacturerALL()
    {
    	$manufacturerALL = Manufacturer::all();

    	return $manufacturerALL;
    }

    public static function manufacturersByCAT($catID)
    {

    	// MANUFACTURER po kategoriji
    	$builder = DB::table('manufacturer as MNF');

    	if ($catID != 3):

    		// CATEGORY data
    		$catDATA = DB::table('categories as CAT')
    						->where('id',$catID)
    						->first();

    		if ($catDATA->parent_id == 3):

    			// ako je parent cat
    			$childCATs = DB::table('categories as CAT')
    								->where('parent_id',$catID)
    								->pluck('id')->toArray();

		    	$builder->join('products as P', function($p) use ($childCATs) {
		    					$p->on('MNF.id','P.manufacturer_id')
		    					->whereIn('P.category_id',$childCATs);
		    				});

    		else:

    			// ako je krajnja kategorija
		    	$builder->join('products as P', function($p) use ($catID) {
		    					$p->on('MNF.id','P.manufacturer_id')
		    					->where('P.category_id',$catID)
                                ->where('P.status',1); // prikazuje samo MANUFACTURERS koji imaju dodeljenih proizvoda
		    				});

    		endif;

        else:

            // ako je krajnja kategorija
            $builder->join('products as P', function($p) {
                $p->on('MNF.id','P.manufacturer_id')
                ->where('P.status',1);
            });

    	endif;


    	$mnfcByCAT = $builder->select(
		                            'MNF.id as id',
		                            'MNF.name as name',
		                            'MNF.image as image',
                                    DB::raw('count(P.manufacturer_id) AS prod_count')
		                        )
		                        ->groupBy('MNF.id')
		                        ->orderBy('MNF.name','ASC')
		                        ->get();
        
        return $mnfcByCAT;

    }


}
