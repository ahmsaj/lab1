<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'] , $_POST['num'])&& isset($_POST['p_id'])){
	$type=pp($_POST['type']);
	$num=pp($_POST['num']);
	$p_id=pp($_POST['p_id']);
	mysql_q("DELETE FROM cln_x_medical_info where pationt_id='$p_id' and val='$num' and type='$type' limit 1");
}?>