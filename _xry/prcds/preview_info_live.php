<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){	
	$vis=pp($_POST['vis']);	list($vis_status,$clinic)=get_val('xry_x_visits','status,clinic',$vis);
	//echo $clinic;//=$userSubType;
	$clinic_type=3;
	echo getTotalCO("gnr_x_roles","status < 3 and clic in($clinic) and ( doctor='$thisUser' or doctor=0 )").'^';
	/**************************/
	echo dateToTimeS2(getDocWorkTime($vis,$clinic)).'^';
	/**************************/
	$ser_times=array();
	$totalTime=0;
	$srvs=get_vals('xry_x_visits_services','service',"visit_id='$vis'");
	$srvTime=get_sum('xry_m_services','ser_time'," id IN ($srvs)");	
	$totalTime=$srvTime*_set_pn68gsh6dj*60;
	/**************************/
	$work_time=getRealWorkTime($vis,3);
	$bar2_width=(($work_time*100)/$totalTime);	
	$defTime=$totalTime-$work_time;
	$barC='cbg6';
	$bgC='cbg666';
	$statusTxt=k_remain_time_for_visit;
	if($work_time>$totalTime){
		$defTime=$work_time-$totalTime;
		$barC='cbg5';
		$bgC='cbg555';
		$bar2_width=100;
		$statusTxt=k_prv_cmpsnc;
	}	
	if($work_time){?>
		<div class="f1 fs12 lh30 of fs14 w100 pd10 <?=$bgC?>"><?=$statusTxt?>: <ff class="fs16"><?=dateToTimeS2($defTime)?></ff></div>		
		<div class="f1 fs12 lh10 of ws w100 pd10 <?=$bgC?>">
		<ff class="fs14"><?=dateToTimeS2($totalTime).' / '.dateToTimeS2($work_time);?> | <?=number_format($bar2_width,1)?> % </ff></div>		
		<div class="cbg444 fl w100" fix="h:10">
			<div class="<?=$barC?> fl t_bord" fix="h:10" style="width:<?=$bar2_width?>%">&nbsp;</div>
		</div>
		<?
	}else{
		if($vis_status==2){
			echo '<div class="lh60 fs14 cbg555 f1 TC clr5">'.k_visit_finshd.'</div>';
		}
	}
	/**************************/
	echo '^';
	$timeClass='fr timeStatus';
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
	echo $timeClass.$flasher;
	
	
	
}?>