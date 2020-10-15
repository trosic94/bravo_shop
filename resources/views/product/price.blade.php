					<div class="row mt-4 mb-4">
						
						<div class="col-xl-12">

							<div class="productPriceWrap">
								@if ($productDATA->prod_price_with_discount != null)
									<span class="fullPrice">@lang('shop.title_price'): {{ number_format($productDATA->prod_price,0,"",".") }} {{ setting('shop.valuta') }}</span>
									<span class="discountPrice">@lang('shop.title_price_with_discount'): {{ number_format($productDATA->prod_price_with_discount,0,"",".") }} {{ setting('shop.valuta') }}</span>

					            @elseif ($productDATA->prod_discount != null)
					            	<span class="fullPrice">@lang('shop.title_price'): {{ number_format($productDATA->prod_price,0,"",".") }} {{ setting('shop.valuta') }}</span>

					            	@php
					            		$discountPrice = $productDATA->prod_price-(($productDATA->prod_price/100)*$productDATA->prod_discount);
					            	@endphp

					            	<span class="discountPrice">@lang('shop.title_price_with_discount'): {{ number_format($discountPrice,0,"",".") }} {{ setting('shop.valuta') }}</span>

								@else
									<span class="singlePrice">@lang('shop.title_price'): {{ number_format($productDATA->prod_price,0,"",".") }} {{ setting('shop.valuta') }}</span>
								@endif
							</div>

		          		</div>

		          	</div>