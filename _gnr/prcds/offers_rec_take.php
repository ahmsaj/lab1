<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['srv'],$_POST['vis'])){
	$srv=pp($_POST['srv']);
	$vis=pp($_POST['vis']);
	$r=getRec('gnr_x_offers_items',$srv);
	if($r['r']){
		$patient=$r['patient'];
		$mood=$r['mood'];
		$status=$r['status'];
		$service=$r['service'];
		$hos_part=$r['hos_part'];
		$doc_part=$r['doc_part'];
		$offer_id=$r['offer_id'];
		$doc_percent=$r['doc_percent'];
		if($status==0){
			$table=$srvXTables[$mood];
			$doctor=0;
			if($mood==2){
				list($s_id,$s_patient,$s_status)=get_val_con($table,'id,patient,status',"service='$service' and visit_id='$vis' ");
			}else{
				list($s_id,$s_patient,$s_status,$doctor)=get_val_con($table,'id,patient,status,doc',"service='$service' and visit_id='$vis' ");	
			}
			if($s_patient==$patient && $s_status==0){			
				if(offerOpr($mood,$patient,$offer_id,$srv,$service,$vis,$s_id,$doctor)){
					mysql_q(" UPDATE gnr_x_offers_items SET status=1 , date='$now' , vis='$vis' , srv_x_id='$s_id' where id='$srv' ");
					echo 1;
				}
			}
		}
	}
}
?>