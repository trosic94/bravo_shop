<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOption extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'special_options';

    public static function SpecialDisplayOptions()
    {
    	$all = SpecialOption::all();

    	return $all;

    }
}
