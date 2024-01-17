<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	if(mysql_q("UPDATE gnr_x_roles set status=0 where vis=$id and mood='$t'")){echo 1;}
}
?>