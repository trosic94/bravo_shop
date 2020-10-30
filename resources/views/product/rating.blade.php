					<div id="ratingWrap" class="row">
						
						<div class="col-xl-12 pb-3">

							<h5 class="mb-3 mt-0">@lang('shop.title_rate_product')</h5>

							<div class="row">

								@if (setting('shop.rating') == 1)

									<div id="rateOptions" class="ml-3 w-auto" onmouseout="rateOF({{ count($ratingOptions) }},{{ $productRate }})">

										@foreach ($ratingOptions as $rKey => $rate)

											<span
												@if ($daLiMozeDaOcenjujeIKomentarise != 1)
												class="blank"
												@endif
												id="rate{{ $rKey }}" 
												data-toggle="tooltip" 
												title="{{ $rate->ro_name }}"
												@if ($daLiMozeDaOcenjujeIKomentarise == 1)
												onmouseover="rateON({{ $rate->ro_id }},{{ count($ratingOptions) }})" 
												onclick="rateMe({{ $rate->ro_id }},{{ $rate->ro_value }},{{ $productDATA->prod_id }},{{ $rKey }})"
												@endif
												>
												<i class="fas fa-star {{ ($productRate > $rKey)? 'starON':'starOFF' }}"></i>
											</span>

										@endforeach

									</div>

								@endif

							</div>

						{{-- <div class="rate">@lang('shop.title_rate'): <span id="rateVal">{{ $productRate }}</span></div> --}}

							@if ($daLiMozeDaOcenjujeIKomentarise == 1)
							<div id="rateMSG"></div>
							@endif

							@if (setting('shop.rating_comments') == 1)

								@include ('product.rating_comments')

							@endif

		          		</div>

		          	</div>


@php
// echo '<pre>';
// print_r($daLiJeKupioProizvod);
// print_r($ulogovan);
// echo '</pre>';
@endphp