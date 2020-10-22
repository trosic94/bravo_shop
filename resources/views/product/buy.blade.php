		          	{{-- <div class="row"> --}}
		          		<div class="col-auto mt-md-0 mt-4 p-0 ml-md-4 ml-xs-0">
		          			@if ($productDATA->prod_on_stock == 1)
								<div id="addTo_CART" class="rounded-pill" onclick="CartEvent({{ $productDATA->prod_id }})">@lang('shop.btn_buy')</div>
							@endif
		          		</div>
		          	{{-- </div> --}}