								<div id="commentWrap" class="row mt-3">

									<div class="col-xl-12 pb-3">

										{{-- <h3 class="mb-3">@lang('shop.rate_comment_title')</h3> --}}

										{{-- <div class="row">
											@if ($ratingComments)
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
										<hr> --}}

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

@php
// echo '<pre>';
// print_r($ratingComments);
// echo '</pre>';
@endphp