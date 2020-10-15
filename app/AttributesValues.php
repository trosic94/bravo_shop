<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class AttributesValues extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'attributes_values';

    public static function attributeVALUES($id)
    {
    	$attributeVALUES = DB::table('attributes_values as ATTRVAL')
                                ->where('ATTRVAL.attribute_id',$id)
                                ->select(
                                	'ATTRVAL.id as attrval_id',
                                	'ATTRVAL.attribute_id as attrval_attribute_id',
                                	'ATTRVAL.status as attrval_status',
                                	'ATTRVAL.label as attrval_label',
                                	'ATTRVAL.value as attrval_value',
                                	'ATTRVAL.value_order as attrval_order'
                                )
                                ->orderBy('ATTRVAL.value_order','ASC')
                                ->get();

    	return $attributeVALUES;
    }

    public static function attributeVALUESbyID($id)
    {
        $attributeVALUES = DB::table('attributes_values as ATTRVAL')
                                ->where('ATTRVAL.id',$id)
                                ->select(
                                    'ATTRVAL.id as attrval_id',
                                    'ATTRVAL.attribute_id as attrval_attribute_id',
                                    'ATTRVAL.status as attrval_status',
                                    'ATTRVAL.label as attrval_label',
                                    'ATTRVAL.value as attrval_value',
                                    'ATTRVAL.value_order as attrval_order'
                                )
                                ->orderBy('ATTRVAL.value_order','ASC')
                                ->first();

        return $attributeVALUES;
    }



    // relacije
    public function Attributes()
    {
        return $this->hasOne('App\Attributes','id','attribute_id');
    }
}
