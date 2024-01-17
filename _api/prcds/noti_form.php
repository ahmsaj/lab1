<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['noti'])){
	$noti=pp($_POST['noti']);	
	$r=getRec('api_noti_list',$noti);
	if($r['r']){
		$module=$r['module'];
		$no=$r['no'];
		$name=$r['name_'.$lg];
		$rec=$r['rec_'.$lg];?>
		<form name="api_data" id="api_data" action="<?=$f_path?>X/api_tes_noti.php" method="post" cb="showNotiData('[1]');" bv="a">		
			<div class="lh40 f1 fs14 b_bord"><?=k_type?> : <ff><?=$no?></ff></div>
			<div><input type="hidden" name="noti" value="<?=$noti?>"/></div>
			<div class="lh30 f1 fs14"><?=k_token?> <span class="clr5 fs18">*</span></div>
			<div><input type="text" name="token" value="<?=$_SESSION['Token']?>"/></div>
			<div class="lh40 f1 fs14"><?=$rec?></div>
			<div><input type="number" name="rec_id" value=""/></div>
			<div class="uLine lh40">&nbsp;</div>
			<div class="bu bu_t4 buu  sButt"><?=k_send?></div>
		</form><?
	}
}?>