<? include("../../__sys/mods/protected.php");?>
<header>
	<div class="top_txt_sec fl">
		<div class="top_title fl f1"><?=$def_title?></div> 
	</div>
	<div class="top_icons fr"><? 
		echo topIconCus(k_search,'ti_search_o fr','Open_co_filter(0)');		
		echo topIconCus(k_dlv_tdy,'cbg6 labStatus top_OverX fr','','id="lr1"');
		echo topIconCus(k_rdy,'cbg66 labStatus top_OverX fr','','id="lr2"');?>
	</div>
</header>
<div class="centerSideIn so"></div><?
$customFiltter='
1:'.k_visit_num.':v1|
1:'.k_pat_num.':p1|
1:'.k_patient_name.':p2|
1:'.k_l_name.':p4|
1:'.k_fth_name.':p3|
4:'.k_sex.':p5:1-'.k_male.'^2-'.k_female.'|';
//6:'.k_urgent.':p6|
//5:'.k_bokng.':d1|
//';
$customPageFiltter='lab_results_delivery';
?>
<script>
sezPage='l_Resp';
$(document).ready(function(e){
	Open_co_filter(1); 
	loadFitterCostom('<?=$customPageFiltter?>');
	l_res_ref(1);
	refPage(12,5000);
});
</script>