<div id="ratingWrap" class="row">	
	<div class="col-xl-12">
		<h3 class="mb-3">@lang('shop.rate_comment_title')</h3>

		<div class="row">
			@if (!$ratingComments->isEmpty())
				@foreach ($ratingComments as $rcKey => $comment)
				<div class="col-md-12 mb-3">
					<div class="font-weight-bolder">{{ $comment->prod_comment }}</div>
					<div class="font-italic">{{ $comment->u_name }} {{ $comment->u_last_name }}</div>
				</div>
				@endforeach
			@else
				<div class="col-md-12">
				@if ($daLiMozeDaOcenjujeIKomentarise == 1)
					@lang('shop.rate_comment_first')
				@else
					@lang('shop.rate_no_comments')
				@endif
				</div>
			@endif
		</div>
		<hr>

		@if ($daLiMozeDaOcenjujeIKomentarise == 1)

			<h5 class="mb-3 mt-5">@lang('shop.title_rate_product')</h5>
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
								@endif>
								<i class="fas fa-star {{ ($productRate > $rKey)? 'starON':'starOFF' }}"></i>
							</span>
						@endforeach
					</div>
				@endif
			</div>

		@endif

		@if ($daLiMozeDaOcenjujeIKomentarise == 1)
			<div id="rateMSG"></div>
		@endif

		@if (setting('shop.rating_comments') == 1)
			@include ('product.rating_comments')
		@endif

	</div>
</div>
