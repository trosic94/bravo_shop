<div id="shopBlock">

	<div class="container site-max-width">

        <div class="row">
            <div class="col-md-4 mb-4">
                @foreach ($cat_Zensko as $cat)
                <div class="card" style="border-top: 10px solid {{ $cat->cat_color }}E6; background-color:{{ $cat->cat_color }}4C;" >   
                    <img src="/storage/{{ $cat->cat_image }}" alt="{{ $cat->cat_name }}" class="card-img">
                    <div class="card-img-overlay">   
                      <div class="bgd" style="background-image: linear-gradient(to bottom,{{ $cat->cat_color }}00 50%, {{ $cat->cat_color }}E6 50%);"></div>  
                      <h2 class="card-title">{{ $cat->cat_name }}</h2>
                      <p class="card-text text-white">{{ $cat->cat_description }}</p>
                      <a href="shop/{{ $cat->cat_slug }}" class="btn mt-1 rounded-pill" style="color:{{ $cat->cat_color }}">Pogledaj sve</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-md-4 mb-4">
                @foreach ($cat_Musko as $cat)
                <div class="card" style="border-top: 10px solid {{ $cat->cat_color }}E6; background-color:{{ $cat->cat_color }}4C;" >   
                  <img src="/storage/{{ $cat->cat_image }}" alt="{{ $cat->cat_name }}" class="card-img">
                  <div class="card-img-overlay">   
                    <div class="bgd" style="background-image: linear-gradient(to bottom,{{ $cat->cat_color }}00 50%, {{ $cat->cat_color }}E6 50%);"></div>  
                    <h2 class="card-title">{{ $cat->cat_name }}</h2>
                    <p class="card-text text-white">{{ $cat->cat_description }}</p>
                    <a href="shop/{{ $cat->cat_slug }}" class="btn mt-1 rounded-pill" style="color:{{ $cat->cat_color }}">Pogledaj sve</a>
                  </div>
                </div>
                @endforeach
                
            </div>
            <div class="col-md-4 mb-4">
              @foreach ($cat_Distributer as $cat)
              <div class="card" style="border-top: 10px solid {{ $cat->cat_color }}E6; background-color:{{ $cat->cat_color }}4C;" >   
                <img src="/storage/{{ $cat->cat_image }}" alt="{{ $cat->cat_name }}" class="card-img" style="padding-left: 0 !important; padding-right:0 !important;"> 
                <div class="card-img-overlay">   
                  <div class="bgd" style="background-image: linear-gradient(to bottom,{{ $cat->cat_color }}00 50%, {{ $cat->cat_color }}E6 50%);"></div>  
                  <h2 class="card-title">{{ $cat->cat_name }}</h2>
                  <p class="card-text text-white">{{ $cat->cat_description }}</p>
                  <a href="shop/{{ $cat->cat_slug }}" class="btn mt-1 rounded-pill" style="color:{{ $cat->cat_color }}">Detaljnije</a>
                </div>
              </div>
              @endforeach
            </div>

          </div>

	</div>

@php
	// echo '<pre>';
	// print_r($cat_LEVEL_1);
	// echo '</pre>';
@endphp

</div>
