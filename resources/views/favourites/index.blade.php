@extends ('includes.page')

@section ('content')

<div id="pageWrap">

	<div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
		<h1>@lang('shop.title_favourites')</h1>
	</div>


	<div class="row mt-5">

		<div class="col-lg-12">

			<div class="row pl-4 pl-xl-0 pr-4 pr-xl-0">

				@if ($productsFor_FAV->isEmpty())
					<div class="col-lg-12">
						@lang('shop.title_favourites_none_note')
					</div>
				@endif

				@foreach ($productsFor_FAV as $key => $prod)

				@php
					$productSLUG = App\Product::productsSLUG_By_catID($prod->prod_cat_id);
				@endphp

		        <div class="col-md-3 pl-2 pl-lg-0 pr-2 pr-lg-0 pb-4 d-flex wow animated fadeIn">
			          <div class="prodOne white pl-0 pr-0 m-3 z-depth-1 text-default">

			            <div class="imgWrap">
		              		<div id="addTo_FAV" class="prod_{{ $prod->prod_id }}" onclick="FavEvent({{ $prod->prod_id }})">
		                      <i class="far fa-heart fa-2x red-text {{ (in_array($prod->prod_id,$favLIST))? 'd-none':'d-block' }}"></i>
		                      <i class="fas fa-heart fa-2x red-text {{ (in_array($prod->prod_id,$favLIST))? 'd-block':'d-none' }}"></i>
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

				            	<span class="discountPrice">{{ number_format($discountPrice,0,"",".") }} {{ setting('shop.valuta') }}</span>

			                @else
			                	<span class="singlePrice">{{ number_format($prod->prod_price,0,"",".") }} {{ setting('shop.valuta') }}</span>
			                @endif
			              </div>

			              <div class="row">
			              	<div class="col text-center"><span id="addTo_CART" class="rounded-pill" onclick="CartEvent({{ $prod->prod_id }})"><i class="fas fa-shopping-cart"></i> @lang('shop.btn_buy')</span></div>
			              </div>

			            </div>

			          </div>
		        </div>
				@endforeach

			</div>
			<div class="row">
				<div id="paginateBlock">
					{{ $productsFor_FAV->links() }}
				</div>
			</div>

		</div>

	</div>
	
@php
    // echo '<pre>';
    // print_r($productsFor_FAV);
    // echo '</pre>';
@endphp

</div>

@endsection