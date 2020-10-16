@extends ('includes.page')

@section ('content')

<div id="pageWrap">

	<div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
		<h1>@lang('shop.title_search')</h1>
	</div>

	<div class="row pr-4 mt-4">

		<div class="col-lg-3">
			
			@include ('includes.left')

		</div>

		<div class="col-lg-9">
			
			<div class="row">

			@if (!$searchREZ->isEmpty())

				@foreach ($searchREZ as $key => $prod)

				@php
					$productSLUG = App\Product::productsSLUG_By_catID($prod->prod_cat_id);
				@endphp

					@include ('category.product')

				@endforeach

			</div>
			<div class="row">
				<div id="paginateBlock">
					{{ $searchREZ->appends(Request::except('page'))->links() }}
				</div>
			</div>

			@else

				<div class="col-xl-12 pt-4">
					<h4>@lang('shop.title_search_no_result')</h4>
				</div>

			@endif

		</div>

	</div>
@php
    // echo '<pre class="text-white">';
    // print_r($currentCAT);
    // print_r($searchREZ);
    // echo '</pre>';
@endphp

</div>

@endsection