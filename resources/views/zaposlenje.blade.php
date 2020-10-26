@extends ('includes.page')

@section ('content')

	<div class="mainTitle">

		<h1> {!! $page->title !!}</h1>

	</div>

	<div class="pageContent"> 
	
		<div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 pl-0 pr-4">
                            <p>
                                {!! $page->body !!}
                            </p>
                        </div>
                        <div class="col-md-4 offset-sm-2 pt-sm-0 pt-4 pl-0">
                            <h6 class="text-uppercase font-weight-bold">
                                @lang('shop.zaposlenje_konkursi')
                            </h6>
                            @foreach ($konkursi as $k)                              

                            <ul class="list-unstyled pt-4 px-0">
                                <li class="list-item row">
                                    <div class="col-auto pr-1">
                                        @lang('shop.zaposlenje_kon_naslov') 
                                    </div>
                                    <div class="col-auto font-weight-bold pl-0">
                                        {{$k->naslov}}
                                    </div>
                                </li>
                                <li class="list-item row">
                                    <div class="col-auto pr-1">
                                        @lang('shop.zaposlenje_kon_datum') 
                                    </div>
                                    <div class="col-auto font-weight-bold pl-0">
                                        {{$k->vazi_do}}
                                    </div>
                                </li>
                                <li class="list-item row">
                                    <div class="col-auto pr-1">
                                        @lang('shop.zaposlenje_kon_mesto') 
                                    </div>
                                    <div class="col-auto font-weight-bold pl-0">
                                        {{$k->mesto}}
                                    </div>
                                </li>
                            </ul>
                            <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

	</div>

@php
    // echo '<pre>';
    // print_r($page);
    // echo '</pre>';
@endphp

</div>


@endsection