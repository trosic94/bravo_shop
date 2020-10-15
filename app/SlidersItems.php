<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlidersItems extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'sliders_items';


    // relacije
    public function Sliders()
    {
        return $this->hasOne('App\Sliders','id','slider_id');
    }

}
