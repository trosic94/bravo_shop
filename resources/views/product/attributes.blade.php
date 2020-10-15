					<div class="row mt-5">

						<div class="col-xl-12">

							<h3>@lang('shop.title_available_options'):</h3>

                            @php
                                $listOfAttributes = array();
                                $attr_cnt = 0;
                            @endphp

                            @foreach ($allAttributesForProduct as $ATTRkey => $atribut)

                            <div class="form-group">
                                <label class="control-label mar_b_0 text-bold">{{ $atribut['attr_name'] }}:</label>
                                <div class="small mar_b_5">{{ $atribut['attr_description'] }} {{ $atribut['attr_type_id'] }}</div>

                                @php
                                    if (!in_array($atribut['attr_id'], $listOfAttributes)):
                                        array_push($listOfAttributes, $atribut['attr_id']);
                                        $attr_cnt++;
                                    endif;
                                @endphp


                                @if ($atribut['attr_type_id'] == 1)
                                    {{-- Ako je TEXT --}}


                                @elseif ($atribut['attr_type_id'] == 2)
                                    {{-- Ako je SELECT --}}

                                    <select class="mdb-select md-form col-xl-6 pl-0 pr-0 mt-2 mb-0" name="attr_{{ $atribut['attr_id'] }}">
                                        <option value="" disabled selected>@lang('shop.title_choose')</option>

                                        @if (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod))

		                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
		                                    	@if (in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))
		                                        <option value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</option>
		                                        @endif
		                                    @endforeach

                                        @else

		                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
		                                        <option value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</option>
		                                    @endforeach

                                        @endif


                                    </select>

                                @elseif ($atribut['attr_type_id'] == 3)
                                    {{-- Ako je MULTISELECT --}}

                                    <select class="mdb-select md-form col-xl-6 pl-0 pr-0 mt-2 mb-0" name="attr_{{ $atribut['attr_id'] }}[]" data-label-select-all="@lang('shop.title_select_all')" data-label-options-selected="@lang('shop.title_selected_options')" multiple="">
                                        <option value="" disabled selected>@lang('shop.title_choose')</option>

                                        @if (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod))

		                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
		                                    	@if (in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))
		                                        	<option value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</option>
		                                        @endif
		                                    @endforeach

                                        @else

		                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
		                                        <option value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</option>
		                                    @endforeach

                                        @endif

                                    </select>

                                @elseif ($atribut['attr_type_id'] == 4)
                                    {{-- Ako je CHECKBOX --}}

                                    @if (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod))

	                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
		                                    @if (in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))
												<div class="form-check pl-0 pr-0 mt-2 mb-0 mt-1">
													<input type="checkbox" name="attr_{{ $atribut['attr_id'] }}" class="form-check-input" id="attr_{{ $ATTRoptions['id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">
													<label class="form-check-label" for="attr_{{ $ATTRoptions['id'] }}">{{ $ATTRoptions['label'] }} {{ $atribut['attr_unit'] }}</label>
												</div>
											@endif
	                                    @endforeach

                                    @else

	                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
											<div class="form-check pl-0 pr-0 mt-2 mb-0 mt-1">
												<input type="checkbox" name="attr_{{ $atribut['attr_id'] }}" class="form-check-input" id="attr_{{ $ATTRoptions['id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">
												<label class="form-check-label" for="attr_{{ $ATTRoptions['id'] }}">{{ $ATTRoptions['label'] }} {{ $atribut['attr_unit'] }}</label>
											</div>
										@endforeach

									@endif

                                @elseif ($atribut['attr_type_id'] == 5)
                                    {{-- Ako je RADIO BUTTON --}}

                                    @if (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod))

	                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
		                                    @if (in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))
											<div class="form-check pl-0 pr-0 mt-2 mb-0" mt-1>
												<input type="radio" name="attr_{{ $atribut['attr_id'] }}" class="form-check-input" id="attr_{{ $ATTRoptions['id'] }}" name="materialExampleRadios" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">
												<label class="form-check-label" for="attr_{{ $ATTRoptions['id'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</label>
											</div>
											@endif
	                                    @endforeach

                                    @else

	                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
										<div class="form-check pl-0 pr-0 mt-2 mb-0" mt-1>
											<input type="radio" name="attr_{{ $atribut['attr_id'] }}" class="form-check-input" id="attr_{{ $ATTRoptions['id'] }}" name="materialExampleRadios" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">
											<label class="form-check-label" for="attr_{{ $ATTRoptions['id'] }}">{{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</label>
										</div>
	                                    @endforeach

                                    @endif

                                @elseif ($atribut['attr_type_id'] == 7)
                                    {{-- Ako je COLOR --}}

                                    @if (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod))

	                                    @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
		                                    @if (in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))
											<div class="form-check pl-0 pr-0 mt-2 mb-0 mt-1">
												<input type="checkbox" name="attr_{{ $atribut['attr_id'] }}" class="form-check-input" id="attr_{{ $ATTRoptions['id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">
												<label class="form-check-label" for="attr_{{ $ATTRoptions['id'] }}"><div class="btn mar_l_10 mar_r_10" style="background-color: {{ $ATTRoptions['value'] }}"></div>  {{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</label>
											</div>
											@endif
										@endforeach

									@else

										@foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
										<div class="form-check pl-0 pr-0 mt-2 mb-0 mt-1">
											<input type="checkbox" name="attr_{{ $atribut['attr_id'] }}" class="form-check-input" id="attr_{{ $ATTRoptions['id'] }}" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}">
											<label class="form-check-label" for="attr_{{ $ATTRoptions['id'] }}"><div class="btn mar_l_10 mar_r_10" style="background-color: {{ $ATTRoptions['value'] }}"></div>  {{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}</label>
										</div>
										@endforeach

									@endif

                                @else
                                    {{-- Ako je OSTALO --}}

                                @endif

                            </div>

                            <hr>

                            @endforeach

                            <input type="hidden" name="attr_all" value="{{ json_encode($listOfAttributes) }}">
                            <input type="hidden" name="attr_cnt" value="{{ $attr_cnt }}">

						</div>

					</div>

<script type="text/javascript">
	$('document').ready(function () {
		$('.mdb-select').materialSelect();
	});
</script>