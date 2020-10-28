@extends ('includes.page')

@section ('content')

<div id="pageWrap">

    <div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
        <h1>@lang('shop.order_title') <span>{{ $orderDetails->ord_order_number }}</h1>
    </div>

    <div class="row mt-5 mb-5">

        <div class="col-xl-12">


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

	                <div class="table-responsive">

		                <table id="cartTable" class="table">
		                    <thead>
		                      <tr>
		                        <th></th>
		                        <th>@lang('shop.thank_you_product_title')</th>
		                        <th class="text-center">@lang('shop.order_price')</th>
		                        <th class="text-center">@lang('shop.title_discount')</th>
								<th class="text-center">@lang('shop.title_price_with_discount')</th>
		                        <th class="text-center">@lang('shop.order_quantity')</th>
		                        <th class="text-center">@lang('shop.order_amount')({{ setting('shop.valuta') }})</th>
		                      </tr>
		                    </thead>
		                    <tbody>

	                    	@foreach ($orderProducts as $key => $prod)
		                    <tr>
		                        <td><img src="/storage/products/{{ $prod->p_image }}" alt="{{ $prod->p_title }}"></td>
		                        <td>
		                        	<h3>{{ $prod->p_title }}</h3>
		                        	<span class="prodSKU"><label>@lang('shop.my_cart_sku'):</label> {{ $prod->p_sku }}</span>

		                        	@if ($prod->attr)
		                        		@php
		                        			$sviAtributi = array();
		                        			foreach ($prod->attr as $attrKey => $attr) {
		                        				
		                        				if (!in_array($attr->attr_id, $sviAtributi)):
		                        					array_push($sviAtributi, $attr->attr_id);

		                        					$i = 0;
		                        					$iMAX = 0;
		                        					$attrLABELs = '';

		                        					// ispis Labele
		                        					echo '<span class="font-weight-bold mr-1">'.$attr->attr_name.'</span>';

		                        					foreach ($prod->attr as $attrLBLKey => $attrLBL) {

		                        						if ($attr->attr_id == $attrLBL->attr_id):

		                        							$attrLABELs .= $attrLBL->attr_val_label.', ';
		                        							$i++;
		                        							$iMAX++;
		                        						endif;

		                        					}
						                            // sklanjam zarez sa iza poslednje ispisane vrednosti
						                            if ($i == 1 || $i == $iMAX):
						                                $attrLABELs = substr($attrLABELs, 0, -2);
						                            endif;

						                            echo '<span>'.$attrLABELs.'</span>';
		                        					echo '<br>';

		                        				endif;

		                        				


		                        			}
		                        		@endphp
		                        	@endif
		                        	
		                        </td>
		                        <td class="text-right">
                                    @if ($prod->p_product_price_with_discount != null)
                                        {{ number_format($prod->p_product_price_with_discount,0,"",".") }}
                                    @else
                                        {{ number_format($prod->oi_price,0,"",".") }}
                                    @endif
		                        </td>
		                        <td class="text-center">
                                    @if ($prod->oi_discount != null)
                                        {{ $prod->oi_discount }}%
                                    @else
                                        -
                                    @endif
		                        </td>
		                        <td class="text-right">
                                    @if ($prod->oi_discount != null)

                                        @php
                                            $discountPrice = $prod->oi_price-(($prod->oi_price/100)*$prod->oi_discount);
                                        @endphp

                                        {{ number_format($discountPrice,0,"",".") }}

                                    @else
                                        -
                                    @endif
		                        </td>
		                        <td class="text-center">{{ $prod->oi_kolicina }}</td>
		                        <td class="text-right">

		                        	@php
		                        		if ($prod->p_product_price_with_discount != null):
		                        			$displayPrice = $prod->p_product_price_with_discount;
		                        		elseif ($prod->oi_discount != null):
		                        			$displayPrice = $discountPrice;
			                        	else:
			                        		$displayPrice = $prod->oi_price;
			                        	endif;
		                        	@endphp

			                        <div class="priceWrap">
			                        	<span class="finalPrice">{{ number_format($displayPrice,0,"",".") }}</span>
			                        </div>

		                        	@php
		                        		// konacna cena po proizvodu
		                        		$productTotal = $displayPrice * $prod->oi_kolicina;

		                        		// kreiram sumu za konacan prikaz
		                        		$amount = $amount + $productTotal;

		                        	@endphp

		                        </td>
							</tr>
	                    	@endforeach

		                    </tbody>
		                </table>

	                </div>

                    <div class="row">

			            <div class="col-xl-12">

	                        <div id="cartAmountWrap" class="">

	                            <div id="cartAmount" class="row">
	                                <div id="cartAmount_label" class="col-xl-6"><label>@lang('shop.order_amount'):</label></div>
	                                <div id="cartAmount_txt" class="col-xl-6 text-right"><span>{{ number_format($amount,0,"",".") }}</span> {{ setting('shop.valuta') }}</div>
	                            </div>

	                            <div id="cartAmount" class="row">
	                                <div id="cartAmount_label" class="col-xl-6"><label>@lang('shop.order_discount'):</label></div>
	                                <div id="cartAmount_txt" class="col-xl-6 text-right"><span>{{ $orderDetails->ord_rabat }}</span> %</div>
	                            </div>

	                            <div id="cartShipping" class="row">
	                                <div id="cartShipping_label" class="col-xl-4"><label>@lang('shop.order_shipping'):</label></div>
	                                <div id="cartShipping_txt" class="col-xl-8 small text-right">{{ setting('shop.shop_delivery_note') }}</div>
	                            </div>

	                            @php
	                            	$total = $amount - ($amount/100)*$orderDetails->ord_rabat;
	                            @endphp


	                            <div id="cartTotal" class="row">
	                                <div id="cartTotal_label" class="col-xl-6">
	                                    <label>@lang('shop.order_total'):</label>
	                                    <span>(@lang('shop.order_amount_total_vat'))</span>
	                                </div>
	                                <div id="cartTotal_txt" class="col-xl-6 text-right"><label>{{ number_format($total,0,"",".") }}</label> {{ setting('shop.valuta') }}</div>
	                            </div>

	                        </div>

			            </div>

                    </div>

	            </div>

	        </div>


    	</div>

    </div>
    <div class="row">
        <div class="col-xl-12">

		    <div class="row">

	            <div class="col-md-6">

	                <div class="card mb-4">

	                    <div class="card-header">
	                        <h4 class="card-title m-0">@lang('shop.order_comment')</h4>
	                    </div>

	                    <div class="card-body">

	                    	{!! $orderDetails->ord_comment !!}

	                	</div>

	                </div>

	            </div>

	            <div class="col-md-6">

	                <div id="orderStatus" class="card mb-4">

	                    <div class="card-header">
	                        <h4 class="card-title m-0">@lang('shop.order_status')</h4>
	                    </div>

	                    <div class="card-body">

	                    	<div><label>@lang('shop.order_date'):</label> <span>{{ date('d.m.Y', strtotime($orderDetails->ord_created_at)) }}</span></div>
	                    	<div><label>@lang('shop.order_status'):</label> <span>{!! $orderDetails->ord_stat_title !!}</span></div>
	                    	@if (strtotime($orderDetails->ord_updated_at) != '')
	                    		<div><label>@lang('shop.order_update'):</label> <span>{{ date('d.m.Y', strtotime($orderDetails->ord_updated_at)) }}</span></div>
	                    	@endif
	                    	<div><label>@lang('shop.order_proforma_invoice'):</label> <a href="/storage/proforma-invoice/{{ $orderDetails->ord_proforma_invoice }}.pdf" target="_blank">{{ $orderDetails->ord_proforma_invoice }}</a></div>
	                	</div>

	                </div>

	            </div>


	        </div>

    	</div>

    </div>

	<div class="row">

		<div class="col-xl-12">

            <div class="card mb-4">

                <div class="card-header">
                    <h4 class="card-title m-0">@lang('shop.thank_you_shipping')</h4>
                </div>

                <div class="card-body">

                    <div id="shippingAddress" class="row">
                        <div class="col-xl-6">

                        	<h5 class="mb-3">@lang('shop.thank_you_customer_details'):</h5>

                            <ul>
                                <li class="mb-2"><label>@lang('shop.order_name'):</label> <span>{{ $orderDetails->u_name }} {{ $orderDetails->u_last_name }}</span></li>
                                <li><label>@lang('shop.order_address'):</label> <span>{{ $orderDetails->u_address }}</span></li>
                                <li><label>@lang('shop.order_zip'):</label> <span>{{ $orderDetails->u_zip }}</span></li>
                                <li class="mb-2"><label>@lang('shop.order_city'):</label> <span>{{ $orderDetails->u_city }}</span></li>
                                <li><label>@lang('shop.order_phone'):</label> <span>{{ $orderDetails->u_phone }}</span></li>
                                <li><label>@lang('shop.order_email'):</label> <span>{{ $orderDetails->u_email }}</span></li>
                            </ul>

                        </div>

                        <div class="col-xl-6">

                        	<h5 class="mb-3">@lang('shop.thank_you_shipping_details'):</h5>

                            <ul>
                                <li class="mb-2"><label>@lang('shop.order_name'):</label> <span>{{ $orderDetails->ord_shp_name }} {{ $orderDetails->ord_shp_last_name }}</span></li>
                                <li><label>@lang('shop.order_address'):</label> <span>{{ $orderDetails->ord_shp_address }}</span></li>
                                <li><label>@lang('shop.order_zip'):</label> <span>{{ $orderDetails->ord_shp_zip }}</span></li>
                                <li class="mb-2"><label>@lang('shop.order_city'):</label> <span>{{ $orderDetails->ord_shp_city }}</span></li>
                                <li><label>@lang('shop.order_phone'):</label> <span>{{ $orderDetails->ord_shp_phone }}</span></li>
                                <li><label>@lang('shop.order_email'):</label> <span>{{ $orderDetails->ord_shp_email }}</span></li>
                            </ul>

                        </div>

                    </div>

                </div>

            </div>

		</div>

	</div>

	</div>

</div>

</div>

@php
// echo '<pre>';
// print_r($orderDetails);
// echo '</pre>';
@endphp

</div>


@endsection