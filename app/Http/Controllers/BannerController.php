<?php

namespace App\Http\Controllers;

use App\Banner;
use App\BannersTrackImpression;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Input;

class BannerController extends Controller
{
	public function clickCount(Request $request)
    {

    	return $request->all();

    	$banner_id = request('id');
    	$position_id = request('position');
    	
    	$oldImpressionCount = DB::table('banners_track_impressions as BANI')
    								->where('banner_id',$banner_id)
    								->where('position_id',$position_id)
    								->first();

    	return $oldImpressionCount->impression_count;

    	$response = 'err';

    	if ($oldImpressionCount):

    		$newImpressionCount = $oldImpressionCount->impression_count + 1;

    		$updateImpression = BannersTrackImpression::where('banner_id',$banner_id)
						    								->where('position_id',$position_id)
						    								->update([
						    									'impression_count' => $newImpressionCount
						    								]);

    		$response = 'ok';

    	endif;

    	return $response;

    }


	public function storeProcessingInsert(Request $request)
    {

    	$sada = Carbon::now();

    	$banner = array();

    	$banner['name'] = request('name');
    	$banner['client_id'] = request('client_id');
    	$banner['position_id'] = request('position_id');
    	$banner['description'] = request('description');
    	$banner['url'] = request('url');
    	$banner['target'] = request('target');

    	$banner['start_date'] = date('Y.m.d H:i:s', strtotime(request('new_start_date')));
    	$banner['end_date'] = date('Y.m.d H:i:s', strtotime(request('new_end_date')));


        // postavlja se SLIKA ako je odabrana
        if (request('image') != null ) {
            $image = $request->file('image');

            $new_name = $banner['client_id'].'-'.date_format(Carbon::now(),"dmYHis").'-'.$image->getClientOriginalName();

            $img = Image::make(Input::file('image'));

            // $img->resize(300, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });

            $path = public_path('storage/banners/'.$new_name);

            $img->save($path);

            $banner['image'] = $new_name;
        } else {
            $banner['image'] = '';
        }


        // INSERT BANNER ------------------------------------------------------------------------------------- //
        $insertBanner = DB::table('banners')->insertGetId($banner);

        // ID unetog PROIZVODA
        $bannerID = $insertBanner;


        // INSERT TRACK IMPRESSIONS -------------------------------------------------------------------------- //
        $bannerImpressions = array();
        $bannerImpressions['banner_id'] = $bannerID;
        $bannerImpressions['position_id'] = $banner['position_id'];
        $bannerImpressions['impression_count'] = 0;

        $insertBannerTrackImpression = DB::table('banners_track_impressions')->insert($bannerImpressions);



    	return  redirect('/SDFSDf345345--DFgghjtyut-6/banners')
                ->with([
                    'message'    => __('voyager::generic.successfully_added_new').": {$banner['name']}",
                    'alert-type' => 'success',
                ]);
    }


	public function storeProcessingEdit(Request $request)
    {

    	$sada = Carbon::now();

    	$oldBanneDATA = DB::table('banners as BAN')->where('id',request('banner_id'))->first();

    	$banner = array();

    	$banner['name'] = request('name');
    	$banner['client_id'] = request('client_id');
    	$banner['position_id'] = request('position_id');
    	$banner['description'] = request('description');
    	$banner['url'] = request('url');
    	$banner['target'] = request('target');

    	$banner['start_date'] = request('old_start_date');
    	if (request('new_start_date') != ''):
    		$banner['start_date'] = date('Y-m-d H:i:s', strtotime(request('new_start_date')));;
    	endif;

    	$banner['end_date'] = request('old_end_date');
    	if (request('new_end_date') != ''):
    		$banner['end_date'] = date('Y-m-d H:i:s', strtotime(request('new_end_date')));;
    	endif;


        // postavlja se SLIKA ako je odabrana
        if (request('image') != null ) {
            $image = $request->file('image');

            $new_name = $banner['client_id'].'-'.date_format(Carbon::now(),"dmYHis").'-'.$image->getClientOriginalName();

            $img = Image::make(Input::file('image'));

            // $img->resize(300, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });

            $path = public_path('storage/banners/'.$new_name);

            $img->save($path);

            $banner['image'] = $new_name;
        } else {
            $banner['image'] = $oldBanneDATA->image;
        }
        

        // INSERT BANNER ------------------------------------------------------------------------------------- //
        $insertBanner = DB::table('banners')->where('id',$oldBanneDATA->id)->update($banner);



    	return  redirect('/SDFSDf345345--DFgghjtyut-6/banners')
                ->with([
                    'message'    => __('voyager::generic.successfully_updated').": {$banner['name']}",
                    'alert-type' => 'success',
                ]);
    }
}
