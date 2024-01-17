<? include("../header.php");
if (isset($_POST['vis'], $_POST['t'])) {
	$id = pp($_POST['vis']);
	$t = pp($_POST['t']);
	$code = $icd_codes[$t];
	$r2 = getRecCon('cln_m_addons', " code='$code' and act=1");
	$r = getRec('cln_x_visits', $id);
	if ($r['r'] && $r2['r']) {
		$visStatus = $r['status'];
		$color = $r2['color'];
		$name = $r2['name_' . $lg];
		$icon = $r2['icon'];
		$short_code = $r2['short_code'];
		$iconT = 'def';
		if ($icon) {
			$iconT = $icon;
		}
		$pay_type = $r['pay_type'];
		$vis_status = $r['status']; ?>
		<div class="fl mp_list_tit" style="background-color:<?= $color ?>;">
			<div class="mp_list_tit_txt ff" style="background-image:url(../images/add/<?= $iconT ?>.png);"><?= $name ?></div>
			<? if ($visStatus == 1 || _set_whx91aq4mx) { ?>
				<div class=""><input type="text" placeholder="<?= k_search ?>" id="pm_src" /></div>
			<? } ?>
		</div><?
				if ($visStatus == 1 || _set_whx91aq4mx) { ?>
			<div class="fl w100  cbg444 b_bord f1"><?
													$options = '';
													// $cats=get_val('gnr_m_clinics',$icd_table_f[$t],$userSubType);			
													// if($cats){ $cats= " where id IN ($cats)";}
													$sql = "select * from $icd_table_cat[$t] $cats order by name_$lg ASC";
													$res = mysql_q($sql);
													$rows = mysql_n($res);

													if ($rows > 0) {
														while ($r = mysql_f($res)) {
															$id = $r['id'];
															$catname = $r['name_' . $lg];
															$options .= '<option  value="' . $id . '">' . $catname . '</option>';
														}
													} ?>
				<select class="cbg666" id="addCat">
					<option value="0"><?= k_all_cats ?></option><?= $options ?>
				</select>
			</div>
			<div class="fl w100 lh40 cbg444 b_bord f1" id="mp_ItTot"></div>
			<div class="fl ofx so pd10f prvTpmlist" id="mp_ItData" t="<?= $t ?>" fix="hp:162|wp:0"></div><?
																										} else {
																											echo '<div class="f1 fs14 clr5 lh40 pd10f ">' . k_visit_ended . '</div>';
																										}
																									}
																								} ?>