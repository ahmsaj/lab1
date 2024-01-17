<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['d'])){
	$d=$_POST['d'];
	$ordrs=array();
	$dd=explode('|',$d);
	foreach($dd as $row){
		$ord_data=explode(':',$row);
		$code=$ord_data[0];
		$ord=$ord_data[1];
		array_push($ordrs,$ord);			
		mysql_q("UPDATE `_modules_list` SET ord='$ord' where code='$code' ");
	}
}
?>