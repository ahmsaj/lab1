<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'] , $_POST['v_id'] , $_POST['t']) ){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	$t=pp($_POST['t']);
	$q='';
	if(_set_prtba6023==0 && $thisGrp!='hrwgtql5wk'){$q=" and doctor='$thisUser' ";}	
	
	$sql1="select * from cln_x_visits where patient='$p_id' $q order by d_start DESC";
	$res1=mysql_q($sql1);
	$rows1=mysql_n($res1);

	$sql2="select * from lab_x_visits where patient='$p_id' order $q by d_start DESC";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);

	$sql5="select * from bty_x_visits where patient='$p_id' order $q by d_start DESC";
	$res5=mysql_q($sql5);
	$rows5=mysql_n($res5);

	$sql6="select * from bty_x_laser_visits where patient='$p_id' $q order by d_start DESC";
	$res6=mysql_q($sql6);
	$rows6=mysql_n($res6);
	
	$rowsAll=$rows1+$rows2+$rows5+$rows6;
	if($t){		
		?><div class="win_body">
		<div class="form_header"><div class="f1 fs18 lh40"><?=get_p_name($p_id)?> <ff>( <?=$rowsAll?> )</ff> </div></div>
		<div class="form_body so" type="full"><? 
	}	
	
	if($rowsAll>0){
		if($t){echo '		
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
		<tr><th width="30">#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.'</th><th>'.k_status.'</th><th width="40"></th></tr>';}
		$lastDay=0;
		
		//--------------CLN-----
		while($r=mysql_f($res1)){
			$id=$r['id'];			
			$d_start=$r['d_start'];
			$d_finish=$r['d_finish'];
			$status=$r['status'];
			$type=$r['type'];
			$clinic=$r['clinic'];
			$doctor=$r['doctor'];
			
			if(_set_prtba6023){
				$clinic_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
				$doc_name=get_val('_users','name_'.$lg,$doctor);
			}
			//$v_date=k_current_visits;
			$v_date=dateToTimeS2_array($d_start);								
			//$str=array('d'=>0,'h'=>0,'d'=>0,'s'=>0,'x'=>0);
			$p_d1=his_data($id,'com');
			$p_d2=his_data($id,'dia');
			$p_d3=his_data($id,'cln');
			$p_d4=his_data($id,'str');
			$p_d5=$r['note'];				
			
			if($t){
				echo '<tr>				
				<td><ff>'.$id.'</ff></td>
				<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
				<td txt>'.$clinic_name.'</td>
				<td txt>'.$doc_name.'</td>
				<td><span  class="f1 fs14" style="color:'.$stats_arr_col[$status].'">'.$stats_arr[$status].'</span></td>
				<td><div class="info_icon" title="'.k_visit_details.'" onclick="showVd('.$id.',0)"></div></td>
				</tr>';
			}else{
				if($lastDay!=0){				
					?><div class="vis_bettween">
						<div class="vis_bettween_in">
							<div class="fl vis_b_l"></div>
							<div class="fl vis_b_c"><?=timeAgo($lastDay-$d_start)?></div>
							<div class="fl vis_b_r"></div>
						</div>
					</div><?
					$lastDay=$d_start;
				}else{
					$lastDay=$d_start;
				}?>
				<div class="hisList">
				<div class="hisList_d">
					<? if($v_id==$id){
						?><div class="f1 fl fs16" ><?=k_curr_visit?> ( <?=$clinic_name?> ) [ <?=$doc_name?> ]</div><?
					}else{?>
						<div class="ff fl" d><?=date('d',$d_start)?></div>				
						<div class="f1 fl" m><?=$monthsNames[date('n',$d_start)]?></div>
						<div class="ff fl" y><?=date('Y',$d_start)?></div>
						<? if(_set_prtba6023){?><div class="f1 fs16 fl" > ( <?=$clinic_name?> ) [ <?=$doc_name?> ]</div><? }?>
					<? }?>
					<div class="f1 fr" s><?=timeAgo(date('U')-$d_start)?></div>

				</div>
				<? if($p_d1!=''){?><div class="his_con f1"><div class="his_icon1"></div><?=k_cmpnt?> : <?=$p_d1?></div><? }?>          
				<? if($p_d3!=''){?><div class="his_con f1"><div class="his_icon2"></div><?=k_sick_story?> : <?=$p_d3?></div><? }?>
				<? if($p_d4!=''){?><div class="his_con f1"><div class="his_icon2"></div><?=k_clincal_examination?> : <?=$p_d4?></div><? }?>
				<? if($p_d2!=''){?><div class="his_con f1"><div class="his_icon2"></div><?=k_diag?> : <?=$p_d2?></div><? }?>
				<? if($p_d5!=''){?><div class="his_con f1"><div class="his_icon3"></div><?=k_notes?> : <?=nl2br($p_d5)?></div><? }?>
				<div class="his_con3"><?=getVisitLink($id)?></div>        
				</div><?
			}
		}
		//--------------BTY-----
		while($r=mysql_f($res5)){
			$id=$r['id'];			
			$d_start=$r['d_start'];
			$d_finish=$r['d_finish'];
			$status=$r['status'];
			$type=$r['type'];
			$clinic=$r['clinic'];
			$doctor=$r['doctor'];
			if(_set_prtba6023){
				$clinic_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
				$doc_name=get_val('_users','name_'.$lg,$doctor);
			}			
			if($t){
				echo '<tr>				
				<td><ff>'.$id.'</ff></td>
				<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
				<td txt>'.$clinic_name.'</td>
				<td txt>'.$doc_name.'</td>
				<td><span  class="f1 fs14" style="color:'.$stats_arr_col[$status].'">'.$stats_arr[$status].'</span></td>
				<td></td>
				</tr>';
			}
		}
		//--------------LSR-----
		while($r=mysql_f($res6)){
			$id=$r['id'];			
			$d_start=$r['d_start'];
			$d_finish=$r['d_finish'];
			$status=$r['status'];
			$type=$r['type'];
			$clinic=$r['clinic'];
			$doctor=$r['doctor'];
			if(_set_prtba6023){
				$clinic_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
				$doc_name=get_val('_users','name_'.$lg,$doctor);
			}			
			if($t){
				echo '<tr>				
				<td><ff>'.$id.'</ff></td>
				<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
				<td txt>'.$clinic_name.'</td>
				<td txt>'.$doc_name.'</td>
				<td><span  class="f1 fs14" style="color:'.$stats_arr_col[$status].'">'.$stats_arr[$status].'</span></td>
				<td></td>
				</tr>';
			}
		}
		if($t){echo '</table>';}
	}else{
		echo '<div class="f1 fs18 clr5">'.k_npat_prv_pre.'</div>';
	}
	if($t){?></div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
    </div>
    </div><? }
}?>