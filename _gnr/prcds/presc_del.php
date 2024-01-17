<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(getTotalCO('gnr_x_prescription',"id='$id' and doc='$thisUser'")){
		if(mysql_q("DELETE from gnr_x_prescription where id='$id' ")){			
			mysql_q("DELETE from gnr_x_prescription_itemes where presc_id='$id'");
			echo 1;
		}
	}
}?>