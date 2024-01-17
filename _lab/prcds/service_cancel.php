<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['srv'] , $_POST['t'])){
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$type=pp($_POST['t']);
	
	if($type==1){
		$ch1=getTotalCO("lab_x_visits_services"," id='$srv' and visit_id='$vis' ");
		if($ch1){
			$vis_status=get_val('lab_x_visits','status',$vis);
			$newStatus=4;
			$s_status=get_val('lab_x_visits_services','status',$srv);
			if($s_status==2){
				if(mysql_q("DELETE from  lab_x_visits_services  where id='$srv' and status =2")){echo 1;}
			}else{
				if($vis_status==2){$newStatus=0;}
				if(mysql_q("UPDATE lab_x_visits_services set status='$newStatus' where id='$srv'")){echo 1;}
			}
		}
	}
	if($type==2){
		$ch1=getTotalCO("lab_x_visits_samlpes"," id='$srv' and visit_id='$vis' ");
		if($ch1){
			$vis_status=get_val('lab_x_visits','status',$vis);
			$newStatus=4;
			if($vis_status==2){$newStatus=0;}
			$services=get_val('lab_x_visits_samlpes','services',$srv);
			if(mysql_q("UPDATE lab_x_visits_services set status='$newStatus' where id IN($services)")){
				if(mysql_q("DELETE from lab_x_visits_samlpes where id='$srv'")){echo 1;}				
			}
		}
	}
	if($type==3){
		$ch1=getTotalCO("lab_x_visits_services"," id='$srv' and visit_id='$vis' ");
		if($ch1){			
			if(mysql_q("UPDATE lab_x_visits_services set status=0 where id='$srv' and status=4 ")){echo 1;}
		}
	}
	endLabVist($vis);
}?>