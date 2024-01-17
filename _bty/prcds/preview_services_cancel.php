<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['srv'])){
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$clinic=$userSubType;
	
	$ch1=getTotalCO("bty_x_visits_services"," id=$srv and visit_id='$vis' ");
	$ch2=getTotalCO("bty_x_visits"," id='$vis' and clinic='$clinic' and doctor='$thisUser' and status in(1,2) ");
	if($ch1 && $ch2){
		$vis_status=get_val('bty_x_visits','status',$vis);
		$srv_status=get_val('bty_x_visits_services','status',$srv);
		$newStatus=4;
		if($vis_status==2){$newStatus=0;}
		if($srv_status==2){
			mysql_q("DELETE from bty_x_visits_services where status='2' and id='$srv'");
		}else if($srv_status==4){
			mysql_q("UPDATE bty_x_visits_services set status='0' where id='$srv'");
		}else{
			mysql_q("UPDATE bty_x_visits_services set status='$newStatus' where id='$srv'");
		}
	}
    if(_set_ruqswqrrpl==0){payAlertBe($vis,5);}
}?>