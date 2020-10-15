<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderStatus extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'order_status';


    public static function orderStatusALL()
    {
        $orderStatusALL = OrderStatus::all();

        return $orderStatusALL;
    }


    // relacije
    public function orders()
    {
        return $this->hasOne('App\Order','order_status','id');
    }

}
