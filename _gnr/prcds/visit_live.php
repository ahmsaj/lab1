<? include("../../__sys/prcds/ajax_header.php");
$dayNo=date('w');
$x_doctor=array();
$date=date('Y-m-d');
$t=$_POST['t'];
$sw1=$sw2=$sw3='off';
${'sw'.$t}='on';
if(_set_tauv8g02){$serClinic=$_SESSION['po_clns'];}
//else{ $serClinic=get_val('_users','subgrp',$thisUser);}
/*********************************************************/
//$delUnfinishVisTime=3600;
if($t==1){
	$tab1=$tab2=$tab3=$tab4='';
	$ordRec=array();
	$sql="select * from gnr_x_temp_oprs where user='$thisUser' or ( type in(1,2,3) ) order by type ASC , date ASC ";
	$res=mysql_q($sql);	
	while($r=mysql_f($res)){
		$opr_id=$r['id'];
		$v_id=$r['vis'];
		$clinic=$r['clinic'];
		$patient=$r['patient'];
		$pat_name=$r['pat_name'];
		$d_start=$r['date'];
		$sub_status=$r['sub_status'];
		$status=$r['status'];
		$type=$r['type'];
		$mood=$r['mood'];
		if($type==4 && !in_array($v_id,$ordRec) && $status==0){
			$clinicName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'cli');
			$tab1.='<div class="x_visit_List cur fl" onclick="viSts('.$mood.','.$v_id.')">
			<div class="f1 fs16 lh30">'.$pat_name.'</div>		
			<div class="f1 fs12 clr1">'.$clinicName.'</div></div>';
		}
		if($type==3){
			array_push($ordRec,$v_id);
			$action='';			
			$class2='';
			if($status==1){
				$class2='x_visit_List_act';
				$action='onclick="viSts('.$mood.','.$v_id.')" ';
			}
			$x=1;
			if($ss_day>($d_start+(86400*3))){
				$x=getTotalCO($visXTables[$mood]," id='$v_id'");				
				if($x==0){delTempOpr($mood,$v_id,3);}
			}
			$tab2.='
			<div class="x_visit_List '.$class2.'" '.$action.'  >
			<div class="f1 fs16 lh30 clr1">'.$pat_name.' </div>		
			<div class="f1 fs12 clr3">'.k_reg_snc.' <span class="ff fs14 B"> ( '.dateToTimeS2($now-$d_start).' ) </span></div>
			<div class="fs12 f1 cdoc_name cb lh20 TC ins_s'.$sub_status.'">'.$payStatusArrRec[$sub_status].'</div>
			</div>';
		}
		if($type==2){
			array_push($ordRec,$v_id);
			$action='';			
			$class2='';
			if($status==1){
				$class2='x_visit_List_act';
				if($mood==4){
					$action='onclick="srvAlertPay('.$v_id.','.$mood.')"';
				}else{
					$action='onclick="viSts('.$mood.','.$v_id.')" ';
				}
			}
			$x=1;			
			if($ss_day>($d_start+(86400*3))){
				$x=getTotalCO($visXTables," id='$v_id' ");				
				if($x==0){delTempOpr($mood,$v_id,2);}
			}
			$tab3.='
			<div class="x_visit_List '.$class2.'" '.$action.'  >
			<div class="f1 fs16 lh30 clr1">'.$pat_name.' </div>		
			<div class="f1 fs12 clr3">'.k_reg_snc.' <span class="ff fs14 B"> ( '.dateToTimeS2($now-$d_start).' ) </span></div>		
			<div class="fs12 f1 cdoc_name cb lh20 TC ex_s'.$status.'">'.$reqStatusArr[$status].'</div>
			</div>';
		}
		if($type==1){
			array_push($ordRec,$v_id);
			$action='';
			$class2='';
			if($status==1){$class2='x_visit_List_act';$action='onclick="viSts('.$mood.','.$v_id.')" ';}
			$tab4.='
			<div class="x_visit_List '.$class2.'" '.$action.'  >
			<div class="f1 fs16 lh30 clr1">'.get_p_name($patient).' </div>		
			<div class="f1 fs12 clr3">'.k_reg_snc.' <span class="ff fs14 B"> ( '.dateToTimeS2($now-$d_start).' ) </span></div>		
			<div class="fs12 f1 cdoc_name cb lh20 TC ex_s'.$status.'">'.$payStatusArrRec[$status].'</div>
			</div>';
		}
	}	
	echo $tab1.'^'.$tab2.'^'.$tab3.$tab4;
	
	echo '^';
	/*********************طلبات التحاليل**********************/
	$sql="select * from lab_x_visits_requested where `status`=1 order by id DESC limit 3";//status=1 To Fix
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){	
		while($r=mysql_f($res)){
			$r_id=$r['id'];
			$doc=$r['doc'];
			$patient=$r['patient'];
			$date=$r['date'];
			$docNmae=get_val_arr('_users','name_'.$lg,$doc,'doc');
			echo'
			<div class="x_visit_List cur fl" onclick="anaRequ('.$r_id.')">
			<div class="f1 fs16 lh30">'.get_p_name($patient).'</div>		
			<div class="f1 fs14 clr1">'.$docNmae.'</div>
			<div class="clr5"><ff>'.clockStr($now-$date).'</ff></div>
			</div>';
		}
	}
	/******************طلبات الأشعة********************/
	$sql="select * from xry_x_visits_requested where `status`=1 order by id DESC limit 3";//status=1 To Fix
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		while($r=mysql_f($res)){
			$r_id=$r['id'];
			$doc=$r['doc'];
			$patient=$r['patient'];
			$date=$r['date'];
			$docNmae=get_val_arr('_users','name_'.$lg,$doc,'doc');
			echo'
			<div class="x_visit_List cur fl" onclick="pxRequ('.$r_id.')">
			<div class="f1 fs16 lh30">'.get_p_name($patient).'</div>		
			<div class="f1 fs14 clr1">'.$docNmae.'</div>
			<div class="clr5"><ff>'.clockStr($now-$date).'</ff></div>
			</div>';
		}
	}
	echo '^';
	/******************* التنبيهات**********/
	$q="";
	if($serClinic){
		if(_set_tauv8g02){$q=" clinic IN($serClinic) and ";}
	}
	$sql="select * from gnr_x_visits_services_alert where $q status>0  and status!=4 order by date ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){			
			$a_visit_id=$r['visit_id'];
			$a_clinic=$r['clinic'];
			$a_doc=$r['doc'];
			$a_service=$r['service'];
			$a_amount=$r['amount'];
			$a_patient=$r['patient'];
			$a_date=$r['date'];
			$status=$r['status'];
			$mood=$r['mood'];
			$action='srvAlertPay('.$a_visit_id.','.$mood.')';
			if($status==5){
				$action='check_tik_do(\''.$mood.'-'.$a_visit_id.'\')';
			}
			echo '
			<div class="x_visit_List cur fl" onclick="'.$action.'">
			<div class="f1 fs16 lh40">'.get_p_name($a_patient).'</div>		
			<div class="f1 fs12 clr1 lh20">'.get_val('_users','name_'.$lg,$a_doc).' ['.get_val('gnr_m_clinics','name_'.$lg,$a_clinic).' ]</div>				
			</div>';
		}
	}
	$sql="select * from gnr_x_insur_pay_back order by date ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<div class="f1 clr1 fs16 lh40 uLine TC">'.k_pats_recvbls.'</div>';
		while($r=mysql_f($res)){			
			$s_id=$r['id'];
			$patient=$r['patient'];
			$amount=$r['amount'];
			echo '
			<div class="x_visit_List cur fl cbg44" onclick="backInsur('.$s_id.','.$amount.')">
			<div class="f1 fs16 lh40">'.get_p_name($patient).'<div class="lh20"><ff>'.number_format($amount).'</ff></div></div>
			</div>';
		}
		
	}
}
/*********************************************************/
if($t==2){	
	echo '<div class="drt_rowHead fl" fix="wp:0"><div class="dInfo fl" title="'.k_appoint_clrs.'" onclick="showDtsClr()">?</div>
	<div class="drt_row2 " fix="wp:0">';
	list($days,$type,$data)=get_val('gnr_m_users_times','days,type,data',0);
	$d=get_doc_Time($type,$data,$days);
	$sDay=$d[0];
	$eDay=$d[1];
	$dayLength=($eDay-$sDay);
	$dayLengthHours=($dayLength/3600);
	$dayPer=100/$dayLengthHours;
	
	$pointerWidth=(($now-$ss_day-$sDay)*100)/($eDay-$sDay);
	$pointerWidth=min(100,$pointerWidth);
	if($n==0){
		$thisH=$sDay;
		while($thisH<$eDay){
			$thh=($thisH/3600);
			$pbh=$dayPer;
			$thisH+=3600;
			if($thisH%3600!=0 || ($thisH-$eDay)==1800){
				$thisH-=1800;
				$pbh=$dayPer/2;
			}
			echo '<div class="fl pd5 bord" style="width:'.number_format($pbh,6).'%">'.clockSty($thh).'</div>';
		}
	}
	echo '</div>
	</div>
	<div class="lh20">&nbsp;</div>';
	
	$dates_arr=array();
	$clinic_arr=array();
	$sql="select * from dts_x_dates where d_start>='$ss_day' and d_start<'$ee_day' and status !=5 order by d_start ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	while($r=mysql_f($res)){
		$clinic=$r['clinic'];
		$d_id=$r['id'];
		if(!in_array($clinic,$clinic_arr)){array_push($clinic_arr,$clinic);}
		$dates_arr[$d_id]=$r;		
	}
	if(count($clinic_arr)){		
		$clnics=implode(',',$clinic_arr);
		$sql="select id,photo,name_$lg from gnr_m_clinics where act=1 and id IN($clnics) order by ord ASC";
		$res=mysql_q($sql);		
		while($r=mysql_f($res)){
			$c_id=$r['id'];
			$photo=$r['photo'];
			$name=$r['name_'.$lg];			
			$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
			echo '<div class="drt_row clr5" fix="wp:0">
			<div class="fl ic b_bord" title="'.$name.'" clinc="'.$c_id.'">'.$ph_src.'</div>
			<div class="fl ti lh40" fix="wp:40"><div class="dtsPointer" style="width:'.$pointerWidth.'%"></div>';
			$pointer=$sDay;
			foreach($dates_arr as $k => $d){
				$flasher='';
				if($d['clinic']==$c_id){
					$d_start=$d['d_start'];
					$ds=$d_start-$ss_day;
					$de=$d['d_end']-$ss_day;
					$de=$d['d_end']-$ss_day;
					$note=$d['note'];
					$d_status=$d['status'];
					$d_t=$de-$ds;
					$b_width=$d_t*100/$dayLength;
					$d_m=$ds-$pointer;
					$b_margin=$d_m*100/$dayLength;
					
					$pat_name=get_p_dts_name($d['patient'],$d['p_type']);					
					if($d_status==2 && $d_start < $now ){$flasher='flasher2';}	
					if($d_status==2 && $d_start < $now-(60*_set_d9c90np40z ) ){
						$flasher='flasher';						
					}
					//$b_margin=0;
					$title=$pat_name.'&#013;'.date('A h:i',$ds);
					if($note){$title.='&#013;--------------&#013;'.$note;}
					echo '<div style="width:'.number_format($b_width,6).'%; margin-'.$align.':'.$b_margin.'% " class="fl dts_bl dts_bl_'.$d_status.' '.$flasher.' Over" onclick="dateINfo('.$d['id'].')" title="'.$title.'"></div>';
					$pointer=$de;
				}
			}
			echo '</div>
			</div>';
		}		
	}	

	echo '^';
	$dateTabColor='';
	$dateTabTotal1=0;
	$dateTabTotal2=0;
	$clsDateCounter=0;
	if(chProUsed('dts')){
		foreach($dates_arr as $k => $d){
			$flasher='';			
			$d_start=$d['d_start'];
			$ds=$d_start-$ss_day;
			$de=$d['d_end']-$ss_day;
			$de=$d['d_end']-$ss_day;
			$d_status=$d['status'];
			$d_t=$de-$ds;
			$b_width=$d_t*100/$dayLength;
			$d_m=$ds-$pointer;
			$b_margin=$d_m*100/$dayLength;

			$pat_name=get_p_dts_name($d['patient'],$d['p_type']);			
			if($d_status==2 && $clsDateCounter<10 ){
				$clsDateCounter++;
				if( $d_start < $now ){
					$flasher='flasher2';
					$dateTabTotal1++;
					if($dateTabColor!='flasher'){$dateTabColor='flasher2';}
				}
				if( $d_start < $now-(60*_set_d9c90np40z ) ){
					$flasher='flasher';
					$dateTabColor='flasher';
					$dateTabTotal2++;
				}
				$closeDate.='
				<div class="clsDate fl '.$flasher.' Over" onclick="dateINfo('.$d['id'].')">
					<div a class="fl ff B fs16" >'.date('h:i',$ds).'</div>
					<div b class="fl f1 " fix="wp:50">'.$pat_name.'</div>
				</div>';				
			}
		}
		if($closeDate){
			echo $closeDate.'<div class="uLine cb"></div>';
		}
		$dDate=$now-(60*_set_d9c90np40z);
		$sql="select * from dts_x_dates where reg_user='$thisUser' and status=0 ";

		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<div class="f1 fs16 TC lh30 clr1111">'.k_appoints_to_cmplt.'</div><div class="uLine"></div>';
			while($r=mysql_f($res)){		
				$id=$r['id'];	
				$doctor=$r['doctor'];			
				$clinic=$r['clinic'];
				$date=$r['date'];
				$d_start=$r['d_start'];
				$d_end=$r['d_end'];
				$c_type=$r['type'];
				$status=$r['status'];			
				if($date < $dDate && $status==0){
					mysql_q("DELETE from dts_x_dates where id='$id'");
                    datesTempUp($id);
					mysql_q("DELETE from dts_x_dates_services where dts_id='$id'");
				}else{
					$action='selDate('.$id.');';
					if($d_start){$action='selDaPat('.$id.',1,'.$c_type.');';}	
					echo'
					<div class="x_visit_List cur fl" onclick="'.$action.'">
					<div class="f1 fs16 lh30 clr1">'.get_val('_users','name_'.$lg,$doctor).' ( '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' )</div>
					<div class="f1 fs12 clr5 lh20"><ff>'.dateToTimeS2($now-$date).'</ff></div>
					</div>';
				}
			}		
		}
	}
echo '^^^';}
/*********************************************************/
if($t==3){
	$q=" ";
	if(_set_tauv8g02){$q=" (clinic IN($serClinic) or status=2) and ";}
	$sql="select * from gnr_x_visits_services_alert where $q  status!=4 order by date ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$visitEnd='';
		echo '<table width="100%" type="static" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
		<tr><th></th><th>'.k_patient.'</th><th>'.k_doctor.'</th><th>'.k_service.'</th><th>'.k_amount.'</th></tr>';
		while($r=mysql_f($res)){			
			$a_visit_id=$r['visit_id'];
			$a_clinic=$r['clinic'];
			$a_doc=$r['doc'];
			$a_service=$r['service'];
			$a_amount=$r['amount'];
			$a_patient=$r['patient'];
			$a_date=$r['date'];
			$status=$r['status'];
			$mood=$r['mood'];
			if($mood==1){
				$action='class="Over" onclick="srvAlertPay('.$a_visit_id.','.$mood.')"';
				$serName=get_val('cln_m_services','name_'.$lg,$a_service);
			}
			if($mood==3){
				$action='class="Over" onclick="srvAlertPay('.$a_visit_id.','.$mood.')"';
				$serName=get_val('xry_m_services','name_'.$lg,$a_service);
			}
			if($mood==5 || $mood==6){
				$action='';
				$serName=get_val('bty_m_services','name_'.$lg,$a_service);
				$a_amount=k_no_sel;
			}
			if($status==0){
				echo '<tr>				
				<td><ff class="clr5">'.dateToTimeS2($now-$a_date).'</ff></td>
				<td class="f1 fs14 clr1">'.get_p_name($a_patient).'</td>
				<td class="f1 fs14">'.get_val('_users','name_'.$lg,$a_doc).' [ '.get_val('gnr_m_clinics','name_'.$lg,$a_clinic).' ]</td>
				<td class="f1 fs14">'.$serName.'</td>
				<td><ff>'.$a_amount.'</ff></td>
				</tr>';	
			}elseif($status==2){
				$visitEnd.= '
				<div class="x_visit_List cur  f1 fs14 pd10v cbg555" onclick="conflctDates()">
				'.k_appoint_coflict_with_vac.' <br>'.k_nums.' <ff>('.$a_amount.')</ff>
				</div>';
			}elseif($status==5){
				//;
				$visitEnd.= '
				<div class="x_visit_List cur fl" onclick="check_tik_do(\''.$mood.'-'.$a_visit_id.'\')">
				<div class="f1 fs16 lh40">'.get_p_name($a_patient).'</div>		
				<div class="f1 fs12 clr1 lh20">'.get_val('_users','name_'.$lg,$a_doc).' ['.get_val('gnr_m_clinics','name_'.$lg,$a_clinic).' ]</div>				
				</div>';
			}else{
				$visitEnd.= '
				<div class="x_visit_List cur fl" onclick="srvAlertPay('.$a_visit_id.','.$mood.')">
				<div class="f1 fs16 lh40">'.get_p_name($a_patient).'</div>		
				<div class="f1 fs12 clr1 lh20">'.get_val('_users','name_'.$lg,$a_doc).' ['.get_val('gnr_m_clinics','name_'.$lg,$a_clinic).' ]</div>				
				</div>';
			}
		}
		echo '</table>';	
	}
	echo '^';
	if($visitEnd){		
		echo $visitEnd;
	} 
	/*********************************************************************************/
echo '^^^';}
/*********************************************************/
echo '^';
echo '<div class="visTab f1 fs14 fl TC" s="'.$sw1.'" n="1">'.k_operations.' <ff> ( 0 ) </ff></div>';
if(chProUsed('dts')){
	if(in_array($t,array(1,3))){
		$lateDate=$now-(60*_set_d9c90np40z);
		$dateTabTotal1=getTotalCO("dts_x_dates","status=2 and d_start < $now and d_start > $ss_day ");
		$dateTabTotal2=getTotalCO("dts_x_dates","status=2 and d_start < $lateDate and d_start > $ss_day ");
		if($dateTabTotal1){$dateTabColor=' flasher2 ';}
		if($dateTabTotal2){$dateTabColor=' flasher ';}
	}
	echo '<div class="visTab f1 fs14 fl TC '.$dateTabColor.' " s="'.$sw2.'" n="2">'.k_appointments.' <ff> ( '.$dateTabTotal1.' / '.$dateTabTotal2.' ) </ff></div>';
}
$q=" status in(2,5) ";
$q2='';

$dateTabTotal1=0;
$dateTabTotal2=0;

if(_set_tauv8g02){
	$q=" clinic IN($serClinic) or status in(2,5) ";
	$q2=" clinic IN($serClinic) and ";
}
	
$dateTabColor='';

if($serClinic){
	$dateTabTotal1=getTotalCO("gnr_x_visits_services_alert", $q);
	$dateTabTotal2=getTotalCO("gnr_x_visits_services_alert"," (clinic IN($serClinic) and status>0) or status=2");
}
if($dateTabTotal1){$dateTabColor=' flasher2 ';}
if($dateTabTotal2){$dateTabColor=' flasher ';}
$dateTabTotal1=getTotalCO("gnr_x_visits_services_alert"," $q2 status=0");	
echo '<div class="visTab f1 fs14 fl TC '.$dateTabColor.' " s="'.$sw3.'" n="3">'.k_alerts.'<ff> ( '.$dateTabTotal1.' / '.$dateTabTotal2.' ) </ff></div>';


echo '^';
$bal=0;
$r=getRecCon('gnr_x_tmp_cash'," casher='$thisUser' ");
if($r['r']){
	if(_set_vyo1ykjlhm){
		$bal=($r['amount_in']-$r['amount_out'])+($r['bal_in']-$r['bal_out']);
	}else{
		$bal=($r['amount_in']-$r['amount_out']);
	}
	$viss=$r['vis'];
}

echo '
<div class="f_info fl">
<div class="lh20 ff fs16 B fl pd5">'.number_format($bal).'</div>
<div class="lh20 ff fs16 B fl fic_money"></div>
<div class="lh20 ff fs16 B fl">'.number_format($viss).'</div>
<div class="lh20 ff fs18 B fl fic_vis"></div>
<div class="lh20 ff fs18 B fl pd10">'.date('h:i',$now).'</div>
</div>';
?>