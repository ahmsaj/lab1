<? $repCode='bty';
$pageSize='print_page4';
$report_kWord='report';//k_repot;
$fin=1;//إظهار العلومات المالية
if($thisGrp=='o9yqmxot8'){//مجموعة التسويق
    $fin=0;
}
/**************************************************/
$head=1;$breakC='^';$page_mood=0;
if(isset($_GET['mood'])){$page_mood=intval($_GET['mood']);}
if($page_mood==2){include("../../__sys/prcds/ajax_head_cFile.php");}else{include("../../__sys/prcds/ajax_header.php");}
reportStart($page_mood);
/*******Report Title*******************************/
if($page==1){
	$title1=k_tbty;
	if($tab==0){$titleVal=reportTapTitle('day');}			
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}	
if($page==2){
	$title1=k_tlaser;
	if($tab==0){$titleVal=reportTapTitle('day');}			
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}
if($page==3){	
	$title1=k_specialist;
	$pageSize='print_paW4';
	if($tab==0){$titleVal=reportTapTitle('day',' '.k_dly_perf.' ');}
	if($tab==1){$titleVal=reportTapTitle('month',' '.k_monthly_perf.' ');}
	if($tab==2){$titleVal=reportTapTitle('date',' '.k_perf_by_date.' ');}
}
if($page==4){	
	$title1='الخدمات';
	$pageSize='print_pa4';
	if($tab==0){$titleVal=reportTapTitle('day',' '.k_dly_perf.' ');}
	if($tab==1){$titleVal=reportTapTitle('month',' '.k_monthly_perf.' ');}
	if($tab==2){$titleVal=reportTapTitle('date',' '.k_perf_by_date.' ');}
}
/*******Export File Name*******************************/
if($page==1){
	$fileName='bty_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRange';}
}	
if($page==2){
	$fileName='lzr_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRange';}
}
if($page==3){
	$fileName='bty_docPerf_';				
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
if($page==4){
	$fileName='bty_docSrv_';				
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
/**************************************************/
echo reportPageSet($page_mood,$fileName);
/**************************************************/
if($page==1){
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);			
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;			
	}
	echo $breakC;
	$usersArr=array();
	$usersTotalArr=array();
    $docsType="'9yjlzayzp','66hd2fomwt'";
    $q='';
    if($val){$q="and subgrp='$val'";}
	$sql="select * from _users where grp_code IN($docsType)  $q  order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$usersArr[$r['id']]=$r['name_'.$lg];
		}
        echo repTitleShow();
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s ">
		<tr>
			<th rowspan="2"  width="150">'.k_specialist.'</th>';
			foreach ($usersArr as $k=> $doc ){echo '<th colspan="2" d="d'.$k.'">'.$doc.'</th>';}
		echo '<th colspan="2">'.k_total.'</th>
		<tr>';
		foreach ($usersArr as $k=> $doc ){
			echo '<th d="d'.$k.'">'.k_services.' </th>';
			echo '<th d="d'.$k.'">'.k_monetary.'</th>';
		}
		echo '<th>'.k_services.' </th>';
		echo '<th>'.k_monetary.'</th>';
		echo '</tr>';
		$sql="select * from bty_m_services_cat where clinic in (select id from gnr_m_clinics where type=5) order by name_$lg ASC";
		$res=mysql_q($sql);
		$vTt=0;
		$cTt=0;
		while($r=mysql_f($res)){
			$vT=0;
			$cT=0;
			$showRow=0;
			$srvCat=$r['id'];
			$rr='<tr>
			<td class="f1">'.$r['name_'.$lg].'</td>';
			 foreach ($usersArr as $k=> $doc ){
				$visitTot=getTotalCO('bty_x_visits_services'," d_start>='$d_s' and d_start<'$d_e' and doc='$k' and service IN(select id from bty_m_services where cat='$srvCat') and status=1");

				$visitval=get_sum('bty_x_visits_services','total_pay'," d_start>='$d_s' and d_start<'$d_e' and doc='$k' and service IN(select id from bty_m_services where cat='$srvCat') and status=1 ");
				$usersTotalArr[$k]['vis']+=$visitTot;
				$usersTotalArr[$k]['val']+=$visitval;
				$vT+=$visitTot;
				$cT+=$visitval;
				$rr.='<td d="d'.$k.'"><ff class="clr1">'.number_format($visitTot).'<ff></td>';
				$rr.='<td d="d'.$k.'"><ff class="clr6">'.number_format($visitval).'</ff></td>';
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
			echo '<td d="d'.$k.'"><ff class="clr1" >'.number_format($usersTotalArr[$k]['vis']).'<ff></td>';
			echo '<td d="d'.$k.'"><ff class="clr6">'.number_format($usersTotalArr[$k]['val']).'</ff></td>';
             if($usersTotalArr[$k]['vis']+$usersTotalArr[$k]['val']==0){echo '<script>$("[d=d'.$k.']").hide();</script>';}
		}
		echo '<td><ff class="clr1">'.number_format($vTt).'<ff></td>';
		echo '<td><ff class="clr6">'.number_format($cTt).'</ff></td>';
		echo '</tr>';
		echo '</table>';
	}				
}
if($page==2){
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);			
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;			
	}
	echo $breakC;
	$usersArr=array();
	$usersTotalArr=array();
    $docsType="'9yjlzayzp','66hd2fomwt'";
    $q='';
    if($val){$q="and subgrp='$val'";}
	$sql="select * from _users where grp_code IN($docsType) $q order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
    echo repTitleShow();
	if($rows>0){
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th>'.k_specialist.'</th>
			<th>'.k_vis_no.' </th>
			<th>'.k_actual_num_of_strikes.'</th>
			<th>'.k_tot_strikes.'</th>			
			<th> '.k_net_amount.'</th>
			<th>'.k_discount.'</th>
			<th> '.k_totl.'</th>
			<th>'.k_avg_strike_price.'</th>
			<th>'.k_avg_sell_strike.'</th>
		</tr>';
		$t1=$t2=$t3=$t4=$t5=0;
		while($r=mysql_f($res)){
			$doc=$r['id'];
			$visitTot=getTotalCO('bty_x_laser_visits',"status=2 and d_start>='$d_s' and d_start<'$d_e' and doctor='$doc' ");
			$shoots=get_sum('bty_x_laser_visits','vis_shoot',"status=2 and  d_start>='$d_s' and d_start<'$d_e' and doctor='$doc' ");
			$shoots_r=get_sum('bty_x_laser_visits','vis_shoot_r',"status=2 and d_start>='$d_s' and d_start<'$d_e' and doctor='$doc' ");

			$amount_net=get_sum('bty_x_laser_visits','total_pay',"status=2 and d_start>='$d_s' and d_start<'$d_e' and doctor='$doc' ");
			$dis=get_sum('bty_x_laser_visits','dis',"status=2 and d_start>='$d_s' and d_start<'$d_e' and doctor='$doc' ");

			$amount_total=$amount_net+$dis;
			$average=$amount_total/$shoots_r;
			$average2=$amount_net/$shoots_r;
			if($visitTot){
				$t1+=$visitTot;$t2+=$shoots;$t22+=$shoots_r;$t3+=$amount_net;$t4+=$dis;$t5+=$amount_total;
				echo '<tr>
				<td class="f1">'.$r['name_'.$lg].'</td>
				<td><ff class="clr1">'.number_format($visitTot).'</ff></td>
				<td><ff class="clr5">'.number_format($shoots).'</ff></td>
				<td><ff class="clr1">'.number_format($shoots_r).'</ff></td>
				<td><ff class="clr6">'.number_format($amount_net).'</ff></td>
				<td><ff class="clr5">'.number_format($dis).'</ff></td>
				<td><ff class="clr1">'.number_format($amount_total).'</ff></td>
				<td><ff>'.number_format($average,2).'</ff></td>
				<td><ff>'.number_format($average2,2).'</ff></td>
				</tr>';
			}
		}
		echo '<tr fot>
			<td class="f1">'.k_total.'</td>
			<td><ff class="clr1">'.number_format($t1).'</ff></td>
			<td><ff class="clr5">'.number_format($t2).'</ff></td>
			<td><ff class="clr1">'.number_format($t22).'</ff></td>
			<td><ff class="clr6">'.number_format($t3).'</ff></td>
			<td><ff class="clr5">'.number_format($t4).'</ff></td>
			<td><ff class="clr1">'.number_format($t5).'</ff></td>
			<td><ff>'.number_format($t5/$t22,2).'</ff></td>
			<td><ff>'.number_format($t3/$t22,2).'</ff></td>
		</tr>
		</table>';
	}
}
if($page==3){
	$docsType="'9yjlzayzp','66hd2fomwt'";
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);			
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;			
	}
	echo $breakC;
    echo repTitleShow();?>

	<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
	<? if($page_mood==2){echo exportTitle($reportTitle,14);}?>
	<tr>
		<th rowspan="2"><?=k_dr?></th>
		<th rowspan="2"><?=k_specialty?></th>
		<th rowspan="2"><?=k_job_code?> </th>
		<th colspan="7"><?=k_visits?></th>             
		<th colspan="4"><?=k_services?></th>
	</tr> 	
	<tr>            
		<th><?=k_tot_num?> </th>
		<th><?=k_vnorm?></th>
		<th><?=k_exemption?></th>
		<th><?=k_charity?></th>
		<th><?=k_insurance?></th>
		<th><?=k_employee?></th>
		<th><?=k_new_patient?></th>
		<th><?=k_total?></th>
		<th><?=k_procedure?></th>
		<th><?=k_preview?></th>
		<th><?=k_review?></th>

	</tr>
	<?
	$pm0=$pm1=$pm2=$pm3=$pm4=$pm5=$pm6=$pm7=$pm8=$pm9=$pm10=0;
    $q='';
	if($val){$q="and subgrp='$val'";}
    $sql="select * from _users where grp_code IN($docsType) $q order by name_$lg ASC";
	$res=mysql_q($sql);			
	while($r=mysql_f($res)){
		$doc_id=$r['id'];
		$grp_code=$r['grp_code'];
		$subgrp=$r['subgrp'];
		$doc_name=$r['name_'.$lg];
		$career_code=$r['career_code'];
		$clinic=get_val_con('gnr_m_clinics','name_'.$lg," id IN ($subgrp)" );
		/************************************/				
		$sql2="select 		
		SUM(v_total) v_total , 
		SUM(v_normal) v_normal , 
		SUM(v_exemption) v_exemption , 
		SUM(v_charity) v_charity , 
		SUM(v_insurance) v_insurance , 			
		SUM(v_employee) v_employee , 
		SUM(v_new_pat) v_new_pat , 
		SUM(s_total) s_total , 
		SUM(s_preview) s_preview , 
		SUM(s_procedure) s_procedure , 
		SUM(s_review) s_review
		from gnr_r_docs_details where doc='$doc_id' and `date`>='$d_s' and `date`<'$d_e' ";
		$res2=mysql_q($sql2);
		$r2=mysql_f($res2);
		$v_total=$r2['v_total'];
		$v_normal=$r2['v_normal'];
		$v_exemption=$r2['v_exemption'];
		$v_charity=$r2['v_charity'];
		$v_insurance=$r2['v_insurance'];			
		$v_employee=$r2['v_employee'];
		$v_new_pat=$r2['v_new_pat'];
		$s_total=$r2['s_total'];
		$s_preview=$r2['s_preview'];
		$s_procedure=$r2['s_procedure'];
		$s_review=$r2['s_review'];
		if($v_total){
			$pm0+=$v_total;
			$pm1+=$v_normal;
			$pm2+=$v_exemption;
			$pm3+=$v_charity;
			$pm4+=$v_insurance;			
			$pm5+=$v_employee;
			$pm6+=$v_new_pat;
			$pm7+=$s_total;
			$pm8+=$s_preview;
			$pm9+=$s_procedure;
			$pm10+=$s_review;
			echo '<tr>
			<td txt>'.$doc_name.'</td>
			<td txt>'.$clinic.'</td>
			<td txt>'.$career_code.'</td>
			<td><ff class="clr6">'.number_format($v_total).'</ff></td>
			<td><ff class="clr1">'.number_format($v_normal).'</ff></td>
			<td><ff class="clr1">'.number_format($v_exemption).'</ff></td>
			<td><ff class="clr1">'.number_format($v_charity).'</ff></td>
			<td><ff class="clr1">'.number_format($v_insurance).'</ff></td>						
			<td><ff class="clr1">'.number_format($v_employee).'</ff></td>
			<td><ff class="clr6">'.number_format($v_new_pat).'</ff></td>
			<td><ff class="clr1">'.number_format($s_total).'</ff></td>
			<td><ff class="clr1">'.number_format($s_preview).'</ff></td>
			<td><ff class="clr1">'.number_format($s_procedure).'</ff></td>
			<td><ff class="clr1">'.number_format($s_review).'</ff></td>
			</tr>';
		}
	}
	echo '<tr fot>
		<td txt colspan="3">'.k_total.'</td>
		<td><ff class="clr6">'.number_format($pm0).'</ff></td>
		<td><ff class="clr1">'.number_format($pm1).'</ff></td>
		<td><ff class="clr1">'.number_format($pm2).'</ff></td>
		<td><ff class="clr1">'.number_format($pm3).'</ff></td>
		<td><ff class="clr1">'.number_format($pm4).'</ff></td>
		<td><ff class="clr1">'.number_format($pm5).'</ff></td>		
		<td><ff class="clr6">'.number_format($pm6).'</ff></td>
		<td><ff class="clr1">'.number_format($pm7).'</ff></td>
		<td><ff class="clr1">'.number_format($pm8).'</ff></td>
		<td><ff class="clr1">'.number_format($pm9).'</ff></td>
		<td><ff class="clr1">'.number_format($pm10).'</ff></td>		
		</tr>';
	?>
	</table>
	<?
}
if($page==4){
	$docsType="'9yjlzayzp','66hd2fomwt'";
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);			
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;			
	}
	echo $breakC;
    echo repTitleShow();?>

	<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
	<? if($page_mood==2){echo exportTitle($reportTitle,14);}?>
	<tr>
		<th><?=k_service?></th>
		<th><?=k_tot_num?></th>
        <? if($fin){?><th><?=k_tot_rev?> </th><? }?>
	</tr>
	<?
	$t1=$t2=0;
    $q='';
    
	if($val){
        $cats=get_vals('bty_m_services_cat','id',"clinic='$val'");
        if($cats){$q="where cat  in($cats)";}
        
    }
    $sql="select * from bty_m_services  $q order by name_$lg ASC";
	$res=mysql_q($sql);			
	while($r=mysql_f($res)){
		$srv_id=$r['id'];	
		$name=$r['name_'.$lg];        
		/************************************/
        $total=getTotalCo('bty_x_visits_services',"service='$srv_id' and status=1 and `d_start`>='$d_s' and `d_start`<'$d_e' ");
        $amount=get_sum('bty_x_visits_services','total_pay',"service='$srv_id' and status=1 and `d_start`>='$d_s' and `d_start`<'$d_e' ");
		
		if($total){
			$t1+=$total;
			$t2+=$amount;			
			echo '<tr>
			<td txt>'.$name.'</td>				
			<td><ff class="clr1">'.number_format($total).'</ff></td>';
            if($fin){
			 echo '<td><ff class="clr6">'.number_format($amount).'</ff></td>';			
            }
			echo '</tr>';
		}
	}
	echo '<tr fot>
		<td txt >'.k_total.'</td>		
		<td><ff class="clr1">'.number_format($t1).'</ff></td>';
        if($fin){
		  echo '<td><ff class="clr6">'.number_format($t2).'</ff></td>';
        }
		echo '</tr>';
	?>
	</table>
	<?
}
/**************************************************/
if($page_mood==1){echo reportFooter();}?>