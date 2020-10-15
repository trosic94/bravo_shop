				@if ($productDATA->prod_body != '')
					<div class="row mt-3">
						<div class="col-12">
							<h3>@lang('shop.title_description')</h3>
							{!! $productDATA->prod_body !!}
						</div>
					</div>
				@endif

				@if ($productDATA->prod_specification != '')
					<div class="row mt-3">
						<div class="col-12">
							<h3>@lang('shop.title_specification')</h3>
							{!! $productDATA->prod_specification !!}
						</div>
					</div>
				@endif

				@if ($productDATA->prod_video != '')
					<div class="row mt-3">
						<div class="col-12">
							<h3>@lang('shop.title_video')</h3>
							<div class="ytEmbedContainter mar_b_10">
								<iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{ $productDATA->prod_video }}"></iframe>
							</div>
						</div>
					</div>
				@endif