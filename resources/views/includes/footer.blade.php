<footer>

	<div class="container site-max-width pb-5">

		<div class="row ml-0 mr-0">

			<div class="col-xl-12">

				<div class="row">

					<div class="col-lg-2 col-md-6 mb-5">

						<h2>@lang('shop.title_navigation')</h2>

						<nav>{!! menu('Navigacija') !!}</nav>

						<a href="/" title="{{ setting('site.title') }}" ><img src="/storage/{{ setting('site.footer_logo') }}" alt="{{ setting('site.title') }}"></a>
					</div>

					<div class="col-lg-2 col-md-6 mb-5">

						<h2>@lang('shop.title_purchase_instructions')</h2>
						
						<nav>{!! menu('Uputstvo za kupovinu') !!}</nav>

					</div>

					<div class="col-lg-2 col-md-6 mb-5">

						<h2>@lang('shop.title_contact')</h2>

						{!! setting('site.kontakt') !!}

					</div>

					<div class="col-lg-6 col-md-6 mb-5">
						@if (\Session::has('mailSent'))
                            <div style="display: block; font-weight: bold; margin-bottom: 20px;"> {!! \Session::get('mailSent') !!}</div>
                        @endif
                    
                        {!! Form::open(['url' => '/posalji-kontakt','class' => 'formWrap', 'id' => 'btnToSend']) !!}
                    
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="formLabel">Ime*</label>
                                {!! Form::text('ime','',['class' => 'form-control border-0']) !!}
                                {!! $errors->first('ime', '<div class="formERR">:message</div>') !!}
                            </div>
                            <div class="col-12 col-md-6 pr-sm-0 ">
                                <label class="formLabel">Prezime*</label>
                                {!! Form::text('prezime','',['class' => 'form-control border-0']) !!}
                                {!! $errors->first('prezime', '<div class="formERR">:message</div>') !!}
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="formLabel">E-mail adresa*</label>
                                {!! Form::text('email','',['class' => 'form-control border-0']) !!}
                                {!! $errors->first('email', '<div class="formERR">:message</div>') !!}
                            </div>
                            <div class="col-12 col-md-6 pr-sm-0">
                                <label class="formLabel">Broj telefona</label>
                                {!! Form::text('telefon','',['class' => 'form-control border-0']) !!}
                                {!! $errors->first('telefon', '<div class="formERR">:message</div>') !!}
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-12">
                                <label class="formLabel">Tekst poruke*</label>
                                {!! Form::textarea('poruka','',['class' => 'form-control border-0']) !!}
                                {!! $errors->first('poruka', '<div class="formERR">:message</div>') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                        {!! Form::hidden('hpASSdDGT3e5345345','') !!}
                            <button id="btnToSend" class="btn btn-primary btn-sm mt-3 rounded-pill">Pošalji poruku</button>
                        {!! Form::close() !!}
                            </div>
                        </div>


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