@if (!$banners_homeWide->isEmpty())
<div id="banner_1">

	<div id="bannerWrap">

        @foreach($banners_homeWide->random(1) as $bKey => $banner)
        <div class="cont">
            <a href="{{ $banner->ban_url }}" target="{{ $banner->ban_target }}" title="{{ $banner->ban_name }}" onclick="clickCount(event,{{ $banner->ban_id }},{{ $banner->ban_position_id }},'{{ $banner->ban_url }}','{{ $banner->ban_target }}')">
                <img src="/storage/banners/{{ $banner->ban_image }}" alt="{{ $banner->ban_name }}" class="img-fluid">
            </a>
            <div class="centered">
                <h1>{{ $banner->ban_name }}</h1>
                <span class="pt-2 pt-sm-5">{{ $banner->ban_description }}</span>
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
