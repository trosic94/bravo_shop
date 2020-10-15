@if (count($navCategory) > 0)

	<div class="lBlock_Category mb-4 mb-lg-0">

		<div class="lBlockTitle" onclick="categoryNAV()">
			<h3>@lang('shop.title_choose_category')</h3>
		</div>


		<div class="catItems">
		@foreach ($navCategory as $category)

		<a href="/shop/{{ $category->slug }}">{{ $category->name }}</a><br>

			<div class="subCat">

		        @foreach ($category->childrenCategories as $childCategory)
		            @include(
		            	'category.child_category',
		            	[
		            		'child_category' => $childCategory,
		            		'parent_url' => $category->slug,
		            		'padding' => 5
		            	]
		            	)
		        @endforeach

		    </div>

		@endforeach
		</div>

	</div>

{{-- 	    @foreach ($navCategory as $category)
	        <div class="l1">
	        	<a href="/shop/{{ $category->slug }}">{{ $category->name }}</a>
	        </div>

	        <div class="l1_sub">
	        @foreach ($category->childrenCategories as $childCategory)
	            @include(
	            	'category.child_category',
	            	[
	            		'child_category' => $childCategory,
	            		'parent_url' => $category->slug
	            	]
	            	)
	        @endforeach
	        </div>
	    @endforeach --}}

@php
// echo '<pre>';
// print_r($navCategory);
// echo '</pre>';
@endphp

@endif