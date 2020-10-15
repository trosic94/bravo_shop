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

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="user_id_TMP">@lang('shop_admin.title_customer')</label>
                                        <input class="form-control" type="text" name="user_id_TMP" placeholder="" value="{{ $orderDATA->usr_name }} {{ $orderDATA->usr_last_name }}" readonly>
                                        <input type="hidden" name="user_id" value="{{ $orderDATA->usr_id }}">

                                    </div>

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="order_number">@lang('shop_admin.title_order_number')</label>
                                        <input class="form-control" type="text" name="order_number" placeholder="" value="{{ $orderDATA->ord_order_number }}" required="">

                                    </div>

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="order_invoice">@lang('shop_admin.title_invoice_number')</label>
                                        <input class="form-control" type="text" name="order_invoice" placeholder="" value="{{ $orderDATA->ord_invoice }}" required="">

                                    </div>

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="proforma_invoice">@lang('shop_admin.title_proforma_invoice')</label>
                                        <input class="form-control" type="text" name="proforma_invoice" placeholder="" value="{{ $orderDATA->ord_proforma_invoice }}" required="">

                                    </div>

                                    <hr>

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="created_at_TMP">@lang('shop_admin.title_created_at')</label>
                                        <input class="form-control" type="text" name="created_at_TMP" placeholder="" value="{{ date('d.m.Y H:i:s', strtotime($orderDATA->ord_created_at)) }}" readonly>
                                        <input type="hidden" name="created_at" value="{{ $orderDATA->ord_created_at }}">

                                    </div>

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="updated_at_TMP">@lang('shop_admin.title_updated_at')</label>
                                        <input class="form-control" type="text" name="updated_at_TMP" placeholder="" value="{{ (strtotime($orderDATA->ord_updated_at) != '')? date('d.m.Y H:i:s', strtotime($orderDATA->ord_updated_at)):'' }}" readonly>
                                        <input type="hidden" name="updated_at" value="{{ $orderDATA->ord_updated_at }}">

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="rabat">@lang('shop_admin.title_discount')</label>
                                        <input class="form-control" type="text" name="rabat" placeholder="" value="{{ $orderDATA->ord_rabat }}" readonly>

                                    </div>

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="total">@lang('shop_admin.title_total')</label>
                                        <input class="form-control" type="text" name="total" placeholder="" value="{{ number_format($orderDATA->ord_total,2,".","") }}" readonly>

                                    </div>

                                    <hr>

                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="order_status">@lang('shop_admin.title_order_Status')</label>
                                        <select class="form-control" name="order_status">
                                            @foreach($orderSTatusALL as $status)
                                                <option value="{{ $status->id }}" {{ ($status->id == $orderDATA->ord_status_id)? 'selected':'' }}>{{ $status->title }}</option>
                                            @endforeach
                                        </select>

                                    </div>


                                    <div class="form-group col-md-12 ">

                                        <label class="control-label" for="payment_method_TMP">@lang('shop_admin.title_payment_method')</label>
                                        <input class="form-control" type="text" name="payment_method_TMP" placeholder="" value="{{ $orderDATA->ord_payment_method }}" readonly>
                                        <input type="hidden" name="payment_method" value="{{ $orderDATA->ord_payment_method_id }}">

                                    </div>




                                    @if ($orderDATA->ord_payment_method_id == 1)
                                    <div class="form-group col-md-12">

                                        <label class="control-label" for="merchantPaymentId">@lang('shop_admin.title_merchant_payment_id')</label>
                                        <input class="form-control" type="text" name="merchantPaymentId" placeholder="" value="{{ $orderDATA->ord_merchantPaymentId }}" readonly>

                                    </div>
                                    @endif
                                    
                                    <div class="form-group col-md-12">
                                        <label class="control-label" for="comment">@lang('shop_admin.title_comment')</label>
                                        <textarea class="form-control" name="comment" readonly>{{ $orderDATA->ord_merchantPaymentId }}</textarea>
                                    </div>


                                </div>

                            </div>

                        </div>

                        <div class="panel-footer">

                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>

                        </div>


                    </form>

                </div>




@php
    // echo '<pre>';
    // print_r($paymentMethodALL);
    // //print_r($orderSTatusALL);
    // print_r($orderDATA);
    // echo '</pre>';
@endphp



            </div>
        </div>
    </div>

@stop