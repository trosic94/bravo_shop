<header>
	<div class="container site-max-width">

		<div class="row  ml-0 mr-0">

		<div class="col-xl-12">

			<div class="row pt-4 pb-4">
			    <div class="col-lg-3 text-center text-lg-left mb-3 mb-lg-0">
			    	<a href="/" title="Kupi Poklon"><img src="/storage/{{ setting('site.logo') }}" alt="{{ setting('site.title') }}"></a>
			    </div>
				<div class="col-lg-9 align-items-stretch">

					<div class="row">
                        <div class="col-lg-12 col-xl-6 col-12 small text-muted pl-3 align-self-center" id="contactINFOhead">
                            {!! setting('site.kontakt') !!}
                        </div>
						<div class="col-xl-6 col-12 col-lg-12 pl-0">
							<div class="row justify-content-xl-end justify-content-lg-start mt-lg-2 mt-xl-0 justify-content-center">
							@include ('includes.search_form')
							@include ('includes.my_profile')
							@include ('includes.my_favourites')
                            @include ('includes.my_cart')
                            </div>

						</div>
					</div>
					<div class="row">
						<div class="col-12 justify-content-end d-flex align-items-lg-baseline mt-xl-4 pr-0 align-lg-bottom pt-lg-2">
                            <div class="row d-flex align-items-center mt-xl-3">
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
