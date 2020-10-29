
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
                <div class="proudctSizes">
                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
                    @if($ATTRoptions['value'] < 41)  

                    <div class="btn-group p-0 pr-2 pl-2 row" data-toggle="buttons">
                        <label class="btn mr-3 text-center align-middle">
                            <input type="radio" name="attr_{{ $atribut['attr_id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}" id="attr_{{ $ATTRoptions['id'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}              
                        </label> 
                    </div>

                    @else

                    <div class="btn-group p-0 pr-2 pl-2 row" data-toggle="buttons">
                        <label class="btn mr-3 text-center align-middle">
                            <input type="radio" name="attr_{{ $atribut['attr_id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}" id="attr_{{ $ATTRoptions['id'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}              
                        </label> 
                    </div>

                    @endif
            @endforeach
                </div>
            @endif 
            
        </div>
        @endforeach

        {{-- <input type="hidden" name="attr_all" value="{{ json_encode($listOfAttributes) }}">
        <input type="hidden" name="attr_cnt" value="{{ $attr_cnt }}"> --}}
 
    
    <script type="text/javascript">
        $('document').ready(function () {
            $('.mdb-select').materialSelect();
        });
    </script>