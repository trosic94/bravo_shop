
@php
    $sel = '';

    if (in_array($child_category->id, $categoriesForAttribute)):
        $sel = 'selected';
    else:
        if ($dataTypeContent->category_id == $child_category->id):
            $sel = 'selected';
        endif;
    endif;
@endphp

<option value="{{ $child_category->id }}" {{ ($child_category->published == '0')? 'disabled':'' }} {{ $sel }}>{{ $before }} {{ $child_category->name }}</option>

@if ($child_category->categories)
        @foreach ($child_category->categories as $childCategory)
            @include(
            		'vendor.voyager.categories.child_category',
            		[
            			'child_category' => $childCategory,
            			'parent_url' => $parent_url.'/'.$child_category->slug,
                        'before' => $before.'-',
                        'selected_cat' => $categoriesForAttribute
            		]
            	)
        @endforeach
@endif