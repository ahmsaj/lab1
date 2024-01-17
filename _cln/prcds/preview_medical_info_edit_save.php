<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])&& isset($_POST['num'] , $_POST['p_id'])){
	$type=pp($_POST['type']);
	$num=pp($_POST['num']);
	$p_id=pp($_POST['p_id']);
	if(mysql_q("INSERT INTO cln_x_medical_info (`type`,`pationt_id`,`val`)values('$type','$p_id','$num') ")){
		echo 'm'.$type.'-'.$num;
	}
}?>