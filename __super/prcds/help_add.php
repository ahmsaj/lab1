<? include("../../__sys/prcds/ajax_header.php");
$index=getTotalCO('_help',"type=0");?>
<div class="win_body">
<div class="form_header f1 fs18 lh40"><?=k_choose_mod_type?></div>
	<div class="form_body so">
		<? if($index==0){echo '<div class="bu bu_t3" onclick="hlpSelMod(0)">'.k_home_page.'</div>';}?>
		<div class="bu bu_t1" onclick="hlpSelMod(1)"><?=k_bmod?></div>
		<div class="bu bu_t1" onclick="hlpSelMod(2)"><?=k_amod?></div>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
	</div>
</div>