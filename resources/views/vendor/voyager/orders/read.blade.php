@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->display_name_singular) }} &nbsp;

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
            <div class="col-md-6">

            	<div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_order'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div><label class="text-bold">@lang('shop_admin.title_order_number'):</label> <span>{{ $orderDATA->ord_order_number }}</span></div>

                    	<div><label class="text-bold">@lang('shop_admin.title_invoice_number'):</label> <span>{{ $orderDATA->ord_invoice }}</span></div>
                    	
                    	<div><label class="text-bold">@lang('shop_admin.title_proforma_invoice'):</label> <span class="text-bold"><a href="/storage/proforma-invoice/{{ $orderDATA->ord_proforma_invoice }}.pdf" target="_blank">{{ $orderDATA->ord_proforma_invoice }}</a></span></div>

                    	<div><label class="text-bold">@lang('shop_admin.title_payment_method'):</label> <span>{{ $orderDATA->ord_payment_method }}</span></div>

                    	@if($orderDATA->ord_merchantPaymentId != '')
                    		<div><label class="text-bold">@lang('shop_admin.title_merchant_payment_id'):</label> <span>{{ $orderDATA->ord_merchantPaymentId }}</span></div>
                    	@endif

                    	<hr>

						<div><label class="text-bold">@lang('shop_admin.title_created_at'):</label> <span>{{ date('d.m.Y H:i:s', strtotime($orderDATA->ord_created_at)) }}</span></div>

                    	<hr>

						<div><label class="text-bold">@lang('shop_admin.title_order_Status'):</label> <span>{{ $orderDATA->ord_status }}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_updated_at'):</label> <span>{{ (strtotime($orderDATA->ord_updated_at) != '')? date('d.m.Y H:i:s', strtotime($orderDATA->ord_updated_at)):'' }}</span></div>

                    </div>


            	</div>

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_shipping'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div><label class="text-bold">@lang('shop_admin.title_firstname'):</label> <span>{{ $orderDATA->shp_name }} {{ $orderDATA->shp_last_name }}</span></div>

                        <div><label class="text-bold">@lang('shop_admin.title_phone'):</label> <span>{{ $orderDATA->shp_phone }}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_email'):</label> <span><a href="mailto:{{ $orderDATA->shp_email }}" target="_blank"> {{ $orderDATA->shp_email }}</a></span></div>

                        <div><label class="text-bold">@lang('shop_admin.title_address'):</label> <span> {{ $orderDATA->shp_address }}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_postal_code'):</label> <span> {{ $orderDATA->shp_zip }}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_city'):</label> <span> {{ $orderDATA->shp_city }}</span></div>

                    </div>


                </div>

            </div>

            <div class="col-md-6">

            	<div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_customer')</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                    	<div><label class="text-bold">@lang('shop_admin.title_firstname'):</label> <span>{{ $orderDATA->usr_name }} {{ $orderDATA->usr_last_name }}</span></div>

                    	<div><label class="text-bold">@lang('shop_admin.title_phone'):</label> <span>{{ $orderDATA->usr_phone }}</span></div>
                    	<div><label class="text-bold">@lang('shop_admin.title_email'):</label> <span><a href="mailto:{{ $orderDATA->usr_email }}" target="_blank"> {{ $orderDATA->usr_email }}</a></span></div>

                    	<div><label class="text-bold">@lang('shop_admin.title_address'):</label> <span> {{ $orderDATA->usr_address }}</span></div>
                    	<div><label class="text-bold">@lang('shop_admin.title_postal_code'):</label> <span> {{ $orderDATA->usr_zip }}</span></div>
                    	<div><label class="text-bold">@lang('shop_admin.title_city'):</label> <span> {{ $orderDATA->usr_city }}</span></div>

                    	@if ($orderDATA->usr_company_name != '')
                    		<h5>@lang('shop_admin.title_company'):</h5>
                    		<div><label class="text-bold">@lang('shop_admin.title_company_name'):</label> <span> {{ $orderDATA->usr_company_name }}</span></div>
                    		
                    		<div><label class="text-bold">@lang('shop_admin.title_phone'):</label> <span> {{ $orderDATA->usr_company_phone }}</span></div>
                    		<div><label class="text-bold">@lang('shop_admin.title_email'):</label> <span> <a href="mailto:{{ $orderDATA->usr_email }}" target="_blank">{{ $orderDATA->usr_company_email }}</a></span></div>

                    		<div><label class="text-bold">@lang('shop_admin.title_address'):</label> <span> {{ $orderDATA->usr_company_address }}</span></div>
                    		<div><label class="text-bold">@lang('shop_admin.title_postal_code'):</label> <span> {{ $orderDATA->usr_company_zip }}</span></div>
                    		<div><label class="text-bold">@lang('shop_admin.title_city'):</label> <span> {{ $orderDATA->usr_company_city }}</span></div>
                    	@endif

                    </div>


            	</div>
            	
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

            	<div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_order_items')</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

            		<table class="table_v1" cellpadding="0" cellspacing="0">
            			<thead>
            				<tr>
            					<th>@lang('shop_admin.title_row_number')</th>
            					<th>@lang('shop_admin.title_sku')</th>
            					<th>@lang('shop_admin.title_title')</th>
            					<th>@lang('shop_admin.title_quantity')</th>
            					<th>@lang('shop_admin.title_price')</th>
            					<th>@lang('shop_admin.title_discount')</th>
            					<th>@lang('shop_admin.title_price_w_discount')</th>
            					<th>@lang('shop_admin.title_vat') (%)</th>
            					<th>@lang('shop_admin.title_total')</th>
            				</tr>
            			</thead>
            			<tbody>
            				@php
            					$itemCNT = 1;
            					$subTotal = 0;
            				@endphp
            				@foreach($orderItemsDATA as $key => $item)

            				@php
            					//jedinacna cena sa popustom
            					$priceWDiscount = $item->prod_price-(($item->prod_price/100)*$item->prod_discount);

            					//racunam popust na jedinacnu cenu ako je proizvod na akciji
								if ($item->prod_discount != 0 || $item->prod_discount != ''):
            						$itemTotal = $item->ordi_kolicina * $priceWDiscount;
            					else:
            						$itemTotal = $item->ordi_kolicina * $item->prod_price;
            					endif;
            				@endphp


            				<tr class="itemRow">
            					<td class="text-center">{{ $itemCNT }}</td>
            					<td class="text-center">{{ $item->prod_sku }}</td>
            					<td>{{ $item->prod_title }}</td>
            					<td class="text-center">{{ $item->ordi_kolicina }}</td>
            					<td class="text-right">{{ number_format($item->prod_price,2,".","") }}</td>
            					<td class="text-right">{{ number_format($item->prod_discount,2,".","") }}</td>
            					<td class="text-right">{{ number_format($priceWDiscount,2,".","") }}</td>
            					<td class="text-center">{{ $item->prod_vat }}</td>
            					<td class="text-right">{{ number_format($itemTotal,2,".","") }}</td>
            				</tr>
            				@php
            					$itemCNT++;

            					// kreiram ukupan iznos racuna
            					$subTotal = $subTotal + $itemTotal;

            				@endphp
            				@endforeach
            				<tr>
            					<td colspan="6"></td>
            					<td class="ORD_subTotal" colspan="2">@lang('shop_admin.title_value')</td>
            					<td class="ORD_subTotal text-right">{{ number_format($subTotal,2,".","") }}</td>
            				</tr>

            				@if ($orderDATA->ord_rabat != 0 || $orderDATA->ord_rabat != '')
            				<tr>
            					<td colspan="6"></td>
            					<td colspan="2">@lang('shop_admin.title_discount') (%)</td>
            					<td class="text-right">{{ $orderDATA->ord_rabat }}</td>
            				</tr>

            					@php
            						$total = $subTotal-(($subTotal/100)*$orderDATA->ord_rabat);
            					@endphp

            				@else

            					@php
            						$total = $subTotal;
            					@endphp

            				@endif

            				<tr>
            					<td colspan="6"></td>
            					<td class="ORD_Total" colspan="2">@lang('shop_admin.title_total_big')</td>
            					<td class="ORD_Total text-right">{{ number_format($total,2,".","") }}</td>
            				</tr>
            			</tbody>
            		</table>

            		</div>


            	</div>
            </div>
        </div>


@php
	// echo '<pre>';
	// print_r($orderDATA);
	// echo '</pre>';
@endphp


    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->display_name_singular) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->display_name_singular) }}">
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
        <script src="{{ voyager_asset('js/multilingual.js') }}"></script>
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
