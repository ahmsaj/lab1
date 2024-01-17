<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if($thisGrp=='hrwgtql5wk'){
		list($mood,$service_x,$visit)=get_val('gnr_x_insurance_rec','mood,service_x,visit',$id);
		if($service_x){			
			if($mood==1){$table='cln_x_visits_services';$table2='cln_x_visits';}
			if($mood==2){$table='lab_x_visits_services';$table2='lab_x_visits';}
			if($mood==3){$table='xry_x_visits_services';$table2='xry_x_visits';}
			if($mood==4){$table='den_x_visits_services';$table2='den_x_visits';}
			if($mood==5){$table='bty_x_visits_services';$table2='bty_x_visits';}			
			if(mysql_q("DELETE from gnr_x_insurance_rec where id='$id' ")){
				echo 1;
				mysql_q("UPDATE $table SET insur=0 where id='$service_x'");
				if(getTotalCO($table,"insur=1 and visit_id='$visit' ")==0){					
					mysql_q("UPDATE $table2 set pay_type=0 where pay_type=3 and id='$visit' ");
				}
			}
		}
	}
}?>