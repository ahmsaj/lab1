<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'] , $_POST['m']) ){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$m=pp($_POST['m']);
	
	if($t==1){
		list($pat,$visit_id)=get_val('lab_x_visits_services','patient,visit_id',$id);
		//$status=get_val('lab_x_visits_services','status',$id);		
		if(mysql_q("UPDATE lab_x_visits_services SET status=8 , report_rev='$thisUser' , date_reviwe='$now' where id='$id' and status IN(7,10)")){
			echo 1;
			checkDocOrder($id,1);			
			if(getTotalCO('lab_x_visits_services', " visit_id='$visit_id' and status NOT IN (3,8)")==0){
				mysql_q("UPDATE lab_x_visits SET status=5 ,d_finish='$now' where id='$visit_id'");
				delTempOpr(2,$visit_id,4);
				api_notif($pat,1,1,$id);
			}			
		}
	}
	if($t==2){
		$pat=get_val('lab_x_visits','patient',$id);
		if($m==1){
			$sql="UPDATE lab_x_visits_services SET status=8 , report_rev='$thisUser' , date_reviwe='$now' where visit_id='$id' and status IN(7,10)";
		}else{
			$sql="UPDATE lab_x_visits_services SET status=8 , report_rev='$thisUser' , date_reviwe='$now' where service='$id' and status IN(7,10)";
		}
		if(mysql_q($sql)){
			echo 1;
			checkDocOrder($id,2);
			if(getTotalCO('lab_x_visits_services', " visit_id='$id' and status NOT IN (3,8)")==0){
				mysql_q("UPDATE lab_x_visits SET status=5 ,d_finish='$now' where id='$id'");
				api_notif($pat,1,1,$id);
			}			
		}
	}
}?>