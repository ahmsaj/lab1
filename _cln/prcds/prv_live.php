<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){	
	$vis=pp($_POST['vis']);	
	$vis_status=get_val('cln_x_visits','status',$vis);
	$clinic=$userSubType;
	$ser_times=array();
	$totalTime=0;
	$srvs=get_vals('cln_x_visits_services','service',"visit_id='$vis'");
	$srvTime=get_sum('cln_m_services','ser_time'," id IN ($srvs)");	
	$totalTime=$srvTime*_set_pn68gsh6dj*60;
	/**************************/
	$work_time=getRealWorkTime($vis,1);
	$bar2_width=(($work_time*100)/$totalTime);	
	$defTime=$totalTime-$work_time;
	$barC='preloader';	
	$statusTxt=k_remain_time_for_visit;
	if($work_time>$totalTime){
		$defTime=$work_time-$totalTime;
		$barC='cbg5';		
		$bar2_width=100;
		$statusTxt=k_prv_cmpsnc;
	}	
	if($work_time){?>
		<div class="f1 fs12 lh20 of fs14 w100"><?=$statusTxt?>: <ff class="fs16"><?=dateToTimeS2($defTime)?></ff></div>		
		<div class="ff fs14 lh30 of ws w100 "><?=dateToTimeS2($totalTime).' / '.dateToTimeS2($work_time);?> | <?=number_format($bar2_width,1)?> %</div>		
		<div class="cbg4 fl w100 of " fix="h:6">
			<div class="<?=$barC?> fl " fix="h:6" style="width:<?=$bar2_width?>%">&nbsp;</div>
		</div><?
	}else{
		if($vis_status==2){
			echo '<div class="lh60 fs14  f1 TC clrw cbg55">'.k_visit_finshd.'</div>';
		}
	}
	/**************************/
	$patN=getTotalCO("gnr_x_roles","status < 3 and clic in($clinic) and ( doctor='$thisUser' or doctor=0 )");	
	$flasher='';
	if(chProUsed('dts')){
		$lateDate=$now-(60*_set_d9c90np40z );
		if(getTotalCO("gnr_x_roles","status IN(0,1) and clic='$clinic' and doctor='$thisUser' and  date < $lateDate  and fast=2")){
			$flasher=' flasher ';	
		}
		if($flasher==''){
			if(getTotalCO("gnr_x_roles","status IN(0,1) and clic='$clinic' and doctor='$thisUser' and date < $now  and fast=2 ")){
				$flasher=' flasher2 ';			
			}
		}		
	}
	if($patN>0){$patN--;}
	echo '^'.$patN.'^'.$flasher;
}?>