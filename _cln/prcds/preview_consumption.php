<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['srv'])){
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$itCost=pp($_POST['itCost'],'s');
	$clinic=$userSubType;	
	$ch1=getTotalCO("cln_x_visits_services"," id=$srv and visit_id='$vis' ");
	$ch2=getTotalCO("cln_x_visits"," id='$vis' and clinic='$clinic' and doctor='$thisUser' and status=1 ");
	if($ch1 && $ch2){
		actItemeConsCln($vis,$srv,$itCost);
	}
}?>