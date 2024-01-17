<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){	
	$vis=pp($_POST['vis']);
	list($vis_status,$pay_type)=get_val('cln_x_visits','status,pay_type',$vis);
	$clinic=$userSubType;	
	echo getTotalCO("gnr_x_roles","status < 3 and clic='$clinic' and ( doctor='$thisUser' or doctor=0 )").'^';	
	/**************************/
	echo dateToTimeS2(getDocWorkTime($vis,$clinic)).'^';
	/**************************/
	$ser_times=array();
	$totalTime=0;
	$sql="select * , x.id as xid , z.id as zid  from cln_m_services z , cln_x_visits_services x where z.id=x.service and x.visit_id='$vis' order by z.ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
	echo '<tr>';
	if($vis_status!=2){echo '<th width="40">'.k_cancel.'</th>';}
	echo '<th>'.k_service.'</th><th width="120">'.k_tim.'</th><th>'.k_status.'</th>';
	if($vis_status!=2){echo '<th width="40"><div class="buutAdd" onclick="addNewServ('.$vis.')"></div></th>';}
	echo'</tr>';
	if($rows>0){
		$actRows=getTotalCO('cln_x_visits_services',"visit_id='$vis' and status not in(4)");		
		$i=0;
		while($r=mysql_f($res)){
			$s_id=$r['xid'];
			$srv_id=$r['zid'];
			$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
			$s_status=$r['status'];
			$pay_net=$r['pay_net'];
			$edit_price=$r['edit_price'];
			$rev=$r['rev'];				
			$name=$r['name_'.$lg];
			$r='';
			$ins_status_txt='';
			$cancelSrv=1;
			if($pay_type==3){
				$cancelSrv=0;
				$res_status=get_val_con('gnr_x_insurance_rec','res_status',"service_x='$s_id' and mood=1 ");
				if($res_status!=''){				
					if($res_status==0){$ins_status_txt='<div class="f1 clr1">'.k_insurance_pen_sts.' :</div>';}
					if($res_status==1){$ins_status_txt='<div class="f1 clr6">'.k_acceptance_ins_sts.' :</div>';}
					if($res_status==2){$ins_status_txt='<div class="f1 clr5">'.k_ins_case_denied.' :</div>';$cancelSrv=1;}
				}else{
					$cancelSrv=1;
				}		
			}
			if($rev){$r='<span class="f1 fs12 clr5"> ( '.k_review.' )</span>';}
			echo '<tr bgcolor="'.$ser_status_color[$s_status].'">';
			if($vis_status!=2){
				echo '<td class="f1">';
				if(($s_status==0 || $s_status==2) && $cancelSrv && $actRows>1){
					echo '<div class="ic40 icc2 ic40_del" title="'.k_cncl_serv.'" onclick="caclSrv('.$s_id.',1)"></div>';
				}
				if($s_status==4){echo '<div class="ic40 icc1 ic40_ref" title="'.k_rt_srv.'" onclick="caclSrv('.$s_id.',2)"></div>';}
				echo '</td>';
			}

			$statusTxtAdd='';
			if($s_status==2 && _set_ruqswqrrpl==1){
				$statusTxtAdd='<div class="f1 clr5">'.k_end_befr_pay.'</div>';
			}
			$priceChange='';
			if($edit_price==1 && ($s_status==0 || $s_status==2) && $pay_net==0){
				$priceChange='<div class="bu2 bu_t3 buu" onclick="changePrice('.$s_id.')">'.k_set_price.'</div>';
			}
			echo '<td class="f1">'.$name.$r.$ins_status_txt.'</td>
			<td><ff>'.dateToTimeS2($s_time).'</ff></td>
			<td class="f1">'.$ser_status_Tex[$s_status].$statusTxtAdd.$priceChange.'</td>';
			if($vis_status!=2){
				echo '<td>';				

				if($s_status<2 || (($s_status==2 && _set_ruqswqrrpl==1) )){
					$title='';
					if($s_status!=1){$title=k_ed_srv;}
					if($edit_price==0 || $pay_net>0){
						echo '<div class="fl ic40 finshSrv'.$s_status.'" title="'.$title.'" ';
						if($s_status==0  || $s_status==2 ){echo ' onclick="chkSrvBefEnd('.$srv_id.','.$s_id.',0)" ';}
						echo '></div>';	
					}
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
	}
	echo '</table>';
	echo '^';
	/**************************/
	$work_time=getRealWorkTime($vis,1);	
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
		list($d,$n)=get_val_con('gnr_x_roles','date,no',"status IN(0,1) and clic='$clinic' and fast=2",' order by no ASC');
		if($d){
			$conf=max($d%86400,$n);			
			$dNow=$now%86400;
			if($dNow>$conf){
				$flasher=' flasher2';
			}
			if($dNow>$conf+(60*_set_d9c90np40z)){
				$flasher=' flasher';
			}
		}
	}
	echo $timeClass.$flasher;
	
	
	
}?>