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
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <!-- form start -->
                    <form role="form"
                            id="editAttribute"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if($edit)
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                            <div class="panel-body">

                            <div class="row">
            
                            <div class="col-md-9">

                                <div class="form-group col-md-12">
                                    <label class="control-label" for="name">@lang('shop_admin.title_title')</label>
                                    <input type="text" name="name" class="form-control" required value="{{($edit)? $atributDATA->name:'' }}">
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label" for="name">@lang('shop_admin.title_description')</label>
                                    <input type="text" name="description" class="form-control" value="{{($edit)? $atributDATA->description:'' }}">
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label" for="name">@lang('shop_admin.title_unit')</label>
                                    <input type="text" name="unit" class="form-control" value="{{($edit)? $atributDATA->unit:'' }}">
                                </div>


                                <div class="form-group col-md-12">
                                    <label class="control-label" for="name">@lang('shop_admin.title_field_type')</label>
                                    <select class="form-control select2 select2-hidden-accessible" name="type" required>
                                        @foreach($attributeTYPE as $key => $type)

                                            <option value="{{ $key }}"  {{ ($edit && $atributDATA->type == $key )? 'selected':'' }}>{{ $type }}</option>

                                        @endforeach
                                    </select>
                                </div>

                                <hr>

                                <div class="form-group col-md-12">
                                    <label class="control-label" for="name">@lang('shop_admin.title_categories')</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="category_id[]" multiple required>

                                        @foreach($productCategories_SEL as $category)
                                            <option value="{{ $category->id }}" {{ ($category->published == '0')? 'disabled':'' }} {{ ($edit && in_array($category->id, $categoriesForAttribute))? 'selected':'' }}>{{ $category->name }}</option>
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

                                <div class="form-group col-md-12">
                                    <label class="control-label" for="status">@lang('shop_admin.title_status')</label><br>
                                    <input type="checkbox" name="status" class="form-control" data-toggle="toggle" value="{{($edit)? $atributDATA->status:'0' }}" {{($edit && $atributDATA->status == 1)? 'checked':'' }} id="btToggleStatus" onchange="checkBOXStatus()">
                                </div>

                                        <script type="text/javascript">

                                            function checkBOXStatus() {
                                                var ifChecked = $('input[name=status]').prop('checked');

                                                if (ifChecked) {
                                                    $('input[name=status]').val('1');
                                                } else {
                                                    $('input[name=status]').val('0');
                                                }
                                            }
                                        </script>

                            </div>

                            <div class="col-md-3">


                                <div class="form-group col-md-12">
                                    <label class="control-label" for="name">@lang('shop_admin.title_image')</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                @if($edit && isset($atributDATA->image))
                                <div class="form-group col-md-12">
                                    <img src="{{ Voyager::image( $atributDATA->image ) }}" class="img100" />
                                </div>
                                @endif


                            </div>

                            <div class="col-md-12">

                                @if ($edit)

                                    {{-- @if ($atributDATA->type != 1) --}}

                                        &nbsp;
                                        <hr>

                                        <div class="panel-heading" style="border-bottom:0;">
                                            <h3 class="panel-title">@lang('shop_admin.title_attributes_options'):</h3>
                                        </div>

                                        @if($attributeVALUES->isEmpty())

                                            <div class="row padd_l_15 mar_b_5" id="attr_1">


                                                <div class="col-md-2 mar_b_0">

                                                    <div class="form-group mar_b_0">
                                                        <label class="control-label" for="attr_order_1">@lang('shop_admin.title_order')</label>
                                                        <input type="text" name="attr_order_1" class="form-control" required>
                                                    </div>

                                                </div>

                                                <div class="col-md-4 mar_b_0">

                                                    <div class="form-group mar_b_0">
                                                        <label class="control-label" for="attr_label_1">@lang('shop_admin.title_label')</label>
                                                        <input type="text" name="attr_label_1" class="form-control" required>
                                                    </div>

                                                </div>

                                                <div class="col-md-4 mar_b_0">

                                                    <div class="form-group mar_b_0">
                                                        <label class="control-label" for="attr_value_1">@lang('shop_admin.title_value')</label>
                                                        <input type="text" name="attr_value_1" class="form-control" required>
                                                    </div>

                                                </div>

                                                <div class="col-md-4 mar_b_0">

                                                    <div class="form-group mar_b_0">
                                                        <label class="control-label" for="attr_value_1">@lang('shop_admin.title_status')</label>
                                                        <input type="checkbox" name="attr_status_1" class="form-control" data-toggle="toggle" value="0" id="btToggle" attrROW="1" onchange="checkBOX(1)">
                                                    </div>

                                                </div>

                                                <div class="col-md-2 mar_b_0">

                                                    <div class="form-group mar_b_0">
                                                        <label class="control-label"></label><br>
                                                        <div class="btn btn-danger" id="del_attr_1" name="delATTR" rowNO ="1" onclick="removeROW(1)"><i class="voyager-trash"></i></div>
                                                    </div>

                                                </div>

                                            </div>

                                            <input type="hidden" name="attr_val_id_1" value="">
                                            <input type="hidden" name="attr_val_cnt" value="1">

                                        @else

                                            @foreach ($attributeVALUES as $key => $attrVAL)

                                                <div class="row padd_l_15 mar_b_5" id="attr_{{ $key }}">


                                                    <div class="col-md-1 mar_b_0">

                                                        <div class="form-group mar_b_0">
                                                            <label class="control-label" for="attr_order_{{ $key }}">@lang('shop_admin.title_order')</label>
                                                            <input type="text" name="attr_order_{{ $key }}" class="form-control text-center" value="{{ $attrVAL->attrval_order }}" required>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-5 mar_b_0">

                                                        <div class="form-group mar_b_0">
                                                            <label class="control-label" for="attr_label_{{ $key }}">@lang('shop_admin.title_label')</label>
                                                            <input type="text" name="attr_label_{{ $key }}" class="form-control" value="{{ $attrVAL->attrval_label }}" required>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-4 mar_b_0">

                                                        <div class="form-group mar_b_0">
                                                            <label class="control-label" for="attr_value_{{ $key }}">@lang('shop_admin.title_value')</label>

                                                            @switch($atributDATA->type)
                                                                @case(7) {{-- Color --}}
                                                                    
                                                                        <input type="color" name="attr_value_{{ $key }}" class="form-control" value="{{ $attrVAL->attrval_value }}" required>

                                                                    @break
                                                            
                                                                @default  {{-- all others --}}
                                                                        <input type="text" name="attr_value_{{ $key }}" class="form-control" value="{{ $attrVAL->attrval_value }}" required>

                                                            @endswitch

                                                        </div>

                                                    </div>

                                                    <div class="col-md-1 mar_b_0">

                                                        <div class="form-group mar_b_0">
                                                            <label class="control-label" for="attr_value_{{ $key }}">@lang('shop_admin.title_status')</label><br>
                                                            <input type="checkbox" name="attr_status_tmp_{{ $key }}" value="{{ $attrVAL->attrval_status }}" {{ ($attrVAL->attrval_status == 1)? 'checked':'' }} id="btToggle" data-toggle="toggle" attrROW="{{ $key }}" onchange="checkBOX({{ $key }})">
                                                            <input type="hidden" name="attr_status_{{ $key }}" value="{{ $attrVAL->attrval_status }}">
                                                        </div>

                                                    </div>

                                                    <div class="col-md-1 mar_b_0">

                                                        <div class="form-group mar_b_0">
                                                            <label class="control-label"></label><br>
                                                            <div class="btn btn-danger" id="del_attr_{{ $key }}" name="delATTR" rowNO ="{{ $key }}" onclick="removeROW({{ $key }})"><i class="voyager-trash"></i></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <input type="hidden" name="attr_val_id_{{ $key }}" value="{{ $attrVAL->attrval_id }}">

                                            @endforeach


                                            <input type="hidden" name="attr_val_cnt" value="{{ $key }}">

                                        @endif

                                        <div id="addedROWs"></div>

                                        <div class="form-group col-md-12">

                                            <div class="btn btn-primary" id="addATTRrow" onclick="addROW()">@lang('shop_admin.btn_add')</div>
                                        </div>

                                    {{-- @endif --}}

                                @else

                                        &nbsp;
                                        <hr>

                                        <div class="panel-heading" style="border-bottom:0;">
                                            <h3 class="panel-title">@lang('shop_admin.title_attributes_options'):</h3>
                                        </div>


                                        <div class="row padd_l_15 mar_b_5" id="attr_1">


                                            <div class="col-md-1 mar_b_0">

                                                <div class="form-group mar_b_0">
                                                    <label class="control-label" for="attr_order_1">@lang('shop_admin.title_order')</label>
                                                    <input type="text" name="attr_order_1" class="form-control text-center" required>
                                                </div>

                                            </div>

                                            <div class="col-md-5 mar_b_0">

                                                <div class="form-group mar_b_0">
                                                    <label class="control-label" for="attr_label_1">@lang('shop_admin.title_label')</label>
                                                    <input type="text" name="attr_label_1" class="form-control" required>
                                                </div>

                                            </div>

                                            <div class="col-md-4 mar_b_0">

                                                <div class="form-group mar_b_0">
                                                    <label class="control-label" for="attr_value_1">@lang('shop_admin.title_value')</label>
                                                    <input type="text" name="attr_value_1" class="form-control" required>
                                                </div>

                                            </div>

                                            <div class="col-md-1 mar_b_0">

                                                <div class="form-group mar_b_0">
                                                    <label class="control-label" for="attr_value_1">@lang('shop_admin.title_status')</label><br>
                                                    <input type="checkbox" name="attr_status_tmp_1" class="form-control" data-toggle="toggle" value="0" id="btToggle" attrROW="1" onchange="checkBOX(1)">
                                                    <input type="hidden" name="attr_status_1" value="0">
                                                </div>

                                            </div>

                                            <div class="col-md-1 mar_b_0">

                                                <div class="form-group mar_b_0">
                                                    <label class="control-label"></label><br>
                                                    <div class="btn btn-danger" id="del_attr_1" name="delATTR" rowNO ="1" onclick="removeROW(1)"><i class="voyager-trash"></i></div>
                                                </div>

                                            </div>

                                        </div>

                                        <input type="hidden" name="attr_val_cnt" value="1">

                                        <div id="addedROWs"></div>

                                        <div class="form-group col-md-12">

                                            <div class="btn btn-primary" id="addATTRrow" onclick="addROW()">@lang('shop_admin.btn_add')</div>
                                        </div>

                                @endif


                                        <script type="text/javascript">

                                            function checkBOX(attrRowNO) {
                                                var ifChecked = $('input[name=attr_status_tmp_'+attrRowNO+']').prop('checked');

                                                if (ifChecked) {
                                                    $('input[name=attr_status_'+attrRowNO+']').val('1');
                                                } else {
                                                    $('input[name=attr_status_'+attrRowNO+']').val('0');
                                                }
                                                console.log(ifChecked);
                                            }

                                            function removeROW(rowNO) {

                                                var numberOfRows = $('input[name=attr_val_cnt]').val();
                                                var new_numberOfRows = Number(numberOfRows) + 1;
                                                $('input[name=attr_val_cnt]').val(new_numberOfRows);

                                                $('div#attr_'+rowNO).remove();

                                                console.log(rowNO+' // '+'brisiiii');

                                            }

                                            function addROW() {

                                                var numberOfRows = $('input[name=attr_val_cnt]').val();
                                                var new_numberOfRows = Number(numberOfRows) + 1;
                                                $('input[name=attr_val_cnt]').val(new_numberOfRows);

                                                var rowNO = new_numberOfRows;

                                                
                                                var attrType = $('select[name=type] option:selected').val();

                                                if (attrType == 7) {
                                                    var fieldHTML = '<input type="color" name="attr_value_'+rowNO+'" class="form-control" required>';
                                                } else {
                                                    var fieldHTML = '<input type="text" name="attr_value_'+rowNO+'" class="form-control" required>';
                                                }

                                                var ATTRrowHTML = '\
                                                    <div class="row padd_l_15 mar_b_5" id="attr_'+rowNO+'">\
                                                        <div class="col-md-1 mar_b_0">\
                                                            <div class="form-group mar_b_0">\
                                                                <label class="control-label" for="attr_order_'+rowNO+'">@lang('shop_admin.title_order')</label>\
                                                                <input type="text" name="attr_order_'+rowNO+'" class="form-control text-center" required>\
                                                            </div>\
                                                        </div>\
                                                        <div class="col-md-5 mar_b_0">\
                                                            <div class="form-group mar_b_0">\
                                                                <label class="control-label" for="attr_label_'+rowNO+'">@lang('shop_admin.title_label')</label>\
                                                                <input type="text" name="attr_label_'+rowNO+'" class="form-control" required>\
                                                            </div>\
                                                        </div>\
                                                        <div class="col-md-4 mar_b_0">\
                                                            <div class="form-group mar_b_0">\
                                                                <label class="control-label" for="attr_value_'+rowNO+'">@lang('shop_admin.title_value')</label>\
                                                                '+fieldHTML+'\
                                                            </div>\
                                                        </div>\
                                                        <div class="col-md-1 mar_b_0">\
                                                            <div class="form-group mar_b_0">\
                                                                <label class="control-label" for="attr_value_'+rowNO+'">@lang('shop_admin.title_status')</label><br>\
                                                                <input type="checkbox" name="attr_status_tmp_'+rowNO+'" value="0" data-toggle="toggle" id="btToggle" attrROW="'+rowNO+'" onchange="checkBOX('+rowNO+')">\
                                                                <input type="hidden" name="attr_status_'+rowNO+'" value="0">\
                                                            </div>\
                                                        </div>\
                                                        <div class="col-md-1 mar_b_0">\
                                                            <div class="form-group mar_b_0">\
                                                                <label class="control-label"></label><br>\
                                                                <div class="btn btn-danger" id="del_attr_'+rowNO+'" name="delATTR" rowNO ="'+rowNO+'"  onclick="removeROW('+rowNO+')"><i class="voyager-trash"></i></div>\
                                                            </div>\
                                                        </div>\
                                                    </div>\
                                                ';

                                                $('div#addedROWs').append(ATTRrowHTML);

                                                $("[data-toggle='toggle']").bootstrapToggle('destroy');
                                                $("[data-toggle='toggle']").bootstrapToggle();                                                

                                            }

                                        </script>

                            </div>

                            </div>

                        </div>

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        </div>

                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>

        </div>


    </div>

@php
// if ($edit):
    // echo '<pre>';
    // print_r($productCategories_SEL);
    // print_r($atributDATA);
    // echo '</pre>';
// endif;
@endphp

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
