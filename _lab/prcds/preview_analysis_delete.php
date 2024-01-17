<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(mysql_q("DELETE from lab_x_visits_requested where id='$id' and status=0 ")){
		mysql_q("DELETE from lab_x_visits_requested_items where r_id='$id' ");
		echo 1;
	}
}?>