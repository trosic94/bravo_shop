<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryItems extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'gallery_items';


    // relacije
    public function Gallery()
    {
        return $this->hasOne('App\Gallery','id','gallery_id');
    }
}
