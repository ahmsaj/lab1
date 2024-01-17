<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){	
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$d=pp($_POST['d'],'s');
	echo '<script>repPointer="'.$d.'";delOprType=0;</script>';
	if($t==2)echo '<div class="win_body"><div class="form_body so">';
	$doc=$thisUser;
	$sql="select * from cln_x_pro_x_operations  where id='$id' and doc='$doc'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$opration=$r['opration'];
		$hospital=$r['hospital'];
		$opr_date=$r['date'];
		$duration=$r['duration'];
		$price=$r['price'];
		$tools=$r['tools'];
		
		$duration2=$r['real_dur'];
		$price2=$r['real_price'];
		$notes=$r['notes'];
		$report=$r['report'];		
		
		if($duration2=='')$duration2=$duration;
		$opration_name=get_val('cln_m_pro_operations','name_'.$lg,$opration);
		$hospital=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital);?>               
        <table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">
            <tr><td width="150"  class="fs14 f1"><?=k_operation?>:</td><td><?=$opration_name?></td></tr>
			<tr><td class="fs14 f1"><?=k_the_hospital?>:</td><td><?=$hospital?></td></tr>
            <tr><td class="fs14 f1"><?=k_oper_dat_tim?>:</td><td><?=$opr_date?></td></tr>
            <tr><td class="fs14 f1"><?=k_oper_dur?>:</td><td><?=$duration?></td></tr>
            <tr><td class="fs14 f1"><?=k_oper_cost?>:</td><td><?=$price?></td></tr>
            <? if($tools!=''){?>
            <tr><td class="fs14 f1"><?=k_oper_tools?>:</td><td><div id="opr_tools_d"><?=getTools($tools)?></div></td></tr>
            <? }?>
        </table>
        <?
        if($t==1){$cb="getTopStatus('x',3);";}
		if($t==2){$cb="opr_list_Load();";}
		?>
		<div class="f1 winOprNote"><?=k_after_oper_report?></div>
        <form name="form_oper_<?=$id?>" id="form_oper_<?=$id?>" action="<?=$f_path?>X/cln_preview_operations_report_save.php" 
        method="post" cb="reloadRP('<?=$d?>')">
        <input type="hidden" name="id" value="<?=$id?>" />    
        <table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">
            <tr><td width="150"  class="fs14 f1"><?=k_act_oper_tim?>:</td>
            <td><input type="text" name="duration" class="DUR" value="<?=$duration2?>" /></td></tr>
			<tr><td class="fs14 f1"><?=k_dr_pays?>:</td><td><input type="text" name="price" value="<?=$price2?>" /></td></tr>            
            <tr><td class="fs14 f1"><?=k_notes?>:</td>
            <td><textarea name="report" style="height:80px;"><?=$report?></textarea></td></tr>
            <tr><td class="fs14 f1"><?=k_the_medical_report?>:</td>
            <td><textarea name="notes" style="height:150px;"><?=$notes?></textarea></td>
            </tr>
            <? if($t==1){?>
            <tr><td colspan="2" class="fs14 f1">
            	<div class="bu bu_t1 fl" onclick="save_Operation_re(<?=$id?>)" style="width:auto"><?=k_sav_oper_report?></div>
            </td></tr>
            <? }?>
        </table>
        </form><?
	}
	if($t==2){?></div>
	<div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info3')"><?=k_close?></div>
        <div class="bu bu_t1 fr" onclick="save_Operation_re(<?=$id?>)" style="width:auto"><?=k_sav_oper_report?></div>   
        <div class="bu bu_t3 fr" onclick="print_Operation_re(8,<?=$id?>)"><?=k_print?></div>        
    </div>
	</div><?
	}
}?>