<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$x=getTotalCO('bty_x_laser_visits'," doctor='$thisUser' and id='$id'");
	list($c,$p,$s)=get_val('bty_x_laser_visits','clinic,patient,status',$id);
	if($x && $s==1){		
		$sql="select id from bty_m_services where cat IN(select id from bty_m_services_cat where  clinic='$c') and act=1 and id NOT IN(select service from bty_x_laser_visits_services where visit_id='$id')";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				if(isset($_POST['ser_'.$s_id])){
					$sql="INSERT INTO bty_x_laser_visits_services (`visit_id`, `clinic`, `service`,`d_start`, `patient`,`doc`)values ('$id','$c','$s_id','$now','$p','$thisUser')";
					mysql_q($sql);
				}
			}
			setLaserServises($id);
			echo 1;
		}
	}
}?>