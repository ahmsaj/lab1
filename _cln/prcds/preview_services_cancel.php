<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['srv'])){
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$clinic=$userSubType;
	$insurStopCancel=0;
	$q=" doctor='$thisUser' ";
	
	$ch1=getTotalCO("cln_x_visits_services"," id=$srv and visit_id='$vis' ");
	$ch2=getTotalCO("cln_x_visits"," id='$vis' and clinic in($clinic) and $q and status in(1,2) ");
	if($ch1 && $ch2){
		list($pay_type,$vis_status)=get_val('cln_x_visits','pay_type,status',$vis);
		list($srv_status,$offer)=get_val('cln_x_visits_services','status,offer',$srv);
		$newStatus=4;
		if($pay_type==3){
			$res_status=get_val_con('gnr_x_insurance_rec','res_status',"service_x='$srv' and mood=1 ");
			if($res_status!='' || $res_status==2){$insurStopCancel=1;}
		}		
		if($vis_status==2){$newStatus=0;}
		if($srv_status==2){
			if($insurStopCancel==0){
				mysql_q("DELETE from cln_x_visits_services where status='2' and id='$srv'");
				if($offer){
					mysql_q("DELETE from gnr_x_offers_oprations where visit_srv='$srv' and mood=1 ");
				}
			}
		}else if($srv_status==4){
			mysql_q("UPDATE cln_x_visits_services set status='0' where id='$srv'");
		}else{
			mysql_q("UPDATE cln_x_visits_services set status='$newStatus' where id='$srv'");
			mysql_q("UPDATE cln_x_visits set status='1' where id='$vis'");
			mysql_q("UPDATE gnr_x_roles set status='2' where vis='$vis' and status = 4");
		}
	}
}?>