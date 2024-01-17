<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['id'])) {
	$id = pp($_POST['id']);
	$r = getRec('gnr_x_prescription', $id);
	if ($r['r']) {
		$doc = $r['doc'];
		$clinic = $r['clinic'];
		$note = $r['note'];
		$complaint = $r['complaint_txt'];
		$status = $r['status'];
		$patient = $r['patient'];
		$date = $r['date'];
		$add_date = $r['add_date'];
		$sending = $r['sending_status'];
		$process_status = $r['process_status'];
		echo '^';
		$sql = "select * from gnr_x_prescription_itemes where presc_id='$id' group by mad_id order by id ASC";
		$res = mysql_q($sql);
		$rows = mysql_n($res);
		if ($rows) { ?>
			<div class="fr fs14 clr1"><?= date('Y-m-d  A h:i:s', $add_date) ?></div>
			<div class="f1 mg5b"><?= k_patient ?>: <span class="f1 clr1"><?= get_p_name($patient) ?></span></div>
			<div class="f1 mg5b"><?= k_doctor ?>: <span class="f1 clr1">
					<?= get_val('_users', 'name_' . $lg, $doc) ?>
					( <?= get_val('gnr_m_clinics', 'name_' . $lg, $clinic) ?> )</span>
			</div>
			<? if ($complaint) { ?>
				<div class="f1 mg5b"><?= k_diagnoses ?>: <span class="f1 clr1"><?= $complaint ?></span></div><?
																											}
																											if ($note) { ?>
				<div class="f1 mg5b"><?= k_notes ?>: <span class="f1 clr1"><?= $note ?></span></div><?
																											}
																											echo '
			<div class="f1 fs14 mg10t lh40">' . k_medicines_list . '</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="infoTable_s " type="static" >
				<tr>
				<th>' . k_medicine . '</th>
				<th>' . k_dosage . '</th>
				<th>' . k_num_of_tim . ' </th>
				<th> ' . k_dosage_status . '</th>
				<th>' . k_duration . '</th>	
				<th>' . k_quantity . '</th>
				</tr>';
																											while ($r = mysql_f($res)) {
																												$r_id = $r['id'];
																												$mad_id = $r['mad_id'];
																												$dose = $r['dose'];
																												$num = $r['num'];
																												$duration = $r['duration'];
																												$dose_s = $r['dose_s'];
																												$note = $r['note'];
																												$quantity = $r['presc_quantity'];
																												$name = $dose_t = $num_t = $duration_t = $dose_s_t = '';
																												$name = get_val_arr('gnr_m_medicines', 'name', $mad_id, 'm');
																												if ($dose) {
																													$dose_t = get_val_arr('gnr_m_medicines_doses', 'name_' . $lg, $dose, 'm1');
																												}
																												if ($num) {
																													$num_t = get_val_arr('gnr_m_medicines_times', 'name_' . $lg, $num, 'm2');
																												}
																												if ($duration) {
																													$duration_t = get_val_arr('gnr_m_medicines_duration', 'name_' . $lg, $duration, 'm3');
																												}
																												if ($dose_s) {
																													$dose_s_t = get_val_arr('gnr_m_medicines_doses_status', 'name_' . $lg, $dose_s, 'm4');
																												}
																												echo '
				<tr >
					<td>
					<div class="fl lh20 B">' . $name . '<br>
						<span class="clr55" >' . $note . '</span>
					</div>
					</td>
					<td>' . $dose_t . '</td>
					<td>' . $num_t . '</td>
					<td>' . $dose_s_t . '</td>
					<td>' . $duration_t . '</td>
					<td class="TC"><ff>' . $quantity . '</ff></td>
				</tr>';
																											}
																											echo '</table>';
																										}
																										/********Actions**********************/
																										$sql = "select * from phr_x_presc_actions where presc_id='$id' order by date ASC";
																										$res = mysql_q($sql);
																										$rows = mysql_n($res);
																										if ($rows) {
																											echo '
			<div class="f1 fs14 mg10t lh40"> ' . k_prev_surgeries . ' ( ' . $rows . ' )</div>
            <div class="bord pd10f br5 cbg444">';
																											while ($r = mysql_f($res)) {
																												$date = $r['date'];
																												$user = get_val_arr('_users', 'name_' . $lg, $r['user'], 'u');
																												$action = $r['action'];
																												echo '<div class=" f1 lh30 ' . $presc_pr_status[$action][1] . '">' . date('Y-m-d  A h:i:s', $date) . ' | ';
																												if ($action == 1) {
																													echo $user . k_print_pres;
																												} else {
																													echo $user . k_dis_the_pre;
																												}
																												echo '</div>';
																											}
																											echo '</div>';
																										}
																									} else {
																										echo 0;
																									}
																								} ?>