<? include("../../__sys/prcds/ajax_header.php");
if($chPer[2] && isset($_POST['opr'],$_POST['n'],$_POST['v'])){
	$opr=pp($_POST['opr']);
	$n=pp($_POST['n']);
	$vis=pp($_POST['v']);
	$out=0;
	if($opr==1){
		$type='date';
		$title=k_date_of_visit;
		$table='den_x_visits';		
		$old_val=get_val($table,'d_start',$n);
	}
	if($opr==2){
		$type='date';
		$title=k_proced_end_date;
		$table='den_x_visits_services';		
		$old_val=get_val($table,'d_finish',$n);
	}
	if($opr==3){
		$type='date';
		$title=k_level_end_date;
		$table='den_x_visits_services_levels';		
		$old_val=get_val($table,'date_e',$n);
	}
	if($opr==4){
		$type='doc';
		$title=k_visit_doc;
		$table='den_x_visits';		
		$old_val=get_val($table,'doctor',$n);
	}
	if($opr==5){
		$type='doc';
		$title=k_proced_doc;
		$table='den_x_visits_services';		
		$old_val=get_val($table,'doc',$n);
	}
	if($opr==6){
		$type='doc';
		$title=k_level_doc;
		$table='den_x_visits_services_levels';		
		$old_val=get_val($table,'doc',$n);
	}
	if($opr==7){
		$type='date';
		$title=k_paym_date;
		$table='gnr_x_acc_patient_payments';		
		list($old_val,$pay_id)=get_val($table,'date,payment_id',$n);
	}
	if($opr==8){
		$type='doc';
		$title=k_paym_doc;
		$table='gnr_x_acc_patient_payments';		
		$old_val=get_val($table,'doc',$n);
	}
	if($opr==9){
		$type='pay';
		$title=k_paym_partition;
		$table='gnr_x_acc_patient_payments';
		$val=pp($_POST['val']);
		$r=getRec('gnr_x_acc_patient_payments',$n);
		
	}
	
	if(isset($_POST['save'])){
		if($type=='date'){$val=pp($_POST['val'],'s');$val=strtotime($val.' 00:00:00')+($old_val%86400);}
		if($type=='doc'){$val=pp($_POST['val']);}		
		if($val){
			if($opr==1){
				mysql_q("UPDATE den_x_visits SET d_start='$val' , d_check='$val' , d_finish='$val' where id='$n' ");
				mysql_q("UPDATE den_x_visits_services SET d_start='$val' where visit_id='$n' ");
				mysql_q("UPDATE den_x_visits_services_levels SET date='$val' where vis='$n' ");
				$out=1;
			}
			if($opr==2){				
				mysql_q("UPDATE den_x_visits_services SET d_finish='$val' where id='$n' ");
				$out=1;
			}
			if($opr==3){				
				mysql_q("UPDATE den_x_visits_services_levels SET date_e='$val' where id='$n' ");
				$out=1;
			}
			if($opr==4){		
				mysql_q("UPDATE den_x_visits SET doctor='$val' where id='$n' ");
				mysql_q("UPDATE den_x_visits_services SET doc='$val' where visit_id='$n' and doc!=0 ");
				mysql_q("UPDATE den_x_visits_services_levels SET doc='$val' where vis='$n' and doc!=0 ");
				$out=1;
			}
			if($opr==5){		
				mysql_q("UPDATE den_x_visits_services SET doc='$val' where id='$n' and doc!=0 ");
				mysql_q("UPDATE den_x_visits_services_levels SET doc='$val' where x_srv='$n' and doc!=0 ");
				$out=1;
			}
			if($opr==6){
				mysql_q("UPDATE den_x_visits_services_levels SET doc='$val' where id='$n' and doc!=0 ");
				$out=1;
			}
			if($opr==7){
				mysql_q("UPDATE gnr_x_acc_patient_payments SET date='$val' where id='$n' ");
				if($pay_id){
					mysql_q("UPDATE gnr_x_acc_payments SET date='$val' where id='$pay_id' ");
				}
				$out=1;
			}
			if($opr==8){
				mysql_q("UPDATE gnr_x_acc_patient_payments SET doc='$val' where id='$n' ");
				$out=1;
			}
			if($opr==9){
				$doc=$val;
				$pay=pp($_POST['pay']);
				
				$amount=$r['amount'];
				$p_patient=$r['patient'];
				$p_type=$r['type'];
				$p_mood=$r['mood'];
				$p_sub_mood=$r['sub_mood'];				
				$p_date=$r['date'];
				$p_payment_id=$r['payment_id'];
				if($pay<$amount && $pay){
					$oldPay=$amount-$pay;
					if(mysql_q("INSERT INTO gnr_x_acc_patient_payments (`patient`,`type`,`mood`,`sub_mood`,`amount`,`date`,`payment_id`,`doc`)values
					('$p_patient','$p_type','$p_mood','$p_sub_mood','$pay','$p_date','$p_payment_id','$doc')")){
						mysql_q("UPDATE gnr_x_acc_patient_payments SET amount='$oldPay' where id='$n' ");
						$out=1;
					}
				}
			}
		}
        fixPatAccunt($p_patient);
		echo $out;
	}else{
		?><div class="win_body">
		<div class="form_header f1 fs18 clr1 lh40"><?=$title?> <ff>( <?=$n?> )</ff> </div>
		<div class="form_body so" >
			<form name="acc_form_den_fix" id="acc_form_den_fix" action="<?=$f_path.'X/gnr_acc_visit_den_opr.php'?>" method="post"
			cb="setDenVisChangeSave([1],<?=$vis?>)" bv="a">
			<input type="hidden" name="opr" value="<?=$opr?>"/>
			<input type="hidden" name="n" value="<?=$n?>"/>
			<input type="hidden" name="v" value="<?=$vis?>"/>
			<input type="hidden" name="save" value="1"/>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
				<tr><? 
				if($type=='date'){?>
					<td txt><?=k_date?> : </td>
					<td><input type="text" class="Date" name="val" required value="<?=date('Y-m-d',$old_val)?>"/></td>
				<? }
				if($type=='doc'){?>
					<td txt><?=k_doctor?> : </td>
					<td>
					<?=make_Combo_box('_users','name_'.$lg,'id'," where grp_code ='fk590v9lvl' ",'val',0,$old_val,' t ');?>
					</td>
				<? }?>				
				</tr>				
			</table><?
			if($type=='pay'){				
				if($r['r']){
					$doc=$r['doc'];
					$amount=$r['amount'];?>
					<div class="f1 fs16 lh40"><?=k_payment?>  <ff class="clr5"><?=number_format($amount)?></ff> <?=k_for_doc?>  <?=get_val('_users','name_'.$lg,$doc)?></div>
					<div class="f1 fs14 clr5 lh30"><?=k_deduct_paym_doc?></div>
					<div class="f1 fs14 clr5 lh30 uLine"><?=k_amount_shld_less_than_tot?></div>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
						
						<tr>
							<td txt><?=k_doctor?> : </td>
							<td>
							<?=make_Combo_box('_users','name_'.$lg,'id'," where grp_code ='fk590v9lvl' and id!='$doc' ",'val',1,$old_val,' t ');?>
							</td>
						</tr>
						<tr>						
							<td txt><?=k_amount?> : </td>
							<td><input type="number" name="pay" value="" max="<?=$amount?>" required/></td>
						</tr>
					</table><?
				}				
			}?>
			</form>
		</div>
		<div class="form_fot fr" >
			<div class="bu bu_t1 fl" onclick="sub('acc_form_den_fix')"><?=k_save?></div>		
			<div class="bu bu_t2 fr" onclick="win('close','#m_info2');" ><?=k_close?></div>
		</div>
		</div><?
		
	}
}?>
