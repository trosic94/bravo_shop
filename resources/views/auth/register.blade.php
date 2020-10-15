
@extends ('includes.page')

@section ('content')


<div id="pageWrap">

    <div class="mainTitle mt-3 mt-lg-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
        <h1>@lang('shop.register_title')</h1>
    </div>

    <div class="row mt-5 mb-5">

        <div class="col-xl-12">

            @include('auth.includes.form_register')

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
