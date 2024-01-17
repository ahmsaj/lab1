<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');?>

<?
$data=array();
$sql="select * from den_x_visits where reg_user='$thisUser' and d_start > $ss_day order by d_start ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
while($r=mysql_f($res)){
	$k=$r['d_start'];
	$data[$k]['vis']=$r['id'];
	$data[$k]['type']=1;
	$data[$k]['doctor']=$r['doctor'];
	$data[$k]['patient']=$r['patient'];
	$data[$k]['clinic']=$r['clinic'];
	$data[$k]['amount']=0;
	
}

$sql="select * from gnr_x_acc_payments where mood=4 and casher='$thisUser' and date > $ss_day order by date ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
while($r=mysql_f($res)){
	$vis=$r['vis'];
	$amount=$r['amount'];
	$p_date=$r['date'];
	$p_id=$r['id'];
	$actArrK=0;
	if($vis){
		foreach($data as $k=>$v){
			if($v['vis']==$vis){
				$actArrK=$k;
			}
		}
		if($actArrK){		
			$data[$actArrK]['amount']+=$amount;
			
		}else{			
			$r2=getRec('den_x_visits',$vis);						
			$data[$p_date]['vis']=$vis;
			$data[$p_date]['type']=2;
			$data[$p_date]['doctor']=$r2['doctor'];
			$data[$p_date]['patient']=$r2['patient'];
			//$data[$p_date]['clinic']=$r['clinic'];
			$data[$p_date]['amount']=$amount;
		}
	}else{
		$r3=getRecCon('gnr_x_acc_patient_payments',"payment_id='$p_id'");
		if($r3['r']){	
			$data[$p_date]['vis']=0;
			$data[$p_date]['type']=3;
			$data[$p_date]['doctor']=$r3['doc'];
			$data[$p_date]['patient']=$r3['patient'];
			//$data[$p_date]['clinic']=$r['clinic'];
			$data[$p_date]['amount']=$amount;
		}
	}
	
}

ksort($data);
?>
<div class="centerSideInHeader lh50">
<div class="f1 fs18 lh40 clr1">
<div class="fr ic40 icc2 ic40_print" onclick="print4(5,0)"></div><?=get_val('_users','name_'.$lg,$thisUser)?> : <ff dir="ltr"> <?=date('Y-m-d')?> </ff></div></div>
<div class="centerSideIn so">

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" >
	<tr>
	<th width="60"><?=k_thvisit?></th>
	<th width="100"><?=k_tim?></th>	
	<th><?=k_patient?></th>
	<th><?=k_doctor?></th>
	<th><?=k_code?></th>
	<th><?=k_cmpt_srvcs?> </th>
	<th><?=k_val_of_completed?></th>
	<th><?=k_paym?></th>
	</tr><?
	$allService=$allPayment=0;
	foreach($data as $k => $d){		
		$vis=$data[$k]['vis'];		
		list($doc,$code)=get_val_arr('_users',"name_$lg,career_code",$d['doctor'],'doc');
		$amount=$d['amount'];
		$patient=$d['patient'];
		$type=$d['type'];
		$srvData='';
		$totalPrice=0;
		$sql="select * from den_x_visits_services_levels where vis='$vis' and status=2";
		$res=mysql_q($sql);
		if($type==1){
			while($r=mysql_f($res)){
			$srv=$r['service'];
			$lev=$r['lev'];
			$price=$r['price'];
			$totalPrice+=$price;
			$srvTxt=get_val_arr('den_m_services','name_'.$lg,$srv,'srv');
			$levTxt=get_val_arr('den_m_services_levels','name_'.$lg,$lev,'lev');
			$srvData.='<div class="f1 fs14 ">- '.splitNo($srvTxt).' / '.splitNo($levTxt).' <ff class="fs14 clr1"> ( '.number_format($price).' )</ff></div>';
		}
		}
		if($type==2){$srvData='-';$totalPrice='-';}
		if($type==3){$srvData='<div class="f1 fs14 clr5">'.k_indpndnt_pay.'</div>';$totalPrice='-';}
		$allService+=$totalPrice;
		$allPayment+=$amount;
		?>
		<tr>
		<td><ff><?=$vis?></ff></td>
		<td><ff><?=date('A h:i',$k)?></ff></td>
		<td txt><?=get_p_name($patient)?></td>		
		<td txt><?=$doc?></td>
		<td><ff class="clr5"><?=$code?></ff></td>
		<td><div class="TL"><?=$srvData?></div></td>
		<td><ff><?=number_format($totalPrice)?></ff></td>
		<td><ff><?=number_format($amount)?></ff></td>
		</tr><?
	}?>
	<tr>		
		<td txt colspan="6"><?=k_total?></td>
		<td><ff><?=number_format($allService)?></ff></td>
		<td><ff><?=number_format($allPayment)?></ff></td>
		</tr>
</table>
</div>
<script>//sezPage='';$(document).ready(function(e){f(1);});</script>