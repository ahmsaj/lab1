<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['srv'])){
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$clinic=$userSubType;	
	$ch1=getTotalCO("xry_x_visits_services"," id=$srv and visit_id='$vis' ");	
	$ch2=getTotalCO("xry_x_visits"," id='$vis' and (ray_tec='$thisUser' or doctor = 0 or doctor = '$thisUser') and status in(1,2) ");
	if($ch1 && $ch2){
		list($vis_status,$ray_tec)=get_val('xry_x_visits','status,ray_tec',$vis);		
		$s=0;
		if($thisUser!=$ray_tec){
			$s=6;
			list($d_finish,$doc)=get_val('xry_x_pro_radiography_report','date,doc',$srv);
			if(!inThisDay($d_finish) || $doc!=$thisUser){exit;}
		}
		mysql_q("UPDATE xry_x_visits_services set status='$s' where id='$srv' and status =1 ");
	}
}?>