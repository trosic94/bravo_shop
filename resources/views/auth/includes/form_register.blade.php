                        <form class="needs-validation" method="POST" action="{{ route('register') }}" novalidate>

                        {{ csrf_field() }}

                        <div class="row">

                            <div class="col-xl-6 col-lg-6">

                                <h3 class="subTitle">@lang('shop.register_pesonal_details')</h3>

                                <div class="row">

                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="name" id="formNAME" class="form-control" value="{{ old('name') }}" autocomplete="off" required>
                                            <label for="formNAME">@lang('shop.register_name')*</label>
                                            @if ($errors->has('name'))
                                                <div class="formERR">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    
                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="last_name" id="formLASTNAME" class="form-control" value="{{ old('last_name') }}" autocomplete="off" required>
                                            <label for="formLASTNAME">@lang('shop.register_last_name')*</label>
                                            @if ($errors->has('last_name'))
                                                <div class="formERR">{{ $errors->first('last_name') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="email" id="formEMAIL" class="form-control" value="{{ old('email') }}" autocomplete="off" required>
                                            <label for="formEMAIL">@lang('shop.register_email')*</label>
                                            @if ($errors->has('email'))
                                                <div class="formERR">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    
                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="phone" id="formPHONE" class="form-control" value="{{ old('phone') }}" autocomplete="off">
                                            <label for="formPHONE">@lang('shop.register_phone')</label>
                                            @if ($errors->has('phone'))
                                                <div class="formERR">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <hr>

                                <div class="md-form mt-3">
                                    <input type="text" name="loy_barcode" id="formLOY" class="form-control" value="{{ old('loy_barcode') }}" autocomplete="off">
                                    <label for="formLOY">@lang('shop.title_loyalty') (@lang('shop.title_loyalty_barcode'))</label>
                                    @if ($errors->has('loy_barcode'))
                                        <div class="formERR">{{ $errors->first('loy_barcode') }}</div>
                                    @endif
                                </div>

                                <hr>

                                <div class="md-form mt-3">
                                    <input type="text" name="address" id="formADDRESS" class="form-control" value="{{ old('address') }}" autocomplete="off">
                                    <label for="formADDRESS">@lang('shop.register_address')</label>
                                    @if ($errors->has('address'))
                                        <div class="formERR">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>

                                <div class="row">

                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="zip" id="formZIP" class="form-control" value="{{ old('zip') }}" autocomplete="off">
                                            <label for="formZIP">@lang('shop.register_zip')</label>
                                            @if ($errors->has('zip'))
                                                <div class="formERR">{{ $errors->first('zip') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    
                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="city" id="formCITY" class="form-control" value="{{ old('city') }}" autocomplete="off">
                                            <label for="formCITY">@lang('shop.register_city')</label>
                                            @if ($errors->has('city'))
                                                <div class="formERR">{{ $errors->first('city') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="password" name="password" id="formPASSWORD" class="form-control" autocomplete="off" required>
                                            <label for="formPASSWORD">@lang('shop.register_password')*</label>
                                            @if ($errors->has('password'))
                                                <div class="formERR">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    
                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="password" name="password_confirmation" id="password-confirm" class="form-control" autocomplete="off" required>
                                            <label for="password-confirm">@lang('shop.register_password_repeat')*</label>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-6 col-lg-6">

                                <h3 class="subTitle">@lang('shop.register_company_details')</h3>

                                <div class="md-form mt-3">
                                    <input type="text" name="company_name" id="formCOMPANYNAME" class="form-control" value="{{ old('company_name') }}" autocomplete="off">
                                    <label for="formCOMPANYNAME">@lang('shop.register_name')</label>
                                    @if ($errors->has('company_name'))
                                        <div class="formERR">{{ $errors->first('register_company_name') }}</div>
                                    @endif
                                </div>

                                <div class="md-form mt-3">
                                    <input type="text" name="company_vat" id="formCOMPANYVAT" class="form-control" value="{{ old('company_vat') }}" autocomplete="off">
                                    <label for="formCOMPANYVAT">@lang('shop.register_company_vat')</label>
                                    @if ($errors->has('company_vat'))
                                        <div class="formERR">{{ $errors->first('company_vat') }}</div>
                                    @endif
                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="company_email" id="formCOMPANYEMAIL" class="form-control" value="{{ old('company_email') }}" autocomplete="off">
                                            <label for="formCOMPANYEMAIL">@lang('shop.register_company_email')</label>
                                            @if ($errors->has('company_email'))
                                                <div class="formERR">{{ $errors->first('company_email') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    
                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="company_phone" id="formCOMPANYPHONE" class="form-control" value="{{ old('company_phone') }}" autocomplete="off">
                                            <label for="formCOMPANYPHONE">@lang('shop.register_company_phone')</label>
                                            @if ($errors->has('company_phone'))
                                                <div class="formERR">{{ $errors->first('company_phone') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <hr>

                                <div class="md-form mt-3">
                                    <input type="text" name="company_address" id="formCOMPANYADDRESS" class="form-control" value="{{ old('company_address') }}" autocomplete="off">
                                    <label for="formCOMPANYADDRESS">@lang('shop.register_company_address')</label>
                                    @if ($errors->has('company_address'))
                                        <div class="formERR">{{ $errors->first('company_address') }}</div>
                                    @endif
                                </div>

                                <div class="row">

                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="company_zip" id="formCOMPANYZIP" class="form-control" value="{{ old('company_zip') }}" autocomplete="off">
                                            <label for="formCOMPANYZIP">@lang('shop.register_company_zip')</label>
                                            @if ($errors->has('company_zip'))
                                                <div class="formERR">{{ $errors->first('company_zip') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    
                                    <div class="col-xl-6">

                                        <div class="md-form mt-3">
                                            <input type="text" name="company_city" id="formCOMPANYCITY" class="form-control" value="{{ old('company_city') }}" autocomplete="off">
                                            <label for="formCOMPANYCITY">@lang('shop.register_company_city')</label>
                                            @if ($errors->has('company_city'))
                                                <div class="formERR">{{ $errors->first('company_city') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <hr>

                                <div class="row mt-4">

                                    <div class="col-xl-12">

                                        <div class="form-check">
                                            <input type="checkbox" name="newsletter_subscriber" class="form-check-input" id="NLSubscriber" {{ old('newsletter_subscriber') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="NLSubscriber">@lang('shop.title_newsletter_want_to_subscribe')</label>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-6"></div>

                            <div class="col-xl-6">
                                
                                <button type="submit" class="btn btn-block rounded-pill btnPink my-4">@lang('shop.btn_register')</button>

                            </div>
                        </div>

                        </form>