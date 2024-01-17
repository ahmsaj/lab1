<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'] , $_POST['id'])){
	$t=pp($_POST['t']);
	$id=pp($_POST['id']);
	$clinic=$userSubType;
	if($t==1){
		list($dts_id,$doctor)=get_val('bty_x_laser_visits','dts_id,doctor',$id);
		if($doctor!=$thisUser){out();exit;}
		$f=getTotalCO('bty_x_laser_visits_services',"visit_id='$id' and  status=1 ");
		if($f==0){
			if($dts_id){
				if(mysql_q("UPDATE dts_x_dates set status= 2 where status=3 and type=6 and id='$dts_id' ")){
                    datesTempUp($dts_id);
					mysql_q("UPDATE gnr_x_roles set status=0 where mood='6' AND vis='$id' ");
					echo 1;
				}
			}else{
				if(getTotalCO('bty_x_laser_visits'," id='$id' and doctor='$thisUser' ")==1){
					if(mysql_q("UPDATE bty_x_laser_visits set status= 3 , work=0 where id='$id'")){
						if(mysql_q("UPDATE gnr_x_roles set status=4 where vis='$id' and mood=6")){					
							mysql_q("DELETE from gnr_x_visits_timer where visit_id='$id' and mood=6 ");
							mysql_q("DELETE from bty_x_laser_visits_services where visit_id='$id' ");
							mysql_q("DELETE from bty_x_laser_visits_services_vals where visit_id='$id' ");
							delTempOpr(6,$id,'a');
							echo 1;				
						}
					}
				}
			}
		}
	}
	if($t==2){
		$vis=get_val('bty_x_laser_visits_services','visit_id',$id);
		$doctor=get_val('bty_x_laser_visits','doctor',$vis);
		if($doctor!=$thisUser){out();exit;}
		$f=getTotalCO('bty_x_laser_visits_services',"visit_id='$vis'");
		$s_work=getTotalCO('bty_x_laser_visits_services_vals',"serv_x='$id' and status=1");
		if($f>1 && $s_work==0){			
			if(mysql_q("DELETE from bty_x_laser_visits_services where status=0 and id='$id' ")){
				mysql_q("DELETE from bty_x_laser_visits_services_vals where serv_x='$id' ");
				echo 1;
			}
		}
	}
}?>