<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('lab_x_visits_requested',$id);
    if($r['r']){
        $status=$r['status'];
        $vis=$r['lab_vis'];
        if($status==1 || ($status==2 && $vis==0)){
            mysql_q("UPDATE lab_x_visits_requested SET status=2 where id='$id' ");
            mysql_q("UPDATE lab_x_visits_requested_items SET action=2 where r_id='$id' ");           
            delTempOpr(2,$id,7);            
        }
        echo $id;
    }
}?>