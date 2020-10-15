<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'users';

    public static function customerDATA($userID)
    {
    	$customerDATA = DB::table('users as U')
                            ->leftJoin('roles as R','R.id','U.role_id')
                            ->leftJoin('newsletter_subscribers as NLS','NLS.user_id','U.id')
                            ->where('U.id',$userID)
                            ->select(
                                'U.name as name',
                                'U.last_name as last_name',
                                'U.discount as discount',
                                'U.phone as phone',
                                'U.address as address',
                                'U.zip as zip',
                                'U.city as city',
                                'U.country as country',
                                'U.email as email',
                                'U.avatar as avatar',
                                'U.loy_barcode as loy_barcode',
                                'U.company_name as company_name',
                                'U.company_address as company_address',
                                'U.company_zip as company_zip',
                                'U.company_city as company_city',
                                'U.company_country as company_country',
                                'U.company_phone as company_phone',
                                'U.company_email as company_email',
                                'U.company_vat as company_vat',
                                'R.name as role_name',
                                'R.display_name as role_display_name',
                                'NLS.status as nls_status'
                            )
                            ->first();

        return $customerDATA;
    }
}
