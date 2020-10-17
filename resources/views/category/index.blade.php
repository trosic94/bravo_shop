@extends ('includes.page')

@section ('content')

<div id="pageWrap">

	<div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
		<h1>{{ $category->name }}</h1>
	</div>

	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-9">
			<div class="row">
				 {{-- @include('includes.breadcrumb')  --}}
			</div>
		</div>

	</div>

	<div class="row pr-4 mt-5">

		<div class="col-lg-3">
			
			@include ('includes.left')

		</div>

		<div class="col-lg-9">
			<div class="row">
				@foreach ($allProducts as $key => $prod)

				@php
					$productSLUG = App\Product::productsSLUG_By_catID($prod->prod_cat_id);
				@endphp
				
				@include ('category.product')
				
				@endforeach
			</div>

			<div class="row">
				<div id="paginateBlock">
					{{ $allProducts->links() }}
				</div>
			</div>
		</div>

	</div>



</div>

@php
// echo '<pre>';
// print_r($navCategory);
// echo '</pre>';
@endphp

@endsection