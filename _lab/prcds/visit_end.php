<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$ok=1;
	$errMsg='';
	$r=getRec('lab_x_visits',$id);
	if($r['r']){
		if($r['status']==1){
			$ch1=getTotalCO('lab_x_visits_services'," visit_id='$id' and status IN(0,2,4)");
			if($ch1){$ok=0;$errMsg.=k_pending_ana.' <br>';}
			
			$ch2=getTotalCO('lab_x_visits_samlpes'," visit_id='$id' and status=0");
			if($ch2){$ok=0;$errMsg.=k_unnum_samples.' <br>';}
			
			$ch3=getTotalCO('lab_x_visits_samlpes'," visit_id='$id' and services='' and per_s=0 ");
			if($ch3){$ok=0;$errMsg.=k_unrelated_samples.' <br>';}
			if($ok){
				mysql_q("UPDATE lab_x_visits SET status=4 where id='$id'");
				mysql_q("UPDATE gnr_x_roles SET status=4 where vis='$id' and mood=2");
			}
		}
	}else{
		$ok=0;$errMsg.='';
	}
	if($ok==0){$errMsg=k_visit_cant_completed.' <br>'.$errMsg;}
	echo $ok.'^'.$errMsg;
}?>