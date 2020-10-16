		          	<div class="row">
		          		<div class="col-xl-12">
		          			@if ($productDATA->prod_on_stock == 1)
								<div id="addTo_CART" class="rounded-pill" onclick="CartEvent({{ $productDATA->prod_id }})">@lang('shop.btn_buy')</div>
							@endif
		          		</div>
		          	</div>