
@extends ('includes.page')

@section ('content')

<div id="pageWrap">

    <div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
        <h1>@lang('shop.shop_my_cart_title')</h1>
    </div>

    <div class="row mt-5 mb-5">

        <div class="col-xl-12">

            @if(!Auth::guest())
                <form id="confirmOrder" class="needs-validation" method="POST" action="/confirm-order" novalidate>
            @endif
            {{ csrf_field() }}

            <div id="cartWrap">

                <div class="row">

                    <div class="col-xl-12">

                        @php
                            $amount = 0;
                            $total = 0;
                        @endphp

                        <div class="card mb-4">

                            <div class="card-header">
                                <h4 class="card-title m-0">@lang('shop.my_cart_items')</h4>
                            </div>

                            <div class="card-body">


                            @if ($cart)

                                <div class="table-responsive">

                                <table id="cartTable" class="table">
                                    <thead>
                                      <tr>
                                        <th></th>
                                        <th>@lang('shop.my_cart_product_title')</th>
                                        <th class="text-center">@lang('shop.title_price')</th>
                                        <th class="text-center">@lang('shop.title_discount')</th>
                                        <th class="text-center">@lang('shop.title_price_with_discount')</th>
                                        <th class="text-center">@lang('shop.my_cart_quantity')</th>
                                        <th class="text-center">@lang('shop.my_cart_amount') ({{ setting('shop.valuta') }})</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($cart['products'] as $cartKey => $prod)

                                        @php
                                            $productSLUG = App\Product::productsSLUG_By_catID($prod['prod_cat_id']);
                                        @endphp

                                        <tr id="row_{{ $prod['prod_id'] }}">
                                            <td><a href="{{ $productSLUG }}/{{ $prod['prod_slug'] }}" title="{{ $prod['prod_title'] }}"><img src="/storage/products/{{ ($prod['prod_image'] != null)? $prod['prod_image']:'no_image.jpg' }}" alt="{{ $prod['prod_title'] }}" style="min-width: 80px;"></td>
                                            <td>
                                                <h3>{{ $prod['prod_title'] }}</h3>
                                                <span class="prodSKU"><label>@lang('shop.my_cart_sku'):</label> {{ $prod['prod_sku'] }}</span>

                                                @if ($prod['attr_data'])
                                                    <div class="small">
                                                        @foreach ($prod['attr_data'] as $atKey => $attr)
                                                        <div class="attrONE">
                                                            <span class="font-weight-bold mr-1">{{ $attr['title'] }}:</span>

                                                            <span>
                                                            @php
                                                                $i = 0;
                                                                $attrLABELs = '';
                                                                foreach ($attr['val'] as $valKey => $val) {
                                                                    $attrLABELs .= $val['label'].', ';
                                                                    $i++;
                                                                }
                                                                // sklanjam zarez sa iza poslednje ispisane vrednosti
                                                                if ($valKey == 0 || $valKey == ($i-1)):
                                                                    $attrLABELs = substr($attrLABELs, 0, -2);
                                                                endif;
                                                            @endphp
                                                                {{ $attrLABELs }}
                                                            </span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                            </td>
                                            <td class="text-right">{{ number_format($prod['prod_price'],0,"",".") }}</td>
                                            <td class="text-center">
                                                @if ($prod['prod_discount'] != '')
                                                    {{ $prod['prod_discount'] }}%
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-right">

                                                @if ($prod['prod_discount'] != null)

                                                    @php
                                                        $discountPrice = $prod['prod_price']-(($prod['prod_price']/100)*$prod['prod_discount']);
                                                    @endphp

                                                    {{ number_format($discountPrice,0,"",".") }}

                                                @else
                                                    -
                                                @endif

                                            </td>
                                            <td>
                                                <div id="qtyWrap" class="">
                                                    <div id="btnMinus_{{ $prod['prod_id'] }}" class="btnMINUS" onclick="qtyMINUS({{ $prod['prod_id'] }})"><i class="fas fa-minus"></i></div>
                                                    <input id="prodQuantity_{{ $prod['prod_id'] }}" class="prod_quantity" name="prod_quantity_{{ $prod['prod_id'] }}" class="" value="{{ $prod['quantity'] }}" readonly="">
                                                    <div id="btnPlus_{{ $prod['prod_id'] }}" class="btnPLUS" onclick="qtyPLUS({{ $prod['prod_id'] }})"><i class="fas fa-plus"></i></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="priceWrap text-right">

                                                @php

                                                    $prod_price = $prod['quantity'] * $prod['prod_price'];
                                                    $prod_price_with_discount = $prod['quantity'] * $prod['prod_price_with_discount'];
                                                    
                                                @endphp

                                                @if ($prod['prod_price_with_discount'] != null)

                                                    {{-- <span class="fullPrice">{{ number_format($prod_price,0,"",".") }}</span> --}}
                                                    <span class="finalPrice">{{ number_format($prod_price_with_discount,0,"",".") }}</span>

                                                    <input type="hidden" name="start_discount_price_{{ $prod['prod_id'] }}" value="{{ $prod['prod_price'] }}">
                                                    <input type="hidden" name="start_final_price_{{ $prod['prod_id'] }}" value="{{ $prod['prod_price_with_discount'] }}">

                                                    <input type="hidden" name="discount_price_{{ $prod['prod_id'] }}" value="{{ $prod_price }}">
                                                    <input type="hidden" id="finalPRICE" name="final_price_{{ $prod['prod_id'] }}" value="{{ $prod_price_with_discount }}">

                                                    @php
                                                        $amount = $amount + $prod_price_with_discount;
                                                        $total = $total + $prod_price_with_discount;
                                                    @endphp

                                                @elseif ($prod['prod_discount'] != null)

                                                    @php
                                                        $discountPrice = $prod['prod_price']-(($prod['prod_price']/100)*$prod['prod_discount']);

                                                        $finalDiscountPrice = $prod['quantity'] * $discountPrice;
                                                    @endphp

                                                    {{-- <span class="fullPrice">{{ number_format($prod_price,0,"",".") }}</span> --}}
                                                    <span class="finalPrice">{{ number_format($finalDiscountPrice,0,"",".") }}</span>

                                                    <input type="hidden" name="start_discount_price_{{ $prod['prod_id'] }}" value="{{ $prod['prod_price'] }}">
                                                    <input type="hidden" name="start_final_price_{{ $prod['prod_id'] }}" value="{{ $discountPrice }}">

                                                    <input type="hidden" name="discount_price_{{ $prod['prod_id'] }}" value="{{ $prod_price }}">
                                                    <input type="hidden" id="finalPRICE" name="final_price_{{ $prod['prod_id'] }}" value="{{ $finalDiscountPrice }}">

                                                    @php
                                                        $amount = $amount + $finalDiscountPrice;
                                                        $total = $total + $finalDiscountPrice;
                                                    @endphp


                                                @else

                                                    <span class="finalPrice">{{ number_format($prod_price,0,"",".") }}</span>

                                                    <input type="hidden" name="start_discount_price_{{ $prod['prod_id'] }}" value="0">
                                                    <input type="hidden" name="start_final_price_{{ $prod['prod_id'] }}" value="{{ $prod['prod_price'] }}">

                                                    <input type="hidden" name="discount_price_{{ $prod['prod_id'] }}" value="0">
                                                    <input type="hidden" id="finalPRICE" name="final_price_{{ $prod['prod_id'] }}" value="{{ $prod_price }}">

                                                    @php
                                                        $amount = $amount + $prod_price;
                                                        $total = $total + $prod_price;
                                                    @endphp

                                                @endif

                                                </div>

                                            </td>
                                            <td><i id="delCart" class="fas fa-times-circle" onclick="remove_CartEvent({{ $prod['prod_id'] }})"></i></td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                </div>

                                <div class="row">

                                    @include('product.cart_invoice')

                                </div>

                            @else

                                <h3>@lang('shop.my_cart_my_cart_is_empty')</h3>

                            @endif

                            </div>

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">

                        <div class="row">

                            {{-- @include('product.cart_invoice') --}}
                            {{-- @include('product.cart_shipping') --}}
                            @include('product.cart_comment')
                            @include('product.cart_payment')

                        </div>

                    </div>

                </div>

                <div id="shippingAddress" class="row">

                    @include('product.cart_shipping_location')

                </div>

                <div id="orderConfirmation" class="row">

                    @if (!Auth::guest())

                        @include('product.cart_order_confirmation')

                    @endif

                </div>

            </div>

            @if(!Auth::guest())

            </form>

            @endif

        </div>

    </div>


</div>

@php
// echo '<pre>';
// print_r($cart);
// echo '</pre>';
@endphp

<script type="text/javascript">
    $('document').ready(function () {

        $('.mdb-select').materialSelect();

    });
</script>


@endsection
