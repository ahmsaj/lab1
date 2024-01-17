<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pat'],$_POST['offer'])){
	$pat=pp($_POST['pat']);
	$offer=pp($_POST['offer']);	
	$date_off_end=$now-86400;
	$ch1=getTotalCO('gnr_m_patients',"id='$pat'");
	$ch2=getTotalCO('gnr_m_offers'," id='$offer' ");
	$ch3=getTotalCO('gnr_x_offers_patient',"patient='$pat'");
	if($ch1 && $ch2 && $ch3==0){
		if(mysql_q("INSERT INTO gnr_x_offers_patient (`offer`,`patient`,`date`,`user`)values('$offer','$pat','$now','$thisUser')")){echo 1;}
	}
}?>