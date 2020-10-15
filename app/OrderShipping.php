<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'order_shipping';


    // relacije
    public function orders()
    {
        return $this->hasOne('App\Order','id','order_id');
    }
}
