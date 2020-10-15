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
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <!-- form start -->

                        <div class="panel-body" style="padding-top:0;">

                        <div class="row">

                            <div class="col-md-6">

                                <h3 class="panel-title">@lang('shop_admin.title_pesonal_details')</h3>

                                <div><label class="text-bold">@lang('shop_admin.title_firstname'):</label> <span>{{ $userDATA->name }}</span></div>
                                <div><label class="text-bold">@lang('shop_admin.title_lastname'):</label> <span>{{ $userDATA->last_name }}</span></div>

                                <hr>

                                <div><label class="text-bold">@lang('shop_admin.title_phone'):</label> <span>{{ $userDATA->phone }}</span></div>
                                <div><label class="text-bold">@lang('shop_admin.title_email'):</label> <span>{{ $userDATA->email }}</span></div>

                                <hr>

                                <div><label class="text-bold">@lang('shop_admin.title_address'):</label> <span>{{ $userDATA->address }}</span></div>
                                <div><label class="text-bold">@lang('shop_admin.title_postal_code'):</label> <span>{{ $userDATA->zip }}</span></div>
                                <div><label class="text-bold">@lang('shop_admin.title_city'):</label> <span>{{ $userDATA->city }}</span></div>



                                <h3 class="panel-title">@lang('shop_admin.title_company_details')</h3>

                                <div><label class="text-bold">@lang('shop_admin.title_company_name'):</label> <span>{{ $userDATA->company_name }}</span></div>

                                <div><label class="text-bold">@lang('shop_admin.title_company_phone'):</label> <span>{{ $userDATA->company_phone }}</span></div>
                                <div><label class="text-bold">@lang('shop_admin.title_company_email'):</label> <span>{{ $userDATA->company_email }}</span></div>

                                <hr>

                                <div><label class="text-bold">@lang('shop_admin.title_company_address'):</label> <span>{{ $userDATA->company_address }}</span></div>
                                <div><label class="text-bold">@lang('shop_admin.title_company_postal_code'):</label> <span>{{ $userDATA->company_zip }}</span></div>
                                <div><label class="text-bold">@lang('shop_admin.title_company_city'):</label> <span>{{ $userDATA->company_city }}</span></div>


                            </div>

                            <div class="col-md-6 ">

                                <h3 class="panel-title">@lang('shop_admin.title_additional_info')</h3>

                                <div><label class="text-bold">@lang('shop_admin.title_loyalty') (@lang('shop_admin.title_loyalty_barcode')):</label> <span>{{ $userDATA->loy_barcode }}</span></div>

                                <hr>

                                <div><label class="text-bold">@lang('shop_admin.title_user_role'):</label> <span>{{ $userDATA->role_display_name }}</span></div>

                                <hr>

                                <div><label class="text-bold">@lang('shop_admin.title_user_discount'):</label> <span>{{ $userDATA->discount }}</span></div>

                                <hr>

                                <div><label class="text-bold">@lang('shop_admin.title_image'):</label><br>
                                    <img src="/storage/{{ $userDATA->avatar }}" alt="{{ $userDATA->name }} {{ $userDATA->last_name }}" width="200" height="auto">
                                </div>

                                <br>
                                <hr>

                                <h3 class="panel-title">@lang('shop_admin.title_orders')</h3>

                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">@lang('shop_admin.title_order_number')</th>
                                                <th class="text-center">@lang('shop_admin.title_date')</th>
                                                <th class="text-center">@lang('shop_admin.title_amount')</th>
                                                <th class="text-center">@lang('shop_admin.title_status')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ordersForUser as $key => $order)
                                            <tr>
                                                <td><a href="/{{ setting('admin.adm_url') }}/orders/{{ $order->id }}">{{ $order->order_number }}</a></td>
                                                <td class="text-center">{{ date('d.m.Y', strtotime($order->created_at)) }}</td>
                                                <td class="text-right">{{ number_format($order->total,0,"",".") }} {{ setting('site.valuta') }}</td>
                                                <td class="text-center">{{ $order->order_status_title }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                

                            </div>

                        </div>

@php
    // echo '<pre>';
    // print_r($ordersForUser);
    // echo '</pre>';
@endphp


                </div>
            </div>
        </div>
    </div>

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
