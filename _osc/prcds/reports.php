<? $repCode='osc';
$pageSize='print_page4';
$report_kWord=k_repot;
/**************************************************/
$head=1;$breakC='^';$page_mood=0;
if(isset($_GET['mood'])){$page_mood=intval($_GET['mood']);}
if($page_mood==2){include("../../__sys/prcds/ajax_head_cFile.php");}else{include("../../__sys/prcds/ajax_header.php");}
reportStart($page_mood);
/*******Report Title*******************************/
if($page==1){
	$title1=k_endoscopy;
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}
	if($tab==3){$titleVal=reportTapTitle('all');}
	if($tab==4){$titleVal=reportTapTitle('date');}
}
if($page==2){
	$title1=k_endoscopy;
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}	
/*******Export File Name***************************/
if($page==1){
	$fileName='osc_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
	if($tab==3){$fileName.='all';}
	if($tab==4){$fileName.='dateRang';}
}
if($page==2){
	$fileName='osc_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRange';}
}
/**************************************************/
echo reportPageSet($page_mood,$fileName);	
/**************************************************/
if($page==1){
	$cType=7;
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
					<th>'.k_val_srvs.' </th>
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
					<th><?=k_val_srv?> </th>
					<th><?=k_monetary?> </th>
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
			<th>'.k_val_srvs.' </th>
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
					<td><div class="ff fs18 B txt_Over" onclick="loadReport('.$page.',0,'.$d_s.')">'.($ss+1).'</div></td> 
					<td><ff class="clr1">'.number_format($vis).'</ff></td>
					<td><ff class="clr1">'.number_format($srv).'</ff></div></td>
					<td><ff class="clr6">'.number_format($total).'</ff></td>
					<td><ff class="clr66">'.number_format($pay_net).'</ff></td>
					<td><ff class="clr5">'.number_format($pay_insur).'</ff></td>
					</tr>';
					}
				//}

			}
			//else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}
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
			<th width="30">'.k_month.'</th> 
			<th>'.k_visits.'</th>            
			<th>'.k_services.'</th>
			<th>'.k_val_srvs.' </th>
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
		echo reportNav($fil,0,$page,$tab,1,1,$page_mood);
		if($val){$q2=" and clinic='$val'";$add_title=get_val('gnr_m_clinics','name_'.$lg,$val);}?>			
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?>			
		<? $t1=$t2=$t3=$t4=$t5=0;
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th width="30">'.k_tday.'</th> 
			<th>'.k_visits.'</th>            
			<th>'.k_services.'</th>
			<th>'.k_val_srvs.' </th>
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
					<th>'.k_val_srvs.' </th>
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
}
if($page==2){
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
	$sql="select * from _users where grp_code ='9k0a1zy2ww' order by grp_code ASC , name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$user_id=$r['id'];
			if(getTotalCO('osc_x_visits_services'," d_start>='$d_s' and d_start<'$d_e' and  
				visit_id IN(select id from osc_x_visits where doctor='$user_id') and status=1")){
				$usersArr[$user_id]=$r['name_'.$lg];
			}
		}
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th rowspan="2"  width="150">'.k_dr.' / '.k_technician.'</th>';
			foreach ($usersArr as $k=> $doc ){echo '<th colspan="2">'.$doc.'</th>';}
		echo '<th colspan="2">'.k_total.'</th>
		<tr>';
		foreach ($usersArr as $k=> $doc ){
			echo '<th>'.k_services.' </th>';
			echo '<th>'.k_monetary.'</th>';
		}
		echo '<th>'.k_services.'</th>';
		echo '<th>'.k_monetary.'</th>';
		echo '</tr>';
		$sql="select * from gnr_m_clinics where type=7 order by name_$lg ASC";
		$res=mysql_q($sql);
		$vTt=0;
		$cTt=0;
		while($r=mysql_f($res)){
			$vT=0;
			$cT=0;
			$showRow=0;
			$osc_id=$r['id'];
			$rr='<tr>
			<td class="f1">'.$r['name_'.$lg].'</td>';
			 foreach ($usersArr as $k=> $doc ){
				$visitTot=getTotalCO('osc_x_visits_services'," d_start>='$d_s' and d_start<'$d_e' and  
				visit_id IN(select id from osc_x_visits where doctor='$k') and clinic='$osc_id' and status=1");

				$visitval=get_sum('osc_x_visits_services','total_pay'," d_start>='$d_s' and d_start<'$d_e' and 
				visit_id IN(select id from osc_x_visits where doctor='$k') and clinic='$osc_id' and status=1");
				$usersTotalArr[$k]['vis']+=$visitTot;
				$usersTotalArr[$k]['val']+=$visitval;
				$vT+=$visitTot;
				$cT+=$visitval;
				$rr.='<td><ff class="clr1">'.number_format($visitTot).'<ff></td>';
				$rr.='<td><ff class="clr6">'.number_format($visitval).'</ff></td>';
				if($visitTot || $visitval){$showRow=1;}
			}
			$rr.='<td fot><ff class="clr1">'.number_format($vT).'<ff></td>';
			$rr.='<td fot><ff class="clr6">'.number_format($cT).'</ff></td>';
			$rr.='</tr>';				
			if($showRow){echo $rr;}
			$vTt+=$vT;
			$cTt+=$cT;
		}
		echo '<tr fot>
		<td class="f1">'.k_total.'</td>';
		 foreach ($usersArr as $k=> $doc ){
			echo '<td><ff class="clr1">'.number_format($usersTotalArr[$k]['vis']).'<ff></td>';
			echo '<td><ff class="clr6">'.number_format($usersTotalArr[$k]['val']).'</ff></td>';
		}
		echo '<td><ff class="clr1">'.number_format($vTt).'<ff></td>';
		echo '<td><ff class="clr6">'.number_format($cTt).'</ff></td>';
		echo '</tr>';
		echo '</table>';
	}				
}
if($page==3){
	$cType=7;
	if($tab==0){
		echo reportNav($fil,1,$page,$tab,1,1,$page_mood);			
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$breakC;
	}
	if($tab==1){
		echo reportNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$d_s+($monLen*86400);		
	}		
	if($tab==2){
		echo reportNav($fil,3,$page,$tab,1,1,$page_mood);		
		$d_s=mktime(0,0,0,1,1,$selYear);
		$d_e=mktime(0,0,0,1,1,$selYear+1);	
	}
	if($tab==3){			
		$q='';	
		echo reportNav($fil,0,$page,$tab,1,1,$page_mood);
		$d_s=0;
		$d_e=$now+10;
	}		
	if($tab==4){
		echo reportNav($fil,4,$page,$tab,1,1,$page_mood);            			
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	echo $breakC;
	
	list($tecs_ids,$tecs_name)=get_vals('osc_m_team','id,name_'.$lg," type='$val' ",'arr');
	$sql="select id,name_$lg from osc_m_services order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$tecTot=array();
	if($rows){
		echo '<div class="f1 fs18 clr1 lh40">'.$oscTemeNames[$val].'</div>';
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr><th>'.k_service.'</th>';
			foreach($tecs_name as $name){echo '<th>'.$name.'</th>';}
			echo '<th>'.k_total.'</th>
		</tr>';		
		while($r=mysql_f($res)){						
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$row='<tr>
			<td class="f1 fs14">'.$name.'</td>';
			$srvTot=0;
			foreach($tecs_ids as $t_id){				
				$sql="select count(*)c from osc_x_visits_services vs , osc_x_visits_services_add vsa where 
				vs.id=vsa.id and vs.d_start>=$d_s and vs.d_start<$d_e and vs.service='$id' and vsa.".$oscTemeCols[$val]."=$t_id" ;
				$res2=mysql_q($sql);
				$r2=mysql_f($res2);
				$n=$r2['c'];
				$tecTot[$t_id]+=$n;
				$srvTot+=$n;
				$row.='<td><ff class="clr1">'.$n.'</ff></td>';
			}
			$row.='<td><ff class="clr6">'.number_format($srvTot).'</ff></td></tr>';
			if($srvTot){echo $row;}
		}
		echo '
		<tr fot>
		<td class="f1 fs14">'.k_total.'</td>';
		foreach($tecs_ids as $t_id){
			echo '<td><ff class="clr1">'.number_format($tecTot[$t_id]).'</ff></td>';
		}
		echo '<td><ff class="clr6">'.number_format(array_sum($tecTot)).'</ff></td>
		</tr></table>';
	}
}
/**************************************************/
if($page_mood==1){echo reportFooter();}?>