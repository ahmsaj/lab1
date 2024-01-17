<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $type=pp($_POST['type']);
    $r=getRec('gnr_x_prescription',$id);
	if($r['r']){
        $patient=$r['patient'];
        $sending=$r['sending_status'];
        $process_status=$r['process_status'];        
        if($sending==1){
           // if($process_status!=2){
                mysql_q("UPDATE gnr_x_prescription set process_status='$type' where id='$id'");                
            //}
            mysql_q("Insert INTO phr_x_presc_actions (`presc_id`,`user`,`action`,`date`)values('$id','$thisUser','$type','$now')");
        }
        echo 1;
    }    
}?>