@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp;
                {{ __('voyager::generic.edit') }}
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if($isSoftDeleted)
                <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan

        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a>
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">

            <div class="col-md-9">

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_attribute'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div><label class="text-bold">@lang('shop_admin.title_title'):</label> <span>{{ $attributeDATA->attr_title }}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_description'):</label> <span>{{ $attributeDATA->attr_description }}</span></div>

                        <hr>

                        <div><label class="text-bold">@lang('shop_admin.title_type'):</label> <span>
                            @foreach ($attributeTYPE as $key => $attr)
                                @if ($attributeDATA->attr_type == $key)
                                    {{ $attr }}
                                @endif
                            @endforeach
                        </span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_unit'):</label> <span>{{ $attributeDATA->attr_unit }}</span></div>

                        <hr>

                        <div><label class="text-bold">@lang('shop_admin.title_attributes_options'):</label> <span></div>

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('shop_admin.title_order')</th>
                                        <th class="text-center">@lang('shop_admin.title_label')</th>
                                        <th class="text-center">@lang('shop_admin.title_value')</th>
                                        <th class="text-center">@lang('shop_admin.title_status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attributeValuesDATA as $key => $attrVAL)
                                    <tr>
                                        <td class="text-center">{{ $attrVAL->attrval_order }}</td>
                                        <td>{{ $attrVAL->attrval_label }}</td>
                                        <td>
                                            @switch($attributeDATA->attr_type)
                                                @case(7) {{-- COLOR --}}
                                                    <div class="btn mar_r_10" style="background-color: {{ $attrVAL->attrval_value }};"></div>
                                                    @break
                                            
                                                @default
                                                        {{-- ako je potrebno kasnije koristiti za neki drugi atribut --}}
                                            @endswitch
                                            
                                            {{ $attrVAL->attrval_value }}

                                        </td>
                                        <td class="text-center">
                                            @if($attrVAL->attrval_status == 1)
                                                <span class="label label-info">@lang('shop_admin.title_on')</span>
                                            @else
                                                <span class="label label-warning">@lang('shop_admin.title_Off')</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_image'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        @if ($attributeDATA->attr_image != '')

                            <img src="{{ Voyager::image( $attributeDATA->attr_image ) }}" class="img100" />

                        @endif
                    </div>

                </div>
                
            </div>

        </div>
    </div>

@php
    // echo '<pre>';
    // print_r($attributeValuesDATA);
    // echo '</pre>';
@endphp

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function () {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });

    </script>
@stop
