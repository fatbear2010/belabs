<?php use App\Http\Controllers\PinjamController; ?>
<?php use App\Http\Controllers\KeranjangController; ?>
<!DOCTYPE html>

<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
	<title></title>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
		<!--[if !mso]><!-->
			<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css"/>
			<!--<![endif]-->
				<style>
				* {
					box-sizing: border-box;
				}

				th.column {
					padding: 0
				}

				a[x-apple-data-detectors] {
					color: inherit !important;
					text-decoration: inherit !important;
				}

				#MessageViewBody a {
					color: inherit;
					text-decoration: none;
				}

				p {
					line-height: inherit
				}

				@media (max-width:640px) {
					.icons-inner {
						text-align: center;
					}

					.icons-inner td {
						margin: 0 auto;
					}

					.row-content {
						width: 100% !important;
					}

					.stack .column {
						width: 100%;
						display: block;
					}
				}
			</style>
		</head>
		<body style="background-color: #FFFFFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
			<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;" width="100%">
				<tbody>
					<tr>
						<td>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #333;" width="80%">
												<tbody>
													<tr>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-left: 10px; padding-right: 10px;" width="50%">
															<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																<tr>
																	<td style="padding-bottom:20px;padding-top:20px;width:100%;padding-right:0px;padding-left:0px;">
																		<div style="line-height:10px"><img alt="Image" src="https://ubaya.ac.id/2018/img/ubaya.png" style="display: block; height: auto; border: 0; width: 131px; max-width: 100%;" title="Image" width="131"/></div>
																	</td>
																</tr>
															</table>
														</th>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-left: 10px; padding-right: 10px;" width="50%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:20px;padding-top:20px;">
																		<div style="font-family: 'Times New Roman', Georgia, serif">
																			<div style="font-size: 12px; font-family: TimesNewRoman, 'Times New Roman', Times, Baskerville, Georgia, serif; color: #555555; line-height: 1.2;">
																				<p style="margin: 0; font-size: 14px; text-align: right;"><em>{{date("d-m-Y H:i:s")}}</em></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
												<tbody>
													<tr>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 0px;" width="100%">
															<table border="0" cellpadding="0" cellspacing="0" class="divider_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																<tr>
																	<td style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:10px;">
																		<div align="center">
																			<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																				<tr>
																					<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #222222;"><span></span></td>
																				</tr>
																			</table>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
												<tbody>
													<tr>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px;" width="100%">
															<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																<tr>
																	<td style="width:100%;padding-right:0px;padding-left:0px;">
																		<div align="center" style="line-height:10px"><img alt="Image" src="https://stefsk.com/api/okok.gif" style="display: block; height: auto; border: 0; width: 250px; max-width: 100%;" title="Image" width="250"/></div>
																	</td>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
												<tbody>
													<tr>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 10px;" width="100%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:10px;">
																		<div style="font-family: sans-serif">

																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0; text-align: center; font-size: 22px;"><span style="font-size:22px;"><strong>{{$pesan}}</strong></span></p>

																			</div>
																			<br>
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0; text-align: center; font-size: 12px;"><span style="font-size:22px;"><strong>Nomor Pemesanan</strong></span></p>
																				<p style="margin: 0; text-align: center; font-size: 50px;"><span style="font-size:50px;"><strong>{{$orderku[0]->idorder}}</strong></span></p>
																				<p style="margin: 0; text-align: center; font-size: 12px;"><span style="font-size:12px;"><strong>Waktu Pesanan Dibuat : {{$orderku['0']->tanggal}}</strong></span></p>
																			</div>

																		</div>
																	</td>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #000000; color: #333;" width="80%">
												<tbody>
													<tr>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px;" width="50%">
															<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="50%">
																<tr>
																	<td>
																		<div style="font-family: Tahoma, Verdana, sans-serif">
																			<div style="font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555; line-height: 1.2;">
																				<p style="margin: 0; font-size: 12px;"><span style="font-size:18px;color:#ffffff;"><strong>PEMESAN</strong></span></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px;" width="50%">
															<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="50%">
																<tr>
																	<td>
																		<div style="font-family: Tahoma, Verdana, sans-serif">
																			<div style="font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555; line-height: 1.2;">
																				<p style="margin: 0; font-size: 12px;"><span style="font-size:18px;color:#ffffff;"><strong>PENANGGUNGJAWAB</strong></span></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
												<tbody>
													<tr>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px;" width="50%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:10px;padding-left:20px;padding-right:20px;padding-top:10px;">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong>{{$pemesan[0]->nrpnpk}}</strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><span style="font-size:24px;"><strong>{{$pemesan[0]->nama}}</strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pemesan[0]->email}}</span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pemesan[0]->notelp}} - {{$pemesan[0]->lineId}}</span></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px;" width="50%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:10px;padding-left:20px;padding-right:20px;padding-top:10px;">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong>{{$dosenpj[0]->nrpnpk}} </strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><span style="font-size:24px;"><strong>{{$dosenpj[0]->nama}}</strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$dosenpj[0]->email}}</span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$dosenpj[0]->notelp}} - {{$dosenpj[0]->lineId}}</span></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>

							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-9" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #000000; color: #333;" width="100%">
												<tbody>
													<tr>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top;" width="40%">
															<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td>
																		<div style="font-family: Tahoma, Verdana, sans-serif">
																			<div style="font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555; line-height: 1.2;">
																				<p style="margin: 0; font-size: 12px;"><span style="font-size:18px;color:#ffffff;"><strong>ITEM</strong></span></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top;" width="36%">
															<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td>
																		<div style="font-family: Tahoma, Verdana, sans-serif">
																			<div style="font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555; line-height: 1.2;">
																				<p style="margin: 0; font-size: 12px;"><span style="font-size:18px;color:#ffffff;"><strong>JADWAL</strong></span></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top;" width="30%">
															<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td>
																		<div style="font-family: Tahoma, Verdana, sans-serif">
																			<div style="font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555; line-height: 1.2;">
																				<p style="margin: 0; font-size: 12px;"><span style="font-size:18px;color:#ffffff;"><strong>STATUS</strong></span></p>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-10" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
								<tbody>
									<tr>
										<td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
												<tbody>
													
<?php for ($i=0; $i < count($pesanankubarang) ; $i++) { $sesuatu = 0;?>
														<tr>												
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top;" width="40%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:15px;padding-left:20px;padding-right:20px;padding-top:15px;">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
	<?php if($i != 0){
		if($pesanankubarang[$i]->nama == $pesanankubarang[$i-1]->nama) { $sesuatu = 1; ?>														
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong></strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"></span></p>
		<?php }  else { ?>														
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong>{{$pesanankubarang[$i]->merk}} {{$pesanankubarang[$i]->nama}}</strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pesanankubarang[$i]->namaBarang}} | {{$pesanankubarang[$i]->kategori}}</span></p>
																				<br>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pesanankubarang[$i]->namaLab}} | {{$pesanankubarang[$i]->lokasi}}</span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">
																					{{PinjamController::fakultas1($pesanankubarang[$i]->fakultas)->namafakultas}}</span></p>

		<?php } } else { ?>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong>{{$pesanankubarang[$i]->merk}} {{$pesanankubarang[$i]->nama}}</strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pesanankubarang[$i]->namaBarang}} | {{$pesanankubarang[$i]->kategori}}</span></p>
																				<br>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pesanankubarang[$i]->namaLab}} | {{$pesanankubarang[$i]->lokasi}}</span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">
																					{{PinjamController::fakultas1($pesanankubarang[$i]->fakultas)->namafakultas}}</span></p>
		<?php } ?>	
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
															
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top;" width="60%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:15px;padding-left:20px;padding-right:20px;padding-top:15px;" width="60%">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0;">
																				@if($pesanankubarang[$i]->status == 1)
																				<span style="font-size:18px;background-color:red;  ">
																				@else
																				<span style="font-size:18px;">
																				@endif
																				{{date("d-m-Y", strtotime($pesanankubarang[$i]->tanggal))}} | {{$pesanankubarang[$i]->mulai}} - {{$pesanankubarang[$i]->selesai}}
																				</span></p>
																				<br>
																				<p style="margin: 0;"><span style="font-size:14px;"><b>Diambil</b>
																				@if($pesanankubarang[$i]->checkin == "") -
																				@else {{$pesanankubarang[$i]->checkin}} | {{$pesanankubarang[$i]->checkin1}} @endif</span></p>
																				<p style="margin: 0;"><span style="font-size:14px;"><b>Dikembalikan</b>
																					@if($pesanankubarang[$i]->checkout == "") -
																				@else {{$pesanankubarang[$i]->checkout}} | {{$pesanankubarang[$i]->checkout1}} @endif</span></p>
																				<br>
																				<p style="margin: 0;"><span style="font-size:14px;"><b>Catatan</b><br> 
																					@if($pesanankubarang[$i]->masalah == "") -
																				@else {{$pesanankubarang[$i]->masalah}} @endif</span></p>
																				<br>
																			</div>
																		</div>
																	</td>
																	<td style="padding-bottom:15px;padding-left:20px;padding-right:20px;padding-top:15px;"width="40%">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><b>Dosen Penanggungjawab</b><br>
																				@if($pesanankubarang[$i]->sdosen == 2) Tidak Disetujui {{$pesanankubarang[$i]->statusDosen}} - {{PinjamController::dosen1($pesanankubarang[$i]->statusDosen)->nama}}
																				@elseif($pesanankubarang[$i]->sdosen == 1) Sudah Disetujui {{$pesanankubarang[$i]->statusDosen}} - {{PinjamController::dosen1($pesanankubarang[$i]->statusDosen)->nama}}
																				@else  Belum Disetujui @endif

																				
																				 </span></p>
																				<br>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><b>Laboran / Kepala Laboratorium</b><br>
																				@if($pesanankubarang[$i]->skalab==2) 
																				Tidak Disetujui {{$pesanankubarang[$i]->statusKalab}} - {{PinjamController::dosen1($pesanankubarang[$i]->statusKalab)->nama}}

																				@elseif($pesanankubarang[$i]->skalab==1) 
																				Sudah Disetujui {{$pesanankubarang[$i]->statusKalab}} - {{PinjamController::dosen1($pesanankubarang[$i]->statusKalab)->nama}}

																				@else  Belum Disetujui @endif

																				</span></p>
																				<br>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><b>Lainnya</b><br> 
																				@if($pesanankubarang[$i]->keterangan == "") -
																				@else {{$pesanankubarang[$i]->keterangan}} @endif</span></p>
																			</div>
																		</div>
																	</td>

																</tr>
																<tr>
																	<td colspan="2"><p class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px dotted #CCCCCC;"><p><td>
																	</tr>

																</table>
															</th>
														</tr>

<?php } 
for ($i=0; $i < count($pesanankulab) ; $i++) { $sesuatu = 0;?>
														<tr>												
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top;" width="40%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:15px;padding-left:20px;padding-right:20px;padding-top:15px;">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
	<?php if($i != 0){
		if($pesanankulab[$i]->namaLab == $pesanankulab[$i-1]->namaLab) { $sesuatu = 1; ?>														
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong></strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"></span></p>
		<?php }  else { ?>														
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong>{{$pesanankulab[$i]->namaLab}}</strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pesanankulab[$i]->lokasi}}</span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{PinjamController::fakultas1($pesanankulab[$i]->fakultas)->namafakultas}}</span></p>

		<?php } } else { ?>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:24px;"><strong>{{$pesanankulab[$i]->namaLab}}</strong></span></span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{$pesanankulab[$i]->lokasi}}</span></p>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;">{{PinjamController::fakultas1($pesanankulab[$i]->fakultas)->namafakultas}}</span></p>
		<?php } ?>	
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
														</th>
															
														<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top;" width="60%">
															<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																<tr>
																	<td style="padding-bottom:15px;padding-left:20px;padding-right:20px;padding-top:15px;" width="60%">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0;">
																				@if($pesanankulab[$i]->status == 1)
																				<span style="font-size:18px;background-color:red;  ">
																				@else
																				<span style="font-size:18px;">
																				@endif
																					{{date("d-m-Y", strtotime($pesanankulab[$i]->tanggal))}} | {{$pesanankulab[$i]->mulai}} - {{$pesanankulab[$i]->selesai}}</span></p>
																				<br>
																				<p style="margin: 0;"><span style="font-size:14px;"><b>Check In</b>
																				@if($pesanankulab[$i]->checkin == "") -
																				@else {{$pesanankulab[$i]->checkin}} | {{$pesanankulab[$i]->checkin1}} @endif</span></p>
																				<p style="margin: 0;"><span style="font-size:14px;"><b>Check Out</b>
																					@if($pesanankulab[$i]->checkout == "") -
																				@else {{$pesanankulab[$i]->checkout}} | {{$pesanankulab[$i]->checkout1}} @endif</span></p>
																				<br>
																				<p style="margin: 0;"><span style="font-size:14px;"><b>Catatan</b><br> 
																					@if($pesanankulab[$i]->masalah == "") -
																				@else {{$pesanankulab[$i]->masalah}} @endif</span></p>
																				<br>
																			</div>
																		</div>
																	</td>
																	<td style="padding-bottom:15px;padding-left:20px;padding-right:20px;padding-top:15px;"width="40%">
																		<div style="font-family: sans-serif">
																			<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><b>Dosen Penanggungjawab</b><br>
																				@if($pesanankulab[$i]->sdosen == 2) Tidak Disetujui {{$pesanankulab[$i]->statusDosen}} - {{PinjamController::dosen1($pesanankulab[$i]->statusDosen)->nama}}
																				@elseif($pesanankulab[$i]->sdosen == 1) Sudah Disetujui {{$pesanankulab[$i]->statusDosen}} - {{PinjamController::dosen1($pesanankulab[$i]->statusDosen)->nama}}
																				@else  Belum Disetujui @endif
																				 </span></p>
																				<br>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><b>Laboran / Kepala Laboratorium</b><br>
																				@if($pesanankulab[$i]->skalab==2) 
																				Tidak Disetujui {{$pesanankulab[$i]->statusKalab}} - {{PinjamController::dosen1($pesanankulab[$i]->statusKalab)->nama}}

																				@elseif($pesanankulab[$i]->skalab==1) 
																				Sudah Disetujui {{$pesanankulab[$i]->statusKalab}} - {{PinjamController::dosen1($pesanankulab[$i]->statusKalab)->nama}}

																				@else  Belum Disetujui @endif
																				</span></p>
																				<br>
																				<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><b>Lainnya</b><br> 
																				@if($pesanankulab[$i]->keterangan == "") -
																				@else {{$pesanankulab[$i]->keterangan}} @endif</span></p>
																			</div>
																		</div>
																	</td>

																</tr>
																<tr>
																	<td colspan="2"><p class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px dotted #CCCCCC;"><p><td>
																	</tr>

																</table>
															</th>
														</tr>

<?php } ?>
														
													</tbody>
												</table>
											</td>
										</tr>

									</tbody>
								</table>
								
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-12" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
									<tbody>
										<tr>
											<td>
												<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #000000; color: #333;" width="100%">
													<tbody>
														<tr>
															<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px;" width="100%">
																<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																	<tr>
																		<td>
																			<div style="font-family: Tahoma, Verdana, sans-serif">
																				<div style="font-size: 12px; color: #555555; line-height: 1.2; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 12px;"><span style="color:#ffffff;"><span style="font-size:18px;"><strong>CATATAN PESANAN</strong></span></span></p>
																				</div>
																			</div>
																		</td>
																	</tr>
																</table>
															</th>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-8" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
									<tbody>
										<tr>
											<td>
												<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
													<tbody>
														<tr>
															<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px;" width="100%">
																<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																	<tr>
																		<td style="padding-bottom:10px;padding-left:20px;padding-right:20px;padding-top:10px;">
																			<div style="font-family: sans-serif">
																				<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:18px;"><strong>Catatan Pemesan </strong></span></span></p>
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:12px;"><span style="font-size:14px;">{{$orderku['0']->notePeminjam}}</span></span></p>
																				</div>
																				<br>
																				<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:18px;"><strong>Catatan Dosen Penanggungjawab </strong></span></span></p>
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:12px;"><span style="font-size:14px;">{{$orderku['0']->noteDosen}}</span></span></p>
																				</div>
																				<br>
																				<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:18px;"><strong>Catatan Laboran / Kepala Laboratrium </strong></span></span></p>
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:12px;"><span style="font-size:14px;">{{$orderku['0']->noteKalab}}</span></span></p>
																				</div>
																				<br>
																				<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:18px;"><strong>Catatan Pengambilan </strong></span></span></p>
																					 @foreach($ambil as $am)
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:12px;"><span style="font-size:14px;">{{$am->idambilbalik}} | {{$am->note}}</span></span></p>
																					@endforeach
																				</div>
																				<br>
																				<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:14px;"><a href="https://beefree.io" rel="noopener" style="text-decoration:none;color:#000000;" target="_blank"></a><span style="font-size:18px;"><strong>Catatan Pengembalian </strong></span></span></p>
																					 @foreach($balik as $bl)
																					<p style="margin: 0; font-size: 14px;"><span style="color:#000000;font-size:12px;"><span style="font-size:14px;">{{$bl->idambilbalik}} | {{$bl->note}}</span></span></p>
																					@endforeach
																				</div>

																			</div>
																		</td>
																	</tr>
																</table>
															</th>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>

								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-12" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
									<tbody>
										<tr>
											<td>
												<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #000000; color: #333;" width="100%">
													<tbody>
														<tr>
															<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px;" width="100%">
																<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																	<tr>
																		<td>
																			<div style="font-family: Tahoma, Verdana, sans-serif">
																				<div style="font-size: 12px; color: #555555; line-height: 1.2; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 12px;"><span style="color:#ffffff;"><span style="font-size:18px;"><strong>RIWAYAT PESANAN</strong></span></span></p>
																				</div>
																			</div>
																		</td>
																	</tr>
																</table>
															</th>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>

								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-13" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="80%">
									<tbody>
										<tr>
											<td>
												<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
													<tbody>
															
														<tr>
															<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 5px;" width="100%">
																<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
<?php for ($i=count($status)-1; $i > -1 ; $i--) { ?>  
																	<tr>
																		<td style="padding-bottom:10px;padding-left:20px;padding-right:20px;padding-top:10px;">
																			<div style="font-family: sans-serif">
																				<div style="font-size: 12px; color: #000000; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;">
																					<p style="margin: 0; font-size: 14px;"><span style="font-size:14px;">{{date("d-m-Y H:i:s" , strtotime($status[$i]->tanggal))}}
																					</span></p>
																					<p style="margin: 0; font-size: 14px;"><strong><span style="font-size:18px;">{{$status[$i]->nama}}</span></strong></p>
																					<p style="margin: 0; font-size: 14px;"><span style="font-size:14px;">{{KeranjangController::cariorang($status[$i]->pic)}}
																					</span></p>
																				</div>
																			</div>
																		</td>
																	</tr>
<?php } ?>
																</table>
																<table border="0" cellpadding="0" cellspacing="0" class="divider_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																	<tr>
																		<td style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
																			<div align="center">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																					<tr>
																						<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px dotted #CCCCCC;"><span></span></td>
																					</tr>
																				</table>
																			</div>
																		</td>
																	</tr>
																</table>
															</th>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-14" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
									<tbody>
										<tr>
											<td>
												<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
													<tbody>
														<tr>
															<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px;" width="100%">
																<table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
																	<tr>
																		<td>
																			<div style="font-family: sans-serif">
																				<div style="font-size: 12px; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; color: #555555; line-height: 1.2;">
																					<p style="margin: 0; font-size: 14px; text-align: center;"><span style="font-size:12px;">Copyright © 2021 BeLabs</span></p>
																				</div>
																			</div>
																		</td>
																	</tr>
																</table>
															</th>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-15" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
									<tbody>
										<tr>
											<td>
												<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
													<tbody>
														<tr>
															<th class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px;" width="100%">
																<table border="0" cellpadding="0" cellspacing="0" class="icons_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																	<tr>
																		<td style="color:#9d9d9d;font-family:inherit;font-size:15px;padding-bottom:5px;padding-top:5px;text-align:center;">
																			<table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
																				<tr>
																					<td style="text-align:center;">
																						<!--[if vml]><table align="left" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block;padding-left:0px;padding-right:0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;"><![endif]-->
																							<!--[if !vml]><!-->

																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</th>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table><!-- End -->
					</body>
					</html>