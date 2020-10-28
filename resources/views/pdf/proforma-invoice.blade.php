<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>@lang('shop.print_meta_title_proformainvoice') - {{ $order['proforma_invoice'] }}</title>
	<style type="text/css">
        @page 
        {
            size: auto;   /* auto is the current printer page size */
            /*margin: 0mm; */ /* this affects the margin in the printer settings */
        }
		html, body { background-color: #FFFFFF; font-family: DejaVu Sans, sans-serif; font-size: 14px; }
		img { width: 170px; height: auto; }
		h1 { margin: 0 0 10px; padding: 0; font-size: 20px;	}
		h3 { margin: 0 0 5px; padding: 0; }
		h4 { margin: 0 0 5px; padding: 0; }
		p { margin: 0; }
    </style>
</head>
<body>

	<table width="100%">
		<tr>
			<td width="35%" valign="top"><img src="storage/{{ setting('site.logo') }}"></td>
			<td width="65%" valign="top">
				<p><strong>{{ setting('company.company_name') }}</strong>, {{ setting('company.company_address') }}, {{ setting('company.company_postal_code') }} {{ setting('company.company_city') }}, {{ setting('company.company_country') }}</p>
				<p>@lang('shop.print_label_phone'): {{ setting('company.company_phone') }}</p>
				<p>@lang('shop.print_label_email'): {{ setting('company.company_email') }}</p>
				<p>@lang('shop.print_label_website'): {{ setting('company.company_web') }}</p>
				<p>@lang('shop.print_label_vat_no'): {{ setting('company.company_pib') }}; @lang('shop.print_label_company_no'): {{ setting('company.company_mb') }}</p>
				<p>@lang('shop.print_label_invoice_id'): {{ setting('company.company_bank_account') }}</p>
			</td>
		</tr>
	</table>

	<h1 style="text-align: center; margin: 30px 0;">@lang('shop.print_label_proforma_invoice_no'): {{ $order['proforma_invoice'] }}</h1>

	<table cellpadding="0" cellspacing="0" width="100%" border="1" style="border: 1px solid #ffffff; border-collapse: collapse; margin: 0 0 30px;">
		<tr>
			<td width="50%" valign="top" style="padding: 5px;">
				<p>@lang('shop.print_label_customer'): {{ $customer['name'] }} {{ $customer['last_name'] }}</p>
				<p>@lang('shop.print_label_address'): {{ $customer['address'] }}, {{ $customer['zip'] }} {{ $customer['city'] }}</p>
				<p>@lang('shop.print_label_email'): {{ $customer['email'] }}</p>
				<p>@lang('shop.print_label_phone'): {{ $customer['phone'] }}</p>
			</td>
			<td width="50%" valign="top" style="padding: 5px;">
				<p>@lang('shop.print_label_issue_date'): {{ date('d.m.Y', strtotime($order['order_date'])) }}</p>
				<p>@lang('shop.print_label_issue_place'): {{ setting('company.company_city') }}, {{ setting('company.company_country') }}</p>
				<p>@lang('shop.print_label_delivery_type'): {{ setting('shop.shop_delivery_note') }}</p>
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" width="100%" border="1" style="border: 1px solid #ffffff; border-collapse: collapse; margin: 0 0 30px; line-height: 90%; font-size: 12px;">
		<thead>
		<tr>
			<th style="text-align: center; padding: 5px; font-size: 11px;">@lang('shop.print_label_row_no')</th>
			<th style="padding: 5px;">@lang('shop.print_label_product_service')</th>
			<th style="text-align: center; padding: 5px; font-size: 11px;">@lang('shop.print_label_price')</th>
			<th style="text-align: center; padding: 5px; font-size: 11px;">@lang('shop.print_label_discount')</th>
			<th style="text-align: center; padding: 5px; font-size: 11px;">@lang('shop.print_label_base_price')</th>
			<th style="text-align: center; padding: 5px; font-size: 11px;">@lang('shop.print_label_units')</th>
			<th style="text-align: center; padding: 5px; font-size: 11px;">@lang('shop.print_label_quantity')</th>
			<th style="text-align: center; padding: 5px; font-size: 11px;">@lang('shop.print_label_price_with_vat')</th>
		</tr>
		</thead>
		<tbody>
			@php
				$osnovicaTOTAL = 0;
				$pdvTOTAL = 0;
				$ukupnoTOTAL = 0;
				$ukupnoTOTALsaRabatom = 0;
			@endphp
			
			@for ($i=0; $i<count($order_items); $i++) { 

				<tr>
					<td valign="top" style="text-align: center; padding: 5px;">{{ $i+1 }}</td>
					<td valign="top" style="padding: 5px;">
						{{ $order_items[$i]['prod_title'] }}<br>
						@lang('shop.my_cart_sku'): {{ $order_items[$i]['prod_sku'] }}<br><br>

						@if ($order_items[$i]['attr'])

							@php

							foreach ($order_items[$i]['attr'] as $attrKey => $attr):

									$a = 0;
		        					$iMAX = 0;
		        					$attrLABELs = '';

		        					echo '<div style="font-size: 10px;">';
									// ispis Labele
									echo '<span class="mr-1" style="font-weight: bold;">'.$attr['title'].'</span>: ';

									//ispis odabranih dinamickih atributa
		        					foreach ($order_items[$i]['attr'] as $attrLBLKey => $attrLBL) {

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

					<td valign="top" style="text-align: right; padding: 5px;">{{ number_format($order_items[$i]['prod_price'],2,".","") }}</td>
					<td valign="top" style="text-align: center; padding: 5px;">
						@if ($order_items[$i]['prod_discount'] != null)
							{{ $order_items[$i]['prod_discount'] }}%
						@else
							-
						@endif
					</td>
					<td valign="top" style="text-align: right; padding: 5px;">
						@if ($order_items[$i]['prod_discount'] != null)
							@php
								$discountPrice = $order_items[$i]['prod_price']-(($order_items[$i]['prod_price']/100)*$order_items[$i]['prod_discount']);
							@endphp
							{{ number_format($discountPrice,2,".","") }}
						@else
							-
						@endif
					</td>

					<td valign="top" style="text-align: center; padding: 5px;">@lang('shop.print_label_units_type')</td>
					<td valign="top" style="text-align: center; padding: 5px;">{{ $order_items[$i]['quantity'] }}</td>

					<td valign="top" style="text-align: right; padding: 5px;">

						@php
							if ($order_items[$i]['prod_discount'] != null):
								$iznos = $discountPrice*$order_items[$i]['quantity'];
							else:
								$iznos = $order_items[$i]['display_price']*$order_items[$i]['quantity'];
							endif;
						@endphp

						{{ number_format($iznos,2,".","") }}
					</td>
				</tr>
				
				@php
					$osnovicaTOTAL = $osnovicaTOTAL + $iznos;
				@endphp

			@endfor

			@php
				$ukupnoTOTAL = $ukupnoTOTAL + $osnovicaTOTAL;
			@endphp

			<tr>
				<td colspan="5"></td>
				<td style="text-align: center; padding: 5px; font-weight: bold; font-size: 11px;">@lang('shop.print_label_base_amount')</td>
				<td style="text-align: center; padding: 5px; font-weight: bold; font-size: 11px;">@lang('shop.print_label_discount')</td>
				<td style="text-align: center; padding: 5px; font-weight: bold; font-size: 11px;">@lang('shop.print_label_total_amount')</td>
			</tr>

			@php
				$ukupnoTOTALsaRabatom = $ukupnoTOTAL - ($ukupnoTOTAL/100)*$order['rabat'];
			@endphp

			<tr>
				<td colspan="5"></td>
				<td style="text-align: right; padding: 5px;">{{ number_format($osnovicaTOTAL,2,".","") }}</td>
				<td style="text-align: right; padding: 5px;">{{ $order['rabat'] }}</td>
				<td style="text-align: right; padding: 5px; background-color: #000000; color: #ffffff;">{{ number_format($ukupnoTOTALsaRabatom,2,".","") }}</td>
			</tr>

		</tbody>
	</table>

	<p style="font-size: 10px; line-height: 90%;">
		{!! setting('shop.shop_proformainvoice_note') !!}
	</p>

	<div style="width: 100%; text-align: right; font-size: 14px; margin: 30px 0 0;">
		<p>{{ setting('company.company_name') }}</p>
	</div>

</body>
</html>