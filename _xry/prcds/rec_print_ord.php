<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('xry_x_visits_requested',$id);
    if($r['r']){
        $status=$r['status'];        
        $vis=$r['xry_vis'];
        if($status==1 || ($status==2 && $vis==0)){
            mysql_q("UPDATE xry_x_visits_requested SET status=2 where id='$id' ");
            mysql_q("UPDATE xry_x_visits_requested_items SET action=2 where r_id='$id' ");           
            delTempOpr(3,$id,8);            
        }
        echo $id;
    }
}?>