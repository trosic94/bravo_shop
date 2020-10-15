<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AttributesProduct extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'attributes_product';

    public static function selectedAttributesValue_ForProduct($productID)
    {
        //PRODUCT data
        $attributeVAL_DATA = DB::table('attributes_product as ATTRPROD')
                            ->where('ATTRPROD.product_id',$productID)
                            ->select(
                                'ATTRPROD.attribute_id as attr_id',
                                'ATTRPROD.attribute_value_id as attr_value_id',
                                'ATTRPROD.product_id as prod_id'
                            )
                            ->get();

        $attrIDs_tmp = $attributeVAL_DATA->pluck('attr_id');

		$attrIDs = array();

		// jedinstveni IDjevi za dostupne atribute
		foreach ($attrIDs_tmp as $key => $attrID) {

			if (!in_array($attrID, $attrIDs)):
				array_push($attrIDs, $attrID);
			endif;
			
		}

		// spremiti odabrane vrednosti
        $attrVALUES = array();

        foreach ($attrIDs as $aKey => $aID) {
        	
        	$attrVALUES[$aID] = array();

        	foreach ($attributeVAL_DATA as $avKey => $avDATA) {        		

        		if ($aID == $avDATA->attr_id):

        			array_push($attrVALUES[$aID], $avDATA->attr_value_id);

        		endif;

        	}

        }

        return $attrVALUES;
    }

    public static function selectedAttributes_ForProduct($productID)
    {
        //PRODUCT data
        $attributesForProduct = DB::table('attributes_product as AP')
                            ->join('attributes as A','A.id','AP.attribute_id')
                            ->join('attributes_values as AV','AV.id','AP.attribute_value_id')
                            ->where('AP.product_id',$productID)
                            ->select(
                                'AP.attribute_id as attr_id',
                                'AP.attribute_value_id as attr_value_id',
                                'AP.product_id as prod_id',
                                'AV.label as attr_label',
                                'AV.value as attr_value',
                                'A.type as attr_type',
                                'A.name as attr_name'
                            )
                            ->get();

        $grouped = $attributesForProduct->groupBy('attr_id'); 

        return $grouped;

    }


}
