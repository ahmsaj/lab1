<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$vis_id=$id;
	if($t==1){
		list($status,$vis)=get_val('lab_x_visits_services','status,visit_id',$id);			
		if($status==8){if(mysql_q("UPDATE lab_x_visits_services SET status=1 , delv_date='$now' where id='$id'")){echo 1;}}	
		$vis_id=$vis;
	}
	if($t==2){
		if(mysql_q("UPDATE lab_x_visits_services SET status=1 , delv_date='$now' where visit_id='$id' and status=8")){echo 1;}
	}
	
	if(getTotalCO('lab_x_visits_services'," visit_id='$vis_id' and status not in (1,3) ")==0){		
		mysql_q("UPDATE lab_x_visits SET status=2 , d_finish='$now' where id='$vis_id' ");
	}
}?>