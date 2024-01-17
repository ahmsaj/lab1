<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['sta'])){
	$id=pp($_POST['id']);
	$sta=pp($_POST['sta']);
	$ch='';
	if($id){
		$rec=getRec('cln_x_medical_his',$id);
		$rec_s_date=$rec['s_date'];
		$rec_e_date=$rec['e_date'];
		$rec_num=$rec['num'];
		$rec_active=$rec['active'];
		$rec_note=$rec['note'];
		if($rec_active){
			$ch=' checked ';
		}
	}
	$r=getRec('cln_m_medical_his',$sta);
	if($r['r']){
		$name=$r['name_'.$lg];
		$cat=$r['cat'];
		$r2=getRec('cln_m_medical_his_cats',$cat);
		$s_date=$r2['s_date'];
		$e_date=$r2['e_date'];
		$num=$r2['num'];
		$active=$r2['active'];
		?>
		<form name="madHis" id="madHis" action="<?=$f_path?>X/cln_preview_madhis_save.php" method="post"  cb="alert([id]);" bv="">
		<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs18"><?=$name?></div>
			<div class="form_body so">	       
			    <input type="hidden" name="id" value="<?=$id?>">
				<input type="hidden" name="sta" value="<?=$sta?>">
				<table class="fTable" cellpadding="0" cellspacing="0" border="0">
				<? if($s_date){?>
				<tr><td n><?=k_starting_date?>: </td><td i><input name="s_date" value="<?=$rec_s_date?>" type="text" class="Date"></td></tr>
				<? }?>
				<? if($e_date){?>
				<tr><td n><?=k_ending_date?>: </td><td i><input name="e_date" value="<?=$rec_e_date?>" type="text"  class="Date"></td></tr>
				<? }?>
				<? if($num){?>
				<tr><td n><?=k_num_of_tim?> : </td><td i><input name="num" value="<?=$rec_num?>" type="number"></td></tr>
				<? }?>
				<tr><td n><?=k_details?> : </td><td i><textarea name="note"><?=$rec_note?></textarea></td></tr>
				<? if($active){?>
				<tr><td n><?=k_status_act?> : </td><td i><input name="act" value="1" <?=$ch?> type="checkbox"></td></tr>
				<? }?>
				</table>         
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
				<div class="bu bu_t3 fl" onclick="sub('madHis');"><?=k_save?></div>
			</div>
		</div>
		</form><?
	}
}?>