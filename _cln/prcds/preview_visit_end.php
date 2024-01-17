<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v_id'])){	
	$v_id=pp($_POST['v_id']);
	$m_table='cln_x_visits';$m_table2='cln_x_visits_services';
	list($clinic,$dts_id)=get_val($m_table,'clinic,dts_id',$v_id);		
	$ch1=getTotalCO($m_table," id='$v_id' and doctor='$thisUser' and status =1");
	$mood=1;
	if($ch1){		
		$totalTime=0;
		$sql="select status,service from $m_table2 where visit_id='$v_id' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$n_srv=0;
			$e_srv=0;
			$editPrice=0;
			while($r=mysql_f($res)){	
				$s_status=$r['status'];
				$service=$r['service'];
				if($s_status==2){
					$ep=get_val('cln_m_services','edit_price',$service);
					if($ep){$editPrice=1;}
				}
				if($s_status==0){$n_srv=1;}else{$e_srv=1;}
			}				
			if($n_srv==1 && $e_srv==0){
				?>1^<div class="win_body">		 
					<div class="form_body so">
						<div class="f1 fs16 clr5"><?=k_must_fin_servs_end_vis_cancel_vis?></div>
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info')" ><?=k_close?></div>
						<div class="bu bu_t3 fl" onclick="cancelVisit(<?=$v_id?>)"><?=k_cancel_visit?></div>
					</div>
				</div><?
			}else if($n_srv==0 && $e_srv==1 && $editPrice==0){
				echo '2^';				
				if(mysql_q("UPDATE $m_table set status=2 , d_finish='$now'  where id='$v_id'")){
                    fixWorkTime($v_id,1);
					if(_set_ruqswqrrpl){makeSerPayAlert($v_id,$mood);}
					delTempOpr($mood,$v_id,4);
					
					mysql_q("UPDATE gnr_x_roles set status=4 where vis='$v_id' and mood='$mood' ");
					mysql_q("delete FROM  $m_table2 where visit_id='$v_id' and status=2 ");
					mysql_q("DELETE from gnr_x_visits_timer where visit_id='$v_id' and mood='$mood'");					
					if($dts_id>0){
                        mysql_q("UPDATE dts_x_dates SET status='4' , d_end_r='$now' where id ='$dts_id' ");
                        datesTempUp($dts_id);
                    }
					fixVisitSevesCln($v_id);
					fixDashData($clinic,1);
                    api_notif($pat,1,51,$v_id);
				}
			}else{
				echo '3^';
			} 
		}
	}
}?>