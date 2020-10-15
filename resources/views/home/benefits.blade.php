<div id="benefitsBlock">

	<h2 class="text-center mb-5">Benefiti</h2>

	<div class="container site-max-width">

		<div class="row ml-0 mr-0">

			@foreach($benefits as $benefit)
			<div id="benefitOne" class="col-lg-4 text-center pl-5 pr-5 mb-5 mb-lg-5 animated slideInUp wow">

				<div class="imgWrap" style="background-image: url('{{ Voyager::image($benefit->image) }}');"></div>

				<h3 class="mt-4 mb-4">{{ $benefit->title }}</h3>

				<div>{{ $benefit->excerpt }}</div>

			</div>
			@endforeach

		</div>

	</div>

</div>