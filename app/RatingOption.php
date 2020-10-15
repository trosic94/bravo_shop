<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RatingOption extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'rating_options';

    protected $fillable = ['name','value','status'];


    public static function productRating()
    {
        //PRODUCT data
        $productRating = DB::table('rating_options as RO')
        					->where('RO.status',1)
                            ->select(
                            	'RO.id as ro_id',
                            	'RO.name as ro_name',
                            	'RO.value as ro_value'
                            )
                            ->orderBy('RO.rating_order','ASC')
                            ->get();

        return $productRating;
    }
}
