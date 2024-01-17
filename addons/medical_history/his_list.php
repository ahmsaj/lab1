<? include("../header.php");
if (isset($_POST['vis'], $_POST['pat'])) {
	$id = pp($_POST['vis']);
	$pat = pp($_POST['pat']);
	$r2 = getRecCon('cln_m_addons', " code='dd1q42qqvk' and act=1");
	$r = getRecCon('cln_x_visits', " id='$id' and patient='$pat'");
	if ($r['r'] && $r2['r']) {
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
				<div><input type="text" placeholder="<? k_search ?>" id="his_src" /></div>
			<? } ?>
		</div>
		<? if ($visStatus == 1 || _set_whx91aq4mx) { ?>
			<div class="fl w100 cbg444 b_bord f1"><?
													$options = '';
													$sql = "select * from  cln_m_medical_his_cats order by ord ASC";
													$res = mysql_q($sql);
													$rows = mysql_n($res);
													if ($rows > 0) {
														while ($r = mysql_f($res)) {
															$id = $r['id'];
															$catname = $r['name_' . $lg];
															$options .= '<option  value="' . $id . '">' . $catname . '</option>';
														}
													} ?>
				<select class="cbg666" id="addCat" t>
					<option value="0"><?= k_all_cats ?></option><?= $options ?>
				</select>
			</div>

			<div class="fl w100 lh40 cbg444 b_bord f1" id="his_ItTot"></div>
			<div class="fl ofx so pd10f prvHislist" id="his_ItData" fix="hp:162|wp:0"></div><?
																						} else {
																							echo '<div class="f1 fs14 clr5 lh40 pd10f ">' . k_visit_ended . '</div>';
																						}
																					}
																				} ?>