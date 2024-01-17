<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$pay=pp($_POST['pay']);
	$r=getRec('den_x_visits',$id);
	if($r['r']){
		$status=$r['status'];
		$patient=$r['patient'];
		$dts_id=$r['dts_id'];
		$clinic=$r['clinic'];
		if($status==1){
			$srvs=get_sum('den_x_visits_services','total_pay',"patient='$patient'");
			$lastPay=patDenPay($patient,$thisUser);
			$bal=$srvs-$lastPay-$pay;
			//if($bal>=0){
				if(mysql_q("UPDATE den_x_visits SET status=2 , d_finish='$now' where id='$id' and doctor='$thisUser'")){
					echo 1 ;
					makeSerPayAlert($id,4,$pay);
					delTempOpr(4,$id,'a');
					
					mysql_q("UPDATE gnr_x_roles SET status=4 where vis='$id' and mood=4 ");
					mysql_q("DELETE from gnr_x_visits_timer where visit_id='$id' and mood=4 ");				
					if($dts_id>0){
                        mysql_q("UPDATE dts_x_dates SET status='4' , d_end_r='$now' where id ='$dts_id' ");
                        datesTempUp($dts_id);
                    }
					fixPatintAcc($patient);
                    api_notif($patient,1,54,$id);
				}
			//}
		}
	}
}