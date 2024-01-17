<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$date=date('Y-m-d');
	if(getTotalCO('_users'," `id`='$id' and `act`=1 and `grp_code`='7htoys03le'")>0){
		if(getTotalCO('gnr_x_arc_stop_doc'," `doc`='$id' and `date`='$date'")>0){
			if(mysql_q("DELETE from gnr_x_arc_stop_doc where `doc`='$id' and `date`='$date' ")){echo 1;}
		}else{
			if(mysql_q("INSERT INTO gnr_x_arc_stop_doc (`doc`,`date`)values('$id','$date')")){echo 1;}
		}
	}
}?>