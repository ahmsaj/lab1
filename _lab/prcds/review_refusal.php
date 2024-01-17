<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['x'])){
	$x=pp($_POST['x'],'s');
	$xx=explode(',',$x);
	foreach($xx as $x_id){
		list($serv_id,$x_val,$serv_val_id)=get_val('lab_x_visits_services_results','serv_id,value,serv_val_id',$x_id);
		$rw=get_val('lab_x_visits_services','report_wr',$serv_id);
		mysql_q("UPDATE lab_x_visits_services SET status=9 , report_rev='$thisUser' , date_reviwe='$now' where id='$serv_id' and status IN(7,10)");
		mysql_q("INSERT INTO lab_x_visits_services_results_x (`srv`,`x_id`,`x_ser_id`,`res_writer`,`res_rev`,`value`,`date`)
		values('$serv_id','$x_id','$serv_val_id','$rw','$thisUser','$x_val','$now')");
	}
	echo 1;
}?>