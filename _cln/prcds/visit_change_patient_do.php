<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['type'],$_POST['old_pat'],$_POST['new_pat']) ){
	$id=pp($_POST['id']);
	$type=pp($_POST['type']);	
	$old_pat=pp($_POST['old_pat']);
	$new_pat=pp($_POST['new_pat']);
	if($type==1){$table='cln_x_visits';$table2='cln_x_visits_services';}
	if($type==2){$table='lab_x_visits';$table2='lab_x_visits_services';}
	if($type==3){$table='xry_x_visits';$table2='xry_x_visits_services';}
	if($type==4){$table='den_x_visits';$table2='';}
	if(getTotalCO('gnr_m_patients'," id='$new_pat' ")>0){
	
		if(mysql_q("UPDATE $table SET patient='$new_pat' where id='$id' and patient='$old_pat' ")){
			if($type!=4){
				mysql_q("UPDATE $table2 SET patient='$new_pat' where visit_id='$id' ");
			}
			mysql_q("UPDATE gnr_x_roles SET pat='$new_pat' where vis='$id' and mood='$type'");
			if($type==2){mysql_q("UPDATE lab_x_visits_samlpes SET patient='$new_pat' where visit_id='$id' ");}
			echo 1;
		}
	}
}?>