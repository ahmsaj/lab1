<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fix'])){
	$id=pp($_POST['fix']);
	$paymentDate=latePay($id);
	if($paymentDate==0){
		$sql="select date from gnr_x_acc_payments where casher='$id' order by date ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$date=$r['date'];
			$paymentDate=$date-($date%86400);
		}		
	}
	
	if($paymentDate){		
		while($paymentDate<$ss_day){
			if(isset($_POST['p_'.$paymentDate])){
				$date2=$paymentDate;
				$val=pp($_POST['p_'.$paymentDate]);
				$ch=pp($_POST['ch_'.$paymentDate]);
				if($ch){
					mysql_q("INSERT INTO gnr_x_box_take(`amount`,`box`,`date`,`m_box`)values('$val','$id','$date2','$thisUser')");					
					fixCasherBalans($id);
				}
			}
			$paymentDate=$paymentDate+86400;
		}
		echo 1;
	}
}else{
if(isset($_POST['id'])){
	?><div class="win_body"><?
	$id=pp($_POST['id']);?>
    <div class="form_header f1 fs16 lh40"><?=get_val('_users','name_'.$lg,$id)?></div>
    <div class="form_body so" type="full_pd0"><?
		$paymentDate=latePay($id);
		if($paymentDate==0){
			$sql="select date from gnr_x_acc_payments where casher='$id' order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$r=mysql_f($res);
				$date=$r['date'];
				$paymentDate=$date-($date%86400);
			}		
		}		
		if($paymentDate){
		echo '<form name="for_box" id="for_box" action="'.$f_path.'X/gnr_acc_box_fix.php" method="post" cb="boReload();" bv="">
		<input type="hidden" name="fix" value="'.$id.'"/>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
		<tr><th>#</th><th>'.k_date.'</th><th>'.k_box.'</th><th>'.k_previous_withdrawals.'</th><th>'.k_balance.'</th></tr>';
		$alll=0;
		$all_pay=0;
		$all_bal=0;
		while($paymentDate<$ss_day){
			$d_e=$paymentDate+86400;
			$in=get_sum('gnr_x_acc_payments','amount'," casher='$id' and type IN(1,2,5,6,7,10) and date>='$paymentDate' and date < '$d_e'");
            $out=get_sum('gnr_x_acc_payments','amount'," casher='$id' and type IN(3,4,8) and date>='$paymentDate' and date < '$d_e'");
			$d_e2=date('Y-m-d',$d_e);
	
			$paymentDate2=date('Y-m-d',$paymentDate);
			$pay=get_sum('gnr_x_box_take','amount'," box='$id'  and date>='$paymentDate' and date < '$d_e' ");
			$all=$in-$out;			
			if($all-$pay){
				echo '<tr>
				<td><input type="checkbox" name="ch_'.$paymentDate.'" value="1" checked  /></td>
				<td><ff>'.date('Y-m-d',$paymentDate).'</ff></td>
				<td><ff>'.number_format($all).'</ff></td>
				<td><ff>'.number_format($pay).'</ff></td>
				<td><input type="number" name="p_'.$paymentDate.'" onkeyup="calboxTotal()"  value="'.($all-$pay).'" class="TC fs18 boxtt" style="width:80px;"/></td>
				</tr>';
				$alll+=$all;
				$all_pay+=$pay;
				$all_bal+=$all-$pay;
			}
			$paymentDate=$paymentDate+86400;
		}
		echo '<tr bgcolor="#eeeeee"><td class="f1 fs14" colspan="2">'.k_total.'</td>
		<td><ff>'.number_format($alll).'</ff></td>
		<td>'.number_format($all_pay).'</td>
		<td id="boxttt">'.number_format($all_bal).'</td></tr>';
		echo '</table></form>';
	}?>
    </div>
    <div class="form_fot fr" >
    	<div class="bu bu_t3 fl" onclick="sub('for_box')"><?=k_save?></div>
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');" ><?=k_close?></div>
    </div><?
	?></div><?
}
}?>
