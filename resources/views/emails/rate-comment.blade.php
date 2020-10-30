@include('emails.mail_header')

			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#231f20">
				<tr bgcolor="#231f20">
					<td>
					<table border="0" cellpadding="0" cellspacing="0" width="540" align="center">
						<tr>
							<td width="50%" style="color: #ffffff; text-transform: uppercase; font-size: 18px; padding: 5px 10px; font-family: Arial, Helvetica, sans-serif;">@lang('shop.email_rate_comment_title')</td>
							<td width="50%" style="color: #ffffff; text-transform: uppercase; font-size: 18px; padding: 5px 10px; font-family: Arial, Helvetica, sans-serif; text-align: right;">{{ $dateTime }}</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

			&nbsp;<br>
			<table cellpadding="0" cellspacing="0" width="768" align="center">
				<tr>
					<td style="padding: 25px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #231f20;">
					@lang('shop.email_hello'),
					<br>
					<br>
					@lang('shop.email_rate_comment_confirmation_txt1') <strong>{{ $customer->name }} {{ $customer->last_name }}</strong> @lang('shop.email_rate_comment_confirmation_txt2') <strong>{{ $product->title }}</strong>!<br>
					<br>
					@lang('shop.email_rate_comment_confirmation_comment_content'):<br>
					<i>"{!! $comment !!}"</i><br>
					<br>
					<br>
					@lang('shop.email_rate_comment_confirmation_approve') <a href="{{ setting('site.site_url') }}/{{ setting('admin.adm_url') }}/products/{{ $product->id }}" target="_blank" style="text-decoration: none; color: #e31a51; font-weight: bold;">@lang('shop.email_rate_comment_confirmation_approve_link')</a>.
					</td>
				</tr>
			</table>
			&nbsp;<br>

@include('emails.mail_footer')