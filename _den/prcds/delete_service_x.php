<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('den_x_visits_services',$id);
	if($r['id']){
		$visit_id=$r['visit_id'];
		$clinic=$r['clinic'];
		$doc=$r['doc'];
		$service=$r['service'];	
		$total_pay=$r['total_pay'];
		
		mysql_q("delete from den_x_visits_services where id='$id'");
		mysql_q("delete from den_x_visits_services_levels where x_srv='$id'");
		mysql_q("delete from den_x_visits_services_levels_txt where x_srv='$id'");
		mysql_q("delete from den_x_visits_services_levels_w where x_srv='$id'");
		mysql_q("delete from den_x_visits_services_price_diff where x_srv='$id'");
		
		$User=intval($thisUser);
		$sql="INSERT INTO den_x_service_delete_log (`visit_id`,`clinic`,`doc`,`service`,`total_pay`,`user`,`date`)
		values('$visit_id','$clinic','$doc','$service','$total_pay',$User,$now)";
		mysql_q($sql);
		echo 1;
	}	
}?>