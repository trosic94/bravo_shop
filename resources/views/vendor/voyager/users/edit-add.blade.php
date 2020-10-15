@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}


            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                    {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-7">

                                    <h4>@lang('shop_admin.title_user_data')</h4>

                                    <div class="form-group">
                                        <label for="name">@lang('shop_admin.title_firstname')</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $dataTypeContent->name ?? '' }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name">@lang('shop_admin.title_lastname')</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $dataTypeContent->last_name ?? '' }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">@lang('shop_admin.title_email')</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $dataTypeContent->email ?? '' }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">@lang('shop_admin.title_phone')</label>
                                        <input type="phone" class="form-control" id="phone" name="phone" value="{{ $dataTypeContent->phone ?? '' }}">
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label for="address">@lang('shop_admin.title_address')</label>
                                        <input type="address" class="form-control" id="address" name="address" value="{{ $dataTypeContent->address ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="zip">@lang('shop_admin.title_postal_code')</label>
                                        <input type="zip" class="form-control" id="zip" name="zip" value="{{ $dataTypeContent->zip ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="city">@lang('shop_admin.title_city')</label>
                                        <input type="city" class="form-control" id="city" name="city" value="{{ $dataTypeContent->city ?? '' }}">
                                    </div>

                                    <hr>

                                    <h4>@lang('shop_admin.title_company_data')</h4>
                                
                                    <div class="form-group">
                                        <label for="name">@lang('shop_admin.title_company_name')</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="" value="{{ $dataTypeContent->company_name ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">@lang('shop_admin.title_company_address')</label>
                                        <input type="text" class="form-control" id="company_address" name="company_address" placeholder="" value="{{ $dataTypeContent->company_address ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">@lang('shop_admin.title_company_postal_code')</label>
                                        <input type="text" class="form-control" id="company_zip" name="company_zip" placeholder="" value="{{ $dataTypeContent->company_zip ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="company_city">@lang('shop_admin.title_company_city')</label>
                                        <input type="text" class="form-control" id="company_city" name="company_city" placeholder="" value="{{ $dataTypeContent->company_city ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">@lang('shop_admin.title_company_phone')</label>
                                        <input type="text" class="form-control" id="company_phone" name="company_phone" placeholder="" value="{{ $dataTypeContent->company_phone ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">@lang('shop_admin.title_company_email')</label>
                                        <input type="text" class="form-control" id="company_email" name="company_email" placeholder="" value="{{ $dataTypeContent->company_email ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">@lang('shop_admin.title_company_vat')</label>
                                        <input type="text" class="form-control" id="company_vat" name="company_vat" placeholder="" value="{{ $dataTypeContent->company_vat ?? '' }}">
                                    </div>


                                </div>

                                <div class="col-md-5">

                                    <h4>@lang('shop_admin.title_loyalty')</h4>

                                    <div class="form-group">
                                        <label for="loy_barcode">@lang('shop_admin.title_loyalty_barcode')</label>
                                        <input type="text" class="form-control" id="loy_barcode" name="loy_barcode" value="{{ $dataTypeContent->loy_barcode ?? '' }}">
                                    </div>

                                    <hr>

                                    <h4>@lang('shop_admin.title_user_role')</h4>

                                    @can('editRoles', $dataTypeContent)
                                        <div class="form-group">
                                            <label for="default_role">{{ __('voyager::profile.role_default') }}</label>
                                            @php
                                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                                                $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                                $options = $row->details;
                                            @endphp
                                            @include('voyager::formfields.relationship')
                                        </div>
{{--                                         <div class="form-group">
                                            <label for="additional_roles">{{ __('voyager::profile.roles_additional') }}</label>
                                            @php
                                                $row     = $dataTypeRows->where('field', 'user_belongstomany_role_relationship')->first();
                                                $options = $row->details;
                                            @endphp
                                            @include('voyager::formfields.relationship')
                                        </div> --}}

                                        <script type="text/javascript">
                                            $( document ).ready(function() {
                                                $('select[name=role_id]').prop('required',true);
                                            });
                                        </script>

                                    @endcan

                                    <hr>

                                    <h4>@lang('shop_admin.title_user_discount')</h4>

                                    <div class="form-group">
                                        <label for="discount">@lang('shop_admin.title_discount') (%)</label>
                                        <input type="text" class="form-control" id="discount" name="discount" value="{{ $dataTypeContent->discount ?? '' }}">
                                    </div>

                                    <hr>

                                    <h4>@lang('shop_admin.title_password')</h4>

                                    <div class="form-group">
                                        <label for="password">{{ __('voyager::generic.password') }}</label>
                                        @if(isset($dataTypeContent->password))
                                            <br>
                                            <small>{{ __('voyager::profile.password_hint') }}</small>
                                        @endif
                                        <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password" {{ ($dataTypeContent->password == null)? 'required':''  }}>
                                    </div>

                                    <hr>

                                    <h4>@lang('shop_admin.title_image')</h4>

                                    <div class="form-group">
                                        @if(isset($dataTypeContent->avatar))
                                            <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                        @endif
                                        <input type="file" data-name="avatar" name="avatar">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        </div>

                    </div>
                </div>

            </div>

        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
@stop