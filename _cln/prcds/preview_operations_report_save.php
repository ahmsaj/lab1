<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$duration=pp($_POST['duration'],'s');
	$price=pp($_POST['price']);
	$report=pp($_POST['report'],'s');
	$notes=pp($_POST['notes'],'s');	
	$sql="UPDATE cln_x_pro_x_operations set `real_dur`='$duration' , `real_price`='$price' , `notes`='$notes' ,
		 `report`='$report' , `status`=1 where id='$id'";
	if(mysql_q($sql)){echo 1;}	
}
?>