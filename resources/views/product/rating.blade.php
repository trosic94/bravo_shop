					<div id="ratingWrap" class="row">
						
						<div class="col-xl-12">

							@if (setting('shop.rating') == 1)


								<div class="container" onmouseout="rateOF({{ count($ratingOptions) }})">

									@foreach ($ratingOptions as $rKey => $rate)

										<span id="rate{{ $rKey }}" data-toggle="tooltip" title="{{ $rate->ro_name }}" onmouseover="rateON({{ $rate->ro_id }},{{ count($ratingOptions) }})" onclick="rateMe({{ $rate->ro_id }},{{ $rate->ro_value }},{{ $productDATA->prod_id }})"><i class="fas fa-star starOFF"></i></span>

									@endforeach

								</div>

								@if (setting('shop.rating_comments') == 1)

									{{-- {{ setting('shop.rating_comments') }} --}}

								@endif

							@endif

		          		</div>

		          	</div>


@php
// echo '<pre>';
// print_r($ratingOptions);
// echo '</pre>';
@endphp

<script type="text/javascript">


</script>