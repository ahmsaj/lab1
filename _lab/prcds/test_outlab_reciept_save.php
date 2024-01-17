<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$patient=pp($_POST['ptientname'],'s');
	$recParent=pp($_POST['recParent']);
	echo $patient.','.$recParent;
}
$test=0;
if(isset($_POST['num']) && isset($_POST['pat']) && isset($_POST['recP'])){
	$test=pp($_POST['num']);
	$pat=pp($_POST['pat'],'s');
	$recP=pp($_POST['recP']);
	list($recPDate,$outlab)=get_val('lab_x_receipt','create_date,outlab',$recP);
	$lab_price=get_val_con('lab_m_external_labs_price','price',"lab='$outlab' and ana='$test'");
	$unit=get_val('lab_m_services','unit',$test);
	$price=$unit*_set_x6kmh3k9mh;
	$sql="INSERT INTO `lab_x_receipt_items`(`receipt_id`, `paitent`, `tests`, `reciept_date`,`outlab`,`lab_price`,`price`) VALUES ('$recP','$pat','$test','$recPDate','$outlab','$lab_price','$price')";
	if(mysql_q($sql)){
		$newId=last_id();
		echo 'R-'.$test.'^'.$newId;
	}
}
?>