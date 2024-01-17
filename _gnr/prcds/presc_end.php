<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('gnr_x_prescription',$id);    
    if($r['r']){
        if(getTotalCo('gnr_x_prescription_itemes',"presc_id= '$id'")==0){
            mysql_q("DELETE from gnr_x_prescription where id='$id'");
        }else{
            $status=$r['status'];			
            if($status==0){				
                $send=0;
                if(intval(_set_8g9zjll9cm)==1){
                    $send=1;					
                }
				mysql_q("UPDATE gnr_x_prescription set status=1 , sending_status=$send where id='$id'");
            }
        }
    }
}?>