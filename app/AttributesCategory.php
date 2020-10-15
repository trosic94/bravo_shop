<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


use App\Attributes;

class AttributesCategory extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'attributes_category';

    public static function catForAttr($attrID)
    {
    	$attrID = DB::table('attributes_category as ACAT')
    					->where('ACAT.attribute_id',$attrID)
    					->pluck('ACAT.category_id')->toArray();

    	return $attrID;
    }


    public static function attributesDATA_for_Category($categoryID)
    {
        $attributesDATA_tmp = DB::table('attributes_category as ATTRCAT')
        									->join('attributes as ATTR','ATTR.id','ATTRCAT.attribute_id')
        									->where('ATTRCAT.category_id',$categoryID)
        									->select(
        										'ATTR.id as attr_id',
        										'ATTR.name as attr_name',
        										'ATTR.description as attr_description',
        										'ATTR.type as attr_type',
        										'ATTR.unit as attr_unit',
        										'ATTR.image as attr_image',
        										'ATTR.status as attr_status'
        									)
        									->where('ATTR.status',1)
        									->get();

        $attributesDATA_for_Category = array();

        foreach ($attributesDATA_tmp as $ATTkey => $attribute) {

        	//Naziv za TIP atributa
        	$attributeTYPE = Attributes::attributeTYPE();
        	$choosenTYPE = $attributeTYPE[$attribute->attr_type];


			$attributesDATA_for_Category[$ATTkey]['attr_id'] = $attribute->attr_id;
			$attributesDATA_for_Category[$ATTkey]['attr_name'] = $attribute->attr_name;
			$attributesDATA_for_Category[$ATTkey]['attr_description'] = $attribute->attr_description;
			$attributesDATA_for_Category[$ATTkey]['attr_type'] = $choosenTYPE;
			$attributesDATA_for_Category[$ATTkey]['attr_type_id'] = $attribute->attr_type;
			$attributesDATA_for_Category[$ATTkey]['attr_unit'] = $attribute->attr_unit;
			$attributesDATA_for_Category[$ATTkey]['attr_image'] = $attribute->attr_image;
			$attributesDATA_for_Category[$ATTkey]['attr_status'] = $attribute->attr_status;

			$attributeValues_TMP = DB::table('attributes_values as ATTRVAL')
										->where('ATTRVAL.attribute_id',$attribute->attr_id)
										->select(
											'ATTRVAL.id as val_id',
											'ATTRVAL.label as val_label',
											'ATTRVAL.value as val_value',
											'ATTRVAL.value_order as val_order',
											'ATTRVAL.status as val_status',
											'ATTRVAL.price as val_price',
											'ATTRVAL.image as val_image'
										)
										->where('ATTRVAL.status',1)
										->get();

			foreach ($attributeValues_TMP as $VALkey => $val) {

				$attributesDATA_for_Category[$ATTkey]['attr_values'][$VALkey]['id'] = $val->val_id;
				$attributesDATA_for_Category[$ATTkey]['attr_values'][$VALkey]['label'] = $val->val_label;
				$attributesDATA_for_Category[$ATTkey]['attr_values'][$VALkey]['value'] = $val->val_value;
				$attributesDATA_for_Category[$ATTkey]['attr_values'][$VALkey]['order'] = $val->val_order;
				$attributesDATA_for_Category[$ATTkey]['attr_values'][$VALkey]['status'] = $val->val_status;
				$attributesDATA_for_Category[$ATTkey]['attr_values'][$VALkey]['price'] = $val->val_price;
				$attributesDATA_for_Category[$ATTkey]['attr_values'][$VALkey]['image'] = $val->val_image;
				
			}

        }

        return $attributesDATA_for_Category;
    }



    // relacije
    public function Attributes()
    {
        return $this->hasOne('App\Attributes','id','attribute_id');
    }
}