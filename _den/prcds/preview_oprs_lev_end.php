<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$r=getRec('den_x_visits_services_levels',$id);
	if($r['r']){
		$doc=$r['doc'];
		$x_srv=$r['x_srv'];
		if($doc==$thisUser){
			mysql_q("UPDATE den_x_visits_services_levels SET status=2 , date_e='$now' where id='$id' and status=1 ");
			echo 1;
			fixDenServEnd($x_srv);
		}
		
	}
}