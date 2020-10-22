<div class="col-auto pl-1 pl-sm-2 pr-1 pr-sm-1">
	<a id="myProfile" class="rounded-pill profileLNK justify-content-md-center" href="/profil" @auth data-toggle="modal" data-target="#myProfileModal" @endauth>
		<div class="row">
		<div class="col-auto p-0">
			<img class="" src="/images/header/moj-profil-icon.svg" alt="Moj profil">
		</div>
		{{-- <div class="col-auto pl-1 pr-0 d-none d-lg-block">
			{{ $userDATA['msg'] }}
		</div> --}}
		</div>
	</a>
</div>

@auth
 <div class="modal fade right" id="myProfileModal" tabindex="-1" role="dialog" aria-labelledby="myProfileModal" aria-hidden="true">
   <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">

     <div class="modal-content">

       <div class="modal-header">
         <p class="heading lead">@lang('shop.profile_title')</p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>

       <div id="profilDATA" class="modal-body">

          <h3>{{ $userDATA['customer']['name'] }} {{ $userDATA['customer']['last_name'] }}</h3>

			<hr>

			<h5>@lang('shop.profile_order_overview')</h5>

          <table class="table table-sm">
            <tbody>
            @foreach ($userDATA['orders'] as $key => $order)

              <tr>
                <td><a href="/profil/order-details/{{ $order->id }}" class="orderToolTip" data-placement="right" data-toggle="tooltip" title="{{ $order->order_status_title }}">{{ $order->order_number }}</a></td>
                <td>{{ date('d.m.Y', strtotime($order->created_at)) }}</td>
                <td class="text-right">{{ number_format($order->total,0,"",".") }} {{ setting('shop.valuta') }}</td>
              </tr>

            @endforeach
            </tbody>
          </table>

        	<hr>

{{--           <div>
            {{ $userDATA['loy'] }}
          </div> --}}



@php
// echo '<pre>';
// print_r($userDATA['loy']);
// echo '</pre>';
@endphp



       </div>

       <div class="modal-footer justify-content-center">
         <a id="btnProfil" type="button" class="btn rounded-pill" href="/profil">@lang('shop.profile_title')</a>
         <a id="btnLogout" type="button" class="btn rounded-pill" href="/logout">@lang('shop.btn_logout')</a>
       </div>

     </div>

   </div>
 </div>

<script type="text/javascript">
  toolTipINIT('orderToolTip');
</script>


@endauth