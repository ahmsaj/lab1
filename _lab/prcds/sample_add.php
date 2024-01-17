<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['srv'] , $_POST['id'] , $_POST['t'])){
	$id=pp($_POST['id']);
	$srv=pp($_POST['srv']);
	$type=pp($_POST['t']);
	
	$ch2=getTotalCO('lab_m_samples_packages'," id='$id'");
	if($type==1 || $type==3){
		$ch1=getTotalCO('lab_x_visits_services'," id='$srv'");
		if($ch1 && $ch2){
			list($vis,$patient)=get_val('lab_x_visits_services','visit_id,patient',$srv);
			echo LabAddSample($srv,$id,$type,$patient);
		}
	}
	if($type==2){
		$ch1=getTotalCO('lab_x_visits'," id='$srv'");
		if($ch1 && $ch2){
			echo LabAddSampleAll($srv,$id);
		}
	}	
}