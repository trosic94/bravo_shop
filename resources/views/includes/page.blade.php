@extends ('includes.master')

@section ('pageContent')

<content>

	<div class="container site-max-width">

		<div class="row ml-0 mr-0">

			<div class="col-xl-12">

				@yield('content')

			</div>

		</div>

	</div>

</div>

</content>

<script type="text/javascript">
$( document ).ready(function() {



});
</script>

@endsection