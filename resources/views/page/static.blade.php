@extends ('includes.page')

@section ('content')

	<div class="mainTitle">

		<h1>{{ $page->title }}</h1>

	</div>

	<div class="pageContent"> 
	
		{!! $page->body !!}

	</div>

@php
    // echo '<pre>';
    // print_r($page);
    // echo '</pre>';
@endphp

</div>


@endsection