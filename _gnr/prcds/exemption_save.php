<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v_id'] , $_POST['c_type'])){
	$v_id=pp($_POST['v_id']);
	$type=pp($_POST['c_type']);
	$reso=pp($_POST['cof_t52jbdjyk']);
	$sql="INSERT INTO gnr_x_exemption(`vis`,`reason`,`c_type`)values('$v_id','$reso','$type')";
	if(mysql_q($sql)){echo 1;}else{echo '0';}	
}?>