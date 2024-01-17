<? include("../../__sys/prcds/ajax_header.php");
if($chPer[2] && isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$table=$visXTables[$t];
	$table2=$srvXTables[$t];
	if(isset($_POST['save'])){		
		$date=pp($_POST['date'],'s');
		if($date){						
			$newDate = strtotime($date.' 00:00:00');
			list($v1,$v2,$v3)=get_val($table,'d_start,d_check,d_finish',$id);
			if($v1){$v1=($v1%86400)+$newDate;}
			if($v2){$v2=($v2%86400)+$newDate;}
			if($v3){$v3=($v3%86400)+$newDate;}		
			mysql_q(" UPDATE $table set d_start='$v1' , d_check='$v2' , d_finish='$v3' where id='$id'");
			if($t==2){
				mysql_q(" UPDATE $table2 set date_enter='$v1' ,  date_reviwe='$v2' , delv_date='$v3' where visit_id='$id'");
			}else{
				mysql_q(" UPDATE $table2 set d_start='$v1' ,  d_finish='$v3' where visit_id='$id'");
			}
			if(!$v3){$v3=$v1;}
			mysql_q(" UPDATE gnr_x_insurance_rec set s_date='$v1' ,  r_date='$v3' where visit='$id' and mood='$t' ");
            mysql_q(" UPDATE gnr_x_charities_srv set date='$v1' where mood='$t' and vis='$id' ");
            mysql_q(" UPDATE gnr_x_exemption_srv set date='$v1' where mood='$t' and vis='$id' ");
			mysql_q(" UPDATE gnr_x_acc_payments set date='$v1'  where vis='$id' and mood like'$t%' ");
			echo 1;
		}
	}else{
		$date=get_val($table,'d_start',$id);
		if($date){
			?><div class="win_body">
			<div class="form_header f1 fs18 clr1 lh40"><?=k_enter_new_date?></div>
			<div class="form_body so" >
				<form name="acc_form_date" id="acc_form_date" action="<?=$f_path.'X/gnr_acc_visit_date_edit.php'?>" method="post"
				cb="showAcc(<?=$id?>,<?=$t?>)" bv="">
				<input type="hidden" name="id" value="<?=$id?>"/>
				<input type="hidden" name="t" value="<?=$t?>"/>
				<input type="hidden" name="save" value="1"/>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr>
						<td txt><?=k_tday?></td>
						<td><input type="text" class="Date" name="date" required value="<?=date('Y-m-d',$date)?>"/></td>
					</tr>				
				</table>
				<div class="f1 fs14 clr5 lh30"> <?=k_note?> : <?=k_date_edit_affetcion?></div>
				</form>
			</div>
			<div class="form_fot fr" >
				<div class="bu bu_t1 fl" onclick="sub('acc_form_date')"><?=k_save?></div>		
				<div class="bu bu_t2 fr" onclick="win('close','#m_info2');" ><?=k_close?></div>
			</div>
			</div><?
		}
	}
}?>
