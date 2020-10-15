<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'sliders';



    // relacije
    public function SlidersItems()
    {
        return $this->hasMany('App\SlidersItems','slider_id','id');
    }
}
