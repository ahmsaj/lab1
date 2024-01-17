<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'])){
	$id=pp($_POST['id']);
	$opr=pp($_POST['opr']);

	$r=getRecCon('dts_x_dates'," id='$id' and status=10 and reg_user='$thisUser' ");	
	if($r['r']){	
		$patient=$r['patient'];
		$p_type=$r['p_type'];
		$status=$r['status'];
        $clinic=$r['clinic'];
        $mood=$r['type'];
		$s=0;
		if($opr==1){$s=1;$type=6;}
		if($opr==2){$s=5;$type=7;}
		if($s){
			if(mysql_q("UPDATE dts_x_dates SET status=$s where reg_user='$thisUser' and id='$id'")){
                datesTempUp($id);
				api_notif($patient,$p_type,$type,$id);
                //addDtsSrviceAuto($r);
				echo 1;
			}
		}
	}
}?>