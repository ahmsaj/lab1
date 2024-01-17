<? include("../../__sys/mods/protected.php");?>
<script src="<?=$m_path?>library/highstock/js/highstock.js"></script> 
<script src="<?=$m_path?>library/highstock/js/modules/exporting.js"></script>
<script src="<?=$m_path?>library/highstock/js/highcharts-more.js"></script>
<header>
	<div class="top_title fl f1"><?=k_receive_samples?></div>
    <div class="fr rakIcon" onclick="enterRack()" title="<?=k_sel_rck?>"></div> 
</header>
<div class="centerSideIn of">
	<div class="fl so" id="sContent"></div>
	<div class="fr so" id="sContent2">
    <div class="f1 fs14 clr5 lh40 fr"><?=k_sel_rck_icn?></div>
    </div>
</div>
<script>
sezPage='vis_l_r';$(document).ready(function(e){r_samples_ref(1);$('#cn_bc').focus();refPage(9,5000);});
</script>