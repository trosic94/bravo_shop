
@extends ('includes.master')

@section ('pageContent')

<content>

<div class="mainTitle">
    <h1>{{ $intro }}</h1>
</div>

<div class="contentWrap">


	<p>Poštovani,</p>
	<p>&nbsp;</p>
	<p>Vaša porudžbina je uspešno kompletirana.</p>
	<p>Sve informacije o porudžbini možete pronaći na vašem <a href="/profil">profilu</a>.</p>
	<p>&nbsp;</p>
	<p>Pozdrav</p>

</div>


</content>

@php
// //echo $ulogovan->discount;
//     echo '<pre>';
//     print_r($ulogovan);
//     echo '</pre>';
@endphp

@endsection