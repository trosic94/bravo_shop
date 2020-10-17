<header>
	<div class="container site-max-width">

		<div class="row  ml-0 mr-0">

		<div class="col-xl-12">

			<div class="row pt-4 pb-4">
			    <div class="col-lg-3 text-center text-lg-left mb-3 mb-lg-0">
			    	<a href="/" title="Kupi Poklon"><img src="/storage/{{ setting('site.logo') }}" alt="{{ setting('site.title') }}"></a>
			    </div>
				<div class="col-lg-9  align-items-stretch">

					<div class="row">
                        <div class="col-8 small pb-1 mb-n1 text-muted pl-3 align-top" id="contactINFOhead">
                            {!! setting('site.kontakt') !!}
                        </div>
						<div class="col-4">
							<div class="row justify-content-end">
							{{-- @include ('includes.search_form') --}}
							{{-- @include ('includes.my_profile') --}}
							@include ('includes.my_favourites')
							@include ('includes.my_cart')
							</div>
						</div>

						<div class="col-12 justify-content-end d-flex align-items-baseline mt-4 pr-0 align-bottom">
							<div class="row d-flex align-items-center mt-3">
								<div id="mainMenu" class="col-auto pr-0">
									<div class="hamburger" onclick="mobMenu()"><i class="fas fa-bars"></i></div>
									{{ menu('Navigacija') }}
								</div>
								<div id="snLNKs" class="col-auto">{!! setting('site.sn_icons') !!}</div>
							</div>
						</div>

					</div>

				</div>
			</div>

		</div>

	</div>

</header>

<script type="text/javascript">
$(document).ready(function() {
    new WOW().init();
});
</script>
