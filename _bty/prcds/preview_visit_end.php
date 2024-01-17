<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v_id'])){	
	$v_id=pp($_POST['v_id']);
	$clinic=$userSubType;
	$mood=get_val('gnr_m_clinics','type',$clinic);	
	$ch1=getTotalCO("bty_x_visits"," id='$v_id' and doctor='$thisUser' and status=1");
	if($ch1){
		if($mood==5){$m_table='bty_x_visits';$m_table2='bty_x_visits_services';$q='';}
		if($mood==6){$m_table='bty_x_laser_visits';$m_table2='bty_x_laser_visits_services';}
        $pat=get_val($m_table,'patient',$v_id);
		$totalTime=0;
		$sql="select status from $m_table2 where visit_id='$v_id' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$n_srv=0;
			$e_srv=0;
			while($r=mysql_f($res)){				
				$s_status=$r['status'];
				if($s_status==0){$n_srv=1;}else{$e_srv=1;}
			}				
			if($n_srv==1 && $e_srv==0){			
				?>1^<div class="win_body">		 
					<div class="form_body so">
						<div class="f1 fs16 clr5"><?=k_must_fin_servs_end_vis_cancel_vis?></div>
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info')" ><?=k_close?></div>
						<div class="bu bu_t3 fl" onclick="cancelBtyVisit(<?=$v_id?>)"><?=k_cancel_visit?></div>
					</div>
				</div><?
			}else if($n_srv==0 && $e_srv==1){
				echo '2^';				
				if(mysql_q("UPDATE $m_table set status=2 , d_finish='$now'  where id='$v_id'")){
                    fixWorkTime($v_id,5);					
					if(_set_ruqswqrrpl){makeSerPayAlert($v_id,$mood);}
					delTempOpr($mood,$v_id,4);
					mysql_q("UPDATE gnr_x_roles set status=4 where vis='$v_id' and mood='$mood' ");
					mysql_q("delete FROM  $m_table2 where visit_id='$v_id' and status=2 ");
					mysql_q("DELETE from gnr_x_visits_timer where visit_id='$v_id' and mood='$mood' ");
					//mysql_q("DELETE from gnr_x_visits_timer where visit_id IN(select id from bty_x_visits where status>1 ) and clinic='$clinic'");
					if($mood==5){$vid_dts=get_val('bty_x_visits','dts_id',$v_id);}
					if($mood==6){$vid_dts=get_val('bty_x_laser_visits','dts_id',$v_id);}
					if($vid_dts>0){
                        mysql_q("UPDATE dts_x_dates SET status='4' , d_end_r='$now' where id ='$vid_dts' ");
                        datesTempUp($vid_dts);
                    }
					fixVisitSevesBty($v_id,$mood);
					fixDashData($clinic,$mood);
                    api_notif($pat,1,55,$v_id);
				}
			}else{
				echo '3^';
			}				
		}
	}
}?>