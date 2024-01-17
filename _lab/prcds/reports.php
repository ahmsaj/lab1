<? $repCode='lab';
$pageSize='print_page4';
/**************************************************/
$head=1;$breakC='^';$page_mood=0;
if(isset($_GET['mood'])){$page_mood=intval($_GET['mood']);}
if($page_mood==2){include("../../__sys/prcds/ajax_head_cFile.php");}else{include("../../__sys/prcds/ajax_header.php");}
reportStart($page_mood);
$report_kWord='';
/*******Report Title*******************************/
if($page==1){
	$title1=' '.k_lab.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==32){$titleVal=reportTapTitle('date');}
	if($tab==3){$title1=' '.k_ext_anlyz_revenu.' ';$titleVal=reportTapTitle('month');}	
	if($tab==4){$titleVal=reportTapTitle('month');}
	if($tab==5){$titleVal=reportTapTitle('date');}
}
if($page==2){
	$head=0;
	$pageSize='print_page4W';
	$title1=' CBC ';
	if($tab==0){$titleVal=reportTapTitle('day');}	
}
if($page==3){
	$title1=' '.k_lab.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
}
if($page==4){
	$title1=' '.k_outlabs_fin.' ';
	if(in_array($tab,array(5,6,7,8,9,10))){$title1=k_tests_account_stats;}
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==3){$titleVal=reportTapTitle('month',k_mth_tol);}	
	if($tab==2){$titleVal=reportTapTitle('date');}
	if($tab==4){$titleVal=reportTapTitle('date');}
	if($tab==5){$titleVal=reportTapTitle('month');}
	if($tab==6){$titleVal=reportTapTitle('date');}
	if($tab==7){$titleVal=reportTapTitle('month');}
	if($tab==8){$titleVal=reportTapTitle('date');}
	if($tab==9){$titleVal=reportTapTitle('month');}
	if($tab==10){$titleVal=reportTapTitle('date');}
	if(in_array($tab,array(5,6,7,8,9,10))){
		$info_title=get_val('lab_m_external_labs','name_'.$lg,$val);
		$header='<div class="f1 fs18 lh60 uLine">'.$info_title.'</div>';
		$report_kWord='';
		$title3=' '.k_mwasat_benefit.'   ';
	}
}
/*******Export File Name*******************************/		
if($page==1){
	$fileName='lab_';
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}								
	if($tab==2){$fileName.='dateRang';}
	if($tab==3){$fileName.='month2';}
	if($tab==4){$fileName.='monthTotal';}
	if($tab==2){$fileName.='dateRangTotal';}
}
if($page==2){
	$fileName='labCBC';					
}
if($page==3){
	$fileName='lab_';
	if($tab==0){$fileName.='day';}
}
if($page==4){
	$fileName='labOut_';				
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
	if($tab==3){$fileName.='monthTotal';}
	if($tab==4){$fileName.='total';}
	if($tab==5){$fileName.='monthCash';}
	if($tab==6){$fileName.='monthAna';}
	if($tab==7){$fileName.='monthCash';}
	if($tab==8){$fileName.='monthAna';}
	if($tab==9){$fileName.='monthCash';}
	if($tab==10){$fileName.='monthAna';}				
}
/**************************************************/
echo reportPageSet($page_mood,$fileName);
/**************************************************/
if($page==1){		
	if($tab==999900000){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);			
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$sql="select * , xs.id as xs_id from lab_x_visits_services xs , lab_x_visits x where x.id=xs.visit_id 
		 and x.d_start>'$d_s' and x.d_start < '$d_e' order by xs.id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo $breakC;
		if($rows>0){
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th width="20"><?=k_num_serv?></th>
				<th><?=k_patient?></th>            
				<th><?=k_analysis?></th>
				<th><?=k_amount?></th>  
				<th><?=k_discount?></th>
				<th><?=k_net_amount?></th>                        
			</tr><?
			$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;                    
			while($r=mysql_f($res)){
				$s_id=$r['xs_id'];
				$patient=$r['patient'];
				$units=$r['units'];
				$units_price=$r['units_price'];
				$price=$units*$units_price;
				$pay_net=$r['pay_net'];
				$service=$r['service'];
				$dis=$price-$pay_net;					
				$t1+=$price;$t2+=$dis;$t3+=$pay_net;
				echo '<tr>
				<td><ff>'.$s_id.'</ff></td>
				<td class="f1 fs14">'.get_p_name($patient).'</td>
				<td class="f1 fs14">'.get_val('lab_m_services','name_'.$lg,$service).'</td>
				<td><ff>'.number_format($price).'</ff></td>
				<td><ff>'.number_format($dis).'</ff></td>
				<td><ff>'.number_format($pay_net).'</ff></td>
				</tr>';
			}

			echo '<tr fot>
			<td colspan="3" class="f1 fs14">'.k_total.'</td>
			<td><ff>'.number_format($t1).'</ff></td>
			<td><ff>'.number_format($t2).'</ff></td>
			<td><ff>'.number_format($t3).'</ff></td>
			';
			?></table><?
		}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}            
	}
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);			
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$sql="select * from lab_x_visits where  d_start>'$d_s' and d_start < '$d_e' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo $breakC;
		echo repTitleShow();
		if($rows>0){?>			
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th width="60"><?=k_visit_num?></th>
				<th><?=k_patient?></th>	
				<th><?=k_tests_val?></th>
				<th><?=k_payms?></th>
				<th><?=k_insure_val?></th>					
				<th><?=k_visit_balance?></th>					
			</tr><?
			$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;                    
			while($r=mysql_f($res)){
				$id=$r['id'];
				$patient=$r['patient'];
				$t_servs=$r['t_servs'];
				$t_payments=$r['t_payments'];					
				$t_insur=$r['t_insur'];
				$t_balans=$r['t_balans'];					
				$t1+=$t_servs;$t2+=$t_payments;$t3+=$t_insur;$t4+=$t_balans;
				echo '<tr>
				<td><ff>'.$id.'</ff></td>
				<td class="f1 fs14">'.get_p_name($patient).'</td>					
				<td><ff class="clr1111">'.number_format($t_servs).'</ff></td>
				<td><ff class="clr6">'.number_format($t_payments).'</ff></td>
				<td><ff class="clr1">'.number_format($t_insur).'</ff></td>
				<td><ff class="clr5">'.number_format($t_balans).'</ff></td>
				</tr>';
			}

			echo '<tr fot>
			<td colspan="2" class="f1 fs14">'.k_total.'</td>
			<td><ff class="clr1111">'.number_format($t1).'</ff></td>
			<td><ff class="clr6">'.number_format($t2).'</ff></td>
			<td><ff class="clr1">'.number_format($t3).'</ff></td>
			<td><ff class="clr5">'.number_format($t4).'</ff></td>
			</tr>
			';
			?></table><?
		}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}            
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);			
		$q3="";?><?=$breakC?>
		<?=repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_tday?></th>
			<th><?=k_num_pats?></th>
			<th><?=k_tests_val?></th>
			<th><?=k_payms?></th>
			<th><?=k_insure_val?></th>					
			<th><?=k_visit_balance?></th>
		</tr>  
		<?
		$t0=$t1=$t2=$t3=$t4=0;

		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;				
			$p_no=getTotalCO('lab_x_visits'," d_start>'$d_s' and d_start < '$d_e' $q3 ");
			$t_servs=get_sum('lab_x_visits','t_servs'," d_start>'$d_s' and d_start < '$d_e' ");
			$t_payments=get_sum('lab_x_visits','t_payments'," d_start>'$d_s' and d_start < '$d_e' ");
			$t_insur=get_sum('lab_x_visits','t_insur'," d_start>'$d_s' and d_start < '$d_e' ");
			$t_balans=get_sum('lab_x_visits','t_balans'," d_start>'$d_s' and d_start < '$d_e' ");

			$t0+=$p_no;$t1+=$t_servs;$t2+=$t_payments;$t3+=$t_insur;$t4+=$t_balans;
			if($p_no){
				echo '<tr>					
				<td><div class="ff fs18 B txt_Over" onclick="loadReport('.$page.',0,'.$d_s.')">'.($ss+1).'</div></td>
				<td><ff class="clr2">'.number_format($p_no).'</ff></td>
				<td><ff class="clr1111">'.number_format($t_servs).'</ff></td>
				<td><ff class="clr6">'.number_format($t_payments).'</ff></td>
				<td><ff class="clr1">'.number_format($t_insur).'</ff></td>
				<td><ff class="clr5">'.number_format($t_balans).'</ff></td>
				</tr>';
			}
		}
		echo '<tr fot>
		<td class="f1 fs14">'.k_total.'</td>
		<td><ff class="clr2">'.number_format($t0).'</ff></td>
		<td><ff class="clr1111">'.number_format($t1).'</ff></td>
		<td><ff class="clr6">'.number_format($t2).'</ff></td>
		<td><ff class="clr1">'.number_format($t3).'</ff></td>
		<td><ff class="clr5">'.number_format($t4).'</ff></td>
		<tr>';?>
		</table><?		
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		echo $breakC;		
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo repTitleShow();
		if($d_s<$d_e){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
			<th><?=k_clinic?></th>
			<th><?=k_receipts?></th>            
			<th><?=k_dscrds?></th>
			<th><?=k_balance?></th>
			<th><?=k_vis_no?></th>
			</tr><?				
			$c_id=get_val_c('gnr_m_clinics','id',2,'type');
			$name=get_val('gnr_m_clinics','name_'.$lg,$c_id);
			$q2=" and vis IN(select id from lab_x_visits )";
			$in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2) and date >= '$d_s' and date < '$d_e' and mood=2  $q2");				
			$out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4) and date >= '$d_s' and date < '$d_e' and mood=2 $q2");
			$p_no=getTotalCO('lab_x_visits',"d_start >= '$d_s' and d_start < '$d_e' ");

			echo '<tr>
			<td class="f1 fs14">'.$name.'</td>
			<td><ff class="clr6">'.number_format($in).'</ff></td>
			<td><ff class="clr5">'.number_format($out).'</ff></div></td>
			<td><ff class="clr1">'.number_format($in-$out).'</ff></td>


			<td><ff>'.number_format($p_no).'</ff></td>
			</tr>';				
			?></table><?
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}

	}
	if($tab==3){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);?>  
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?>
		<?=repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_date?></th>                 
			<th><?=k_tday?></th>
			<th><?=k_lab_pricing?></th>
			 <th><?=k_hsp_rvnu?></th>
		</tr><?
		$count_all=0; $sum_all=0; $total_pay_all=0;        
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			$count_of_ana1=getTotalCO('lab_x_visits_services_outlabs'," date_send>='$d_s' and date_send < '$d_e' ");
			$sum_of_price1=get_sum('lab_x_visits_services_outlabs','lab_price'," date_send >= '$d_s' and date_send < '$d_e'");
			$sum_of_pay1=get_sum('lab_x_visits_services_outlabs','price'," date_send >= '$d_s' and date_send < '$d_e' ");

			$count_of_ana2=getTotalCO('lab_x_receipt_items'," reciept_date>='$d_s' and reciept_date < '$d_e' ");
			$sum_of_price2=get_sum('lab_x_receipt_items','lab_price'," reciept_date >= '$d_s' and reciept_date < '$d_e'  ");
			$sum_of_pay2=get_sum('lab_x_receipt_items','price'," reciept_date >= '$d_s' and reciept_date < '$d_e'  ");

			$count_of_ana=$count_of_ana1+$count_of_ana2;
			$sum_of_price=$sum_of_price1+$sum_of_price2;
			$sum_of_pay=$sum_of_pay1+$sum_of_pay2;

			$count_all+=$count_of_ana;
			$sum_all+=$sum_of_price;
			$total_pay_all+=$sum_of_pay;

			if($count_of_ana || $sum_of_price ){?>
				<tr><td><div class="ff fs18 B " ><?=date('Y-m-d',$d_s)?></div></td>				
				<td><ff class=""><?=$wakeeDays[date('w', strtotime(date('Y-m-d',$d_s)))]?></ff></td>
				<td><ff class=""><?=number_format($sum_of_price)?></ff></td>
				<td><ff class=""><?=number_format($sum_of_pay)?></ff></td>
				</tr><?
			}
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1">-</ff></td>
			<td><ff class="clr1"><?=number_format($sum_all)?></ff></td>
			<td><ff class="clr1"><?=number_format($total_pay_all)?></ff></td>                 
		</tr>
		</table>
		<?
		$reange1=0;
		if($total_pay_all){
			$reange1=($sum_all/$total_pay_all)*100;
		}
		$reange2=100-$reange1;
		?>
		<table border="0" cellpadding="10" cellspacing="0">

		<tr>
		<td class="f1 fs16" style="border-bottom:1px #000 solid"><?=k_bridge_lab_fees?></td>
		<td rowspan="2" class="fs18">=</td>
		<td style="border-bottom:1px #000 solid"><ff><?=number_format($sum_all)?></ff></td>
		<td rowspan="2" class="fs18">=</td>
		<td rowspan="2"><ff><?=number_format($reange1,2)?> %</ff></td>
		<td rowspan="2" class="fs18">&raquo;</td>
		<td rowspan="2" class="clr6 fs14 f1"><ff class="clr6"><?=number_format($reange2,2)?> %</ff> <?=k_gain?></td>

		</tr>
		<tr>
		<td class="f1 fs16"><?=k_tot_rev?></td>
		<td><ff><?=number_format($total_pay_all)?></ff></td>
		</tr>
		</table>


		<?
	}
	if($tab==4){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?><?
		echo repTitleShow();
		$d_s=$mm;		
        $d_e=$d_s+(($monLen)*86400);
		$servics_arr=array();
		$sql="select * , xs.id as xs_id from lab_x_visits_services xs , lab_x_visits x where x.id=xs.visit_id 
		and x.d_start>'$d_s' and x.d_start < '$d_e' and xs.status !=3 order by xs.id ASC";      
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){				
			$total=0;
			while($r=mysql_f($res)){										
				$status=$r['status'];
				$price=$r['units']*$r['units_price'];
				$service=$r['service'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$price;
				$total+=$price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>

		</tr>  
		<?
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>                 
		</tr>
		</table><?
	}
	if($tab==5){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?><?
		echo repTitleShow();
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		$servics_arr=array();
		$sql="select * , xs.id as xs_id from lab_x_visits_services xs , lab_x_visits x where x.id=xs.visit_id 
		and x.d_start>'$d_s' and x.d_start < '$d_e' and xs.status !=3 order by xs.id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){				
			$total=0;
			while($r=mysql_f($res)){										
				$status=$r['status'];
				$price=$r['units']*$r['units_price'];
				$service=$r['service'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$price;
				$total+=$price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>
		</tr><?
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>                 
		</tr>
		</table><?
	}
	if($tab==6){			
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);?>		
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?><?
		echo repTitleShow();
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;

		$sql="select * from lab_x_visits where  d_start>'$d_s' and d_start < '$d_e' and t_balans>0 order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th width="60"><?=k_visit_num?></th>
				<th><?=k_date?></th>
				<th><?=k_patient?></th>	
				<th><?=k_tests_val?></th>
				<th><?=k_payms?></th>
				<th><?=k_insure_val?></th>					
				<th><?=k_visit_balance?></th>					
			</tr><?
			$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;                    
			while($r=mysql_f($res)){
				$id=$r['id'];
				$patient=$r['patient'];
				$t_servs=$r['t_servs'];
				$t_payments=$r['t_payments'];
				$d_start=$r['d_start'];
				$t_insur=$r['t_insur'];
				$t_balans=$r['t_balans'];					
				$t1+=$t_servs;$t2+=$t_payments;$t3+=$t_insur;$t4+=$t_balans;
				echo '<tr>
				<td><ff>'.$id.'</ff></td>
				<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
				<td class="f1 fs14">'.get_p_name($patient).'</td>					
				<td><ff class="clr1111">'.number_format($t_servs).'</ff></td>
				<td><ff class="clr6">'.number_format($t_payments).'</ff></td>
				<td><ff class="clr1">'.number_format($t_insur).'</ff></td>
				<td><ff class="clr5">'.number_format($t_balans).'</ff></td>
				</tr>';
			}

			echo '<tr fot>
			<td colspan="3" class="f1 fs14">'.k_total.'</td>
			<td><ff class="clr1111">'.number_format($t1).'</ff></td>
			<td><ff class="clr6">'.number_format($t2).'</ff></td>
			<td><ff class="clr1">'.number_format($t3).'</ff></td>
			<td><ff class="clr5">'.number_format($t4).'</ff></td>
			</tr>
			';
			?></table><?
		}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}
	}
}
if($page==2){	
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);					
		$sql="select id,patient,sample_link from lab_x_visits_services where service=158 and date_enter>='$d_s' and date_enter < '$d_e' order by date_enter ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo $breakC;
		echo repTitleShow();
		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th width="30">#</th>                    
				<th><?=k_patient?></th>
				<th><?=k_sample?></th>
				<th>RBC</th>                      
				<th>HGB</th>
				<th>HCT</th>
				<th>MCV</th>
				<th>MCH</th>
				<th>MCHC</th>
				<th>WBC</th>
				<th>NEU%</th>
				<th>LYM%</th>
				<th>MONO%</th>
				<th>ESO%</th>
				<th>BASO%</th>
				<th>PLT</th>
				<th>MPV</th>
			</tr>
			<?
			$i=1;				
			while($r=mysql_f($res)){
				$resArr=array();
				$s_id=$r['id'];
				$patient=$r['patient'];
				$sample_link=$r['sample_link'];
				$sql2="select * from lab_x_visits_services_results where serv_id='$s_id'";
				$res2=mysql_q($sql2);
				$rows2=mysql_n($res2);
				if($rows2>0){
					while($r2=mysql_f($res2)){
						$serv_val_id=$r2['serv_val_id'];
						$serv_type=$r2['serv_type'];
						$value=$r2['value'];
						$normal_val=$r2['normal_val'];
						$status=$r2['status'];
						$resArr[$serv_val_id]=$value;
					}
				}
				echo '
				<tr>
				<td><ff>'.$i.'</ff></td>					
				<td class="f1 fs14">'.get_p_name($patient).'</td>
				<td><ff>'.get_val('lab_x_visits_samlpes','no',$sample_link).'</ff></td>
				<td><ff>'.$resArr[161].'</ff></td>					               
				<td><ff>'.$resArr[495].'</ff></td>
				<td><ff>'.$resArr[496].'</ff></td>
				<td><ff>'.$resArr[498].'</ff></td>
				<td><ff>'.$resArr[499].'</ff></td>
				<td><ff>'.$resArr[497].'</ff></td>
				<td><ff>'.$resArr[500].'</ff></td>
				<td><ff>'.$resArr[501].'</ff></td>
				<td><ff>'.$resArr[503].'</ff></td>
				<td><ff>'.$resArr[505].'</ff></td>
				<td><ff>'.$resArr[507].'</ff></td>
				<td><ff>'.$resArr[509].'</ff></td>
				<td><ff>'.$resArr[512].'</ff></td>
				<td><ff>'.$resArr[618].'</ff></td>
				</tr>';
				$i++;
				unset($resArr);
			}
			echo '</table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_no_tests_tdy.'</div>';}

	}
	if($tab==2){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);?>            
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?=$breakC?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th>
			<th><?=k_clinics?></th>    
			<th><?=k_thlab?></th>
			<th><?=k_txry?></th>
			<th><?=k_cards?></th>
			<th><?=k_total?></th>		
		</tr>  
		<?
		$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;          
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			$a_1=$a_2=$a_3=$card=$all='';
			$sql2="select SUM(a1_in-a1_out) a1, SUM(a2_in-a2_out) a2, SUM(a3_in-a3_out) a3, SUM(card)card from gnr_r_cash where date >= '$d_s' and date < '$d_e'  limit 1";
			$res2=mysql_q($sql2);
			if($res2){
				$r2=mysql_f($res2);
				$a_1=$r2['a1'];
				$a_2=$r2['a2'];
				$a_3=$r2['a3'];
				$card=$r2['card'];
				$all=$a_1+$a_2+$a_3+$card;
			}				
			$pm1+=$a_1;$pm2+=$a_2;$pm3+=$a_3;$pm4+=$card;$pm5+=$all;
			if($a_1 || $a_2||$a_3||$card){?>           
				<tr><td><div class="ff fs18 B txt_Over" onclick="loadReport(<?=$page?>,1,<?=$d_s?>)"><?=($ss+1)?></div></td>    
				<td><ff class=""><?=number_format($a_1)?></ff></td>
				<td><ff class=""><?=number_format($a_2)?></ff></td>
				<td><ff class=""><?=number_format($a_3)?></ff></td>  
				<td><ff class=""><?=number_format($card)?></ff></td>     
				<td><ff class="clr1"><?=number_format($all)?></ff></td>
				</tr><?	
			}
		}
		$cash_in=$pm1+$pm2+$pm5;
		$cash_out=$pm3+$pm4;
		$cash_net=$cash_in-$cash_out;?> 
		<tr fot>
			<td class="f1 fs14"><?=k_ggre?></td>    
			<td><ff class=""><?=number_format($pm1)?></ff></td>
			<td><ff class=""><?=number_format($pm2)?></ff></td> 
			<td><ff class=""><?=number_format($pm3)?></ff></td>                    
			<td><ff class=""><?=number_format($pm4)?></ff></td>                
			<td><ff class="clr1"><?=number_format($pm5)?></ff></td>                
		</tr>
		</table><?		
	}
}
if($page==3){	
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);			
		$d_s=$todyU;
		$d_e=$d_s+86400;
		echo $breakC;
		$q='';
		if($val){			
			$q=" and status='$val' ";
			$tot=getTotalCO('lab_x_visits_services',"d_start>'$d_s' and d_start < '$d_e' $q");
			echo '<div class="f1 fs16 lh40 clr1 uLine">'.k_status.' : '.$anStatus[$val].' <ff> ( '.$tot.' )</ff></div>';
		}else{
			$tot=getTotalCO('lab_x_visits_services',"d_start>'$d_s' and d_start < '$d_e' $q");
			echo '<div class="f1 fs16 lh40 clr1 uLine">'.k_tests.' : <ff> ( '.$tot.' )</ff></div>';
		}
		$sql="select * from lab_x_visits_services where  d_start>'$d_s' and d_start < '$d_e' $q order by visit_id  ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		
		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th width="30"></th>
				<th width="60"><?=k_visit_num?></th>				
				<th><?=k_patient?></th>	
				<th width="30">#</th>
				<th><?=k_tests?></th>				
				<th><?=k_status?></th>					
				<th width="30"></th>					
			</tr><?			
			$i=1;
			$actVis=0;
			while($r=mysql_f($res)){
				$id=$r['id'];
				$vis=$r['visit_id'];
				$patient=$r['patient'];
				$service=$r['service'];
				$status=$r['status'];
				$srvTxt=get_val_arr('lab_m_services','short_name',$service,'s');
				
				$print='';
				$printVis='';
				if(in_array($status,array(1,8,10))){
					$print='<div class="ic40 icc1 ic40_print fr" onclick="printLabRes(1,'.$id.')"></div>';
				}
				
				echo '<tr>';
				if($actVis!=$vis){
					$t=getTotalCO('lab_x_visits_services',"visit_id='$vis' $q");
					$visStatus=get_val('lab_x_visits','status',$vis);
					if(!in_array($visStatus,array(0,3))){
						$printVis='<div class="ic40 icc2 ic40_print fr" onclick="customPrint('.$vis.')"></div>';
					}
					echo '<td rowspan="'.$t.'">'.$printVis.'</td>
					<td rowspan="'.$t.'"><ff>'.$vis.'</ff></td>
					<td rowspan="'.$t.'" class="f1 fs14">'.get_p_name($patient).'</td>';
					$actVis=$vis;
				}
				
				echo '
				<td><ff>'.$i.'</ff></td>
				<td><ff>'.$srvTxt.'</ff></td>
				<td class="f1">'.$anStatus[$status].'</td>
				<td>'.$print.'</td>
				</tr>';
				$i++;
			}
			?></table><?
		}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}            
	}	
}
if($page==4){
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$q="";
		echo $breakC;
		echo repTitleShow();
		if($val){
			$q="and out_lab='$val'"; 
			$add_title=get_val('lab_m_external_labs','name_'.$lg,$val);
		}else{
			$outLabs_arr=array();
			$sql="select * from lab_m_external_labs where act=1 order by name_$lg asc";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$id=$r['id'];
					$outLabs_arr[$id]=$r['name_'.$lg];
				}
			}				
		}		
		$sql="select * from lab_x_visits_services_outlabs l , lab_m_services s where
		s.id=l.service and date_send>='$d_s' and date_send < '$d_e' $q  order by date_send ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
		if($rows>0){
		$colspan=3?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<? if(!$val){ $colspan++;?><th><?=k_thlab?> </th> <? }?>
				<th><?=k_analysis?></th>                    
				<th><?=k_patient?></th>
				<th><?=k_status?></th>
				<th><?=k_price?></th>
			</tr>
			<?
			$total=0;				
			while($r=mysql_f($res)){
				$patient=$r['patient'];
				$out_lab=$r['out_lab'];
				$status=$r['status'];
				$service_name=$r['short_name'];
				$lab_price=$r['lab_price'];
				$total+=$lab_price;
				echo '
				<tr>';
				if(!$val){echo '<td class="f1 fs14">'.$outLabs_arr[$out_lab].'</td>';}
				echo '<td><ff>'.$service_name.'</ff></td>
				<td class="f1 fs14">'.get_p_name($patient).'</td>					
				<td class="f1 fs14">'.$lab_out_status[$status].'</td>
				<td><ff>'.number_format($lab_price).'</ff></td>
				</tr>';
			}
			echo '
			<tr style="background-color:#eee">
			<td colspan="'.$colspan.'" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_total.'</td>                
			<td><ff class="clr6 fs22">'.number_format($total).'</ff></td>				
			</tr>
			</table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_no_tests_tdy.'</div>';}

	}		
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q="and outlab='$val'"; $add_title=get_val('lab_m_external_labs','name_'.$lg,$val);}?>  
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th>                 
			<th><?=k_number_of_tests?></th>
			<th><?=k_tot_price?></th>
		</tr><?
		$count_all=0; $sum_all=0; $total_pay_all=0;        
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			$count_of_ana=getTotalCO('lab_x_visits_services_outlabs'," date_send>='$d_s' and date_send < '$d_e' $q ");
			$sum_of_price=get_sum('lab_x_visits_services_outlabs','lab_price'," date_send >= '$d_s' and date_send < '$d_e' $q ");
			$count_all+=$count_of_ana;
			$sum_all+=$sum_of_price;
			$total_pay_all+=$total_pay;
			if($count_of_ana || $sum_of_price ){?>
				<tr><td><div class="ff fs18 B txt_Over" onclick="loadRep(<?=$page?>,0,<?=$d_s?>)"><?=($ss+1)?></div></td>				
				<td><ff class=""><?=number_format($count_of_ana)?></ff></td>
				<td><ff class=""><?=number_format($sum_of_price)?></ff></td>
				</tr><?
			}
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($count_all)?></ff></td>
			<td><ff class="clr1"><?=number_format($sum_all)?></ff></td>                 
		</tr>
		</table><?		
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);			
		$d_ss=strtotime($df);
		$d_ee=strtotime($dt)+86400;
		$q='';
		echo $breakC;
		echo repTitleShow();
		if($val){
			$q="and out_lab='$val'";
			$add_title=get_val('lab_m_external_labs','name_'.$lg,$val);			
		}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?
		if($d_ss<$d_ee){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th width="80"><?=k_tday?></th>                 
				<th><?=k_number_of_tests?></th>
				<th><?=k_tot_price?></th>
			</tr><?
			$count_all=0; $sum_all=0;  $total_pay_all=0;            
			for($ss=$d_ss;$ss<$d_ee;$ss=$ss+86400){		
				 $d_s=$ss;
				$d_e=$d_s+86400;
				$count_of_ana=getTotalCO('lab_x_visits_services_outlabs'," date_send >='$d_s' and date_send < '$d_e' $q ");
				$sum_of_price=get_sum('lab_x_visits_services_outlabs','lab_price'," date_send >= '$d_s' and date_send < '$d_e' $q ");
				$count_all+=$count_of_ana;
				$sum_all+=$sum_of_price;					
				if($count_of_ana || $sum_of_price ){?>
					<tr><td><div class="ff fs18 B txt_Over" onclick="loadRep(<?=$page?>,0,<?=$d_s?>)"><?=date('Y-m-d',$ss)?></div></td>				
					<td><ff class=""><?=number_format($count_of_ana)?></ff></td>
					<td><ff class=""><?=number_format($sum_of_price)?></ff></td>
					</tr><?
				}				
			}
			?> 
			<tr fot>					
				<td class="f1 fs14"><?=k_total?></td> 
				<td><ff class="clr1"><?=$count_all?></ff></td>
				<td><ff class="clr1"><?=$sum_all?></ff></td>
			</tr>
			</table><?                			
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}
	}
	if($tab==3){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_thlab?></th>    
			<th><?=k_number_of_tests?></th>
			<th><?=k_tot_price?></th>
		</tr>  
		<?
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$count_all=0; $sum_all=0;			
		$sql="select * from lab_m_external_labs where act=1";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$out_l=$r['id'];
			$out_name=$r['name_'.$lg];				
			$count_of_ana=getTotalCO('lab_x_visits_services_outlabs'," date_send >='$d_s' and date_send < '$d_e' and out_lab='$out_l' ");
			$sum_of_price=get_sum('lab_x_visits_services_outlabs','lab_price'," date_send >= '$d_s' and date_send < '$d_e' and out_lab='$out_l'  ");
			$count_all+=$count_of_ana;
			$sum_all+=$sum_of_price;				
			if($count_of_ana || $sum_of_price){?>   
				<tr>   
				<td><span class="f1 fs14 "><?=$out_name?></span></td>				
				<td><ff class=""><?=number_format($count_of_ana)?></ff></td>
				<td><ff class=""><?=number_format($sum_of_price)?></ff></td>				
				</tr><?
			}

		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($count_all)?></ff></td>
			<td><ff class="clr1"><?=number_format($sum_all)?></ff></td>                 
		</tr>
		</table><?
	}
	if($tab==4){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		$count_all=0; $sum_all=0;
		echo $breakC;
		echo repTitleShow();?>			
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_thlab?></th>    
			<th><?=k_number_of_tests?></th>
			<th><?=k_tot_price?></th>
		</tr>  
		<?			
		$sql="select * from lab_m_external_labs where act=1";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$out_l=$r['id'];
			$out_name=$r['name_'.$lg];				
			$count_of_ana=getTotalCO('lab_x_visits_services_outlabs'," date_send >='$d_s' and date_send < '$d_e' and out_lab='$out_l' ");
			$sum_of_price=get_sum('lab_x_visits_services_outlabs','lab_price'," date_send >= '$d_s' and date_send < '$d_e' and out_lab='$out_l'  ");
			$count_all+=$count_of_ana;
			$sum_all+=$sum_of_price;				
			if($count_of_ana || $sum_of_price){?>   
				<tr>   
				<td><span class="f1 fs14 "><?=$out_name?></span></td>				
				<td><ff class=""><?=number_format($count_of_ana)?></ff></td>
				<td><ff class=""><?=number_format($sum_of_price)?></ff></td>				
				</tr><?
			}

		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($count_all)?></ff></td>
			<td><ff class="clr1"><?=number_format($sum_all)?></ff></td>                 
		</tr>
		</table><?
	}
	if($tab==5){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q="and outlab='$val'"; $add_title=get_val('lab_m_external_labs','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?			
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$servics_arr=array();
		$sql="select * from lab_x_visits_services_outlabs where	date_send>='$d_s' and date_send < '$d_e' $q  order by date_send ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){				
			$total=0;
			while($r=mysql_f($res)){										
				$status=$r['status'];					
				$lab_price=$r['lab_price'];
				$service=$r['service'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>

		</tr>  
		<?
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$count_all=0; $sum_all=0;			
		$sql="select * from lab_m_external_labs where act=1";
		$res=mysql_q($sql);
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>                 
		</tr>
		</table><?
	}
	if($tab==6){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q="and outlab='$val'"; $add_title=get_val('lab_m_external_labs','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;            

		$servics_arr=array();
		$sql="select * from lab_x_visits_services_outlabs where	date_send>='$d_s' and date_send < '$d_e' $q  order by date_send ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){				
			$total=0;
			while($r=mysql_f($res)){										
				$status=$r['status'];					
				$lab_price=$r['lab_price'];
				$service=$r['service'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>

		</tr>  
		<?
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$count_all=0; $sum_all=0;			
		$sql="select * from lab_m_external_labs where act=1";
		$res=mysql_q($sql);
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>
		</tr>
		</table><?
	}
	if($tab==7){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q="and outlab='$val'"; $add_title=get_val('lab_m_external_labs','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?			
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$servics_arr=array();
		$sql="select * from lab_x_receipt_items where reciept_date>='$d_s' and reciept_date < '$d_e' $q  order by reciept_date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){				
			$total=0;
			while($r=mysql_f($res)){										
				//$status=$r['status'];					
				$lab_price=$r['lab_price'];
				$service=$r['tests'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>

		</tr>  
		<?
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$count_all=0; $sum_all=0;			
		$sql="select * from lab_m_external_labs where act=1";
		$res=mysql_q($sql);
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>                 
		</tr>
		</table><?
	}
	if($tab==8){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q="and outlab='$val'"; $add_title=get_val('lab_m_external_labs','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;            

		$servics_arr=array();
		$sql="select * from lab_x_receipt_items where reciept_date>='$d_s' and reciept_date < '$d_e' $q  order by reciept_date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){				
			$total=0;
			while($r=mysql_f($res)){										
				$lab_price=$r['lab_price'];
				$service=$r['tests'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>

		</tr>  
		<?
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$count_all=0; $sum_all=0;			
		$sql="select * from lab_m_external_labs where act=1";
		$res=mysql_q($sql);
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>
		</tr>
		</table><?
	}
	if($tab==9){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q="and outlab='$val'"; $add_title=get_val('lab_m_external_labs','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?			
		$d_s=$mm;
		$d_e=strtotime($year.'-'.($month+1).'-1');
		$servics_arr=array();
		$sql1="select * from lab_x_visits_services_outlabs where date_send>='$d_s' and date_send < '$d_e' $q  order by date_send ASC";
		$res1=mysql_q($sql1);
		$rows1=mysql_n($res1);
		if($rows1>0){				

			while($r=mysql_f($res1)){														
				$lab_price=$r['lab_price'];
				$service=$r['service'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}//echo $servics_arr[1]['c'];
		$sql2="select * from lab_x_receipt_items where reciept_date>='$d_s' and reciept_date < '$d_e' $q2  order by reciept_date ASC";
		$res2=mysql_q($sql2);
		$rows2=mysql_n($res2);
		if($rows2>0){				
			while($r=mysql_f($res2)){										
				//$status=$r['status'];					
				$lab_price=$r['lab_price'];
				$service=$r['tests'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>

		</tr>  
		<?$rows=$rows1+$rows2;
		//echo '</br>'.$servics_arr[1]['c'];
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>                 
		</tr>
		</table><?
	}
	if($tab==10){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$q1='';$q2='';
		echo $breakC;
		echo repTitleShow();		
		if($val){$q1="and out_lab='$val'";$q2="and outlab='$val'"; $add_title=get_val('lab_m_external_labs','name_'.$lg,$val);}?>			
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;            
		$total=0;
		$servics_arr=array();
		$sql="select * from lab_x_visits_services_outlabs where	date_send>='$d_s' and date_send < '$d_e' $q1  order by date_send ASC";
		$res=mysql_q($sql);
		$rows1=mysql_n($res);
		if($rows>0){						
			while($r=mysql_f($res)){										
				$status=$r['status'];					
				$lab_price=$r['lab_price'];
				$service=$r['service'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}

		$sql="select * from lab_x_receipt_items where reciept_date>='$d_s' and reciept_date < '$d_e' $q2  order by reciept_date ASC";
		$res=mysql_q($sql);
		$rows2=mysql_n($res);
		if($rows>0){						
			while($r=mysql_f($res)){										
				$lab_price=$r['lab_price'];
				$service=$r['tests'];					
				$servics_arr[$service]['c']++;
				$servics_arr[$service]['p']+=$lab_price;
				$total+=$lab_price;
			}
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th><?=k_analysis?></th>    
			<th><?=k_number?></th>
			<th><?=k_price?></th>
			<th><?=k_tot_amount?></th>

		</tr>  
		<?$rows=$rows1+$rows2;
		foreach($servics_arr as $key => $ana){?>   
			<tr>   
			<td><ff><?=get_val('lab_m_services','short_name',$key)?></ff></td>
			<td><ff class=""><?=number_format($ana['c'])?></ff></td>
			<td><ff class=""><?=number_format($ana['p']/$ana['c'])?></ff></td>
			<td><ff class="clr1"><?=number_format($ana['p'])?></ff></td>				
			</tr><?
		}?>
		<tr fot>                
			<td class="f1 fs14"><?=k_total?></td> 
			<td><ff class="clr1"><?=number_format($rows)?></ff></td>
			<td><ff class="clr1">-</td>
			<td><ff class="clr1"><?=number_format($total)?></ff></td>
		</tr>
		</table><?
	}		
}
/**************************************************/
if($page_mood==1){echo reportFooter();}?>