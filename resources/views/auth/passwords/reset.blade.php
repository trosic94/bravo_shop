@extends ('includes.page')

@section ('content')

<div id="pageWrap">

    <div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
        <h1>@lang('shop.email_create_pass_title')</h1>
    </div>

    <div class="row mt-5">

        <div class="col-xl-6 col-md-6">
            <p>@lang('shop.email_create_pass_txt_1')</p>
            <p>@lang('shop.email_create_pass_txt_2')</p>
        </div>

        <div class="col-xl-6 col-md-6 mb-5 mb-md-0">

            <form class="needs-validation" method="POST" action="{{ route('password.request') }}" novalidate>

            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="md-form mt-3">
                <input type="text" name="email" id="formEMAIL" class="form-control" value="{{ old('email') }}" autocomplete="off" required>
                <label for="formEMAIL">@lang('shop.register_email')*</label>
                {!! $errors->first('email', '<div class="formERR">:message</div>') !!}
            </div>

            <div class="md-form mt-3">
                <input type="password" name="password" id="formPASSWORD" class="form-control" autocomplete="off" required>
                <label for="formPASSWORD">@lang('shop.register_password')*</label>
                <div class="formERR">{{ $errors->first('password') }}</div>
            </div>

            <div class="md-form mt-3">
                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" autocomplete="off" required>
                <label for="password-confirm">@lang('shop.register_password_repeat')*</label>
            </div>

            <button type="submit" class="btn btn-info btn-block my-4">@lang('shop.btn_confirm')</button>

            </form>


        </div>

    </div>

</div>

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

@endsection
