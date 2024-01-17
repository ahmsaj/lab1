<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$res=mysql_q("DELETE FROM den_x_visits_services where id='$id' and doc='$thisUser' and status=0 " );
	if(mysql_a($res)){
		echo 1;
		mysql_q("DELETE FROM den_x_visits_services_levels where x_srv='$id' and doc='$thisUser' ");
		mysql_q("DELETE FROM den_x_visits_services_levels_w where x_srv='$id' ");
	}
}?>