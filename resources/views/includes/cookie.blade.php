@if (Cookie::get('kp_prvcy') == null)
<!--Modal: modalCookie-->
<div class="modal fade bottom" id="modalCookie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-frame modal-bottom modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Body-->
      <div class="modal-body">
        <div class="row d-flex justify-content-center align-items-center">

        	<div class="col-xl-6">
	          <p class="pt-3 pr-2">{!! setting('site.cookie_notice') !!}</p>
	          <a type="button" id="cookieConfirm" class="btn rounded-pill waves-effect" data-dismiss="modal" onclick="ckiPrvcy(event)">@lang('shop.btn_agree')</a>
      		</div>

        </div>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalCookie-->

<script type="text/javascript">
$(window).on('load', function() {
  $('#modalCookie').modal('show');
});
</script>
@endif