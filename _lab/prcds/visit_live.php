<? include("../../__sys/prcds/ajax_header.php");
$clinic=get_val_c('gnr_m_clinics','id',2,'type');
if(getTotalCO('gnr_x_roles'," clic='$clinic' and no=0 ")==0){
	echo '<div class="fr ic40x mg5v icc2 ic40_stop " onclick="stopRow()" title="'.k_pse.'"></div>';
}else{
	echo '<div class="fr ic40x mg5v icc4 ic40_play " onclick="stopRowDo(2)" title="'.k_wrk.'"></div>';
	echo '<input type="hidden" id="stopVal" value="0"/>';
}
if(_set_k9zsc2awv){
	$sampels=getTotalCO('lab_x_visits_samlpes',' grp=0  and status=2');?>
	<div class="top_icon sStatus fr" onclick="sampelsGropInfo(0)">
		<div a><?=$sampels?></div>
		<div b><?=k_unassembled?></div>
	</div><?
}
echo '^';
/***************************************************************/
$dayNo=date('w');
$h_time=get_host_Time();
$h_realTime=intval($h_time[1])-intval($h_time[0]);
$thisDay2=$now-($now%86400);
if(($h_realTime+$thisDay2+intval($h_time[0]))<$now){$h_realTime=($now%86400)-intval($h_time[0]);}
$x_doctor=array();
$date=date('Y-m-d');
/********************************************/
$total=getTotalCO('gnr_x_roles'," status < 4 and mood='2' ");
$sql="select * from gnr_x_roles where status < 4 and mood='2' order by fast DESC , no ASC limit 25";
$res=mysql_q($sql);
$rows=mysql_n($res);$rows2=$rows;
if($rows>0){	
	$i=0;
	$rr=0;
	$stopText='';
	$dataList='';
	while($r=mysql_f($res)){	
		$r_id=$r['id'];
		$vis=$r['vis'];
		$clic=$r['clic'];
		$pat=$r['pat'];
		$date=$r['date'];
		$fast=$r['fast'];
		$status=$r['status'];
		$pat_name=$r['pat_name'];
		$services=$r['services'];
		$no=$r['no'];
		$sClass='s0';
		$action='';
		$c_status=$status;
		$statusAdd='';
		$opration='';
		if($rr==0 && $status<3){			
			if($status==0){
				$rr=2;
				if(!$stopPrv){
					$sClass='s1';
					$action="d_vis_Play(".$r_id.",".$status.",2)";					
				}
			}
			if($status==1){
				$rr=2;
				$sClass='s5';
				$action="d_vis_Play(".$r_id.",".$status.",2)";				
			}			
		}		
		if($status==2){
			$sClass='s2';
			$action="openLabSWin(1,".$vis.")";					
		}
		$no=$r['no'];
		$staTxt='';
		if($sClass!='s0'){$staTxt=' (  '.$samp_opr_txt[$status].' ) ';}
		if($fast>0){$sClass='s4';$staTxt=' ( '.k_emergency.' ) ';}
		if($no==0){
			if(($date-$now)>0){
				$s_time=dateToTimeS2($date-$now);
				$s_title=k_trn_spd_rsm;
			}else{
				$s_time=dateToTimeS2($now-$datew);
				$s_title=k_rsm_wrk;
			}
			echo  $stopText='<div class="cbg5 clrw fs14 lh40 mg10v f1 cb TC" >'.$s_title.' <ff14>'.$s_time.'</ff14></div>';
		}else{
			if($status==3){
				$dataList.='
				<div class="sampleWBlc w100 pd10f" s3>
					<div class="f1s fs14x lh30 clr9">
					<ff>'.$no.' - </ff>'.$pat_name.'- <span class="f1">( '.$samp_opr_txt[$status].' )</span></div>
					<div><ff14 class="lh20">'.$services.'</ff14></div>					
				</div>';
			}else{
				$dataList.='
				<div class="sampleWBlc w100 pd10f " '.$sClass.' onclick="'.$action.'">
					<div class="f1s fs16x lh30 clr3">
					<ff>'.$no.' - </ff>'.$pat_name.' <span class="f1 fs14"> '.$staTxt.' </span></div>
					<div><ff14 class="lh20">'.$services.'</ff14></div>
				</div>';			
			}
		}			
	}
	$out1=$dataList;
}else{$out1='<div class="f1 fs16 clr1">'.k_npat_wait.'</div>';}
/********************************************/
if(_set_b7jbsn8oog==0){
	$sql="select * from lab_x_visits_samlpes where status =1 order by date DESC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=0;
		$out2='';
		while($r=mysql_f($res)){	
			$r_id=$r['id'];
			$visit_id=$r['visit_id'];
			$pkg_id=$r['pkg_id'];
			$services=$r['services'];
			$date=$r['date'];
			$no=$r['no'];
			$status=$r['status'];
			$fast=$r['fast'];
			$sub_s=$r['sub_s'];
			$per_s=$r['per_s'];
			$patient=$r['patient'];
			$action="openLabSWin(1,".$visit_id.")";

			$fastTxt='';if($fast){$fastTxt='<span class="f1 clr5">'.k_emergency.'</span>';}
			$perTxt='';if($per_s){$perTxt='<span class="f1 clr5">'.k_bu_sam.'</span>';}
			$out2.='
			<div s onclick="'.$action.'">
				<div class="fr fs14 f1s lh20 TC">'.get_p_name($patient).'<br>'.$fastTxt.$perTxt.'</div>
				<div class="fl ">'.get_samlpViewC(0,$pkg_id,2,$no).'</div>
				<div class="cb"> </div>
			</div>';				
		}
	}else{$out2='<div class="f1 fs16 clr1">'.k_no_sams_watn.'</div>';}
}
/*******************************************/
	echo $total.'^'.$stopText.$out1.'^'.$rows.'^'.$out2;
	
?>