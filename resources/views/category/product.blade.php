

	<div class="col-md-4 pl-2 pl-lg-0 pr-2 pr-lg-0 pb-4 d-flex wow animated fadeIn">
		<div class="prodOne white pl-0 pr-0 m-3 z-depth-1 text-default">

		<div class="imgWrap">
			<div id="addTo_FAV" class="prod_{{ $prod->prod_id }}" onclick="FavEvent({{ $prod->prod_id }})">
				<i class="far fa-heart fa-2x {{ (in_array($prod->prod_id,$favLIST))? 'd-none':'d-block' }}"></i>
				<i class="fas fa-heart fa-2x {{ (in_array($prod->prod_id,$favLIST))? 'd-block':'d-none' }}"></i>
			</div>
			@if ($prod->prod_discount != null)
				<div class="discountNOTE {{ ($prod->b_title != '')? 'discountNOTE_position_wBagge':'discountNOTE_position_noBagge' }}">-{{ $prod->prod_discount }}%</div>
			@endif
			@if ($prod->b_title != '')
				<div class="akcijaNOTE" style="background-color: {{ $prod->b_color }}; color: {{ $prod->b_text_color }};">{{ $prod->b_title }}</div>
			@endif
			<a href="{{ $productSLUG }}/{{ $prod->prod_slug }}"><img src="/storage/products/{{ ($prod->prod_image != null)? $prod->prod_image:'no_image.jpg' }}" alt="{{ $prod->prod_title }}" class="img100"></a>
		</div>

		<h3><a href="{{ $productSLUG }}/{{ $prod->prod_slug }}">{{ $prod->prod_title }}</a></h3>

		<div class="prodFooter">

			<div class="priceWrap">
			@if ($prod->prod_price_with_discount != null)
				<span class="fullPrice">{{ number_format($prod->prod_price,0,"",".") }} {{ setting('shop.valuta') }}</span>
				<span class="discountPrice">{{ number_format($prod->prod_price_with_discount,0,"",".") }} {{ setting('shop.valuta') }}</span>

			@elseif ($prod->prod_discount != null)
				<span class="fullPrice">{{ number_format($prod->prod_price,0,"",".") }} {{ setting('shop.valuta') }}</span>

				@php
					$discountPrice = $prod->prod_price-(($prod->prod_price/100)*$prod->prod_discount);
				@endphp

				<span class="discountPrice">cena: {{ number_format($discountPrice,0,"",".") }} {{ setting('shop.valuta') }}</span>

			@else
				<span class="singlePrice">cena: {{ number_format($prod->prod_price,0,"",".") }} {{ setting('shop.valuta') }}</span>
			@endif
			</div>

			{{-- <div class="row">
			<div class="col text-center">
				@if ($prod->prod_on_stock == 1)
					<span id="addTo_CART" class="rounded-pill" onclick="CartEvent({{ $prod->prod_id }})"><i class="fas fa-shopping-cart"></i> @lang('shop.btn_buy')</span>
				@endif
			</div>
			</div> --}}

		</div>

		</div>
	</div>
