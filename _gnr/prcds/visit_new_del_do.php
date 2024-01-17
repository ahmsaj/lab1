<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$vis=pp($_POST['id']);
	$mood=pp($_POST['t']);
    
    $m_table=$visXTables[$mood];
    $m_table2=$srvXTables[$mood];
    $m_table3=$srvTables[$mood];
	if($mood==6){
		if(mysql_q(" delete from $m_table where id='$vis' and status <2 ")){
			mysql_q(" delete from bty_x_laser_visits_services where visit_id='$vis' ");
			mysql_q(" delete from bty_x_laser_visits_services_vals where visit_id='$vis' ");
			mysql_q(" delete from gnr_x_roles where vis='$vis' and mood=6");
			echo 1;
		}
	}else{
		$sql="select * from $m_table where id='$vis' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){
			$r=mysql_f($res);
			$status=$r['status'];
			$dts_id=$r['dts_id'];
			if($dts_id){
				if(mysql_q("DELETE from dts_x_dates where id='$dts_id' ")){
                    datesTempUp($dts_id);
					mysql_q("DELETE from dts_x_dates_services where dts_id='$dts_id' ");			
				}
			}
			if($status==0 && $mood==4){
				delVis($vis,$mood,2);
				mysql_q(" delete from gnr_x_roles where vis='$vis' and mood='$mood'");
				echo 1;
			}
			mysql_q("DELETE from gnr_x_insurance_rec where mood='$mood' and visit='$vis' ");
			mysql_q("DELETE from gnr_x_charities_srv where mood='$mood' and vis='$vis' ");
			if($status<2){
				if($mood==1){if(addPay1($vis,3)){echo 1;fixVisitSevesCln($vis);}}
				if($mood==2){if(addPay2($vis,3)){echo 1;}}
				if($mood==3){if(addPay3($vis,3)){echo 1;}}
				//if($mood==4){if(addPay4($vis,6)){echo 1;}}
				if($mood==5){if(addPay5($vis,3)){echo 1;}}
				if($mood==7){if(addPay7($vis,3)){echo 1;}}
				mysql_q(" delete from gnr_x_roles where vis='$vis' and mood='$mood'");
                mysql_q(" delete from gnr_x_temp_oprs where vis='$vis' and mood='$mood'");
				delTempOpr($mood,$vis,'a');
			}		
		}
	}
}?>