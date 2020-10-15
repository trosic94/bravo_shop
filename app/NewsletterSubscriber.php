<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'newsletter_subscribers';

    protected $fillable = ['user_id','email','status','created_at','updated_at'];
}
