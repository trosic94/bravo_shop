<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\NewsletterSubscriber;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerController extends Controller
{

	public function profil()
    {
    	$ulogovan = Auth::user();
        $ulogovan_ID = $ulogovan->id;


        $customerDATA = Customer::customerDATA($ulogovan_ID);

    	//$orders = Order::where('user_id',$ulogovan->id)->orderBy('created_at','desc')->get();

    	return view('customer.profil', compact('customerDATA'));
    }

	public function profilEdit(Request $request)
    {

    	$this->validationEdit($request);

    	$ulogovan = Auth::user();

    	$sada = Carbon::now();

        $customer['name'] = request('name');
        $customer['last_name'] = request('last_name');
        $customer['phone'] = request('phone');
        $customer['address'] = request('address');
        $customer['zip'] = request('zip');
        $customer['city'] = request('city');
        $customer['loy_barcode'] = request('loy_barcode');
        $customer['company_name'] = request('company_name');
        $customer['company_address'] = request('company_address');
        $customer['zip'] = request('zip');
        $customer['city'] = request('city');
        $customer['company_phone'] = request('company_phone');
        $customer['company_email'] = request('company_email');
        $customer['company_vat'] = request('company_vat');
        $customer['updated_at'] = $sada;

        // proveravam da li unet emajl je isti kao stari
        // ako nije, da li je unoque u users tabeli
        if ($ulogovan->email != request('email')):

            $validator = \Validator::make($request->all(), [
                'email' => 'required|email|unique:users'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }           

        endif;

        $customer['email'] = request('email');


        // UPDATE ako je poslata nova sifra
        if (request('password') != ''):
            $customer['password'] = bcrypt(request('password')); 
        endif;

        $update = DB::table('users')->where('id',$ulogovan->id)->where('role_id',2)->update($customer);

       
        // PRIJAVA/ODJAVA za NL -------------------------------------------------------------------------------- //
        $daLiPostojiPrijavaZaNL = NewsletterSubscriber::where('user_id',$ulogovan->id)->first();

        // proveravam da li je User prijavljen na NL, ako nije prijavljujem
        if ($daLiPostojiPrijavaZaNL):

            // ako postoji prijava, updejtujem status
            if (request('newsletter_subscriber') == 'on'):
                $updejtujemSTATUS = NewsletterSubscriber::where('user_id',$ulogovan->id)->update(['status'=>1]);
            else:
                $updejtujemSTATUS = NewsletterSubscriber::where('user_id',$ulogovan->id)->update(['status'=>0]);
            endif;

        else:

            // ako nema prijave, dodajem novu
            if (request('newsletter_subscriber') == 'on'):
                $prijavljujemNaListu = NewsletterSubscriber::insert([
                    'user_id' => $ulogovan->id,
                    'email' => $customer['email'],
                    'status' => 1
                ]);
            endif;

        endif;
        // PRIJAVA/ODJAVA za NL -------------------------------------------------------------------------------- //


		return redirect(url()->previous());
    }

	public function validationEdit($request)
    {
    	return $this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email'
		]);
    }

}
