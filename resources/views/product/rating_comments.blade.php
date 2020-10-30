<div id="commentWrap" class="row mt-1">
	<div class="col-xl-12 pb-3">
		@if ($daLiMozeDaOcenjujeIKomentarise == 1)
			<div class="row">
				<div class="col-xl-12">
					<div class="md-form">
						<textarea id="rateCommentTXT" class="md-textarea form-control" rows="3"></textarea>
						<label for="rateCommentTXT">@lang('shop.rate_comment_add')</label>
					</div>
					<div id="addTo_CART" class="rounded-pill" onclick="addRateComment({{ $productDATA->prod_id }})">@lang('shop.btn_send')</div>
					<div id="rateCommentMSG"></div>
				</div>
			</div>
		@endif
	</div>
</div>