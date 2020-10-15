<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'galleries';

    // relacije
    public function GalleryItems()
    {
        return $this->hasMany('App\GalleryItems','gallery_id','id');
    }
}
