<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['id'])) {
	$id = pp($_POST['id']);
	$r = getRec('dts_x_dates', $id);
	$s = $r['d_start'];
	$e = $r['d_end'];
	$date = $r['date'];
	$p_type = $r['p_type'];
	$note = $r['note'];
	$c_type = $r['type'];
	$status = $r['status'];
	$vis_link = $r['vis_link'];
	$reg_user = $r['reg_user'];
	$other = $r['other'];
	if ($status == 2 && ($c_type == 6)) {
		if (getTotalCO('gnr_x_roles', "vis='$id' and mood='$c_type' and fast=2") == 0) {
			echo script("viSts($c_type,$vis_link );");
			exit;
		}
	}
	$action = 'confirmDate(' . $id . ',' . $c_type . ')';
	if ($p_type == 2 || $other) {
		$action = 'selDaPat(' . $id . ',2,' . $c_type . ')';
	}
	$services = get_vals('dts_x_dates_services', 'service', "dts_id='$id'") ?>
	<div class="win_body">
		<div class="form_header">
			<div class="so lh40 clr1 f1 fs18 fl"><?
													echo get_p_dts_name($r['patient'], $p_type);
													if ($p_type == 1) {
														list($mobile, $phone) = get_val('gnr_m_patients', 'mobile,phone', $r['patient']);
														echo '<span class="f1 clr5 fs16 Over" onclick="editPaVis(' . $r['patient'] . ',' . $id . ')"> ( ' . k_edit . ' ) </span>';
														if ($mobile || $phone) {
															echo '<div><bdi><ff>' . $mobile . ' - ' . $phone . '</ff></bdi></div>';
														}
														if ($other && $status == 1) {
															echo '<div class="f1 fs16 lh30 clr5">' . k_app_res_else . '</div>';
														}
													}
													if ($p_type == 2) {
														list($mobile, $phone) = get_val('dts_x_patients', 'mobile,phone', $r['patient']);
														echo '<span class="f1 clr5 fs16 Over" onclick="editPaVis(' . $r['patient'] . ',' . $id . ',2)"> ( ' . k_edit . ' )</span>';
														if ($mobile || $phone) {
															echo '<div><bdi><ff>' . $mobile . ' - ' . $phone . '</ff></bdi></div>';
														}
													}
													?></div>
			<div class="fr">
				<div class="ic40 icc2 ic40_print" onclick="printDate(<?= $id ?>);"></div>
				<div class="lh40">
					<ff class="clr6">#<?= $id ?></ff>
				</div>
			</div>
		</div>
		<div class="form_body so">
			<table width="100%" border="0" class="grad_s" cellspacing="0" cellpadding="4" type="static">
				<tr>
					<td txt> <?= k_appointment ?></td>
					<td>
						<div class="f1 fs16 lh30 clr1">
							<?= $wakeeDays[date('w', $s)] . ' - <ff>' .	date('d', $s) . '</ff> - ' . $monthsNames[date('n', $s)] . ' - <ff>' . date('Y', $s) . '</ff> | ' . k_thhour . ' <ff dir="ltr" class="clr5">' . date('A h:i', $s) . '</ff>'; ?></div>
						<div class="f1 fs16">
							<ff><?= ($e - $s) / 60 ?></ff> <?= k_minute ?>
						</div>
					</td>
				</tr>
				<tr>
					<td txt width="150"> <?= k_reserv_date ?></td>
					<td>
						<ff><?= date('Y-m-d A h:i', $date) ?></ff>
					</td>
				</tr>
				<tr>
					<td txt><?= k_reception ?></td>
					<td txt><?= get_val('_users', 'name_' . $lg, $reg_user) ?></td>
				</tr>
				<tr>
					<td txt><?= k_tclinic ?></td>
					<td txt><?= get_val('gnr_m_clinics', 'name_' . $lg, $r['clinic']) ?></td>
				</tr>
				<tr>
					<td txt><?= k_doctor ?></td>
					<td txt><?= get_val('_users', 'name_' . $lg, $r['doctor']) ?></td>
				</tr><?
						if ($c_type != 4) { ?>
					<!--<tr><td txt>قيمة الخدمات</td><td><ff class="clr1"><?= number_format(get_sum('dts_x_dates_services', 'hos_part+doc_part', " dts_id='$id' ")) ?></ff></td></tr>-->

					<tr>
						<td txt><?= k_services ?></td>
						<td txt><?
								$table = $srvTables[$c_type];
								if ($services) {
									echo get_vals($table, "name_$lg", " id IN($services) ", ' :: ');
								}
								?></td>
					</tr><?
						} ?>
				<tr>
					<td txt>الحالة</td>
					<td txt bgcolor="<?= $dateStatusInfoClr[$status] ?>">
						<div class="clrb f1 fs14"><?= $dateStatus[$status] . dateSubStatus($r) ?></div>
					</td>
				</tr>
				<?
				//if($status==1 || $status==5 || $status==8){
				$pPay = DTS_PayBalans($id);
				if ($pPay) { ?>
					<tr>
						<td txt><?= k_prev_pays ?></td>
						<td>
							<ff class="clr5 lh40" onclick=""><?= number_format($pPay) ?></ff>
							<div class="bu2 bu_t3 buu " onclick="returnPayment(<?= $id ?>)"><?= k_paym_ret ?></div>
						</td>
					</tr><?
						}
						//}
							?>
				<? if ($note) {
					echo '<tr><td txt>' . k_notes . '</td><td><div class="clr5 f1 ">' . nl2br($note) . '</div></td></tr>';
				} ?>
			</table>
		</div>
		<div class="form_fot fr"><?
									$edit = 0;
									if ($r['status'] < 2 || $r['status'] == 9 ||  $r['status'] == 10) {
										$edit = 1;
										if ($s > $ss_day && $s < ($ss_day + 86400) && $thisGrp == 'pfx33zco65') {
											$butt = k_attended;
											if ($s < $now - (60 * _set_d9c90np40z)) {
												$butt = k_trns_to_wait;
												$edit = 0;
											}
											echo '<div class="bu bu_t4 fl" onclick="' . $action . '">' . $butt . '</div>';
										}
									}
									if ($edit) {
										echo '<div class="bu bu_t1 fl" onclick="editDate(' . $id . ');">' . k_edit . '</div>';
										//if($date<$now-(60*_set_d9c90np40z)){
										echo '<div class="bu bu_t3 fl" onclick="dtsCancel(' . $id . ');">' . k_cancel . '</div>';
										//}else{				
										//echo '<div class="bu bu_t3 fl" onclick="dtsDel('.$id.');">'.k_delete.'</div>';
										//}
									}
									if ($PER_ID == 'xev9s6nztt') {
										$addAction = "loadFitterCostom('dts_arc');";
									}
									if ($PER_ID == 'u9xw1uxxeb') {
										$addAction = "res_ref(1)";
									}
									?>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');<?= $addAction ?>"><?= k_end ?></div>
		</div>
	</div><?
		} ?>