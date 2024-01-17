<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(getTotalCO('bty_x_visits'," id='$id' and doctor='$thisUser' ")==1){			
		if(mysql_q("UPDATE bty_x_visits set doctor=0 , d_check=0 , note='' ,  work=0 where id='$id'")){
			if(mysql_q("UPDATE gnr_x_roles set status=3 where vis='$id' and mood=5")){
				mysql_q("UPDATE bty_x_visits set doctor=0 where visit_id='$id'");
				mysql_q("DELETE from gnr_x_visits_timer where visit_id='$id' and mood=5");				
				echo 1;				
			}
		}
	}	
}?>