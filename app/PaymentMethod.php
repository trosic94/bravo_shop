<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'payment_methods';

    public static function paymentMethods()
    {
        $paymentMethods = PaymentMethod::where('active',1)->get();

        return $paymentMethods;
    }
}
