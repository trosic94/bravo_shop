@include('emails.mail_header')

			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#231f20">
				<tr bgcolor="#231f20">
					<td>
					<table border="0" cellpadding="0" cellspacing="0" width="540" align="center">
						<tr>
							<td width="50%" style="color: #ffffff; text-transform: uppercase; font-size: 18px; padding: 5px 10px; font-family: Arial, Helvetica, sans-serif;">@lang('shop.email_reset_pass_title')</td>
							<td width="50%" style="color: #ffffff; text-transform: uppercase; font-size: 18px; padding: 5px 10px; font-family: Arial, Helvetica, sans-serif; text-align: right;"></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

			&nbsp;<br>
			<table cellpadding="0" cellspacing="0" width="600" align="center">
				<tr>
					<td style="padding: 25px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #231f20;">
					@lang('shop.title_hello'),
					<br>
					<br>
					@lang('shop.email_reset_pass_1')<br>
					<br>
					@lang('shop.email_reset_pass_2') <a href="{{ $resetLNK }}" target="_blank" style="text-decoration: none; color: #0DACD2; font-weight: bold;">@lang('shop.title_link')</a>.<br>
					<br>
					@lang('shop.email_reset_pass_3')<br>
					<br>
					<br>
					@lang('shop.email_reset_pass_4')<br>
					<a href="{{ $resetLNK }}" target="_blank" style="text-decoration: none; color: #0DACD2; font-weight: bold;">{{ $resetLNK }}</a>
					</td>
				</tr>
			</table>
			&nbsp;<br>

@include('emails.mail_footer')