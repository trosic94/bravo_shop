<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrdersLog extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'orders_log';

    public static function addOrdersLog($merpID,$orderitemsJSONtmp)
    {
        $sada = Carbon::now();

        $insert = DB::table('orders_log')->insert([
            'orderID' => $merpID,
            'orderitems' => $orderitemsJSONtmp,
            'created_at' => $sada,
            'updated_at' => $sada,
        ]);
    }
}
