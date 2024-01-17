<? $repCode = 'den';
$pageSize = 'print_page4';
/**************************************************/
$head = 1;
$breakC = '^';
$page_mood = 0;
if (isset($_GET['mood'])) {
	$page_mood = intval($_GET['mood']);
}
if ($page_mood == 2) {
	include("../../__sys/prcds/ajax_head_cFile.php");
} else {
	include("../../__sys/prcds/ajax_header.php");
}
reportStart($page_mood);
$report_kWord = '' . k_repot . '';
/*******Report Title*******************************/
if ($page == 1) {
	$title1 = ' ' . k_trtmnt_procs . ' ';
	if ($tab == 1) {
		$titleVal = reportTapTitle('day');
	}
	if ($tab == 2) {
		$titleVal = reportTapTitle('month');
	}
	if ($tab == 3) {
		$titleVal = reportTapTitle('year');
	}
	if ($tab == 4) {
		$title2 = k_general_report;
	}
	if ($tab == 5) {
		$titleVal = reportTapTitle('date');
	}
}
if ($page == 2) {
	$title1 = ' ' . k_trtmnt_procs . ' ';
	if ($tab == 1) {
		$titleVal = reportTapTitle('day');
	}
}
if ($page == 3) {
	$title1 = k_teeth_shift;
	if ($tab == 1) {
		$titleVal = reportTapTitle('day');
	}
	if ($tab == 2) {
		$titleVal = reportTapTitle('month');
	}
}
if ($page == 4) {
	$title1 = k_den_ser_sta;
	if ($tab == 1) {
		$titleVal = reportTapTitle('day');
	}
	if ($tab == 2) {
		$titleVal = reportTapTitle('month');
	}
	if ($tab == 3) {
		$titleVal = reportTapTitle('date');
	}
}
if ($page == 5) {
	$title1 = k_fin_ser_sta;
	if ($tab == 1) {
		$titleVal = reportTapTitle('day');
	}
	if ($tab == 2) {
		$titleVal = reportTapTitle('month');
	}
	if ($tab == 3) {
		$titleVal = reportTapTitle('date');
	}
}
/*******Export File Name*******************************/
if ($page == 1) {
	$fileName = 'den_';
	if ($tab == 1) {
		$fileName .= 'day';
	}
	if ($tab == 2) {
		$fileName .= 'month';
	}
	if ($tab == 3) {
		$fileName .= 'year';
	}
	if ($tab == 4) {
		$fileName .= 'all';
	}
	if ($tab == 5) {
		$fileName .= 'dateRang';
	}
}
if ($page == 2) {
	$fileName = 'den_';
	if ($tab == 1) {
		$fileName .= 'day';
	}
}
if ($page == 3) {
	$fileName = 'den_';
	if ($tab == 1) {
		$fileName .= 'day';
	}
	if ($tab == 2) {
		$fileName .= 'month';
	}
}
if ($page == 4) {
	$fileName = 'den_st_';
	if ($tab == 1) {
		$fileName .= 'day';
	}
	if ($tab == 2) {
		$fileName .= 'month';
	}
	if ($tab == 3) {
		$fileName .= 'dateRang';
	}
}
if ($page == 5) {
	$fileName = 'den_sf_';
	if ($tab == 1) {
		$fileName .= 'day';
	}
	if ($tab == 2) {
		$fileName .= 'month';
	}
	if ($tab == 3) {
		$fileName .= 'dateRang';
	}
}
/**************************************************/
echo reportPageSet($page_mood, $fileName);
/**************************************************/
if ($page == 1) {
	if ($tab == 1) {
		echo repoNav($fil, 1, $page, $tab, 1, 1, $page_mood);
		$d_s = $todyU;
		$d_e = $d_s + 86400;
		if ($val) {
			$add_title = get_val('_users', 'name_' . $lg, $val);
			$sql = "select * from den_x_visits_services_levels where date_e>='$d_s' and date_e < '$d_e' and status=2 and doc='$val' order by date_e ASC";
			$res = mysql_q($sql);
			$rows = mysql_n($res);
			echo $breakC;
			echo repTitleShow();
			echo '<div class="f1 fs14 clr1 lh40">' . $add_title . '</div>';

			if ($rows > 0) { ?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<tr>
						<th width="30"><?= k_visit_num ?></th>
						<th><?= k_patient ?></th>
						<? if (!$val) { ?><th><?= k_dr ?></th><? } ?>
						<th><?= k_level ?></th>
						<th><?= k_level_percent ?></th>
						<th><?= k_done ?></th>
						<th><?= k_perc_doc ?></th>
						<th><?= k_doctor_share ?></th>
					</tr>
					<?
					while ($r = mysql_f($res)) {
						$patient = $r['patient'];
						$vis = $r['vis'];
						$doc = $r['doc'];
						$service = $r['service'];
						$lev = $r['lev'];
						$price = $r['price'];
						$lev_perc = $r['lev_perc'];
						$doc_prec = $r['doc_prec'];
						$doc_part = $r['doc_part'];
						$prices += $price;
						$prcs += $doc_part;
						$docName = get_val_arr('_users', 'name_' . $lg, $doc, 'd');
						$patientName = get_val_arr('gnr_m_patien', 'name_' . $lg, $clinic, 'c');
						$servTxt = get_val_arr('den_m_services', 'name_' . $lg, $service, 's');
						$levelTxt = get_val_arr('den_m_services_levels', 'name_' . $lg, $lev, 'l');
						echo '
					<tr>
					<td><ff>#' . $vis . '</ff></td>
					<td txt><div class="f1 fs14 clr5 Over" onclick="accStat(' . $patient . ')" class="Over">' . get_p_name($patient) . '</div></td>';
						if (!$val) {
							echo '<td txt>' . $docName . '</td>';
						}
						echo '<td txt>' . $servTxt . ' <ff> &raquo; </ff> ' . $levelTxt . '</td>
					<td><ff class="clr1">' . number_format($lev_perc) . '%</ff></td>
					<td><ff class="clr6">' . number_format($price) . '</ff></td>
					<td><ff class="clr1">' . number_format($doc_prec) . '%</ff></td>
					<td><ff class="clr6">' . number_format($doc_part) . '</ff></td>
					</tr>';
					}
					echo '
				<tr fot>
				<td colspan="4" class="f1 fs14" style="text-align:' . k_Xalign . '">' . k_total . '</td>
				<td><ff class="clr6">' . number_format($prices) . '</ff></td>
				<td><ff>-</ff></td>
				<td><ff class="clr6">' . number_format($prcs) . '</ff></td>
				</tr>';
					?>
				</table><?
					} else {
						echo '<div class="f1 fs14 clr5">' . k_no_lvls . '</div>';
					}
				} else {
					echo $breakC;
					echo repTitleShow();
					$sql = "select id,name_$lg,subgrp from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						?><table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<tr>
						<th><?= k_dr ?></th>
						<th><?= k_clinic ?></th>
						<th><?= k_visits ?></th>
						<th><?= k_treatment ?></th>
						<th><?= k_cons ?></th>
						<th><?= k_the_proced ?></th>
						<th><?= k_levels ?></th>
						<th><?= k_val_levels ?></th>
						<th><?= k_doctor_share ?></th>
					</tr><?
							$totals = array();
							while ($r = mysql_f($res)) {
								$doc_id = $r['id'];
								$name = $r['name_' . $lg];
								$clinic = $r['subgrp'];
								$q = " and  d_start>='$d_s' and d_start < '$d_e' ";
								$q2 = " and  date_e>='$d_s' and date_e < '$d_e' ";
								$vis = getTotalCO('den_x_visits', "status=2 and doctor='$doc_id' $q");
								$totals['vis'] += $vis;
								$v_pro = getTotalCO('den_x_visits', "status=2 and doctor='$doc_id' and type='1' $q ");
								$totals['v_pro'] += $v_pro;
								$v_con = getTotalCO('den_x_visits', "status=2 and doctor='$doc_id' and type='2' $q ");
								$totals['v_con'] += $v_con;
								$srvs = getTotalCO('den_x_visits_services', "status=1 and doc='$doc_id' $q ");
								$totals['srvs'] += $srvs;
								$levels = getTotalCO('den_x_visits_services_levels', "status=2 and doc='$doc_id' $q2 ");
								$totals['levels'] += $levels;
								$levels_values = get_sum('den_x_visits_services_levels', 'price', "status=2 and doc='$doc_id' $q2 ");
								$totals['levels_values'] += $levels_values;
								$doc_part = get_sum('den_x_visits_services_levels', 'doc_part', "status=2 and doc='$doc_id' $q2 ");
								$totals['doc_part'] += $doc_part;
								if ($vis || $srvs || $levels) {
									echo '<tr>
						<td txt class="cur Over" onclick="chnRepVal(' . $doc_id . ')">' . $name . '</td>
						<td txt>' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'n') . '</td>
						<td><ff class="clr1">' . number_format($vis) . '</div></td>					
						<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
						<td><ff class="clr6">' . number_format($v_con) . '</div></td>
						<td><ff class="clr66">' . number_format($srvs) . '</div></td>
						<td><ff class="clr66">' . number_format($levels) . '</div></td>
						<td><ff class="clr6">' . number_format($levels_values) . '</div></td>					
						<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
						</tr>';
								}
							}
							echo '<tr fot>
				<td txt colspan="2" class="TR" style="TR">' . k_total . '</td>				
				<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
				<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>					
				<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
				</tr>
				</table>';
						}
					}
				}
				if ($tab == 2) {
					echo repoNav($fil, 2, $page, $tab, 1, 1, $page_mood);
					$d_s = $mm;
					$d_e = $d_s + (($monLen) * 86400);
					if ($val) {
						$add_title = get_val('_users', 'name_' . $lg, $val);
						$doc_id = $val;
						echo $breakC;
						echo repTitleShow();
						echo '<div class="f1 fs14 clr1 lh40">' . $add_title . '</div>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th>' . k_day . '</th>					
				<th>' . k_visits . '</th>
				<th>' . k_treatment . '</th>
				<th>' . k_cons . '</th>
				<th>' . k_the_proced . '</th>
				<th>' . k_levels . '</th>
				<th> ' . k_val_levels . ' </th>					
				<th>' . k_doctor_share . '</th>                    
			</tr>';
						for ($ss = 0; $ss < $monLen; $ss++) {
							$d_s = $mm + ($ss * 86400);
							$d_e = $d_s + 86400;
							$q = " and  date>='$d_s' and date < '$d_e' ";
							list($vis, $v_pro, $v_con, $srvs, $levels, $levels_values, $doc_part) = get_sum('den_r_docs', 'vis,vis_session,vis_consul,service,levels,levels_values,doc_part', " doc='$doc_id' $q");
							$totals['vis'] += $vis;
							$totals['v_pro'] += $v_pro;
							$totals['v_con'] += $v_con;
							$totals['srvs'] += $srvs;
							$totals['levels'] += $levels;
							$totals['levels_values'] += $levels_values;
							$totals['doc_part'] += $doc_part;
							if ($vis || $srvs || $levels) {
								echo '<tr>
					<td><div class="ff fs18 B txt_Over" onclick="reloadRep(' . $page . ',1,' . $d_s . ')">' . ($ss + 1) . '</div></td>
					<td><ff class="clr1">' . number_format($vis) . '</div></td>					
					<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
					<td><ff class="clr6">' . number_format($v_con) . '</div></td>
					<td><ff class="clr66">' . number_format($srvs) . '</div></td>
					<td><ff class="clr66">' . number_format($levels) . '</div></td>
					<td><ff class="clr6">' . number_format($levels_values) . '</div></td>					
					<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
					</tr>';
							}
						}
						echo '<tr fot>
			<td txt >' . k_total . '</td>				
			<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
			<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
			<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
			<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
			<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
			<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>				
			<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
			</tr>
			</table>';
					} else {
						echo $breakC;
						echo repTitleShow();
						$sql = "select id,name_$lg,subgrp from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
						$res = mysql_q($sql);
						$rows = mysql_n($res);
						if ($rows > 0) {
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th>' . k_dr . '</th>
					<th>' . k_clinic . '</th>
					<th>' . k_visits . '</th>
					<th>' . k_treatment . '</th>
					<th>' . k_cons . '</th>
					<th>' . k_the_proced . '</th>
					<th>' . k_levels . '</th>
				    <th> ' . k_val_levels . ' </th>						
					<th>' . k_doctor_share . '</th>                    
				</tr>';
							$totals = array();
							while ($r = mysql_f($res)) {
								$doc_id = $r['id'];
								$name = $r['name_' . $lg];
								$clinic = $r['subgrp'];
								$q = " and  date>='$d_s' and date < '$d_e' ";
								list($vis, $v_pro, $v_con, $srvs, $levels, $levels_values, $doc_part) = get_sum('den_r_docs', 'vis,vis_session,vis_consul,service,levels,levels_values,doc_part', " doc='$doc_id' $q");
								$totals['vis'] += $vis;
								$totals['v_pro'] += $v_pro;
								$totals['v_con'] += $v_con;
								$totals['srvs'] += $srvs;
								$totals['levels'] += $levels;
								$totals['levels_values'] += $levels_values;
								$totals['doc_part'] += $doc_part;
								if ($vis || $srvs || $levels) {
									echo '<tr>
						<td txt class="cur Over" onclick="chnRepVal(' . $doc_id . ')">' . $name . '</td>
						<td txt>' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'n') . '</td>
						<td><ff class="clr1">' . number_format($vis) . '</div></td>					
						<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
						<td><ff class="clr6">' . number_format($v_con) . '</div></td>
						<td><ff class="clr66">' . number_format($srvs) . '</div></td>
						<td><ff class="clr66">' . number_format($levels) . '</div></td>
						<td><ff class="clr6">' . number_format($levels_values) . '</div></td>					
						<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
						</tr>';
								}
							}
							echo '<tr fot>
				<td txt colspan="2">' . k_total . '</td>				
				<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
				<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>					
				<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
				</tr>
				</table>';
						}
					}
				}
				if ($tab == 3) {
					echo repoNav($fil, 3, $page, $tab, 1, 1, $page_mood);
					$d_s = mktime(0, 0, 0, 1, 1, $selYear);
					$d_e = mktime(0, 0, 0, 1, 1, $selYear + 1);
					if ($val) {
						$add_title = get_val('_users', 'name_' . $lg, $val);
						$doc_id = $val;
						echo $breakC;
						echo repTitleShow();
						echo '<div class="f1 fs14 clr1 lh40">' . $add_title . '</div>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th>' . k_month . '</th>
				<th>' . k_visits . '</th>
				<th>' . k_treatment . '</th>
				<th>' . k_cons . '</th>
				<th>' . k_the_proced . '</th>
				<th>' . k_levels . '</th>
				<th> ' . k_val_levels . ' </th>				
				<th>' . k_doctor_share . '</th>                    
			</tr>';
						for ($ss = 1; $ss < 13; $ss++) {
							$d_s = mktime(0, 0, 0, $ss, 1, $selYear);
							$d_e = mktime(0, 0, 0, $ss + 1, 1, $selYear);
							$q = " and  date>='$d_s' and date < '$d_e' ";
							list($vis, $v_pro, $v_con, $srvs, $levels, $levels_values, $doc_part) = get_sum('den_r_docs', 'vis,vis_session,vis_consul,service,levels,levels_values,doc_part', " doc='$doc_id' $q");
							$totals['vis'] += $vis;
							$totals['v_pro'] += $v_pro;
							$totals['v_con'] += $v_con;
							$totals['srvs'] += $srvs;
							$totals['levels'] += $levels;
							$totals['levels_values'] += $levels_values;
							$totals['doc_part'] += $doc_part;
							if ($vis || $srvs || $levels) {
								echo '<tr>
					<td txt class="Over" onclick="reloadRep(' . $page . ',2,\'' . ($selYear . '-' . $ss) . '\')">' . $monthsNames[$ss] . '</td>
					<td><ff class="clr1">' . number_format($vis) . '</div></td>					
					<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
					<td><ff class="clr6">' . number_format($v_con) . '</div></td>
					<td><ff class="clr66">' . number_format($srvs) . '</div></td>
					<td><ff class="clr66">' . number_format($levels) . '</div></td>
					<td><ff class="clr6">' . number_format($levels_values) . '</div></td>					
					<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
					</tr>';
							}
						}
						echo '<tr fot>
			<td txt >' . k_total . '</td>				
			<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
			<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
			<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
			<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
			<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
			<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>					
			<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
			</tr>
			</table>';
					} else {
						echo $breakC;
						echo repTitleShow();
						$sql = "select id,name_$lg,subgrp from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
						$res = mysql_q($sql);
						$rows = mysql_n($res);
						if ($rows > 0) {
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th>' . k_dr . '</th>
					<th>' . k_clinic . '</th>
					<th>' . k_visits . '</th>
					<th>' . k_treatment . '</th>
					<th>' . k_cons . '</th>
					<th>' . k_the_proced . '</th>
					<th>' . k_levels . '</th>
				    <th> ' . k_val_levels . ' </th>					
					<th>' . k_doctor_share . '</th>                    
				</tr>';
							$totals = array();
							while ($r = mysql_f($res)) {
								$doc_id = $r['id'];
								$name = $r['name_' . $lg];
								$clinic = $r['subgrp'];
								$q = " and  date>='$d_s' and date < '$d_e' ";
								list($vis, $v_pro, $v_con, $srvs, $levels, $levels_values, $doc_part) = get_sum('den_r_docs', 'vis,vis_session,vis_consul,service,levels,levels_values,doc_part', " doc='$doc_id' $q");
								$totals['vis'] += $vis;
								$totals['v_pro'] += $v_pro;
								$totals['v_con'] += $v_con;
								$totals['srvs'] += $srvs;
								$totals['levels'] += $levels;
								$totals['levels_values'] += $levels_values;
								$totals['doc_part'] += $doc_part;
								if ($vis || $srvs || $levels) {
									echo '<tr>
						<td txt class="cur Over" onclick="chnRepVal(' . $doc_id . ')">' . $name . '</td>
						<td txt>' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'n') . '</td>
						<td><ff class="clr1">' . number_format($vis) . '</div></td>					
						<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
						<td><ff class="clr6">' . number_format($v_con) . '</div></td>
						<td><ff class="clr66">' . number_format($srvs) . '</div></td>
						<td><ff class="clr66">' . number_format($levels) . '</div></td>
						<td><ff class="clr6">' . number_format($levels_values) . '</div></td>					
						<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
						</tr>';
								}
							}
							echo '<tr fot>
				<td txt colspan="2">' . k_total . '</td>				
				<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
				<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>					
				<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
				</tr>
				</table>';
						}
					}
				}
				if ($tab == 4) {
					echo repoNav($fil, 0, $page, $tab, 1, 1, $page_mood);
					if ($val) {
						$add_title = get_val('_users', 'name_' . $lg, $val);
						$doc_id = $val;
						echo $breakC;
						echo repTitleShow();
						echo '<div class="f1 fs14 clr1 lh40">' . $add_title . '</div>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH"><tr>
				<th>' . k_year . '</th>
				<th>' . k_visits . '</th>
				<th>' . k_treatment . '</th>
				<th>' . k_cons . '</th>
				<th>' . k_the_proced . '</th>
				<th>' . k_levels . '</th>
				 <th> ' . k_val_levels . ' </th>			
				<th>' . k_doctor_share . '</th>                    
			</tr>';
						$years = getYearsOfRec('den_r_docs', 'date', str_replace('and', '', " doc='$doc_id' "));
						if ($years[0] != 0) {
							for ($ss = $years[0]; $ss <= $years[1]; $ss++) {
								$d_s = strtotime($ss . '-1-1');
								$d_e = strtotime(($ss + 1) . '-1-1');
								$q = " and  date>='$d_s' and date < '$d_e' ";
								list($vis, $v_pro, $v_con, $srvs, $levels, $levels_values, $doc_part) = get_sum('den_r_docs', 'vis,vis_session,vis_consul,service,levels,levels_values,doc_part', " doc='$doc_id' $q");
								$totals['vis'] += $vis;
								$totals['v_pro'] += $v_pro;
								$totals['v_con'] += $v_con;
								$totals['srvs'] += $srvs;
								$totals['levels'] += $levels;
								$totals['levels_values'] += $levels_values;
								$totals['doc_part'] += $doc_part;
								if ($vis || $srvs || $levels) {
									echo '<tr>
						<td class="Over" onclick="reloadRep(' . $page . ',3,\'' . $ss . '\')"><ff>' . $ss . '</ff></td>
						<td><ff class="clr1">' . number_format($vis) . '</div></td>					
						<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
						<td><ff class="clr6">' . number_format($v_con) . '</div></td>
						<td><ff class="clr66">' . number_format($srvs) . '</div></td>
						<td><ff class="clr66">' . number_format($levels) . '</div></td>
						<td><ff class="clr6">' . number_format($levels_values) . '</div></td>					
						<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
						</tr>';
								}
							}
							echo '<tr fot>
				<td txt >' . k_total . '</td>				
				<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
				<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>					
				<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
				</tr>';
						}
						echo '</table>';
					} else {
						echo $breakC;
						echo repTitleShow();
						$sql = "select id,name_$lg,subgrp from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
						$res = mysql_q($sql);
						$rows = mysql_n($res);
						if ($rows > 0) {
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th>' . k_dr . '</th>
					<th>' . k_clinic . '</th>
					<th>' . k_visits . '</th>
					<th>' . k_treatment . '</th>
					<th>' . k_cons . '</th>
					<th>' . k_the_proced . '</th>
					<th>' . k_levels . '</th>
				    <th> ' . k_val_levels . ' </th>				
					<th>' . k_doctor_share . '</th>                    
				</tr>';
							$totals = array();
							while ($r = mysql_f($res)) {
								$doc_id = $r['id'];
								$name = $r['name_' . $lg];
								$clinic = $r['subgrp'];
								$q = " ";
								list($vis, $v_pro, $v_con, $srvs, $levels, $levels_values, $doc_part) = get_sum('den_r_docs', 'vis,vis_session,vis_consul,service,levels,levels_values,doc_part', " doc='$doc_id' $q");
								$totals['vis'] += $vis;
								$totals['v_pro'] += $v_pro;
								$totals['v_con'] += $v_con;
								$totals['srvs'] += $srvs;
								$totals['levels'] += $levels;
								$totals['levels_values'] += $levels_values;
								$totals['doc_part'] += $doc_part;
								if ($vis || $srvs || $levels) {
									echo '<tr>
						<td txt class="cur Over" onclick="chnRepVal(' . $doc_id . ')">' . $name . '</td>
						<td txt>' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'n') . '</td>
						<td><ff class="clr1">' . number_format($vis) . '</div></td>					
						<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
						<td><ff class="clr6">' . number_format($v_con) . '</div></td>
						<td><ff class="clr66">' . number_format($srvs) . '</div></td>
						<td><ff class="clr66">' . number_format($levels) . '</div></td>
						<td><ff class="clr6">' . number_format($levels_values) . '</div></td>					
						<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
						</tr>';
								}
							}
							echo '<tr fot>
				<td txt colspan="2">' . k_total . '</td>				
				<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
				<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
				<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
				<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>					
				<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
				</tr>
				</table>';
						}
					}
				}
				if ($tab == 5) {
					echo repoNav($fil, 4, $page, $tab, 1, 1, $page_mood);
					$d_s = strtotime($df);
					$d_e = strtotime($dt) + 86400;
					echo $breakC;
					echo repTitleShow();
					$sql = "select id,name_$lg,subgrp from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th>' . k_dr . '</th>
				<th>' . k_clinic . '</th>
				<th>' . k_visits . '</th>
				<th>' . k_treatment . '</th>
				<th>' . k_cons . '</th>
				<th>' . k_the_proced . '</th>
				<th>' . k_levels . '</th>
				<th> ' . k_val_levels . ' </th>				
				<th>' . k_doctor_share . '</th>                    
			</tr>';
						$totals = array();
						while ($r = mysql_f($res)) {
							$doc_id = $r['id'];
							$name = $r['name_' . $lg];
							$clinic = $r['subgrp'];
							$q = " and  date>='$d_s' and date < '$d_e' ";
							list($vis, $v_pro, $v_con, $srvs, $levels, $levels_values, $doc_part) = get_sum('den_r_docs', 'vis,vis_session,vis_consul,service,levels,levels_values,doc_part', " doc='$doc_id' $q");
							$totals['vis'] += $vis;
							$totals['v_pro'] += $v_pro;
							$totals['v_con'] += $v_con;
							$totals['srvs'] += $srvs;
							$totals['levels'] += $levels;
							$totals['levels_values'] += $levels_values;
							$totals['doc_part'] += $doc_part;
							if ($vis || $srvs || $levels) {
								echo '<tr>
					<td txt class="cur Over" onclick="chnRepVal(' . $doc_id . ')">' . $name . '</td>
					<td txt>' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'n') . '</td>
					<td><ff class="clr1">' . number_format($vis) . '</div></td>					
					<td><ff class="clr6">' . number_format($v_pro) . '</div></td>
					<td><ff class="clr6">' . number_format($v_con) . '</div></td>
					<td><ff class="clr66">' . number_format($srvs) . '</div></td>
					<td><ff class="clr66">' . number_format($levels) . '</div></td>
					<td><ff class="clr6">' . number_format($levels_values) . '</div></td>				
					<td><ff class="clr5">' . number_format($doc_part) . '</ff></td>                    
					</tr>';
							}
						}
						echo '<tr fot>
			<td txt colspan="2">' . k_total . '</td>				
			<td><ff class="clr1">' . number_format($totals['vis']) . '</div></td>					
			<td><ff class="clr6">' . number_format($totals['v_pro']) . '</div></td>
			<td><ff class="clr6">' . number_format($totals['v_con']) . '</div></td>
			<td><ff class="clr66">' . number_format($totals['srvs']) . '</div></td>
			<td><ff class="clr66">' . number_format($totals['levels']) . '</div></td>
			<td><ff class="clr6">' . number_format($totals['levels_values']) . '</div></td>			
			<td><ff class="clr5">' . number_format($totals['doc_part']) . '</ff></td>                    
			</tr>
			</table>';
					}
				}
				if ($tab == 6) {
					echo repoNav($fil, 4, $page, $tab, 1, 1, $page_mood);
					$d_ss = strtotime($df);
					$d_ee = strtotime($dt) + 86400;
					if ($d_ss < $d_ee) {
						if ($val) {
							$q = " and doc='$val' ";
							echo '<div class="f1 fs18 clr1 lh40">' . get_val('_users', 'name_' . $lg, $val) . '</div>';

							echo $breakC; ?>
				<?

						} else {
							echo $breakC; ?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
						<tr>
							<th><?= k_dr ?></th>
							<th><?= k_done ?></th>
							<th><?= k_payms ?></th>
							<th><?= k_balance ?></th>
						</tr>
						<?
							$t1 = $t2 = 0;
							$sql = "select * from _users where grp_code='fk590v9lvl' order by name_$lg ASC";
							$res = mysql_q($sql);
							while ($r = mysql_f($res)) {
								$u_id = $r['id'];
								$srvDone = get_sum('den_x_visits_services_levels', 'price', "date_e>='$d_ss' and date_e < '$d_ee' and status=2 and doc='$u_id' ");
								$cashIn = get_sum('gnr_x_acc_patient_payments', 'amount', "date>='$d_ss' and date < '$d_ee' and doc='$u_id' and type in(0,1,3,4) and mood=4");
								$cashOut = get_sum('gnr_x_acc_patient_payments', 'amount', "date>='$d_ss' and date < '$d_ee' and doc='$u_id' and type in(2) and mood=4");
								$pay = $cashIn - $cashOut;
								$bal = $srvDone - $pay;
								$clr = 'clr6';
								if ($bal > 0) {
									$clr = 'clr5';
								}
								$t1 += $srvDone;
								$t2 += $pay;
						?>
							<tr>
								<td txt><?= $r['name_' . $lg] ?></td>
								<td>
									<ff class="clr1"><?= number_format($srvDone) ?></ff>
								</td>
								<td>
									<ff class="clr11"><?= number_format($pay) ?></ff>
								</td>
								<td>
									<ff class="<?= $clr ?>"><?= number_format($bal) ?></ff>
								</td>
							</tr><?
								}
								$bal = $t1 - $t2;
								$clr = 'clr6';
								if ($bal > 0) {
									$clr = 'clr5';
								}
									?>
						<tr fot>
							<td class="f1 fs14"><?= k_ggre ?></td>
							<td>
								<ff class="clr1"><?= number_format($t1) ?></ff>
							</td>
							<td>
								<ff class="clr11"><?= number_format($t2) ?></ff>
							</td>
							<td>
								<ff class="<?= $clr ?>"><?= number_format($bal) ?></ff>
							</td>
						</tr>
					</table><?
						}
					} else {
						echo '<div class="f1 fs16 clr5">' . k_err_ent_date . '</div>';
					}
				}
			}
			if ($page == 2) {
				if ($tab == 1) {
					echo repoNav($fil, 1, $page, $tab, 1, 1, $page_mood);
					$d_s = $todyU;
					$d_e = $d_s + 86400;
					$pats = array();
					$q = "  d_start>='$d_s' and d_start < '$d_e' ";
					$q2 = "  date_e>='$d_s' and date_e < '$d_e' ";
					$q3 = "  date>='$d_s' and date < '$d_e' ";
					if ($val) {
						$q .= "and doctor='$val'";
						$add_title = get_val('_users', 'name_' . $lg, $val);
					}
					$add_title = get_val('_users', 'name_' . $lg, $val);

					echo $breakC;
					echo repTitleShow();

					$data = array();
					$sql = "select * from den_x_visits where $q order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows) { ?>
				<div class="f1 fs16 clr1111 lh40"><?= $add_title ?> <?= k_visits ?> <ff> ( <?= $rows ?> )</ff>
				</div><?
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" >
			<tr>
				<th width="60">' . k_thvisit . '</th>
				<th width="100">' . k_the_time . '</th>	
				<th>' . k_patient . '</th>
				<th>' . k_doctor . '</th>
				<th>' . k_reception . '</th>
				<th>' . k_cmpt_srvcs . '</th>
				<th>' . k_val_of_completed . '</th>
				<th>' . k_paym . '</th>
				<th>' . k_difference . '</th>				
			</tr>';
						$allService = $allPayment = 0;
						while ($r = mysql_f($res)) {
							$date = $r['d_start'];
							$vis = $r['id'];
							$patient = $r['patient'];
							array_push($pats, $patient);
							$doc = $r['doctor'];
							$reg_user = $r['reg_user'];
							$clinic = $r['clinic'];
							list($docTxt, $code) = get_val_arr('_users', "name_$lg,career_code", $doc, 'doc');
							$recTxt = get_val_arr('_users', "name_$lg", $reg_user, 'doc');
							if ($code) {
								$code = ' <ff class="clr5"> ( ' . $code . ' )';
							}
							$srvData = '<table>';
							$sql2 = "select * from den_x_visits_services_levels where $q2 and doc='$doc' and status=2 and patient='$patient' order by x_srv ASC";
							$res2 = mysql_q($sql2);
							$totalPrice = $amount = 0;
							$actSrv = 0;
							while ($r2 = mysql_f($res2)) {
								$srv = $r2['service'];
								$lev = $r2['lev'];
								$price = $r2['price'];
								$x_srv = $r2['x_srv'];
								$totalPrice += $price;
								$srvTxt = get_val_arr('den_m_services', 'name_' . $lg, $srv, 'srv');
								list($srvPrice, $teeth) = get_val_arr('den_x_visits_services', 'pay_net,teeth', $x_srv, 'srvp');
								$teethTxt = '';
								if ($teeth) {
									$teethTxt = '<ff class="cbg55 clrw pd5 mg5">' . $teeth . '</ff>';
								}
								$levTxt = get_val_arr('den_m_services_levels', 'name_' . $lg, $lev, 'lev');

								$srvData .= '<tr>';
								if ($actSrv != $x_srv) {
									$srvData .= '
						<td><div class="f1 fs14 clr1">' . $lev . '-' . splitNo($srvTxt) . '</div></td>
						<td><ff class="clr1">' . number_format($srvPrice) . '</ff></td>';
								} else {
									$srvData .= '<td colspan="2"></td>';
								}
								$srvData .= '<td class="f1">' . $teethTxt . ' / ' . splitNo($levTxt) . '</td><td><ff14>' . number_format($price) . '</ff14></td></tr>';
								$actSrv = $x_srv;
							}
							$srvData .= '</table>';
							$amount = get_sum('gnr_x_acc_patient_payments', 'amount', " mood=4 and sub_mood='$vis' OR ( $q3 and  sub_mood=0 and doc='$doc' and patient='$patient') ");
							$allService += $totalPrice;
							$allPayment += $amount;
							echo '
				<tr>
					<td><ff>#' . $vis . '</ff></td>
					<td><ff>' . date('A h:i', $date) . '</ff></td>
					<td txt><div class="clr5 Over f1 fs14" onclick="accStat(' . $patient . ')">' . get_p_name($patient) . '</div></td>		
					<td txt>' . $docTxt . $code . '</td>
					<td txt>' . $recTxt . '</td>
					<td><div class="TL">' . $srvData . '</div></td>
					<td><ff class="clr1">' . number_format($totalPrice) . '</ff></td>
					<td><ff class="clr6">' . number_format($amount) . '</ff></td>
					<td><ff class="clr9">' . number_format($amount - $totalPrice) . '</ff></td>
				</tr>';
						}
						echo '
			<tr fot>
				<td txt colspan="6">' . k_the_total . '</td>
				<td><ff class="clr1">' . number_format($allService) . '</ff></td>
				<td><ff class="clr6">' . number_format($allPayment) . '</ff></td>
				<td><ff class="clr9">' . number_format($allPayment - $allService) . '</ff></td>
			</tr>
			</table>';
					}
					/***********************/
					$patsTxt = implode(',', $pats);
					$Qp = '';
					//if($patsTxt){$Qp=" and patient NOT IN($patsTxt) ";}
					$sql = "select * from gnr_x_acc_patient_payments where mood=4 and sub_mood=0 and $q3 $Qp order by date ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows) { ?>
				<div class="f1 fs18 clr1 lh40"><?= k_indep_pays ?><ff> ( <?= $rows ?> )</ff>
				</div>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
					<tr>
						<th width="120"><?= k_thnum ?></th>
						<th width="120"><?= k_the_date ?></th>
						<th width="120"><?= k_doctor ?></th>
						<th><?= k_patient ?></th>
						<th><?= k_paym ?></th>
					</tr><?
							while ($r = mysql_f($res)) {
								$id = $r['id'];
								$amount = $r['amount'];
								$date = $r['date'];
								$patient = $r['patient'];
								$clr = '';
								if (in_array($patient, $pats)) {
									$clr = ' cbg555';
								}
								$doc = $r['doc'];
								$docName = get_val_arr('_users', 'name_' . $lg, $doc, 'd');
								$pay_id = $r['payment_id'];
								echo '
				<tr>
					<td><ff>#' . $id . '|#' . $pay_id . '</ff></td>
					<td><ff>' . date('A h:i', $date) . '</ff></td>
					<td txt><div class="f1 fs14">' . $docName . '</div></td>
					<td txt class="' . $clr . '"><div class="clr5 Over f1 fs14 " onclick="accStat(' . $patient . ')">' . get_p_name($patient) . '</div></td>	
					<td><ff class="clr6">' . number_format($amount) . '</ff></td>
				</tr>';
							}
							echo '</table>';
						}
					}
				}
				if ($page == 3) {
					$x_times = array('8-15', '15-22');
					if ($tab == 1) {
						echo repoNav($fil, 1, $page, $tab, 1, 1, $page_mood);
						$d_s = $todyU;
						$d_e = $d_s + 86400;
						echo $breakC;
						echo repTitleShow();
						$tot = array();
						$sql = "select id , name_$lg from  _users  where grp_code='fk590v9lvl' order by name_$lg ASC ";
						$res = mysql_q($sql);
						$rows = mysql_n($res);
						if ($rows > 0) {
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>			
				<th>' . k_dr . '</th>';
							foreach ($x_times as $x) {
								echo '<th><ff>' . $x . '</ff></th>';
							}
							echo '<th colspan="' . count($x_times) . '">' . k_total . '</th>
			</tr>';
							$i = 0;
							while ($r = mysql_f($res)) {
								$doc_id = $r['id'];
								$docTxt = $r['name_' . $lg];
								$total = 0;
								$row = '<tr><td txt>' . $docTxt . '</td>';
								$i = 0;
								foreach ($x_times as $x) {
									$xx = explode('-', $x);
									$sH = $xx[0] * 3600;
									$eH = $xx[1] * 3600;
									$t_s = $d_s + $sH;
									$t_e = $d_s + $eH;
									$q = " and date >= $t_s and date < $t_e ";
									$amount = get_sum('gnr_x_acc_patient_payments', 'amount', " doc='$doc_id' $q");
									$tot[$i] += $amount;
									$total += $amount;
									$row .= '<td><ff>' . number_format($amount) . '</ff></td>';
									$i++;
								}
								$row .= '<td ><ff>' . number_format($total) . '</ff></td></tr>';
								if ($total) {
									echo $row;
								}
							}
							$total = array_sum($tot);
							echo '<tr fot><td txt>' . k_total . '</td>';
							foreach ($tot as $x) {
								$pece = $x * 100 / $total;
								echo '<td><ff>' . number_format($x) . '</ff><ff class="clr5"> (%' . number_format($pece, 2) . ')</ff></td>';
							}
							echo '<td ><ff>' . number_format($total) . '</ff></td></tr>';
							echo '</table>';
						}
					}
					if ($tab == 2) {
						echo repoNav($fil, 2, $page, $tab, 1, 1, $page_mood);
						$d_s = $mm;
						$d_e = $mm + ($monLen * 86400);
						$q2 = '';
						if ($val) {
							$add_title = get_val('_users', 'name_' . $lg, $val);
							$q2 = " and doc='$val' ";
						}
						echo $breakC;
						echo repTitleShow();
						echo '<div class="f1 fs14 clr1 lh40">' . $add_title . '</div>';

						$total = 0;
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>			
			<th width="50">' . k_day . '</th>';
						foreach ($x_times as $x) {
							echo '<th><ff>' . $x . '</ff></th>';
						}
						echo '<th colspan="' . count($x_times) . '">' . k_total . '</th>
		</tr>';
						$r_total_arr = array();
						$x_data = array();
						$r = 0;
						for ($ss = 0; $ss < $monLen; $ss++) {
							$d_s = $mm + ($ss * 86400);
							$d_e = $d_s + 86400;
							$total = 0;
							$row = '<tr><td><div class="ff fs18 B txt_Over" onclick="reloadRep(' . $page . ',1,' . $d_s . ')">' . ($ss + 1) . '</div>';
							$i = 0;
							foreach ($x_times as $x) {
								$xx = explode('-', $x);
								$sH = $xx[0] * 3600;
								$eH = $xx[1] * 3600;
								$t_s = $d_s + $sH;
								$t_e = $d_s + $eH;
								$q = " date >= $t_s and date < $t_e $q2";
								$amount = get_sum('gnr_x_acc_patient_payments', 'amount', " $q");
								$tot[$i] += $amount;
								$total += $amount;
								$row .= '<td><ff>' . number_format($amount) . '</ff></td>';
								$i++;
							}
							$row .= '<td ><ff>' . number_format($total) . '</ff></td></tr>';
							if ($total) {
								echo $row;
							}
						}
						$total = array_sum($tot);
						echo '<tr fot><td txt>' . k_total . '</td>';
						foreach ($tot as $x) {
							$pece = $x * 100 / $total;
							echo '<td><ff>' . number_format($x) . '</ff><ff class="clr5"> (%' . number_format($pece, 2) . ')</ff></td>';
						}
						echo '<td ><ff>' . number_format($total) . '</ff></td></tr>';
						echo '</table>';
					}
				}
				if ($page == 4) {
					if ($tab == 1) {
						echo repoNav($fil, 1, $page, $tab, 1, 1, $page_mood);
						$d_s = $todyU;
						$d_e = $d_s + 86400;
					}
					if ($tab == 2) {
						echo repoNav($fil, 2, $page, $tab, 1, 1, $page_mood);
						$d_s = $mm;
						$d_e = $d_s + (($monLen) * 86400);
					}
					if ($tab == 3) {
						echo repoNav($fil, 4, $page, $tab, 1, 1, $page_mood);
						$d_s = strtotime($df);
						$d_e = strtotime($dt) + 86400;
					}
					$q = '';
					if ($val) {
						$q = " and doc='$val'";
					}
					echo $breakC;
					echo repTitleShow();
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
	<tr>
		<th rowspan="2">' . k_dr . '</th>
		<th rowspan="2">' . k_service . '</th>
		<th colspan="2">' . k_new_srvcs . '</th>
		<th colspan="2">' . k_fin_ser . '</th>                 
	</tr>
	<tr>
		<th>' . k_services . '</th>
		<th>' . k_thdental . '</th>
		<th>' . k_services . '</th>
		<th>' . k_thdental . '</th>
	</tr>';
					$tot = array();
					$sql = "select id,name_$lg,subgrp from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";

					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						$totals = array();
						while ($r = mysql_f($res)) {
							unset($totals);
							$doc_id = $r['id'];
							$name = $r['name_' . $lg];
							$clinic = $r['subgrp'];
							$sql2 = "select count(service)st ,count(tooth_no)tt , service  from den_x_visits_services where doc='$doc_id' and d_start>='$d_s' and d_start<'$d_e'  $q group by service ";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);
							if ($rows2) {
								while ($r2 = mysql_f($res2)) {
									$srv = $r2['service'];
									$totals[$srv][0] = $r2['st'];
									$totals[$srv][1] = $r2['tt'];
								}
							}
							$sql2 = "select count(service)st ,count(tooth_no)tt , service  from den_x_visits_services where doc='$doc_id' and d_finish>='$d_s' and d_finish<'$d_e' $q group by service ";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);
							if ($rows2) {
								while ($r2 = mysql_f($res2)) {
									$srv = $r2['service'];
									$totals[$srv][2] = $r2['st'];
									$totals[$srv][3] = $r2['tt'];
								}
							}
							$i = 0;

							foreach ($totals as $k => $s) {
								$srvTxt = get_val_arr('den_m_services', 'name_' . $lg, $k, 'ss');
								$tot[0] += $s[0];
								$tot[1] += $s[1];
								$tot[2] += $s[2];
								$tot[3] += $s[3];
								echo '<tr>';
								if ($i == 0) {
									echo '<td txt class="cur Over" rowspan="' . count($totals) . '" onclick="chnRepVal(' . $doc_id . ')">' . $name . '</td>';
								}
								echo '
					<td txt>' . $srvice . $srvTxt . '</td>
					<td><ff class="clr1">' . number_format($s[0]) . '</div></td>
					<td><ff class="clr6">' . number_format($s[1]) . '</div></td>
					<td><ff class="clr1">' . number_format($s[2]) . '</div></td>
					<td><ff class="clr6">' . number_format($s[3]) . '</div></td>		
				</tr>';
								$i++;
							}
						}
					}
					echo '<tr fot>
	<td txt colspan="2">' . k_total . '</td>					
	<td><ff class="clr1">' . number_format($tot[0]) . '</div></td>
	<td><ff class="clr6">' . number_format($tot[1]) . '</div></td>
	<td><ff class="clr1">' . number_format($tot[2]) . '</div></td>
	<td><ff class="clr6">' . number_format($tot[3]) . '</div></td>                  
	</tr>
	</table>';
				}
				if ($page == 5) {
					if ($tab == 1) {
						echo repoNav($fil, 1, $page, $tab, 1, 1, $page_mood);
						$d_s = $todyU;
						$d_e = $d_s + 86400;
					}
					if ($tab == 2) {
						echo repoNav($fil, 2, $page, $tab, 1, 1, $page_mood);
						$d_s = $mm;
						$d_e = $d_s + (($monLen) * 86400);
					}
					if ($tab == 3) {
						echo repoNav($fil, 4, $page, $tab, 1, 1, $page_mood);
						$d_s = strtotime($df);
						$d_e = strtotime($dt) + 86400;
					}
					$q = '';
					if ($val) {
						$q = " and doc='$val'";
					}
					echo $breakC;
					echo repTitleShow();
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
	<tr>
		<th>' . k_dr . '</th>
		<th>' . k_service . '</th>
		<th>' . k_total_ach . '</th>
		<th>' . k_center_share . '</th>
		<th>' . k_doctor_share . '</th>
		<th>' . k_perc_doc . '</th>
	</tr>';
					$tot = array();
					$sql = "select id,name_$lg,subgrp from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						$totals = array();
						while ($r = mysql_f($res)) {
							$doc_id = $r['id'];
							$name = $r['name_' . $lg];
							$clinic = $r['subgrp'];
							$sql2 = "select sum(price)price ,sum(doc_part)doc_p , service  from den_x_visits_services_levels where doc='$doc_id' and date_e>='$d_s' and date_e<'$d_e'  $q group by service ";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);
							if ($rows2) {
								$i = 0;
								while ($r2 = mysql_f($res2)) {
									$price = $r2['price'];
									$doc_p = $r2['doc_p'];
									$hos_p = $price - $doc_p;
									$service = $r2['service'];
									$docPer = ($doc_p * 100) / $price;
									$totals[0] += $price;
									$totals[1] += $doc_p;
									$srvTxt = get_val_arr('den_m_services', 'name_' . $lg, $service, 'ss');
									echo '<tr>';
									if ($i == 0) {
										echo '<td txt class="cur Over" rowspan="' . $rows2 . '" onclick="chnRepVal(' . $doc_id . ')">' . $name . '</td>';
									}
									echo '
						<td txt>' . $srvice . $srvTxt . '</td>
						<td><ff class="clr1">' . number_format($price) . '</div></td>
						<td><ff class="clr6">' . number_format($hos_p) . '</div></td>
						<td><ff class="clr5">' . number_format($doc_p) . '</div></td>
						<td><ff class="clr1">%' . number_format($docPer) . '</div></td>		
					</tr>';
									$i++;
								}
							}
						}
					}
					$docPer = ($totals[1] * 100) / $totals[0];
					echo '<tr fot>
	<td txt colspan="2">' . k_total . '</td>					
	<td><ff class="clr1">' . number_format($totals[0]) . '</div></td>
	<td><ff class="clr6">' . number_format($totals[0] - $totals[1]) . '</div></td>
	<td><ff class="clr5">' . number_format($totals[1]) . '</div></td>
	<td><ff class="clr1">%' . number_format($docPer, 2) . '</div></td>                  
	</tr>
	</table>';
				}
				/**************************************************/
				if ($page_mood == 1) {
					echo reportFooter();
				} ?>