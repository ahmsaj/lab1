<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mood'])){
	$out=0;
	$id=pp($_POST['id']);
	$mood=pp($_POST['mood']);
	if($mood==1){$table='cln_x_visits_services';$table2='cln_x_visits';}
	if($mood==2){$table='lab_x_visits_services';$table2='lab_x_visits';}
	if($mood==3){$table='xry_x_visits_services';$table2='xry_x_visits';}
	if($mood==5){$table='bty_x_visits_services';$table2='bty_x_visits';}
	if($mood==6){$table='bty_x_laser_visits_services';$table='bty_x_laser_visits';}
	list($status,$vis)=get_val($table,'status,visit_id',$id);	
	if($vis && $status==0){
		$v_status=get_val($table2,'status',$vis);
		if($v_status==0){
			if(mysql_q("delete from $table where id ='$id' ")){
				$out=$vis;
			}
		}
	}
	echo $out;
}?>