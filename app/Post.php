<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'posts';


    public static function benefits()
    {
    	$benefiti = Post::where('category_id',84)->where('status','PUBLISHED')->get();

    	return $benefiti;
    }
}
