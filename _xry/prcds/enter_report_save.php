<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['rep'])){
	$id=pp($_POST['id']);
	$rep=pp($_POST['rep'],'s');
	$r=getRec('xry_x_visits_services',$id);
	if($r['r']){
		$status=$r['status'];
		$service=$r['service'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		if($status==6 || $status==0){
			if(mysql_q("UPDATE xry_x_pro_radiography_report set report='$rep' , doc='$thisUser' where id='$id' ")){
				mysql_q("UPDATE xry_x_visits_services set status='1' , doc='$thisUser' where id='$id' ");
				$r_id=get_val_con('xry_x_visits_requested_items','r_id',"service_id='$id'");
				if($r_id){					
					$photos=get_val('xry_x_pro_radiography_report','photos',$id);
					mysql_q("UPDATE xry_x_visits_requested_items SET res_photo='$photos' , res='$rep', status=2 where service_id='$id' ");
					mysql_q("UPDATE xry_x_visits_requested SET status=3 where id='$r_id' ");
					
				}
				fixDashData($clinic,3);
				echo 1;
			}
		}
	}
}?>