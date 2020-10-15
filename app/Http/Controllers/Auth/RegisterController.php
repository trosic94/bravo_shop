<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\NewsletterSubscriber;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        // Kreiram novog usera
        $NEWuser = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'zip' => $data['zip'],
            'city' => $data['city'],
            'loy_barcode' => $data['loy_barcode'],
            //'country' => $data['country'],
            'company_name' => $data['company_name'],
            'company_address' => $data['company_address'],
            'company_zip' => $data['company_zip'],
            'company_city' => $data['company_city'],
            //'company_country' => $data['company_country'],
            'company_phone' => $data['company_phone'],
            'company_email' => $data['company_email'],
            'company_vat' => $data['company_vat'],
            'password' => bcrypt($data['password']),
        ]);


        // ako je pristao da dobija obavestenja, prijavljujem na listu
        if ($data['newsletter_subscriber'] == 'on'):

            $addSubscriber = NewsletterSubscriber::create([
                'user_id' => $NEWuser->id,
                'email' => $data['email'],
                'status' => 1,
            ]);

        endif;

        return $NEWuser;

    }
}
