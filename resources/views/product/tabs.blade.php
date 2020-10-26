	
	@if ($productDATA->prod_body != '' || $productDATA->prod_specification != '' || $productDATA->prod_video != '')

	<div class="row w-100">

		<div class="col-xl-12">

			<div class="prodTABs">

				<ul class="nav nav-tabs  md-tabs  ml-0 mr-0 p-0 rounded-0 z-depth-0" id="tabsProduct" role="tablist">
				
					@if ($productDATA->prod_body != '')
					<li class="nav-item col-md-2 col-12 p-0 ">
						<a class="nav-link rounded-0 active text-left p-0 pb-2 mt-md-0 mt-2" id="body-tab-md" data-toggle="tab" href="#body-md" role="tab" aria-controls="body-md" aria-selected="true">@lang('shop.title_description')</a>
						 <span></span>
					</li>
					@endif

					{{-- @if ($productDATA->prod_specification != '') --}}
					<li class="nav-item col-md-4 col-12 p-0 ">
						<a class="nav-link rounded-0 text-left p-0 pb-2 mt-md-0 mt-2" id="specification-tab-md" data-toggle="tab" href="#specification-md" role="tab" aria-controls="specification-md" aria-selected="false">@lang('shop.title_additional_information')</a>
						 <span></span>
					</li>
					{{-- @endif --}}

					<li class="nav-item col-md-2 col-12 p-0 mt-md-0 mt-xs-5">
						<a class="nav-link rounded-0 text-left p-0 pb-2 mt-md-0 mt-2" id="video-tab-md" data-toggle="tab" href="#video-md" role="tab" aria-controls="video-md" aria-selected="false">@lang('shop.title_reviews')</a>
						 <span></span>
					</li>
				</ul>

				<div class="tab-content card p-0 pt-3 rounded-0 z-depth-0" id="tabsProductContent">

					
					<div class="tab-pane fade show active" id="body-md" role="tabpanel" aria-labelledby="body-tab-md">
						
							<div class="primary-text mb-3">
								@if ($productDATA->prod_body != '')
								{!! $productDATA->prod_body !!}
								@endif
							</div>	
				          	<div class="container">
				          		<form id="addToCart" method="POST" action="/add-to-cart" enctype="multipart/form-data">
				          		{{-- <div class="col-md-12"> --}}
				          			
								{{-- ATTRIBUTES --}}
									@if (!$selectedAttributes->isEmpty())

										@include ('product.attributes_bravo')

										<input type="hidden" name="attr_exist" value="1">
									@else	
										<input type="hidden" name="attr_exist" value="0">

									@endif
									{{-- ATTRIBUTES --}}
									{{-- PRICE --}}
									@include ('product.price')
						          	{{-- PRICE --}}
				          			<div class="row">
				          				{{-- QUANTITY --}}
				          				@include ('product.quantity')
						          		{{-- QUANTITY --}}
						          		{{-- BUY --}}
							          	@include ('product.buy')
							          	{{-- BUY --}}
				          			</div>
				          		</form>
				          	</div>
						</div>
					

					{{-- @if ($productDATA->prod_specification != '') --}}
					<div class="tab-pane fade" id="specification-md" role="tabpanel" aria-labelledby="specification-tab-md">
						<div class="container p-0">
							<ul class="no-bullets">
								<li>
									<p class="d-inline">@lang('shop.title_category'): </p>
									<p class="font-weight-bold d-inline">
										{{$productDATA->cat_name}}
									</p>
								</li>
								@foreach ($allAttributesForProduct as  $atribut)
									@if (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod))
										<li>
											<p class="d-inline">{{$atribut['attr_name']}}: </p>
											<p class="font-weight-bold d-inline">
											@php
												$values = '';
											@endphp 
											@foreach ($atribut['attr_values'] as  $atrr_value)
												@if (in_array($atrr_value['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))
													@php
														$values .= $atrr_value['label'].',';
													@endphp
												@endif
		            						@endforeach
		            						@php
												echo rtrim($values, ',');
											@endphp 

											</p>
										</li>
									@endif
								@endforeach
							</ul>
							
						</div>
					</div>
					{{-- @endif --}}

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