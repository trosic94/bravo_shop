<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemAttributes extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'orders';

    protected $fillable = ['order_id','product_id','user_id','attribute_id','attribute_value_id','created_at','updated_at'];


    // relacije
    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
    public function order()
    {
        return $this->hasOne('App\Order','id','order_id');
    }
    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
}
