<? $repCode='xry';
$pageSize='print_page4';
$report_kWord='report';//k_repot;
/**************************************************/
$head=1;$breakC='^';$page_mood=0;
if(isset($_GET['mood'])){$page_mood=intval($_GET['mood']);}
if($page_mood==2){include("../../__sys/prcds/ajax_head_cFile.php");}else{include("../../__sys/prcds/ajax_header.php");}
reportStart($page_mood);
/*******Report Title*******************************/
if($page==1){
	$title1=' '.k_txry.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}	
if($page==2){
	$title1=' '.k_rad_report.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}
if($page==3){
	$title1=' '.k_xray_reports.' ';				
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}
	if($tab==3){$titleVal=reportTapTitle('all');}
	if($tab==4){$titleVal=reportTapTitle('date');}
	if($tab==5){$titleVal=reportTapTitle('month',k_mth_tol);}
	if($tab==6){$titleVal=reportTapTitle('month',k_mth_tm);}
}
/*******Export File Name***************************/
if($page==1){
	$fileName='xry_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRange';}
}
if($page==2){
	$fileName='xyr_rep_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRange';}
}
if($page==3){
	$fileName='xryReport_';		
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
	if($tab==3){$fileName.='all';}
	if($tab==4){$fileName.='dateRang';}
	if($tab==5){$fileName.='monthTotal';}
	if($tab==6){$fileName.='monthTime';}

}
/**************************************************/
echo reportPageSet($page_mood,$fileName);
/**************************************************/			
if($page==1){
	if($tab==0){
		echo reportNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo reportNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);			
	}
	if($tab==2){
		echo reportNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;			
	}		
	echo $breakC;
	$usersArr=array();
	$usersTotalArr=array();
	$sql="select * from _users where grp_code in('nlh8spit9q','1ceddvqi3g') order by grp_code ASC , name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$user_id=$r['id'];
			if(getTotalCO('xry_x_visits_services'," d_start>='$d_s' and d_start<'$d_e' and  
				visit_id IN(select id from xry_x_visits where ray_tec='$user_id') and status=1")){
				$usersArr[$user_id]=$r['name_'.$lg];
			}
		}
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th rowspan="2"  width="150">'.k_tclinic.' / '.k_doctor.' - '.k_technician.'</th>';
		foreach ($usersArr as $k=> $doc ){echo '<th colspan="4">'.$doc.'</th>';}
		echo '<th colspan="4">'.k_total.'</th>
		<tr>';
		foreach ($usersArr as $k=> $doc ){
			echo '<th>'.k_services.' </th><th>'.k_totl.'</th><th>'.k_monetary.'</th><th>'.k_postpaid.'</th>';
		}
		echo '<th>'.k_services.' </th><th>'.k_totl.'</th><th>'.k_monetary.'</th><th>'.k_postpaid.'</th>';
		echo '</tr>';
		$sql="select * from gnr_m_clinics where type=3 order by name_$lg ASC";
		$res=mysql_q($sql);
		$vTt=0;
		$cTt=0;
		while($r=mysql_f($res)){
			$vT=$cT1=$cT2=$cT3=0;
			$showRow=0;
			$xry_id=$r['id'];
			$rr='<tr>
			<td class="f1">'.$r['name_'.$lg].'</td>';
			foreach ($usersArr as $k=> $doc){
				$visitTot=getTotalCO('xry_x_visits_services'," d_start>='$d_s' and d_start<'$d_e' and  
				visit_id IN(select id from xry_x_visits where ray_tec='$k' and status=2) and clinic='$xry_id' and status=1");
				list($pay_all,$pay_cash)=get_sum('xry_x_visits_services','total_pay,pay_net'," d_start>='$d_s' and d_start<'$d_e' and 
				visit_id IN(select id from xry_x_visits where ray_tec='$k' and status=2) and clinic='$xry_id' and status=1");
				$pay_past=$pay_all-$pay_cash;
				$usersTotalArr[$k]['vis']+=$visitTot;
				$usersTotalArr[$k]['val1']+=$pay_all;
				$usersTotalArr[$k]['val2']+=$pay_cash;
				$usersTotalArr[$k]['val3']+=$pay_past;
				$vT+=$visitTot;
				$cT1+=$pay_all;
				$cT2+=$pay_cash;
				$cT3+=$pay_past;
				
				$rr.='<td><ff class="clr11">'.number_format($visitTot).'<ff></td>';
				$rr.='<td><ff class="clr1">'.number_format($pay_all).'</ff></td>';
				$rr.='<td><ff class="clr6">'.number_format($pay_cash).'</ff></td>';
				$rr.='<td><ff class="clr5">'.number_format($pay_past).'</ff></td>';
				if($visitTot || $visitval){$showRow=1;}
			}
			$rr.='<td fot><ff class="clr11">'.number_format($vT).'<ff></td>';
			$rr.='<td fot><ff class="clr1">'.number_format($cT1).'</ff></td>';
			$rr.='<td fot><ff class="clr6">'.number_format($cT2).'</ff></td>';
			$rr.='<td fot><ff class="clr5">'.number_format($cT3).'</ff></td>';
			$rr.='</tr>';				
			if($showRow){echo $rr;}
			$vTt+=$vT;
			$cTt1+=$cT1;
			$cTt2+=$cT2;
			$cTt3+=$cT3;
		}
		echo '<tr fot>
		<td class="f1">'.k_total.'</td>';
		 foreach ($usersArr as $k=> $doc ){
			echo '<td><ff class="clr11">'.number_format($usersTotalArr[$k]['vis']).'<ff></td>
			<td><ff class="clr1">'.number_format($usersTotalArr[$k]['val1']).'</ff></td>
			<td><ff class="clr6">'.number_format($usersTotalArr[$k]['val2']).'</ff></td>
			<td><ff class="clr5">'.number_format($usersTotalArr[$k]['val3']).'</ff></td>';
		}
		echo '<td><ff class="clr11">'.number_format($vTt).'<ff></td>';
		echo '<td><ff class="clr1">'.number_format($cTt1).'</ff></td>';
		echo '<td><ff class="clr6">'.number_format($cTt2).'</ff></td>';
		echo '<td><ff class="clr5">'.number_format($cTt3).'</ff></td>';
		echo '</tr>';
		echo '</table>';
	}				
}
if($page==2){	
	$sql="select id,val from xry_x_pro_radiography_report where val=0";
	$res=mysql_q($sql);
	while($r=mysql_f($res)){
		$pId=$r['id'];
		$val=get_val('xry_x_visits_services','total_pay',$pId);
		if($val){mysql_q("UPDATE xry_x_pro_radiography_report SET val='$val' where id='$pId' ");}
	}		
	if($tab==0){
		echo reportNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo reportNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);			
	}
	if($tab==2){
		echo reportNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;			
	}		
	echo $breakC;
	$usersArr=array();
	$usersTotalArr=array();
	$sql="select * from gnr_m_clinics where type=3 order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$cli_id=$r['id'];
			$clinTotal=getTotalCO('xry_x_visits_services'," d_start>='$d_s' and d_start<'$d_e' and clinic='$cli_id' and doc!=0 and status=1");
			if($clinTotal){
				$clinicArr[$cli_id]=$r['name_'.$lg];
			}
		}
		echo '<div class="f1 clr5 fs14 lh30">'.k_notes.' :</div>';
		echo '<div class="f1 clr5">'.k_val_srvs_is_total.'  ( '.k_not_dr_share.' )</div>';
		echo '<div class="f1 clr5 fs14 lh30">'.k_num_represent_report.'</div>';
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s  holdH"><tr>
			<th width="150" rowspan="2">'.k_doctor.' / '.k_tclinic.'</th>';
		foreach ($clinicArr as $k=> $clin){echo '<th colspan="2">'.$clin.'</th>';}
		echo '<th colspan="2">'.k_total.'</th>
		</tr>
		<tr>';		
		foreach ($clinicArr as $k=> $clin){echo '<th>'.k_number.'</th><th>'.k_val.'</th>';}
		echo '<th>'.k_number.'</th><th>'.k_val.'</th>';			
		echo '</tr>';
		$sql="select * from _users where grp_code ='nlh8spit9q' order by name_$lg ASC";
		$res=mysql_q($sql);
		$vTt=$vVv=0;
		while($r=mysql_f($res)){
			$vT=$vV=$vTall=$vVall=0;
			$realRepAll=$realValAll='';
			$user_id=$r['id'];
			$rr='<tr>
			<td class="f1">'.$r['name_'.$lg].'</td>';
			 foreach ($clinicArr as $k=> $clin ){
				$visitTot=getTotalCO('xry_x_pro_radiography_report'," `date` >='$d_s' and `date` <'$d_e' and doc='$user_id' and clin='$k' ");
				//$visitTotR=getTotalCO('xry_x_pro_radiography_report'," `date` >='$d_s' and `date` <'$d_e' and doc='$user_id' and clin='$k' and report!=''");
				$visitTotR=getTotalCO('xry_x_pro_radiography_report'," `date` >='$d_s' and `date` <'$d_e' and doc='$user_id' and clin='$k' and  LENGTH(report)>30 ");

				$visitval=get_sum('xry_x_pro_radiography_report','val'," `date` >='$d_s' and `date` <'$d_e' and doc='$user_id' and clin='$k' ");

				$usersTotalArr[$k]['vis']+=$visitTot;
				$usersTotalArr[$k]['val']+=$visitval;
				$vT+=$visitTot;
				$vV+=$visitval;
				$realRep=$realVal='';
				if($visitTot!=$visitTotR){
					$realRep='<br><ff class="clr5 fs12">'.number_format($visitTotR).'</ff>';
					$visitRealVal=get_sum('xry_x_pro_radiography_report','val'," `date` >='$d_s' and `date` <'$d_e' and doc='$user_id' and clin='$k' and  LENGTH(report)>30 ");
					$realVal='<br><ff class="clr5 fs12">'.number_format($visitRealVal).'</ff>';						
					$vTall+=$visitTotR;
					$vVall+=$visitRealVal;
				}else{
					$vTall+=$visitTot;
					$vVall+=$visitval;
				}
				$rr.='<td><ff class="clr1">'.number_format($visitTot).'</ff>'.$realRep.'</td>';
				$rr.='<td><ff class="clr6">'.number_format($visitval).'</ff>'.$realVal.'</td>';
			}
			if($vT!=$vTall){
				$realRepAll='<br><ff class="clr5 fs12">'.number_format($vTall).'</ff>';					
				$realValAll='<br><ff class="clr5 fs12">'.number_format($vVall).'</ff>';											
			}
			$rr.='<td fot><ff class="clr1">'.number_format($vT).'</ff>'.$realRepAll.'</td>';
			$rr.='<td fot><ff class="clr6">'.number_format($vV).'</ff>'.$realValAll.'</td>';
			$rr.='</tr>';
			if($vT){echo $rr;}
			$vTt+=$vT;
			$vVv+=$vV;
			$cTt+=$cT;
		}
		echo '<tr fot>
		<td class="f1">'.k_total.'</td>';
		 foreach ($clinicArr as $k=> $clin){
			echo '<td><ff class="clr1">'.number_format($usersTotalArr[$k]['vis']).'</ff></td>';
			echo '<td><ff class="clr6">'.number_format($usersTotalArr[$k]['val']).'</ff></td>';
		}

		echo '<td><ff class="clr1">'.number_format($vTt).'</ff></td>';
		echo '<td><ff class="clr6">'.number_format($vVv).'</ff></td>';
		echo '</tr>';
		echo '</table>';
	}
}
if($page==3){
	$cType=3;
	if($tab==0){
		echo reportNav($fil,1,$page,$tab,1,1,$page_mood);			
		if($val==0){
			$d_s=$todyU;
			$d_e=$d_s+86400;
			$q='';
			$clArr=array();
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>'.$breakC;
			$sql="select id,name_$lg from gnr_m_clinics where type=$cType order by ord ASC";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){$clArr[$r['id']]=$r['name_'.$lg];}				
			$sql="select clinic,SUM(vis)vis ,SUM(srv)srv , SUM(total)total , SUM(pay_net)pay_net , SUM(pay_insur)pay_insur from gnr_r_clinic 
			where date >= '$d_s' and date < '$d_e' and type=$cType group by clinic order by clinic ASC";
			$res=mysql_q($sql);
			if($res){
				$t1=$t2=$t3=$t4=$t5=0;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th>'.k_clinic.'</th>
					<th>'.k_visits.'</th>            
					<th>'.k_services.'</th>
					<th>'.k_val_srvs.'</th>
					<th>'.k_monetary.'</th>
					<th>'.k_uncovered_amount.'</th>
				</tr>';
				while($r=mysql_f($res)){						
					$vis=$r['vis'];
					$srv=$r['srv'];
					$total=$r['total'];
					$pay_net=$r['pay_net'];
					$pay_insur=$r['pay_insur'];
					$t1+=$vis;
					$t2+=$srv;
					$t3+=$total;
					$t4+=$pay_net;
					$t5=$pay_insur;
					echo '<tr>
					<td class="f1 fs14">'.$clArr[$r['clinic']].'</td>
					<td><ff class="clr1">'.number_format($vis).'</ff></td>
					<td><ff class="clr1">'.number_format($srv).'</ff></div></td>
					<td><ff class="clr6">'.number_format($total).'</ff></td>
					<td><ff class="clr66">'.number_format($pay_net).'</ff></td>
					<td><ff class="clr5">'.number_format($pay_insur).'</ff></td>
					</tr>';
				}
				echo '
				<tr fot>
				<td class="f1 fs14">'.k_total.'</td>
				<td><ff class="clr1">'.number_format($t1).'</ff></td>
				<td><ff class="clr1">'.number_format($t2).'</ff></div></td>
				<td><ff class="clr6">'.number_format($t3).'</ff></td>
				<td><ff class="clr66">'.number_format($t4).'</ff></td>
				<td><ff class="clr5">'.number_format($t5).'</ff></td>
				</tr></table>';
			}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}
		}else{				
			$d_s=$todyU;
			$d_e=$d_s+86400;
			$q='';
			$sql="select * from $srvXTables[$cType] where status=1 
			and clinic='$val' and d_start>'$d_s' and d_start < '$d_e' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_clinics','name_'.$lg,$val).' <ff> ( '.number_format($rows).' ) </ff></div>'.$breakC;
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th width="20"><?=k_num_serv?></th>
					<th><?=k_patient?></th>            
					<th><?=k_service?></th>
					<th><?=k_val_srv?></th>
					<th><?=k_monetary?></th>
					<!--<th><?=k_nt_prv?></th>
					<th><?=k_nt_actn?></th>
					<th><?=k_discount?></th>
					<th><?=k_totl?></th>
					<th><?=k_hsp_rvnu?></th>
					<th><?=k_incvs_doc?></th>-->
				</tr><?
				$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;                    
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$patient=$r['patient'];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$doc_part=$r['doc_part'];
					$doc_percent=$r['doc_percent'];
					$pay_net=$r['pay_net'];
					$service=$r['service'];
					$doc_bal=$r['doc_bal'];
					$doc_dis=$r['doc_dis'];
					$hos_bal=$r['hos_bal'];
					$hos_dis=$r['hos_dis'];
					$cost=$r['cost'];
					$total_pay=$r['total_pay'];
					$dis=$doc_dis+$hos_dis;						$t1+=$pay_net;$t2+=$doc_part;$t3+=$dis;$t4+=$total_pay;$t5+=$hos_bal;$t6+=$doc_bal;
					echo '<tr>
					<td><ff>'.$s_id.'</ff></td>
					<td class="f1 fs14">'.get_p_name($patient).'</td>
					<td class="f1 fs14">'.get_val('cln_m_services','name_'.$lg,$service).'</td>
					<td><ff>'.number_format($total_pay).'</ff></td>						
					<td><ff>'.number_format($pay_net).'</ff></td>';
					/*<td><ff>'.number_format($hos_part).'</ff></td>
					<td><ff>'.number_format($doc_part).'</ff></td>
					<td><ff>'.number_format($dis).'</ff></td>
					<td><ff>'.number_format($total_pay).'</ff></td>
					<td><ff>'.number_format($hos_bal).'</ff></td>
					<td><ff>'.number_format($doc_bal).'</ff></td>*/
					echo '</tr>';
				}					
				echo '<tr fot>
				<td colspan="3" class="f1 fs14">'.k_total.'</td>
				<td><ff>'.number_format($t4).'</ff></td>
				<td><ff>'.number_format($t1).'</ff></td>';
				/*<td><ff>'.number_format($t3).'</ff></td>
				<td><ff>'.number_format($t4).'</ff></td>
				<td><ff>'.number_format($t5).'</ff></td>
				<td><ff>'.number_format($t6).'</ff></td>*/
				echo '</tr>';
				?></table><?
			}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}				
		}
	}
	if($tab==1){
		echo reportNav($fil,2,$page,$tab,1,1,$page_mood);
		$q2='';
		if($val){$q2=" and clinic='$val'";$add_title=get_val('gnr_m_clinics','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?>
		<?
		$t1=$t2=$t3=$t4=$t5=0;
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th width="30">'.k_tday.'</th>
			<th>'.k_visits.'</th>            
			<th>'.k_services.'</th>
			<th>'.k_val_srvs.'</th>
			<th>'.k_monetary.'</th>
			<th>'.k_uncovered_amount.'</th>
		</tr>';
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			$sql="select SUM(vis)vis ,SUM(srv)srv , SUM(total)total , SUM(pay_net)pay_net , SUM(pay_insur)pay_insur from gnr_r_clinic 
			where date >= '$d_s' and date < '$d_e' and type=$cType $q2  order by clinic ASC limit 1";
			$res=mysql_q($sql);
			if($res){
				$r=mysql_f($res);	
				$vis=$r['vis'];
				$srv=$r['srv'];
				$total=$r['total'];
				$pay_net=$r['pay_net'];
				$pay_insur=$r['pay_insur'];
				$t1+=$vis;
				$t2+=$srv;
				$t3+=$total;
				$t4+=$pay_net;
				$t5=$pay_insur;
				if($vis){
					echo '<tr>
					<td><div class="ff fs18 B txt_Over" onclick="loadReport('.$page.',0,'.$d_s.')">'.($ss+1).'</div></td> 
					<td><ff class="clr1">'.number_format($vis).'</ff></td>
					<td><ff class="clr1">'.number_format($srv).'</ff></div></td>
					<td><ff class="clr6">'.number_format($total).'</ff></td>
					<td><ff class="clr66">'.number_format($pay_net).'</ff></td>
					<td><ff class="clr5">'.number_format($pay_insur).'</ff></td>
					</tr>';
				}
			}
		}
		echo '
		<tr fot>
		<td class="f1 fs14">'.k_total.'</td>
		<td><ff class="clr1">'.number_format($t1).'</ff></td>
		<td><ff class="clr1">'.number_format($t2).'</ff></div></td>
		<td><ff class="clr6">'.number_format($t3).'</ff></td>
		<td><ff class="clr66">'.number_format($t4).'</ff></td>
		<td><ff class="clr5">'.number_format($t5).'</ff></td>
		</tr></table>'; 
	}		
	if($tab==2){
		echo reportNav($fil,3,$page,$tab,1,1,$page_mood);
		$q='';
		if($val){$q2=" and clinic='$val'";$add_title=get_val('gnr_m_clinics','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?>
		<? $t1=$t2=$t3=$t4=$t5=0;
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th width="30">'.k_tday.'</th>
			<th>'.k_visits.'</th>            
			<th>'.k_services.'</th>
			<th>'.k_val_srvs.'</th>

			<th>'.k_monetary.'</th>
			<th>'.k_uncovered_amount.'</th>
		</tr>';

		for($ss=1;$ss<13;$ss++){
			$d_s=mktime(0,0,0,$ss,1,$selYear);
			$d_e=mktime(0,0,0,$ss+1,1,$selYear);
			$sql="select SUM(vis)vis ,SUM(srv)srv , SUM(total)total , SUM(pay_net)pay_net , SUM(pay_insur)pay_insur from gnr_r_clinic 
			where date >= '$d_s' and date < '$d_e' and type=$cType $q2 order by clinic ASC limit 1";
			$res=mysql_q($sql);
			if($res){
				//while(
				$r=mysql_f($res);
				//){
					$vis=$r['vis'];
					$srv=$r['srv'];
					$total=$r['total'];
					$pay_net=$r['pay_net'];
					$pay_insur=$r['pay_insur'];
					$t1+=$vis;
					$t2+=$srv;
					$t3+=$total;
					$t4+=$pay_net;
					$t5=$pay_insur;
					if($vis){
					echo '<tr>
					<td><div class="f1 fs14 txt_Over" onclick="loadReport('.$page.',1,\''.($selYear.'-'.$ss).'\')">'.$monthsNames[$ss].'</div></td> 
					<td><ff class="clr1">'.number_format($vis).'</ff></td>
					<td><ff class="clr1">'.number_format($srv).'</ff></div></td>
					<td><ff class="clr6">'.number_format($total).'</ff></td>
					<td><ff class="clr66">'.number_format($pay_net).'</ff></td>
					<td><ff class="clr5">'.number_format($pay_insur).'</ff></td>
					</tr>';
					}
				//}

			}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}
		}
		echo '
		<tr fot>
		<td class="f1 fs14">'.k_total.'</td>
		<td><ff class="clr1">'.number_format($t1).'</ff></td>
		<td><ff class="clr1">'.number_format($t2).'</ff></div></td>
		<td><ff class="clr6">'.number_format($t3).'</ff></td>
		<td><ff class="clr66">'.number_format($t4).'</ff></td>
		<td><ff class="clr5">'.number_format($t5).'</ff></td>
		</tr></table>'; 	
	}
	if($tab==3){			
		$q='';			
		if($val){$q2=" and clinic='$val'";$add_title=get_val('gnr_m_clinics','name_'.$lg,$val);}?>      
		<div class="bu bu_t3 fr" onclick="printReport(1)"><?=k_prn_tbl?></div><div class="uLine cb"></div>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?>			
		<? $t1=$t2=$t3=$t4=$t5=0;
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th width="30">'.k_tday.'</th>
			<th>'.k_visits.'</th>            
			<th>'.k_services.'</th>
			<th>'.k_val_srvs.'</th>
			<th>'.k_monetary.'</th>
			<th>'.k_uncovered_amount.'</th>
		</tr>';
		$years=getYearsOfRec('gnr_r_clinic','date',str_replace('and','',$q2));
		if($years[0]!=0){         
			for($ss=$years[0];$ss<=$years[1];$ss++){
				$d_s=strtotime($ss.'-1-1');
				$d_e=strtotime(($ss+1).'-1-1');					
				$sql="select SUM(vis)vis ,SUM(srv)srv , SUM(total)total , SUM(pay_net)pay_net , SUM(pay_insur)pay_insur from gnr_r_clinic 
				where date >= '$d_s' and date < '$d_e' and type=$cType $q2 order by clinic ASC";
				$res=mysql_q($sql);
				if($res){
					//while(
					$r=mysql_f($res);
					//){
						$vis=$r['vis'];
						$srv=$r['srv'];
						$total=$r['total'];
						$pay_net=$r['pay_net'];
						$pay_insur=$r['pay_insur'];
						$t1+=$vis;
						$t2+=$srv;
						$t3+=$total;
						$t4+=$pay_net;
						$t5=$pay_insur;
						if($vis){
						echo '<tr>
						<td><div class="ff fs18 B txt_Over" onclick="loadReport('.$page.',2,\''.($ss).'\')">'.$ss.'</div></td>
						<td><ff class="clr1">'.number_format($vis).'</ff></td>
						<td><ff class="clr1">'.number_format($srv).'</ff></div></td>
						<td><ff class="clr6">'.number_format($total).'</ff></td>
						<td><ff class="clr66">'.number_format($pay_net).'</ff></td>
						<td><ff class="clr5">'.number_format($pay_insur).'</ff></td>
						</tr>';
						}
					//}

				}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}
			}
			echo '
			<tr fot>
			<td class="f1 fs14">'.k_total.'</td>
			<td><ff class="clr1">'.number_format($t1).'</ff></td>
			<td><ff class="clr1">'.number_format($t2).'</ff></div></td>
			<td><ff class="clr6">'.number_format($t3).'</ff></td>
			<td><ff class="clr66">'.number_format($t4).'</ff></td>
			<td><ff class="clr5">'.number_format($t5).'</ff></td>
			</tr></table>'; 
		}
	}		
	if($tab==4){
		echo reportNav($fil,4,$page,$tab,1,1,$page_mood);            			
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		if($d_s<$d_e){
			$q='';
			$clArr=array();
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>'.$breakC;
			$sql="select id,name_$lg from gnr_m_clinics where type=$cType order by ord ASC";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){$clArr[$r['id']]=$r['name_'.$lg];}				
			$sql="select clinic,SUM(vis)vis ,SUM(srv)srv , SUM(total)total , SUM(pay_net)pay_net , SUM(pay_insur)pay_insur from gnr_r_clinic 
			where date >= '$d_s' and date < '$d_e' and type=$cType group by clinic order by clinic ASC";
			$res=mysql_q($sql);
			if($res){
				$t1=$t2=$t3=$t4=$t5=0;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th>'.k_clinic.'</th>
					<th>'.k_visits.'</th>            
					<th>'.k_services.'</th>
					<th>'.k_val_srvs.'</th>
					<th>'.k_monetary.'</th>
					<th>'.k_uncovered_amount.'</th>
				</tr>';
				while($r=mysql_f($res)){						
					$vis=$r['vis'];
					$srv=$r['srv'];
					$total=$r['total'];
					$pay_net=$r['pay_net'];
					$pay_insur=$r['pay_insur'];
					$t1+=$vis;
					$t2+=$srv;
					$t3+=$total;
					$t4+=$pay_net;
					$t5=$pay_insur;					
					echo '<tr>
					<td class="f1 fs14">'.$clArr[$r['clinic']].'</td>
					<td><ff class="clr1">'.number_format($vis).'</ff></td>
					<td><ff class="clr1">'.number_format($srv).'</ff></div></td>
					<td><ff class="clr6">'.number_format($total).'</ff></td>
					<td><ff class="clr66">'.number_format($pay_net).'</ff></td>
					<td><ff class="clr5">'.number_format($pay_insur).'</ff></td>
					</tr>';					
				}
				echo '
				<tr fot>
				<td class="f1 fs14">'.k_total.'</td>
				<td><ff class="clr1">'.number_format($t1).'</ff></td>
				<td><ff class="clr1">'.number_format($t2).'</ff></div></td>
				<td><ff class="clr6">'.number_format($t3).'</ff></td>
				<td><ff class="clr66">'.number_format($t4).'</ff></td>
				<td><ff class="clr5">'.number_format($t5).'</ff></td>
				</tr></table>';
			}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}

	}


	if($tab==5){
		echo reportNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);
		$q='';
		$clArr=array();
		echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>'.$breakC;
		$sql="select id,name_$lg from gnr_m_clinics where type=$cType order by ord ASC";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){$clArr[$r['id']]=$r['name_'.$lg];}				
		$sql="select clinic,SUM(vis)vis ,SUM(srv)srv , SUM(total)total , SUM(pay_net)pay_net , SUM(pay_insur)pay_insur from gnr_r_clinic 
		where date >= '$d_s' and date < '$d_e' and type=$cType group by clinic order by clinic ASC";
		$res=mysql_q($sql);
		if($res){
			$t1=$t2=$t3=$t4=$t5=0;
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th>'.k_clinic.'</th>
				<th>'.k_visits.'</th>            
				<th>'.k_services.'</th>
				<th>'.k_val_srvs.'</th>
				<th>'.k_monetary.'</th>
				<th>'.k_uncovered_amount.'</th>
			</tr>';
			while($r=mysql_f($res)){						
				$vis=$r['vis'];
				$srv=$r['srv'];
				$total=$r['total'];
				$pay_net=$r['pay_net'];
				$pay_insur=$r['pay_insur'];
				$t1+=$vis;
				$t2+=$srv;
				$t3+=$total;
				$t4+=$pay_net;
				$t5=$pay_insur;
				echo '<tr>
				<td class="f1 fs14">'.$clArr[$r['clinic']].'</td>
				<td><ff class="clr1">'.number_format($vis).'</ff></td>
				<td><ff class="clr1">'.number_format($srv).'</ff></div></td>
				<td><ff class="clr6">'.number_format($total).'</ff></td>
				<td><ff class="clr66">'.number_format($pay_net).'</ff></td>
				<td><ff class="clr5">'.number_format($pay_insur).'</ff></td>
				</tr>';
			}
			echo '
			<tr fot>
			<td class="f1 fs14">'.k_total.'</td>
			<td><ff class="clr1">'.number_format($t1).'</ff></td>
			<td><ff class="clr1">'.number_format($t2).'</ff></div></td>
			<td><ff class="clr6">'.number_format($t3).'</ff></td>
			<td><ff class="clr66">'.number_format($t4).'</ff></td>
			<td><ff class="clr5">'.number_format($t5).'</ff></td>
			</tr></table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}

	}
	if($tab==6){
		echo reportNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_ss=$mm;
		$d_ee=$mm+($monLen*86400);
		echo $breakC; 
		$sql="select id , name_$lg from  gnr_m_clinics  where type=3 and act = 1 order by ord ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);				
		$x_clinic=array();
		$x_times=array('8-17','17-22','22-8');
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){
				$x_clinic[$i]['id']=$r['id'];
				$x_clinic[$i]['name']=$r['name_'.$lg];
				$i++;
			}
		}
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>			
			<th width="20"><?=k_tday?></th><th>'.k_shft.'</th>';
			foreach($x_clinic as $c){echo '<th>'.$c['name'].'</th>';}				
			echo'<th colspan="'.count($x_times).'">'.k_total.'</th>
		</tr>';
		$r_total_arr=array();
		$x_data=array();
		$r=0;
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;			
			$row_txt='';
			if($d_e<($now+86400)){
				$fr=0;
				foreach($x_times as $t){
					$r_total=0;					
					$tt=explode('-',$t);
					$sH=$tt[0];
					$eH=$tt[1];					
					$nextDay=0;						
					if($nextDay){
						$d_s2=$d_s+(($sH+24)*3600);
						$d_e2=$d_s+(($eH+24)*3600);
					}else{
						if($eH<$sH){
							$d_s2=$d_s+($sH*3600);
							$d_e2=$d_s+(($eH+24)*3600);
							$nextDay=1;
						}else{
							$d_s2=$d_s+($sH*3600);
							$d_e2=$d_s+($eH*3600);
						}
					}
					$r++;
					$x_data[$r]['s']=$d_s2;
					$x_data[$r]['e']=$d_e2;					
				}
			}
		}
		$sql="select d_start,clinic from xry_x_visits where  d_start>='$d_ss' and d_start < '$d_ee' order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$d_start=$r['d_start'];
				$clinic=$r['clinic'];
				foreach($x_data as $d){
					if($d_start>=$d['s'] && $d_start<$d['e']){
						$x_data[$clinic][$d['s'].'-'.$d['e']]++;
					}
				}
			}
		}
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;			
			$row_txt='';
			if($d_e<($now+86400)){
				$fr=0;
				foreach($x_times as $t){
					$r_total=0;
					if($fr==0){$row_txt='<tr style="border-top:2px #ccc solid">
					<td rowspan="'.count($x_times).'"><ff>'.($ss+1).'</ff></td>';}
					$fr=1;
					$tt=explode('-',$t);
					$sH=$tt[0];$eH=$tt[1];
					$sH2=clockStye($sH);$eH2=clockStye($eH);
					$t2=$sH2.'/'.$eH2;
					$nextDay=0;						
					if($nextDay){
						$d_s2=$d_s+(($sH+24)*3600);
						$d_e2=$d_s+(($eH+24)*3600);
					}else{
						if($eH<$sH){
							$d_s2=$d_s+($sH*3600);
							$d_e2=$d_s+(($eH+24)*3600);
							$nextDay=1;
						}else{
							$d_s2=$d_s+($sH*3600);
							$d_e2=$d_s+($eH*3600);
						}
					}
					$row_txt.='<td><ff>'.$t2.'</ff></td>';
					foreach($x_clinic as $c){
						$c_id=$c['id'];
						$total=$x_data[$c_id][$d_s2.'-'.$d_e2];
						if(!$total){$total=0;}
						$r_total+=$total;							
						$row_txt.='<td><ff>'.$total.'</ff></td>';							
					}
					$r_total_arr[$t]+=$r_total;
					$row_txt.='<td><ff>'.number_format($r_total).'</ff></td></tr>';
				}
				if($r_total>0){echo $row_txt;}
			}
		}
		$allReks=0;
		foreach($x_times as $t){$allReks+=$r_total_arr[$t];}
		if($allReks>0){
			$row_txt2='<tr style="border-top:2px #ccc solid"><td rowspan="'.count($x_times).'"><ff>'.k_total.'</ff></td>';
			foreach($x_times as $t){
				$r_total=0;
				$tt=explode('-',$t);
				$sH=$tt[0];$sH2=clockStye($sH);
				$eH=$tt[1];$eH2=clockStye($eH);			
				$t2=$sH2.'/'.$eH2;
				$row_txt2.='<td colspan="'.(count($x_clinic)+1).'"><ff>'.$t2.'</ff></td>';
				$row_txt2.='<td><ff dir="ltr">'.number_format($r_total_arr[$t]).' - '.number_format((100*$r_total_arr[$t])/$allReks).'% </ff></td></tr>';
			}
			echo $row_txt2;
		}
		echo '</table>';

	}
}
/**************************************************/
if($page_mood==1){echo reportFooter();}?>