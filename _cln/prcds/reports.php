<? $repCode='cln';
$pageSize='print_page4';
/**************************************************/
$head=1;$breakC='^';$page_mood=0;
if(isset($_GET['mood'])){$page_mood=intval($_GET['mood']);}
if($page_mood==2){include("../../__sys/prcds/ajax_head_cFile.php");}else{include("../../__sys/prcds/ajax_header.php");}
reportStart($page_mood);
$report_kWord=k_repot;
$fin=1;//إظهار العلومات المالية
if($thisGrp=='o9yqmxot8'){//مجموعة التسويق
    $fin=0;
}
/*******Report Title*******************************/
if($page==1){
	$title1=' '.k_sers_info.' ';
}
if($page==2){
	$title1=' '.k_clinics.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}
	if($tab==3){$titleVal=reportTapTitle('all');}
	if($tab==4){$titleVal=reportTapTitle('date');}		
}
if($page==3){
	$title1='';
	if($tab==0){$title1=' '.k_clinics_services.' ';}
	if($tab==1){$title1=' '.k_clc_class_sers.' ';}
	if($tab==2){$title1=' '.k_static_sers_report.' ';}
}
/*******Export File Name***************************/
if($page==1){
	$fileName='cln_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRange';}
}	
if($page==2){
	$fileName='clinics_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
	if($tab==3){$fileName.='all';}
	if($tab==4){$fileName.='dateRang';}
}
if($page==3){
	$fileName='cln_srv_cat_';
	if($tab==0){$fileName.='dateRange';}
	if($tab==1){$fileName.='dateRange_cat';}
	if($tab==2){$fileName.='allRep';}
}
/**************************************************/
echo reportPageSet($page_mood,$fileName);
/**************************************************/
if($page==1){
	if($tab==0){
		$insurCompany=array();
		$sql="select * from gnr_m_insurance_prov order by name_$lg ASC";
		$res=mysql_q($sql);						
		while($r=mysql_f($res)){$insurCompany[$r['id']]=$r['name_'.$lg];}
		/***************************************/
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q=" where id='$val' ";}
		$sql="select * from gnr_m_clinics where type=1 order by name_$lg ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		while($r=mysql_f($res)){
			$clinic_id=$r['id'];
			$docs=array();
			$sql2="select * from _users  where subgrp='$clinic_id' order by name_$lg ASC";
			$res2=mysql_q($sql2);						
			while($r2=mysql_f($res2)){$docs[$r2['id']]=$r2['name_'.$lg];}
			/***************************************/
			echo '<div class="f1 fs18 clr1 lh40">'.$r['name_'.$lg].'</div>';				
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
			<th rowspan="3"width="30">#</th>					
			<th rowspan="3">الخدمة</th>
			<th rowspan="3">'.k_price.'</th>
			<th rowspan="3">'.k_the_time.'</th>
			<th rowspan="3">'.k_ratio.'</th>
			<th colspan="'.(count($docs)*3).'">'.k_custom_sett.'</th>
			<th  colspan="'.count($insurCompany).'">'.k_ins_prices.'</th>
			</tr>				
			<tr>';
			foreach($docs as $d =>$doc){
				echo '<th colspan="3">'.$doc.'</th>';
			}				
			foreach($insurCompany as $c => $comp){
				echo '<th rowspan="2">'.$comp.'</th>';
			}
			echo '</tr>								
			<tr>';
			foreach($docs as $d =>$doc){
				echo '<th>'.k_price.'</th>
				<th>'.k_the_time.'</th>
				<th>'.k_ratio.'</th>';
			}
			echo '</tr>';

			$sql2="select * from cln_m_services where clinic='$clinic_id' order by ord ASC";
			$res2=mysql_q($sql2);				
			while($r2=mysql_f($res2)){					
				$srv_id=$r2['id'];
				$srv_name=$r2['name_'.$lg];
				$hos_part=$r2['hos_part'];
				$doc_part=$r2['doc_part'];
				$s_time=$r2['ser_time']*_set_pn68gsh6dj;
				$totalPrice=$hos_part+$doc_part;
				$doc_percent=$r2['doc_percent'];
				$srv_id=$r2['id'];
				$srv_id=$r2['id'];
				echo '<tr>
				<td><ff>#'.$srv_id.'</ff></td>
				<td class="f1">'.$srv_name.'</td>
				<td><ff class="clr6">'.number_format($totalPrice).'</ff></td>
				<td><ff class="clr1">'.$s_time.'</ff></td>
				<td><ff class="clr5">'.$doc_percent.'%</ff></td>
				';
				foreach($docs as $d =>$doc){
					$d_Time_txt=$d_Price_txt=$d_per_txt='-';						
					$d_Time=get_val_con('cln_m_services_times','ser_time'," service='$srv_id' and doctor='$d' ");	
					list($hos_part,$doc_part,$doc_per)=get_val_con('gnr_m_services_prices','hos_part,doc_part,doc_percent'," service='$srv_id' and doctor='$d' ");

					$d_Price=$hos_part+$doc_part;
					if($d_Price){$d_Price_txt='<ff class="clr6">'.number_format($d_Price).'</ff>';}
					if($d_Time){$d_Time_txt='<ff class="clr1">'.($d_Time*_set_pn68gsh6dj).'</ff>';}
					if($doc_per){$d_per_txt='<ff class="clr5">'.($doc_per).'%</ff>';}
					echo '
					<td>'.$d_Price_txt.'</td>
					<td>'.$d_Time_txt.'</td>
					<td>'.$d_per_txt.'</td>';
				}					
				foreach($insurCompany as $c => $com){
					$com_Price_txt='-';
					$com_Price=get_val_con('gnr_m_insurance_prices','price'," service='$srv_id' and insur='$c' ");
					if($com_Price){$com_Price_txt='<ff class="clr1111">'.number_format($com_Price).'</ff>';}
					echo '<td>'.$com_Price_txt.'</td>';
				}
				echo '</tr>';
			}

			$sql2="select * from gnr_m_clinics where type=3 order by name_$lg ASC";
			$res2=mysql_q($sql2);
			$vTt=0;
			$cTt=0;
			while($r2=mysql_f($res2)){
				$vT=0;
				$cT=0;
				$showRow=0;
				$cln_id=$r['id'];
				$rr='<tr>
				<td class="f1">'.$r['name_'.$lg].'</td>';

				$rr.='<td fot><ff class="clr1">'.number_format($vT).'<ff></td>';
				$rr.='<td fot><ff class="clr6">'.number_format($cT).'</ff></td>';
				$rr.='</tr>';				
				if($showRow){echo $rr;}
				$vTt+=$vT;
				$cTt+=$cT;
			}				
			echo '</table>';
		}
	}
}
if($page==2){
	$cType=1;
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);			
		if($val==0){
			$d_s=$todyU;
			$d_e=$d_s+86400;
			$q='';
			$clArr=array();			
			echo $breakC;
			echo repTitleShow();
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
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$q2='';
		if($val){$q2=" and clinic='$val'";$add_title=get_val('gnr_m_clinics','name_'.$lg,$val);}
		echo $breakC;
		echo repTitleShow();		
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
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);
		$q='';
		if($val){$q2=" and clinic='$val'";$add_title=get_val('gnr_m_clinics','name_'.$lg,$val);}
		echo $breakC;
		echo repTitleShow();
		$t1=$t2=$t3=$t4=$t5=0;
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th width="30">'.k_month.'</th>
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
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);
		if($val){$q2=" and clinic='$val'";$add_title=get_val('gnr_m_clinics','name_'.$lg,$val);}
		echo $breakC;
		echo repTitleShow();
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
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);            			
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		if($d_s<$d_e){
			$q='';
			$clArr=array();
			echo $breakC;
			echo repTitleShow();
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
} 
if($page==3){
	$q1=$q2='';
	$ss=1;
	$ee=7;
	if($thisGrp=='im22ovq3jm'){
		$q=" and  type= $userSubType ";
		$q2=" where type= $userSubType ";
		$ss=$ee=$userSubType;
	}
	if($tab==0){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		if($val){
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_clinics','name_'.$lg,$val).'</div>';
		}
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr><?
			if($val){echo '<th rowspan="2">'.k_thmonth.'</th>';}else{echo '<th rowspan="2">'.k_tclinic.'</th>';}?>
			<th colspan="8"><?=k_visits?></th>             
			<th colspan="4"><?=k_services?></th>
            <? if($fin){?><th colspan="4"><?=k_financial?></th><?}?>
		</tr> 
		<tr>            	
			<th><?=k_tot_num?></th>
			<th><?=k_normal?></th>
			<th><?=k_exemption?></th>
			<th><?=k_charity?></th>
			<th><?=k_insurance?></th>
			<th><?=k_employee?></th>
			<th><?=k_unpaid?></th>
			<th><?=k_new_pats?></th>
			<th><?=k_tot_num?></th>
			<th><?=k_proced?></th>
			<th><?=k_preview?></th>
			<th><?=k_review?></th>
            <? if($fin){?>
			<th><?=k_val_srvs?></th>
			<th><?=k_monetary?></th>
			<th><?=k_thinsure?></th>
			<th><?=k_end_ratio?></th>
            <?}?>
		</tr>
		<?$pm0=$pm1=$pm2=$pm3=$pm4=$pm5=$pm6=$pm7=$pm8=$pm9=$pm10=$pm11=$pm12=$pm13=$pm14=$pm15=0;
		if($val){
			$startDate=get_val_con('gnr_r_clinic','date',"clinic='$val' $q"," order by date ASC");
			//date('U')
			$m=date('m',$startDate);
			$y=date('Y',$startDate);
			$t0=1;
			$chartData=array([],[],[],[]);
			$chartData['n']=array();
			while($t0!=0){
				$d_s=date("U",mktime(0,0,0,$m,1,$y));
				$d_e=date("U",mktime(0,0,0,$m+1,1,$y));
				$m++;
				/************************************/				
				$sql2="select 
				SUM(vis)t0 , 
				SUM(vis_free) t1 ,
				SUM(new_pat) t2 ,
				SUM(srv) t3 ,
				SUM(st0) t4 ,
				SUM(st1) t5 ,
				SUM(st2) t6 ,
				SUM(total) t7 ,
				SUM(pay_net) t8 ,
				SUM(pay_insur) t9 ,
				SUM(pt0) t11 ,
				SUM(pt1) t12 ,
				SUM(pt2) t13 ,
				SUM(pt3) t14 ,
				SUM(emplo) t15 

				from gnr_r_clinic where clinic='$val' and `date`>='$d_s' and `date`<'$d_e'   ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);

				$t0=$r2['t0'];
				$t1=$r2['t1'];
				$t2=$r2['t2'];
				$t3=$r2['t3'];
				$t4=$r2['t4'];
				$t5=$r2['t5'];
				$t6=$r2['t6'];
				$t7=$r2['t7'];
				$t8=$r2['t8'];
				$t9=$r2['t9'];
				$t11=$r2['t11'];
				$t12=$r2['t12'];
				$t13=$r2['t13'];
				$t14=$r2['t14'];
				$t15=$r2['t15'];
				$t8-=$t9;
				$t10=$t7-$t8;
				if($t0){
					array_push($chartData['n'],"'".date('Y-m',$d_s)."'");						
					array_push($chartData[0],$t0);
					array_push($chartData[1],$t11);
					array_push($chartData[2],$t14);
					array_push($chartData[3],$t13);

					$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;$pm5+=$t5;$pm6+=$t6;$pm7+=$t7;$pm8+=$t8;$pm9+=$t9;$pm10+=$t10;
					$pm11+=$t11;
					$pm12+=$t12;
					$pm13+=$t13;
					$pm14+=$t14;
					$pm15+=$t15;
					echo '<tr>
					<td><ff>'.date('Y-m',$d_s).'</ff></td>
					<td><ff class="clr6">'.number_format($t0).'</ff></td>

					<td><ff class="clr1">'.number_format($t11).'</ff></td>
					<td><ff class="clr1">'.number_format($t12).'</ff></td>
					<td><ff class="clr1">'.number_format($t13).'</ff></td>
					<td><ff class="clr1">'.number_format($t14).'</ff></td>
					<td><ff class="clr5">'.number_format($t15).'</ff></td>

					<td><ff class="clr5">'.number_format($t1).'</ff></td>
					<td><ff class="clr1">'.number_format($t2).'</ff></td>
					<td><ff class="clr6">'.number_format($t3).'</ff></td>
					<td><ff class="clr1">'.number_format($t4).'</ff></td>
					<td><ff class="clr1">'.number_format($t5).'</ff></td>
					<td><ff class="clr1">'.number_format($t6).'</ff></td>';
                    if($fin){
                        echo '<td><ff class="clr6">'.number_format($t7).'</ff></td>
                        <td><ff class="clr1">'.number_format($t8).'</ff></td>
                        <td><ff class="clr1">'.number_format($t10).'</ff></td>
                        <td><ff class="clr5">'.number_format($t9).'</ff></td>';
                    }
					echo '</tr>';
				}
				/***************************************/

				//$pm5=round($pm5,-1);
			}

		}else{
			$sql="select * from gnr_m_clinics $q2 order by name_$lg ASC";
			$res=mysql_q($sql);			
			while($r=mysql_f($res)){
				$c_id=$r['id'];				
				$cType=$r['type'];
				$cln_name=$r['name_'.$lg];
				/************************************/				
				$sql2="select 
				SUM(vis)t0 , 
				SUM(vis_free) t1 ,
				SUM(new_pat) t2 ,
				SUM(srv) t3 ,
				SUM(st0) t4 ,
				SUM(st1) t5 ,
				SUM(st2) t6 ,
				SUM(total) t7 ,
				SUM(pay_net) t8 ,
				SUM(pay_insur) t9 ,
				SUM(pt0) t11 ,
				SUM(pt1) t12 ,
				SUM(pt2) t13 ,
				SUM(pt3) t14 ,
				SUM(emplo) t15 

				from gnr_r_clinic where clinic='$c_id' and `date`>='$d_s' and `date`<'$d_e'   ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$t0=$r2['t0'];
				$t1=$r2['t1'];
				$t2=$r2['t2'];
				$t3=$r2['t3'];
				$t4=$r2['t4'];
				$t5=$r2['t5'];
				$t6=$r2['t6'];
				$t7=$r2['t7'];
				$t8=$r2['t8'];
				$t9=$r2['t9'];
				$t11=$r2['t11'];
				$t12=$r2['t12'];
				$t13=$r2['t13'];
				$t14=$r2['t14'];
				$t15=$r2['t15'];
				$t8-=$t9;
				$t10=$t7-$t8;
				if($t0){					
					$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;$pm5+=$t5;$pm6+=$t6;$pm7+=$t7;$pm8+=$t8;$pm9+=$t9;$pm10+=$t10;
					$pm11+=$t11;
					$pm12+=$t12;
					$pm13+=$t13;
					$pm14+=$t14;
					$pm15+=$t15;
					echo '<tr>
					<td txt>'.$cln_name.'</td>
					<td><ff class="clr6">'.number_format($t0).'</ff></td>

					<td><ff class="clr1">'.number_format($t11).'</ff></td>
					<td><ff class="clr1">'.number_format($t12).'</ff></td>
					<td><ff class="clr1">'.number_format($t13).'</ff></td>
					<td><ff class="clr1">'.number_format($t14).'</ff></td>
					<td><ff class="clr5">'.number_format($t15).'</ff></td>

					<td><ff class="clr5">'.number_format($t1).'</ff></td>
					<td><ff class="clr1">'.number_format($t2).'</ff></td>
					<td><ff class="clr6">'.number_format($t3).'</ff></td>
					<td><ff class="clr1">'.number_format($t4).'</ff></td>
					<td><ff class="clr1">'.number_format($t5).'</ff></td>
					<td><ff class="clr1">'.number_format($t6).'</ff></td>';
                    if($fin){
                        echo '<td><ff class="clr6">'.number_format($t7).'</ff></td>
                        <td><ff class="clr1">'.number_format($t8).'</ff></td>
                        <td><ff class="clr1">'.number_format($t10).'</ff></td>
                        <td><ff class="clr5">'.number_format($t9).'</ff></td>';
                    }
					echo '</tr>';
				}
				/***************************************/
			}
			//$pm5=round($pm5,-1);
		}
		echo '<tr fot >
			<td class="f1 fs14">'.k_total.'</td>
			<td><ff class="clr6">'.number_format($pm0).'</ff></td>

			<td><ff class="clr1">'.number_format($pm11).'</ff></td>
			<td><ff class="clr1">'.number_format($pm12).'</ff></td>
			<td><ff class="clr1">'.number_format($pm13).'</ff></td>
			<td><ff class="clr1">'.number_format($pm14).'</ff></td>
			<td><ff class="clr5">'.number_format($pm15).'</ff></td>					

			<td><ff class="clr5">'.number_format($pm1).'</ff></td>
			<td><ff class="clr1">'.number_format($pm2).'</ff></td>
			<td><ff class="clr6">'.number_format($pm3).'</ff></td>
			<td><ff class="clr1">'.number_format($pm4).'</ff></td>
			<td><ff class="clr1">'.number_format($pm5).'</ff></td>
			<td><ff class="clr1">'.number_format($pm6).'</ff></td>';
            if($fin){
			echo '<td><ff class="clr6">'.number_format($pm7).'</ff></td>
			<td><ff class="clr1">'.number_format($pm8).'</ff></td>
			<td><ff class="clr1">'.number_format($pm10).'</ff></td>
			<td><ff class="clr5">'.number_format($pm9).'</ff></td>';
            }
			echo '</tr>
			</table>';
		if($val){?>
			<script>
			$('.container').highcharts({


			xAxis: {
				categories:[<?=implode(',',$chartData['n'])?>]
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
			},

			series: [{
				name: k_visits,
				data: [<?=implode(',',$chartData[0])?>]
			}, {
				name: k_normal,
				data: [<?=implode(',',$chartData[1])?>]
			}, {
				name: k_insurance,
				data: [<?=implode(',',$chartData[2])?>]
			}, {
				name: k_associations,
				data: [<?=implode(',',$chartData[3])?>]

			}],

			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			}

		});
		</script>
		<div class="container" dir="ltr"></div>
		<?}else{?>
			
			
			<?	
		}
	}
	if($tab==1 && $thisGrp!='im22ovq3jm'){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th rowspan="2"><?=k_department?></th>						
			<th colspan="8"><?=k_visits?></th>             
			<th colspan="4"><?=k_services?></th>
            <? if($fin){?>
			<th colspan="4"><?=k_financial?></th>
            <?}?>
		</tr> 
		<tr>            	
			<th><?=k_tot_num?></th>
			<th><?=k_normal?></th>
			<th><?=k_exemption?></th>
			<th><?=k_charity?></th>
			<th><?=k_insurance?></th>
			<th><?=k_employee?></th>
			<th><?=k_unpaid?></th>
			<th><?=k_new_pats?></th>
			<th><?=k_tot_num?></th>
			<th><?=k_proced?></th>
			<th><?=k_preview?></th>
			<th><?=k_review?></th>
            <? if($fin){?>
			<th><?=k_val_srvs?></th>
			<th><?=k_monetary?></th>
			<th><?=k_thinsure?></th>
			<th><?=k_end_ratio?></th>
            <?}?>
		</tr>
		<?
		$pm0=$pm1=$pm2=$pm3=$pm4=$pm5=$pm6=$pm7=$pm8=$pm9=$pm10=$pm11=$pm12=$pm13=$pm14=$pm15=0;
		$sql="select * from gnr_m_clinics order by name_$lg ASC";
		$res=mysql_q($sql);			
		//while($r=mysql_f($res)){
		for($i=1;$i<8;$i++){
			$c_id=$r['id'];				
			$cType=$r['type'];
			$cln_name=$r['name_'.$lg];
			/************************************/				
			$sql2="select 
			SUM(vis)t0 , 
			SUM(vis_free) t1 ,
			SUM(new_pat) t2 ,
			SUM(srv) t3 ,
			SUM(st0) t4 ,
			SUM(st1) t5 ,
			SUM(st2) t6 ,
			SUM(total) t7 ,
			SUM(pay_net) t8 ,
			SUM(pay_insur) t9 ,
			SUM(pt0) t11 ,
			SUM(pt1) t12 ,
			SUM(pt2) t13 ,
			SUM(pt3) t14 ,
			SUM(emplo) t15 

			from gnr_r_clinic where type='$i' and `date`>='$d_s' and `date`<'$d_e'   ";
			$res2=mysql_q($sql2);
			$r2=mysql_f($res2);
			$t0=$r2['t0'];
			$t1=$r2['t1'];
			$t2=$r2['t2'];
			$t3=$r2['t3'];
			$t4=$r2['t4'];
			$t5=$r2['t5'];
			$t6=$r2['t6'];
			$t7=$r2['t7'];
			$t8=$r2['t8'];
			$t9=$r2['t9'];
			$t11=$r2['t11'];
			$t12=$r2['t12'];
			$t13=$r2['t13'];
			$t14=$r2['t14'];
			$t15=$r2['t15'];
			$t8-=$t9;
			$t10=$t7-$t8;
			if($t0){					
				$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;$pm5+=$t5;$pm6+=$t6;$pm7+=$t7;$pm8+=$t8;$pm9+=$t9;$pm10+=$t10;
				$pm11+=$t11;
				$pm12+=$t12;
				$pm13+=$t13;
				$pm14+=$t14;
				$pm15+=$t15;
				echo '<tr>
				<td txt>'.$clinicTypes[$i].'</td>
				<td><ff class="clr6">'.number_format($t0).'</ff></td>

				<td><ff class="clr1">'.number_format($t11).'</ff></td>
				<td><ff class="clr1">'.number_format($t12).'</ff></td>
				<td><ff class="clr1">'.number_format($t13).'</ff></td>
				<td><ff class="clr1">'.number_format($t14).'</ff></td>
				<td><ff class="clr5">'.number_format($t15).'</ff></td>

				<td><ff class="clr5">'.number_format($t1).'</ff></td>
				<td><ff class="clr1">'.number_format($t2).'</ff></td>
				<td><ff class="clr6">'.number_format($t3).'</ff></td>
				<td><ff class="clr1">'.number_format($t4).'</ff></td>
				<td><ff class="clr1">'.number_format($t5).'</ff></td>
				<td><ff class="clr1">'.number_format($t6).'</ff></td>';
                if($fin){
                    echo '<td><ff class="clr6">'.number_format($t7).'</ff></td>
                    <td><ff class="clr1">'.number_format($t8).'</ff></td>
                    <td><ff class="clr1">'.number_format($t10).'</ff></td>
                    <td><ff class="clr5">'.number_format($t9).'</ff></td>';
                }
				echo '</tr>';
			}
			/***************************************/
		}
		$pm5=round($pm5,-1);
		echo '<tr fot >
			<td class="f1 fs14">'.k_total.'</td>
			<td><ff class="clr6">'.number_format($pm0).'</ff></td>

			<td><ff class="clr1">'.number_format($pm11).'</ff></td>
			<td><ff class="clr1">'.number_format($pm12).'</ff></td>
			<td><ff class="clr1">'.number_format($pm13).'</ff></td>
			<td><ff class="clr1">'.number_format($pm14).'</ff></td>
			<td><ff class="clr5">'.number_format($pm15).'</ff></td>					

			<td><ff class="clr5">'.number_format($pm1).'</ff></td>
			<td><ff class="clr1">'.number_format($pm2).'</ff></td>
			<td><ff class="clr6">'.number_format($pm3).'</ff></td>
			<td><ff class="clr1">'.number_format($pm4).'</ff></td>
			<td><ff class="clr1">'.number_format($pm5).'</ff></td>
			<td><ff class="clr1">'.number_format($pm6).'</ff></td>';
            if($fin){
                echo '<td><ff class="clr6">'.number_format($pm7).'</ff></td>
                <td><ff class="clr1">'.number_format($pm8).'</ff></td>
                <td><ff class="clr1">'.number_format($pm10).'</ff></td>
                <td><ff class="clr5">'.number_format($pm9).'</ff></td>';
            }
			echo '</tr>
			</table>';				
	}
	if($tab==2){
		echo repoNav($fil,5,$page,$tab,1,1,$page_mood);
		//$d_s=strtotime($df);
		//$d_e=strtotime($dt)+86400;		
		echo $breakC;
		echo repTitleShow();
		for($i=$ss;$i<=$ee;$i++){?>
			<div class="f1 fs18 clr1 lh40"><?=$clinicTypes[$i]?></div>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>
				<th rowspan="2"><?=k_thmonth?></th>
				<th colspan="8"><?=k_visits?></th>             
				<th colspan="4"><?=k_services?></th>
                <? if($fin){?>
				<th colspan="4"><?=k_financial?></th>
                <? }?>
			</tr> 
			<tr>            	
				<th><?=k_tot_num?></th>
				<th><?=k_normal?></th>
				<th><?=k_exemption?></th>
				<th><?=k_charity?></th>
				<th><?=k_insurance?></th>
				<th><?=k_employee?></th>
				<th><?=k_unpaid?></th>
				<th><?=k_new_pats?></th>
				<th><?=k_tot_num?></th>
				<th><?=k_proced?></th>
				<th><?=k_preview?></th>
				<th><?=k_review?></th>
                <? if($fin){?>
				<th><?=k_val_srvs?></th>
				<th><?=k_monetary?></th>
				<th><?=k_postpaid?></th>
				<th><?=k_end_ratio?></th>
                <? }?>
			</tr>

			<?
			$pm0=$pm1=$pm2=$pm3=$pm4=$pm5=$pm6=$pm7=$pm8=$pm9=$pm10=$pm11=$pm12=$pm13=$pm14=$pm15=0;
			$startDate=get_val_con('gnr_r_clinic','date',"type='$i'"," order by date ASC");
			//date('U')
			$m=date('m',$startDate);
			$y=date('Y',$startDate);
			$t0=1;
			$chartData=array([],[],[],[]);
			$chartData['n']=array();
			while($t0!=0){
				$d_s=date("U",mktime(0,0,0,$m,1,$y));
				$d_e=date("U",mktime(0,0,0,$m+1,1,$y));
				$m++;
				/************************************/				
				$sql2="select 
				SUM(vis)t0 , 
				SUM(vis_free) t1 ,
				SUM(new_pat) t2 ,
				SUM(srv) t3 ,
				SUM(st0) t4 ,
				SUM(st1) t5 ,
				SUM(st2) t6 ,
				SUM(total) t7 ,
				SUM(pay_net) t8 ,
				SUM(pay_insur) t9 ,
				SUM(pt0) t11 ,
				SUM(pt1) t12 ,
				SUM(pt2) t13 ,
				SUM(pt3) t14 ,
				SUM(emplo) t15 

				from gnr_r_clinic where type='$i' and `date`>='$d_s' and `date`<'$d_e'   ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);

				$t0=$r2['t0'];
				$t1=$r2['t1'];
				$t2=$r2['t2'];
				$t3=$r2['t3'];
				$t4=$r2['t4'];
				$t5=$r2['t5'];
				$t6=$r2['t6'];
				$t7=$r2['t7'];
				$t8=$r2['t8'];
				$t9=$r2['t9'];
				$t11=$r2['t11'];
				$t12=$r2['t12'];
				$t13=$r2['t13'];
				$t14=$r2['t14'];
				$t15=$r2['t15'];
				$t8-=$t9;
				$t10=$t7-$t8;
				if($t0){
					array_push($chartData['n'],"'".date('Y-m',$d_s)."'");						
					array_push($chartData[0],$t0);
					array_push($chartData[1],$t11);
					array_push($chartData[2],$t14);
					array_push($chartData[3],$t13);

					$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;$pm5+=$t5;$pm6+=$t6;$pm7+=$t7;$pm8+=$t8;$pm9+=$t9;$pm10+=$t10;
					$pm11+=$t11;
					$pm12+=$t12;
					$pm13+=$t13;
					$pm14+=$t14;
					$pm15+=$t15;
					echo '<tr>
					<td><ff>'.date('Y-m',$d_s).'</ff></td>
					<td><ff class="clr6">'.number_format($t0).'</ff></td>

					<td><ff class="clr1">'.number_format($t11).'</ff></td>
					<td><ff class="clr1">'.number_format($t12).'</ff></td>
					<td><ff class="clr1">'.number_format($t13).'</ff></td>
					<td><ff class="clr1">'.number_format($t14).'</ff></td>
					<td><ff class="clr5">'.number_format($t15).'</ff></td>

					<td><ff class="clr5">'.number_format($t1).'</ff></td>
					<td><ff class="clr1">'.number_format($t2).'</ff></td>
					<td><ff class="clr6">'.number_format($t3).'</ff></td>
					<td><ff class="clr1">'.number_format($t4).'</ff></td>
					<td><ff class="clr1">'.number_format($t5).'</ff></td>
					<td><ff class="clr1">'.number_format($t6).'</ff></td>';
                    if($fin){
                        echo '<td><ff class="clr6">'.number_format($t7).'</ff></td>
                        <td><ff class="clr1">'.number_format($t8).'</ff></td>
                        <td><ff class="clr1">'.number_format($t10).'</ff></td>
                        <td><ff class="clr5">'.number_format($t9).'</ff></td>';
                    }
					echo '</tr>';
				}
				/***************************************/				
			}
			?>
			</table>
			<div class="container<?=$i?>" dir="ltr"></div><?
		}
	}
	if($tab==3){
		echo $breakC;		
		for($i=$ss;$i<=$ee;$i++){			
			$startDate=get_val_con('gnr_r_clinic','date',"type='$i'"," order by date ASC");			
			$m=date('m',$startDate);
			$y=date('Y',$startDate);
			$t1=1;
			$chartData=array([],[],[],[]);
			$chartData['n']=array();
			while($t1!=0){
				$d_s=date("U",mktime(0,0,0,$m,1,$y));
				$d_e=date("U",mktime(0,0,0,$m+1,1,$y));
				$m++;
				/************************************/				
				$sql2="select 
				SUM(vis) t1 ,	
				SUM(pt0) t2 ,
				SUM(pt2) t3 ,
				SUM(pt3) t4 
				from gnr_r_clinic where type='$i' and `date`>='$d_s' and `date`<'$d_e'   ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$t1=$r2['t1'];
				$t2=$r2['t2'];				
				$t3=$r2['t3'];
				$t4=$r2['t4'];				
				if($t1){
					array_push($chartData['n'],"'".date('Y-m',$d_s)."'");						
					array_push($chartData[0],$t1);
					array_push($chartData[1],$t2);
					array_push($chartData[2],$t4);
					array_push($chartData[3],$t3);
				}
				/***************************************/				
			}?>
			<script>
				$('.container<?=$i?>').highcharts({
				 title: {
					text: '<?=$clinicTypes[$i]?>'
				},
				xAxis: {
					categories:[<?=implode(',',$chartData['n'])?>]
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},

				series: [{
					name: k_visits,
					data: [<?=implode(',',$chartData[0])?>]
				}, {
					name: k_normal,
					data: [<?=implode(',',$chartData[1])?>]
				}, {
					name: k_insurance,
					data: [<?=implode(',',$chartData[2])?>]
				}, {
					name: k_associations,
					data: [<?=implode(',',$chartData[3])?>]

				}],

				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {
							legend: {
								layout: 'horizontal',
								align: 'center',
								verticalAlign: 'bottom'
							}
						}
					}]
				}

			});
			</script>
			<div class="container<?=$i?>" dir="ltr"></div><?
		}
	}
	if($tab==4 && $fin){
		echo $breakC;
		for($i=$ss;$i<=$ee;$i++){			
			$startDate=get_val_con('gnr_r_clinic','date',"type='$i'"," order by date ASC");			
			$m=date('m',$startDate);
			$y=date('Y',$startDate);
			$t1=1;
			$chartData=array([],[],[],[]);
			$chartData['n']=array();
			while($t1!=0){
				$d_s=date("U",mktime(0,0,0,$m,1,$y));
				$d_e=date("U",mktime(0,0,0,$m+1,1,$y));
				$m++;
				/************************************/				
				$sql2="select 
				SUM(total) t1 ,
				SUM(pay_net) t2 ,
				SUM(pay_insur) t3
				from gnr_r_clinic where type='$i' and `date`>='$d_s' and `date`<'$d_e'   ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$t1=$r2['t1'];
				$t2=$r2['t2'];
				$t3=$r2['t3'];				
				$t2-=$t3;
				$t4=$t1-$t2;
				if($t1){
					array_push($chartData['n'],"'".date('Y-m',$d_s)."'");
					array_push($chartData[0],$t1);
					array_push($chartData[1],$t2);
					array_push($chartData[2],$t4);
					array_push($chartData[3],$t3);
				}
				/***************************************/				
			}
			?>			
			<script>
				$('.container<?=$i?>').highcharts({
				 title: {
					text: '<?=$clinicTypes[$i]?>'
				},
				xAxis: {
					categories:[<?=implode(',',$chartData['n'])?>]
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},

				series: [{
					name: k_val_srvs,
					data: [<?=implode(',',$chartData[0])?>]
				}, {
					name: k_monetary,
					data: [<?=implode(',',$chartData[1])?>]
				}, {
					name: k_insurance,
					data: [<?=implode(',',$chartData[2])?>]
				}, {
					name: k_end_ratio,
					data: [<?=implode(',',$chartData[3])?>]
				}],

				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {
							legend: {
								layout: 'horizontal',
								align: 'center',
								verticalAlign: 'bottom'
							}
						}
					}]
				}
			});
			</script>
			<div class="container<?=$i?> chartCon" dir="ltr"></div><?

		}
	}
}
/**************************************************/
if($page_mood==1){echo reportFooter();}?>