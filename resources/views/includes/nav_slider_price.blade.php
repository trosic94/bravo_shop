<div class="lBlockTitle p-0 pb-3 pt-3" role="tab" id="price">
    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapsePRICE" aria-expanded="true" aria-controls="collapsePRICE">
      <h5 id="filterTitle" class="mb-0">
         @lang('shop.title_price') {{--<i class="fas fa-angle-down rotate-icon"></i> --}}
      </h5>
    </a>
  </div>

<div class="d-flex justify-content-left my-2">
    <span class="font-weight-bold text-primary mr-2">{{$minPrice}}</span>
    <div class="w-75">
      <input type="range" class="custom-range" id="customRange11" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{$valPrice}}" onChange="sliderCena()">
    </div>
    <span class="font-weight-bold text-primary ml-2 valueSpan2"></span>
</div>