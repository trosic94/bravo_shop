<footer>

	<div class="container site-max-width pb-5">

		<div class="row ml-0 mr-0">

			<div class="col-xl-12">

				<div class="row">

					<div class="col-lg-2 col-md-6 mb-5">

						<h2>@lang('shop.foot_menu_main')</h2>

						<nav>{!! menu('Navigacija') !!}</nav>

					</div>

					<div class="col-lg-2 col-md-6 mb-5">

						<h2>@lang('shop.foot_menu_kupovina')</h2>
						
						<nav>{!! menu('Uputstvo za kupovinu') !!}</nav>

					</div>

					<div class="col-lg-2 col-md-6 mb-5">

						<h2>@lang('shop.title_contact')</h2>

						{!! setting('site.foot_kontakt') !!}

					</div>

					<div class="col-lg-6 col-md-6 mb-5">

                        <h2>@lang('shop.foot_forma')</h2>

						@if (\Session::has('mailSent'))
                            <div style="display: block; font-weight: bold; margin-bottom: 20px;"> {!! \Session::get('mailSent') !!}</div>
                        @endif
                    
                        {!! Form::open(['url' => '/posalji-kontakt','class' => 'formWrap', 'id' => 'btnToSend']) !!}
                    
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="col-12 p-0">
                                    <label class="formLabel">Ime i prezime</label>
                                    {!! Form::text('ime_prezime','',['class' => 'form-control border-0', 'style' => 'border-radius:25px']) !!}
                                    {!! $errors->first('ime_prezime', '<div class="formERR">:message</div>') !!}
                                </div>
                                <div class="col-12 p-0 pt-4">
                                    <label class="formLabel">E-mail adresa</label>
                                    {!! Form::text('email','',['class' => 'form-control border-0', 'style' => 'border-radius:25px']) !!}
                                    {!! $errors->first('email', '<div class="formERR">:message</div>') !!}
                                </div>
                                <div class="col-12 p-0 pt-4">
                                    <label class="formLabel">Broj telefona</label>
                                    {!! Form::text('telefon','',['class' => 'form-control border-0', 'style' => 'border-radius:25px']) !!}
                                    {!! $errors->first('telefon', '<div class="formERR">:message</div>') !!}
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 pt-sm-0 pt-4">
                                <label class="formLabel">Tekst poruke</label>
                                {!! Form::textarea('poruka','',['class' => 'form-control border-0', 'style' => 'border-radius:25px']) !!}
                                {!! $errors->first('poruka', '<div class="formERR">:message</div>') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6"></div>
                            <div class="col-12 col-md-6">
                        {!! Form::hidden('hpASSdDGT3e5345345','') !!}
                            <button id="btnToSend" class="btn btn-primary btn mt-3 rounded-pill">Pošalji poruku</button>
                        {!! Form::close() !!}
                            </div>
                        </div>


					</div>

                </div>
                
                <div class="row pt-0 footer_logo">
                    <div class="col-12 pt-0 mt-n5">
                        <a href="/" title="{{ setting('site.title') }}" ><img src="/storage/{{ setting('site.footer_logo') }}" alt="{{ setting('site.title') }}"></a>
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