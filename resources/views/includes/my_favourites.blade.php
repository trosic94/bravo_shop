<div id="myFAV" class="col-auto pl-2 pl-sm-0 pr-1 pr-sm-1">
	<a class="favouritesLNK" href="/favourites">
		<span class="badge {{ ($favouritesCNT > 0)? '':'d-none' }}">{{ $favouritesCNT }}</span>
        <div id="addTo_FAV_h">
			<img class="" src="/images/header/fav_icon.svg">
			{{-- <i class="far fa-heart fa-2x"></i> --}}
			{{-- <i class="fas fa-heart fa-2x {{ ($favouritesCNT > 0)? 'd-block':'d-none' }}"></i> --}}
        </div>
	</a>
</div>

@php
// echo '<pre>';
// print_r($userDATA);
// echo '</pre>';
@endphp
