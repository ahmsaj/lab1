<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['sub_id'])) {
	$id = pp($_POST['sub_id']);
	$r = getRec('den_x_tooth_status', $id);
	$tType = 1;
	if ($r['r']) {
		$s_id = $r['id'];
		$doc = $r['doc'];
		$patient = $r['patient'];
		$date = $r['date'];
		echo '<div class="f1 fs18 clr1 lh50 b_bord">' . k_teeth_status_date . ' : <ff dir="ltr">' . date('Y-m-d', $date) . '</ff></div>';
		/****************************************/
		$oprDataArr = array();
		$sql = "select * from den_m_set_teeth where act =1 order by ord ASC";
		$res = mysql_q($sql);
		$rows = mysql_n($res);
		if ($rows) {
			while ($r = mysql_f($res)) {
				$id = $r['id'];
				$oprDataArr[$id]['icon'] = $r['icon'];
				$oprDataArr[$id]['name'] = $r['name_' . $lg];
				$oprDataArr[$id]['color'] = $r['color'];
				$oprDataArr[$id]['opr_type'] = $r['opr_type'];
				$oprDataArr[$id]['opr_type'] = $r['opr_type'];
			}
		}
		$rootDataArr = array();
		$sql = "select * from den_m_set_roots where act =1 order by ord ASC";
		$res = mysql_q($sql);
		$rows = mysql_n($res);
		if ($rows) {
			while ($r = mysql_f($res)) {
				$id = $r['id'];
				$rootDataArr[$id]['icon'] = $r['icon'];
				$rootDataArr[$id]['name'] = $r['name_' . $lg];
				$rootDataArr[$id]['color'] = $r['color'];
			}
		}
		$teethStatus = array();
		$tsfc = array();
		$sql = "SELECT * FROM den_x_tooth_status_items WHERE status_id = '$s_id' ";
		$res = mysql_q($sql);
		$actA = $actC = 0;
		while ($r = mysql_f($res)) {
			$no = $r['teeth_no'];
			if ($no < 50) {
				$actA = 1;
			} else {
				$actC = 1;
			}
			$teeth_part = $r['teeth_part'];
			$opr_sub = $r['teeth_part_sub'];
			$last_opr = $r['last_opr'];
			if ($last_opr) {
				$tsfc[$teeth_part . '-' . $no][$opr_sub] = $r;
			}
			if ($teeth_part == 1) {
				$teethStatus[$no] = $r;
			} else {
				$rootStatus[$no][$opr_sub] = $r;
				$rootStatus[$no]['c'] = $r['opr_type'];
			}
		}

		$tt1 = 12.8;
		$tt2 = 12.8;
		$tt3 = 12;
		$tt4 = 12;
		$teethWidth = array(0, $tt4, $tt4, $tt3, $tt2, $tt2, $tt1, $tt1, $tt1);
		$tun = array();
		$trno = array();
		$cavsArr = array();
		$sql = "select * from den_m_teeth where type='$tType' order by no_unv";
		$res = mysql_q($sql);
		while ($r = mysql_f($res)) {
			$no = $r['no'];
			$t_type = $r['t_type'];
			$no_unv = $r['no_unv'];
			$root_no = $r['root_no'];
			$t_code = $r['code'];
			$tun[$no] = $no_unv;
			$trno[$no_unv] = $root_no;
			$cavities = $r['cavities'];
			$cavsArr[$no] = $cavities;
		}
		for ($ti = 1; $ti < 3; $ti++) {
			$tType = $ti;
			if ($tType == 1) {
				$side_s = 1;
				$side_e = 4;
				$side_n = 8;
			}
			if ($tType == 2) {
				$side_s = 5;
				$side_e = 8;
				$side_n = 5;
			}
			if (($tType == 1 && $actA) || ($tType == 2 && $actC)) {
?>
				<div class="teethCont" dir="ltr"><?
													for ($p = $side_s; $p <= $side_e; $p++) {
														$TheethNo = '';
														$TheethBoxs = '';
														$TheethRoots = '';
														$TheethPart = '<tr><td colspan="8" tpn' . $p . ' class="fs24 ff" >' . $p . '</td></tr>';
														for ($i = 1; $i <= $side_n; $i++) {
															$TheethNo .= '<td class="ff TtNO" style="padding:2px;">' . $tun[$p . $i] . '</td>';
														}
														for ($i = 1; $i <= $side_n; $i++) {
															$bg = $bg2 = $t_status = '';
															$oprType = 0;
															if ($tsfc['1-' . $p . $i]) {
																$tsArr = $tsfc['1-' . $p . $i];
																$tfStyles = '';
																foreach ($tsArr as $k => $ts) {
																	$oprType = $tsArr[$k]['opr_type'];
																	$oprType_o = $tsArr[$k]['opr'];
																	if ($oprType == 1) {
																		$bgColr = ' background-color:' . $oprDataArr[$oprType_o]['color'] . ';';
																		$t_status = $oprDataArr[$oprType_o]['name'];
																		$bg = $bgColr;
																	}
																	if ($oprType == 2) {
																		$oprSub_o = $tsArr[$k]['teeth_part_sub'];
																		if ($oprSub_o == 1 || $oprSub_o == 2) {
																			$tfStyles .= ' background-color:' . $oprDataArr[$oprType_o]['color'] . ';color:#fff;';
																		} else {
																			$borDir = selTDir($p, $i, $oprSub_o);
																			$tfStyles .= 'border-' . $borDir . '-color:' . $oprDataArr[$oprType_o]['color'] . ';';
																		}
																	}
																}
																if ($tfStyles) {
																	$bodrColr = 'style="' . $tfStyles . '"';
																}
															}
															$TheethBoxs .= '<td width="' . $teethWidth[$i] . '%" title="' . $t_status . '" tdno="' . $p . $i . '">';
															if ($oprType) {
																if ($oprType == 1) {
																	$TheethBoxs .= '
								<div class="fl w100 Over lh50" TNO="' . $p . $i . '" tBor' . $p . ' style="' . $bg . '">
									<ff class="clrw">' . $p . $i . '</ff>
								</div>
								';
																}
																if ($oprType == 2) {
																	$TheethBoxs .= '
								<div class="fl w100 Over" TNO="' . $p . $i . '" tBor' . $p . '>
									<div ' . $bodrColr . '><ff>' . $p . $i . '</ff></div>
								</div>
								';
																}
															} else {
																$TheethBoxs .= '
								<div class="fl w100 Over" TNO="' . $p . $i . '" tBor' . $p . '>
									<div><ff>' . $p . $i . '</ff></div>						
								</div>';
															}
															$TheethBoxs .= '</td>';
														}
														for ($i = 1; $i <= $side_n; $i++) {
															$roNo = $trno[$tun[$p . $i]];
															$TheethRoots .= '<td class="Troot Over" RNO="' . $p . $i . '" tdno="' . $p . $i . '">
						<div class="c_cont w100 lh50" ' . $bgColr . '>';
															if ($tsfc['2-' . $p . $i]) {
																$tsArr = $tsfc['2-' . $p . $i];
																$tfStyles = '';
																$rpc = 0;
																foreach ($tsArr as $k => $ts) {
																	$oprType = $tsArr[$k]['opr_type'];
																	$oprType_o = $tsArr[$k]['opr'];
																	$rpc = $tsArr[$k]['cav_no'];
																	$part_sub = $tsArr[$k]['teeth_part_sub'];
																	$opr = $tsArr[$k]['opr'];
																	$rName = $rootDataArr[$opr]['name'];
																	$rColor = $rootDataArr[$opr]['color'];
																	if ($oprType == 1) {
																		//$bgColr=' background-color:'.$oprDataArr[$oprType_o]['color'].';';
																		//$t_status=$oprDataArr[$oprType_o]['name'];
																		//$bg=$bgColr;
																		$rIc = 'style="background-color:' . $rColor . '" title="' . $rName . '"';
																	}
																	if ($oprType == 2) {
																		$rIc = 'style="background-color:' . $rColor . '" title="' . strtoupper($cavCodes[$part_sub]) . '-' . $rName . '"';
																	}
																	$TheethRoots .= '<div class="fl lh40" ' . $rIc . '></div>';
																}
																if ($rpc > count($tsArr)) {
																	for ($ii = count($tsArr); $ii < $rpc; $ii++) {
																		if ($oprType == 1) {
																			$TheethRoots .= '<div class="fl lh40" ' . $rIc . '></div>';
																		} else {
																			$TheethRoots .= '<div class="fl lh40"></div>';
																		}
																	}
																}
																if ($tfStyles) {
																	$bodrColr = 'style="' . $tfStyles . '"';
																}
															} else {
																for ($r = 1; $r <= $roNo; $r++) {
																	$TheethRoots .= '<div class="fl lh40"></div>';
																}
															}
															$TheethRoots .= '</div></td>';
														} ?>
						<div class="<?= $teethFl[$p] ?>" tp tp<?= $p ?>>
							<table border="0" width="100%" class="teethTable" cellpadding="4" cellspacing="0" dir="<?= $teethDir[$p] ?>"><?
																																			if (in_array($p, array(1, 2, 5, 6))) {
																																				echo '<tr>' . $TheethPart . '</tr><tr root>' . $TheethRoots . '</tr><tr box>' . $TheethBoxs . '</tr><tr>' . $TheethNo . '</tr>';
																																			} else {
																																				echo '<tr>' . $TheethNo . '</tr><tr box>' . $TheethBoxs . '</tr><tr root>' . $TheethRoots . '</tr><tr>' . $TheethPart . '</tr>';
																																			} ?>
							</table>
						</div>
					<? } ?>
				</div>
				<div class="b_bord">&nbsp;</div>
	<?
			}
		}
		/****************************************/
	}
} else if (isset($_POST['id'])) {
	$id = pp($_POST['id']); ?>
	<div class="win_body">
		<div class="winButts">
			<div class="wB_x fr" onclick="win('close','#full_win1');"></div>
		</div>
		<div class="form_header so lh40 clr1 f1 fs18">
			<div class="fr ic40 icc2 ic40_save" onclick="teethStatusSave(<?= $id ?>)" title="<?= k_teeth_status_save ?>"></div><?= get_p_name($id) ?>
		</div>
		<div class="form_body of" type="pd0">
			<div class="fl ofx so r_bord pd10 " fix="w:300|hp:0"><?
																	$sql = "select * from den_x_tooth_status where patient='$id' order by date DESC";
																	$res = mysql_q($sql);
																	$rows = mysql_n($res);
																	if ($rows > 0) {
																		echo '<div actButt="actts">';
																		while ($r = mysql_f($res)) {
																			$s_id = $r['id'];
																			$d_start = $r['date'];
																			$docName = get_val_arr('_users', 'name_' . $lg, $r['doc'], 'dl');
																			$oprsArr[$s_id] = $r;
																			echo '<div class="bu bu_t1"  onclick="showTeethStatus(' . $s_id . ')">' . $docName . ' <ff dir="ltr"> ( ' . date('Y-m-d', $d_start) . ' ) </ff></div>';
																		}
																		echo '</div>';
																	} else {
																		echo '<div class="f1 fs16 clr5 lh40">' . k_no_saved_status . '</div>';
																	}
																	?>
			</div>
			<div class="fl ofx so pd10" fix="wp:300|hp:0" id="stutusDes">
				<div class="f1 fs16 clr1 lh40"><?= _info_0ypihnca8 ?></div>
			</div>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?= k_close ?></div>
		</div>
	</div><?
		}
			?>