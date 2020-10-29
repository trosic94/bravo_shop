					{{-- <div class="row mt-1"> --}}

						{{-- <div class="col-xl-12 p-0"> --}}
							<div class="row">
                                @php
                                    $listOfAttributes = array();
                                    $attr_cnt = 0;
                                @endphp
                                {{-- <div class="form-row"> --}}
                                @foreach ($allAttributesForAll as $ATTRkey => $atribut)
                                     @if($atribut['attr_id'] != 15 && $atribut['attr_id'] != 16)
                                        @continue
                                    @endif 
                                <div class="col-md-6 col-xs-12 p-0">
                                    @php
                                        if (!in_array($atribut['attr_id'], $listOfAttributes)):
                                            array_push($listOfAttributes, $atribut['attr_id']);
                                            $attr_cnt++;
                                        endif;
                                    @endphp
    
    
                                    
                                       @if( $atribut['attr_id'] == 15)
                                        <label class="d-block control-label mar_b_0 text-bold mb-md-4 mb-xs-2">@lang('shop.title_choose_size'):</label>
                                            <div class="proudctSizes">
                                                <div class="btn-group p-0" data-toggle="buttons">
                                                        @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
                                                        <label class="btn mr-3 text-center align-middle">
                                                                    <input type="radio" name="attr_{{ $atribut['attr_id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}" id="attr_{{ $ATTRoptions['id'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}
                                                                </label>
                                                        @endforeach
    
    
                                                </div>
                                            </div>
                                        @endif 
                                        {{-- @if( $atribut['attr_id'] == 16 )
                                            
                                            <label class="col-12 control-label mar_b_0 text-bold p-0  mb-md-4 mb-xs-2">@lang('shop.title_choose_color'):</label>
    
                                            <div class="proudctSizes">
                                                <div class="btn-group p-0" data-toggle="buttons">
                                                    @if (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod))
                                                            @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
                                                                @if (in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))
                                                                <label class="btn mr-3 text-center" style="background-color: {{ $ATTRoptions['value'] }}">
                                                                    <input type="radio" name="attr_{{ $atribut['attr_id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}" id="attr_{{ $ATTRoptions['id'] }}"></label>
                                                                @endif
                                                            @endforeach
                                                    @else
                                                        @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
                                                        <label class="btn mr-3 text-center" style="background-color: {{ $ATTRoptions['value'] }}">
                                                                    <input type="radio" name="attr_{{ $atribut['attr_id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}" id="attr_{{ $ATTRoptions['id'] }}"></label>
                                                        @endforeach
    
                                                    @endif
                                                </div>
                                            </div>
                                        @endif --}}
                                    
                                </div>
                                @endforeach
                                {{-- </div> --}}
    
                                <input type="hidden" name="attr_all" value="{{ json_encode($listOfAttributes) }}">
                                <input type="hidden" name="attr_cnt" value="{{ $attr_cnt }}">
                            </div>
                            {{-- </div> --}}
    
                        {{-- </div> --}}
    
    <script type="text/javascript">
        $('document').ready(function () {
            $('.mdb-select').materialSelect();
        });
    </script>