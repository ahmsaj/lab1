<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	$r=getRecCon('gnr_x_temp_oprs'," type=2 and id='$id' and status=0");
	if($r['r']){
		$id=$r['id'];
		$mood=$r['mood'];
		$vis=$r['vis'];		
		$table=$visXTables[$mood];
		if(mysql_q("UPDATE $table SET pay_type=0  where id ='$vis' and pay_type='2' and status=0 limit 1")){
			mysql_q("delete FROM `gnr_x_charities_srv` where vis='$vis' ");
			delTempOpr($mood,$vis,2);
			echo 1;
		}
	}
}?>