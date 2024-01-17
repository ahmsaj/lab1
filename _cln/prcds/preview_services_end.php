<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['srv'])){
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$itCost=pp($_POST['itCost'],'s');
	$clinic=$userSubType;
	$cType=get_val('gnr_m_clinics','type',$clinic);
	$ch1=getTotalCO("cln_x_visits_services"," id='$srv' and visit_id='$vis' and status IN (2,0)");
	$ch2=getTotalCO("cln_x_visits"," id='$vis' and clinic='$clinic' and doctor='$thisUser' and status=1 ");
	if($ch1 && $ch2){
		$new_status=1;
		list($status,$pay_net,$pay_type)=get_val('cln_x_visits_services','status,pay_net,pay_type',$srv);
		if($status==2){
			if(_set_ruqswqrrpl==1){
				$new_status=5;
				if($pay_net && $pay_type==3){
				
				}
			}else{
				out();exit;
			}
		}
		if(mysql_q("UPDATE cln_x_visits_services set status='$new_status' where id='$srv'")){
			if($new_status==5){servPayAler($srv,$cType);}			
			actItemeConsCln($vis,$srv,$itCost);
		}
	}
}?>