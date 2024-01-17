<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'])){
	$r=getRecCon('gnr_x_roles',"doctor='$thisUser' and no=0 ");
	if($r['r']){
		if(mysql_q("DELETE from  gnr_x_roles where `doctor`='$thisUser' and `no`=0 ")){			
			mysql_q("UPDATE gnr_x_arc_stop_role SET `e_date`='$now' where `doc`='$thisUser' and `e_date`=0 ");
			echo 1;
		}
	}else{
		$v=pp($_POST['v']);
		$val=$v+$now;
		$clinic=intval($userSubType);
		if(getTotalCO('gnr_x_roles'," clic='$clinic' and no=0 ")==0){
			if(mysql_q("INSERT INTO gnr_x_roles (`clic`,`no`,`date`,`fast`,`mood`,`doctor`)
				values('$clinic','0','$val',1,0,'$thisUser')")){
				echo 1;
				mysql_q("INSERT INTO gnr_x_arc_stop_role (`doc`,`s_date`,`stop_time`)values('$doc','$now','$v')");
			}
		}
	}
}?>