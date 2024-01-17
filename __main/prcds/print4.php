<? include("../../__sys/prcds/ajax_header.php");
if (isset($_GET['type'], $_GET['id'])) {
	$type = pp($_GET['type']);
	$id = pp($_GET['id']);
	if (_set_14jk4yqz3w) {
		$image = getImages(_set_14jk4yqz3w);
		$file = $image[0]['file'];
		$folder = $image[0]['folder'];
		list($w, $h) = getimagesize("sData/" . $folder . $file);
		$fullfile = $m_path . 'upi/' . $folder . $file;
		$logo = '<img src="' . $fullfile . '"/>';
	}
	$style_file = styleFiles('P'); ?>

	<head>
		<link rel="stylesheet" type="text/css" href="<?= $m_path . $style_file ?>">
	</head>

	<body dir="<?= $l_dir ?>">
		<div class="print_page4 ">
			<div class="print_pageIn">
				<div class="p5Header2">
					<div class="h_logo_p4 fr"><?= $logo ?></div>
				</div><?
						if ($type == 1) {
							$title1 = ' ' . k_visits . '  ';
							$title2 = k_male_pat . '  ( ' . get_p_name($id) . ' ) ';
							$titleVal = k_until . '  <ff dir="ltr"> ( ' . date('Y-m-d') . ' ) </ff>';
							echo '<div class="f1 fs16 lh40">' . k_report . $title1 . $title2 . $titleVal . '</div>';
							$p_id = $id;
							$sql1 = "select * from cln_x_visits where patient='$p_id' order by d_start DESC";
							$res1 = mysql_q($sql1);
							$rows1 = mysql_n($res1);

							$sql2 = "select * from lab_x_visits where patient='$p_id' order by d_start DESC";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);

							$sql3 = "select * from xry_x_visits where patient='$p_id' order by d_start DESC";
							$res3 = mysql_q($sql3);
							$rows3 = mysql_n($res3);

							$sql5 = "select * from bty_x_visits where patient='$p_id' order by d_start DESC";
							$res5 = mysql_q($sql5);
							$rows5 = mysql_n($res5);

							$sql6 = "select * from bty_x_laser_visits where patient='$p_id' order by d_start DESC";
							$res6 = mysql_q($sql6);
							$rows6 = mysql_n($res6);

							$rowsAll = $rows1 + $rows2 + $rows3 + $rows5 + $rows6;
							if ($rowsAll > 0) {
								echo '<div class="f1 fs18 clr1 lh40 uLine">' . k_vis_no . ' <ff>[ ' . $rowsAll . ' ] </ff></div>';
							}
							//-------------CLN-----------
							if ($rows1) {
								echo '<div class="f1 fs18 clr1 lh40">' . k_clinics . ' <ff>[ ' . $rows1 . ' ] </ff></div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>' . k_date . '</th><th>' . k_clinic . '</th><th>' . k_doctor . '</th><th>' . k_stime . '</th><th> ' . k_end_bord . ' / ' . k_cancel . '</th><th>' . k_services . '</th><th>' . k_status . '</th></tr>';
								while ($r = mysql_f($res1)) {
									$v_id = $r['id'];
									$doctor = $r['doctor'];
									$patient = $r['patient'];
									$clinic = $r['clinic'];
									$time_entr = $r['d_start'];
									$time_chck = $r['d_check'];
									$time_out = $r['d_finish'];
									$type = $r['type'];
									$v_status = $r['status'];
									$work = $r['work'];
									$workTxt = '';
									if ($work) {
										$workPers = ($work * 100) / ($time_out - $time_chck);
										$workTxt = '<div>' . dateToTimeS($work) . ' (' . number_format($workPers) . '% ) </div>
					<div class="clr1">' . k_waiting . ' :' . dateToTimeS($time_chck - $time_entr) . ' </div>';
									}

									if ($doctor) {
										$doc = get_val('_users', 'name_' . $lg, $doctor);
									} else {
										$doc = k_not_existed;
									}
									$status2 = '';
									if ($v_status == 2) {
										$x_srv = getTotalCO('cln_x_visits_services', " visit_id='$v_id' and status=0 ");
										if ($x_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_services_not_complete_amount . ' <span class="ff B clr5"> ( ' . $x_srv . ' )</span></div>';
										}
									}
									if ($v_status == 1) {
										$add_srv = getTotalCO('cln_x_visits_services', " visit_id='$v_id' and status=2 ");
										if ($add_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_additional_services_amount . ' <span class="ff B clr5"> ( ' . $add_srv . ' )</span></div>';
										}
									}
									$services = get_vals('cln_x_visits_services', 'service', " visit_id='$v_id'");
									$servicesNames = get_vals('cln_m_services', 'name_' . $lg, " id IN($services)", ' | ');
									$d_checkT = $d_finishT = '-';
									if ($time_chck) {
										$d_checkT = clockStr($time_chck - ($time_chck - ($time_chck % 86400)));
									}
									if ($time_out) {
										$d_finishT = clockStr($time_out - ($time_out - ($time_out % 86400)));
									}
									echo '				
				<tr>
				<td><ff>' . $v_id . '</ff></td>
				<td><ff>' . date('Y-m-d', $time_entr) . '</ff></td>				
				<td class="f1 fs14">' . get_val('gnr_m_clinics', 'name_' . $lg, $clinic) . '</td>
				<td class="f1 fs14">' . $doc . '</td>
				<td><ff>' . $d_checkT . '</ff></td>
				<td><ff>' . $d_finishT . '</ff></td>
				<td txt>' . $servicesNames . '</td>
				<td><span class="f1 fs14" style="color:' . $stats_arr_col[$v_status] . '">' . $stats_arr[$v_status] . $status2 . '</td>
				</tr>';
								}
								echo '</table>';
							}
							//-------------LAB-----------	
							if ($rows2) {
								echo '<div class="f1 fs18 clr1 lh40">' . k_thlab . ' <ff>[ ' . $rows2 . ' ] </ff></div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>' . k_date . '</th><th>' . k_stime . '</th><th> ' . k_end_bord . ' / ' . k_cancel . '</th><th>' . k_services . '</th><th>' . k_status . '</th></tr>';
								while ($r = mysql_f($res2)) {
									$v_id = $r['id'];
									$patient = $r['patient'];
									$clinic = $r['clinic'];
									$time_entr = $r['d_start'];
									$time_chck = $r['d_check'];
									$time_out = $r['d_finish'];
									$type = $r['type'];
									$v_status = $r['status'];
									$work = $r['work'];
									$workTxt = '';
									if ($work) {
										$workPers = ($work * 100) / ($time_out - $time_chck);
										$workTxt = '<div>' . dateToTimeS($work) . ' (' . number_format($workPers) . '% ) </div>
					<div class="clr1">' . k_waiting . ' :' . dateToTimeS($time_chck - $time_entr) . ' </div>';
									}

									if ($doctor) {
										$doc = get_val('_users', 'name_' . $lg, $doctor);
									} else {
										$doc = k_not_existed;
									}
									$status2 = '';
									if ($v_status == 2) {
										$x_srv = getTotalCO('lab_x_visits_services', " visit_id='$v_id' and status=0 ");
										if ($x_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_services_not_complete_amount . ' <span class="ff B clr5"> ( ' . $x_srv . ' )</span></div>';
										}
									}
									if ($v_status == 1) {
										$add_srv = getTotalCO('lab_x_visits_services', " visit_id='$v_id' and status=2 ");
										if ($add_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_additional_services_amount . ' <span class="ff B clr5"> ( ' . $add_srv . ' )</span></div>';
										}
									}
									$services = get_vals('lab_x_visits_services', 'service', " visit_id='$v_id'");
									$servicesNames = get_vals('lab_m_services', 'short_name', " id IN($services)", ' | ');
									$d_checkT = $d_finishT = '-';
									if ($time_chck) {
										$d_checkT = clockStr($time_chck - ($time_chck - ($time_chck % 86400)));
									}
									if ($time_out) {
										$d_finishT = clockStr($time_out - ($time_out - ($time_out % 86400)));
									}
									echo '				
				<tr>
				<td><ff>' . $v_id . '</ff></td>
				<td><ff>' . date('Y-m-d', $time_entr) . '</ff></td>
				<td><ff>' . $d_checkT . '</ff></td>
				<td><ff>' . $d_finishT . '</ff></td>
				<td><ff class="fs14">' . $servicesNames . '</ff></td>
				<td><span class="f1 fs14" style="color:' . $lab_vis_sClr[$v_status] . '">' . $lab_vis_s[$v_status] . $status2 . '</td>
				</tr>';
								}
								echo '</table>';
							}
							//-------------XRY-----------
							if ($rows3) {
								echo '<div class="f1 fs18 clr1 lh40">' . k_txry . ' <ff>[ ' . $rows3 . ' ] </ff></div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>' . k_date . '</th><th>' . k_clinic . '</th><th>' . k_doctor . ' / ' . k_technician . '</th><th>' . k_stime . '</th><th> ' . k_end_bord . ' / ' . k_cancel . '</th><th>' . k_services . '</th><th>' . k_status . '</th></tr>';
								while ($r = mysql_f($res3)) {
									$v_id = $r['id'];
									$doctor = $r['ray_tec'];
									$patient = $r['patient'];
									$clinic = $r['clinic'];
									$time_entr = $r['d_start'];
									$time_chck = $r['d_check'];
									$time_out = $r['d_finish'];
									$type = $r['type'];
									$v_status = $r['status'];
									$work = $r['work'];
									$workTxt = '';
									if ($work) {
										$workPers = ($work * 100) / ($time_out - $time_chck);
										$workTxt = '<div>' . dateToTimeS($work) . ' (' . number_format($workPers) . '% ) </div>
					<div class="clr1">' . k_waiting . ' :' . dateToTimeS($time_chck - $time_entr) . ' </div>';
									}

									if ($doctor) {
										$doc = get_val('_users', 'name_' . $lg, $doctor);
									} else {
										$doc = k_not_existed;
									}
									$status2 = '';
									if ($v_status == 2) {
										$x_srv = getTotalCO('xry_x_visits_services', " visit_id='$v_id' and status=0 ");
										if ($x_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_services_not_complete_amount . ' <span class="ff B clr5"> ( ' . $x_srv . ' )</span></div>';
										}
									}
									if ($v_status == 1) {
										$add_srv = getTotalCO('xry_x_visits_services', " visit_id='$v_id' and status=2 ");
										if ($add_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_additional_services_amount . ' <span class="ff B clr5"> ( ' . $add_srv . ' )</span></div>';
										}
									}
									$services = get_vals('xry_x_visits_services', 'service', " visit_id='$v_id'");
									$servicesNames = get_vals('xry_m_services', 'name_' . $lg, " id IN($services)", ' | ');
									$d_checkT = $d_finishT = '-';
									if ($time_chck) {
										$d_checkT = clockStr($time_chck - ($time_chck - ($time_chck % 86400)));
									}
									if ($time_out) {
										$d_finishT = clockStr($time_out - ($time_out - ($time_out % 86400)));
									}
									echo '				
				<tr>
				<td><ff>' . $v_id . '</ff></td>
				<td><ff>' . date('Y-m-d', $time_entr) . '</ff></td>				
				<td class="f1 fs14">' . get_val('gnr_m_clinics', 'name_' . $lg, $clinic) . '</td>
				<td class="f1 fs14">' . $doc . '</td>
				<td><ff>' . $d_checkT . '</ff></td>
				<td><ff>' . $d_finishT . '</ff></td>
				<td txt>' . $servicesNames . '</td>
				<td><span class="f1 fs14" style="color:' . $stats_arr_col[$v_status] . '">' . $stats_arr[$v_status] . $status2 . '</td>
				</tr>';
								}
								echo '</table>';
							}
							//-------------BTY-----------
							if ($rows5) {
								echo '<div class="f1 fs18 clr1 lh40">التجميل <ff>[ ' . $rows5 . ' ] </ff></div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>' . k_date . '</th><th>' . k_clinic . '</th><th>' . k_doctor . '</th><th>' . k_stime . '</th><th> ' . k_end_bord . ' / ' . k_cancel . '</th><th>' . k_services . '</th><th>' . k_status . '</th></tr>';
								while ($r = mysql_f($res5)) {
									$v_id = $r['id'];
									$doctor = $r['doctor'];
									$patient = $r['patient'];
									$clinic = $r['clinic'];
									$time_entr = $r['d_start'];
									$time_chck = $r['d_check'];
									$time_out = $r['d_finish'];
									$type = $r['type'];
									$v_status = $r['status'];
									/*$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}*/

									if ($doctor) {
										$doc = get_val('_users', 'name_' . $lg, $doctor);
									} else {
										$doc = k_not_existed;
									}
									$status2 = '';
									if ($v_status == 2) {
										$x_srv = getTotalCO('bty_x_visits_services', " visit_id='$v_id' and status=0 ");
										if ($x_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_services_not_complete_amount . ' <span class="ff B clr5"> ( ' . $x_srv . ' )</span></div>';
										}
									}
									if ($v_status == 1) {
										$add_srv = getTotalCO('bty_x_visits_services', " visit_id='$v_id' and status=2 ");
										if ($add_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_additional_services_amount . ' <span class="ff B clr5"> ( ' . $add_srv . ' )</span></div>';
										}
									}
									$services = get_vals('bty_x_visits_services', 'service', " visit_id='$v_id'");
									$servicesNames = get_vals('bty_m_services', 'name_' . $lg, " id IN($services)", ' | ');
									$d_checkT = $d_finishT = '-';
									if ($time_chck) {
										$d_checkT = clockStr($time_chck - ($time_chck - ($time_chck % 86400)));
									}
									if ($time_out) {
										$d_finishT = clockStr($time_out - ($time_out - ($time_out % 86400)));
									}
									echo '				
				<tr>
				<td><ff>' . $v_id . '</ff></td>
				<td><ff>' . date('Y-m-d', $time_entr) . '</ff></td>				
				<td class="f1 fs14">' . get_val('gnr_m_clinics', 'name_' . $lg, $clinic) . '</td>
				<td class="f1 fs14">' . $doc . '</td>
				<td><ff>' . $d_checkT . '</ff></td>
				<td><ff>' . $d_finishT . '</ff></td>
				<td txt>' . $servicesNames . '</td>
				<td><span class="f1 fs14" style="color:' . $stats_arr_col[$v_status] . '">' . $stats_arr[$v_status] . $status2 . '</td>
				</tr>';
								}
								echo '</table>';
							}
							//-------------LZR-----------
							if ($rows6) {
								echo '<div class="f1 fs18 clr1 lh40">' . k_tlaser . ' <ff>[ ' . $rows6 . ' ] </ff></div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>' . k_date . '</th><th>' . k_clinic . '</th><th>' . k_doctor . '</th><th>' . k_stime . '</th><th> ' . k_end_bord . ' / ' . k_cancel . '</th><th>' . k_services . '</th><th>' . k_status . '</th></tr>';
								while ($r = mysql_f($res6)) {
									$v_id = $r['id'];
									$doctor = $r['doctor'];
									$patient = $r['patient'];
									$clinic = $r['clinic'];
									$time_entr = $r['d_start'];
									$time_chck = $r['d_check'];
									$time_out = $r['d_finish'];
									$type = $r['type'];
									$v_status = $r['status'];
									/*$work=$r['work'];

				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}*/

									if ($doctor) {
										$doc = get_val('_users', 'name_' . $lg, $doctor);
									} else {
										$doc = k_not_existed;
									}
									$status2 = '';
									if ($v_status == 2) {
										$x_srv = getTotalCO('bty_x_laser_visits_services', " visit_id='$v_id' and status=0 ");
										if ($x_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_services_not_complete_amount . ' <span class="ff B clr5"> ( ' . $x_srv . ' )</span></div>';
										}
									}
									if ($v_status == 1) {
										$add_srv = getTotalCO('bty_x_laser_visits_services', " visit_id='$v_id' and status=2 ");
										if ($add_srv > 0) {
											$status2 = '<div class="f1 clr5">' . k_additional_services_amount . ' <span class="ff B clr5"> ( ' . $add_srv . ' )</span></div>';
										}
									}
									$services = get_vals('bty_x_laser_visits_services', 'service', " visit_id='$v_id'");
									$servicesNames = get_vals('bty_m_services', 'name_' . $lg, " id IN($services)", ' | ');
									$d_checkT = $d_finishT = '-';
									if ($time_chck) {
										$d_checkT = clockStr($time_chck - ($time_chck - ($time_chck % 86400)));
									}
									if ($time_out) {
										$d_finishT = clockStr($time_out - ($time_out - ($time_out % 86400)));
									}
									echo '				
				<tr>
				<td><ff>' . $v_id . '</ff></td>
				<td><ff>' . date('Y-m-d', $time_entr) . '</ff></td>				
				<td class="f1 fs14">' . get_val('gnr_m_clinics', 'name_' . $lg, $clinic) . '</td>
				<td class="f1 fs14">' . $doc . '</td>
				<td><ff>' . $d_checkT . '</ff></td>
				<td><ff>' . $d_finishT . '</ff></td>
				<td txt>' . $servicesNames . '</td>
				<td><span class="f1 fs14" style="color:' . $stats_arr_col[$v_status] . '">' . $stats_arr[$v_status] . $status2 . '</td>
				</tr>';
								}
								echo '</table>';
							}
							/************/
							if ($rowsAll == 0) {
								echo '<div class="f1 fs14 clr5 lh40">' . k_no_vis_pat . ' </div>';
							}
							/*******/
						}

						if ($type == 3) {
							$r = getRec('gnr_m_offers', $id);
							if ($r['r']) {
								$sql = "select * from gnr_m_offers_items where offers_id='$id' ";
								$res = mysql_q($sql);
								$rows = mysql_n($res);
								$rowTxt = '';
								if ($rows) {
									$totPrice = 0;
									$totM_price = 0;
									while ($r2 = mysql_f($res)) {
										$totPrice += $r2['price'];
										$mood = $r2['mood'];
										$srv = $r2['service'];
										$mood = $r2['mood'];
										$m_price = getSrvPrice($mood, $srv);
										$totM_price += $m_price;
										$serTxt = get_val_arr($srvTables[$mood], 'name_' . $lg, $srv, 'srv' . $mood);
										$subVal = get_val_arr($srvTables[$mood], $subTablesOfferCol[$mood], $srv, 'cl' . $mood);
										$subTxt = get_val_arr($subTablesOfeer[$mood], 'name_' . $lg, $subVal, 'sub' . $mood);

										$rowTxt .= '<tr>
						<td txt>' . $clinicTypes[$mood] . '</td>
						<td txt class="ta_n"><span class="f1 clr1 fs16">' . splitNo($subTxt) . ' : </span>' . splitNo($serTxt) . '</td>
						<td><ff>' . number_format($m_price) . '</ff></td>
					</tr>';
									}
								}
								echo '				
				<div class="f1 fs18 lh40">' . k_thoffer . ' : ' . $r['name'] . ' <ff>( ' . $rows . ' )</ff> </div>
				<div class="fl f1 fs16 clr6 lh40 pd10">' . k_offer_val . '<ff>[ ' . number_format($totPrice) . ' ]</ff></div> 
				<div class="fl f1 fs16 clr5 lh40 pd10"> ' . k_val_ser_before_off . '<ff>[ ' . number_format($totM_price) . ' ]</ff></div>';

								if ($rows) {
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s"  >
				<tr><th>' . k_the_sec . '</th><th>' . k_service
										. '</th><th>' . k_price_serv . '</th></tr>' . $rowTxt . '</table>';
								}
							}
						}
						if ($type == 4) {
						?>
					<div class="lh40 clr1 f1 fs18"><?= get_p_name($id) ?></div>
					<div class="f1 fs16 lh30"><?= k_srvs_prvd ?></div>
					<div><?
							$sql = "select * from den_x_visits_services where patient='$id' order by d_start DESC";
							$res = mysql_q($sql);
							$rows = mysql_n($res);
							if ($rows > 0) { ?>
							<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">
								<tr>
									<th width="120"><?= k_the_date ?></th>
									<th><?= k_service ?></th>
									<th><?= k_val_srv ?></th>
									<th><?= k_complete_percent ?></th>
									<th><?= k_rece ?></th>
								</tr><?
										$t1 = $t2 = $t3 = 0;
										while ($r = mysql_f($res)) {
											$x_id = $r['id'];
											$service = $r['service'];
											$pay_net = $r['total_pay'];
											$d_start = $r['d_start'];
											$end_percet = $r['end_percet'];
											$srvTxt = get_val_arr('den_m_services', 'name_' . $lg, $service, 's');
											$levleNotes = get_levetNote($x_id, $service);
											$srvNet = 0;
											if ($end_percet) {
												$srvNet = $pay_net * $end_percet / 100;
											}
											$t1 += $pay_net;
											$t2 += $end_percet;
											$t3 += $srvNet;
											$srvDone += $srvNet;
										?>
									<tr>
										<td>
											<ff><?= date('Y-m-d', $d_start) ?></ff>
										</td>
										<td txt><?= $srvTxt . $levleNotes ?></td>
										<td>
											<ff class="clr1"><?= number_format($pay_net) ?></ff>
										</td>
										<td>
											<ff>%<?= $end_percet ?></ff>
										</td>
										<td>
											<ff class="clr6"><?= number_format($srvNet) ?></ff>
										</td>
									</tr><?
										} ?>
								<tr fot>
									<td class="f1 fs14" colspan="2"><?= k_the_total ?></td>
									<td>
										<ff class="clr1"><?= number_format($t1) ?></ff>
									</td>
									<td>
										<ff>%<?= $end_percet ?></ff>
									</td>
									<td>
										<ff class="clr6"><?= number_format($t3) ?></ff>
									</td>
								</tr>
							</table><?
								} else { ?>
							<div class="f1 fs16 clr5 lh40"><?= k_no_ser ?></div><?
																			} ?>
					</div>

					<div class="f1 fs16 lh40"><?= k_payms ?></div>
					<div><?
							$sql = "select * from gnr_x_acc_patient_payments where patient='$id' order by date DESC";
							$res = mysql_q($sql);
							$rows = mysql_n($res);
							if ($rows > 0) { ?>
							<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">
								<tr>
									<th width="120"><?= k_the_date ?></th>
									<th><?= k_paym_type ?></th>
									<th><?= k_paym ?></th>
								</tr><?
										$t3 = 0;
										while ($r = mysql_f($res)) {
											$amount = $r['amount'];
											$date = $r['date'];
											$type = $r['type'];
											$srvNet = 0;
											if ($type == 2) {
												$t3 -= $amount;
											} else {
												$t3 += $amount;
											}
										?>
									<tr>
										<td>
											<ff class="<?= $patPaymentClr[$type] ?>"><?= date('Y-m-d', $date) ?></ff>
										</td>
										<td txt class="<?= $patPaymentClr[$type] ?>"><?= $patPayment[$type] ?></td>
										<td>
											<ff class="clr1"><?= number_format($amount) ?></ff>
										</td>
									</tr><?
										} ?>
								<tr fot>
									<td class="f1 fs14" colspan="2"><?= k_the_total ?></td>
									<td>
										<ff class="clr6"><?= number_format($t3) ?></ff>
									</td>
								</tr>
							</table><?
								} else { ?>
							<div class="f1 fs16 clr5 lh40"><?= k_no_payms ?></div><?
																				}
																				$pay = patDenPay($patient);
																				$bal = $t3 - $pay;
																				$balPay = $bal;
																				if ($balPay < 0) {
																					$balPay = 0;
																				}
																				$maxPay = $t1 - $pay;
																					?>
					</div>
					<?
							$fbClr = 'clr5';
							$finBal = $srvDone - $t3;
							if ($finBal <= 0) {
								$fbClr = 'clr6';
							}
					?>
					<div>
						<div class="f1 fs16 lh50 pd10 clr1"><?= k_balance ?></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s holdH">
							<tr>
								<td>
									<div class="f1 fs14 lh40  clr4"><?= k_val_srvs ?> : </div>
								</td>
								<td class="TC" width="100">
									<ff class="clr4"><?= number_format($t1) ?></ff>
								</td>
							</tr>
							<tr>
								<td class="f1 fs14 lh40 "><?= k_val_ach_due ?>: </td>
								<td class="TC" width="100">
									<ff class="clr5"><?= number_format($srvDone) ?></ff>
								</td>
							</tr>
							<tr>
								<td class="f1 fs14 lh40 "><?= k_prev_pays ?> :</td>
								<td class="TC">
									<ff class="clr1"><?= number_format($t3) ?></ff>
								</td>
							</tr>
							<tr>
								<td class="f1 fs14 lh40 "><?= k_balance ?> :</td>
								<td class="TC">
									<ff class="<?= $fbClr ?>"><?= number_format($finBal) ?></ff>
								</td>
							</tr>
						</table>
					</div>
				<?
						}
						if ($type == 5) {
							$data = array();
							$sql = "select * from den_x_visits where reg_user='$thisUser' and d_start > $ss_day order by d_start ASC";
							$res = mysql_q($sql);
							$rows = mysql_n($res);
							while ($r = mysql_f($res)) {
								$k = $r['d_start'];
								$data[$k]['vis'] = $r['id'];
								$data[$k]['type'] = 1;
								$data[$k]['doctor'] = $r['doctor'];
								$data[$k]['patient'] = $r['patient'];
								$data[$k]['clinic'] = $r['clinic'];
								$data[$k]['amount'] = 0;
							}

							$sql = "select * from gnr_x_acc_payments where mood=4 and casher='$thisUser' and date > $ss_day order by date ASC";
							$res = mysql_q($sql);
							$rows = mysql_n($res);
							while ($r = mysql_f($res)) {
								$vis = $r['vis'];
								$amount = $r['amount'];
								$p_date = $r['date'];
								$p_id = $r['id'];
								$actArrK = 0;
								if ($vis) {
									foreach ($data as $k => $v) {
										if ($v['vis'] == $vis) {
											$actArrK = $k;
										}
									}
									if ($actArrK) {
										$data[$actArrK]['amount'] += $amount;
									} else {
										$r2 = getRec('den_x_visits', $vis);
										$data[$p_date]['vis'] = $vis;
										$data[$p_date]['type'] = 2;
										$data[$p_date]['doctor'] = $r2['doctor'];
										$data[$p_date]['patient'] = $r2['patient'];
										//$data[$p_date]['clinic']=$r['clinic'];
										$data[$p_date]['amount'] = $amount;
									}
								} else {
									$r3 = getRecCon('gnr_x_acc_patient_payments', "payment_id='$p_id'");
									if ($r3['r']) {
										$data[$p_date]['vis'] = 0;
										$data[$p_date]['type'] = 3;
										$data[$p_date]['doctor'] = $r3['doc'];
										$data[$p_date]['patient'] = $r3['patient'];
										//$data[$p_date]['clinic']=$r['clinic'];
										$data[$p_date]['amount'] = $amount;
									}
								}
							}

							ksort($data);
				?>
					<div class="f1 fs18 lh40 clr1"><?= get_val('_users', 'name_' . $lg, $thisUser) ?> : <ff dir="ltr"> <?= date('Y-m-d') ?> </ff>
					</div>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
						<tr>
							<th width="60"><?= k_thvisit ?></th>
							<th width="100"><?= k_tim ?></th>
							<th><?= k_patient ?></th>
							<th><?= k_doctor ?></th>
							<th><?= k_code ?></th>
							<th><?= k_cmpt_srvcs ?></th>
							<th><?= k_val_of_completed ?></th>
							<th><?= k_paym ?></th>
						</tr><?
								$allService = $allPayment = 0;
								foreach ($data as $k => $d) {
									$vis = $data[$k]['vis'];
									list($doc, $code) = get_val_arr('_users', "name_$lg,career_code", $d['doctor'], 'doc');
									$amount = $d['amount'];
									$patient = $d['patient'];
									$type = $d['type'];
									$srvData = '';
									$totalPrice = 0;
									$sql = "select * from den_x_visits_services_levels where vis='$vis' and status=2";
									$res = mysql_q($sql);
									if ($type == 1) {
										while ($r = mysql_f($res)) {
											$srv = $r['service'];
											$lev = $r['lev'];
											$price = $r['price'];
											$totalPrice += $price;
											$srvTxt = get_val_arr('den_m_services', 'name_' . $lg, $srv, 'srv');
											$levTxt = get_val_arr('den_m_services_levels', 'name_' . $lg, $lev, 'lev');
											$srvData .= '<div class="f1 fs14 ">- ' . splitNo($srvTxt) . ' / ' . splitNo($levTxt) . ' <ff class="fs14 clr1"> ( ' . number_format($price) . ' )</ff></div>';
										}
									}
									if ($type == 2) {
										$srvData = '-';
										$totalPrice = '-';
									}
									if ($type == 3) {
										$srvData = '<div class="f1 fs14 clr5">' . k_indpndnt_pay . '</div>';
										$totalPrice = '-';
									}
									$allService += $totalPrice;
									$allPayment += $amount;
								?>
							<tr>
								<td>
									<ff><?= $vis ?></ff>
								</td>
								<td>
									<ff><?= date('A h:i', $k) ?></ff>
								</td>
								<td txt><?= get_p_name($patient) ?></td>
								<td txt><?= $doc ?></td>
								<td>
									<ff class="clr5"><?= $code ?></ff>
								</td>
								<td>
									<div class="TL"><?= $srvData ?></div>
								</td>
								<td>
									<ff><?= number_format($totalPrice) ?></ff>
								</td>
								<td>
									<ff><?= number_format($amount) ?></ff>
								</td>
							</tr><?
								} ?>
						<tr>
							<td txt colspan="6"><?= k_the_total ?></td>
							<td>
								<ff><?= number_format($allService) ?></ff>
							</td>
							<td>
								<ff><?= number_format($allPayment) ?></ff>
							</td>
						</tr>
					</table><?


						}
							?>
			</div>
		</div>
	</body>
	<script>
		window.print();
	</script><?
			} ?>