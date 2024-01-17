<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['fil'], $_POST['p'])) {
	$pars = explode('|', pp($_POST['fil'], 's'));
	$q = '';
	$q_p = $q_p2 = '';
	foreach ($pars as $p) {
		if ($p != '') {
			$pp = explode(':', $p);
			$cal = $pp[0];
			$val1 = $pp[1];
			$val2 = $pp[2];
			if ($cal == 'p1') {
				$q .= " AND id = '$val1' ";
			}
			if ($cal == 'p7') {
				$q .= " AND status = '$val1' ";
			}
			if ($cal == 'p8') {
				$q .= " AND clinic = '$val1' ";
			}
			if ($cal == 'p55') {
				$q .= " AND reg_user = '$val1' ";
			}
			if ($cal == 'p9') {
				$q .= " AND doctor IN(select id from _users where name_$lg LIKE '%$val1%' ) ";
			}
			if ($cal == 'p6') {
				if ($val1 && $val2) {
					$val11 = date('U', strtotime($val1));
					$val22 = date('U', strtotime($val2));
					if ($val11 <= $val22) {
						$val22 += 86400;
						$q .= " AND d_start >= '$val11' AND d_start <= '$val22' ";
					} else {
						$val11 += 86400;
						$q .= " AND d_start >= '$val22' AND d_start <= '$val11' ";
					}
				} else {
					if ($val1) {
						$val11 = date('U', strtotime($val1));
						$q .= " AND d_start >= '$val11' ";
					}
					if ($val2) {
						$val22 = date('U', strtotime($val2)) + 86400;
						$q .= " AND d_start <= '$val22' ";
					}
				}
			}
			if ($cal == 'p66') {
				if ($val1 == 1) {
					$q .= " AND app !=0 ";
				} else {
					$q .= " AND app =0 ";
				}
			}
			if ($cal == 'p77') {
				if ($val1 == 1) {
					$q .= " AND reserve !=0 ";
				} else {
					$q .= " AND reserve =0 ";
				}
			}
			if ($cal == 'p2') {
				$q_p .= " AND id = '$val1' ";
			}
			if ($cal == 'p3') {
				$q_p .= " AND f_name like '%$val1%' ";
				$q_p2 .= " AND f_name like '%$val1%' ";
			}
			if ($cal == 'p4') {
				$q_p .= " AND l_name like '%$val1%' ";
				$q_p2 .= " AND l_name like '%$val1%' ";
			}
			if ($cal == 'p5') {
				$q_p .= " AND ft_name like '%$val1%' ";
			}
		}
	}
	$doc_q = '';
	if (in_array($thisGrp, array('7htoys03le', 'nlh8spit9q', 'fk590v9lvl', '1ceddvqi3g', '9yjlzayzp', '66hd2fomwt'))) {
		$doc_q = " and doctor ='$thisUser' ";
	}
	if ($q_p) {
		$q_p = " AND (
		(patient IN(select id from gnr_m_patients where id!=0 $q_p ) and p_type=1) 
		";
		if ($q_p2) {
			$q_p .= "OR
			(patient IN(select id from dts_x_patients where id!=0 $q_p2 ) and p_type=2)";
		}
		$q_p .= " )";
	}
	$res = mysql_q("select count(*)c from dts_x_dates where status >= 0 $doc_q $q $q_p ");
	$r = mysql_f($res);
	$pagination = pagination('', '', 10, $r['c']);
	$page_view = $pagination[0];
	$q_limit = $pagination[1];
	echo ' ' . $all_rows = $pagination[2] . ' <!--***-->';
	$sql = "select * from dts_x_dates  where status >= 0 $doc_q $q $q_p order by d_start DESC $q_limit";
	$res = mysql_q($sql);
	$rows = mysql_n($res);
	if ($rows > 0) { ?>
		<table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0">
			<tr>
				<th class="fs16 f1" width="30">#</th>
				<th class="fs16 f1"><?= k_the_date ?></th>
				<th class="fs16 f1"><?= k_reception ?></th>
				<th class="fs16 f1"><?= k_patient ?></th>
				<? if ($doc_q == '') { ?><th class="fs16 f1"><?= k_doctor ?></th><? } ?>
				<th class="fs16 f1"><?= k_status ?></th>
				<th class="fs16 f1"><?= k_from_the_app ?></th>
				<th class="fs16 f1"><?= k_backup ?></th>
				<th class="fs16 f1" width="40"></th>
			</tr> <?
					while ($r = mysql_f($res)) {
						$id = $r['id'];
						$doctor = $r['doctor'];
						$patient = $r['patient'];
						$p_type = $r['p_type'];
						$clinic = $r['clinic'];
						$reg_user = $r['reg_user'];
						$d_start = $r['d_start'];
						$status = $r['status'];
						$note = $r['note'];
						$reg_user = $r['reg_user'];
						$app = $r['app'];
						if ($app > 0) {
							$app = 1;
						}
						$reserve = $r['reserve'];
						if ($reserve > 0) {
							$reserve = 1;
						}
					?><tr>
					<td>
						<ff><?= $id ?></ff>
					</td>
					<td>
						<ff class="fl_d"><?= date('Y-m-d A H:i', $d_start) ?></ff>
					</td>
					<td class="f1"><?= get_val_arr('_users', 'name_' . $lg, $reg_user, 'u') ?></td>
					<td class="f1"><?= get_p_dts_name($patient, $p_type, 1) ?></td>

					<? if ($doc_q == '') { ?><td class="f1"><?= get_val('_users', 'name_' . $lg, $doctor) . ' [ ' . get_val('gnr_m_clinics', 'name_' . $lg, $clinic) . ' ]' ?></td><? } ?>
					<td style="background-color: <?= $dateStatusInfoClr[$status] ?>">
						<div class="f1 clrb"><?= $dateStatus[$status] ?></div>
					</td>
					<td>
						<div class="act_<?= $app ?> c_cont"></div>
					</td>
					<td>
						<div class="act_<?= $reserve ?> c_cont"></div>
					</td>
					<td class="f1">
						<div class="ic40 icc1 ic40_info" onclick="dateINfo(<?= $id ?>,1)"></div>
					</td>
				</tr><?
					}
				} else {
					echo '<div class="lh40 f1 fs18 clr5">' . k_no_results . '</div>';
				}
				echo '<!--***-->' . $page_view;
			}
						?>