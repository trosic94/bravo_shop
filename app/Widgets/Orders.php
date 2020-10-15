<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

use Illuminate\Support\Facades\DB;

//use App\Users;

class Orders extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = DB::table('orders as ORD')->count();
        $string = trans_choice('shop_admin.title_orders', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-dollar',
            'title'  => "{$count} {$string}",
            'text'   => '',
            'button' => [
                'text' => __('shop_admin.btn_view_all'),
                'link' => route('voyager.orders.index'),
            ],
            //'image' => voyager_asset('images/widget-backgrounds/01.jpg'),
            'image' => '/storage/widgets/orders.jpg',
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('Post'));
    }
}
