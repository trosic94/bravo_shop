		<html>
		
		<head>
			<meta charset="utf-8">
			<title>{{ setting('company.company_name') }}</title>
		</head>

		<body style="margin: 0; padding: 0;">

			<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
				<tr>
					<td style="padding: 10px; text-align: left;"><a href="{{ setting('site.site_url') }}" target="_blank" title="{{ setting('company.company_name') }}"><img src="{{ setting('site.site_url') }}/storage/{{ setting('site.logo') }}" alt="{{ setting('company.company_name') }}"></a></td>
					<td style="padding: 10px; text-align: right;">
						<a href="{{ setting('site.facebook') }}" target="_blank" title="{{ setting('company.company_name') }}"><img src="{{ setting('site.site_url') }}/storage/{{ setting('site.fb_icon') }}" alt="{{ setting('company.company_name') }} - Facebook"></a>&nbsp;
						<a href="{{ setting('site.instagram') }}" target="_blank" title="{{ setting('company.company_name') }}"><img src="{{ setting('site.site_url') }}/storage/{{ setting('site.ig_icon') }}" alt="{{ setting('company.company_name') }} - Instagram"></a>
					</td>
				</tr>
			</table>