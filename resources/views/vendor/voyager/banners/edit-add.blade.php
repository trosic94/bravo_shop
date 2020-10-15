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

            @php
                $formURL = 'insert';
                if ($edit):
                    $editURL = 'edit';
                endif;
            @endphp

        <form method="POST" class="form-edit-add" action="/{{ setting('admin.adm_url') }}/banners/{{ ($edit)? 'edit':'insert' }}" enctype="multipart/form-data">
       
            <!-- CSRF TOKEN -->
            {{ csrf_field() }}

            @if ($edit)
                <input type="hidden" name="banner_id" value="{{ $bannerDATA->id }}">
            @endif

            <div class="col-md-6">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_basic_data')</h3>
                        <div class="panel-actions">
                            <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                        </div>
                    </div>

                    <div class="panel-body">


                        <div class="form-group">
                            <label class="control-title">@lang('shop_admin.title_banner_name')*</label>
                            <input  type="text" class="form-control" name="name" placeholder="Name" value="{{ ($edit)? $bannerDATA->name:'' }}" required>
                        </div>

                        <div class="form-group">
                            <label class="control-title">@lang('shop_admin.title_client_name') *</label>

                            <select class="form-control select2 select2-hidden-accessible" name="client_id" required>
                                <option value="">@lang('shop_admin.title_choose')</option>
                                @foreach ($bannersClients as $cliKey => $client)
                                    <option value="{{ $client->id }}" {{ ($edit && $bannerDATA->client_id == $client->id)? 'selected':'' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-title">@lang('shop_admin.title_banner_position')*</label>

                            <select class="form-control select2 select2-hidden-accessible" name="position_id" required>
                                <option value="">@lang('shop_admin.title_choose')</option>
                                @foreach ($bannersPositions as $posKey => $position)
                                    <option value="{{ $position->id }}" {{ ($edit && $bannerDATA->position_id == $position->id)? 'selected':'' }}>{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr style="margin: 30px 0 20px;">

                        <div class="form-group">
                            <label class="control-title" for="name">@lang('shop_admin.title_start_date')*</label>
                            @php
                                $startDATE = '';
                                if ($edit):
                                    $startDATE = date('d.m.Y H:i', strtotime($bannerDATA->start_date));
                                endif;
                            @endphp
                            <input type="text" id="date" class="form-control" name="new_start_date" placeholder="{{ $startDATE }}" {{ ($edit)? '':'required' }}>
                            @if ($edit)
                                <input type="hidden" name="old_start_date" value="{{ $bannerDATA->start_date }}">
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="control-title" for="name">@lang('shop_admin.title_end_date')*</label>
                            @php
                                $endDATE = '';
                                if ($edit):
                                    $endDATE = date('d.m.Y H:i', strtotime($bannerDATA->end_date));
                                endif;
                            @endphp
                            <input type="text" id="date" class="form-control" name="new_end_date" placeholder="{{ $endDATE }}" {{ ($edit)? '':'required' }}>
                            @if ($edit)
                                <input type="hidden" name="old_end_date" value="{{ $bannerDATA->end_date }}">
                            @endif

                        </div>

                        <hr style="margin: 30px 0 20px;">

                        <div class="form-group">
                            <label class="control-title" for="description">@lang('shop_admin.title_description')</label>
                            <textarea class="form-control" name="description">{{ ($edit)? $bannerDATA->description:'' }}</textarea>
                        </div>

                    </div>

                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                    </div>

                </div>
            </div>

            <div class="col-md-6">

                <div class="panel panel-bordered panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_options')</h3>
                        <div class="panel-actions">
                            <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label class="control-title" for="url">@lang('shop_admin.title_url')*</label>
                                    <input type="text" class="form-control" name="url" value="{{ ($edit)? $bannerDATA->url:'' }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-title" for="target">@lang('shop_admin.title_target')*</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="target" required>
                                        <option value="_self" {{ ($edit && $bannerDATA->target == '_self')? 'selected':'' }}>@lang('shop_admin.title_target_self')</option>
                                        <option value="_blank" {{ ($edit && $bannerDATA->target == '_blank')? 'selected':'' }}>@lang('shop_admin.title_target_blank')</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- ### IMAGE ### -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon wb-image"></i> @lang('shop_admin.title_image')</h3>
                        <div class="panel-actions">
                            <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(isset($dataTypeContent->image))
                            <img src="/storage/banners/{{ $bannerDATA->image }}" class="img100" />
                        @endif
                            <input type="file" name="image">
                        
                    </div>
                </div>

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

@php
    // echo '<pre>';
    // print_r($bannerDATA);
    // echo '</pre>';
@endphp

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
            $('.form-group input#date').each(function (idx, elt) {
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
