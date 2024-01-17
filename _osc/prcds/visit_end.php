<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v_id'],$_POST['t'])){	
	$v_id=pp($_POST['v_id']);
	$t=pp($_POST['t']);
	$r=getRec('osc_x_visits',$v_id);
	$status=$r['status'];
	$clinic=$r['clinic'];
	$dts_id=$r['dts_id'];
    $patient=$r['patient'];
	$mood=7;
	if($status!=''){		
		if($status>1){
			echo '2^';
		}else{
			$visData=getTotalCO('osc_x_visits_services_add'," visit_id='$v_id' ");
			if($t==1){
				echo '1^'?>						
				<div class="win_body">		 
					<div class="form_body so">
						<div class="f1 fs16 clr5"><?
						if($visData){
							echo k_end_vis_warn_rep_edit;
						}else{
							echo k_end_vis_warn_staff_chs;
						}

						?></div>
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info')" ><?=k_close?></div>
						<? if($visData){
							echo '<div class="bu bu_t4 fl" onclick="oscVisEnd(2)">'.k_endvis.' </div>';
						}else{
							echo '<div class="bu bu_t3 fl" onclick="cancelOscVisit('.$v_id.')">'.k_cancel_visit.'</div>';
						}?>
					</div>
				</div><?
			}
			if($t==2){
				echo '2^';
				if($status==1){					
					if(mysql_q("UPDATE osc_x_visits set status=2 , d_finish='$now' where id='$v_id'")){
                        fixWorkTime($v_id,7);
                        
						//if(_set_ruqswqrrpl){makeSerPayAlert($v_id,$mood);}					
						mysql_q("UPDATE gnr_x_roles set status=4 where vis='$v_id' and mood='$mood' ");
						mysql_q("UPDATE osc_x_visits_services set status=1 where visit_id='$v_id' ");
						mysql_q("DELETE from gnr_x_visits_timer where visit_id='$v_id' and mood='$mood'");
						if($dts_id){
							mysql_q("UPDATE dts_x_dates set status=4 where id='$dts_id' and type='$mood' ");
                            datesTempUp($dts_id);
						}
						fixVisitSevesOsc($v_id);
						fixDashData($clinic,7);
                        api_notif($patient,1,57,$v_id);
					}
				}
			}
		}		
	}	
}?>