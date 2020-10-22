@extends ('includes.page')

@section ('content')

<div id="pageWrap">

	<div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
		<h1>{{ $productDATA->prod_title }}</h1>
	</div>

	<div class="row pl-4 pl-lg-0 pr-4 mt-5 mb-5">

		{{-- IMAGE --}}
		<div class="col-md-4">
			<div class="imgWrap border">
	            <div id="addTo_FAV" class="prod_{{ $productDATA->prod_id }}" onclick="FavEvent({{ $productDATA->prod_id }})">
	              <i class="far fa-heart fa-2x primary-text {{ (in_array($productDATA->prod_id,$favLIST))? 'd-none':'d-block' }}"></i>
	              <i class="fas fa-heart fa-2x primary-text {{ (in_array($productDATA->prod_id,$favLIST))? 'd-block':'d-none' }}"></i>
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

		<div class="col-md-8  mt-md-0">
			<div id="productDATA">
				<div class="row m-0">
					@include ('product.tabs', ['productDATA' => $productDATA,'favLIST'=>$favLIST]) 
				</div>
			</div>

		</div>

	</div>

</div>

@endsection