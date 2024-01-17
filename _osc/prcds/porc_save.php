<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['srv'],$_POST['rep'],$_POST['val'])){
	$srv=pp($_POST['srv']);
	$rep=pp($_POST['rep']);
	$val=pp($_POST['val'],'s');
	$r=getRec('osc_x_visits_services',$srv);	
	if($r['r']){
		$status=$r['status'];
		$vis=$r['visit_id'];
		$repType=get_val('osc_m_report','type',$rep);
		if($thisUser==$r['doc'] && $status==0){
			if($repType && $val!=''){				
				if(getTotalCO('osc_x_report'," `srv`='$srv' AND `report`='$rep' ")==0){
					$ord=getMaxMin('max','osc_x_report','ord'," where `srv`='$srv' AND `vis`='$vis' ")+1;
					$sql="INSERT INTO osc_x_report (`vis`,`srv`,`report`,`report_type`,`report_val`,`ord`)values('$vis','$srv','$rep','$repType','$val','$ord')";
				}else{
					$sql="UPDATE osc_x_report SET `report_val`='$val' WHERE `srv`='$srv' AND `report`='$rep' ";					
				}
				if(mysql_q($sql)){
					echo 1;
				}
			}		
		}
	}	
}?>