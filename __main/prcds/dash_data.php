<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['n'] , $_POST['n'])){
	$t=pp($_POST['t']);
	$n=pp($_POST['n']);
	$d_s=$now-($now%86400);
	$d_e=$d_s+86400;
	if($t==1){$title2=k_box.' : '.get_val('_users','name_'.$lg,$n);}
	if($t==2){$title2=k_clinic.' : '.get_val('gnr_m_clinics','name_'.$lg,$n);}
	if($t==3){$title2=k_unfinshd_srvs;}
	if($t==4){$title2="اجمالي المرضى اليوم";}
	if($t==5){$title2="اجمالي التحاليل";}
	if($t==6){$title2="التحاليل الخارجية";}
	if($t==7){
		list($dtStart,$patient)=get_val('lab_x_visits','d_start,patient',$n);
		$pName=get_p_name($patient);
		$title2=$pName;
	}
?><div class="win_body">
	<div class="winButts">
    	<div class="wB_x fr" onclick="win('close','#full_win1')"></div>
	</div>	  
    <div class="form_header f1 lh40 fs18">
		<div class="f1 lh40 fs18 fl"><?=$title2?></div>
        <div class="ff lh40 fs18 fr B" dir="ltr"><?=date('Y-m-d',$now)?></div>
    </div>
    <div class="form_body so" type="pd0"><? 
	if($t==1){
		$sql="select * from gnr_x_acc_payments where type!=9 and date>'$d_s' and date < '$d_e' and casher='$n' order by date DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
            <tr>
                <th width="80"><?=k_visit_num?></th>
                <th width="120"><?=k_actu_time?></th> 
                <th><?=k_patient?></th> 
                <th><?=k_doctor?></th> 
                <th><?=k_clinic?></th>                           
                <th><?=k_type?></th>
                <th>نوع الدفع</th>
                <th width="120"><?=k_incm_fnd?></th>
                <th width="120"><?=k_outcm_fnd?></th>
            </tr><?
			$in_all=0;
			$out_all=0;
            while($r=mysql_f($res)){
                $type=$r['type'];
                $vis=$r['vis'];
                $amount=$r['amount'];
                $date=$r['date'];
				$mood=$r['mood'];
                $pay_type=$r['pay_type'];
				$visInfo=getVistInfo($vis,$mood);
				$patient=$visInfo['p'];
				$clinic=$visInfo['c'];
				$doctor=$visInfo['d'];
				
				$in='0';
				$out='0';
				if(in_array($type,array(1,2,5,6,7,10))){
					$in=$amount;
					$in_all+=$in;
				}else{
					$out=$amount;
					$out_all+=$out;
				}
				if($type==5){$patient=$vis;$doctor='';$vis='';$clinic='';}
				
				if($mood==2){
					$clinicName='مخبر';
				}else{
					$clinicName=get_val('gnr_m_clinics','name_'.$lg,$clinic);
				}
                echo '
                <tr>
                <td><ff>#'.$vis.'</ff></td>
                <td><ff>'.clockStr($date-($now-($now%86400))).'</ff></td>
                <td class="f1 fs14"><ff>'.$patient.' -  </ff>'.get_p_name($patient).'</td>
				<td class="f1 fs14">'.get_val('_users','name_'.$lg,$doctor).'</td>
				<td class="f1 fs14">'.$clinicName.'</td>				
				<td><div style="color:'.$payArry_col[$type].'" class="f1 fs14">'.$payArry[$type].'</div></td>
                <td><div style="color:'.$payTypePClr[$pay_type].'" class="f1 fs14">'.$payTypeP[$pay_type].'</div></td>
                <td><ff class="clr6">'.number_format($in).'</ff></td>
				<td><ff class="clr5">'.number_format($out).'</ff></td>
                </tr>';
            }
			echo '
			<tr style="background-color:#eee">
			<td colspan="7" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_total.'</td>                
			<td><ff class="clr6 fs22">'.number_format($in_all).'</ff></td>
			<td><ff class="clr5 fs22">'.number_format($out_all).'</ff></td>
			</tr>';
			echo '
			<tr style="background-color:#">
			<td colspan="7" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_fin_blnc.'</td>    
			<td colspan="2"><ff class="clr1 fs22">'.number_format($in_all-$out_all).'</ff></td>				
			</tr></table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_ntrns_fnd.'</div>';}	
	}
	if($t==2){
		$mood=get_val('gnr_m_clinics','type',$n);		
		$table=$visXTables[$mood];
		$sql="select *,p.type as pType from gnr_x_acc_payments p , $table x where x.id=p.vis and p.mood='$mood' and p.date>'$d_s' and p.date < '$d_e' and vis and x.clinic='$n' order by date DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
            <tr>
                <th width="80"><?=k_visit_num?></th>
                <th width="120"><?=k_actu_time?></th> 
                <th><?=k_patient?></th> 
                <th><?=k_doctor?></th> 
                <th><?=k_box?></th>                           
                <th><?=k_type?></th>
                <th width="120"><?=k_incm_fnd?></th>
                <th width="120"><?=k_outcm_fnd?></th>
            </tr><?
			$in_all=0;
			$out_all=0;
            while($r=mysql_f($res)){
                $type=$r['pType'];
                $vis=$r['vis'];
                $amount=$r['amount'];
                $date=$r['date'];
				$patient=$r['patient'];
				$casher=$r['casher'];
				$doctor=$r['doctor'];
				
				$in='0';
				$out='0';
				if(in_array($type,array(1,2,5))){
					$in=$amount;
					$in_all+=$in;
				}else{
					$out=$amount;
					$out_all+=$out;
				}				
                echo '<tr>
                <td><ff>#'.$vis.'</ff></td>
                <td><ff>'.clockStr($date-($now-($now%86400))).'</ff></td>                
				<td class="f1 fs14"><ff>'.$patient.' -  </ff>'.get_p_name($patient).'</td>
				<td class="f1 fs14">'.get_val('_users','name_'.$lg,$doctor).'</td>
				<td class="f1 fs14">'.get_val('_users','name_'.$lg,$casher).'</td>
				<td><div style="color:'.$payArry_col[$type].'" class="f1 fs14">'.$payArry[$type].'</div></td>
                <td><ff class="clr6">'.number_format($in).'</ff></td>
				<td><ff class="clr5">'.number_format($out).'</ff></td>
                </tr>';
            }
			echo '
			<tr style="background-color:#eee">
			<td colspan="6" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_total.'</td>                
			<td><ff class="clr6 fs22">'.number_format($in_all).'</ff></td>
			<td><ff class="clr5 fs22">'.number_format($out_all).'</ff></td>
			</tr>';
			echo '
			<tr style="background-color:#">
			<td colspan="6" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_fin_blnc.'</td>    
			<td colspan="2"><ff class="clr1 fs22">'.number_format($in_all-$out_all).'</ff></td>				
			</tr></table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_ntrns_fnd.'</div>';}	
	}
	if($t==3){
		$s_date=$now-($now%86400);
		$e_date=$s_date+86400;
		$sql="select * from cln_m_services z ,cln_x_visits_services x where z.id=x.service and x.status=0 and x.d_start > '$s_date' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0">
            <tr>
                <th><?=k_visit_num?></th>
                <th><?=k_actu_time?></th> 
                <th><?=k_patient?></th> 
                <th><?=k_doctor?></th> 
                <th><?=k_service?></th>
                <th><?=k_status?></th>           
                <th><?=k_price?></th>                                
            </tr><?
			$all_pay=0;
            while($r=mysql_f($res)){                		
                $vis=$r['visit_id'];                
                $date=$r['d_start'];
				$patient=$r['patient'];				
				$doctor=$r['doctor'];
				$service=$r['name_'.$lg];
				$pay_net=$r['pay_net'];
				$x_status=$r['status'];				
				$stats_text=k_srv_ncmpt;
				$col='clr4';
				if($x_status==2){$stats_text=k_cncl_srv_pnd_reval;$col='clr5';}
				$all_pay+=$pay_net;
                echo '<tr>
                <td><ff>#'.$vis.'</ff></td>
                <td><ff>'.clockStr($date-($now-($now%86400))).'</ff></td>                
				<td class="f1 fs14">'.get_p_name($patient).'</td>
				<td class="f1 fs14">'.get_val('_users','name_'.$lg,$doctor).'</td>
				<td class="f1 fs14">'.$service.'</td>
				<td><span class="f1 fs14 '.$col.'">'.$stats_text.'</span></td>
				<td><ff>'.number_format($pay_net).'</ff></td>
                </tr>';
            }
			echo '
			<tr style="background-color:#eee">
			<td colspan="6" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_total.'</td>                
			<td><ff>'.number_format($all_pay).'</ff></td>
			</tr></table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_no_results.'</div>';}	
	}
	if($t==4){
		$s_date=$now-($now%86400);
		$e_date=$s_date+86400;
		$sql="select patient,id from lab_x_visits x where  x.d_start>'$s_date' and x.d_start < '$e_date' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$results=array();
		if($rows>0){?>
		    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0">
            <tr>
                <th><?=k_visit_num?></th>
                <th>اسم المريض</th> 
                <th>التحاليل المطلوبة</th>                        
            </tr><?
			  while($r=mysql_f($res)){
				  $vis=$r['id'];
				  $patient=$r['patient'];
				  $results[$vis]='';
				  echo '<tr>
					<td><ff>#'.$vis.'</ff></td>             
					<td class="f1 fs14">'.get_p_name($patient).'</td>';
					$sql2="select xs.service from lab_x_visits_services xs  where xs.visit_id=$vis";
					$res2=mysql_q($sql2);
					$rows2=mysql_n($res2);
					while($r2=mysql_f($res2)){
					   $service=$r2['service'];
						if($results[$vis]!=''){$results[$vis].=', ';}
						$results[$vis].=get_val('lab_m_services','short_name',$service);
					}
					echo'<td><ff>'.$results[$vis].'</ff></td>
					</tr>';
			  }
			echo'</table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_no_results.'</div>';}	
	}
	if($t==5){
		$s_date=$now-($now%86400);
		$e_date=$s_date+86400;
		$sql="select count(*) as c , service from  lab_x_visits_services xs , lab_x_visits x where x.id=xs.visit_id and x.d_start>'$s_date' and x.d_start < '$e_date' group by service";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
		    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0">
            <tr>
                <th>التحليل</th>
                <th>العدد</th>
                <th>نوع التحليل</th>                     
            </tr><?		
			  while($r=mysql_f($res)){
				$service=$r['service'];
				$count=$r['c'];
				$out_lab='ضمن المخبر';
				if(get_val('lab_m_services','outlab',$service)==1){
					$out_lab='خارجي';
				}
 				echo '<tr>
				<td><ff>'.get_val('lab_m_services','short_name',$service).'</ff></td>             
				<td><ff>'.$count.'</ff></td>
				<td class="f1 fs14">'.$out_lab.'</td>';				  
			  }
			echo '</table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_no_results.'</div>';}	
	}
	if($t==6){
		$s_date=$now-($now%86400);
		$e_date=$s_date+86400;
		$sql="select count(*) as c , service from  lab_x_visits_services xs , lab_x_visits x where x.id=xs.visit_id and x.d_start>'$s_date' and x.d_start < '$e_date' group by service having service in(select id from lab_m_services where outlab=1)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
		    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0">
            <tr>
                <th>التحليل</th>
                <th>العدد</th>
                <th>اسعافي/غير اسعافي</th>                     
            </tr><?		
			  while($r=mysql_f($res)){
				$service=$r['service'];
				$count=$r['c'];
				$fast='غير اسعافي';
				if(get_val('lab_m_services','fast',$service)==1){
					$fast='اسعافي';
				}
 				echo '<tr>
				<td><ff>'.get_val('lab_m_services','short_name',$service).'</ff></td>             
				<td><ff>'.$count.'</ff></td>
				<td class="f1 fs14">'.$fast.'</td>';				  
			  }
			echo '</table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_no_results.'</div>';}			
	}
	if($t==7){
		$lrStatus=array('','تم ترقيم العبوة
		',k_sample_received_since,k_entered_lab_since,k_report_partially_entered,'',k_canceled_sample);
		$anStatus=array(k_num_tube_entered,k_complete,k_request_service_for_payment,k_canceled,k_request_cancellation,k_Results_not_entered,k_incomplete_report_entered,k_complete_report,k_report_accepted,k_report_rejected,k_corrected);
		$visitStatus=array('','بالانتظار حالياَ','','','تم اخذ العينات','تم انجاز الخدمات','تم استلام التحاليل');
		list($status,$d_start,$d_check,$d_finish)=get_val('lab_x_visits','status,d_start,d_check,d_finish',$n);
		$time=$d_start;
		if($status==4){$time=$d_check;}
		if($status==5){$time=$d_finish;}
				echo '<div style="background-color:#eee;width:100%;text-align:center;"><div class=" f1 fs18 lh40" >وقت الزيارة [<ff> '.clockStr($dtStart-($dtStart-($dtStart%86400))).' </ff>]</div>';
				echo '<div class=" f1 fs14 ">'.$visitStatus[$status].' منذ [<ff>'.dateToTimeS2($now-$time).'</ff>]</div></div>';
	
		echo '<div class="cb"></div></br>';
			$sql="select * , x.id as x_id , x.fast as x_fast from lab_x_visits_services x , lab_m_services z where x.service=z.id and  x.visit_id='$n' order by x.sample_link ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
		if($rows>0){
			$act_sample=0;
			$fastTime=_set_6bu0m3quf2;
			while($r=mysql_f($res)){
				$s_id=$r['x_id'];
				$name=$r['short_name'];
				$outlab=$r['outlab'];
				$status=$r['status'];
				$fast=$r['x_fast'];
				$sample=$r['sample'];
				$sample_link=$r['sample_link'];
				$s_no=get_val('lab_x_visits_samlpes','no',$sample_link);
				$fastTxt='';
				$styleRow='';
				$style='';
				if($fast){$fastTxt='<div class="f1 clr5 lh20 cb"> '.k_emergency.' </div>';
					$style='fs18 fast_ana_dash3';
					if(number_format(($now-$d_start)/60)>$fastTime){$style='fast_ana_dash2';}			 
				}
				if($act_sample!= $sample_link){				
					$s=getRec('lab_x_visits_samlpes',$sample_link);
					$bg='cbg4';
					echo '<tr class="'.$bg.'">
						<td class="ff B fs16">
							
							<div class="fl f1 fs20 lh50"> '.get_val('lab_m_samples_packages','name_'.$lg,$s['pkg_id']).' <ff> ( '.$s['no'].' )</ff></div>
							<div class="fl" dir="ltr"></div>
						</td>
						<td>
							<div class="cb f1 clr1111 fs14 lh30 mg10">'.$lrStatus[$s['status']].' : <ff>'.dateToTimeS2($now-$s['take_date']).'</ff></div>
						</td>
						</tr>';
					$act_sample=$sample_link;
				}
				$outTxt='';
				if($outlab){$outTxt='<div class="f1 clr1 lh20">'.k_out_test.'</div>';}
				echo '<tr class="'.$style.'">
				<td class="ff B fs16">'.$name.$outTxt.$fastTxt.'</td>
				<td><div class="f1">'.$anStatus[$status].'</div></td>
				</tr>';
			}
			echo '</table>';
		}
			
	}
?>
	</div>
    <div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#full_win1')"><?=k_cancel?></div></div>
</div>
<style>
.fast_ana_dash{
		background-color:#faa;
		border:1px <?=$clr5?> solid;
		border-bottom:5px <?=$clr5?> solid;
	}
.fast_ana_dash:hover{background-color:#faa;}
</style>
<? }?>