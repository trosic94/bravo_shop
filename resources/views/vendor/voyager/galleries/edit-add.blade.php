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

            <div class="col-md-5">

                <div class="panel panel-bordered">

                    <!-- form start -->
                    <form role="form"
                            id="editSlider"
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
                
                                    <div class="col-md-12">

                                        <div class="form-group col-md-12">
                                            <label class="control-label" for="name">@lang('shop_admin.title_title')</label>
                                            <input type="text" name="name" class="form-control" required value="{{($edit)? $galleryDATA->name:'' }}">
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            </div>

                    </form>

                </div>

            </div>

            <div class="col-md-7">

                <div class="panel panel-bordered panel-info">

                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon wb-clipboard"></i> @lang('shop_admin.title_add_image_for_gallery')</h3>
                        <div class="panel-actions">
                            <a class="panel-action voyager-angle-down panel-collapsed" data-toggle="panel-collapse" aria-hidden="true"></a>
                        </div>
                    </div>
                    <!-- form start -->
                    <form method="POST" id="slideDEL" action="/SDFSDf345345--DFgghjtyut-6/gallery-items/insert" enctype="multipart/form-data">

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body" style="display: none;">

                            <div class="form-group col-md-12">
                                <label class="control-label" for="title">@lang('shop_admin.title_title')</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label" for="description">@lang('shop_admin.title_description')</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label" for="image">@lang('shop_admin.title_image')</label>
                                <input type="file" name="image" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="control-label" for="image_order">@lang('shop_admin.title_order')</label>
                                <input type="text" name="image_order" class="form-control" required>
                            </div>

                        </div>

                        <div class="panel-footer">
                            <input type="hidden" name="gallery_id" value="{{ $galleryDATA->id }}">
                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered panel-warning">

                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon wb-clipboard"></i> @lang('shop_admin.title_gallery')</h3>
                        <div class="panel-actions">
                            <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                        </div>
                    </div>

                    <div class="panel-body">

                        @if ($galleryITEMs)

                        <div class="row flexWrap">

                        @foreach ($galleryITEMs as $key => $image)

                            <div class="col-md-3 mar_b_10">

                                <div class="row">
                                    <div class="col-md-6 mar_b_0">

                                        <div>
                                        <label class="text-bold">@lang('shop_admin.title_order'):</label>
                                        <span class="text-bold text-warning">{{ $image->image_order }}</span>
                                        </div>

                                        <div>
                                        <label class="text-bold">@lang('shop_admin.title_title'):</label><br>
                                        {{ $image->title }}
                                        </div>

                                        <div>
                                        <label class="text-bold">@lang('shop_admin.title_description'):</label><br>
                                        {{ $image->description }}
                                        </div>

                                    </div>
                                    <div class="col-md-6 mar_b_0">
                                        <img src="/storage/gallery/{{ $image->image }}" alt="{{ $image->title }}" class="img100">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mar_b_0 text-right">
                                        <div class="btn btn-primary btnSmall" name="galIMGEdit" galIMG_ID="{{ $image->id }}"><i class="voyager-edit"></i></div>
                                        <form method="POST" id="imageDEL" action="/SDFSDf345345--DFgghjtyut-6/gallery-items/delete" class="inlineForms">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                                            <button class="btn btn-danger btnSmall" name="delIMGbtn"><i class="voyager-trash"></i></button>
                                        </form>
                                    </div>
                                </div>

                            <hr>

                            </div>

                        @endforeach

                        </div>

                        @endif

                    </div>

                </div>

            </div>
        </div>

@php
// if ($edit):
//     echo '<pre>';
//     print_r($galleryITEMs);
//     echo '</pre>';
// endif;
@endphp

    </div>

    <!-- Start SLIDE Edit Modal -->
    <div class="modal fade modal-primary" id="slide_edit_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-cintent modal-content-scrollable">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-edit"></i> @lang('shop_admin.title_edit')</h4>
                </div>

                <form method="POST" id="galIMGEdit" action="/SDFSDf345345--DFgghjtyut-6/gallery-items/edit" enctype="multipart/form-data">

                <div class="modal-body bgWhite">
                    
                    {{ csrf_field() }}

                    <div class="panel-body padd_0">
                        <div id="galIMGEditForm"></div>
                    </div>

                </div>

                <div class="modal-footer bgWhite">
                    <div type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</div>
                    <button type="button" class="btn btn-primary" id="confirm_edit">@lang('shop_admin.title_update_slide')</button>
                </div>

                </form>
            </div>
        </div>
    </div>
    <!-- End SLIDE Edit Modal -->

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

            $('div[name=galIMGEdit]').on('click', function(){

                $('div#galIMGEditForm').html('');

                var galIMG_ID = $(this).attr('galIMG_ID');
                var _token = $('input[name=_token]').val();
                var host = '{{ URL::to("/") }}';

                $.ajax({
                    url: host+'/SDFSDf345345--DFgghjtyut-6/gallery-items/edit',
                    type: 'POST',
                    data: { galIMG_ID: galIMG_ID,
                            _token: _token },
                    success: function (rsp) {
                        $('div#galIMGEditForm').html(rsp);

                        $('select#targetSEL').select2();
                        $('.toggleswitch').bootstrapToggle();
                    }
                });


                $('#slide_edit_modal').modal('show');
            });

            $('button#confirm_edit').on('click', function(){
                $('form#galIMGEdit').submit();
            });


            $('.toggleswitch').bootstrapToggle();

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

