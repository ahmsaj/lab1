<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_x_visits_requested',$id);
	if($r['r']){
        $staus=$r['status'];
        $patient=$r['patient'];
        $doc=$r['doc'];        
        if($staus<2 && $doc==$thisUser){
            if(mysql_q("UPDATE lab_x_visits_requested SET status='1' where id='$id' and status=0 ")){
                mysql_q("UPDATE lab_x_visits_requested_items SET action='1' where r_id='$id' ");
                if(getTotalCo('gnr_x_temp_oprs',"type=7 and vis='$id' ")==0){     
                    addTempOpr($patient,7,2,0,$id);                    
                }
                echo 1;
            }
        }
	}
}?>