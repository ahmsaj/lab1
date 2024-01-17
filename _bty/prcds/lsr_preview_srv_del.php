<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['id'],$_POST['type'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$type=pp($_POST['type']);
	$r=getRec('bty_x_laser_visits',$vis);
	if($r['r']){
		$doctor=$r['doctor'];
		$vis_status=$r['status'];		
		if($doctor==$thisUser && $vis_status==1){
			if($type==1){
				mysql_q("DELETE from bty_x_laser_visits_services where visit_id='$vis' and id='$id' ");
				mysql_q("DELETE from bty_x_laser_visits_services_vals where visit_id='$vis' and serv_x='$id' ");
				echo 1;
			}
			if($type==2){				
				mysql_q("DELETE from bty_x_laser_visits_services_vals where visit_id='$vis' and part='$id' ");				
				$srv=get_val_con('bty_x_laser_visits_services_vals','serv_x',"part='$id'");
				if(getTotalCO('bty_x_laser_visits_services_vals'," serv_x='$srv'")==0){
					mysql_q("DELETE from bty_x_laser_visits_services where visit_id='$vis' and id='$srv' ");
				}
				echo 1;
			}
		}
	}
}?>