<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(getTotalCO('dts_x_cancel'," dts='$id' ")>0){
		if(mysql_q("UPDATE dts_x_dates SET status=5  where id='$id' and status in(1,9,10) ")){
            datesTempUp($id);
			echo 1;
			vacaConflictAlert();
		}else{
			mysql_q("DELETE from  dts_x_cancel where id='$id' ");
		}
	}
}?>