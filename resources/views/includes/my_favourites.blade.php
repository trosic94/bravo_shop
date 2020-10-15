<div id="myFAV" class="col-auto pl-2 pl-sm-2 pr-2 pr-sm-2">
	<a class="favouritesLNK" href="/favourites">
		<span class="badge {{ ($favouritesCNT > 0)? '':'d-none' }}">{{ $favouritesCNT }}</span>
        <div id="addTo_FAV">
			<i class="far fa-heart fa-2x {{ ($favouritesCNT > 0)? 'd-none':'d-block' }}"></i>
			<i class="fas fa-heart fa-2x {{ ($favouritesCNT > 0)? 'd-block':'d-none' }}"></i>
        </div>
	</a>
</div>

@php
// echo '<pre>';
// print_r($userDATA);
// echo '</pre>';
@endphp