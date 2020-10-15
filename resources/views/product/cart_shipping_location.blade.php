                            <div class="col-xl-12">

                                @if (Auth::guest())

                                    <div class="card mb-4">

                                        <div class="card-header">
                                            <h4 class="card-title m-0">@lang('shop.login_title') & @lang('shop.register_title')</h4>
                                        </div>

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-6 mb-5 mb-lg-0">

                                                    <h3>@lang('shop.login_title')</h3>

                                                    @include('auth.includes.form_login')


                                                    <script type="text/javascript">
                                                    (function() {
                                                    'use strict';
                                                    window.addEventListener('load', function() {
                                                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                                    var forms = document.getElementsByClassName('needs-validation');
                                                    // Loop over them and prevent submission
                                                    var validation = Array.prototype.filter.call(forms, function(form) {
                                                    form.addEventListener('submit', function(event) {
                                                    if (form.checkValidity() === false) {
                                                    event.preventDefault();
                                                    event.stopPropagation();
                                                    }
                                                    form.classList.add('was-validated');
                                                    }, false);
                                                    });
                                                    }, false);
                                                    })();
                                                    </script>

                                                </div>
                                                <div class="col-lg-6">

                                                     <h3 class="mb-3">@lang('shop.register_title')</h3>

                                                     @lang('shop.my_cart_shipping_register')

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                @else

                                    <div class="card mb-4">

                                        <div class="card-header">
                                            <h4 class="card-title font-weight-bold">@lang('shop.my_cart_shipping_location')</h4>
                                        </div>

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-6 mb-5 mb-lg-0">
                                                    
                                                    <div id="cartUserDATA">

                                                        <div class="form-check pl-0 mb-3">
                                                            <input type="radio" class="form-check-input" id="cartShippingOptionUnchecked" name="cart_shipping_address_option" value="profil" checked>
                                                            <label class="form-check-label" for="cartShippingOptionUnchecked">Informacije sa profila</label>
                                                        </div>

                                                        <ul>
                                                            <li class="mb-2"><label>Ime</label>: <span>{{ $ulogovan->name }} {{ $ulogovan->last_name }}</span></li>
                                                            <li><label>Adresa</label>: <span>{{ $ulogovan->address }}</span></li>
                                                            <li><label>Poštanski broj</label>: <span>{{ $ulogovan->zip }}</span></li>
                                                            <li class="mb-2"><label>Mesto</label>: <span>{{ $ulogovan->city }}</span></li>
                                                            <li><label>Telefon</label>: <span>{{ $ulogovan->phone }}</span></li>
                                                            <li><label>E-mail</label>: <span>{{ $ulogovan->email }}</span></li>
                                                        </ul>

                                                    </div>

                                                </div>
                                                <div class="col-lg-6">

                                                    <div id="cartUserNewShipping">
                                                    
                                                        <div class="form-check pl-0 mb-3">
                                                            <input type="radio" class="form-check-input" id="cartShippingOptionChecked" name="cart_shipping_address_option" value="other">
                                                            <label class="form-check-label" for="cartShippingOptionChecked">Nova adresa</label>
                                                        </div>

                                                        <div class="row">

                                                            <div class="col-xl-6">

                                                                <div class="md-form mt-3">
                                                                    <input type="text" name="cart_new_shp_name" id="formNAME" class="form-control" value="{{ $ulogovan->name }}" autocomplete="off" required>
                                                                    <label for="formNAME">@lang('shop.register_name')*</label>
                                                                    @if ($errors->has('name'))
                                                                        <div class="formERR">{{ $errors->first('name') }}</div>
                                                                    @endif
                                                                </div>

                                                            </div>

                                                            <div class="col-xl-6">

                                                                <div class="md-form mt-3">
                                                                    <input type="text" name="cart_new_shp_last_name" id="formLASTNAME" class="form-control" value="{{ $ulogovan->last_name }}" autocomplete="off" required>
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
                                                                <input type="text" name="cart_new_shp_email" id="formEMAIL" class="form-control" value="{{ $ulogovan->email }}" autocomplete="off" required>
                                                                <label for="formEMAIL">@lang('shop.register_email')*</label>
                                                                @if ($errors->has('email'))
                                                                    <div class="formERR">{{ $errors->first('email') }}</div>
                                                                @endif
                                                            </div>

                                                            </div>

                                                            <div class="col-xl-6">

                                                            <div class="md-form mt-3">
                                                                <input type="text" name="cart_new_shp_phone" id="formPHONE" class="form-control" value="{{ old('phone') }}" autocomplete="off" required>
                                                                <label for="formPHONE">@lang('shop.register_phone')</label>
                                                                @if ($errors->has('phone'))
                                                                    <div class="formERR">{{ $errors->first('phone') }}</div>
                                                                @endif
                                                            </div>

                                                            </div>

                                                        </div>

                                                            <div class="md-form mt-3">
                                                                <input type="text" name="cart_new_shp_address" id="formADDRESS" class="form-control" value="{{ old('address') }}" autocomplete="off" required>
                                                                <label for="formADDRESS">@lang('shop.register_address')</label>
                                                                @if ($errors->has('address'))
                                                                    <div class="formERR">{{ $errors->first('address') }}</div>
                                                                @endif
                                                            </div>

                                                        <div class="row">

                                                            <div class="col-xl-6">

                                                            <div class="md-form mt-3">
                                                                <input type="text" name="cart_new_shp_zip" id="formZIP" class="form-control" value="{{ old('zip') }}" autocomplete="off" required>
                                                                <label for="formZIP">@lang('shop.register_zip')</label>
                                                                @if ($errors->has('zip'))
                                                                    <div class="formERR">{{ $errors->first('zip') }}</div>
                                                                @endif
                                                            </div>

                                                            </div>

                                                            <div class="col-xl-6">

                                                            <div class="md-form mt-3">
                                                                <input type="text" name="cart_new_shp_city" id="formCITY" class="form-control" value="{{ old('city') }}" autocomplete="off" required>
                                                                <label for="formCITY">@lang('shop.register_city')</label>
                                                                @if ($errors->has('city'))
                                                                    <div class="formERR">{{ $errors->first('city') }}</div>
                                                                @endif
                                                            </div>

                                                            </div>

                                                        </div>


                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                @endif
@php
// echo '<pre class="text-white">';
// print_r($ulogovan);
// echo '</pre>';
@endphp

                            </div>
