<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	list($doc,$status)=get_val('bty_x_laser_visits','doctor,status',$vis);
	if($doc==$thisUser && $status==1){
		$r=getRecCon('bty_x_laser_visits_services_vals',"id='$id' and status=1");
		if($r['r']){
			$serv_x=$r['serv_x'];
			if(mysql_q("UPDATE bty_x_laser_visits_services_vals SET status=0 where id='$id' ")){
				mysql_q("UPDATE bty_x_laser_visits_services SET status=0 where id='$serv_x' and status=1");
				echo 1;		
			}
		}
	}	
}?>