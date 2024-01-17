<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'])){
	$type=pp($_POST['t']);
	$clinic=$userSubType;
	$doc=$thisUser;
	if($type==1){if(mysql_q("INSERT INTO gnr_x_arc_stop_clinic (`clic`,`doc`,`s_date`)values('$clinic','$doc','$now')")){echo 1;}}
	if($type==2){if(mysql_q("UPDATE  gnr_x_arc_stop_clinic set `e_date`='$now' where `clic`='$clinic' and e_date=0 ")){echo 1;}}
}?>