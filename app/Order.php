<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDO;
use Carbon\Carbon;
use Session;
use Config;
use PDF;


class Order extends Model
{

	protected $primaryKey = 'id';
    protected $table = 'orders';


    public static function orderDATA($orderID)
    {
        $orderData = DB::table('orders as ORD')
                            ->join('users as USR','USR.id','ORD.user_id')
                            ->join('order_status as ORDS','ORD.order_status','ORDS.id')
                            ->join('order_shipping as ORDSHP','ORD.id','ORDSHP.order_id')
                            ->join('payment_methods as PYMNT','ORD.payment_method','PYMNT.id')
                            ->where('ORD.id',$orderID)
                            ->select(
                                'ORD.id as ord_id',
                                'ORD.order_invoice as ord_invoice',
                                'ORD.order_number as ord_order_number',
                                'ORD.proforma_invoice as ord_proforma_invoice',
                                'ORD.rabat as ord_rabat',
                                'ORD.total as ord_total',
                                'ORD.order_status as ord_status_id',
                                'ORDS.title as ord_status',
                                'ORD.payment_method as ord_payment_method_id',
                                'PYMNT.title as ord_payment_method',
                                'ORD.merchantPaymentId as ord_merchantPaymentId',
                                'ORD.pgTranId as ord_pgTranId',
                                'ORD.created_at as ord_created_at',
                                'ORD.updated_at as ord_updated_at',
                                'USR.id as usr_id',
                                'USR.name as usr_name',
                                'USR.last_name as usr_last_name',
                                'USR.phone as usr_phone',
                                'USR.email as usr_email',
                                'USR.address as usr_address',
                                'USR.zip as usr_zip',
                                'USR.city as usr_city',
                                'USR.country as usr_country',
                                'USR.company_name as usr_company_name',
                                'USR.company_address as usr_company_address',
                                'USR.company_zip as usr_company_zip',
                                'USR.company_city as usr_company_city',
                                'USR.company_country as usr_company_country',
                                'USR.company_phone as usr_company_phone',
                                'USR.company_email as usr_company_email',
                                'USR.company_vat as usr_company_vat',
                                'ORDSHP.shp_name as shp_name',
                                'ORDSHP.shp_last_name as shp_last_name',
                                'ORDSHP.shp_email as shp_email',
                                'ORDSHP.shp_phone as shp_phone',
                                'ORDSHP.shp_address as shp_address',
                                'ORDSHP.shp_zip as shp_zip',
                                'ORDSHP.shp_city as shp_city'

                            )
                            ->first();

        return $orderData;
    }

    public static function orderDATAbyUser($userID)
    {
        $orderData = DB::table('orders as ORD')
                            ->where('user_id',$userID)
                            ->join('order_status as OS','OS.id','ORD.order_status')
                            ->select(
                                'ORD.id as id',
                                'ORD.order_number as order_number',
                                'ORD.created_at as created_at',
                                'ORD.total as total',
                                'ORD.order_status as order_status',
                                'OS.title as order_status_title'
                            )
                            ->orderBy('created_at','DESC')
                            ->get();

        return $orderData;
    }
   
    public static function orderNumber($orderID)
    {
        $orderDateTime = date('dmYHis', strtotime(Carbon::now()));

        $broj = $orderID;
        //$broj = sprintf('%04d',$orderID);

        $orderNumber = 'ORD-'.$broj.'-'.$orderDateTime;

        return $orderNumber;
    }

    public static function invoiceNO($orderID)
    {
        $godina = Carbon::now()->format('y');

        $broj = sprintf('%04d',$orderID);

        $orderInvoice = 'INV'.$broj.'-'.$godina;

        return $orderInvoice;
    }

    public static function proformaInvoiceNO($orderID)
    {
        $godina = Carbon::now()->format('y');

        $broj = sprintf('%04d',$orderID);

        $proformaInvoice = 'PF-INV-'.$broj.'-'.$godina;

        return $proformaInvoice;
    }


    public static function sendOrderInfoCustomer($orderDATA)
    {
            Mail::send('emails.order-confirmation', $orderDATA, function($message) use ($orderDATA)
            {
                $message->to($orderDATA['customer']['email'],$orderDATA['customer']['name'])
                        ->from(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->bcc('webmaster@onestopmarketing.rs', 'OSM')
                        ->sender(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->replyTo(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->subject(trans('shop.email_subject_order_confirmation').' '.$orderDATA['order']['order_number']);
            });
    }

    public static function sendOrderInfoAdmin($orderDATA)
    {
            Mail::send('emails.order-confirmation-admin', $orderDATA, function($message) use ($orderDATA)
            {
                $message->to(setting('shop.shop_admin_mail'),setting('company.company_name'))
                        ->from(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->bcc('webmaster@onestopmarketing.rs', 'OSM')
                        ->sender(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->replyTo(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->subject(trans('shop.email_subject_order_confirmation').' '.$orderDATA['order']['order_number']);
            });
    }

    public static function sendPaymentError($orderDATA)
    {
            Mail::send('emails.payment-error', $orderDATA, function($message) use ($orderDATA)
            {
                $message->to($mailData['orders']['customer_mail'],$mailData['orders']['customer_name'])
                        ->from(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->bcc('webmaster@onestopmarketing.rs', 'OSM')
                        ->sender(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->replyTo(setting('shop.shop_notification_email'), setting('company.company_name'))
                        ->subject(trans('shop.email_subject_payment_failure'));
            });
    }

    public static function ifProductOrderedByCustomer($productID,$userID)
    {
        $ifProductOrderedByCustomer = DB::table('orders as O')
                                            ->leftJoin('order_items as OI','OI.order_id','O.id')
                                            ->where('OI.product_id',$productID)
                                            ->where('O.user_id',$userID)
                                            ->first();

        return $ifProductOrderedByCustomer;
    }


    // relacije
    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
    public function orderItems()
    {
        return $this->hasMany('App\OrderItems','order_id','id');
    }
    public function orderStatus()
    {
        return $this->hasOne('App\OrderStatus','id','order_status');
    }
    public function orderShipping()
    {
        return $this->hasOne('App\OrderShipping','order_id','id');
    }
    public function orderItemAttributes()
    {
        return $this->hasMany('App\OrderItemAttributes','order_id','id');
    }
}
