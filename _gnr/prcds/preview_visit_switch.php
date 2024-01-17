<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$vis=$_POST['vis'];?>
	<div class="win_body">	
	<div class="form_body of" type="full_pd0"><?
	$clinic=$userSubType;
	$mood=get_val_con('gnr_m_clinics','type',"id IN($clinic)");
	$fix='class="fl pd10" fix="hp:0"';
	if(chProUsed('dts')){$fix='class="fl r_bord pd10" fix="wp%:50|hp:0"';}?>
	<div <?=$fix?>>
		<div class="lh50 f1 fs18 clr1 uLine TC"><?=k_waiting?></div>
		<div class="ofx so" fix="hp:70"><?=clinicOpr_waiting($mood,$vis);?></div>
	</div><? 
	if(chProUsed('dts')){?>
		<div class="fl pd10" fix="wp%:50|hp:0">
			<div class="lh50 f1 fs18 clr1 uLine TC"><?=k_appointments?></div>
			<div class="ofx so" fix="hp:70"><?=clinicOpr_DTS($mood,$vis);?></div>
		</div><? 
	}
?>
</div>
<div class="form_fot fr">
<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
</div>
</div>
<?
}?>