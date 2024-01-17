<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	$sql="select * from cln_x_pro_referral where id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$id=$r['id'];?>
        <table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4"><?		
		$type=$r['type'];
		$p_id=$r['p_id'];
		$hospital=$r['hospital'];
		$doctor=$r['doctor'];
		$opr_date=$r['opr_date'];
		$des=$r['des'];
		$opration=$r['opration'];
		$v_id=$r['v_id'];
		$date=$r['date'];
		?>
		<tr><td  width="150"  class="fs14 f1"><?=k_visit_num?>:</td><td i><?=$v_id?></td></tr>
        <tr><td class="fs14 f1"><?=k_patient?>:</td><td i><?=get_p_name($p_id)?></td></tr>
        <tr><td class="fs14 f1"><?=k_date_of_referral?>:</td><td i><?=dateToTimeS3($date,1)?></td></tr>
        <tr><td class="fs14 f1"><?=k_referral_type?>:</td><td i><?=$assi_typs_arr[$type]?></td></tr>
        <? if($hospital){?><tr>
          <td class="fs14 f1"><?=k_the_hospital?>:</td><td style="line-height:22px;">
		  <?=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital)?><br>
          <?=k_phone?>: <?=get_val('cln_m_pro_referral_hospitals','phone',$hospital)?><br>
          <?=k_address?>: <?=get_val('cln_m_pro_referral_hospitals','addres',$hospital)?>
          </td></tr><? }?>
        <? if($doctor){?>
        <tr><td class="fs14 f1"><?=k_dr?>:</td><td i><?=get_val('cln_m_pro_referral_doctors','name_'.$lg,$doctor)?></td></tr><? }?>
        <? if($opration){?>
        <tr><td class="fs14 f1">
		<?=k_operation?>:</td><td i><?=get_val('cln_m_pro_operations','name_'.$lg,$opration)?></td></tr><? }?>
        <? if($opr_date!='0000-00-00'){?>
        <tr><td class="fs14 f1"><?=k_date_of_operation?>:</td><td i><?=$opr_date?></td></tr><? }?>
        <? if($des!=''){?><tr><td class="fs14 f1"><?=k_notes?>:</td><td i><?=$des?></td></tr><? }?>
		</table><?
	}
}?>