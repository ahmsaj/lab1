<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['srv'])){
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$r=getRecCon('xry_x_visits_services'," id='$srv' and visit_id='$vis' ");
	if($r['r']){
		$t1=pp($_POST['t1']);
		$t11=pp($_POST['t11']);
		if(!$t11){$t11=0;}
		$t2=pp($_POST['t2']);
		$t3=pp($_POST['t3']);
		$t4=pp($_POST['t4']);
		if(!$t4){$t4=0;$t44;}
		if($t1 && $t2 && $t3 ){
			$t22=get_val_con('xry_m_osc_team','wage'," id='$t2' and type=2 ");
			$t33=get_val_con('xry_m_osc_team','wage'," id='$t3' and type=3 ");
			if($t4){$t44=get_val_con('xry_m_osc_team','wage'," id='$t4' and type=4 ");}
			if($t22!='' && $t33!=''){
				if(getTotalCO('xry_x_visits_services_add'," id='$srv'")){					
					$sql="UPDATE xry_x_visits_services_add set 										
					tec_endoscopy='$t1',
					tec_endoscopy_wages='$t11',
					tec_anesthesia='$t2',
					tec_anesthesia_wages='$t22',
					tec_sterilization='$t3',
					tec_sterilization_wages='$t33',
					tec_nurse='$t4',
					tec_nurse_wages='$t44'
					where id='$srv'";					
				}else{
					$doc=get_val('xry_x_visits','doctor',$vis);
					$sql="INSERT INTO xry_x_visits_services_add (`id`,`visit_id`,`doc`,`tec_endoscopy`,`tec_endoscopy_wages`,`tec_anesthesia`,`tec_anesthesia_wages`,`tec_sterilization`,`tec_sterilization_wages`,`tec_nurse`,`tec_nurse_wages`) values($srv,'$vis','$doc','$t1','$t11','$t2','$t22','$t3','$t33','$t4','$t44')";
				}
				if(mysql_q($sql)){echo 1;}
			}
		}
	}
}?>