<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	//$res=mysql_q("UPDATE lab_x_visits_services SET status= '5' where id='$id' and status= 7 limit 1");
	$res=mysql_q("UPDATE lab_x_visits_services SET status= '5' where id='$id' and status in(7,8,9,10,1) limit 1");
	if(mysql_a()>0){echo 1;}
}
?>