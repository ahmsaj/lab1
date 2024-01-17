<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){	
	$vis=pp($_POST['vis']);
	$vis_status=get_val('bty_x_visits','status',$vis);
	$clinic=$userSubType;
	$clinic_type=get_val('gnr_m_clinics','type',$clinic);
	echo getTotalCO("gnr_x_roles","status < 3 and clic='$clinic' and ( doctor='$thisUser' or doctor=0 )").'^';
	/**************************/
	echo dateToTimeS2(getDocWorkTime($vis,$clinic)).'^';
	/**************************/
	$ser_times=array();
	$totalTime=0;
	$sql="select * , x.id as xid , z.id as zid  from bty_m_services z , bty_x_visits_services x where z.id=x.service and x.visit_id='$vis' order by z.ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		if($clinic_type==5){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
			echo '<tr>';
			if($vis_status!=2){echo '<th width="40">'.k_cancel.'</th>';}
			echo '<th>'.k_service.'</th><th width="120">'.k_tim.'</th><th>'.k_status.'</th>';
			if($vis_status!=2){echo '<th width="40"><div class="buutAdd" onclick="btyAddNewServ('.$vis.')"></div></th>';}
			echo'</tr>';
			$i=0;
			while($r=mysql_f($res)){
				$s_id=$r['xid'];
				$srv_id=$r['zid'];
				$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
				$s_status=$r['status'];
				$cat=$r['cat'];				
				$name=get_val('bty_m_services_cat','name_'.$lg,$cat).' ( '.$r['name_'.$lg].' )';
				$r='';
				
				echo '<tr bgcolor="'.$ser_status_color[$s_status].'">';
				if($vis_status!=2){		
					echo '<td class="f1">';
					if($s_status==0 || $s_status==2){
						echo '<div class="ic40 icc2 ic40_del" title="'.k_cncl_serv.'" onclick="bty_caclSrv('.$s_id.',1)"></div>';
					}
					if($s_status==4){echo '<div class="ic40 icc1 ic40_ref" title="'.k_rt_srv.'" onclick="bty_caclSrv('.$s_id.',2)"></div>';}
					echo '</td>';
				}
				
				$statusTxtAdd='';
				if($s_status==2 && _set_ruqswqrrpl==1){
					$statusTxtAdd='<div class="f1 clr5">'.k_end_befr_pay.'</div>';
				}
				echo '<td class="f1">'.$name.$r.'</td>
				<td><ff>'.dateToTimeS2($s_time).'</ff></td>
				<td class="f1">'.$ser_status_Tex[$s_status].$statusTxtAdd.'</td>';
				if($vis_status!=2){
					echo '<td>';					
					if($s_status<2 || ($s_status==2 && _set_ruqswqrrpl==1)){
						$title='';
						if($s_status!=1){$title='title="'.k_ed_srv.'"';}
						echo '<div class="fl ic40 finshSrv'.$s_status.'" '.$title.' ';
						if($s_status==0 || $s_status==2 ){echo ' onclick="bty_finshSrv('.$s_id.')" ';}
						echo '></div>';					
					}
					echo '</td>';
				}
				echo '</tr>';
				if($s_status<3){
					$ser_times[$i]['time']=$s_time;
					$ser_times[$i]['name']=$name;
					$ser_times[$i]['status']=$s_status;
					$totalTime+=$s_time;
				}
				$i++;
			}
			echo '</table>';
		}	
	}	
	echo '^';
	/**************************/
	$work_time=getRealWorkTime($vis,5);	
	$bar2_width=(($work_time*100)/$totalTime);
	$servPart='';
	$p=1;
	$timeLine=0;	
	foreach($ser_times as $data){
		$pW=number_format(($data['time']/$totalTime*100),5);		
		$thisServGo=$work_time-$timeLine;
		$timeLine+=$data['time'];
		$endServ='';
		if($thisServGo>0){							
			$svText=$data['name'];
			$thisSrvTime=dateToTimeS2($data['time']).' / '.dateToTimeS2($thisServGo);
			if($data['time']<$thisServGo){$endServ='endServ';}			
		}
		$servPart.='<div class="fl '.$endServ.'" style="width:'.$pW.'%"><div>'.dateToTimeS2($data['time']).'</div></div>';
		$p++;
	}
	if($bar2_width>100){
		$svText='<div class="clr5 f1 fs14">'.k_prv_cmpsnc.'</div>';
		$thisSrvTime='<div class="ff clr5 B fs16">'.dateToTimeS2($thisServGo-$data['time']).'</div>';
		if($data['time']<$thisServGo){$endServ='endServ';}
	}
	if($work_time){?>
        <div class="ServSel fl">
            <div class="f1 fs12 lh30 of ws" style="background-color:#bbb"><?=$svText?></div>
            <div class="ff fs14 B lh20"><?=$thisSrvTime?></div>
        </div>
        <div class="ServSel2 fl" fix="wp:150">
            <div class="pr_tda fl">
                <div class="fl ff B fs16 ws"><?=dateToTimeS2($totalTime).' / '.dateToTimeS2($work_time);?></div>
                <div class="fr ff B fs18 ws"><?=number_format($bar2_width,1)?> % </div>
            </div>
            <div class="pti_bar cb">
                <div class="srvParts"><?=$servPart?></div>
                <div class="pti_bar_in" style="width:<?=number_format($bar2_width,4)?>%"><div class="fr"></div></div>
            </div>
        </div><?
	}else{
		if($vis_status==2){
			echo '<div class="lh40 fs18 f1 TC clr5">'.k_edt_vis.'</div>';
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