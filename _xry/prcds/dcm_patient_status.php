<? include("../../__sys/prcds/ajax_header.php");
$perm_dcm=modPer($mod_study);
if($perm_dcm[0]){
	if(isset($_POST['patient'],$_POST['service'])){
		$patient=pp($_POST['patient']);
		$service=pp($_POST['service']);
		echo dicom_link($patient,$service,2);
	}  	
}else{
  out(1);
}
