<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mod_code'])){
	$mod_code=$_POST['mod_code'];
	$events='';
	$e1=$_POST['e1'];if($e1){$events.='1:'.$e1;}
	$e2=$_POST['e2'];if($e2){if($events){$events.='|';}$events.='2:'.$e2;}
	$e3=$_POST['e3'];if($e3){if($events){$events.='|';}$events.='3:'.$e3;}
	$e4=$_POST['e4'];if($e4){if($events){$events.='|';}$events.='4:'.$e4;}
	$e5=$_POST['e5'];if($e5){if($events){$events.='|';}$events.='5:'.$e5;}
	$e6=$_POST['e6'];if($e6){if($events){$events.='|';}$events.='6:'.$e6;}	
	mysql_q("UPDATE  _modules set events='$events' where code='$mod_code'");
	moduleGen(1,$mod_code);
	echo 1;
}?>