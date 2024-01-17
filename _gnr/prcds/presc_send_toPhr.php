<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$presc=pp($_POST['id']);
	$status=pp($_POST['status']);
	$process_status=get_val_con('gnr_x_prescription','process_status',"id='$presc'");
	if($process_status==0){//not processed
		$sql="update `gnr_x_prescription` set `sending_status` = '$status' where id='$presc' ";
		if(mysql_q($sql)){echo "1";}else{echo "0";}
	}else{echo "0";}
}?>