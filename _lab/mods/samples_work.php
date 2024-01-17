<? include("../../__sys/mods/protected.php");?>
<script src="<?=$m_path?>library/Highcharts/highcharts.src.js"></script>
<script src="<?=$m_path?>library/Highcharts/highcharts-more.js"></script>
<? $customPageFiltter='lab_results_sample_info'; ?>
<header>
	<div class="top_txt_sec fl">
		<div class="top_title fl f1"><?=k_ent_report?></div> 
	</div>
	<div class="top_icons fr"><? 
		echo topIconCus(k_search,'ti_search_o fr','Open_co_filter(0)');
		echo topIconCus(k_refresh,'ti_ref fr','loadFitterCostom(\''.$customPageFiltter.'\')');
		echo topIconCus(k_dsprv_res,'cbg55 labStatus fr','showXRes()','id="lr1"');
		echo topIconCus(k_nw_sams,'cbg66 labStatus top_OverX fr','','id="lr2"');
		echo topIconCus(k_tst_rqrd,'cbg88 labStatus top_OverX fr','','id="lr3"');?>
	</div>
</header>
<div class="centerSideInHeader"></div>
<div class="centerSideIn so"></div><?
$customFiltter='
1:'.k_sample_no.':cn_bc|
1:'.k_analysis.':ana|
1:'.k_visit_num.':v1|
5:'.k_date.':d1:|
6:'.k_urgent.':p6|
1:'.k_pat_num.':p1|
1:'.k_patient_name.':p2|
1:'.k_l_name.':p4|
1:'.k_fth_name.':p3|
4:'.k_sex.':p5:1-'.k_male.'^2-'.k_female.'|

';

?>
<script>
sezPage='vis_l_work';
$(document).ready(function(e){
	Open_co_filter(1); 
	loadFitterCostom('<?=$customPageFiltter?>');
	$('#fil_cn_bc').focus();
	refPage(10,5000);
});
</script>