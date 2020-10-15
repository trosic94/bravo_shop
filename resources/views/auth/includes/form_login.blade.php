                                <form class="needs-validation" method="POST" action="{{ route('login') }}" novalidate>

                                {{ csrf_field() }}

                                    <div class="md-form mt-3">
                                        <input type="text" name="email" id="formEMAIL" class="form-control" value="{{ old('email') }}" autocomplete="off" required>
                                        <label for="formEMAIL">@lang('shop.login_email')</label>
                                        @if ($errors->has('email'))
                                            <div class="formERR">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="md-form mt-3">
                                        <input type="password" name="password" id="formPASSWORD" class="form-control" autocomplete="off" required>
                                        <label for="formPASSWORD">@lang('shop.login_password')</label>
                                        @if ($errors->has('password'))
                                            <div class="formERR">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="formREMEMBER" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="formREMEMBER">@lang('shop.login_remember')</label>
                                    </div>

                                    <button type="submit" class="btn btnPink rounded-pill btn-block my-4">@lang('shop.btn_user_login')</button>
                                    
                                    <a class="formLNK" href="{{ route('password.request') }}">@lang('shop.login_forgot_password')</a>

                                </form>