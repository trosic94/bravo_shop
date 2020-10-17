@if (!$banners_homeWide->isEmpty())
<div id="banner_1">

	<div id="bannerWrap">

        @foreach($banners_homeWide->random(1) as $bKey => $banner)
        <div class="container-fluid p-0">

            <a href="{{ $banner->ban_url }}" target="{{ $banner->ban_target }}" title="{{ $banner->ban_name }}" onclick="clickCount(event,{{ $banner->ban_id }},{{ $banner->ban_position_id }},'{{ $banner->ban_url }}','{{ $banner->ban_target }}')">
                <img src="/storage/banners/{{ $banner->ban_image }}" alt="{{ $banner->ban_name }}">
            </a>
            <div class="carousel-caption align-middle">
                <h1 class="text-bold text-white">{{ $banner->ban_name }}</h1>
                <h5 class="text-white">{{ $banner->ban_description }}</h5>
            </div>
        </div>
		@endforeach

	</div>

@php
// echo '<pre>';
// print_r($banners_homeWide);
// echo '</pre>';
@endphp

</div>
@endif
