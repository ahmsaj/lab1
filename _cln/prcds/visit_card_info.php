<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'])){
	$p_id=pp($_POST['t'],'s');
	$vv=explode('-',$p_id);
	if(count($vv)==2){
		echo '0^<div class="f1 fs14 clr5 lh40">'.k_num_for_tick_not_pat.' </div>';
	}else{
	$p_id=intval($p_id);
	$sql="select * from gnr_m_patients where id='$p_id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	echo $rows.'^';	
	if($rows>0){
		$r=mysql_f($res);
		$birth=$r['birth_date'];
		$birthCount=birthCount($birth);
		?>
		<div class="win_body">
		<div class="form_header">
		<div class="fl f1 fs16 lh40"><ff><?=$p_id?></ff> | <?=get_p_name($p_id)?><span class="f1 clr5 fs16 Over" onclick="editPaVis(<?=$p_id?>,0)"> ( <?=k_edit?> ) </span> </div>
            <div class="fr f1 fs16 lh40"><?=' [ <ff>'.$birthCount[0].'</ff> '.$birthCount[1].' ] '?></div>
		</div>
        <div class="form_body so"><?
		$sql="select * from cln_x_visits where patient='$p_id' order by d_start DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<div class="f1 fs18 clr1 lh40">'.k_vis_no.'<ff>[ '.$rows.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_clinic.'</th><th>'.k_doctor.'</th><th>'.k_status.'</th></tr>'; 
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$patient=$r['patient'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$type=$r['type'];				
				$v_status=$r['status'];				
				if($doctor){$doc=get_val('_users','name_'.$lg,$doctor);}else{$doc=k_no_results;}
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
				echo '
				<tr onclick="check_tik_do(\'1-'.$v_id.'\')" class="cur">
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
				<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
				<td class="f1 fs14">'.$doc.'</td>
				<td class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';
            
		}
		$sql="select * from lab_x_visits where patient='$p_id' order by d_start DESC";
		$res=mysql_q($sql);
		$rows2=mysql_n($res);
		if($rows2>0){
			echo '<div class="f1 fs18 clr1 lh40">'.k_tests.' <ff>[ '.$rows2.' ] </ff></div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
			<tr><th>#</th><th>'.k_date.'</th><th>'.k_status.'</th></tr>'; 
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$patient=$r['patient'];
				$d_start=$r['d_start'];
				$type=$r['type'];				
				$v_status=$r['status'];				
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
				echo '
				<tr onclick="check_tik_do(\'2-'.$v_id.'\')" class="cur">
				<td><ff>'.$v_id.'</ff></td>
				<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
				<td class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$stats_arr[$v_status].$status2.'</td>
				</tr>';
			}
			echo '</table>';
            
		}
		if($rows+$rows2==	0){echo '<div class="f1 fs14 clr5 lh40">'.k_no_vis_pat.' </div>';}
		/****************************************************************/?>
		</div>
		<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div></div>
		</div><?
	}else{echo '<div class="f1 fs14 clr5 lh40">'.k_no_patient_number.' <ff>'.$p_id.'</ff></div>';}
	}
}
?>