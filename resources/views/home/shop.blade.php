<div id="shopBlock">

	<div class="container site-max-width">

		<div class="row ml-0 mr-0">

			<div class="col-md-6 mb-5 mb-md-0">

				<div class="row justify-content-end">

					<div id="productCard" class="col-xl-6 col-lg-8">

						<h2 class="mb-3">@lang('shop.title_decorative_ribbons')</h2>

						<div class="card rounded-0 p-3">

							<h4 class="card-title text-center">@lang('shop.title_create_ribbon')</h4>

							<form method="POST" action="/submit-cat">

								@csrf

								<div class="card-text mb-5">

									<select name="selLevel1_T" onchange="findeCatLevel(this.value,2,'T')" class="mdb-select md-form mt-2 mb-2" searchable="@lang('shop.title_find')...">
										<option value="" disabled selected>@lang('shop.title_select_design')</option>
										@foreach ($cat_Trakice as $cat)
											<option value="{{ $cat->cat_id }}|{{ $cat->cat_slug }}">{{ $cat->cat_name }}</option>
										@endforeach
									</select>

									<select name="selLevel2_T" onchange="findeCatLevel(this.value,3,'T')" class="mdb-select md-form mt-2 mb-2" searchable="@lang('shop.title_find')..." disabled>
										<option value="" disabled selected>@lang('shop.title_choose')</option>
									</select>

									<select name="selLevel3_T" class="mdb-select md-form mt-2 mb-2" searchable="@lang('shop.title_find')..." disabled>
										<option value="" disabled selected>@lang('shop.title_choose')</option>
									</select>

								</div>

								<input type="hidden" name="pType" value="T">

								<button class="btn rounded-pill btn-block mt-4">@lang('shop.btn_search')</button>

							</form>

						</div>

					</div>

				</div>

			</div>

			<div class="col-md-6">

				<div class="row justify-content-end">

					<div id="productCard" class="col-xl-6 col-lg-8">

					<h2 class="mb-3">@lang('shop.title_protective_masks')</h2>

					<div class="card rounded-0 p-3">

						<h4 class="card-title text-center pb-2">@lang('shop.title_create_mask')</h4>

						<form method="POST" action="/submit-cat">

							@csrf

							<div class="card-text mb-5">

								<select name="selLevel1_M" onchange="findeCatLevel(this.value,2,'M')" class="mdb-select md-form mt-2 mb-2" searchable="@lang('shop.title_find')...">
									<option value="" disabled selected>@lang('shop.title_select_design')</option>
									@foreach ($cat_ZastitneMaske as $cat)
										<option value="{{ $cat->cat_id }}|{{ $cat->cat_slug }}">{{ $cat->cat_name }}</option>
									@endforeach
								</select>

								<select name="selLevel2_M" onchange="findeCatLevel(this.value,3,'M')" class="mdb-select md-form mt-2 mb-2" searchable="@lang('shop.title_find')..." disabled>
									<option value="" disabled selected>@lang('shop.title_choose')</option>
								</select>

								<select name="selLevel3_M" class="mdb-select md-form mt-2 mb-2" searchable="@lang('shop.title_find')..." disabled>
									<option value="" disabled selected>@lang('shop.title_choose')</option>
								</select>

							</div>

							<input type="hidden" name="pType" value="M">

							<button class="btn rounded-pill btn-block mt-4">@lang('shop.btn_search')</button>

						</form>

					</div>

					</div>

				</div>

			</div>

		</div>

	</div>

@php
	// echo '<pre>';
	// print_r($cat_LEVEL_1);
	// echo '</pre>';
@endphp

</div>