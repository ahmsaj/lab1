<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$vis=get_val('osc_x_visits_services','visit_id',$id);
	$status=get_val('osc_x_visits','status',$vis);
	echo getOscReportEl($id,$status).'^'.oscReportView($id,$status);
}?>