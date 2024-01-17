<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_x_work_table',$id);
	if($r['r']){
		$status=$r['status'];
		if($status<2){
			if(mysql_q("DELETE from lab_x_work_table where status<2 and id='$id'")){
				mysql_q("UPDATE lab_x_visits_services SET w_table='0' and status=5 where w_table='$id'");
				echo 1;
			}
		}
	}
}?>