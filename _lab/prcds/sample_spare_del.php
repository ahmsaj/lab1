<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(mysql_q("DELETE from lab_x_visits_samlpes where id='$id' ")){
		if(mysql_q("UPDATE lab_x_visits_samlpes  SET sub_s='0' where sub_s='$id'")){echo 1;}		
	}
}?>
