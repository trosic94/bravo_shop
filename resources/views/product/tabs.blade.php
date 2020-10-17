	
	@if ($productDATA->prod_body != '' || $productDATA->prod_specification != '' || $productDATA->prod_video != '')

	<div class="row mt-5">

		<div class="col-xl-12">

			<div class="prodTABs">

				<ul class="nav nav-tabs nav-justified md-tabs  ml-0 mr-0 p-0 rounded-0 z-depth-0" id="tabsProduct" role="tablist">

					@if ($productDATA->prod_body != '')
					<li class="nav-item col-2 p-0">
						<a class="nav-link rounded-0 active text-left p-0" id="body-tab-md" data-toggle="tab" href="#body-md" role="tab" aria-controls="body-md" aria-selected="true">@lang('shop.title_description')</a>
					</li>
					@endif

					@if ($productDATA->prod_specification != '')
					<li class="nav-item">
						<a class="nav-link rounded-0" id="specification-tab-md" data-toggle="tab" href="#specification-md" role="tab" aria-controls="specification-md" aria-selected="false">@lang('shop.title_specification')</a>
					</li>
					@endif

					@if ($productDATA->prod_video != '')
					<li class="nav-item">
						<a class="nav-link rounded-0" id="video-tab-md" data-toggle="tab" href="#video-md" role="tab" aria-controls="video-md" aria-selected="false">@lang('shop.title_video')</a>
					</li>
					@endif

				</ul>

				<div class="tab-content card p-0 pt-3 rounded-0 z-depth-0" id="tabsProductContent">

					
					<div class="tab-pane fade show active" id="body-md" role="tabpanel" aria-labelledby="body-tab-md">
						<div class="primary-text">
							@if ($productDATA->prod_body != '')
							{!! $productDATA->prod_body !!}
							@endif
						</div>
						
						<div id="prodFooterWrap" class="{{ (count($selectedAttributes) == 0)? 'alignElementToBottom':'' }}">

								
									<div class="col-6">
										<div class="row">
											<div class="productSize d-inline p-2 mr-2 ">
												<p class="my-auto">36</p>
											</div>
											<div class="productSize d-inline p-2 mr-2">
												<p>36</p>
											</div>
											<div class="productSize d-inline p-2 mr-2">
												<p>36</p>
											</div>
										</div>
										
									</div>
								

								{{-- PRICE --}}
								@include ('product.price')
					          	{{-- PRICE --}}

					          	@include ('product.quantity')

					          	{{-- BUY --}}
					          	@include ('product.buy')
					          	{{-- BUY --}}


				          	</div>
						</div>
					

					@if ($productDATA->prod_specification != '')
					<div class="tab-pane fade" id="specification-md" role="tabpanel" aria-labelledby="specification-tab-md">
						{!! $productDATA->prod_specification !!}
					</div>
					@endif

					@if ($productDATA->prod_video != '')
					<div class="tab-pane fade" id="video-md" role="tabpanel" aria-labelledby="video-tab-md">

						<div class="ytEmbedContainter mar_b_10">
							<iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{ $productDATA->prod_video }}"></iframe>
						</div>

					</div>
					@endif

				</div>

			</div>

		</div>

	</div>

	@endif