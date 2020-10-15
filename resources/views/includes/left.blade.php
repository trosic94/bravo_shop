<div class="leftCol pl-3 pr-3">

	<form id="prodSearch" method="POST">

	@include ('includes.nav_category')
	{{-- @include ('includes.nav_manufacturer') --}}
	{{-- @include ('includes.nav_available') --}}
	{{-- @include ('includes.nav_price') --}}

	<input type="hidden" name="CATCurrent" value="{{ $CATCurrent }}">

	</form>

<script type="text/javascript">
$( document ).ready(function() {


});
</script>

</div>