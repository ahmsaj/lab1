<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_x_visits',$id);
	if($r['r']){
		$pay_type=$r['pay_type'];
		$patient=$r['patient'];
		if($pay_type==0){
			?>
			<div class="win_body">			
			<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($patient)?></div>
			<div class="form_body so">
				<div class="f1 fs16 clr5 lh30"><?=k_visit_ret_to_samples?></div>
				<form name="labsrv" id="labsrv" action="<?=$f_path?>X/lab_visit_srv_save.php" method="post" cb="win('close','#m_info2');" bv="">
				<input type="hidden" value="<?=$id?>" name="vis"/>
				<table class="fTable" cellpadding="0" cellspacing="0" border="0"><?
					$cData=getColumesData('kyanxtrckr',1,0,'1=1'); 					
					echo co_getFormInput(0,$cData['252idghz1q']);
					echo co_getFormInput(0,$cData['eoel8yrbpz']);?>
				</table>
			</form>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t3 fl" onclick="sub('labsrv');"><?=k_add?></div>
				<div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>
			</div>
			</div><?
		}
	}
}?>