<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['srv'] , $_POST['id'])){
	$id=pp($_POST['id']);
	$srv=pp($_POST['srv']);
	$ch1=getTotalCO('lab_x_visits_services'," id='$srv'");
	$ch2=getTotalCO('lab_x_visits_samlpes'," id='$id'");
	if($ch1 && $ch2){
		echo LabDelAna($srv,$id);
	}
}