<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	if(getTotalCO('gnr_x_prescription',"id='$id' and doc='$thisUser'")){
		if(getTotalCO('gnr_x_prescription_itemes',"presc_id='$id'")){
			if(mysql_q("UPDATE gnr_x_prescription SET status=1 where id='$id' ")){echo 1;}
		}else{
			if(mysql_q("DELETE from gnr_x_prescription where id='$id' and status=0 ")){echo 1;}
		}
	}	
}?>