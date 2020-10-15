
<div class="col-lg-12">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb rounded-0">

  	@foreach ($slug as $key => $bc)
    	
    	<li class="breadcrumb-item {{ $bc['active'] }} {{ ($bc['active'] != '')? 'font-weight-bold':'' }}"><a href="{{ $bc['slug'] }}">{{ $bc['title'] }}</a></li>
    	
    @endforeach

  </ol>
</nav>

@php
	// echo '<pre>';
	// print_r($slug);
	// echo '</pre>';
@endphp

</div>