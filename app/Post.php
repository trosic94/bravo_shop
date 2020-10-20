<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'posts';


    public static function oNama()
    {
    	$o_nama = Post::where('category_id',105)->where('status','PUBLISHED')->get();

    	return $o_nama;
    }
}
