<? include("../header.php");
if (isset($_POST['vis'], $_POST['t'])) {
	$id = pp($_POST['vis']);
	$t = pp($_POST['t']);
	$code = $mp_codes[$t];
	$r2 = getRecCon('cln_m_addons', " code='$code' and act=1");
	$r = getRec('cln_x_visits', $id);
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
			<div class="mp_list_tit_txt" style="background-image:url(../images/add/<?= $iconT ?>.png);"><?= $name ?></div>
			<? if ($visStatus == 1 || _set_whx91aq4mx) { ?>
				<div class=""><input type="text" placeholder="<?= k_search ?>" id="pm_src" /></div>
			<? } ?>
		</div>
		<? if ($visStatus == 1 || _set_whx91aq4mx) { ?>
			<div class="fl w100 lh40 cbg444 b_bord f1" id="mp_ItTot"></div>
			<div class="fl ofx so pd10f prvTpmlist" id="mp_ItData" fix="hp:115|wp:0"></div><?
																						} else {
																							echo '<div class="f1 fs14 clr5 lh40 pd10f ">' . k_visit_ended . '</div>';
																						}
																					}
																				} ?>