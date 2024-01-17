<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');?>

<script>
function dpSensRet(o){
	if(o==0){
		loader_msg(1,k_doc_not_avble,0);
	}else{
		loader_msg(1,k_done_successfully,1);
	}
}
function sencDP(){
	doc=$('#doc').val();
	date=$('#date').val();
	//if(doc !='' && date!=''){
		sub('dps');
	//}else{
		//nav(3,k_fields_fill);
	//}
}
</script>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so">
<?
$sel= '<select name="doc" id="doc"  ><option value="">-- '.k_doc_choos.' --</option>';
$sql="select * from _users where grp_code IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g')  order by name_$lg ";
$res=mysql_q($sql);
while($r=mysql_f($res)){
	$id=$r['id'];
	$name=$r['name_'.$lg];
	$clinic=$r['subgrp'];
	$act=$r['act'];
	$grp=$r['grp_code'];
	$cc=$ct='';
	if($act==0){$cc='clr5';$ct=k_inactive;}
	$ckinicTxt=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'ca');
	$sel.= '<option value="'.$id.'" class="'.$cc.'">'.$name.' - ('.$ckinicTxt.') '.$ct.'</option>';
}
$sel.='</select>';
?>
<form name="dps" id="dps" action="<?=$f_path?>X/gnr_doc_prof_senc.php" method="post" cb="dpSensRet([1])" bv="d">
	<div fix="w:400">
		<div class="f1 fs16 clr1 lh40"><?=k_doctor?> :</div>
		<div><?=$sel?></div>
		<div class="f1 fs16 clr1 lh40"><?=k_date?> :</div>
		<div class="uLine"><input type="text" class="Date" name="date" id="date" required/></div>
		
		<div class="fl"><div class="bu bu_t3 buu" onclick="sencDP()"><?=k_synion?></div></div>
	</div>
</form>
</div>
<script>;$(document).ready(function(e){setupForm('dps','');loadFormElements('#dps');});</script>