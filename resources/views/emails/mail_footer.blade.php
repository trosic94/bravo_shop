			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#231f20">
				<tr bgcolor="#231f20">
					<td>
					<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
						<tr>
							<td style="color: #ffffff; font-size: 14px; font-family: Arial, Helvetica, sans-serif; padding: 10px 0; text-align: center;">
							<h2 style="margin: 0; padding: 0; font-size: 18px; color: #e31a51; font-weight: bold; text-align: center;">{{ setting('company.company_name') }}</h2>
							&nbsp;<br>
							<span style="color: #e31a51; font-weight: bold;">@lang('shop.email_address_f')</span> {{ setting('company.company_address') }}, {{ setting('company.company_postal_code') }} {{ setting('company.company_city') }}, {{ setting('company.company_country') }}&nbsp;&nbsp;&nbsp;<span style="color: #e31a51; font-weight: bold;">@lang('shop.email_pib')</span> {{ setting('company.company_pib') }}<br>
							<span style="color: #e31a51; font-weight: bold;">@lang('shop.email_phone_f')</span> {{ setting('company.company_phone') }}&nbsp;&nbsp;&nbsp;<span style="color: #e31a51; font-weight: bold;">@lang('shop.email_email_f')</span> <a href="mailto:{{ setting('company.company_email') }}" style="text-decoration: none; color: #ffffff; font-weight: bold;">{{ setting('company.company_email') }}</a>&nbsp;&nbsp;&nbsp;<span style="color: #e31a51; font-weight: bold;">&nbsp;&nbsp;&nbsp;<span style="color: #e31a51; font-weight: bold;">@lang('shop.email_web_f')</span> </span> <a href="https://{{ setting('company.company_web') }}" style="text-decoration: none; color: #ffffff; font-weight: bold;">{{ setting('company.company_web') }}</a>
							&nbsp;<br>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

		</body>
		</html>