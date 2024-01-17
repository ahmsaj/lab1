<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$p_id=pp($_POST['id']);
    fixPatAccunt($p_id);
	$sql="select * from gnr_m_patients where id='$p_id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$r=mysql_f($res);
		$birth=$r['birth_date'];
		$birthCount=birthCount($birth);
		?>
		<div class="win_body">
		<div class="form_header">
			<div class="fl f1 fs16 lh40"><?=get_p_name($p_id).' [ <ff>'.$birthCount[0].'</ff> '.$birthCount[1].' ]'?> </div>
            <div class="ic40 icc1 icc1 iconPrint fr" title="<?=k_print?>" onclick="printpaVisits(<?=$p_id?>)"></div>
		</div>
        <div class="form_body so"><?
		$sql1="select * from cln_x_visits where patient='$p_id' order by d_start DESC";
		$res1=mysql_q($sql1);
		$rows1=mysql_n($res1);
		
		$sql2="select * from lab_x_visits where patient='$p_id' order by d_start DESC";
		$res2=mysql_q($sql2);
		$rows2=mysql_n($res2);
		
		$sql3="select * from xry_x_visits where patient='$p_id' order by d_start DESC";
		$res3=mysql_q($sql3);
		$rows3=mysql_n($res3);
		
		$sql4="select * from den_x_visits where patient='$p_id' order by d_start DESC";
		$res4=mysql_q($sql4);
		$rows4=mysql_n($res4);
		
		$sql5="select * from bty_x_visits where patient='$p_id' order by d_start DESC";
		$res5=mysql_q($sql5);
		$rows5=mysql_n($res5);
		
		$sql6="select * from bty_x_laser_visits where patient='$p_id' order by d_start DESC";
		$res6=mysql_q($sql6);
		$rows6=mysql_n($res6);
		
		$sql7="select * from osc_x_visits where patient='$p_id' order by d_start DESC";
		$res7=mysql_q($sql7);
		$rows7=mysql_n($res7);
		
		$rowsAll=$rows1+$rows2+$rows3+$rows4+$rows5+$rows6+$rows7;
		if($rowsAll>0){echo '<div class="f1 fs18 clr1 lh40 uLine">'.k_vis_no.' <ff>[ '.$rowsAll.' ] </ff></div>';}
		//-------------CLN-----------
		if($rows1){ 
			echo '<div class="f1 fs18 clr1 lh40">'.k_clinics.' <ff>[ '.$rows1.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.'</th><th>'.k_stime.'</th><th> '.k_end_bord.' / '.k_cancel.'</th><th>'.k_services.'</th><th>'.k_status.'</th></tr>';			
			while($r=mysql_f($res1)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$time_entr=$r['d_start'];
				$time_chck=$r['d_check'];
				$time_out=$r['d_finish'];
				$type=$r['type'];				
				$v_status=$r['status'];
				$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}
				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_not_existed;}
				$status2='';
				if($v_status==2){
					$x_srv=getTotalCO('cln_x_visits_services'," visit_id='$v_id' and status=0 ");
					if($x_srv>0){
						$status2='<div class="f1 clr5">'.k_services_not_complete_amount.' <span class="ff B clr5"> ( '.$x_srv.' )</span></div>';
					}
				}				
				if($v_status==1){
					$add_srv=getTotalCO('cln_x_visits_services'," visit_id='$v_id' and status=2 ");
					if($add_srv>0){
						$status2='<div class="f1 clr5">'.k_additional_services_amount.' <span class="ff B clr5"> ( '.$add_srv.' )</span></div>';
					}
				}
				$services=get_vals('cln_x_visits_services','service'," visit_id='$v_id'");
				$servicesNames=get_vals('cln_m_services','name_'.$lg," id IN($services)",' | ');
				$d_checkT=$d_finishT='-';
				if($time_chck){$d_checkT=clockStr($time_chck-($time_chck-($time_chck%86400)));}
				if($time_out){$d_finishT=clockStr($time_out-($time_out-($time_out%86400)));}
				echo '				
				<tr>
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$time_entr).'</ff></td>				
				<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
				<td class="f1 fs14">'.$doc.'</td>
				<td><ff>'.$d_checkT.'</ff></td>
				<td><ff>'.$d_finishT.'</ff></td>
				<td txt>'.$servicesNames.'</td>
				<td><span class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';            
		}
		//-------------LAB-----------	
		if($rows2){
			echo '<div class="f1 fs18 clr1 lh40">'.k_thlab.' <ff>[ '.$rows2.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_stime.'</th><th> '.k_end_bord.' / '.k_cancel.'</th><th>'.k_services.'</th><th>'.k_status.'</th></tr>';			
			while($r=mysql_f($res2)){
				$v_id=$r['id'];				
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$time_entr=$r['d_start'];
				$time_chck=$r['d_check'];
				$time_out=$r['d_finish'];
				$type=$r['type'];				
				$v_status=$r['status'];
				$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}
				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_not_existed;}
				$status2='';
				if($v_status==2){
					$x_srv=getTotalCO('lab_x_visits_services'," visit_id='$v_id' and status=0 ");
					if($x_srv>0){
						$status2='<div class="f1 clr5">'.k_services_not_complete_amount.' <span class="ff B clr5"> ( '.$x_srv.' )</span></div>';
					}
				}				
				if($v_status==1){
					$add_srv=getTotalCO('lab_x_visits_services'," visit_id='$v_id' and status=2 ");
					if($add_srv>0){
						$status2='<div class="f1 clr5">'.k_additional_services_amount.' <span class="ff B clr5"> ( '.$add_srv.' )</span></div>';
					}
				}
				$services=get_vals('lab_x_visits_services','service'," visit_id='$v_id'");
				$servicesNames='';
				if($services){
					$servicesNames=get_vals('lab_m_services','short_name'," id IN($services)",' | ');
				}
				$d_checkT=$d_finishT='-';
				if($time_chck){$d_checkT=clockStr($time_chck-($time_chck-($time_chck%86400)));}
				if($time_out){$d_finishT=clockStr($time_out-($time_out-($time_out%86400)));}
				echo '				
				<tr>
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$time_entr).'</ff></td>
				<td><ff>'.$d_checkT.'</ff></td>
				<td><ff>'.$d_finishT.'</ff></td>
				<td><ff class="fs14">'.$servicesNames.'</ff></td>
				<td><span class="f1 fs14" style="color:'.$lab_vis_sClr[$v_status].'">'.$lab_vis_s[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';            
		}
		//-------------XRY-----------
		if($rows3){
			echo '<div class="f1 fs18 clr1 lh40">'.k_txry.' <ff>[ '.$rows3.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.' / '.k_technician.'</th><th>'.k_stime.'</th><th> '.k_end_bord.' / '.k_cancel.'</th><th>'.k_services.'</th><th>'.k_status.'</th></tr>';			
			while($r=mysql_f($res3)){
				$v_id=$r['id'];
				$doctor=$r['ray_tec'];
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$time_entr=$r['d_start'];
				$time_chck=$r['d_check'];
				$time_out=$r['d_finish'];
				$type=$r['type'];				
				$v_status=$r['status'];
				$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}
				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_not_existed;}
				$status2='';
				if($v_status==2){
					$x_srv=getTotalCO('xry_x_visits_services'," visit_id='$v_id' and status=0 ");
					if($x_srv>0){
						$status2='<div class="f1 clr5">'.k_services_not_complete_amount.' <span class="ff B clr5"> ( '.$x_srv.' )</span></div>';
					}
				}				
				if($v_status==1){
					$add_srv=getTotalCO('xry_x_visits_services'," visit_id='$v_id' and status=2 ");
					if($add_srv>0){
						$status2='<div class="f1 clr5">'.k_additional_services_amount.' <span class="ff B clr5"> ( '.$add_srv.' )</span></div>';
					}
				}
				$services=get_vals('xry_x_visits_services','service'," visit_id='$v_id'");
				$servicesNames=get_vals('xry_m_services','name_'.$lg," id IN($services)",' | ');
				$d_checkT=$d_finishT='-';
				if($time_chck){$d_checkT=clockStr($time_chck-($time_chck-($time_chck%86400)));}
				if($time_out){$d_finishT=clockStr($time_out-($time_out-($time_out%86400)));}
				echo '				
				<tr>
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$time_entr).'</ff></td>				
				<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
				<td class="f1 fs14">'.$doc.'</td>
				<td><ff>'.$d_checkT.'</ff></td>
				<td><ff>'.$d_finishT.'</ff></td>
				<td txt>'.$servicesNames.'</td>
				<td><span class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';            
		}
		//-------------DEN-----------
		if($rows4){
			echo '<div class="f1 fs18 clr1 lh40">'.k_thdental.' <ff>[ '.$rows4.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.'</th><th>'.k_stime.'</th><th> '.k_end_bord.' / '.k_cancel.'</th><th>'.k_status.'</th></tr>';			
			while($r=mysql_f($res4)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$time_entr=$r['d_start'];
				$time_chck=$r['d_check'];
				$time_out=$r['d_finish'];
				$type=$r['type'];				
				$v_status=$r['status'];
				$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}
				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_not_existed;}
				$status2='';
			
				//$services=get_vals('den_x_visits_services','service'," visit_id='$v_id'");
				//$servicesNames=get_vals('den_m_services','name_'.$lg," id IN($services)",' | ');
				$d_checkT=$d_finishT='-';
				if($time_chck){$d_checkT=clockStr($time_chck-($time_chck-($time_chck%86400)));}
				if($time_out){$d_finishT=clockStr($time_out-($time_out-($time_out%86400)));}
				echo '				
				<tr>
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$time_entr).'</ff></td>				
				<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
				<td class="f1 fs14">'.$doc.'</td>
				<td><ff>'.$d_checkT.'</ff></td>
				<td><ff>'.$d_finishT.'</ff></td>				
				<td><span class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';            
		}
		//-------------BTY-----------
		if($rows5){
			echo '<div class="f1 fs18 clr1 lh40">'.k_tbty.' <ff>[ '.$rows5.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.'</th><th>'.k_stime.'</th><th> '.k_end_bord.' / '.k_cancel.'</th><th>'.k_services.'</th><th>'.k_status.'</th></tr>';			
			while($r=mysql_f($res5)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$time_entr=$r['d_start'];
				$time_chck=$r['d_check'];
				$time_out=$r['d_finish'];
				$type=$r['type'];				
				$v_status=$r['status'];
				/*$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}*/
				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_not_existed;}
				$status2='';
				if($v_status==2){
					$x_srv=getTotalCO('bty_x_visits_services'," visit_id='$v_id' and status=0 ");
					if($x_srv>0){
						$status2='<div class="f1 clr5">'.k_services_not_complete_amount.' <span class="ff B clr5"> ( '.$x_srv.' )</span></div>';
					}
				}				
				if($v_status==1){
					$add_srv=getTotalCO('bty_x_visits_services'," visit_id='$v_id' and status=2 ");
					if($add_srv>0){
						$status2='<div class="f1 clr5">'.k_additional_services_amount.' <span class="ff B clr5"> ( '.$add_srv.' )</span></div>';
					}
				}
				$services=get_vals('bty_x_visits_services','service'," visit_id='$v_id'");
				$servicesNames=get_vals('bty_m_services','name_'.$lg," id IN($services)",' | ');
				$d_checkT=$d_finishT='-';
				if($time_chck){$d_checkT=clockStr($time_chck-($time_chck-($time_chck%86400)));}
				if($time_out){$d_finishT=clockStr($time_out-($time_out-($time_out%86400)));}
				echo '				
				<tr>
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$time_entr).'</ff></td>				
				<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
				<td class="f1 fs14">'.$doc.'</td>
				<td><ff>'.$d_checkT.'</ff></td>
				<td><ff>'.$d_finishT.'</ff></td>
				<td txt>'.$servicesNames.'</td>
				<td><span class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';            
		}
		//-------------LZR-----------
		if($rows6){
			echo '<div class="f1 fs18 clr1 lh40">'.k_tlaser.' <ff>[ '.$rows6.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.'</th><th>'.k_stime.'</th><th> '.k_end_bord.' / '.k_cancel.'</th><th>'.k_services.'</th><th>'.k_status.'</th></tr>';			
			while($r=mysql_f($res6)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$time_entr=$r['d_start'];
				$time_chck=$r['d_check'];
				$time_out=$r['d_finish'];
				$type=$r['type'];				
				$v_status=$r['status'];
				/*$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}*/
				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_not_existed;}
				$status2='';
				if($v_status==2){
					$x_srv=getTotalCO('bty_x_laser_visits_services'," visit_id='$v_id' and status=0 ");
					if($x_srv>0){
						$status2='<div class="f1 clr5">'.k_services_not_complete_amount.' <span class="ff B clr5"> ( '.$x_srv.' )</span></div>';
					}
				}				
				if($v_status==1){
					$add_srv=getTotalCO('bty_x_laser_visits_services'," visit_id='$v_id' and status=2 ");
					if($add_srv>0){
						$status2='<div class="f1 clr5">'.k_additional_services_amount.' <span class="ff B clr5"> ( '.$add_srv.' )</span></div>';
					}
				}
				$services=get_vals('bty_x_laser_visits_services','service'," visit_id='$v_id'");
				$servicesNames=get_vals('bty_m_services','name_'.$lg," id IN($services)",' | ');
				$d_checkT=$d_finishT='-';
				if($time_chck){$d_checkT=clockStr($time_chck-($time_chck-($time_chck%86400)));}
				if($time_out){$d_finishT=clockStr($time_out-($time_out-($time_out%86400)));}
				echo '				
				<tr>
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$time_entr).'</ff></td>				
				<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
				<td class="f1 fs14">'.$doc.'</td>
				<td><ff>'.$d_checkT.'</ff></td>
				<td><ff>'.$d_finishT.'</ff></td>
				<td txt>'.$servicesNames.'</td>
				<td><span class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';            
		}
		//-------------OSC-----------
		if($rows7){
			 
			echo '<div class="f1 fs18 clr1 lh40">'.k_endoscopy.' <ff>[ '.$rows7.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.'</th><th>'.k_stime.'</th><th> '.k_end_bord.' / '.k_cancel.'</th><th>'.k_services.'</th><th>'.k_status.'</th></tr>';			
			while($r=mysql_f($res7)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$time_entr=$r['d_start'];
				$time_chck=$r['d_check'];
				$time_out=$r['d_finish'];
				$type=$r['type'];				
				$v_status=$r['status'];
				$work=$r['work'];
				$workTxt='';
				if($work){
					$workPers=($work*100)/($time_out-$time_chck);
					$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
					<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
				}
				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_not_existed;}
				$status2='';
				if($v_status==2){
					$x_srv=getTotalCO('osc_x_visits_services'," visit_id='$v_id' and status=0 ");
					if($x_srv>0){
						$status2='<div class="f1 clr5">'.k_services_not_complete_amount.' <span class="ff B clr5"> ( '.$x_srv.' )</span></div>';
					}
				}				
				if($v_status==1){
					$add_srv=getTotalCO('osc_x_visits_services'," visit_id='$v_id' and status=2 ");
					if($add_srv>0){
						$status2='<div class="f1 clr5">'.k_additional_services_amount.' <span class="ff B clr5"> ( '.$add_srv.' )</span></div>';
					}
				}
				$services=get_vals('osc_x_visits_services','service'," visit_id='$v_id'");
				$servicesNames=get_vals('osc_m_services','name_'.$lg," id IN($services)",' | ');
				$d_checkT=$d_finishT='-';
				if($time_chck){$d_checkT=clockStr($time_chck-($time_chck-($time_chck%86400)));}
				if($time_out){$d_finishT=clockStr($time_out-($time_out-($time_out%86400)));}
				echo '				
				<tr>
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$time_entr).'</ff></td>				
				<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
				<td class="f1 fs14">'.$doc.'</td>
				<td><ff>'.$d_checkT.'</ff></td>
				<td><ff>'.$d_finishT.'</ff></td>
				<td txt>'.$servicesNames.'</td>
				<td><span class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';            
		           
		}
		/****************************************************************/
		if($rowsAll==0){echo '<div class="f1 fs14 clr5 lh40">'.k_no_vis_pat.' </div>';}
		/****************************************************************/?>
		</div>
		<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div></div>
		</div><?
	}else{echo '<div class="f1 fs14 clr5 lh40">'.k_no_patient_number.' <ff>'.$p_id.'</ff></div>';}
	
}
?>