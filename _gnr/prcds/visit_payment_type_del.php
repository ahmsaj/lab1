<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['type'])){	
	$id=pp($_POST['id']);
	$type=pp($_POST['type']);
	$r=getRecCon('gnr_x_temp_oprs'," type=$type and id='$id' and status=0");
	if($r['r']){
		$id=$r['id'];
		$mood=$r['mood'];
		$vis=$r['vis'];		
		$table=$visXTables[$mood];
		if(mysql_q("UPDATE $table SET pay_type=0  where id ='$vis' and pay_type='$type' and status=0 limit 1")){
			if($type==1){$table='gnr_x_exemption_srv';}
			if($type==2){$table='gnr_x_charities_srv';}
			mysql_q("delete FROM `$table` where vis='$vis' and mood='$mood'");
			delTempOpr($mood,$vis,$type);
			echo 1;
		}
	}
}?>