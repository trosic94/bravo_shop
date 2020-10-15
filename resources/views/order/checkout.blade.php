
@extends ('includes.master')

@section ('pageContent')

<content>

<div class="mainTitle">
    <h1>Poručivanje</h1>
</div>

<div class="contentWrap">

    <div class="checkOutCart">
    	<ul class="chkROWth">
			<li class="chkTH col1 textCenter">RB</li>
			<li class="chkTH col2 textCenter">Slika</li>
			<li class="chkTH col3" id="lrgSCRProd">Proizvod</li>
			<li class="chkTH col4 textCenter" id="lrgSCR">Šifra</li>
			<li class="chkTH col5 textCenter" id="lrgSCR">Količina</li>
			<li class="chkTH col6 textRight" id="lrgSCR">Cena ({{ setting('site.valuta') }})</li>
		</ul>
		@php
			$ukupno = 0;
		@endphp
		@for ($p = 0; $p<count($myCart); $p++)
		<ul class="chkROWtd" id="lrgSCR">
			<li class="chkTD col1 textCenter"><strong>{{ $p+1 }}</strong></li>
			<li class="chkTD col2 textCenter"><img src="/storage/{{ $myCart[$p]['product']['image'] }}" alt="{{ $myCart[$p]['product']['title'] }}"></li>
			<li class="chkTD col3">
				<ul class="productDetails">
					<li><label>Oznaka: </label>{{ $myCart[$p]['product']['title'] }}</li>
					@if (array_key_exists('material',$myCart[$p]))
						<li><label>Materijal: </label>{{ $myCart[$p]['material']['name'] }}</li>
					@endif
					@if (array_key_exists('dimensions',$myCart[$p]))
						<li><label>Dimanzija: </label>{{ $myCart[$p]['dimensions']['value'] }}</li>
					@endif
				</ul>
			</li>
			<li class="chkTD col4 textCenter">{{ $myCart[$p]['product']['sku'] }}</li>
			<li class="chkTD col5 textCenter">{{ $myCart[$p]['order']['kolicina'] }}</li>
			<li class="chkTD col6 textRight">{{ number_format($myCart[$p]['order']['total'],2,".","") }}</li>
		</ul>

		<ul id="smlSCR">
			<li class="col1 textCenter"><strong>{{ $p+1 }}</strong></li>
			<li class="col2 textCenter"><img src="/storage/{{ $myCart[$p]['product']['image'] }}" alt="{{ $myCart[$p]['product']['title'] }}"></li>
			<li class="col3">
				<ul class="productDetails">
					<li><label>Oznaka: </label>{{ $myCart[$p]['product']['title'] }}</li>
					@if (array_key_exists('material',$myCart[$p]))
					<li><label>Materijal: </label>{{ $myCart[$p]['material']['name'] }}</li>
					@endif
					@if (array_key_exists('dimensions',$myCart[$p]))
					<li><label>Dimanzija: </label>{{ $myCart[$p]['dimensions']['value'] }}</li>
					@endif
				</ul>
			</li>
			<li class="chkTD col4 textCenter"><span>Šifra:</span> {{ $myCart[$p]['product']['sku'] }}</li>
			<li class="chkTD col5 textCenter"><span>Količina:</span> {{ $myCart[$p]['order']['kolicina'] }}</li>
			<li class="chkTD col6 textRight"><span>Cena:</span> {{ number_format($myCart[$p]['order']['total'],2,".","") }} {{ setting('site.valuta') }}</li>
		</ul>
			@php
				$ukupno = $ukupno + $myCart[$p]['order']['total'];
			@endphp
		@endfor
		<ul class="chkROWRabat">
			<li class="c_col1"></li>
			<li class="chkRabat c_col2 textRight"><strong>Popust: </strong></li>
			<li class="chkRabat c_col3 textRight">{{ $ulogovan->discount }}%</li>
		</ul>
		
		@php
			$rabat = ($ukupno/100)*$ulogovan->discount;
			$ukupno = $ukupno - $rabat;
		@endphp
		<ul class="chkROWUkupno">
			<li class="c_col1"></li>
			<li class="chkUkupno c_col2 textRight"><strong>U K U P N O: </strong></li>
			<li class="chkUkupno c_col3 textRight"><strong>{{ number_format($ukupno,2,".","") }}</strong></li>
		</ul>

		<ul class="chkROWShipping">
			<li class="c_col1"></li>
			<li class="chkShippingtextRight" style="width: 40%; line-height: normal; font-size: 80%; padding: 10px 0;"><strong>Isporuka:</strong> Prema važećem cenovniku Royal Express kurirske službe.</li>
			{{-- <li class="chkShipping c_col2 textRight">Poštarina: </li> --}}
			{{-- <li class="chkShipping c_col3 textRight">{{ number_format(setting('site.postarina'),2,".","") }}</li> --}}
		</ul>

		@php
			// $total = $ukupno + setting('site.postarina');
		$total = $ukupno;
		@endphp
		<ul class="chkROWTotal">
			<li class="c_col1"></li>
			<li class="chkTotal c_col2 textRight">T O T A L: </li>
			<li class="chkTotal c_col3 textRight">{{ number_format($total,2,".","") }}</li>
		</ul>
		<div class="PDVnote textRight">*U cenu je uračunat PDV</div>
	</div>

	{!! Form::open(['url' => '/confirm-order','id' => 'confirmOrder']) !!}

	<div class="col50">

		<div class="kupacInfo">
			<h2>Kupac</h2>

			<table class="kupacData" cellpadding="0" cellspacing="0">
				<tr>
					<td><label>Ime i prezime: </label></td>
					<td>{{ $ulogovan->name }}</td>
				</tr>
				<tr>
					<td><label>Firma: </label></td>
					<td>{{ $ulogovan->comapny_name }}</td>
				</tr>
				<tr>
					<td><label>Adresa: </label></td>
					<td>{{ $ulogovan->company_address }}</td>
				</tr>
				<tr>
					<td><label>E-mail: </label></td>
					<td>{{ $ulogovan->company_email }}</td>
				</tr>
				<tr>
					<td><label>Telefon: </label></td>
					<td>{{ $ulogovan->company_phone }}</td>
				</tr>
				<tr>
					<td><label>PIB: </label></td>
					<td>{{ $ulogovan->company_vat }}</td>
				</tr>
			</table>

		</div>

	</div>
	
	<div class="col50">

		<div class="paymentInfo">
			<h2>Način plaćanja</h2>
		</div>

		<table cellpadding="0" cellspacing="0">
		@foreach($paymentMethod as $payment)
			<tr>
				<td valign="top"><br><input type="radio" name="payment_method" value="{{ $payment->id }}"></td>
				<td><br>
					<div class="paymentRow">{{ $payment->title }}</div>
					<div class="paymentRowDescription">{!! $payment->description !!}</div>					
				</td>
			</tr>
		@endforeach
		</table>
		<div id="paymentERR"></div>

	</div>


	<div class="TOC">
		<input type="checkbox" name="toc" value="DA"> Slažem se sa <a href="/pravila-i-uslovi-koriscenja">Pravilima i uslovima</a> korišćenja!
		<div class="paymentNotice" style="display: block; margin: 10px 5px 0 5px; font-size: 80%; font-style: italic;">Sva plaćanja biće izvršena u lokalnoj valuti Republike Srbije – dinar (RSD). Za informativni prikaz cena u drugim valutama koristi se srednji kurs Narodne Banke Srbije. Iznos za koji će biti zadužena Vaša platna kartica biće izražen u Vašoj lokalnoj valuti kroz konverziju u istu po kursu koji koriste kartičarske organizacije, a koji nama u trenutku transakcije ne može biti poznat. Kao rezultat ove konverzije postoji mogućnost neznatne razlike od originalne cene navedene na našem sajtu.<br>Hvala Vam na razumevanju.</div>
	</div>
	<div id="tocERR"></div>


	
	{!! Form::hidden('order',json_encode($myCart)) !!}
	{{ Form::submit('Potvrdi porudžbinu', ['id' => 'btnConfirm']) }}
	{!! Form::close() !!}	

</div>


<script type="text/javascript">
$(document).ready(function() {

	$('input#btnConfirm').on('click', function(e){
		e.preventDefault();

		var paymentMethod = $("input[name=payment_method]:checked").val();
		var toc = $("input[name=toc]:checked").val();

    	if (!paymentMethod || 0 === paymentMethod.length) {
			e.preventDefault();
			$('div#paymentERR').html('<div class="ERRformat">Morate odabrati način plaćanja!</div>');
		} else {
			$('div#paymentERR').html('');
		}

    	if (!toc || 0 === toc.length) {
			e.preventDefault();
			$('div#tocERR').html('<div class="ERRformat">Neophodno je da prihvatite pravila i uslove korišćenja!</div>');
		} else {
			$('div#tocERR').html('');
		}		

		if ((!paymentMethod || 0 === paymentMethod.length) || (!toc || 0 === toc.length)) {
			e.preventDefault();
		} else {
			document.getElementById("confirmOrder").submit();
		}

	});

});
</script>

</content>

@php
//echo $ulogovan->discount;
    // echo '<pre>';
    // print_r($myCart);
    // print_r($ulogovan);
    // echo '</pre>';
@endphp

@endsection