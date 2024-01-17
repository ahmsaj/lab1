<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['d'], $_POST['pars'], $_POST['t'])) {
	$max_list = 100;
	$q = '';
	$q2 = '';
	$f1 = $f2 = $f3 = $f4 = $f5 = '';
	$pars = pp($_POST['pars'], 's');
	$d = pp($_POST['d']);
	$type = pp($_POST['t']);
	$p = explode('|', $pars);
	foreach ($p as $p2) {
		$p3 = explode(':', $p2);
		$par = $p3[0];
		$val = addslashes($p3[1]);
		if ($par == 'p1' && $val) {
			$f1 = intval($val);
			$q .= " and id ='" . intval($val) . "%' ";
		}
		if ($par == 'p2' && $val) {
			$f2 = $val;
			$q .= " and f_name like'%$val%' ";
			$q2 .= " and f_name like'%$val%' ";
		}
		if ($par == 'p3' && $val) {
			$f3 = $val;
			$q .= " and l_name like'%$val%' ";
			$q2 .= " and l_name like'%$val%' ";
		}
		if ($par == 'p4' && $val) {
			$f4 = $val;
			$q .= " and ft_name like'%$val%' ";
		}
		if ($par == 'p5' && $val) {
			$f5 = $val;
			$val1 = $val2 = $val;
			if ($val[0] == 0) {
				$val2 = substr($val, 1);
			} else {
				$val2 = '0' . $val;
			}
			$q .= " and ( mobile like'$val1%' OR mobile like'$val2%' ) ";
			$q2 .= " and ( mobile like'$val1%' OR mobile like'$val2%' ) ";
		}
	}
	if ($q) {
		$q = " where id!=0 $q ";
	}
	if ($q2) {
		$q2 = " where id!=0 $q2 ";
	}
	$res = mysql_q("select count(*)c from gnr_m_patients $q ");
	$r = mysql_f($res);
	$all = $r['c'];
	$butTitle = k_pat_add_temprly;
	$pat_data = '';
	if ($type == 2) {
		$butTitle = k_new_patient;
		list($pat, $c_type) = get_val('dts_x_dates', 'patient,type', $d);
		list($f_name, $l_name, $mobile, $phone) = get_val('dts_x_patients', 'f_name,l_name,mobile,phone', $pat);
		$pat_data = 'f_name:' . $f_name . ',l_name:' . $l_name . ',mobile:' . $mobile . ',phone:' . $phone;
	}
	if ($q) {
		$sql = "select id,f_name,l_name,ft_name,mobile from gnr_m_patients $q order by f_name ASC , ft_name ASC , l_name ASC limit $max_list ";
		$res = mysql_q($sql);
		$rows = mysql_n($res);

		if ($all > $max_list) {
			echo '<div class="lh30 fs16 clr1 f1">' . k_patients . ' <ff>' . $rows . ' / ' . number_format($all) . '</ff></div>';
		} else {
			echo '<div class="lh30 fs16 clr1 f1">' . k_patients . ' <ff> ( ' . $rows . ' )</ff></div>';
		}


		echo '<section  w="220" m=27" c_ord class="plistD">
		<div np class="fl fs14 f1s lh40 TC"  c_ord onclick="newPaDa(' . $d . ',' . $type . ',\'' . $pat_data . '\',' . $c_type . ')">' . $butTitle . '</div>';

		if ($rows > 0) {
			while ($r = mysql_f($res)) {
				$id = $r['id'];
				$f_name = $r['f_name'];
				$l_name = $r['l_name'];
				$ft_name = $r['ft_name'];
				$mobile = $r['mobile'];
				echo '<div class="fl" c_ord pn="' . $id . '">				
					<div class="fs14x f1s of lh20 clr1111">' . hlight($f2, $f_name) . ' ' . hlight($f4, $ft_name) . ' ' . hlight($f3, $l_name) . '</div>
					<div class="fl"><ff class="fs16">' . hlight($f5, $mobile) . '</ff>&nbsp;</div>
					<div n><ff class="fr fs14 clr111">#' . hlight($f1, $id) . '</ff></div>
				</div>';
			}
		} else {
			echo '<section class="f1 fs16 clr5 lh40">' . k_no_results . '</section>';
		}
		echo '</section>';
		if ($rows < 20 && $q2 && $type == 1) {
			$sql = "select id,f_name,l_name , mobile from dts_x_patients $q2 order by f_name ASC , l_name ASC limit $max_list ";
			$res = mysql_q($sql);
			$rows = mysql_n($res);
			echo '<div class="cb lh40 f1 fs16 clr1 t_bord">' . k_temp_pats . '<ff> ( ' . $rows . ' ) </ff></div>';

			echo '<section  w="220" m=27" c_ord class="plistD">';
			if ($rows > 0) {
				while ($r = mysql_f($res)) {
					$id = $r['id'];
					$f_name = $r['f_name'];
					$l_name = $r['l_name'];

					$mobile = $r['mobile'];
					echo '<div class="fl" c_ord pn2="' . $id . '">				
						<div class="fs14x f1s of lh20 clr1111">' . hlight($f2, $f_name) . ' ' . hlight($f3, $l_name) . '</div>
						<div class="fl"><ff class="fs16">' . hlight($f5, $mobile) . '</ff>&nbsp;</div>
						<div n><ff class="fr fs14 clr111">#' . hlight($f1, $id) . '</ff></div>
					</div>';
				}
			} else {
				echo '<section class="f1 fs16 clr5">' . k_no_results . '</section>';
			}
		}
	} else {
		echo '<div class="f1 fs18 clr1 lh40"> ' . k_num_pats . ' <ff>' . number_format($all) . '</ff></div>';
		echo '<div class="f1 fs14 clr5 lh30">' . k_srch_or_add_pat . '</div>';
		echo '<div class="bu2 bu_t4 fl" onclick="newPaDa(' . $d . ',' . $type . ',\'' . $pat_data . '\',' . $c_type . ')">' . $butTitle . '</div>';
	}
}
