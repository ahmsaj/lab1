<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	$r=getRec('osc_x_visits',$id);
	if($r['r']){
		$doctor=$r['doctor'];
		$patient=$r['patient'];
		$d_start=$r['d_start'];
		$d_check=$r['d_check'];
		$d_finish=$r['d_finish'];
		$type=$r['type'];
		$sub_type=$r['sub_type'];
		$status=$r['status'];
		$pay=$r['pay'];
		$ref=$r['ref'];
		$ref_no=$r['ref_no'];
		$ref_date=$r['ref_date'];
		$report=$r['report'];
		$doctor=$r['doctor'];
		$clinic=$r['clinic'];
		$pp=get_p_name($patient,3);?>
		<div class="win_body">
		<div class="form_header f1 fs18 clr1 lh40">
		<div class="fr clr5"><ff>#<?=$id?></ff></div>
			<ff><?=$patient?> | </ff><?=$pp[0].' [ '.$pp[1].' ]'?>
			<div class="fs14 f1 lh20 clr1111"><?=k_vis_status?> : <?=$stats_arr[$status];?></div>
		</div>
			<div class="form_body so" type="full"><? 
				if(($thisUser==$doctor || ($doctor==$thisUser && $doctor==0))){?>
					<div class="fs16 f1 lh40 clr1"><?=k_services?></div>
					<div><?
						$ser_times=array();
						$totalTime=0;
						$vis_status=get_val('osc_x_visits','status',$id);
						$timeLimit=0;
						if($vis_status==2){
							$vis_finish=get_val('osc_x_visits','d_finish',$id);
							if(($now-$vis_finish)<40000){$timeLimit=1;}
						}

						$sql="select * , x.id as xid from osc_m_services z , osc_x_visits_services x where z.id=x.service and x.visit_id='$id' order by z.ord ASC";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){				
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
							<tr>
								<th>'.k_service.'</th>
								<th width="120">'.k_tim.'</th>
								<th>'.k_status.'</th>
							</tr>';
							while($r=mysql_f($res)){
								$s_id=$r['xid'];
								$s_time=$r['ser_time']*60*_set_pn68gsh6dj;
								$s_status=$r['status'];
								$name=$r['name_'.$lg];			
								echo '<tr>			
								<td class="f1">'.$name.'</td>
								<td><ff>'.dateToTimeS2($s_time).'</ff></td>
								<td class="f1">'.$ser_status_Tex[$s_status].'</td>';
								echo'</tr>';
							}
							echo '</table>';			
						}	
						?>
					</div><? 
				}else{echo '<div class="winOprNote_err f1">'.k_no_perm_med_rep.'</div>';}?>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="<?=$wlp?>win('close','#m_info');"><?=k_close?></div><? 
				if(($thisUser==$doctor || ($doctor==$thisUser && $doctor==0))){
					$loc=$f_path.'_Preview-Osc.'.$id;?>
					<div class="bu bu_t1 fl" onclick="loc('<?=$loc?>');"><?=k_prev_edit?></div><? 
				}?>
			</div>
		</div><?
	}
}?>
