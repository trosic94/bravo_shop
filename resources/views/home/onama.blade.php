<div id="oNamaBlock">

	<div class="container site-max-width">

		<div class="row">
			<div class="col-md-12">
				<div class="row">
					@foreach($oNama as $o_nama)
					<div class="col-md-6 pr-md-5">
						<h2>
							{{ $o_nama->title }}
						</h2>
						<p>
							{!! $o_nama->body !!}
						</p>
					</div>
					<div class="col-md-6 pl-md-5">
						<img class="img-fluid" src="/storage/{{ $o_nama->image }}" />
					</div>
					@endforeach
				</div>
			</div>
		</div>

	</div>

</div>