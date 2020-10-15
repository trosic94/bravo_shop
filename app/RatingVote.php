<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingVote extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'rating_votes';
}
