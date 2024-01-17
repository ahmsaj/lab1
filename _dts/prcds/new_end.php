<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('dts_x_dates',$id);
	if($r['r']){		
		$reg_user=$r['reg_user'];
        $patient=$r['patient'];
        $p_type=$r['p_type'];
        $type=$r['type'];
        if($reg_user==$thisUser){
		    if(mysql_q("UPDATE dts_x_dates SET status=1 , date='$now' where id='$id' and status=0")){
                datesTempUp($id);
                delTempOpr(0,$id,9);
                api_notif($patient,$p_type,4,$id);
                echo 1;
            }
        }
    }
}?>