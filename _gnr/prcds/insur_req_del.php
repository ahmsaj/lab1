<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['sev'],$_POST['vis'],$_POST['mood'])){
	$sev=pp($_POST['sev']);
	$vis=pp($_POST['vis']);
	$mood=pp($_POST['mood']);
	$ch1=getTotalCO($srvXTables[$mood],"id='$sev' and visit_id='$vis' ");
	$ch2=getTotalCO('gnr_x_temp_oprs',"mood='$mood' and vis='$vis' and type=3 ");
	if($ch1 && $ch2){
		if(mysql_q("DELETE from $srvXTables[$mood] where id ='$sev' limit 1")){echo 1;}
	}	
}
if(isset($_POST['id'],$_POST['type'],$_POST['mood'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['type']);
	$mood=pp($_POST['mood']);
	
	$table=$srvXTables[$mood];
	$table2=$srvXTables[$mood];
	$vis=get_val('gnr_x_temp_oprs','vis',$id);	
	if($vis){			
		if(mysql_q("DELETE from gnr_x_temp_oprs where id ='$id' limit 1")){
			if($type==1){//Cancle Req
				if(mysql_q("UPDATE $table SET pay_type=0  where id ='$vis' and pay_type='3' and status=0 limit 1")){echo 1;}
			}
			if($type==2){//Delete Req
				if(mysql_q("DELETE from $table where id ='$vis' and pay_type='3' and status='0' limit 1")){
					if(mysql_q("DELETE from $table2 where visit_id ='$vis' and status='0'")){echo 1;}
				}
			}
		}
	}	
}?>