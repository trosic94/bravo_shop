@extends ('includes.home')

@section ('content')

@include ('home.shop')
@include ('home.benefits')

<div id="galleryBlock">

	<h2>@lang('shop.title_gallery')</h2>

	<div id="galleryIMGs" class="container site-max-width">

		<div class="row ml-0 mr-0">

			<div class="container-fluid">

			  <div class="grid">
			    <div class="grid-sizer"></div>

			    @foreach ($gallery->GalleryItems as $img)
				<div class="grid-item">
					<img src="/storage/gallery/{{ $img->image }}" alt="{{ $img->title }}" />
				</div>
			    @endforeach

			  </div>
			</div>

			<!-- MDBootstrap Masonry  -->
			<script type="text/javascript" src="js/addons/masonry.pkgd.min.js"></script>
			<script type="text/javascript" src="js/addons/imagesloaded.pkgd.min.js"></script>


		</div>

	</div>

</div>


<script type="text/javascript">
$( document ).ready(function() {

	new WOW().init();

	// init Masonry
	var $grid = $('.grid').masonry({
	  itemSelector: '.grid-item',
	  percentPosition: true,
	  columnWidth: '.grid-sizer'
	});

	// layout Masonry after each image loads
	$grid.imagesLoaded().progress( function() {
	  $grid.masonry();
	});


	$('.mdb-select').materialSelect();
});
</script>

@endsection