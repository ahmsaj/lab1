<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if($thisGrp=='5j218rxbn0'){
		if(mysql_q("UPDATE lab_x_visits_samlpes_group SET status=1 ,send_date='$now' , sender='$thisUser' where id='$id' and status=0 ")){echo 1;}
	}
}?>