<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('bty_x_laser_visits_notes',$id);
	if($r['r']){
		$id=$r['id'];
		$user=$r['user'];
		if($user==$thisUser){
			if(mysql_q("DELETE from bty_x_laser_visits_notes where id='$id'")){echo 1;}			
		}
	}
}?>
