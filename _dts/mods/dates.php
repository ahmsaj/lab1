<? include("../../__sys/mods/protected.php"); ?>
<?= header_sec($def_title, "ser|action:" . k_refresh . ":ti_ref:loadFitterCostom('dts_arc')"); ?>
<div class="centerSideIn so"></div><?
									if (!in_array($thisGrp, array('7htoys03le', 'nlh8spit9q', 'fk590v9lvl', '1ceddvqi3g', '9yjlzayzp', '66hd2fomwt'))) {
										$doc_q = '3:' . k_doctor . ':p9:_users^id^name_' . $lg . '^ where grp_code in(\'7htoys03le\',\'nlh8spit9q\',\'9yjlzayzp\',\'66hd2fomwt\',\'1ceddvqi3g\',\'fk590v9lvl\') and act=1 | ';
									}
									$customFiltter = '
1:' . k_num_of_appointment
										. '  :p1|
1:' . k_pat_num
										. '  :p2|
1:' . k_name . ':p3|
1:' . k_l_name . ':p4|
1:' . k_fth_name . ':p5|
3:' . k_reception . ':p55:_users^id^name_' . $lg . '^ where grp_code="pfx33zco65" and act=1 |
5:' . k_the_date . ':p6:|
3:' . k_tclinic . ':p8:gnr_m_clinics^id^name_' . $lg . '^ where type not in(2) and act=1 |
1:' . k_doctor . ':p9|
4:' . k_status . ':p7:' . getModParAsList('fxl1xwgoha') . '|
6:' . k_from_the_app . ' :p66:|
6: ' . k_backup . ':p77:|
';
									$customPageFiltter = 'dts_arc';

									?>
<script>
	$(document).ready(function(e) {
		Open_co_filter(1);
		loadFitterCostom('<?= $customPageFiltter ?>');
	});
</script>