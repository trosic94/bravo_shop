<label class="d-block control-label mar_b_0 text-bold mt-md-4 mb-md-3 mb-xs-2" id="filterTitle">@lang('shop.title_color')</label>
@foreach ($allAttributesForAll as $ATTRkey => $atribut)
    @if($atribut['attr_id'] != 16)
        @continue
    @endif 
    <div class="col-12 col-xs-12 p-0">
        @if( $atribut['attr_id'] == 16 )
            <div class="proudctSizes mb-md-5" id="productColors">
                <div class="btn-group p-0 pl-2" data-toggle="buttons">
                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
                        <input type="checkbox" name="color" value="{{ $ATTRoptions['value'] }}" id="attr_{{ $ATTRoptions['id'] }}" onclick='getVal()' {{ (in_array($ATTRoptions['value'], $searchREQ['color']))? 'checked':'' }} >
                        <label class="btn mr-3 text-center  {{ (in_array($ATTRoptions['value'], $searchREQ['color']))? 'active':'' }}" style="background-color: {{ $ATTRoptions['value'] }}" for="attr_{{ $ATTRoptions['id'] }}"></label>
                    @endforeach
                </div>
            </div>
        @endif  
    </div>
@endforeach