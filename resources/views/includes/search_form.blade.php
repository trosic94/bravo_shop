<div class="col-12 col-md-auto  mb-3 mb-md-0">

	<form method="POST" id="siteSearch" action="/search">

		@csrf

		<input type="text" name="PRETRAGA" value="{{ old('PRETRAGA') }}" class="form-control bg-light rounded-pill border-0">
		{{-- <input type="hidden" name="CATCurrent" value="3"> --}}

	</form>

</div>