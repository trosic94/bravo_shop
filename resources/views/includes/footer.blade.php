<footer>

	<div class="container site-max-width pt-5 pb-5">

		<div class="row ml-0 mr-0">

			<div class="col-xl-12">

				<div class="row">

					<div class="col-lg-3 col-md-6 mb-5">

						<h2>@lang('shop.title_navigation')</h2>

						<nav>{!! menu('Navigacija') !!}</nav>

						<a href="/" title="Kupi Poklon" ><img src="/storage/{{ setting('site.footer_logo') }}" alt="{{ setting('site.title') }}"></a>
					</div>

					<div class="col-lg-3 col-md-6 mb-5">

						<h2>@lang('shop.profile_title')</h2>

						<nav>{!! menu('Moj profil') !!}</nav>

					</div>

					<div class="col-lg-3 col-md-6 mb-5">

						<h2>@lang('shop.title_purchase_instructions')</h2>
						
						<nav>{!! menu('Uputstvo za kupovinu') !!}</nav>

					</div>

					<div class="col-lg-3 col-md-6 mb-5">
						
						<h2>@lang('shop.title_contact')</h2>

						{!! setting('site.kontakt') !!}
						{!! setting('site.sn_icons') !!}

					</div>

				</div>

			</div>

		</div>

	</div>


	<div id="copyWrap" class="pt-3 pb-3 small text-center">
		{{ setting('site.footer_copy_1') }} <span class="vLine">|</span> <span class="OSM">Design by <a href="https://www.onestopmarketing.rs" target="_blank" title="One Stop Marketing"><img src="{{ URL::asset('/images/footer/osm-logo.png') }}" alt="One Stop Marketing"></a></span>
	</div>

</footer>

@include ('includes.cookie')

@php
// echo '<pre>';
// print_r($catOznake);
// echo '</pre>';
@endphp