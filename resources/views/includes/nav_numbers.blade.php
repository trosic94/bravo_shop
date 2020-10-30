<label class="d-block control-label mar_b_0 text-bold mt-md-4 mb-md-3 mb-xs-2" id="filterTitle">@lang('shop.title_size')</label>

@php
    $listOfAttributes = array();
    $attr_cnt = 0;
@endphp

@foreach ($allAttributesForAll as $ATTRkey => $atribut)
    @if($atribut['attr_id'] != 15)
        @continue
    @endif 
<div class="col-12 col-xs-12 p-0">
    @php
        if (!in_array($atribut['attr_id'], $listOfAttributes)):
            array_push($listOfAttributes, $atribut['attr_id']);
            $attr_cnt++;
        endif;
    @endphp

    @if( $atribut['attr_id'] == 15)
        <div class="proudctSizes2">
            @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)

                    <div class="btn-group p-0 pr-2 pl-2 row" data-toggle="buttons">
                        <input type="checkbox" name="size" id="attr_{{ $ATTRoptions['id'] }}" value="{{ $ATTRoptions['value'] }}" onclick='getVal()' {{ (in_array($ATTRoptions['value'], $searchREQ['size']))? 'checked':'' }} >
                        <label class="btn mr-3 text-center m-1 align-middle {{ (in_array($ATTRoptions['value'], $searchREQ['size']))? 'active':'' }}" for="attr_{{ $ATTRoptions['id'] }}">
                            {{ $ATTRoptions['value'] }}
                        </label>
                    </div>

            @endforeach
        </div>
    @endif 
    
</div>
@endforeach