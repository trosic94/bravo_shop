@include('emails.mail_header')

			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#231f20">
				<tr bgcolor="#231f20">
					<td>
					<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
						<tr>
							<td width="50%" style="color: #ffffff; text-transform: uppercase; font-size: 18px; padding: 5px 10px; font-family: Arial, Helvetica, sans-serif;">@lang('shop.email_order_title')</td>
							<td width="50%" style="color: #ffffff; text-transform: uppercase; font-size: 18px; padding: 5px 10px; font-family: Arial, Helvetica, sans-serif; text-align: right;">{{ $dateTime }}</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

			&nbsp;<br>
			<table cellpadding="0" cellspacing="0" width="90%" align="center">
				<tr>
					<td style="padding: 25px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #231f20;">
					@lang('shop.email_hello'),
					<br>
					<br>
					@if ($order['payment_method'] == 1)
						@lang('shop.email_cc_payment_intro_note')<br>
					@else
						@lang('shop.email_other_payment_intro_note_admin_1') <strong>{{ $order['order_number'] }}</strong> @lang('shop.email_other_payment_intro_note_admin_2')<br>
						@lang('shop.email_other_payment_intro_note_admin_3') <a href="{{ $url }}/storage/proforma-invoice/{{ $order['proforma_invoice'] }}.pdf" target="_blank" style="text-decoration: none; color: #e31a51; font-weight: bold;">@lang('shop.email_other_payment_intro_link')</a>.<br>
					@endif
					<br>
					<table width="100%" cellpadding="0" cellspacing="0">
						<thead>
							<tr bgcolor="#494949">
								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_no')</th>
								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_image')</th>
								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_product')</th>

								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_price')</th>
								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_discount')</th>
								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_base_price')</th>

								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_units_type')</th>
								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_quantity')</th>
								<th style="padding: 3px; color: #ffffff;">@lang('shop.email_product_tbl_price') ({{ setting('shop.valuta') }})</th>
							</tr>
						</thead>
						<tbody>

							@php
								$osnovicaTOTAL = 0;
								$pdvTOTAL = 0;
								$ukupnoTOTAL = 0;
								$ukupnoTOTALsaRabatom = 0;

								// kreiram konacnu sumu za racun
								$suma = 0;
							@endphp

							@for ($oi=0; $oi<count($order_items); $oi++)

								<tr>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: center;">{{ $oi+1 }}</td>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: center;"><img src="{{ $order_items[$oi]['prod_image'] }}" width="70" height="auto"></td>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20;">
										{{ $order_items[$oi]['prod_title'] }}<br>
										<br>
										<span style="color: #389178; font-weight: bold;">@lang('shop.email_product_tbl_sku'):</span> <span>{{ $order_items[$oi]['prod_sku'] }}</span><br>
										<br>

										@if ($order_items[$oi]['attr'])

											@php

											foreach ($order_items[$oi]['attr'] as $attrKey => $attr):

													$a = 0;
						        					$iMAX = 0;
						        					$attrLABELs = '';

						        					echo '<div style="font-size: 11px;">';
													// ispis Labele
													echo '<span class="mr-1" style="font-weight: bold;">'.$attr['title'].'</span>: ';

													//ispis odabranih dinamickih atributa
						        					foreach ($order_items[$oi]['attr'] as $attrLBLKey => $attrLBL) {

						        						if ($attr['id'] == $attrLBL['id']):

						        							foreach ($attrLBL['val'] as $vKey => $attrData) {

						            							$attrLABELs .= $attrData['label'].', ';
						            							$a++;
						            							$iMAX++;
						        								
						        							}

						        						endif;

						        					}
						                            // sklanjam zarez sa iza poslednje ispisane vrednosti
						                            if ($a == 1 || $a == $iMAX):
						                                $attrLABELs = substr($attrLABELs, 0, -2);
						                            endif;

						                            echo '<span>'.$attrLABELs.'</span>';
						        					echo '</div>';


											endforeach;

											@endphp 

										@endif

									</td>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: right;">{{ number_format($order_items[$oi]['prod_price'],2,".","") }}</td>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: center;">
										@if ($order_items[$oi]['prod_discount'] != null)
											{{ $order_items[$oi]['prod_discount'] }}%
										@else
											-
										@endif
									</td>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: right;">
									@if ($order_items[$oi]['prod_discount'] != null)
										@php
											$discountPrice = $order_items[$oi]['prod_price']-(($order_items[$oi]['prod_price']/100)*$order_items[$oi]['prod_discount']);
										@endphp
										{{ number_format($discountPrice,2,".","") }}
									@else
										-
									@endif
									</td>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: center;">@lang('shop.email_product_tbl_units_type')</td>
									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: center;">{{ $order_items[$oi]['quantity'] }}</td>

									<td valign="top" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: right;">
									@php
										if ($order_items[$oi]['prod_discount'] != null):
											$iznos = $discountPrice*$order_items[$oi]['quantity'];
										else:
											$iznos = $order_items[$oi]['display_price']*$order_items[$oi]['quantity'];
										endif;
									@endphp

										{{ number_format($iznos,0,".","") }}
									</td>
								</tr>

								@php
									$osnovicaTOTAL = $osnovicaTOTAL + $iznos;
								@endphp

							@endfor

							@php
								$ukupnoTOTAL = $ukupnoTOTAL + $osnovicaTOTAL;
							@endphp

							<tr bgcolor="#f0f0f0">
								<td colspan="6" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: right; font-weight: bold;">@lang('shop.email_product_tbl_amount'):</td>
								<td colspan="3" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: right; font-weight: bold;">{{ $osnovicaTOTAL }}%</td>
							</tr>
							<tr bgcolor="#f0f0f0">
								<td colspan="6" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: right; font-weight: bold;">@lang('shop.email_product_tbl_discount'):</td>
								<td colspan="3" style="padding: 3px; border-bottom: 1px solid #231f20; text-align: right; font-weight: bold;">{{ $order['rabat'] }}%</td>
							</tr>

		                    @php
		                        $ukupnoTOTALsaRabatom = $ukupnoTOTAL - ($ukupnoTOTAL/100)*$order['rabat'];
		                    @endphp

							<tr bgcolor="#f0f0f0">
								<td colspan="6" style="padding: 3px; text-align: right; font-weight: bold;">@lang('shop.email_product_tbl_total'):</td>
								<td colspan="3" style="padding: 3px; text-align: right; font-weight: bold;">{{ number_format($ukupnoTOTALsaRabatom,0,".","") }} {{ setting('site.valuta') }}</td>
							</tr>
							<tr>
								<td colspan="6" style="padding: 3px; text-align: right; font-size: 80%;"><strong>@lang('shop.email_product_tbl_delivery'):</strong> {{ setting('shop.shop_delivery_note') }}</td>
							</tr>
		                    @php
		                        $total = $ukupnoTOTALsaRabatom;
		                    @endphp
							<tr bgcolor="#F48473">
								<td colspan="6" style="padding: 3px; color: #ffffff; text-align: right; font-weight: bold; font-size: 16px;">@lang('shop.email_product_tbl_order_total')</td>
								<td colspan="3" style="padding: 3px; color: #ffffff; text-align: right; font-weight: bold; font-size: 16px;">{{ number_format($total,0,".","") }} {{ setting('site.valuta') }}</td>
							</tr>
						</tbody>
					</table>
					<br>
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="50%">
								<strong>@lang('shop.email_customer'):</strong><br>
								@lang('shop.email_name'): {{ $customer['name'] }} {{ $customer['last_name'] }}<br>
								@lang('shop.email_address'): {{ $customer['address'] }}, {{ $customer['zip'] }} {{ $customer['city'] }}
							</td>
							<td width="50%">
								<strong>@lang('shop.email_shipping_data'):</strong><br>
								@lang('shop.email_name'): {{ $order_shipping['shp_name'] }} {{ $order_shipping['shp_last_name'] }}<br>
								@lang('shop.email_address'): {{ $order_shipping['shp_address'] }}, {{ $order_shipping['shp_zip'] }} {{ $order_shipping['shp_city'] }}
							</td>
						</tr>
					</table>


					<br>
					<br>
					</td>
				</tr>
			</table>
			&nbsp;<br>

@include('emails.mail_footer')