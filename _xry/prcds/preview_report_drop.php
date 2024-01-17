<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$sql="UPDATE xry_x_visits_services SET doc=0 where doc='$thisUser' and id='$id' ";
	if(mysql_q($sql)){echo 1;}
}?>