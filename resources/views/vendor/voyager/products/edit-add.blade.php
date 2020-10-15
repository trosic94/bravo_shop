@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')

    <div class="page-content edit-add container-fluid">
        <div class="row">
        <form method="POST" action="/SDFSDf345345--DFgghjtyut-6/products/{{ $edit ? "edit" : "insert" }}" enctype="multipart/form-data">
        
            <!-- CSRF TOKEN -->
            {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{ $dataTypeContent->id }}">


            <!-- LEFT start --------------------------------------------------->
            <div class="col-md-6">
                <div class="panel panel-bordered">
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <h3 class="panel-title">@lang('shop_admin.title_product_name')</h3>
                            <input  required  type="text" class="form-control" name="title" placeholder="Title" value="{{ $dataTypeContent->title }}">
                        </div>

                        <!-- ### EXCERPT ### -->
                        <div class="form-group">
                            <h3 class="panel-title">@lang('shop_admin.title_product_intro')</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                            <textarea name="excerpt" class="form-control richTextBox" id="richtextexcerpt">{{ $dataTypeContent->excerpt ?? '' }}</textarea>
                        </div>

                        <!-- ### CONTENT ### -->
                        <div class="form-group">
                            <h3 class="panel-title">@lang('shop_admin.title_product_description')</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                                @php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                    $row = $dataTypeRows->where('field', 'body')->first();
                                @endphp
                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                        </div><!-- .panel -->

                        <!-- ### SPECIFICATION ### -->
                        <div class="form-group">
                            <h3 class="panel-title">@lang('shop_admin.title_specification')</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                                @php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                    $row = $dataTypeRows->where('field', 'specification')->first();
                                @endphp
                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                        </div><!-- .panel -->

                    </div><!-- panel-body -->

                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                    </div>
                </div> <!-- panel panel-border -->
            </div>
            <!-- LEFT end --------------------------------------------------->

            <!-- RIGHT start --------------------------------------------------->
            <div class="col-md-6">

                <div class="row">

                    <div class="col-md-6">

                        <!-- ### DETAILS ### -->
                        <div class="panel panel panel-bordered panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-clipboard"></i> @lang('shop_admin.title_product_details')</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('shop_admin.title_product_price')</label>
                                    <input type="text" class="form-control" name="product_price" required step="any" placeholder="@lang('shop_admin.title_product_price')" value="{{ ($dataTypeContent->product_price == 0)? '': $dataTypeContent->product_price }}">
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('shop_admin.title_product_discount')</label>
                                    <input type="text" class="form-control" name="product_discount" step="any" placeholder="@lang('shop_admin.title_product_discount')" value="{{ ($dataTypeContent->product_discount == null)? '': $dataTypeContent->product_discount }}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('shop_admin.title_product_price_with_discount')</label>
                                    <input type="text" class="form-control" name="product_price_with_discount" step="any" placeholder="@lang('shop_admin.title_product_price_with_discount')" value="{{ ($dataTypeContent->product_price_with_discount == null)? '': $dataTypeContent->product_price_with_discount }}">
                                </div>

                                <hr>
                                
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('shop_admin.title_sku')</label>
                                    <input type="text" class="form-control" name="sku" required step="any" placeholder="SKU" value="{{ $dataTypeContent->sku }}">
                                </div>
                                <div class="form-group">
                                    <label for="category_id">@lang('shop_admin.title_category')</label>

                                    <select class="form-control select2" name="category_id" required onchange="findeAttributesForCat()">

                                        @foreach ($productCategories_SEL as $category)
                                            <option value="{{ $category->id }}" {{ ($category['published'] == '0')? 'disabled':'' }} {{ ($edit && $dataTypeContent->category_id == $category->id)? 'selected':'' }}>{{ $category->name }}</option>
                                            @foreach ($category->childrenCategories as $childCategory)
                                                @include(
                                                    'vendor.voyager.categories.child_category',
                                                    [
                                                        'child_category' => $childCategory,
                                                        'parent_url' => $category->slug,
                                                        'before' => '-',
                                                        'selected_cat' => $categoriesForAttribute
                                                    ]
                                                    )
                                            @endforeach
                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="manufacturer_id">@lang('shop_admin.title_manufacturer')</label>

                                    <select class="form-control select2" name="manufacturer_id" required>

                                            <option value="">@lang('shop_admin.title_choose')</option>

                                        @foreach($allManufacturers as $mnf)

                                            <option value="{{ $mnf->id }}" {{ ($edit && $dataTypeContent->manufacturer_id == $mnf->id)? 'selected':'' }}>{{ $mnf->name }}</option>

                                        @endforeach

                                    </select>


                                </div>

                                <div class="form-group col-md-6">
                                    <label class="control-label" for="name">@lang('shop_admin.title_status')</label>
                                    <br>
                                    <input type="checkbox" name="status" class="toggleswitch" {{ ($dataTypeContent->status == 1) ? 'checked' : '' }}>
                                </div>

                                <div class="form-group  col-md-6">
                                    <label class="control-label" for="name">@lang('shop_admin.title_on_stock')</label>
                                    <br>
                                    <input type="checkbox" name="on_stock" class="toggleswitch" {{ ($dataTypeContent->on_stock == 1) ? 'checked' : '' }}>
                                </div>

                                <div class="form-group  col-md-6">
                                    <label class="control-label" for="name">@lang('shop_admin.title_featured')</label>
                                    <br>
                                    <input type="checkbox" name="featured" class="toggleswitch" {{ ($dataTypeContent->featured == 1) ? 'checked' : '' }}>
                                </div>

                                @if ($edit)
                                <div class="form-group  col-md-6">
                                    <label class="control-label" for="name">@lang('shop_admin.title_update_on_import')</label>
                                    <br>
                                    <input type="checkbox" name="update_on_import" class="toggleswitch" {{ ($dataTypeContent->update_on_import == 1) ? 'checked' : '' }}>
                                </div>
                                @endif

                            </div>
                        </div>

                        <!-- ### ATTRIBUTES ### -->
                        <div class="panel panel-bordered panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_attributes')</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">

                            @if ($edit)

                                    @php
                                        $listOfAttributes = array();
                                    @endphp

                                    @foreach ($allAttributesForProduct as $ATTRkey => $atribut)

                                    <div class="form-group">
                                        <label class="control-label mar_b_0 text-bold">{{ $atribut['attr_name'] }}</label>
                                        <div class="small mar_b_5">{{ $atribut['attr_description'] }}</div>

                                        @php
                                            if (!in_array($atribut['attr_id'], $listOfAttributes)):
                                                array_push($listOfAttributes, $atribut['attr_id']);
                                            endif;
                                        @endphp

                                        @if ($atribut['attr_type_id'] != 7)
                                            {{-- Ako je CHECKBOX --}}

                                            @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
                                            <input type="checkbox" name="attr_{{ $atribut['attr_id'] }}[]" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}" {{ (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod) && in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))? 'checked':'' }}> {{ $ATTRoptions['label'] }} {{ $atribut['attr_unit'] }}<br>
                                            @endforeach
                                        @else
                                            {{-- Ako je COLOR --}}

                                            @foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions)
                                            <input type="checkbox" name="attr_{{ $atribut['attr_id'] }}[]" value="{{ $ATTRoptions['id'] }}|{{ $ATTRoptions['value'] }}" {{ (array_key_exists($atribut['attr_id'], $odabraneVrednostiAtributaZaProizvod) && in_array($ATTRoptions['id'], $odabraneVrednostiAtributaZaProizvod[$atribut['attr_id']]))? 'checked':'' }}> <div class="btn mar_l_10 mar_r_10" style="background-color: {{ $ATTRoptions['value'] }}"></div>  {{ $ATTRoptions['label'] }}  {{ $atribut['attr_unit'] }}<br>
                                            @endforeach
                                        @endif


                                    </div>

                                    <hr>

                                    @endforeach
    {{-- @php
    echo '<pre>';
    print_r($allAttributesForProduct);
    echo '</pre>';
    @endphp --}}

                                    <input type="hidden" name="attr_all" value="{{ json_encode($listOfAttributes) }}">

                            @else

                                <div id="productOptions"></div>

                                <input type="hidden" name="attr_all" value="">

                            @endif

                                <script type="text/javascript">
                                    function findeAttributesForCat() {

                                        var CAT = $('select[name=category_id] :selected').val();

                                        var _token = $('[name=_token]').val();
                                        var host = '{{ URL::to("/") }}/{{ setting('admin.adm_url') }}';

                                        $.ajax({
                                            url: host+'/products/attributes',
                                            type: 'POST',
                                            data: { CAT: CAT,
                                                    _token: _token },
                                            success: function (data) {

                                                $('div#productOptions').html('');
                                                $('div#productOptions').html(data);

                                                $('select#sel2').select2();
                                            }
                                        });
                                        
                                    }
                                </script>

                            </div>
                        </div>

                        <!-- ### PROUCT BADGES ### -->
                        <div class="panel panel-bordered panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_product_badges')</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">

                                <p>@lang('shop_admin.title_product_badges_description')</p>

                                <div class="form-group">

                                <select class="form-control select2 select2-hidden-accessible" name="product_badge">
                                    <option value="">@lang('shop_admin.title_choose')</option>
                                    @foreach ($productBadges as $Bkey => $badge)
                                        <option value="{{ $badge->b_id }}" {{ ($badgeForProduct && $badgeForProduct->bp_badge_id == $badge->b_id)? 'selected':'' }}>{{ $badge->b_title }} ({{ $badge->b_description }})</option>
                                    @endforeach
                                </select>

                                </div>

                            </div>
                        </div>

                        <!-- ### SPECIOAL OPTIONS ### -->
                        <div class="panel panel-bordered panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_special_display_options')</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">

                                <p>@lang('shop_admin.title_special_display_options_description')</p>

                                <div class="form-group">

                                @foreach ($specialDisplayOptions as $key => $displayOption)

                                    <input type="checkbox" name="specal_options[]" value="{{ $displayOption->id }}" {{ (in_array($displayOption->id, $specialDisplayOptionsForProduct))? 'checked':'' }}> {{ $displayOption->title }}

                                    @if ($displayOption->description != null)
                                        <div class="small mar_b_10">{{ $displayOption->description }}</div>
                                    @endif

                                @endforeach

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <!-- ### IMAGE ### -->
                        <div class="panel panel-bordered panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_product_image')</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                @if(isset($dataTypeContent->image))
                                    <img src="/storage/products/{{ $dataTypeContent->image }}" style="width:100%" />
                                @endif
                                    <input type="file" name="image">
                                
                            </div>
                        </div>

                        <!-- ### VIDEO ### -->
                        <div class="panel panel-bordered panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_video')</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">

                                @if(isset($dataTypeContent->video))
                                    <div class="ytEmbedContainter mar_b_10">
                                        <iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{ $dataTypeContent->video }}"></iframe>
                                    </div>
                                @endif

                                <div class="small mar_b_10">@lang('shop_admin.title_video_note')</div>
                                <input type="text" name="video" class="form-control" value="{{ $dataTypeContent->video }}">
                                
                            </div>
                        </div>

                        <!-- ### SEO CONTENT ### -->
                        <div class="panel panel-bordered">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-search"></i> @lang('shop_admin.title_product_seo')</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="slug">@lang('shop_admin.title_slug')</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        placeholder="slug"
                                        {!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}
                                        value="{{ $dataTypeContent->slug ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">{{ __('voyager::post.meta_description') }}</label>
                                    <textarea class="form-control" name="meta_description" required="">{{ $dataTypeContent->meta_description ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">{{ __('voyager::post.meta_keywords') }}</label>
                                    <textarea class="form-control" name="meta_keywords" required="">{{ $dataTypeContent->meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!-- RIGHT end --------------------------------------------------->
        </div>

        </form>

@php

//if ($edit):
    // echo '<pre>';
    // print($productCategories_SEL);
    // echo '</pre>';
//endif;
@endphp

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
            <input name="image" id="upload_file" type="file"
                     onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
            {{ csrf_field() }}
        </form>

    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
