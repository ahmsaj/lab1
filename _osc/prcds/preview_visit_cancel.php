<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(getTotalCO('osc_x_visits'," id='$id' and (doctor='$thisUser' OR ray_tec='$thisUser' )")==1){
		$clinic=get_val('osc_x_visits','clinic',$id);
		if(mysql_q("UPDATE osc_x_visits set doctor=0 , d_check=0,report='',note='', work=0 where id='$id'")){
			if(mysql_q("UPDATE gnr_x_roles set status=3 where vis='$id' and mood=7")){
				mysql_q("UPDATE osc_x_visits set doctor=0 where visit_id='$id'");
				mysql_q("DELETE from gnr_x_visits_timer where visit_id='$id' and mood=7");
				echo 1;		
			}
		}
	}	
}?>