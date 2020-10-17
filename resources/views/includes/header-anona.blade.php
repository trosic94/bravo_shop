<header>

	<div class="container-fluid pb-2 pt-1">
		<div class="row px-0 mx-0">
			<div class="col col-lg-0 m-0 p-0"></div>

			<div class="col-xl-8 col-lg-12 minWidth p-0">

				<div class="col-12 pl-0 pr-0">
					<div class="row">
						<div id="contactINFOhead" class="col-10 small pb-1 mb-n1 text-muted pl-3">
							{!! setting('site.kontakt') !!}
						</div>
						<div id="contactINFOhead" class="col-2 small pt-2 pb-1 pr-3">
							<div class="row float-right pr-3">
									<a href="{!! setting('site.facebook') !!}" target="_blank"><i class="fab fa-facebook-f text-primary pr-2 {{ (setting('site.facebook') == '')? 'd-none':'d-block' }}"></i></a>
									<a href="{!! setting('site.instagram') !!}" target="_blank"><i class="fab fa-instagram text-primary pl-2 {{ (setting('site.instagram') == '')? 'd-none':'d-block' }}"></i></a>
							</div>
						</div>
						{{-- <div id="langHead" class="col-6 col-md-2 small text-left pb-md-0 pb-2 pr-4 ">
						
							<select class="mdb-select">
								<option value="sr" data-icon="https://cdn.countryflags.com/thumbs/serbia/flag-round-250.png" class="rounded-circle">
								  SRB</option>
								<option value="en" data-icon="https://cdn.countryflags.com/thumbs/united-states-of-america/flag-round-250.png" class="rounded-circle">
								  ENG</option>
							  </select>
						</div>	 --}}
					</div>
					<div class="border-bottom mb-3 p-0"></div>
				</div>
				
				<div class="row">
					<div class="col-lg-2 text-center text-lg-left">
						<a href="/" title="{{ setting('site.title') }}"><img src="/storage/{{ setting('site.logo') }}" alt="{{ setting('site.title') }}" class="img-fluid pl-2 pl-xl-0"></a>
					</div>
					<div class="col-lg-10">
						<div class="row justify-content-center justify-content-lg-end pr-3">
							@include ('includes.search_form')
							@include ('includes.my_favourites')
							@include ('includes.my_cart')
							@include ('includes.my_profile')
							{!! menu('Glavni Meni', 'includes.nav_glavni') !!}
						</div>
						{{-- <div class="row justify-content-end pr-3">
							{!! menu('Glavni Meni', 'includes.nav_glavni') !!}
						</div> --}}
					</div>
				</div>

			</div>

		<div class="col col-lg-0 m-0 p-0"></div>

	</div>

</header>



<script type="text/javascript">
$(document).ready(function() {
	new WOW().init();
	$('.mdb-select').materialSelect();
});
</script>