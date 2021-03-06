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
                        <h3 class="panel-title">@lang('shop_admin.title_product'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div><label class="text-bold">@lang('shop_admin.title_sku'):</label> <span>{{ $productDATA->prod_sku }}</span></div>
                        <hr>

                        <div><label class="text-bold">@lang('shop_admin.title_title'):</label> <span>{{ $productDATA->prod_title }}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_excerpt'):</label> <span class="blockFormat">{!! $productDATA->prod_excerpt !!}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_body'):</label> <span class="blockFormat">{!! $productDATA->prod_body !!}</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_specification'):</label> <span class="blockFormat">{!! $productDATA->prod_specification !!}</span></div>

                        <hr>

                        <div>
                            <label class="text-bold">@lang('shop_admin.title_status'):</label> 
                            <span>
                                @if($productDATA->prod_status == 1)
                                    <span class="label label-info">@lang('shop_admin.title_on')</span>
                                @else
                                    <span class="label label-warning">@lang('shop_admin.title_off')</span>
                                @endif
                            </span>
                        </div>

                        <div>
                            <label class="text-bold">@lang('shop_admin.title_on_stock'):</label> 
                            <span>
                                @if($productDATA->prod_on_stock == 1)
                                    <span class="label label-info">@lang('shop_admin.title_yes')</span>
                                @else
                                    <span class="label label-warning">@lang('shop_admin.title_no')</span>
                                @endif
                            </span>
                        </div>

                        <div>
                            <label class="text-bold">@lang('shop_admin.title_feautred'):</label> 
                            <span>
                                @if($productDATA->prod_featured == 1)
                                    <span class="label label-info">@lang('shop_admin.title_yes')</span>
                                @else
                                    <span class="label label-warning">@lang('shop_admin.title_no')</span>
                                @endif
                            </span>
                        </div>

                        <hr>

                        <table width="100%">
                            <tr>
                                <td class="text-bold padd_l_5 padd_r_5" width="50%">@lang('shop_admin.title_price'):</td>
                                <td>{{ number_format($productDATA->prod_price,2,".","") }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold padd_l_5 padd_r_5" width="50%">@lang('shop_admin.title_product_price_with_discount'):</td>
                                <td>{{ number_format($productDATA->prod_price_with_discount,2,".","") }}</td>
                            </tr>
{{--                             <tr>
                                <td class="text-bold padd_l_5 padd_r_5">@lang('shop_admin.title_discount') (%):</td>
                                <td>{{ number_format($productDATA->prod_discount,2,".","") }}</td>
                            </tr>

                            @php
                                $priceWDiscount = $productDATA->prod_price + (($productDATA->prod_price / 100) * $productDATA->prod_discount);
                            @endphp

                            <tr class="ORD_subTotal">
                                <td class="text-bold padd_l_5 padd_r_5">@lang('shop_admin.title_price_w_discount'):</td>
                                <td>{{ number_format($priceWDiscount,2,".","") }}</td>
                            </tr>
                                @php
                                    $total = $priceWDiscount + ($priceWDiscount * ($productDATA->prod_vat/100) );
                                @endphp
                            <tr class="ORD_Total">
                                <td class="text-bold padd_l_5 padd_r_5">@lang('shop_admin.title_total_big'):</td>
                                <td>{{ number_format($total,2,".","") }}</td>
                            </tr> --}}

                        </table>
                      

                    </div>

                </div>

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_category'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div><label class="text-bold">@lang('shop_admin.title_company_name'):</label> <span>{{ $productDATA->cat_name }}</span></div>
                        
                    </div>


                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_manufacturer'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div><label class="text-bold">@lang('shop_admin.title_manufacturer_name'):</label> <span>{{ $productDATA->mnf_name }} ({{ $productDATA->mnf_id }})</span></div>
                        <div><label class="text-bold">@lang('shop_admin.title_manufacturer_import_id'):</label> <span>{{ $productDATA->mnf_import_id }}</span></div>
                        
                    </div>

                </div>

                @if (!$productAttributes->isEmpty())
                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_attributes'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        @foreach ($productAttributes as $key => $attributeDATA)
                            <div>
                                <label class="text-bold">{{ $attributeDATA[0]->attr_name }}</label>:

                                @php
                                    $values = '';

                                    foreach ($attributeDATA as $attrKey => $attr):

                                        if ($attr->attr_type == 7):
                                            $values .= '<span class="btn mar_l_10 mar_r_10" style="background-color: '.$attr->attr_value.'"></span>';
                                        else:
                                            $values .= $attr->attr_label.', ';
                                        endif;

                                    endforeach;

                                    if ($attr->attr_type != 7):
                                        $values = substr($values, 0, -2);
                                    endif;

                                @endphp

                                {!! $values !!}

                            </div>
                        @endforeach
                        
                    </div>

                </div>
                @endif

                @if($productRate)
                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_product_rate'):</h3>
                    </div>
                    
                    <div class="panel-body" style="padding-top:0;">
                        <div>
                            <label class="text-bold">@lang('shop_admin.title_product_rate'):</label> {{ round($productRate) }}
                        </div>
                    </div>

                </div>
                @endif

                @if($ratingComments)
                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_product_comments'):</h3>
                    </div>
                    
                    <div class="panel-body" style="padding-top:0;">

                        <table class="table_v1" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@lang('shop_admin.title_customer')</th>
                                    <th>@lang('shop_admin.title_rate')</th>
                                    <th>@lang('shop_admin.title_product_rate_value')</th>
                                    <th>@lang('shop_admin.title_comments')</th>
                                    <th>@lang('shop_admin.title_comment_status')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ratingComments as $cKey => $comment)
                                <td class="text-center">{{ $comment->u_name }} {{ $comment->u_last_name }}</td>
                                <td class="text-center">{{ $comment->ro_name }}</td>
                                <td class="text-center">{{ $comment->rv_rating_value }}</td>
                                <td class="text-center">{{ $comment->rv_comment }}</td>
                                <td class="text-center">
                                    @if($comment->rv_comment_status == 1)
                                        <span class="label label-info">@lang('shop_admin.title_on')</span>
                                    @else
                                        <span class="label label-warning">@lang('shop_admin.title_off')</span>
                                    @endif
                                </td>
                                <td class="text-center"><a class="btn btn-warning btnSmall" href="/{{ setting('admin.adm_url') }}/rating-votes/{{ $comment->rv_id }}"><i class="voyager-edit"></i></a></td>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>
                @endif


                @if($badgeForProduct || !$specialDisplayOptionsForProduct->isEmpty())
                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    @if($badgeForProduct)
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">@lang('shop_admin.title_product_badges'):</h3>
                        </div>
                        
                        <div class="panel-body" style="padding-top:0;">
                            <div>
                                <label class="text-bold">@lang('shop_admin.title_product_badges'):</label> {{ $badgeForProduct->b_title }} (<span class="small">{{ $badgeForProduct->b_description }}</span>)
                            </div>
                        </div>
                    @endif

                    @if (!$specialDisplayOptionsForProduct->isEmpty())
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">@lang('shop_admin.title_special_display_options'):</h3>
                        </div>

                        <div class="panel-body" style="padding-top:0;">
                        @foreach ($specialDisplayOptionsForProduct as $key => $displayOption)
                            <div>
                                <label class="text-bold">{{ $displayOption->title }}</label> (<span class="small">{{ $displayOption->description }}</span>)
                            </div>
                        @endforeach
                        </div>
                    @endif

                </div>
                @endif


            </div>

            <div class="col-md-6">

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_image'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div>
                            @if ($productDATA->prod_image != null)
                            <img src="/storage/products/{{ $productDATA->prod_image }}" class="img100">
                            @endif
                        </div>
                        
                    </div>

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_video'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        <div>
                            @if ($productDATA->prod_video != null)
                                <label class="text-bold mar_b_10">@lang('shop_admin.title_video_code'):</label> <span>{{ $productDATA->prod_video }}</span>

                                <div class="ytEmbedContainter mar_b_10">
                                    <iframe width="100%" height="auto"
                                    src="https://www.youtube.com/embed/{{ $productDATA->prod_video }}">
                                    </iframe>
                                </div>
                            @endif
                        </div>
                        
                    </div>


                </div>

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">@lang('shop_admin.title_product_gallery'):</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">

                        @if ($productGallery)
                            @foreach ($productGallery as $image)
                                <img src="/storage/{{ $image->pi_image }}" class="img25">
                            @endforeach
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


@php
// echo '<pre>';
// print_r($productRate);
// print_r($specialDisplayOptionsForProduct);
// echo '</pre>';
@endphp

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
