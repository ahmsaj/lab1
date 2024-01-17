<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['srv'])){
	$id=pp($_POST['id']);
	$srv=pp($_POST['srv']);	
	$r=getRec('osc_x_visits_services',$srv);
	if($r['r']){
		$status=$r['status'];
		$service=$r['service'];
		$doc=$r['doc'];
		if($doc==$thisUser && $status==0){
			if(mysql_q("DELETE FROM osc_x_report where id='$id' and srv='$srv'")){
				echo 1;
			}
		}
	}
}?>