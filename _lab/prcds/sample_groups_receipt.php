 <? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if($thisGrp=='b3pfukslow'){
		if(mysql_q("UPDATE lab_x_visits_samlpes_group SET status=2 ,recip_date='$now' , recip='$thisUser' where id='$id' and status=1 ")){echo 1;}
	}
}?>