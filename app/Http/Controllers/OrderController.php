<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItems;
use App\OrdersLog;
use App\PaymentMethod;
use App\OrderStatus;
use App\Product;

use Illuminate\Http\Request;

use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDO;
use Carbon\Carbon;
use Session;
use Cookie;
use Config;
use PDF;
use App;
use Illuminate\Support\Facades\URL;

class OrderController extends Controller
{

    public function checkOut()
    {     
        $ulogovan = Auth::user();
        $intro = 'Poručivanje';

        $paymentMethod = PaymentMethod::paymentMethods();

        return view('order.checkout', compact('intro','ulogovan','paymentMethod'));
    }

    public function orderConfirmed()
    {     
        $ulogovan = Auth::user();
        $orderTotal = Session::get('mailData');

        $intro = 'Hvala!';

        return view('order.thank-you', compact('intro','ulogovan','orderTotal'));
    }

    public function quitPayment()
    {     
        $ulogovan = Auth::user();
        
        //preusmeravanje u koliko je odustao od paymenta
        if(Auth::check()):
            return redirect('/checkout');
        else:
            return redirect('/');
        endif;
    }

    public function confirmOrder(Request $request)
    {

        $ulogovan = Auth::user();

        // podaci iz SESIJE
        $crt = Session::get('crt');

        // kreiram DATUM
        $sada = Carbon::now();
        $order_DATETIME = date('d.m.Y H:i:s', strtotime($sada));

        // app URL
        $url = URL::to('/');

        // PAYMENT METHOD
        $paymentMethod = request('payment');

        // Discount
        $discount = 0;
        if ($ulogovan->discount != null):
            $discount = $ulogovan->discount;
        endif;


        // CUSTOME ------------------------------------------------------------------------------------ //
        $customer = array();

        $customer['name'] = $ulogovan->name;
        $customer['last_name'] = $ulogovan->last_name;
        $customer['phone'] = $ulogovan->phone;
        $customer['email'] = $ulogovan->email;
        $customer['address'] = $ulogovan->address;
        $customer['zip'] = $ulogovan->zip;
        $customer['city'] = $ulogovan->city;
        $customer['phone'] = $ulogovan->phone;
        $customer['email'] = $ulogovan->email;


        // ORDER -------------------------------------------------------------------------------------- //
        $order = array();

        $order['user_id'] = $ulogovan->id;
        $order['order_number'] = null;
        $order['order_invoice'] = null; // unosi se kasnije, kada se kreira ID ordera
        $order['rabat'] = $discount;
        $order['total'] = $crt['total'];
        $order['order_status'] = 1; // uplata na cekanju
        $order['payment_method'] = $paymentMethod;
        $order['proforma_invoice'] = null; // unosi se kasnije, kada se kreira ID ordera
        $order['comment'] = request('cart_comment'); // komentar vezan za porudzbinu
        $order['merchantPaymentId'] = null; // unosi se kasnije, kada se koristi CC payment (1)
        $order['pgTranId'] = null; // unosi se kasnije, kada se koristi CC payment (1)
       
        $orderID = DB::table('orders')->insertGetId($order);


        // ORDER DOCs --------------------------------------------------------------------------------- //
        $orderDOCs = array();

        // ORDER INVOICE
        $orderDOCs['order_invoice'] = Order::invoiceNO($orderID);
        // priprema za kasnije slanje na mail
        $order['order_invoice'] = $orderDOCs['order_invoice'];


        // PROFORMA INVOICE NO
        $orderDOCs['proforma_invoice'] = Order::proformaInvoiceNO($orderID);
        // priprema za kasnije slanje na mail
        $order['proforma_invoice'] = $orderDOCs['proforma_invoice'];

        // kreiram ORDER NUMBER
        $orderDOCs['order_number'] = Order::orderNumber($orderID);
        // priprema za kasnije slanje na mail
        $order['order_number'] = $orderDOCs['order_number'];

        // DATUM koji se koristi pri kreiranju PDFa
        $order['order_date'] = $sada;

        $update_order = DB::table('orders')->where('id',$orderID)->update($orderDOCs);


        // ORDER ITEMS -------------------------------------------------------------------------------- //
        $orderItems = array(); // podaci za upis u DB order_items
        $products = array(); // podaci za slanje mailom

        for ($oi=0; $oi < count($crt['products']); $oi++) {
           
            $orderItems[$oi]['order_id'] = $orderID;
            $orderItems[$oi]['product_id'] = $crt['products'][$oi]['prod_id'];

            $orderItems[$oi]['price'] = $crt['products'][$oi]['prod_price'];
            $orderItems[$oi]['discount'] = $crt['products'][$oi]['prod_discount'];

            $orderItems[$oi]['kolicina'] = $crt['products'][$oi]['quantity'];
            $orderItems[$oi]['description'] = null;

            // u zavisnosti od toga koja cena je dostupna
            // prvo se uzima cena sa popustom
            if ($crt['products'][$oi]['prod_price_with_discount'] != null):
                $total = $crt['products'][$oi]['prod_price_with_discount'] * $crt['products'][$oi]['quantity'];

                //cena koja se prikazuje u mailu
                $displayPrice = $crt['products'][$oi]['prod_price_with_discount'];
            elseif ($crt['products'][$oi]['prod_discount'] != null):

                $discountPrice = $crt['products'][$oi]['prod_price']-(($crt['products'][$oi]['prod_price']/100)*$crt['products'][$oi]['prod_discount']);

                $displayPrice = $discountPrice;

                $total = $discountPrice * $crt['products'][$oi]['quantity'];

            else:
                $total = $crt['products'][$oi]['prod_price'] * $crt['products'][$oi]['quantity'];

                //cena koja se prikazuje u mailu
                $displayPrice = $crt['products'][$oi]['prod_price'];
            endif;

            $orderItems[$oi]['total'] = $total;


            $products[$oi]['order_id'] = $orderID;
            $products[$oi]['product_id'] = $crt['products'][$oi]['prod_id'];
            $products[$oi]['prod_title'] = $crt['products'][$oi]['prod_title'];
            $products[$oi]['prod_sku'] = $crt['products'][$oi]['prod_sku'];
            $products[$oi]['prod_price'] = $crt['products'][$oi]['prod_price'];
            $products[$oi]['prod_discount'] = $crt['products'][$oi]['prod_discount'];
            $products[$oi]['quantity'] = $crt['products'][$oi]['quantity'];
            $products[$oi]['display_price'] = $displayPrice;
            $products[$oi]['total'] = $total;


            if ($crt['products'][$oi]['prod_image'] != null):
                $imgFILE = $crt['products'][$oi]['prod_image'];
            else:
                $imgFILE = 'no_image.jpg';
            endif;

            $products[$oi]['prod_image'] = $url.'/storage/products/'.$imgFILE;

        }

        $insert_orderItems = DB::table('order_items')->insert($orderItems);


        // ORDER ITEM ATTRIBUTES --------------------------------------------------------------------- //
        $orderItemAttributes = array();
        $Acnt = 0;
        // INSERT ako su odabrani atributi za proizvod
        for ($oia=0; $oia < count($crt['products']); $oia++) {

            if ($crt['products'][$oia]['attr_data']):

                foreach ($crt['products'][$oia]['attr_data'] as $attKey => $attributeDATA) {

                    for ($av=0; $av < count($attributeDATA['val']); $av++) {

                        $orderItemAttributes[$Acnt]['order_id'] = $orderID;
                        $orderItemAttributes[$Acnt]['product_id'] = $crt['products'][$oia]['prod_id'];
                        $orderItemAttributes[$Acnt]['user_id'] = $ulogovan->id;
                        $orderItemAttributes[$Acnt]['attribute_id'] = $attributeDATA['id'];


                        $orderItemAttributes[$Acnt]['attribute_value_id'] = $attributeDATA['val'][$av]['id'];

                        $Acnt++;

                    }

                }

            endif;

        }

        $orderItemAttributes_INSERT = DB::table('order_item_attributes')->insert($orderItemAttributes);


        // SHIPPING ---------------------------------------------------------------------------------- //

        // na koju adresu se salje?
        $shippingOption = request('cart_shipping_address_option');

        $orderShipping = array();

        // zajednicki podaci
        $orderShipping['user_id'] = $ulogovan->id;
        $orderShipping['order_id'] = $orderID;

        switch ($shippingOption) {
            case 'profil':
                
                $orderShipping['shp_name'] = $ulogovan->name;
                $orderShipping['shp_last_name'] = $ulogovan->last_name;
                $orderShipping['shp_email'] = $ulogovan->email;
                $orderShipping['shp_phone'] = $ulogovan->phone;
                $orderShipping['shp_address'] = $ulogovan->address;
                $orderShipping['shp_zip'] = $ulogovan->zip;
                $orderShipping['shp_city'] = $ulogovan->city;

                break;
            
            case 'other':

                $orderShipping['shp_name'] = request('cart_new_shp_name');
                $orderShipping['shp_last_name'] = request('cart_new_shp_last_name');
                $orderShipping['shp_email'] = request('cart_new_shp_email');
                $orderShipping['shp_phone'] = request('cart_new_shp_phone');
                $orderShipping['shp_address'] = request('cart_new_shp_address');
                $orderShipping['shp_zip'] = request('cart_new_shp_zip');
                $orderShipping['shp_city'] = request('cart_new_shp_city');

                break;
        }

        $shippingOption = DB::table('order_shipping')->insert($orderShipping);


        // EMAIL NOTIFICATIONS ----------------------------------------------------------------------- //

        // ORDER STATUS data
        $orderStatusDATA = DB::table('order_status as OS')
                            ->where('OS.id',$order['order_status'])
                            ->select(
                                'OS.title as title',
                                'OS.description as description'
                            )
                            ->first();

        $order['order_status_name'] = $orderStatusDATA->title;
        $order['order_status_description'] = $orderStatusDATA->description;

        // PAYMENT METHOD data
        $paymentMethodDATA = DB::table('payment_methods as PM')
                            ->where('PM.id',$order['payment_method'])
                            ->select(
                                'PM.title as title',
                                'PM.description as description'
                            )
                            ->first();

        $order['payment_method_name'] = $paymentMethodDATA->title;
        $order['payment_method_description'] = $paymentMethodDATA->description;



        // FINAL ORDER data ******************************************************************** ////
        $orderDATA = array();

        $orderDATA['url'] = $url;
        $orderDATA['dateTime'] = $order_DATETIME;
        $orderDATA['customer'] = $customer; // podaci o ulogovanom korisniku
        $orderDATA['order'] = $order; // podaci o ORDERu
        $orderDATA['order_items'] = $products; // podaci o proizvodima
        $orderDATA['order_shipping'] = $orderShipping; // podaci o adresi za isporuku

        // kreiram sesiju za test, koristim za ThankYou page
        //Session::put('ordTEST', $orderDATA);

        // kreiram PDF za download
        $pdf = PDF::loadView('pdf.proforma-invoice', $orderDATA);
        $pdf->save('storage/proforma-invoice/'.$orderDATA['order']['proforma_invoice'].'.pdf');

        // slanje NOTIFIKACIJA
        $sendOrderInfoCustomer = Order::sendOrderInfoCustomer($orderDATA);
        $sendOrderInfoAdmin = Order::sendOrderInfoAdmin($orderDATA);

        //brisem podatke o ORDERu iz sesije
        Session::forget('crt');

        return redirect('/thank-you')->with(['orderDATA' => $orderDATA]);

    }

    public function orderDetails($id)
    {
        $intro = 'Informacije o odabranoj porudzbini';

        $orderDetails = DB::table('orders as O')
                        ->leftJoin('order_status as OS','OS.id','O.order_status')
                        ->leftJoin('payment_methods as PM','PM.id','O.payment_method')
                        ->leftJoin('order_shipping as OSHP','OSHP.order_id','O.id')
                        ->leftJoin('users as U','U.id','O.user_id')
                        ->where('O.id',$id)
                        ->select(
                            'O.id as ord_id',
                            'O.order_number as ord_order_number',
                            'O.order_invoice as ord_order_invoice',
                            'O.rabat as ord_rabat',
                            'O.total as ord_total',
                            'O.order_status as ord_order_status',
                            'OS.title as ord_stat_title',
                            'O.comment as ord_comment',
                            'O.payment_method as ord_payment_method',
                            'O.created_at as ord_created_at',
                            'O.updated_at as ord_updated_at',
                            'PM.title as ord_paymtd_title',
                            'OSHP.shp_name as ord_shp_name',
                            'OSHP.shp_last_name as ord_shp_last_name',
                            'OSHP.shp_email as ord_shp_email',
                            'OSHP.shp_phone as ord_shp_phone',
                            'OSHP.shp_address as ord_shp_address',
                            'OSHP.shp_zip as ord_shp_zip',
                            'OSHP.shp_city as ord_shp_city',
                            'U.name as u_name',
                            'U.last_name as u_last_name',
                            'U.phone as u_phone',
                            'U.email as u_email',
                            'U.address as u_address',
                            'U.zip as u_zip',
                            'U.city as u_city',
                            'U.country as u_country',
                            'U.discount as u_discount',
                            'U.loy_barcode as u_loy_barcode',
                            'U.company_name as u_company_name',
                            'U.company_phone as u_company_phone',
                            'U.company_email as u_company_email',
                            'U.company_address as u_company_address',
                            'U.company_zip as u_company_zip',
                            'U.company_city as u_company_city',
                            'U.company_country as u_company_country',
                            'U.company_vat as u_company_vat'                        
                        )
                        ->first();


        $orderProducts = DB::table('order_items as OI')
                            ->leftJoin('products as P','P.id','OI.product_id')
                            ->leftJoin('manufacturer as M','M.id','P.manufacturer_id')
                            ->where('OI.order_id',$id)
                            ->select(
                                'OI.id as oi_id',
                                'OI.price as oi_price',
                                'OI.discount as oi_discount',
                                'OI.kolicina as oi_kolicina',
                                'OI.total as oi_total',
                                'P.id as p_id',
                                'P.sku as p_sku',
                                'P.import_id as p_import_id',
                                'P.title as p_title',
                                'P.slug as p_slug',
                                'P.category_id as p_category_id',
                                'P.manufacturer_id as p_manufacturer_id',
                                'M.name as m_name',
                                'P.excerpt as p_excerpt',
                                'P.body as p_body',
                                'P.specification as p_specification',
                                'P.video as p_video',
                                'P.image as p_image',
                                'P.image_import as p_image_import',
                                'P.status as p_status',
                                'P.on_stock as p_on_stock',
                                'P.product_price as p_product_price',
                                'P.product_price_with_discount as p_product_price_with_discount',
                                'P.product_discount as p_product_discount',
                                'P.product_vat as p_product_vat',
                                'P.warranty as p_warranty'
                            )
                            ->get();

        foreach ($orderProducts as $key => $product) {
            $product->attr = DB::table('order_item_attributes as OAI')
                                    ->leftJoin('attributes as A','A.id','OAI.attribute_id')
                                    ->leftJoin('attributes_values as AV','AV.id','OAI.attribute_value_id')
                                    ->where('OAI.product_id',$product->p_id)
                                    ->select(
                                        'OAI.attribute_id as attr_id',
                                        'OAI.attribute_value_id as attr_attribute_value_id',
                                        'A.name as attr_name',
                                        'A.description as attr_description',
                                        'AV.label as attr_val_label',
                                        'AV.value as attr_val_value'
                                    )
                                    ->get();
        }



        return view('order.view', compact('intro','orderDetails','orderProducts'));
    }

    public function procesPayment(Request $request)
    {     

        $ulogovan = Auth::user();
        $sada = Carbon::now();

        //podaci o Orderu iz sesije
        //$orderTotal = json_decode(Session::get('orderTotal'));

        $merchantPaymentId = request('merchantPaymentId');
       
        $pgTranId = request('pgTranId');
        $pgTranRefId = request('pgTranRefId');
        $pgOrderId = request('pgOrderId');
        $pgTranApprCode = request('pgTranApprCode');
        $pgTranDate = request('pgTranDate');
        $customerId = request('customerId');
        $amount = request('amount');
        $sessionToken = request('sessionToken');
        $responseCode = request('responseCode');
        $responseMsg = request('responseMsg');


        //podaci o Orderu iz DB
        $retrieveOrdersLog = OrdersLog::where('orderID',$merchantPaymentId)->first()->toArray();
        $orderTotal = json_decode($retrieveOrdersLog['orderitems'],true);
        

        if(Auth::check()):

        else:
            $user = User::where('id',$orderTotal['orders']['customer_id'])->first();

            Auth::login($user, TRUE);
        endif;

        $orderTotal['transaction']['pgOrderId'] = $pgOrderId;
        $orderTotal['transaction']['pgTranApprCode'] = $pgTranApprCode;
        $orderTotal['transaction']['responseMsg'] = $responseMsg;
        $orderTotal['transaction']['responseCode'] = $responseCode;
        $orderTotal['transaction']['pgTranId'] = $pgTranId;
        $orderTotal['transaction']['pgTranDate'] = $pgTranDate;
        $orderTotal['transaction']['pgTranRefId'] = $pgTranRefId;

        $mailData = $orderTotal;

        if ($responseCode == '00' && $responseMsg == 'Approved'): //upis u DB

            $orderTotal = json_decode($retrieveOrdersLog['orderitems'],true);

        	$addToDB = Order::addOrderToDB($orderTotal,$merchantPaymentId,$pgTranId);

            //brisem podatke o Orderu iz sesije
            Session::forget('orderTotal');
            Session::forget('atc');

            //saljem notifikacije na mail
            $sendOrderInfo = Order::sendOrderInfoCustomer($mailData);
            $sendOrderInfoAdmin = Order::sendOrderInfoAdmin($mailData);
            
        	return redirect('/thank-you')->with(['mailData' => $mailData]);

        else: //redirect to error page

            //saljem notifikacije na mail
            $sendOrderErrorCustomer = Order::sendPaymentError($mailData);
            
        	return redirect('/payment-error')->with(['mailData' => $mailData]);

        endif;



    }
}