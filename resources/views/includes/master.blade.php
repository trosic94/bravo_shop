<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ setting('site.title') }} {{ (isset($metaTitle))? ' - '.$metaTitle : '' }}</title>
<meta name="description" content="{{ setting('site.description') }} {{ (isset($metaDescription))? ' - '.$metaDescription : '' }}"/>
<meta name="keywords" content="{{ setting('site.keywords') }} {{ (isset($metaKeywords))? ', '.$metaKeywords : '' }}"/>


<link rel="stylesheet" type="text/css" href="{{ URL::to('/css/app.css') }}">

<link rel="icon" href="{{ URL::asset('/favicon.ico') }}" type="image/x-icon">


<script type="text/javascript" src="{{ URL::to('/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/mdb.min.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('/js/shp.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/functions.js') }}"></script>

</head>
<body>

@include('includes.preloader')

@include ('includes.header')

@yield ('pageContent')

@php
	// $sessiosn = Session::all();
	
	// $prev = Session::get('_previous');
	// echo $prev['url'];

	// echo '<pre>';
	// print_r($sessiosn);
	// echo '</pre>';
@endphp

@include ('includes.footer')

{!! setting('site.google_analytics_tracking_code') !!}

</body>
</html>