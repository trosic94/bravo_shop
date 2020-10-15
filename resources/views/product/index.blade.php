@extends ('includes.page')

@section ('content')

<div id="pageWrap">

	<div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
		<h1>{{ $productDATA->cat_name }}</h1>
	</div>

	@include('includes.breadcrumb')

	<div class="row pl-4 pl-lg-0 pr-4 mt-5 mb-5">

		{{-- IMAGE --}}
		<div class="col-md-5">
			<div class="imgWrap">
	            <div id="addTo_FAV" class="prod_{{ $productDATA->prod_id }}" onclick="FavEvent({{ $productDATA->prod_id }})">
	              <i class="far fa-heart fa-2x red-text {{ (in_array($productDATA->prod_id,$favLIST))? 'd-none':'d-block' }}"></i>
	              <i class="fas fa-heart fa-2x red-text {{ (in_array($productDATA->prod_id,$favLIST))? 'd-block':'d-none' }}"></i>
	            </div>
	        	@if ($productDATA->prod_discount != null)
	        		<div class="discountNOTE {{ ($productDATA->b_title != '')? 'discountNOTE_position_wBagge':'discountNOTE_position_noBagge' }}">{{ $productDATA->prod_discount }}%</div>
	        	@endif
				@if ($productDATA->b_title != '')
					<div class="akcijaNOTE" style="background-color: {{ $productDATA->b_color }}; color: {{ $productDATA->b_text_color }};">{{ $productDATA->b_title }}</div>
				@endif
				<img src="/storage/products/{{ $productDATA->prod_image }}" class="img100" alt="{{ $productDATA->prod_title }}">
			</div>
		</div>
		{{-- IMAGE --}}

		<div class="col-md-7 mt-5 mt-md-0">

			<div id="productDATA">

			<form id="addToCart" method="POST" action="/add-to-cart" enctype="multipart/form-data">

				{{-- TITLE / FAV --}}
				<div class="row mb-4">

					<div class="col-12">
						<div class="productTitle">
							<h2>{{ $productDATA->prod_title }}</h2>
						</div>
					</div>

				</div>
				{{-- TITLE / FAV --}}

				{{-- PUBLISHER / STOCK --}}
				<div class="row">

					<div class="col-lg-6">

						<label>@lang('shop.title_category'):</label><span>{{ $productDATA->cat_name }}</span>

					</div>
					<div class="col-lg-6">
						
						<label>@lang('shop.title_code'):</label><span>{{ $productDATA->prod_sku }}</span>

					</div>

					<div class="col-lg-6">

						<label>@lang('shop.title_manufacturer'):</label><span>{{ $productDATA->mnf_name }}</span>

					</div>
					<div class="col-lg-6">
						
						<label>@lang('shop.title_available'):</label><span>{{ ($productDATA->prod_on_stock == 1)? trans('shop.title_on_stock'):trans('shop.title_not_on_stock') }}</span>

					</div>

				</div>
				{{-- PUBLISHER / STOCK --}}

				{{-- DESCRIPTION --}}
				@include ('product.description')
				{{-- DESCRIPTION --}}

				{{-- TABs --}}
				{{-- @include ('product.tabs') --}}
				{{-- TABs --}}

				{{-- ATTRIBUTES --}}
				@if (!$selectedAttributes->isEmpty())

					@include ('product.attributes')

					<input type="hidden" name="attr_exist" value="1">
				@else
					<input type="hidden" name="attr_exist" value="0">

				@endif
				{{-- ATTRIBUTES --}}

				{{-- QUANTITY --}}
				@include ('product.quantity')
	          	{{-- QUANTITY --}}

				<div id="prodFooterWrap" class="{{ (count($selectedAttributes) == 0)? 'alignElementToBottom':'' }}">

					{{-- PRICE --}}
					@include ('product.price')
		          	{{-- PRICE --}}

		          	{{-- BUY --}}
		          	@include ('product.buy')
		          	{{-- BUY --}}

		          	{{-- RATING --}}
		          	@include ('product.rating')
		          	{{-- RATING --}}

	          	</div>

			</form>

			</div>

		</div>

	</div>


@php
     // echo '<pre>';
     // print_r($cart);
     // echo '</pre>';
@endphp

</div>

@endsection