<div class="l2" style="padding-left: {{ $padding }}px;"><i class="fas fa-caret-right"></i> <a href="/shop/{{ $parent_url }}/{{ $child_category->slug }}"> {{ $child_category->name }}</a></div>
@if ($child_category->categories)
    <div class="sub_level">
        @foreach ($child_category->categories as $childCategory)
            @include(
            		'category.child_category',
            		[
            			'child_category' => $childCategory,
            			'parent_url' => $parent_url.'/'.$child_category->slug,
                        'padding' => $padding + 5
            		]
            	)
        @endforeach
    </div>
@endif