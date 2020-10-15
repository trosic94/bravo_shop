<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Attributes extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'attributes';

    public static function attributeTYPE()
    {
    	$attributeTYPE = array(
    		'' => trans('shop_admin.title_choose').'...',
    		//'1' => 'Text',
    		'2' => 'Select',
    		'3' => 'Multiselect',
    		'4' => 'Checkbox',
    		'5' => 'Radio button',
    		//'6' => 'Date',
            '7' => 'Color',
    	);

    	return $attributeTYPE;
    }

    public static function attributeDATA($id)
    {
    	$attributeDATA = DB::table('attributes as ATTR')
                                ->where('ATTR.id',$id)
                                ->select(
                                	'ATTR.id as attr_id',
                                	'ATTR.name as attr_title',
                                	'ATTR.description as attr_description',
                                	'ATTR.type as attr_type',
                                	'ATTR.unit as attr_unit',
                                    'ATTR.status as attr_status',
                                	'ATTR.image as attr_image'
                                )
                                ->first();

    	return $attributeDATA;
    }


    // relacije
    public function AttributesValues()
    {
        return $this->hasMany('App\AttributesValues','attribute_id','id');
    }
    public function AttributesCategory()
    {
        return $this->hasMany('App\AttributesCategory','attribute_id','id');
    }

}
