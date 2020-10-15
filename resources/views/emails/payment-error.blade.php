		<html>
		
		<head>
			<meta charset="utf-8">
			<title>Oznake - Neuspešno plaćanje</title>
		</head>

		<body style="margin: 0; padding: 0;">

			<table border="0" cellpadding="0" cellspacing="0" width="540" align="center">
				<tr>
					<td style="padding: 10px; text-align: left;"><a href="https://www.oznake.rs" target="_blank"><img src="https://www.oznake.rs/storage/settings/April2019/BeRfqZsLucNxuysVvsfZ.png" alt="Oznake.rs"></a></td>
					<td style="padding: 10px; text-align: right;">
						<a href="https://www.facebook.com" target="_blank"><img src="http://oznake.rs/images/header/ico-fb-crna.png" alt="Oznake - Facebook"></a>&nbsp;
						<a href="https://www.instagram.com" target="_blank"><img src="http://oznake.rs/images/header/ico-ins-crna.png" alt="Oznake - Instagram"></a>
					</td>
				</tr>
			</table>

			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#231f20">
				<tr bgcolor="#231f20">
					<td>
					<table border="0" cellpadding="0" cellspacing="0" width="540" align="center">
						<tr>
							<td style="color: #ffffff; text-transform: uppercase; font-size: 18px; padding: 5px 10px; font-family: Arial, Helvetica, sans-serif;">Neuspešno plaćanje</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

			&nbsp;<br>
			<table cellpadding="0" cellspacing="0" width="540" align="center">
				<tr>
					<td style="padding: 25px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #231f20;">
					Zdravo {{ $orders['customer_name'] }},
					<br>
					<br>
					Plaćanje nije uspešno, vaš račun nije zadužen.<br>
					Najčešći uzrok je pogrešno unet broj kartice, datum isteka ili sigurnosni kod.<br>
					Pokušajte ponovo, a u slučaju uzastopnih grešaka pozovite vašu banku.<br>
					<br>
					<strong>Kupac:</strong><br>
					Ime: {{ $orders['customer_name'] }}<br>
					Firma: {{ $orders['customer_company'] }}<br>
					Adresa: {{ $orders['customer_address'] }}<br>
					<br>
					@if ($orders['order_nacin_placanja'] == 1)
					<strong>Podaci o zahtevu za plaćanje:</strong><br>
					Broj narudžbine: {{ $transaction['pgOrderId'] }}<br>
					Status transakcije: {{ $transaction['responseMsg'] }}<br>
					Kod statusa transakcije: {{ $transaction['responseCode'] }}<br>
					Broj transakcije: {{ $transaction['pgTranId'] }}<br>
					Datum transakcije: 
					@if ($transaction['pgTranDate'])) != '')
						{{ date('d.m.Y H:i:s', strtotime($transaction['pgTranDate'])) }}
					@endif
					<br>
					Referentni ID transakcije: {{ $transaction['pgTranRefId'] }}<br>
					@endif
					<br>
					<br>
					Informacije o vašim porudžbinama i nalogu možete pronaći na sledećem <a href="https://www.oznake.rs/profil" target="_blank" style="text-decoration: none; color: #ffcb1f; font-weight: bold;">linku</a>.<br>
					<br>
					Hvala na poverenju<br>
					Vaš UltraPlanet<br>
					</td>
				</tr>
			</table>
			&nbsp;<br>

			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#231f20">
				<tr bgcolor="#231f20">
					<td>
					<table border="0" cellpadding="0" cellspacing="0" width="540" align="center">
						<tr>
							<td style="color: #ffffff; font-size: 14px; font-family: Arial, Helvetica, sans-serif; padding: 10px 0; text-align: center;">
							<h2 style="margin: 0; padding: 0; font-size: 18px; color: #ffcb1f; font-weight: bold;">UltraPlanet d.o.o.</h2>
							&nbsp;<br>
							Baranjska 53, 23000 Zrenjanin, Republika Srbija<br>
							<span style="color: #ffcb1f; font-weight: bold;">t.</span> 023 530 350&nbsp;&nbsp;&nbsp;<span style="color: #ffcb1f; font-weight: bold;">e.</span> <a href="mailto:info@ultra-planet.com" style="text-decoration: none; color: #ffffff; font-weight: bold;">info@ultra-planet.com</a>&nbsp;&nbsp;&nbsp;<span style="color: #ffcb1f; font-weight: bold;">w.</span> <a href="https://www.ultra-planet.com" style="text-decoration: none; color: #ffffff; font-weight: bold;">www.ultra-planet.com</a>
							&nbsp;<br>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

		</body>
		</html>