<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['t'], $_POST['s'], $_POST['e'], $_POST['n'])) {
	$type = pp($_POST['t']);
	$start = pp($_POST['s']);
	$end = pp($_POST['e']) + 86400;
	$act = pp($_POST['n']);
	$secStatus = array(k_no_oper_today, k_synced, k_idn_prv_vrs, k_mtch_prv_vrs);
	$secStatusCol = array('#aaa', $clr1, $clr6, $clr5);
	$status = 0;
	function getVisCashBal($mood, $vis)
	{
		$in = get_sum('gnr_x_acc_payments', 'amount', " mood like '$mood%' and vis='$vis' and type IN(1,2,7,11)");
		$out = get_sum('gnr_x_acc_payments', 'amount', " mood like '$mood%' and vis='$vis' and type IN(3,4)");
		return $in - $out;
	}
	function defPayDate($cType, $vis, $date)
	{
		$s_date = $date - ($date % 86400);
		$e_date = $s_date + 86400;
		$con = "mood='$cType' and vis='$vis' and (date < '$s_date' OR date > '$e_date' ) ";
		return getTotalCO('gnr_x_acc_payments', $con);
	}
	if ($end > $start && ($act >= $start && $act <= $end)) {
		$tatalDays = ($end - $start) / 86400;
		$tatalDaysDone = (($act - $start) / 86400) + 1;
		$donePers = (100 * $tatalDaysDone) / $tatalDays;
		if ($type == 1) {
			$table = 'gnr_r_cash';
			$table2 = 'gnr_x_acc_payments';
			$date_filed = 'date';
			$title = k_box;
		}
		if ($type == 2) {
			$table = 'gnr_r_clinic';
			$table2 = 'gnr_x_acc_payments';
			$date_filed = 'date';
			$title = k_clinics;
		}
		if ($type == 3) {
			$table = 'gnr_r_docs';
			$table2 = 'cln_x_visits_services';
			$date_filed = 'd_start';
			$title = k_drs;
		}
		if ($type == 4) {
			$table = 'gnr_r_charities';
			$table2 = 'gnr_x_charities_srv';
			$date_filed = 'date';
			$title = k_charities;
		}
		if ($type == 5) {
			$table = 'gnr_r_insurance';
			$table2 = 'gnr_x_insurance_rec';
			$date_filed = 's_date';
			$title = k_thinsure;
		}
		if ($type == 7) {
			$table = 'lab_x_visits';
			$table2 = 'lab_x_visits_services';
			$date_filed = 's_date';
			$title = k_thlab;
		}
		if ($type == 8) {
			$table = 'gnr_r_recepion';
			$table2 = 'cln_x_visits';
			$date_filed = 'd_start';
			$title = k_emps;
		}
		if ($type == 9) {
			$table = 'den_r_docs';
			$table2 = 'den_x_visits';
			$date_filed = 'd_start';
			$title = k_teeth;
		}
?>
		<div class="f1 fs16 clr1 lh20"> <?= k_synion ?> <?= $title ?>
			<ff dir="ltr">( <?= date('Y-m-d', $start) . ' - ' . date('Y-m-d', $end) ?> )</ff>
		</div>
		<div class="lh20 fs14"><?= date('Y-m-d', $act) . ' ( ' . $tatalDaysDone . ' / ' . $tatalDays . ' )' ?></div>
		<div class="snc_prog fl">
			<div class="fl" style="width:<?= $donePers ?>%"></div>
		</div>^<?
				$out = '';
				$d_s = $act;
				$d_e = $act + 86400;
				if ($type == 1) {
					$cashTxt = '';
					if (_set_l1acfcztzu) {
						$cashTxt = ' ( ' . k_cash . ' )';
					}
					$status = 0;
					$pay_type = 1;
					$users_data = array();
					$actUsers = array();
					$sql = "select type,amount,casher,mood from gnr_x_acc_payments where date>='$d_s' and date < '$d_e' and type not in(9,11) and pay_type=1";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$p_type = $r['type'];
							$amount = $r['amount'];
							$casher = $r['casher'];
							array_push($actUsers, $casher);
							$mood = $r['mood'];
							//echo '('.$mood.'|'.$casher.')';
							$t = 'in';
							if ($p_type == 3 || $p_type == 4 || $p_type == 8) {
								$t = 'out';
							}
							if ($p_type == 5) {
								$users_data[$casher]['card'] += $amount;
							} else if ($p_type == 10) {
								$users_data[$casher]['offer'] += $amount;
							} else {
								$users_data[$casher]['a' . $mood . '_' . $t] += $amount;
							}
						}
					} else {
						mysql_q("DELETE from $table where date ='$act' ");
					}
					$u_total = count($users_data);
					$addTxt1 = '';
					if ($u_total) {
						$addTxt1 = '<span class="ff B">( ' . $u_total . ' )</ff> ';
					}
					$x = 0;
					foreach ($users_data as $k => $u) {
						$u_id = $k;
						$a1_in = $a1_out = $a2_in = $a2_out = $a3_in = $a3_out = $a7_in = $a7_out = $a4_in = $a4_out = $a5_in = $a5_out = $a6_in = $a6_out = $card = $offer = 0;
						if ($u['a1_in']) {
							$a1_in = $u['a1_in'];
						}
						if ($u['a1_out']) {
							$a1_out = $u['a1_out'];
						}
						if ($u['a2_in']) {
							$a2_in = $u['a2_in'];
						}
						if ($u['a2_out']) {
							$a2_out = $u['a2_out'];
						}
						if ($u['a3_in']) {
							$a3_in = $u['a3_in'];
						}
						if ($u['a3_out']) {
							$a3_out = $u['a3_out'];
						}
						if ($u['a7_in']) {
							$a7_in = $u['a7_in'];
						}
						if ($u['a7_out']) {
							$a7_out = $u['a7_out'];
						}
						if ($u['a4_in']) {
							$a4_in = $u['a4_in'];
						}
						if ($u['a4_out']) {
							$a4_out = $u['a4_out'];
						}
						if ($u['a5_in']) {
							$a5_in = $u['a5_in'];
						}
						if ($u['a5_out']) {
							$a5_out = $u['a5_out'];
						}
						if ($u['a6_in']) {
							$a6_in = $u['a6_in'];
						}
						if ($u['a6_out']) {
							$a6_out = $u['a6_out'];
						}
						if ($u['card']) {
							$card = $u['card'];
						}
						if ($u['offer']) {
							$offer = $u['offer'];
						}
						$amount_in = $a1_in + $a2_in + $a3_in + $a7_in + $a4_in + $a5_in + $a6_in + $card + $offer;
						$amount_out = $a1_out + $a2_out + $a3_out + $a7_out + $a4_out + $a5_out + $a6_out;

						$rec = getRecCon($table, " date='$act' and pay_type = '$pay_type' and casher='$u_id' ");
						if ($amount_in || $amount_out) {
							if ($rec['r']) {
								$status = 3;
								//if(!$offer){$offer=0;}
								/*if($amount_in!=$rec['amount_in']){echo '1';}
						if($amount_out!=$rec['amount_out']){echo '2';} 
						if($a1_in!=$rec['a1_in']){echo '3';} 
						if($a1_out!=$rec['a1_out']){echo '4';} 
						if($a2_in!=$rec['a2_in']){echo '5';} 
						if($a2_out!=$rec['a2_out']){echo '6';} 
						if($a3_in!=$rec['a3_in']){echo '7';} 
						if($a3_out!=$rec['a3_out']){echo '8';}
						if($a4_in!=$rec['a4_in']){echo '9';} 
						if($a4_out!=$rec['a4_out']){echo '10';} 
						if($a5_in!=$rec['a5_in']){echo '11';} 
						if($a5_out!=$rec['a5_out']){echo '12';} 
						if($a6_in!=$rec['a6_in']){echo '13';} 
						if($a6_out!=$rec['a6_out']){echo '14';} 
						if($card!=$rec['card']){echo '15';}
						if($offer!=$rec['offer']){echo '16';}	*/
								if (
									$amount_in == $rec['amount_in'] &&
									$amount_out == $rec['amount_out'] &&
									$a1_in == $rec['a1_in'] &&
									$a1_out == $rec['a1_out'] &&
									$a2_in == $rec['a2_in'] &&
									$a2_out == $rec['a2_out'] &&
									$a3_in == $rec['a3_in'] &&
									$a3_out == $rec['a3_out'] &&
									$a7_in == $rec['a7_in'] &&
									$a7_out == $rec['a7_out'] &&
									$a4_in == $rec['a4_in'] &&
									$a4_out == $rec['a4_out'] &&
									$a5_in == $rec['a5_in'] &&
									$a5_out == $rec['a5_out'] &&
									$a6_in == $rec['a6_in'] &&
									$a6_out == $rec['a6_out'] &&
									$card == $rec['card']	&&
									$offer == $rec['offer']
								) {
									$status = 2;
								} else {
									$sql = "UPDATE $table SET `date`='$act',
							`casher`='$u_id',`card`='$card',`offer`='$offer',
							`a1_in`='$a1_in',`a1_out`='$a1_out',
							`a2_in`='$a2_in',`a2_out`='$a2_out',
							`a3_in`='$a3_in',`a3_out`='$a3_out',
							`a7_in`='$a7_in',`a7_out`='$a7_out',
							`a4_in`='$a4_in',`a4_out`='$a4_out',
							`a5_in`='$a5_in',`a5_out`='$a5_out',
							`a6_in`='$a6_in',`a6_out`='$a6_out',
							`amount_in`='$amount_in',`amount_out`='$amount_out'
							where date ='$act' and pay_type = '$pay_type' and casher='$u_id' ";
									if (mysql_q($sql)) {
										$x++;
									}
								}
							} else {
								$status = 1;
								$sql = "INSERT INTO $table (`date`,`casher`,`a1_in`,`a2_in`,`a3_in`,`a7_in`,`a4_in`,`a5_in`,`a6_in`,`a1_out`,`a2_out`,`a3_out`,`a7_out`,`a4_out`,`a5_out`,`a6_out`,`card`,`offer`,`amount_in`,`amount_out`,`pay_type`)values						('$act','$u_id','$a1_in','$a2_in','$a3_in','$a7_in','$a4_in','$a5_in','$a6_in','$a1_out','$a2_out','$a3_out','$a7_out','$a4_out','$a5_out','$a6_out','$card','$offer','$amount_in','$amount_out','$pay_type')";
								mysql_q($sql);
							}
						} else {
							if ($rec['r']) {
								mysql_q("DELETE from $table where date ='$act' and casher='$u_id' and pay_type='$pay_type'");
							}
						}
						$actUTxt = implode(',', $actUsers);
						if ($actUTxt) {
							mysql_q("DELETE from $table where date ='$act' and casher not IN ($actUTxt) and pay_type='$pay_type'");
						}
					}
					if ($x > 0) {
						$status = 3;
						$addTxt1 .= '<span class=" clr5 ff B">[ x' . $x . ' ]</ff> ';
					}
					$out .= '<div style="color:' . $secStatusCol[$status] . '">
			<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
			<span class="lh20 f1" >' . $secStatus[$status] . ' ' . $addTxt1 . $cashTxt . '</span>
			</div>';
					/*******************Epay**********************/
					if (_set_l1acfcztzu) {
						$status = 0;
						$pay_type = 2;
						$users_data = array();
						$actUsers = array();
						$sql = "select type,amount,casher,mood from gnr_x_acc_payments where date>='$d_s' and date < '$d_e' and type not in(9,11) and pay_type=2";
						$res = mysql_q($sql);
						$rows = mysql_n($res);
						if ($rows > 0) {
							while ($r = mysql_f($res)) {
								$p_type = $r['type'];
								$amount = $r['amount'];
								$casher = $r['casher'];
								array_push($actUsers, $casher);
								$mood = $r['mood'];
								//echo '('.$mood.'|'.$casher.')';
								$t = 'in';
								if ($p_type == 3 || $p_type == 4 || $p_type == 8) {
									$t = 'out';
								}
								if ($p_type == 5) {
									$users_data[$casher]['card'] += $amount;
								} else if ($p_type == 10) {
									$users_data[$casher]['offer'] += $amount;
								} else {
									$users_data[$casher]['a' . $mood . '_' . $t] += $amount;
								}
							}
						} else {
							mysql_q("DELETE from $table where date ='$act' and pay_type='$pay_type'");
						}
						$u_total = count($users_data);
						$addTxt1 = '';
						if ($u_total) {
							$addTxt1 = '<span class="ff B">( ' . $u_total . ' )</ff> ';
						}
						$x = 0;
						foreach ($users_data as $k => $u) {
							$u_id = $k;
							$a1_in = $a1_out = $a2_in = $a2_out = $a3_in = $a3_out = $a7_in = $a7_out = $a4_in = $a4_out = $a5_in = $a5_out = $a6_in = $a6_out = $card = $offer = 0;
							if ($u['a1_in']) {
								$a1_in = $u['a1_in'];
							}
							if ($u['a1_out']) {
								$a1_out = $u['a1_out'];
							}
							if ($u['a2_in']) {
								$a2_in = $u['a2_in'];
							}
							if ($u['a2_out']) {
								$a2_out = $u['a2_out'];
							}
							if ($u['a3_in']) {
								$a3_in = $u['a3_in'];
							}
							if ($u['a3_out']) {
								$a3_out = $u['a3_out'];
							}
							if ($u['a7_in']) {
								$a7_in = $u['a7_in'];
							}
							if ($u['a7_out']) {
								$a7_out = $u['a7_out'];
							}
							if ($u['a4_in']) {
								$a4_in = $u['a4_in'];
							}
							if ($u['a4_out']) {
								$a4_out = $u['a4_out'];
							}
							if ($u['a5_in']) {
								$a5_in = $u['a5_in'];
							}
							if ($u['a5_out']) {
								$a5_out = $u['a5_out'];
							}
							if ($u['a6_in']) {
								$a6_in = $u['a6_in'];
							}
							if ($u['a6_out']) {
								$a6_out = $u['a6_out'];
							}
							if ($u['card']) {
								$card = $u['card'];
							}
							if ($u['offer']) {
								$offer = $u['offer'];
							}
							$amount_in = $a1_in + $a2_in + $a3_in + $a7_in + $a4_in + $a5_in + $a6_in + $card + $offer;
							$amount_out = $a1_out + $a2_out + $a3_out + $a7_out + $a4_out + $a5_out + $a6_out;

							$rec = getRecCon($table, " date='$act' and pay_type = '$pay_type' and casher='$u_id' ");
							if ($amount_in || $amount_out) {
								if ($rec['r']) {
									$status = 3;
									//if(!$offer){$offer=0;}

									/*if($amount_in!=$rec['amount_in']){echo '1';}
                            if($amount_out!=$rec['amount_out']){echo '2';} 
                            if($a1_in!=$rec['a1_in']){echo '3';} 
                            if($a1_out!=$rec['a1_out']){echo '4';} 
                            if($a2_in!=$rec['a2_in']){echo '5';} 
                            if($a2_out!=$rec['a2_out']){echo '6';} 
                            if($a3_in!=$rec['a3_in']){echo '7';} 
                            if($a3_out!=$rec['a3_out']){echo '8';}
                            if($a4_in!=$rec['a4_in']){echo '9';} 
                            if($a4_out!=$rec['a4_out']){echo '10';} 
                            if($a5_in!=$rec['a5_in']){echo '11';} 
                            if($a5_out!=$rec['a5_out']){echo '12';} 
                            if($a6_in!=$rec['a6_in']){echo '13';} 
                            if($a6_out!=$rec['a6_out']){echo '14';} 
                            if($card!=$rec['card']){echo '15';}
                            if($offer!=$rec['offer']){echo '16';}	*/
									if (
										$amount_in == $rec['amount_in'] &&
										$amount_out == $rec['amount_out'] &&
										$a1_in == $rec['a1_in'] &&
										$a1_out == $rec['a1_out'] &&
										$a2_in == $rec['a2_in'] &&
										$a2_out == $rec['a2_out'] &&
										$a3_in == $rec['a3_in'] &&
										$a3_out == $rec['a3_out'] &&
										$a7_in == $rec['a7_in'] &&
										$a7_out == $rec['a7_out'] &&
										$a4_in == $rec['a4_in'] &&
										$a4_out == $rec['a4_out'] &&
										$a5_in == $rec['a5_in'] &&
										$a5_out == $rec['a5_out'] &&
										$a6_in == $rec['a6_in'] &&
										$a6_out == $rec['a6_out'] &&
										$card == $rec['card']	&&
										$offer == $rec['offer']
									) {
										$status = 2;
									} else {
										$sql = "UPDATE $table SET `date`='$act',
                                `casher`='$u_id',`card`='$card',`offer`='$offer',
                                `a1_in`='$a1_in',`a1_out`='$a1_out',
                                `a2_in`='$a2_in',`a2_out`='$a2_out',
                                `a3_in`='$a3_in',`a3_out`='$a3_out',
                                `a7_in`='$a7_in',`a7_out`='$a7_out',
                                `a4_in`='$a4_in',`a4_out`='$a4_out',
                                `a5_in`='$a5_in',`a5_out`='$a5_out',
                                `a6_in`='$a6_in',`a6_out`='$a6_out',
                                `amount_in`='$amount_in',`amount_out`='$amount_out'
                                where date ='$act' and pay_type = '$pay_type' and casher='$u_id' ";
										if (mysql_q($sql)) {
											$x++;
										}
									}
								} else {
									$status = 1;
									$sql = "INSERT INTO $table (`date`,`casher`,`a1_in`,`a2_in`,`a3_in`,`a7_in`,`a4_in`,`a5_in`,`a6_in`,`a1_out`,`a2_out`,`a3_out`,`a7_out`,`a4_out`,`a5_out`,`a6_out`,`card`,`offer`,`amount_in`,`amount_out`,`pay_type`)values						('$act','$u_id','$a1_in','$a2_in','$a3_in','$a7_in','$a4_in','$a5_in','$a6_in','$a1_out','$a2_out','$a3_out','$a7_out','$a4_out','$a5_out','$a6_out','$card','$offer','$amount_in','$amount_out','$pay_type')";
									mysql_q($sql);
								}
							} else {
								if ($rec['r']) {
									mysql_q("DELETE from $table where date ='$act' and casher='$u_id' and pay_type='$pay_type'");
								}
							}
							$actUTxt = implode(',', $actUsers);
							if ($actUTxt) {
								mysql_q("DELETE from $table where date ='$act' and casher not IN ($actUTxt) and pay_type='$pay_type'");
							}
						}
						if ($x > 0) {
							$status = 3;
							$addTxt1 .= '<span class=" clr5 ff B">[ x' . $x . ' ]</ff> ';
						}
						$out .= '<div style="color:' . $secStatusCol[$status] . '">
                <span class="fs14">' . date('Y-m-d', $act) . '</span> =>
                <span class="lh20 f1" > ' . $secStatus[$status] . ' ' . $addTxt1 . ' ( ' . k_elec . ' )</span>
                </div>';
					}
				}
				if ($type == 2) {
					$clinic_data = array();
					$clinic2 = get_val_c('gnr_m_clinics', 'id', 2, 'type');
					$sql = "select type,amount,mood,vis from gnr_x_acc_payments where date >='$d_s' and date < '$d_e' and type in(1,2,3,4,5,6,7,10)";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$p_type = $r['type'];
							$amount = $r['amount'];
							$mood = $r['mood'];
							$vis = $r['vis'];
							if ($mood == 2) {
								$clinic = $clinic2;
							} else {
								$clinic = get_val($visXTables[$mood], 'clinic', $vis);
							}

							if ($clinic == '' && $mood != 4) {
								echo '<div class="f1 clr5">' . k_fin_record_exist . '<ff>(' . $mood . ')</ff>' . k_visit_num . '<ff> (' . $vis . ')</ff></div>';
							}
							if ($clinic) {
								$clinic_data[$clinic]['p' . $p_type] += $amount;
							}
						}
					}
					/******************************************************/
					$sql = "select id,type from gnr_m_clinics ";
					$res = mysql_q($sql);
					while ($r = mysql_f($res)) {
						$cli_id = $r['id'];
						$mood = $r['type'];
						$cQ = '';
						if ($mood != 2) {
							$cQ = " and  clinic='$cli_id' ";
						}
						$q = " and  d_start>='$d_s' and d_start < '$d_e' ";
						$tab = $visXTables[$mood];
						if ($mood == 2) {
							$sQ = "status not in(0,3)";
						} else {
							$sQ = "status =2 ";
						}
						$visits = getTotalCO($tab, "$sQ $cQ $q");
						if ($visits > 0) {
							$clinic_data[$cli_id]['vis_free'] = 0;
							$clinic_data[$cli_id]['type'] = $mood;
							$clinic_data[$cli_id]['vis'] = $visits;
							if ($mood == 1 || $mood == 3) {
								$clinic_data[$cli_id]['vis_free'] = getTotalCO($tab, "$sQ and clinic='$cli_id' and dts_id!=0 $q ");
							}
							if (in_array($mood, array(1, 3, 4, 5, 6, 7))) {
								$clinic_data[$cli_id]['dts'] = getTotalCO($tab, " $sQ $cQ $q ");
							}
							$clinic_data[$cli_id]['emplo'] = getTotalCO($tab, " $sQ $cQ and emplo=1 $q ");
							$clinic_data[$cli_id]['pt0'] = getTotalCO($tab, " $sQ $cQ $q and pay_type=0 ");
							$clinic_data[$cli_id]['pt1'] = getTotalCO($tab, " $sQ $cQ $q and pay_type=1 ");
							$clinic_data[$cli_id]['pt2'] = getTotalCO($tab, " $sQ $cQ $q and pay_type=2 ");
							$clinic_data[$cli_id]['pt3'] = getTotalCO($tab, " $sQ $cQ $q and pay_type=3 ");
							$clinic_data[$cli_id]['new_pat'] = getTotalCO($tab, " $sQ $cQ $q and new_pat=1 ");
						} else {
							mysql_q("DELETE from $table where date ='$act' and clinic='$cli_id' ");
						}
					}
					/*******************/
					// CLN
					$sql = "select * from cln_x_visits_services where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$clinic = $r['clinic'];
							$pay_net = $r['pay_net'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];
							$srv_type = $r['srv_type'];

							$pay_type = $r['pay_type'];
							if ($pay_type == 3) {
								$clinic_data[$clinic]['insur'] += ($pay_net);
							}
							$clinic_data[$clinic]['srv']++;
							$clinic_data[$clinic]['total'] += $total_pay;
							$clinic_data[$clinic]['pay_net'] += $pay_net;
							$clinic_data[$clinic]['cost'] += $cost;
							$clinic_data[$clinic]['st' . $srv_type]++;
							$patient = $r['patient'];
						}
					}
					// Lab
					$clinic = $clinic2;
					$sql = "select * from lab_x_visits_services where status not in(0,3) and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$pay_net = $r['pay_net'];
							$total_pay = $r['total_pay'];
							$pay_type = $r['pay_type'];
							if ($pay_type == 3) {
								$clinic_data[$clinic]['insur'] += ($pay_net);
							}
							$clinic_data[$clinic]['srv']++;
							$clinic_data[$clinic]['total'] += $total_pay;
							$clinic_data[$clinic]['pay_net'] += $pay_net;
							$clinic_data[$clinic]['cost'] += $cost;
							$clinic_data[$clinic]['st0']++;
							$patient = $r['patient'];
						}
					}
					// XRY
					$sql = "select * from xry_x_visits_services where status in(1,6) and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$clinic = $r['clinic'];
							$pay_net = $r['pay_net'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];

							$srv_type = $r['srv_type'];
							$pay_type = $r['pay_type'];
							if ($pay_type == 3) {
								$clinic_data[$clinic]['insur'] += ($pay_net);
							}
							$clinic_data[$clinic]['srv']++;
							$clinic_data[$clinic]['total'] += $total_pay;
							$clinic_data[$clinic]['pay_net'] += $pay_net;
							$clinic_data[$clinic]['cost'] += $cost;
							$clinic_data[$clinic]['st' . $srv_type]++;
							$patient = $r['patient'];
						}
					}

					// DEN
					$sql = "select * from den_x_visits_services where  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$clinic = $r['clinic'];
							$pay_net = $r['pay_net'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];
							$srv_type = $r['srv_type'];
							$pay_type = $r['pay_type'];
							if ($pay_type == 3) {
								$clinic_data[$clinic]['insur'] += ($pay_net);
							}
							$clinic_data[$clinic]['srv']++;
							$clinic_data[$clinic]['total'] += $total_pay;
							$clinic_data[$clinic]['pay_net'] += $pay_net;
							$clinic_data[$clinic]['cost'] += $cost;
							$clinic_data[$clinic]['st0']++;
							$patient = $r['patient'];
						}
					}
					// BTY
					$sql = "select * from bty_x_visits_services where status=1 and  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$clinic = $r['clinic'];
							$pay_net = $r['pay_net'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];
							$pay_type = $r['pay_type'];
							if ($pay_type == 3) {
								$clinic_data[$clinic]['insur'] += ($pay_net);
							}
							$clinic_data[$clinic]['srv']++;
							$clinic_data[$clinic]['total'] += $total_pay;
							$clinic_data[$clinic]['pay_net'] += $pay_net;
							$clinic_data[$clinic]['cost'] += $cost;
							$clinic_data[$clinic]['st0']++;
							$patient = $r['patient'];
						}
					}
					// LSR
					$sql = "select * from bty_x_laser_visits where status=2 and  doctor!=0 and d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$clinic = $r['clinic'];
							$pay_net = $r['pay_net'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];
							$clinic_data[$clinic]['insur'] = 0;
							$clinic_data[$clinic]['srv']++;
							$clinic_data[$clinic]['total'] += $total_pay;
							$clinic_data[$clinic]['pay_net'] += $total_pay;
							//$clinic_data[$clinic]['cost']+=$cost;						
							$clinic_data[$clinic]['st0']++;
							$patient = $r['patient'];
						}
					}
					// OSC
					$sql = "select * from osc_x_visits_services where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$clinic = $r['clinic'];
							$pay_net = $r['pay_net'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];
							$srv_type = $r['srv_type'];
							$pay_type = $r['pay_type'];
							if ($pay_type == 3) {
								$clinic_data[$clinic]['insur'] += ($pay_net);
							}
							$clinic_data[$clinic]['srv']++;
							$clinic_data[$clinic]['total'] += $total_pay;
							$clinic_data[$clinic]['pay_net'] += $pay_net;
							$clinic_data[$clinic]['cost'] += $cost;
							$clinic_data[$clinic]['st' . $srv_type]++;
							$patient = $r['patient'];
						}
					}


					$c_total = count($clinic_data);
					$addTxt1 = '';
					if ($c_total) {
						$addTxt1 = '<span class="ff B">( ' . $c_total . ' )</ff> ';
					}
					$x = 0;
					foreach ($clinic_data as $k => $c) {
						$c_id = $k;
						$c_type = $c['type'];

						$srv = $c['srv'];
						$total = $c['total'];
						$cost = $c['cost'];
						$pay_net = $c['pay_net'];
						$pay_insur = $c['insur'];
						$emplo = $c['emplo'];

						$vis = $c['vis'];
						$dts = $c['dts'];
						$new_pat = $c['new_pat'];
						$vis_free = $c['vis_free'];

						$st0 = $c['st0'];
						$st1 = $c['st1'];
						$st2 = $c['st2'];

						$pt0 = $c['pt0'];
						$pt1 = $c['pt1'];
						$pt2 = $c['pt2'];
						$pt3 = $c['pt3'];

						//if($c_type==0){echo '[['.$k.'-'.$srv.'-'.$vis.']]';}
						$rec = getRecCon($table, " date='$act' and clinic='$c_id' ");
						if ($vis) {
							if ($rec['r']) {
								if (!$pay_net) {
									$pay_net = 0;
								}
								if (!$pay_insur) {
									$pay_insur = 0;
								}
								if (!$new_pat) {
									$new_pat = 0;
								}
								if (!$vis) {
									$vis = 0;
								}
								if (!$dts) {
									$dts = 0;
								}
								if (!$vis_free) {
									$vis_free = 0;
								}
								if (!$st0) {
									$st0 = 0;
								}
								if (!$st1) {
									$st1 = 0;
								}
								if (!$st2) {
									$st2 = 0;
								}
								if (!$pt0) {
									$pt0 = 0;
								}
								if (!$pt1) {
									$pt1 = 0;
								}
								if (!$total) {
									$total = 0;
								}
								if (!$pt2) {
									$pt2 = 0;
								}
								if (!$pt3) {
									$pt3 = 0;
								}
								if (!$cost) {
									$cost = 0;
								}
								if (!$emplo) {
									$emplo = 0;
								}
								if (!$total) {
									$total = 0;
								}
								$status = 3;
								/*
						if($c_type!=$rec['type']){echo ' 1 ('.$c_type.'!=['.$rec['type'].'])';}
						if($pay_insur!=$rec['pay_insur']){echo ' 4';}
						if($clinicType!=$rec['clinic_type']){echo ' 5('.$clinicType.'!=['.$rec['clinic_type'].'])';}
						if($pay_net!=$rec['pay_net']){echo ' 6';}						
						if($vis_free!=$rec['vis_free']){echo ' 7('.$vis_free.'!=['.$rec['vis_free'].'])';}
						if($st0!=$rec['st0']){echo ' 8';}
						if($st1!=$rec['st1']){echo ' 9';}
						if($st2!=$rec['st2']){echo ' 10';}
						if($vis!=$rec['vis']){echo ' 11';}
						if($dts!=$rec['dts']){echo ' 111';}
						if($new_pat!=$rec['new_pat']){echo ' 12';}
						if($total!=$rec['total']){echo ' 13';}
						if($cost!=$rec['cost']){echo ' 14';}
						
						if($pt0!=$rec['pt0']){echo ' 15';}
						if($pt1!=$rec['pt1']){echo ' 16';}
						if($pt2!=$rec['pt2']){echo ' 17';}
						if($pt3!=$rec['pt3']){echo ' 18';}*/



								if (
									$total == $rec['total'] &&
									$cost == $rec['cost'] &&
									$pay_insur == $rec['pay_insur'] &&
									$c_type == $rec['type'] &&
									$pay_net == $rec['pay_net'] &&
									$vis == $rec['vis'] &&
									$dts == $rec['dts'] &&
									$new_pat == $rec['new_pat'] &&
									$vis_free == $rec['vis_free'] &&
									$st0 == $rec['st0'] &&
									$st1 == $rec['st1'] &&
									$st2 == $rec['st2'] &&
									$pt0 == $rec['pt0'] &&
									$pt1 == $rec['pt1'] &&
									$pt2 == $rec['pt2'] &&
									$pt3 == $rec['pt3'] &&
									$emplo == $rec['emplo']
								) {
									$status = 2;
								} else {
									$sql = "UPDATE $table SET date='$act',							
							srv='$srv',							
							total='$total',
							cost='$cost',
							type='$c_type',
							pay_net='$pay_net',
							pay_insur='$pay_insur',
							vis='$vis' ,
							dts='$dts' ,
							new_pat='$new_pat',							
							vis_free='$vis_free',
							emplo='$emplo',
							st0='$st0',
							st1='$st1',
							st2='$st2',
							pt0='$pt0',
							pt1='$pt1',
							pt2='$pt2',						
							pt3='$pt3'
							where date ='$act' and clinic='$c_id' ";
									if (mysql_q($sql)) {
										$x++;
									}
									if ($c_type == 0) {
										echo $sql;
									}
								}
							} else {
								$status = 1;
								//mysql_q("INSERT INTO $table (date,clinic,b,type)values('$act','$c_id','$b','$c_type')");

								$sql = "INSERT INTO $table (date,clinic,srv,total,cost,type,pay_net,pay_insur,vis,dts,
							new_pat,st0,st1,st2,emplo,pt0,pt1,pt2,pt3) values('$act','$c_id' ,'$srv', '$total', '$cost', '$c_type', '$pay_net', '$pay_insur','$vis' ,'$dts','$new_pat','$st0','$st1', '$st2','$emplo', '$pt0','$pt1','$pt2','$pt3' )";
								mysql_q($sql);
							}
						} else {
							if ($rec['r']) {
								mysql_q("DELETE from $table where date ='$act' and clinic='$c_id' ");
							}
						}
					}
					if ($x > 0) {
						$status = 3;
						$addTxt1 .= '<span class=" clr5 ff B">[ x' . $x . ' ]</ff> ';
					}
					$out .= '<div style="color:' . $secStatusCol[$status] . '">
			<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
			<span class="lh20 f1" > ' . $secStatus[$status] . ' ' . $addTxt1 . '</span>
			</div>';
				}
				if ($type == 3) {
					$docClnicType = array();
					$doc_data = array();
					$sql = "select id,subgrp from _users where grp_code IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g','9k0a1zy2ww')";
					$res = mysql_q($sql);
					$q = " and  d_start>='$d_s' and d_start < '$d_e' ";
					while ($r = mysql_f($res)) {
						$doc_id = $r['id'];
						$clinic = $r['subgrp'];
						$grp = $r['grp_code'];
						$mood = get_val_con('gnr_m_clinics', 'type', " id IN ($clinic)");
						$docClnicType[$doc_id] = $mood;
						$tab = $visXTables[$mood];
						$visits = getTotalCO($tab, "status=2  and doctor='$doc_id' $q");
						if ($visits) {
							$doc_data[$doc_id]['vis_free'] = 0;
							$doc_data[$doc_id]['vis'] = $visits;
							if ($mood == 1) {
								$doc_data[$doc_id]['vis_free'] = getTotalCO($tab, "status=2 and  doctor='$doc_id' and t_total_pay=0 $q ");
							}
							if ($mood == 3) {
								$doc_data[$doc_id]['vis_free'] = getTotalCO($tab, "status=2 and  ray_tec='$doc_id' and t_total_pay=0 $q ");
							}
							$doc_data[$doc_id]['new_pat'] = getTotalCO($tab, "status=2 and  doctor='$doc_id' and new_pat='1' $q ");
							$doc_data[$doc_id]['emplo'] = getTotalCO($tab, "status=2 and  doctor='$doc_id' and emplo='1' $q ");

							$doc_data[$doc_id]['pt0'] = getTotalCO($tab, "status=2 and  doctor='$doc_id' and pay_type='0' $q ");
							$doc_data[$doc_id]['pt1'] = getTotalCO($tab, "status=2 and  doctor='$doc_id' and pay_type='1' $q ");
							$doc_data[$doc_id]['pt2'] = getTotalCO($tab, "status=2 and  doctor='$doc_id' and pay_type='2' $q ");
							$doc_data[$doc_id]['pt3'] = getTotalCO($tab, "status=2 and  doctor='$doc_id' and pay_type='3' $q ");
						} else {
							mysql_q("DELETE from $table where date ='$act' and doc='$doc_id' ");
						}
					}

					// CLN
					$sql = "select * from cln_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$doc = $r['doc'];
							$vis = $r['visit_id'];
							/*if($docClnicType[$doc]==3){
						$doc=get_val('cln_x_visits','ray_tec',$vis);
						//echo $docClnicType[$doc];
					}*/
							if ($doc) {
								$hos_part = $r['hos_part'];
								$doc_part = $r['doc_part'];
								$doc_percent = $r['doc_percent'];
								$pay_net = $r['pay_net'];
								$doc_bal = $r['doc_bal'];
								$doc_dis = $r['doc_dis'];
								$hos_bal = $r['hos_bal'];
								$hos_dis = $r['hos_dis'];
								$cost = $r['cost'];
								$total_pay = $r['total_pay'];
								$srv_type = $r['srv_type'];
								$pay_type = $r['pay_type'];
								if ($pay_type == 3) {
									$doc_data[$doc]['insur'] += ($pay_net);
								}
								$doc_data[$doc]['srv']++;
								$doc_data[$doc]['prv'] += ($hos_part);
								$doc_data[$doc]['prv_d'] += $hos_dis;
								$doc_data[$doc]['pro'] += ($doc_part);
								$doc_data[$doc]['pro_d'] += $doc_dis;
								$doc_data[$doc]['dis'] += ($doc_dis + $hos_dis);
								$doc_data[$doc]['total'] += ($hos_part + $doc_part);
								$doc_data[$doc]['hos_p'] += $hos_bal;
								$doc_data[$doc]['doc_p'] += $doc_bal;
								$doc_data[$doc]['pay_net'] += $pay_net;
								$doc_data[$doc]['cost'] += $cost;
								$doc_data[$doc]['st' . $srv_type]++;
							}
						}
					}
					// XRY
					$sql = "select * from xry_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$doc = $r['doc'];
							$vis = $r['visit_id'];
							$doc = get_val('xry_x_visits', 'ray_tec', $vis);
							//echo $docClnicType[$doc];					
							if ($doc) {
								$hos_part = $r['hos_part'];
								$doc_part = $r['doc_part'];
								$doc_percent = $r['doc_percent'];
								$pay_net = $r['pay_net'];
								$doc_bal = $r['doc_bal'];
								$doc_dis = $r['doc_dis'];
								$hos_bal = $r['hos_bal'];
								$hos_dis = $r['hos_dis'];
								$cost = $r['cost'];
								$total_pay = $r['total_pay'];
								$srv_type = $r['srv_type'];
								$pay_type = $r['pay_type'];
								if ($pay_type == 3) {
									$doc_data[$doc]['insur'] += ($pay_net);
								}
								$doc_data[$doc]['srv']++;
								$doc_data[$doc]['prv'] += ($hos_part);
								$doc_data[$doc]['prv_d'] += $hos_dis;
								$doc_data[$doc]['pro'] += ($doc_part);
								$doc_data[$doc]['pro_d'] += $doc_dis;
								$doc_data[$doc]['dis'] += ($doc_dis + $hos_dis);
								$doc_data[$doc]['total'] += ($hos_part + $doc_part);
								$doc_data[$doc]['hos_p'] += $hos_bal;
								$doc_data[$doc]['doc_p'] += $doc_bal;
								$doc_data[$doc]['pay_net'] += $pay_net;
								$doc_data[$doc]['cost'] += $cost;
								$doc_data[$doc]['st' . $srv_type]++;
							}
						}
					}
					// DEN
					$sql = "select * from den_x_visits_services  where status=1 and  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$doc = $r['doc'];
							$hos_part = $r['hos_part'];
							$doc_part = $r['doc_part'];
							$doc_percent = $r['doc_percent'];
							$pay_net = $r['pay_net'];
							$doc_bal = $r['doc_bal'];
							$doc_dis = $r['doc_dis'];
							$hos_bal = $r['hos_bal'];
							$hos_dis = $r['hos_dis'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];

							$doc_data[$doc]['srv']++;
							$doc_data[$doc]['prv'] += ($hos_part);
							$doc_data[$doc]['prv_d'] += $hos_dis;
							$doc_data[$doc]['pro'] += ($doc_part);
							$doc_data[$doc]['pro_d'] += $doc_dis;
							$doc_data[$doc]['dis'] += ($doc_dis + $hos_dis);
							$doc_data[$doc]['total'] += ($hos_part + $doc_part);
							$doc_data[$doc]['hos_p'] += $hos_bal;
							$doc_data[$doc]['doc_p'] += $doc_bal;
							$doc_data[$doc]['cost'] += $cost;
						}
					}
					// BTY
					$sql = "select * from bty_x_visits_services  where status=1 and  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$doc = $r['doc'];
							$hos_part = $r['hos_part'];
							$doc_part = $r['doc_part'];
							$doc_percent = $r['doc_percent'];
							$pay_net = $r['pay_net'];
							$doc_bal = $r['doc_bal'];
							$doc_dis = $r['doc_dis'];
							$hos_bal = $r['hos_bal'];
							$hos_dis = $r['hos_dis'];
							$cost = $r['cost'];
							$total_pay = $r['total_pay'];

							$doc_data[$doc]['srv']++;
							$doc_data[$doc]['prv'] += ($hos_part);
							$doc_data[$doc]['prv_d'] += $hos_dis;
							$doc_data[$doc]['pro'] += ($doc_part);
							$doc_data[$doc]['pro_d'] += $doc_dis;
							$doc_data[$doc]['dis'] += ($doc_dis + $hos_dis);
							$doc_data[$doc]['total'] += ($hos_part + $doc_part);
							$doc_data[$doc]['hos_p'] += $hos_bal;
							$doc_data[$doc]['doc_p'] += $doc_bal;
							$doc_data[$doc]['pay_net'] += $pay_net;
							$doc_data[$doc]['cost'] += $cost;
						}
					}
					// LSR
					$sql = "select * from bty_x_laser_visits  where status=2 and  doctor!=0 and d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$doc_part = $doc_percent = $doc_bal = $doc_dis = $cost = 0;
							$v_id = $r['id'];
							$doc = $r['doctor'];
							$total_pay = $r['total_pay'];
							$hos_dis = $r['dis'];

							$hos_part = $total_pay;
							$hos_bal = $total_pay;
							$pay_net = $total_pay;

							$srvTotal = getTotalCO('bty_x_laser_visits_services', " visit_id='$v_id' ");
							$doc_data[$doc]['srv'] += $srvTotal;
							$doc_data[$doc]['prv'] += ($hos_part);
							$doc_data[$doc]['prv_d'] += $hos_dis;
							$doc_data[$doc]['pro'] += ($doc_part);
							$doc_data[$doc]['pro_d'] += $doc_dis;
							$doc_data[$doc]['dis'] += ($doc_dis + $hos_dis);
							$doc_data[$doc]['total'] += ($hos_part + $doc_part);
							$doc_data[$doc]['hos_p'] += $hos_bal;
							$doc_data[$doc]['doc_p'] += $doc_bal;
							$doc_data[$doc]['pay_net'] += $pay_net;
							$doc_data[$doc]['cost'] += $cost;
						}
					}
					// OSC
					$sql = "select * from osc_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$doc = $r['doc'];
							$vis = $r['visit_id'];
							if ($doc) {
								$hos_part = $r['hos_part'];
								$doc_part = $r['doc_part'];
								$doc_percent = $r['doc_percent'];
								$pay_net = $r['pay_net'];
								$doc_bal = $r['doc_bal'];
								$doc_dis = $r['doc_dis'];
								$hos_bal = $r['hos_bal'];
								$hos_dis = $r['hos_dis'];
								$cost = $r['cost'];
								$total_pay = $r['total_pay'];
								$srv_type = $r['srv_type'];
								$pay_type = $r['pay_type'];
								if ($pay_type == 3) {
									$doc_data[$doc]['insur'] += ($pay_net);
								}
								$doc_data[$doc]['srv']++;
								$doc_data[$doc]['prv'] += ($hos_part);
								$doc_data[$doc]['prv_d'] += $hos_dis;
								$doc_data[$doc]['pro'] += ($doc_part);
								$doc_data[$doc]['pro_d'] += $doc_dis;
								$doc_data[$doc]['dis'] += ($doc_dis + $hos_dis);
								$doc_data[$doc]['total'] += ($hos_part + $doc_part);
								$doc_data[$doc]['hos_p'] += $hos_bal;
								$doc_data[$doc]['doc_p'] += $doc_bal;
								$doc_data[$doc]['pay_net'] += $pay_net;
								$doc_data[$doc]['cost'] += $cost;
								$doc_data[$doc]['st' . $srv_type]++;
							}
						}
					}
					/******************************/
					$d_total = count($doc_data);
					$addTxt1 = '';
					if ($d_total) {
						$addTxt1 = '<span class="ff B">( ' . $d_total . ' )</ff> ';
					}
					$x = 0;
					foreach ($doc_data as $k => $d) {
						$d_id = $k;
						$clinicType = $docClnicType[$k];
						$srv = $d['srv'];
						$prv = $d['prv'];
						$prv_d = $d['prv_d'];
						$opr = $d['pro'];
						$por_d = $d['pro_d'];
						$dis = $d['dis'];
						$total = $d['total'];
						$hos_p = $d['hos_p'];
						$doc_p = $d['doc_p'];
						$cost = $d['cost'];
						$pay_net = $d['pay_net'];
						$pay_insur = $d['insur'];
						$emplo = $d['emplo'];

						$vis = $d['vis'];
						$new_pat = $d['new_pat'];
						$vis_free = $d['vis_free'];

						$st0 = $d['st0'];
						$st1 = $d['st1'];
						$st2 = $d['st2'];

						$pt0 = $d['pt0'];
						$pt1 = $d['pt1'];
						$pt2 = $d['pt2'];
						$pt3 = $d['pt3'];

						$doc_per = $doc_p * 100 / $opr;
						$rec = getRecCon($table, " date='$act' and doc='$d_id' ");

						if ($srv) {
							if ($rec['r']) {
								if (!$pay_net) {
									$pay_net = 0;
								}
								if (!$pay_insur) {
									$pay_insur = 0;
								}
								if (!$new_pat) {
									$new_pat = 0;
								}
								if (!$vis) {
									$vis = 0;
								}
								if (!$vis_free) {
									$vis_free = 0;
								}
								if (!$st0) {
									$st0 = 0;
								}
								if (!$st1) {
									$st1 = 0;
								}
								if (!$st2) {
									$st2 = 0;
								}
								if (!$pt0) {
									$pt0 = 0;
								}
								if (!$pt1) {
									$pt1 = 0;
								}
								if (!$pt2) {
									$pt2 = 0;
								}
								if (!$pt3) {
									$pt3 = 0;
								}
								if (!$emplo) {
									$emplo = 0;
								}
								$status = 3;
								/*if($hos_p!=$rec['hos_p']){echo ' 1';}
						if($doc_p!=$rec['doc_p']){echo ' 2';}
						if($cost!=$rec['cost']){echo ' 3';}
						if($pay_insur!=$rec['pay_insur']){echo ' 4';}
						if($clinicType!=$rec['clinic_type']){echo ' 5('.$clinicType.'!=['.$rec['clinic_type'].'])';}
						if($pay_net!=$rec['pay_net']){echo ' 6';}						
						if($vis_free!=$rec['vis_free']){echo ' 7('.$vis_free.'!=['.$rec['vis_free'].'])';}
						if($vis!=$rec['vis']){echo ' 77('.$vis.'!=['.$rec['vis'].'])';}
						if($st0!=$rec['st0']){echo ' 8';}
						if($st1!=$rec['st1']){echo ' 9';}
						if($st2!=$rec['st2']){echo ' 10';}
						if($vis!=$rec['vis']){echo ' 11';}
						if($new_pat!=$rec['new_pat']){echo ' 12';}
						if($pt0!=$rec['pt0']){echo '13';}
						if($emplo!=$rec['emplo']){echo '14('.$emplo.'!=['.$rec['emplo'].'])';}*/


								if (
									$hos_p == $rec['hos_p'] &&
									$doc_p == $rec['doc_p'] &&
									$cost == $rec['cost'] &&
									$pay_insur == $rec['pay_insur'] &&
									$clinicType == $rec['clinic_type'] &&
									$pay_net == $rec['pay_net'] &&
									$vis == $rec['vis'] &&
									$new_pat == $rec['new_pat'] &&
									$vis_free == $rec['vis_free'] &&
									$st0 == $rec['st0'] &&
									$st1 == $rec['st1'] &&
									$st2 == $rec['st2'] &&
									$pt0 == $rec['pt0'] &&
									$emplo == $rec['emplo']
								) {
									$status = 2;
								} else {
									$sql = "UPDATE $table SET date='$act',
							doc='$d_id',
							srv='$srv',
							prv='$prv',
							prv_d='$prv_d',
							opr='$opr',
							por_d='$por_d',
							dis='$dis',
							total='$total',
							hos_p='$hos_p',
							doc_p='$doc_p',
							doc_per='$doc_per',
							cost='$cost',
							clinic_type='$clinicType',
							pay_net='$pay_net',
							pay_insur='$pay_insur',
							vis='$vis' ,
							new_pat='$new_pat',							
							vis_free='$vis_free',
							emplo='$emplo',
							st0='$st0',
							st1='$st1',
							st2='$st2',
							pt0='$pt0',
							pt1='$pt1',
							pt2='$pt2',						
							pt3='$pt3'
							
							where date ='$act' and doc='$d_id' ";
									if (mysql_q($sql)) {
										$x++;
									}
								}
							} else {
								$status = 1;
								$sql = "INSERT INTO $table (date,doc,srv,prv,prv_d,opr,por_d,dis,total,hos_p,doc_p,doc_per,cost,clinic_type,pay_net,pay_insur,vis,
							new_pat,st0,st1,st2,emplo,pt0,pt1,pt2,pt3)						values('$act','$d_id','$srv','$prv','$prv_d','$opr','$por_d','$c_fp_hh=intval($dis/($dis_x+1));
                        $c_fp_dd=$dis-$fp_hh;','$total','$hos_p','$doc_p','$doc_per','$cost','$clinicType','$pay_net','$pay_insur','$vis','$new_pat','$st0','$st1','$st2','$emplo','$pt0','$pt1','$pt2','$pt3' )";
								mysql_q($sql);
							}
						} else {
							if ($rec['r']) {
								mysql_q("DELETE from $table where date ='$act' and doc='$d_id' ");
							}
						}
					}
					if ($x > 0) {
						$status = 3;
						$addTxt1 .= '<span class=" clr5 ff B">[ x' . $x . ' ]</ff>';
					}
					$out .= '<div style="color:' . $secStatusCol[$status] . '">
			<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
			<span class="lh20 f1" > ' . $secStatus[$status] . ' ' . $addTxt1 . '</span>
			</div>';
				}
				if ($type == 4) {
					$chr_data = array();
					$date = date('Y-m-d', $d_s);
					$d_e = $d_s + 86400;
					$sql = "select id from gnr_m_charities ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$char = $r['id'];
							$q = " date>='$d_s' and date<'$d_e' and charity='$char' ";
							$srvs = getTotalCO($table2, $q);
							if ($srvs) {
								$chr_data[$char]['srvs'] = $srvs;
								$chr_data[$char]['price'] = get_sum($table2, 'srv_price', $q);
								$chr_data[$char]['covered'] = get_sum($table2, 'srv_covered', $q);
							}
						}
					}

					$c_total = count($chr_data);
					$addTxt1 = '';
					if ($c_total) {
						$addTxt1 = '<span class="ff B">( ' . $c_total . ' )</ff> ';
					}
					foreach ($chr_data as $k => $d) {
						$c_id = $k;
						$srvs = $d['srvs'];
						$price = $d['price'];
						$covered = $d['covered'];
						$rec = getRecCon($table, " date='$act' and charity='$c_id' ");
						if ($srvs) {
							if ($rec['r']) {
								$status = 3;
								if ($srvs == $rec['srvs'] && $price == $rec['price'] && $covered == $rec['covered']) {
									$status = 2;
								} else {
									mysql_q("UPDATE $table SET srvs='$srvs' , price='$price' , covered='$covered' 
							where date ='$act' and charity='$c_id' ");
								}
							} else {
								$status = 1;
								mysql_q("INSERT INTO $table (date,charity,srvs,price,covered)	values('$act','$c_id','$srvs','$price','$covered')");
							}
						} else {
							if ($rec['r']) {
								mysql_q("DELETE from $table where date ='$act' and charity='$c_id' ");
							}
						}
					}
					$out .= '<div style="color:' . $secStatusCol[$status] . '">
			<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
			<span class="lh20 f1" > ' . $secStatus[$status] . ' ' . $addTxt1 . '</span>
			</div>';
				}
				if ($type == 5) {
					$insur_data = array();
					$sql = "select * from $table2  where s_date>='$d_s' and s_date < '$d_e' and status =1 ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$company = $r['company'];
							$price = $r['price'];
							$in_price = $r['in_price'];
							$in_price_includ = $r['in_price_includ'];
							$res_status = $r['res_status'];

							$insur_data[$company]['apps']++;
							$insur_data[$company]['price_srv'] += $price;
							$insur_data[$company]['price_in'] += $in_price;
							$insur_data[$company]['price_in_in'] += $in_price_includ;
							if ($res_status == 1) {
								$insur_data[$company]['not_caver'] += $in_price - $in_price_includ;
								$insur_data[$company]['accepted']++;
							}
							if ($res_status == 2) {
								$insur_data[$company]['reject']++;
							}
						}
					}
					$c_total = count($insur_data);
					$addTxt1 = '';
					if ($c_total) {
						$addTxt1 = '<span class="ff B">( ' . $c_total . ' )</ff> ';
					}
					foreach ($insur_data as $k => $d) {
						$company = $k;
						$apps = $d['apps'];
						$price_srv = intval($d['price_srv']);
						$price_in = intval($d['price_in']);
						$price_in_in = intval($d['price_in_in']);
						$not_caver = intval($d['not_caver']);
						$accepted = intval($d['accepted']);
						$reject = intval($d['reject']);

						$rec = getRecCon($table, " date='$act' and company='$company' ");
						if (!$apps) {
							$apps = 0;
						}
						if ($price_in_in) {
							if ($rec['r']) {
								$status = 3;
								$o_apps = $rec['apps'];
								$o_price_srv = $rec['price_srv'];
								$o_price_in = $rec['price_in'];
								$o_price_in_in = $rec['price_in_in'];
								$o_not_caver = $rec['not_caver'];
								$o_accepted = $rec['accepted'];
								$o_reject = $rec['reject'];


								$o_reject . '==' . $reject;
								if (
									$o_apps == $apps &&
									$o_price_srv == $price_srv &&
									$o_price_in == $price_in &&
									$o_price_in_in == $price_in_in &&
									$o_not_caver == $not_caver &&
									$o_accepted == $accepted &&
									$o_reject == $reject
								) {
									$status = 2;
								} else {
									mysql_q("UPDATE $table SET 
							apps='$apps' ,	price_srv='$price_srv' , price_in='$price_in' ,	price_in_in='$price_in_in' ,
							not_caver='$not_caver' , accepted='$accepted' , reject='$reject' 
							where date ='$act' and company='$company' ");
								}
							} else {
								$status = 1;
								mysql_q("INSERT INTO $table (date, company, price_in, price_in_in, not_caver, accepted, reject  )	values('$act','$company','$price_in', '$price_in_in', '$not_caver', '$accepted', '$reject' )");
							}
						} else {
							if ($rec['r']) {
								mysql_q("DELETE from $table where date ='$act' and company='$company' ");
							}
						}
					}
					$out .= '<div style="color:' . $secStatusCol[$status] . '">
			<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
			<span class="lh20 f1" > ' . $secStatus[$status] . ' ' . $addTxt1 . '</span>
			</div>';
				}
				if ($type == 6) {
					$recs_cln = $recs_xry = $recs_bty = $recs_lab = $recs_lsr = '';
					$recs_cln_err = $recs_xry_err = $recs_bty_err = $recs_lab_err = $recs_xry_err = $recs_lsr_err = '';
					echo '<div class="fs18 cbg1111 clrw pd10 lh30">' . date('Y-m-d', $act) . '</div>';
					/******************************/
					//CLN			
					$table = 'cln_x_visits';
					$table2 = 'cln_x_visits_services';
					$cType = 1;
					$sql = "select * from $table where d_start>='$d_s' and d_start < '$d_e' and status !=3 "; //status !=3
					$res = mysql_q($sql);
					$rows_cln = mysql_n($res);
					$s1 = $s2 = $s3 = $s4 = 0;
					$st0 = $st1 = $st2 = $st3 = 0;
					$sp0 = $sp1 = $sp2 = $sp3 = 0;
					$notFinish = '';
					$visErr = '';
					if ($rows_cln > 0) {
						while ($r = mysql_f($res)) {
							$vis = $r['id'];
							$clinic = $r['clinic'];
							$pay_type = $r['pay_type'];
							$senc = $r['senc'];
							$v_status = $r['status'];
							$o_doc_bal = $r['t_doc_bal'];
							$o_hos_bal = $r['t_hos_bal'];
							$o_doc_dis = $r['t_doc_dis'];
							$o_hos_dis = $r['t_hos_dis'];
							$o_total_pay = $r['t_total_pay'];
							$o_pay_net = $r['t_pay_net'];
							$o_d_start = $r['d_start'];
							$o_d_start = $o_d_start - ($o_d_start % 86400);
							$sencThis = 0;

							if ($senc) {
								$s1++;
							}
							${'st' . $v_status}++;
							${'sp' . $pay_type}++;

							$cash = getVisCashBal($cType, $vis);



							if (defPayDate($cType, $vis, $o_d_start) > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff>' . k_visit_defe_pay . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							$srvCash = 0;
							$thisVisErr = 0;
							if ($v_status == 1) {
								$notFinish .= '<div class="fl bu2 bu_t3 n' . $vis . '" onclick="endVisAcc(' . $cType . ',' . $vis . ')"><ff>' . $vis . '</ff></div>';
							}
							$sql2 = "select * from $table2 where visit_id='$vis' ";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);
							$t_doc_bal = $t_hos_bal = $t_doc_dis = $t_hos_dis = $t_total_pay = $t_pay_net = 0;
							if ($rows2 > 0) {
								while ($r2 = mysql_f($res2)) {
									$srv_id = $r2['id'];
									$hos_part = $r2['hos_part'];
									$doc_part = $r2['doc_part'];
									$total_pay = $r2['total_pay'];
									$doc_percent = $r2['doc_percent'];
									$pay_net = $r2['pay_net'];
									$srv_status = $r2['status'];
									$doc_bal = $r2['doc_bal'];
									$doc_dis = $r2['doc_dis'];
									$hos_bal = $r2['hos_bal'];
									$hos_dis = $r2['hos_dis'];
									$srv_pay_type = $r2['pay_type'];
									$cost = $r2['cost'];


									$c_fp_dd = 0;
									$c_fp_hh = 0;
									if ($pay_type == 2 || $pay_type == 3) {
										$dis = 0;
									}
									if ($dis == 0) {
										$c_doc_bal = intval($doc_percent * $doc_part / 100);
										$c_hos_bal = $total_pay - $doc_bal;
									} else {
										if ($hos_part <= $doc_part) {
											$dis_x = $hos_part / $doc_part;
											$c_fp_dd = intval($dis / ($dis_x + 1));
											$c_fp_hh = $dis - $fp_dd;
										} else {
											$dis_x = $doc_part / $hos_part;
											$c_fp_hh = intval($dis / ($dis_x + 1));
											$c_fp_dd = $dis - $fp_hh;
										}
										if ($pay_net == 0 && $pay_type == 1) {
											$c_doc_bal = 0;
											$hos_bal = 0;
										} else {
											$c_doc_bal = intval(($doc_part - $fp_dd) / 100 * $doc_percent);
											$c_hos_bal = ($total_pay - $dis) - $doc_bal;
										}
									}
									if ($clinicType == 3 && $cost > 0) {
										$c_doc_bal = (($doc_part - $cost) / 100 * $doc_percent);
									}
									if ($pay_type == 3 && $total_pay && $srv_pay_type == 3) {
										$insurVal = $total_pay - $pay_net;
										$r3 = getRecCon('gnr_x_insurance_rec', " service_x='$srv_id' and mood='$cType' ");
										if ($r3['r']) {
											$i_price = $r3['price'];
											$i_in_price = $r3['in_price'];
											$i_in_price_includ = $r3['in_price_includ'];
											$i_in_cost = $r3['in_cost'];
											$i_res_status = $r3['res_status'];
											$i_status = $r3['status'];
											$ins_rVal = $i_in_price - $i_in_price_includ;
											if ($ins_rVal != $pay_net) {
												echo $vis . '|([' . $ins_rVal . '])!=' . $pay_net . ')_(' . $i_in_price . '-' . $i_in_price_includ . ')<br>';
												$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_ins_amount_not_match_visit . '</div>';
												$s4++;
												$thisVisErr = 1;
											}
										} else {
											$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_no_ins_record . '</div>';
											$s4++;
											$thisVisErr = 1;
										}
									}

									if ($srv_status != 3) {
										$srvCash += $pay_net;
										$t_doc_bal += $doc_bal;
										$t_hos_bal += $hos_bal;
										$t_doc_dis += $doc_dis;
										$t_hos_dis += $hos_dis;
										$t_total_pay += $total_pay;
										$t_pay_net += $pay_net;
									}
								}
							} else {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | ' . k_visit_without_ser . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							if ($srvCash != $cash) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | ' . k_no_fin_balance . ' </div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							$ss_d = $o_d_start;
							$ee_d = $ss_d + 86400;
							if (getTotalCO('gnr_x_acc_payments', "mood like '$cType%' and vis='$vis' and (date=>'$ee_d' or date< '$ss_d')") > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | ' . k_pay_date_not_match . ' </div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							/*if($vis==9880){
					echo '('.$doc_bal.'=='.$c_doc_bal.')('.$hos_bal.'=='.$c_hos_bal.')('.$doc_dis.'=='.$c_fp_dd.')('.$hos_dis.'=='.$c_fp_hh.')<br>';
					}*/
							if (($doc_bal == $c_doc_bal && $hos_bal == $c_hos_bal && $doc_dis == $c_fp_dd && $hos_dis == $c_fp_hh) || $v_status == 1) {
							} else {
								if ($v_status != 3) {
									echo '([' . $doc_bal . ']==' . $c_doc_bal . ')(' . $hos_bal . '==' . $c_hos_bal . ')(' . $doc_dis . '==' . $c_fp_dd . ')(' . $hos_dis . '==' . $c_fp_hh . ')<br>';
									$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_account_ser_not_match . '

							</div>';
									$s4++;
									$thisVisErr = 1;
								}
							}
							/********************************/

							//if($thisVisErr==0 || ($senc==1 && $t_total_pay==0)){
							$sql5 = "UPDATE $table SET 
						t_doc_bal='$t_doc_bal',
						t_hos_bal='$t_hos_bal',
						t_doc_dis='$t_doc_dis',
						t_hos_dis='$t_hos_dis',
						t_total_pay='$t_total_pay',
						t_pay_net='$t_pay_net',
						senc=1
						where id='$vis'";
							if (mysql_q($sql5)) {
								if ($senc == 0) {
									$s1++;
								} else {
									if (
										$t_doc_bal == $o_doc_bal &&
										$t_hos_bal == $o_hos_bal &&
										$t_doc_dis == $o_doc_dis &&
										$t_hos_dis == $o_hos_dis &&
										$t_total_pay == $o_total_pay &&
										$t_pay_net == $o_pay_net
									) {
										$s2++;
									} else {
										$s3++;
									}
								}
							}
							//}
						}
						$recs_cln .= '
				<tr>
					<td class="f1 fs16">' . k_clinics . '<ff>( ' . $rows_cln . ' )</ff></td>
					<td><ff class="clr1">' . $s1 . '</ff></td>
					<td><ff class="clr6">' . $s2 . '</ff></td>
					<td><ff class="clr5">' . $s3 . '</ff></td>
					<td><ff class="clr55">' . $s4 . '</ff></td>
					<td><ff class="clr4">' . $st0 . '</ff></td>
					<td><ff class="clr1">' . $st1 . '</ff></td>
					<td><ff class="clr6">' . $st2 . '</ff></td>
					<td><ff class="clr5">' . $st3 . '</ff></td>
					<td><ff class="clr1">' . $sp0 . '</ff></td>
					<td><ff class="clr11">' . $sp1 . '</ff></td>
					<td><ff class="clr111">' . $sp2 . '</ff></td>
					<td><ff class="clr1111">' . $sp3 . '</ff></td>
				</tr>';

						if ($notFinish) {
							$recs_cln_err .= '<div class="fl w100 clr5 fs14 f1 lh20">' . $notFinish . '</div><div class="cb w100 t_bord">&nbsp;</div>';
						}
						if ($visErr) {
							$recs_cln_err .= '<div class="clr55 fs14 f1 lh20 "><ff class="fs14">' . $visErr . '</ff></div>';
						}
					}
					/******************************/
					//XRY			
					$table = 'xry_x_visits';
					$table2 = 'xry_x_visits_services';
					$cType = 3;
					$sql = "select * from $table where d_start>='$d_s' and d_start < '$d_e' and status !=3 ";
					$res = mysql_q($sql);
					$rows_xry = mysql_n($res);
					$s1 = $s2 = $s3 = $s4 = 0;
					$st0 = $st1 = $st2 = $st3 = 0;
					$sp0 = $sp1 = $sp2 = $sp3 = 0;
					$notFinish = '';
					$visErr = '';
					if ($rows_xry > 0) {
						while ($r = mysql_f($res)) {
							$vis = $r['id'];
							$clinic = $r['clinic'];
							$pay_type = $r['pay_type'];
							$senc = $r['senc'];
							$v_status = $r['status'];
							$o_doc_bal = $r['t_doc_bal'];
							$o_hos_bal = $r['t_hos_bal'];
							$o_doc_dis = $r['t_doc_dis'];
							$o_hos_dis = $r['t_hos_dis'];
							$o_total_pay = $r['t_total_pay'];
							$o_pay_net = $r['t_pay_net'];
							$o_d_start = $r['d_start'];
							$o_d_start = $o_d_start - ($o_d_start % 86400);
							$sencThis = 0;

							if ($senc) {
								$s1++;
							}
							${'st' . $v_status}++;
							${'sp' . $pay_type}++;

							$cash = getVisCashBal($cType, $vis);
							if (defPayDate($cType, $vis, $o_d_start) > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff>' . k_visit_defe_pay . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							$srvCash = 0;
							$thisVisErr = 0;
							if ($v_status == 1) {
								$notFinish .= '<div class="fl bu2 bu_t3 n' . $vis . '" onclick="endVisAcc(' . $cType . ',' . $vis . ')"><ff>' . $vis . '</ff></div>';
							}
							$sql2 = "select * from $table2 where visit_id='$vis' ";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);
							$t_doc_bal = $t_hos_bal = $t_doc_dis = $t_hos_dis = $t_total_pay = $t_pay_net = 0;
							if ($rows2 > 0) {
								while ($r2 = mysql_f($res2)) {
									$srv_id = $r2['id'];
									$hos_part = $r2['hos_part'];
									$doc_part = $r2['doc_part'];
									$total_pay = $r2['total_pay'];
									$doc_percent = $r2['doc_percent'];
									$pay_net = $r2['pay_net'];
									$srv_status = $r2['status'];
									$doc_bal = $r2['doc_bal'];
									$doc_dis = $r2['doc_dis'];
									$hos_bal = $r2['hos_bal'];
									$hos_dis = $r2['hos_dis'];
									$srv_pay_type = $r2['pay_type'];
									$cost = $r2['cost'];

									if ($srv_status == 6) {
										$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff> ' . k_incomplete_x_report . ' </div>';
										$s4++;
										$thisVisErr = 1;
									}

									$c_fp_dd = 0;
									$c_fp_hh = 0;
									if ($pay_type == 2 || $pay_type == 3) {
										$dis = 0;
									}
									if ($dis == 0) {
										$c_doc_bal = intval($doc_percent * $doc_part / 100);
										$c_hos_bal = $total_pay - $doc_bal;
									} else {
										if ($hos_part <= $doc_part) {
											$dis_x = $hos_part / $doc_part;
											$c_fp_dd = intval($dis / ($dis_x + 1));
											$c_fp_hh = $dis - $fp_dd;
										} else {
											$dis_x = $doc_part / $hos_part;
											$c_fp_hh = intval($dis / ($dis_x + 1));
											$c_fp_dd = $dis - $fp_hh;
										}
										if ($pay_net == 0 && $pay_type == 1) {
											$c_doc_bal = 0;
											$hos_bal = 0;
										} else {
											$c_doc_bal = intval(($doc_part - $fp_dd) / 100 * $doc_percent);
											$c_hos_bal = ($total_pay - $dis) - $doc_bal;
										}
									}
									if ($clinicType == 3 && $cost > 0) {
										$c_doc_bal = (($doc_part - $cost) / 100 * $doc_percent);
									}
									if ($pay_type == 3 && $total_pay && $srv_pay_type == 3) {
										$insurVal = $total_pay - $pay_net;
										$r3 = getRecCon('gnr_x_insurance_rec', " service_x='$srv_id' and mood='$cType' ");
										if ($r3['r']) {
											$i_price = $r3['price'];
											$i_in_price = $r3['in_price'];
											$i_in_price_includ = $r3['in_price_includ'];
											$i_in_cost = $r3['in_cost'];
											$i_res_status = $r3['res_status'];
											$i_status = $r3['status'];
											$ins_rVal = $i_in_price - $i_in_price_includ;
											if ($ins_rVal != $pay_net) {
												echo $vis . '|([' . $ins_rVal . '])!=' . $pay_net . ')_(' . $i_in_price . '-' . $i_in_price_includ . ')<br>';
												$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_ins_amount_not_match_visit . ' </div>';
												$s4++;
												$thisVisErr = 1;
											}
										} else {
											$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_no_ins_record . ' </div>';
											$s4++;
											$thisVisErr = 1;
										}
									}

									if ($srv_status != 3) {
										$srvCash += $pay_net;
										$t_doc_bal += $doc_bal;
										$t_hos_bal += $hos_bal;
										$t_doc_dis += $doc_dis;
										$t_hos_dis += $hos_dis;
										$t_total_pay += $total_pay;
										$t_pay_net += $pay_net;
									}
								}
							} else {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_visit_without_ser . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							if ($srvCash != $cash) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_no_fin_balance . ' </div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							$ss_d = $o_d_start;
							$ee_d = $ss_d + 86400;
							if (getTotalCO('gnr_x_acc_payments', "mood like '$cType%' and vis='$vis' and (date=>'$ee_d' or date< '$ss_d')") > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_pay_date_not_match . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							/*if($vis==9880){
					echo '('.$doc_bal.'=='.$c_doc_bal.')('.$hos_bal.'=='.$c_hos_bal.')('.$doc_dis.'=='.$c_fp_dd.')('.$hos_dis.'=='.$c_fp_hh.')<br>';
					}*/
							if (($doc_bal == $c_doc_bal && $hos_bal == $c_hos_bal && $doc_dis == $c_fp_dd && $hos_dis == $c_fp_hh) || $v_status == 1) {
							} else {
								if ($v_status != 3) {
									//echo '(['.$doc_bal.']=='.$c_doc_bal.')('.$hos_bal.'=='.$c_hos_bal.')('.$doc_dis.'=='.$c_fp_dd.')('.$hos_dis.'=='.$c_fp_hh.')<br>';
									$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_account_ser_not_match . '

							</div>';
									$s4++;
									$thisVisErr = 1;
								}
							}
							/********************************/

							//if($thisVisErr==0){
							$sql5 = "UPDATE $table SET 
						t_doc_bal='$t_doc_bal',
						t_hos_bal='$t_hos_bal',
						t_doc_dis='$t_doc_dis',
						t_hos_dis='$t_hos_dis',
						t_total_pay='$t_total_pay',
						t_pay_net='$t_pay_net',
						senc=1
						where id='$vis'";
							if (mysql_q($sql5)) {
								if ($senc == 0) {
									$s1++;
								} else {
									if (
										$t_doc_bal == $o_doc_bal &&
										$t_hos_bal == $o_hos_bal &&
										$t_doc_dis == $o_doc_dis &&
										$t_hos_dis == $o_hos_dis &&
										$t_total_pay == $o_total_pay &&
										$t_pay_net == $o_pay_net
									) {
										$s2++;
									} else {
										$s3++;
									}
								}
							}
							//}
						}
						$recs_xry .= '
				<tr>
					<td class="f1 fs16">' . k_r_graphs . ' <ff>( ' . $rows_xry . ' )</ff></td>
					<td><ff class="clr1">' . $s1 . '</ff></td>
					<td><ff class="clr6">' . $s2 . '</ff></td>
					<td><ff class="clr5">' . $s3 . '</ff></td>
					<td><ff class="clr55">' . $s4 . '</ff></td>
					<td><ff class="clr4">' . $st0 . '</ff></td>
					<td><ff class="clr1">' . $st1 . '</ff></td>
					<td><ff class="clr6">' . $st2 . '</ff></td>
					<td><ff class="clr5">' . $st3 . '</ff></td>
					<td><ff class="clr1">' . $sp0 . '</ff></td>
					<td><ff class="clr11">' . $sp1 . '</ff></td>
					<td><ff class="clr111">' . $sp2 . '</ff></td>
					<td><ff class="clr1111">' . $sp3 . '</ff></td>
				</tr>';

						if ($notFinish) {
							$recs_xry_err .= '<div class="clr5 fs14 f1 lh20 cb">' . $notFinish . '</div><div class="cb t_bord">&nbsp;</div>';
						}
						if ($visErr) {
							$recs_xry_err .= '<div class="clr55 fs14 f1 lh20 "><ff class="fs14">' . $visErr . '</ff></div>';
						}
					}
					/******************************/
					//BTY
					$cType = 5;
					$table = 'bty_x_visits';
					$table2 = 'bty_x_visits_services';
					$sql = "select * from $table where d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows_bty = mysql_n($res);
					$s1 = $s2 = $s3 = $s4 = 0;
					$st0 = $st1 = $st2 = $st3 = 0;
					$sp0 = $sp1 = $sp2 = $sp3 = 0;
					$notFinish = '';
					$visErr = '';
					if ($rows_bty > 0) {
						while ($r = mysql_f($res)) {
							$vis = $r['id'];
							$clinic = $r['clinic'];
							$pay_type = $r['pay_type'];
							$senc = $r['senc'];
							$v_status = $r['status'];
							$o_doc_bal = $r['t_doc_bal'];
							$o_hos_bal = $r['t_hos_bal'];
							$o_doc_dis = $r['t_doc_dis'];
							$o_hos_dis = $r['t_hos_dis'];
							$o_total_pay = $r['t_total_pay'];
							$o_pay_net = $r['t_pay_net'];
							$o_d_start = $r['d_start'];
							$o_d_start = $o_d_start - ($o_d_start % 86400);
							$sencThis = 0;

							if ($senc) {
								$s1++;
							}
							${'st' . $v_status}++;
							${'sp' . $pay_type}++;
							$cash = getVisCashBal($cType, $vis);
							if (defPayDate($cType, $vis, $o_d_start) > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff>' . k_visit_defe_pay . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							$srvCash = 0;
							$thisVisErr = 0;
							if ($v_status == 1) {
								$notFinish .= '<div class="fl bu2 bu_t3 n' . $vis . '" onclick="endVisAcc(' . $cType . ',' . $vis . ')"><ff>' . $vis . '</ff></div>';
							}
							$sql2 = "select * from $table2 where visit_id='$vis' and status!=3";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);
							$t_doc_bal = $t_hos_bal = $t_doc_dis = $t_hos_dis = $t_total_pay = $t_pay_net = 0;
							if ($rows2 > 0) {
								while ($r2 = mysql_f($res2)) {
									$srv_id = $r2['id'];
									$hos_part = $r2['hos_part'];
									$doc_part = $r2['doc_part'];
									$total_pay = $r2['total_pay'];
									$doc_percent = $r2['doc_percent'];
									$pay_net = $r2['pay_net'];
									$srv_status = $r2['status'];
									$doc_bal = $r2['doc_bal'];
									$doc_dis = $r2['doc_dis'];
									$hos_bal = $r2['hos_bal'];
									$hos_dis = $r2['hos_dis'];
									$srv_pay_type = $r2['pay_type'];
									$cost = $r2['cost'];

									if ($pay_type == 2 || $pay_type == 3) {
										$dis = 0;
									}
									if ($dis == 0) {
										$c_doc_bal = intval($doc_percent * $doc_part / 100);
										$c_hos_bal = $total_pay - $doc_bal;
									} else {
										if ($hos_part <= $doc_part) {
											$dis_x = $hos_part / $doc_part;
											$c_fp_dd = intval($dis / ($dis_x + 1));
											$c_fp_hh = $dis - $fp_dd;
										} else {
											$dis_x = $doc_part / $hos_part;
											$c_fp_hh = intval($dis / ($dis_x + 1));
											$c_fp_dd = $dis - $fp_hh;
										}
										if ($pay_net == 0 && $pay_type == 1) {
											$c_doc_bal = 0;
											$hos_bal = 0;
										} else {
											$c_doc_bal = intval(($doc_part - $fp_dd) / 100 * $doc_percent);
											$c_hos_bal = ($total_pay - $dis) - $doc_bal;
										}
									}
									if ($clinicType == 3 && $cost > 0) {
										$c_doc_bal = ($doc_part - $cost) / 100 * $doc_percent;
									}
									if ($pay_type == 3 && $total_pay && $srv_pay_type == 3) {
										$insurVal = $total_pay - $pay_net;
										$r3 = getRecCon('gnr_x_insurance_rec', " service_x='$srv_id' and mood='$cType' ");
										if ($r3['r']) {
											$i_price = $r3['price'];
											$i_in_price = $r3['in_price'];
											$i_in_price_includ = $r3['in_price_includ'];
											$i_in_cost = $r3['in_cost'];
											$i_res_status = $r3['res_status'];
											$i_status = $r3['status'];
											$ins_rVal = $i_in_price - $i_in_price_includ;
											if ($ins_rVal != $pay_net) {
												$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_ins_amount_not_match_visit . ' </div>';
												$s4++;
												$thisVisErr = 1;
											}
										} else {
											$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_no_ins_record . ' </div>';
											$s4++;
											$thisVisErr = 1;
										}
									}


									if ($srv_status != 3) {
										$srvCash += $pay_net;
										$t_doc_bal += $doc_bal;
										$t_hos_bal += $hos_bal;
										$t_doc_dis += $doc_dis;
										$t_hos_dis += $hos_dis;
										$t_total_pay += $total_pay;
										$t_pay_net += $pay_net;
									}
								}
							} else {
								if (getTotalCO($table2, "visit_id='$vis'") == 0) {
									$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_visit_without_ser . '</div>';
									$s4++;
									$thisVisErr = 1;
								}
							}
							if ($srvCash != $cash && $pay_type != 2) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_no_fin_balance . ' </div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							$ss_d = $o_d_start;
							$ee_d = $ss_d + 86400;
							if (getTotalCO('gnr_x_acc_payments', "mood like '$cType%' and vis='$vis' and (date=>'$ee_d' or date< '$ss_d')") > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_pay_date_not_match . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							if (!$c_fp_dd) {
								$c_fp_dd = 0;
							}
							if (!$c_fp_hh) {
								$c_fp_hh = 0;
							}
							//echo '('.$doc_bal.'=='.$c_doc_bal.')('.$hos_bal.'=='.$c_hos_bal.')('.$doc_dis.'=='.$c_fp_dd.')('.$hos_dis.'=='.$c_fp_hh.')<br>';				
							if (($doc_bal == $c_doc_bal && $hos_bal == $c_hos_bal && $doc_dis == $c_fp_dd && $hos_dis == $c_fp_hh) || $v_status == 1) {
								//if( $hos_dis==$c_hos_bal || $v_status==1){

							} else {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_account_ser_not_match . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							/********************************/

							//if($thisVisErr==0){
							$sql5 = "UPDATE $table SET 
						t_doc_bal='$t_doc_bal',
						t_hos_bal='$t_hos_bal',
						t_doc_dis='$t_doc_dis',
						t_hos_dis='$t_hos_dis',
						t_total_pay='$t_total_pay',
						t_pay_net='$t_pay_net',
						senc=1
						where id='$vis'";
							if (mysql_q($sql5)) {
								if ($senc == 0) {
									$s1++;
								} else {
									if (
										$t_doc_bal == $o_doc_bal &&
										$t_hos_bal == $o_hos_bal &&
										$t_doc_dis == $o_doc_dis &&
										$t_hos_dis == $o_hos_dis &&
										$t_total_pay == $o_total_pay &&
										$t_pay_net == $o_pay_net
									) {
										$s2++;
									} else {
										$s3++;
									}
								}
							}
							//}
						}
						$recs_bty .= '
				<tr>
					<td class="f1 fs16">' . k_tbty . ' <ff>( ' . $rows_bty . ' )</ff></td>
					<td><ff class="clr1">' . $s1 . '</ff></td>
					<td><ff class="clr6">' . $s2 . '</ff></td>
					<td><ff class="clr5">' . $s3 . '</ff></td>
					<td><ff class="clr55">' . $s4 . '</ff></td>
					<td><ff class="clr4">' . $st0 . '</ff></td>
					<td><ff class="clr1">' . $st1 . '</ff></td>
					<td><ff class="clr6">' . $st2 . '</ff></td>
					<td><ff class="clr5">' . $st3 . '</ff></td>
					<td><ff class="clr1">' . $sp0 . '</ff></td>
					<td><ff class="clr11">' . $sp1 . '</ff></td>
					<td><ff class="clr111">' . $sp2 . '</ff></td>
			
			<td><ff class="clr1111">' . $sp3 . '</ff></td>
				</tr>';
						if ($notFinish) {
							$recs_bty_err .= '<div class="clr5 fs14 f1 lh20 cb">' . $notFinish . '</div><div class="cb t_bord">&nbsp;</div>';
						}
						if ($visErr) {
							$recs_bty_err .= '<div class="clr55 fs14 f1 lh20 "><ff class="fs14">' . $visErr . '</ff></div>';
						}
					}
					/***********************************/
					//LSR
					$cType = 6;
					$table = 'bty_x_laser_visits';
					$sql = "select * from $table where d_start>='$d_s' and d_start < '$d_e' ";
					$res = mysql_q($sql);
					$rows_lsr = mysql_n($res);
					$s4 = 0;
					$st0 = $st1 = $st2 = $st3 = 0;
					$notFinish = '';
					$visErr = '';
					if ($rows_lsr > 0) {
						while ($r = mysql_f($res)) {
							$vis = $r['id'];
							$clinic = $r['clinic'];


							$v_status = $r['status'];
							$vis_shoot = $r['vis_shoot_r'];
							$price = $r['price'];
							$dis = $r['dis'];
							$total = $r['total'];
							$total_pay = $r['total_pay'];

							$o_d_start = $r['d_start'];
							$o_d_start = $o_d_start - ($o_d_start % 86400);

							${'st' . $v_status}++;
							$cash = getVisCashBal($cType, $vis);
							if (defPayDate($cType, $vis, $o_d_start) > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff>' . k_visit_defe_pay . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							$srvCash = $total_pay;
							$thisVisErr = 0;
							if ($v_status == 1) {
								$notFinish .= '<div class="fl bu2 bu_t3 n' . $vis . '" onclick="endVisAcc(' . $cType . ',' . $vis . ')"><ff>' . $vis . '</ff></div>';
							}
							if ($srvCash != $cash) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_no_fin_balance . '</div>';
								$s4++;
							}
							/*******************************/
							$ss_d = $o_d_start;
							$ee_d = $ss_d + 86400;
							if (getTotalCO('gnr_x_acc_payments', "mood like '$cType%' and vis='$vis' and (date=>'$ee_d' or date< '$ss_d')") > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_pay_date_not_match . '</div>';
								$s4++;
							}
							/*******************************/
							if (intval(($vis_shoot * $price) - $total) > 1) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_account_ser_not_match . ' <ff>(' . (intval($vis_shoot * $price) - $total) . ')</ff></div>';
								$s4++;
							}
							/********************************/
						}
						$recs_lsr .= '
				<tr>
					<td class="f1 fs16">' . k_tlaser . ' <ff>( ' . $rows_lsr . ' )</ff></td>
					<td><ff class="clr1">-</ff></td>
					<td><ff class="clr6">-</ff></td>
					<td><ff class="clr5">-</ff></td>
					<td><ff class="clr55">' . $s4 . '</ff></td>
					<td><ff class="clr4">' . $st0 . '</ff></td>
					<td><ff class="clr1">' . $st1 . '</ff></td>
					<td><ff class="clr6">' . $st2 . '</ff></td>
					<td><ff class="clr5">' . $st3 . '</ff></td>
					<td><ff class="clr1">-</ff></td>
					<td><ff class="clr11">-</ff></td>
					<td><ff class="clr111">-</ff></td>
					<td><ff class="clr1111">-</ff></td>
				</tr>';
						if ($notFinish) {
							$recs_lsr_err .= '<div class="clr5 fs14 f1 lh20 cb">' . $notFinish . '</div><div class="cb t_bord">&nbsp;</div>';
						}
						if ($visErr) {
							$recs_lsr_err .= '<div class="clr55 fs14 f1 lh20 "><ff class="fs14">' . $visErr . '</ff></div>';
						}
					}
					/***********************************/
					//OSC			
					$table = 'osc_x_visits';
					$table2 = 'osc_x_visits_services';
					$cType = 7;
					$sql = "select * from $table where d_start>='$d_s' and d_start < '$d_e' and status !=3 ";
					$res = mysql_q($sql);
					$rows_osc = mysql_n($res);
					$s1 = $s2 = $s3 = $s4 = 0;
					$st0 = $st1 = $st2 = $st3 = 0;
					$sp0 = $sp1 = $sp2 = $sp3 = 0;
					$notFinish = '';
					$visErr = '';
					if ($rows_osc > 0) {
						while ($r = mysql_f($res)) {
							$vis = $r['id'];
							$clinic = $r['clinic'];
							$pay_type = $r['pay_type'];
							$senc = $r['senc'];
							$v_status = $r['status'];
							$o_doc_bal = $r['t_doc_bal'];
							$o_hos_bal = $r['t_hos_bal'];
							$o_doc_dis = $r['t_doc_dis'];
							$o_hos_dis = $r['t_hos_dis'];
							$o_total_pay = $r['t_total_pay'];
							$o_pay_net = $r['t_pay_net'];
							$o_d_start = $r['d_start'];
							$o_d_start = $o_d_start - ($o_d_start % 86400);
							$sencThis = 0;

							if ($senc) {
								$s1++;
							}
							${'st' . $v_status}++;
							${'sp' . $pay_type}++;

							$cash = getVisCashBal($cType, $vis);
							if (defPayDate($cType, $vis, $o_d_start) > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff>' . k_visit_defe_pay . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							$srvCash = 0;
							$thisVisErr = 0;
							if ($v_status == 1) {
								$notFinish .= '<div class="fl bu2 bu_t3 n' . $vis . '" onclick="endVisAcc(' . $cType . ',' . $vis . ')"><ff>' . $vis . '</ff></div>';
							}
							$sql2 = "select * from $table2 where visit_id='$vis' ";
							$res2 = mysql_q($sql2);
							$rows2 = mysql_n($res2);
							$t_doc_bal = $t_hos_bal = $t_doc_dis = $t_hos_dis = $t_total_pay = $t_pay_net = 0;
							if ($rows2 > 0) {
								while ($r2 = mysql_f($res2)) {
									$srv_id = $r2['id'];
									$hos_part = $r2['hos_part'];
									$doc_part = $r2['doc_part'];
									$total_pay = $r2['total_pay'];
									$doc_percent = $r2['doc_percent'];
									$pay_net = $r2['pay_net'];
									$srv_status = $r2['status'];
									$doc_bal = $r2['doc_bal'];
									$doc_dis = $r2['doc_dis'];
									$hos_bal = $r2['hos_bal'];
									$hos_dis = $r2['hos_dis'];
									$srv_pay_type = $r2['pay_type'];
									$cost = $r2['cost'];

									$c_fp_dd = 0;
									$c_fp_hh = 0;
									if ($pay_type == 2 || $pay_type == 3) {
										$dis = 0;
									}
									if ($dis == 0) {
										$c_doc_bal = intval($doc_percent * $doc_part / 100);
										$c_hos_bal = $total_pay - $doc_bal;
									} else {
										if ($hos_part <= $doc_part) {
											$dis_x = $hos_part / $doc_part;
											$c_fp_dd = intval($dis / ($dis_x + 1));
											$c_fp_hh = $dis - $fp_dd;
										} else {
											$dis_x = $doc_part / $hos_part;
											$c_fp_hh = intval($dis / ($dis_x + 1));
											$c_fp_dd = $dis - $fp_hh;
										}
										if ($pay_net == 0 && $pay_type == 1) {
											$c_doc_bal = 0;
											$hos_bal = 0;
										} else {
											$c_doc_bal = intval(($doc_part - $fp_dd) / 100 * $doc_percent);
											$c_hos_bal = ($total_pay - $dis) - $doc_bal;
										}
									}
									if ($clinicType == 3 && $cost > 0) {
										$c_doc_bal = (($doc_part - $cost) / 100 * $doc_percent);
									}
									if ($pay_type == 3 && $total_pay && $srv_pay_type == 3) {
										$insurVal = $total_pay - $pay_net;
										$r3 = getRecCon('gnr_x_insurance_rec', " service_x='$srv_id' and mood='$cType' ");
										if ($r3['r']) {
											$i_price = $r3['price'];
											$i_in_price = $r3['in_price'];
											$i_in_price_includ = $r3['in_price_includ'];
											$i_in_cost = $r3['in_cost'];
											$i_res_status = $r3['res_status'];
											$i_status = $r3['status'];
											$ins_rVal = $i_in_price - $i_in_price_includ;
											if ($ins_rVal != $pay_net) {
												echo $vis . '|([' . $ins_rVal . '])!=' . $pay_net . ')_(' . $i_in_price . '-' . $i_in_price_includ . ')<br>';
												$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_ins_amount_not_match_visit . ' </div>';
												$s4++;
												$thisVisErr = 1;
											}
										} else {
											$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_no_ins_record . ' </div>';
											$s4++;
											$thisVisErr = 1;
										}
									}

									if ($srv_status != 3) {
										$srvCash += $pay_net;
										$t_doc_bal += $doc_bal;
										$t_hos_bal += $hos_bal;
										$t_doc_dis += $doc_dis;
										$t_hos_dis += $hos_dis;
										$t_total_pay += $total_pay;
										$t_pay_net += $pay_net;
									}
								}
							} else {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_visit_without_ser . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							if ($srvCash != $cash) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_no_fin_balance . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							$ss_d = $o_d_start;
							$ee_d = $ss_d + 86400;
							if (getTotalCO('gnr_x_acc_payments', "mood like '$cType%' and vis='$vis' and (date=>'$ee_d' or date< '$ss_d')") > 0) {
								$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> |' . k_pay_date_not_match . '</div>';
								$s4++;
								$thisVisErr = 1;
							}
							/*******************************/
							/*if($vis==9880){
					echo '('.$doc_bal.'=='.$c_doc_bal.')('.$hos_bal.'=='.$c_hos_bal.')('.$doc_dis.'=='.$c_fp_dd.')('.$hos_dis.'=='.$c_fp_hh.')<br>';
					}*/
							if (($doc_bal == $c_doc_bal && $hos_bal == $c_hos_bal && $doc_dis == $c_fp_dd && $hos_dis == $c_fp_hh) || $v_status == 1) {
							} else {
								if ($v_status != 3) {
									//echo '(['.$doc_bal.']=='.$c_doc_bal.')('.$hos_bal.'=='.$c_hos_bal.')('.$doc_dis.'=='.$c_fp_dd.')('.$hos_dis.'=='.$c_fp_hh.')<br>';
									$visErr .= '<div class="clr55 f1 lh20"><ff class="cbg1 clrw Over" onclick="showAcc(' . $vis . ',' . $cType . ')">' . $vis . '</ff> | <ff> s' . $srv_id . ' | </ff>' . k_account_ser_not_match
										. '
							</div>';
									$s4++;
									$thisVisErr = 1;
								}
							}
							/********************************/

							//if($thisVisErr==0){
							$sql5 = "UPDATE $table SET 
						t_doc_bal='$t_doc_bal',
						t_hos_bal='$t_hos_bal',
						t_doc_dis='$t_doc_dis',
						t_hos_dis='$t_hos_dis',
						t_total_pay='$t_total_pay',
						t_pay_net='$t_pay_net',
						senc=1
						where id='$vis'";
							if (mysql_q($sql5)) {
								if ($senc == 0) {
									$s1++;
								} else {
									if (
										$t_doc_bal == $o_doc_bal &&
										$t_hos_bal == $o_hos_bal &&
										$t_doc_dis == $o_doc_dis &&
										$t_hos_dis == $o_hos_dis &&
										$t_total_pay == $o_total_pay &&
										$t_pay_net == $o_pay_net
									) {
										$s2++;
									} else {
										$s3++;
									}
								}
							}
							//}
						}
						$recs_osc .= '
				<tr>
					<td class="f1 fs16">' . k_endoscopy . ' <ff>( ' . $rows_osc . ' )</ff></td>
					<td><ff class="clr1">' . $s1 . '</ff></td>
					<td><ff class="clr6">' . $s2 . '</ff></td>
					<td><ff class="clr5">' . $s3 . '</ff></td>
					<td><ff class="clr55">' . $s4 . '</ff></td>
					<td><ff class="clr4">' . $st0 . '</ff></td>
					<td><ff class="clr1">' . $st1 . '</ff></td>
					<td><ff class="clr6">' . $st2 . '</ff></td>
					<td><ff class="clr5">' . $st3 . '</ff></td>
					<td><ff class="clr1">' . $sp0 . '</ff></td>
					<td><ff class="clr11">' . $sp1 . '</ff></td>
					<td><ff class="clr111">' . $sp2 . '</ff></td>
					<td><ff class="clr1111">' . $sp3 . '</ff></td>
				</tr>';

						if ($notFinish) {
							$recs_osc_err .= '<div class="clr5 fs14 f1 lh20 cb">' . $notFinish . '</div><div class="cb t_bord">&nbsp;</div>';
						}
						if ($visErr) {
							$recs_osc_err .= '<div class="clr55 fs14 f1 lh20 "><ff class="fs14">' . $visErr . '</ff></div>';
						}
					}
					/******************************/
					if ($rows_cln + $rows_xry + $rows_bty + $recs_lsr + $recs_osc) {
						echo '
				<table class="grad_s" type="static" cellpadding="4" cellspacing="0" width="100%">
				<tr>
					<th rowspan="2">' . k_the_sec . '</th>
					<th colspan="4">' . k_sync . '</th>
					<th colspan="4">' . k_visit_cases . '</th>
					<th colspan="4">' . k_pay_cases . '</th>
				</tr>
				<tr>
					<th>' . k_syncz . '</th>
					<th>' . k_match . '</th>
					<th>' . k_not_match . '</th>					
					<th>' . k_errors . '</th>
					<th>' . k_increation . '</th>
					<th>' . k_undone . '</th>
					<th>' . k_complete . '</th>
					<th>' . k_cncled . '</th>
					<th>' . k_vnorm . '</th>
					<th>' . k_exemption . '</th>
					<th>' . k_charity . '</th>
					<th>' . k_insurance . '</th>
				</tr>' . $recs_cln . $recs_xry . $recs_bty . $recs_lab . $recs_lsr . $recs_osc . '
				</table>';
					} else {
						echo '<div class="clr5 f1 fs16 lh40">' . k_no_oper_today . '</div>';
					}

					if ($recs_cln_err || $recs_xry_err || $recs_bty_err || $recs_lsr_err || $recs_osc_err) {
						echo '<table class="grad_s" type="static" cellpadding="4" cellspacing="0" width="100%">
				<tr >';
						if ($recs_cln_err) {
							echo '<th style="background-color:#a00">' . k_cln_errors . '</th>';
						}
						if ($recs_xry_err) {
							echo '<th style="background-color:#a00">' . k_xray_errors . '</th>';
						}
						if ($recs_bty_err) {
							echo '<th style="background-color:#a00">' . k_cos_errors . '</th>';
						}
						if ($recs_lsr_err) {
							echo '<th style="background-color:#a00">' . k_laser_erros . '</th>';
						}
						if ($recs_osc_err) {
							echo '<th style="background-color:#a00">' . k_endo_errors . '</th>';
						}
						echo '</tr><tr>';
						if ($recs_cln_err) {
							echo '<td valign="top"><div class="ta_n">' . $recs_cln_err . '</div></td>';
						}
						if ($recs_xry_err) {
							echo '<td valign="top"><div class="ta_n">' . $recs_xry_err . '</div></td>';
						}
						if ($recs_bty_err) {
							echo '<td valign="top"><div class="ta_n">' . $recs_bty_err . '</div></td>';
						}
						if ($recs_lsr_err) {
							echo '<td valign="top"><div class="ta_n">' . $recs_lsr_err . '</div></td>';
						}
						if ($recs_osc_err) {
							echo '<td valign="top"><div class="ta_n">' . $recs_osc_err . '</div></td>';
						}
						echo '<tr>
				</table>';
					}
					echo '<div class="lh50">&nbsp;</div>';
				}
				if ($type == 7) {
					$chr_data = array();
					$sql = "select * from $table where d_start>'$d_s' and d_start<='$d_e' ";
					$res = mysql_q($sql);
					$rows = mysql_n($res);
					$s1 = $s2 = $s3 = 0;
					if ($rows > 0) {
						while ($r = mysql_f($res)) {
							$v_id = $r['id'];
							$senc = $r['senc'];
							$t_servs = $r['t_servs'];
							$t_payments = $r['t_payments'];
							$t_insur = $r['t_insur'];
							$t_dis = $r['t_dis'];
							$t_balans = $r['t_balans'];

							$total_pay = get_sum($table2, 'total_pay', " visit_id='$v_id' and status !=3");
							$pay_net = get_sum($table2, 'pay_net', " visit_id='$v_id' and status !=3");
							$t_servs_n = intval($total_pay);
							$t_payments_n = getVisCashBal(2, $v_id);
							$t_insur_n = $total_pay - $pay_net;
							$t_balans_n = $pay_net - $t_payments_n;


							if ($senc != 0 && $t_servs == $t_servs_n && $t_payments == $t_payments_n && $t_insur == $t_insur_n && $t_balans == $t_balans_n) {
								$s2++;
							} else {
								//echo '('.$t_servs.'='.$t_servs_n.'&&'.$t_payments.'='.$t_payments_n.'&&'.$t_insur.'='.$t_insur_n.'&&'. $t_balans.'='.$t_balans_n.')<br>';
								mysql_q("UPDATE $table SET senc=1 , t_servs='$t_servs_n' , t_payments='$t_payments_n' , t_insur='$t_insur_n' , t_dis='$t_dis' , t_balans='$t_balans_n' where id='$v_id' ");
								if ($senc == 1) {
									$s3++;
								}
							}
							if ($senc == 0) {
								$s1++;
							}
						}
					}
					if ($rows) {
						$out .= '<div class="f1">
				<span class="fs14">' . date('Y-m-d', $act) . '=> </span> ';
						$out .= '<span class="f1" >العدد الكلي <ff class="fs14">( ' . $rows . ' ) </ff></span>';
						if ($s1) {
							$out .= '<span class="f1" style="color:' . $secStatusCol[1] . '"> ' . k_synced . ' <ff class="fs14">( ' . $s1 . ' ) </ff></span>';
						}
						if ($s2) {
							$out .= '<span class="f1" style="color:' . $secStatusCol[2] . '">' . k_match . '<ff class="fs14">( ' . $s2 . ' ) </ff></span>';
						}
						if ($s3) {
							$out .= '<span class="f1" style="color:' . $secStatusCol[3] . '">' . k_not_match . '<ff class="fs14">( ' . $s3 . ' )</ff> </span>';
						}
						$out .= '</div>';
					} else {
						$out .= '<div class="f1">
				<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
				<span class="f1" style="color:' . $secStatusCol[0] . '">' . k_no_anal . '</span>  
				</div>';
					}
				}
				if ($type == 8) {
					$recArr = array();
					foreach ($visXTables as $tab) {
						if ($tab) {
							$sql = "select * from $tab  where d_start>='$d_s' and d_start < '$d_e' and status>0 ";
							$res = mysql_q($sql);
							while ($r = mysql_f($res)) {
								$reg_user = $r['reg_user'];
								$t = $r['pay_type'];
								$stat = $r['status'];
								$recArr[$reg_user]['vis_total']++;
								if ($t) {
									$recArr[$reg_user]['vis_def']++;
								} else {
									$recArr[$reg_user]['vis_cash']++;
								}
								if ($stat == 3) {
									$recArr[$reg_user]['vis_cancel']++;
								} else {
									$recArr[$reg_user]['vis_act']++;
									$recArr[$reg_user]['bal']++;
								}
							}
						}
					}

					$sql = "select * from dts_x_dates  where date>='$d_s' and date < '$d_e' and status>0 ";
					$res = mysql_q($sql);
					while ($r = mysql_f($res)) {
						$reg_user = $r['reg_user'];
						$stat = $r['status'];
						$recArr[$reg_user]['dts_total']++;
						if (in_array($stat, array(5, 7))) {
							$recArr[$reg_user]['dts_cancel']++;
						} else {
							$recArr[$reg_user]['dts_act']++;
							$recArr[$reg_user]['bal']++;
						}
						if (in_array($stat, array(2, 3, 4))) {
							$recArr[$reg_user]['dts_ok']++;
							$recArr[$reg_user]['dts_do']++;
						}
						if (in_array($stat, array(8))) {
							$recArr[$reg_user]['dts_delay']++;
							$recArr[$reg_user]['dts_do']++;
						}
						if (in_array($stat, array(6))) {
							$recArr[$reg_user]['dts_do_not']++;
						}
					}

					/******************************/
					$d_total = count($recArr);
					$addTxt1 = '';
					if ($d_total) {
						$addTxt1 = '<span class="ff B">( ' . $d_total . ' )</ff> ';
					}
					$x = 0;
					foreach ($recArr as $k => $d) {
						$rec_id = $k;
						$vis_cash = $d['vis_cash'];
						$vis_def = $d['vis_def'];
						$vis_cancel = $d['vis_cancel'];
						$vis_total = $d['vis_total'];
						$vis_act = $d['vis_act'];
						$dts_total = $d['dts_total'];
						$dts_cancel = $d['dts_cancel'];
						$dts_act = $d['dts_act'];
						$dts_ok = $d['dts_ok'];
						$dts_delay = $d['dts_delay'];
						$dts_do = $d['dts_do'];
						$dts_do_not = $d['dts_do_not'];
						$bal = $d['bal'];

						if (!$vis_cash) {
							$vis_cash = 0;
						}
						if (!$vis_def) {
							$vis_def = 0;
						}
						if (!$vis_cancel) {
							$vis_cancel = 0;
						}
						if (!$vis_total) {
							$vis_total = 0;
						}
						if (!$vis_act) {
							$vis_act = 0;
						}
						if (!$dts_total) {
							$dts_total = 0;
						}
						if (!$dts_cancel) {
							$dts_cancel = 0;
						}
						if (!$dts_act) {
							$dts_act = 0;
						}
						if (!$dts_ok) {
							$dts_ok = 0;
						}
						if (!$dts_delay) {
							$dts_delay = 0;
						}
						if (!$dts_do) {
							$dts_do = 0;
						}
						if (!$dts_do_not) {
							$dts_do_not = 0;
						}
						if (!$bal) {
							$bal = 0;
						}

						$rec = getRecCon($table, " `date`='$act' and `rec`='$k' ");
						if ($vis_total || $dts_total) {
							if ($rec['r']) {
								$status = 3;
								/*if($vis_cash!=$rec['vis_cash']){echo ' 1';}
						if($vis_def!=$rec['vis_def']){echo ' 2';}
						if($vis_cancel!=$rec['vis_cancel']){echo ' 3';}
						if($vis_total!=$rec['vis_total']){echo ' 4';}
						if($vis_act!=$rec['vis_act']){echo ' 5';}
						if($dts_total!=$rec['dts_total']){echo ' 6';}
						if($dts_cancel!=$rec['dts_cancel']){echo ' 7';}
						if($dts_act!=$rec['dts_act']){echo ' 8';}
						if($dts_ok!=$rec['dts_ok']){echo ' 9';}
						if($dts_delay!=$rec['dts_delay']){echo ' 10';}
						if($dts_do!=$rec['dts_do']){echo ' 11';}
						if($dts_do_not!=$rec['dts_do_not']){echo ' 12';}
						if($bal!=$rec['bal']){echo ' 13';}*/
								if (
									$vis_cash == $rec['vis_cash'] &&
									$vis_def == $rec['vis_def'] &&
									$vis_cancel == $rec['vis_cancel'] &&
									$vis_total == $rec['vis_total'] &&
									$vis_act == $rec['vis_act'] &&
									$dts_total == $rec['dts_total'] &&
									$dts_cancel == $rec['dts_cancel'] &&
									$dts_act == $rec['dts_act'] &&
									$dts_ok == $rec['dts_ok'] &&
									$dts_delay == $rec['dts_delay'] &&
									$dts_do == $rec['dts_do'] &&
									$dts_do_not == $rec['dts_do_not'] &&
									$bal == $rec['bal']
								) {
									$status = 2;
								} else {
									$sql = "UPDATE $table SET `date`='$act',
							`rec`='$rec_id',
							`vis_cash`='$vis_cash',
							`vis_def`='$vis_def',
							`vis_cancel`='$vis_cancel',
							`vis_total`='$vis_total',
							`vis_act`='$vis_act',
							`dts_total`='$dts_total',
							`dts_cancel`='$dts_cancel',
							`dts_act`='$dts_act',
							`dts_ok`='$dts_ok',
							`dts_delay`='$dts_delay',
							`dts_do`='$dts_do',
							`dts_do_not`='$dts_do_not',
							`bal`='$bal'
							where `date` ='$act' and `rec`='$rec_id' ";
									if (mysql_q($sql)) {
										$x++;
									}
								}
							} else {
								$status = 1;
								$sql = "INSERT INTO $table (`date`,`rec`,`vis_cash`,`vis_def`,`vis_cancel`,`vis_total`,`vis_act`,`dts_total`,`dts_cancel`,`dts_act`,`dts_ok`,`dts_delay`,`dts_do`,`dts_do_not`,`bal`)values	('$act','$rec_id','$vis_cash','$vis_def','$vis_cancel','$vis_total','$vis_act','$dts_total','$dts_cancel','$dts_act','$dts_ok','$dts_delay','$dts_do','$dts_do_not','$bal')";
								mysql_q($sql);
							}
						} else {
							if ($rec['r']) {
								mysql_q("DELETE from $table where date ='$act' and rec='$rec_id' ");
							}
						}
					}
					if ($x > 0) {
						$status = 3;
						$addTxt1 .= '<span class=" clr5 ff B">[ x' . $x . ' ]</ff>';
					}
					$out .= '<div style="color:' . $secStatusCol[$status] . '">
			<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
			<span class="lh20 f1" >' . $secStatus[$status] . ' ' . $addTxt1 . '</span>
			</div>';
				}
				if ($type == 9) {
					$docClnicType = array();
					$doc_data = array();
					$q = " and  d_start>='$d_s' and d_start < '$d_e' ";
					$q2 = " and  date_e>='$d_s' and date_e < '$d_e' ";
					$sql = "select id,subgrp from _users where grp_code IN('fk590v9lvl')";
					$res = mysql_q($sql);
					while ($r = mysql_f($res)) {
						$doc_id = $r['id'];
						$doc_data[$doc_id]['clinic'] = $r['subgrp'];
						$doc_data[$doc_id]['vis'] = getTotalCO($table2, "status=2 and doctor='$doc_id' $q");
						$doc_data[$doc_id]['new_pat'] = getTotalCO($table2, "status=2 and  doctor='$doc_id' and new_pat='1' $q ");
						$doc_data[$doc_id]['emplo'] = getTotalCO($table2, "status=2 and  doctor='$doc_id' and emplo='1' $q ");
						$doc_data[$doc_id]['vis_session'] = getTotalCO($table2, "status=2 and  doctor='$doc_id' and type='1' $q ");
						$doc_data[$doc_id]['vis_consul'] = getTotalCO($table2, "status=2 and  doctor='$doc_id' and type='2' $q ");

						$doc_data[$doc_id]['service'] = getTotalCO('den_x_visits_services', "status=1 and doc='$doc_id' $q ");
						$doc_data[$doc_id]['levels'] = getTotalCO('den_x_visits_services_levels', "status=2 and doc='$doc_id' $q2 ");
						$doc_data[$doc_id]['levels_values'] = get_sum('den_x_visits_services_levels', 'price', "status=2 and doc='$doc_id' $q2 ");
						$doc_data[$doc_id]['doc_part'] = get_sum('den_x_visits_services_levels', 'doc_part', "status=2 and doc='$doc_id' $q2 ");
						//	mysql_q("DELETE from $table where date ='$act' and doctor='$doc_id' ");	
					}
					/******************************/
					$d_total = 0;
					$addTxt1 = '';

					$x = 0;
					foreach ($doc_data as $k => $d) {
						$d_id = $k;
						$vis = $d['vis'];
						$new_pat = $d['new_pat'];
						$emplo = $d['emplo'];
						$vis_session = $d['vis_session'];
						$vis_consul = $d['vis_consul'];
						$service = $d['service'];
						$levels = $d['levels'];
						$levels_values = $d['levels_values'];
						$doc_part = $d['doc_part'];
						$clinic = $d['clinic'];
						$rec = getRecCon($table, " date='$act' and doc='$d_id' ");
						if ($vis || $service || $levels) {
							$d_total++;
							if ($rec['r']) {
								if (!$vis) {
									$vis = 0;
								}
								if (!$new_pat) {
									$new_pat = 0;
								}
								if (!$emplo) {
									$emplo = 0;
								}
								if (!$vis_session) {
									$vis_session = 0;
								}
								if (!$vis_consul) {
									$vis_consul = 0;
								}
								if (!$service) {
									$service = 0;
								}
								if (!$levels) {
									$levels = 0;
								}
								if (!$levels_values) {
									$levels_values = 0;
								}
								if (!$doc_part) {
									$doc_part = 0;
								}
								$status = 3;
								/*if($hos_p!=$rec['hos_p']){echo ' 1';}
						if($doc_p!=$rec['doc_p']){echo ' 2';}
						if($cost!=$rec['cost']){echo ' 3';}*/
								if (
									$vis == $rec['vis'] &&
									$new_pat == $rec['new_pat'] &&
									$emplo == $rec['emplo'] &&
									$vis_session == $rec['vis_session'] &&
									$clinic == $rec['clinic'] &&
									$vis_consul == $rec['vis_consul'] &&
									$service == $rec['service'] &&
									$levels == $rec['levels'] &&
									$levels_values == $rec['levels_values'] &&
									$doc_part == $rec['doc_part']
								) {
									$status = 2;
								} else {
									$sql = "UPDATE $table SET 							
							vis='$vis' ,													
							vis_session='$vis_session',
							vis_consul='$vis_consul',
							service='$service',
							levels='$levels',
							levels_values='$levels_values',
							doc_part='$doc_part',
							emplo='$emplo',
							new_pat='$new_pat',							
							clinic='$clinic'							
							where date ='$act' and doc='$d_id' ";
									if (mysql_q($sql)) {
										$x++;
									}
								}
							} else {
								$status = 1;
								$sql = "INSERT INTO $table (date,doc,vis, vis_session ,vis_consul ,service ,levels ,levels_values ,doc_part ,emplo ,new_pat ,clinic)values('$act','$d_id','$vis', '$vis_session' ,'$vis_consul' ,'$service' ,'$levels' ,'$levels_values' ,'$doc_part' ,'$emplo' ,'$new_pat' ,'$clinic')";
								mysql_q($sql);
							}
						} else {
							if ($rec['r']) {
								mysql_q("DELETE from $table where date ='$act' and doc='$d_id' ");
							}
						}
					}
					if ($d_total) {
						$addTxt1 = '<span class="ff B">( ' . $d_total . ' )</ff> ';
					}
					if ($x > 0) {
						$status = 3;
						$addTxt1 .= '<span class=" clr5 ff B">[ x' . $x . ' ]</ff>';
					}
					$out .= '<div style="color:' . $secStatusCol[$status] . '">
			<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
			<span class="lh20 f1" > ' . $secStatus[$status] . ' ' . $addTxt1 . '</span>
			</div>';
				}
				if ($type == 10) {
					sencDocWorkDoo($act);
				}
				if ($type == 'x') {
					$dayData = presc_data_sync($d_s, $d_e);
					//print_r($dayData);
					$status = 0;
					$statusTxt = $secStatus[$status];
					if (!empty($dayData)) {
						$sql = "INSERT INTO `phr_m_presc_sync`(`drug`,`prescribed_quant`, `exchanged_quant`, `not_exchanged_quant`, `not_exist_quant`,`date`,`price`,`altrs`) VALUES ";
						$values = '';
						foreach ($dayData as $drug => $dataDrug) {
							$presc_quant = $dataDrug['presc_co'];
							$exchanged_quant = $dataDrug['exchange_co']['v'];
							$notExchanged_quant = $dataDrug['not_exchange_co']['v'];
							$notExist_quant = $dataDrug['notExist_co']['v'];
							$altrs = $dataDrug['altrs'];
							$price = $dataDrug['price'];
							if ($values != '') {
								$values .= ',';
							}
							$values .= "('$drug','$presc_quant','$exchanged_quant','$notExchanged_quant','$notExist_quant','$d_s','$price','$altrs')";
						}
						if ($values != '') {
							$sql .= $values;
							if (mysql_q("delete from phr_m_presc_sync where date>='$d_s' and date<='$d_e'")) {
								if (mysql_q($sql)) {
									$status = 1;
									$statusTxt = $secStatus[$status];
								} else {
									$status = 3;
									$statusTxt = k_sync_error_occured;
								}
							} else {
								$status = 3;
								$statusTxt = k_sync_error_occured;
							}
						}
					}
					//				print_r($secStatusCol);
					//				print_r($secStatus);
					$out = '<div style="color:' . $secStatusCol[$status] . '">
				<span class="fs14">' . date('Y-m-d', $act) . '</span> =>
				<span class="lh20 f1" > ' . $statusTxt . '</span>
				</div>';
				}
				?>
		<div class=" font10"><?= $out ?></div>^<?
												if ($tatalDays == $tatalDaysDone) {
													echo '0^<div class="f1 fs16 clr5 lh40">' . k_synced . '  <span onclick="resetSnc(' . $type . ')" class="f1 fs16 clr1 Over">رجوع</span></div>
			<div class="cb"></div>';
												} else {
													echo $act = $act + 86400;
												}
											}
										} ?>