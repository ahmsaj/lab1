<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$x_lev=get_val('den_x_visits_services_levels_w','x_lev',$id);
	$r=getRec('den_x_visits_services_levels',$x_lev);
	if($r['r']){		
		$doc=$r['doc'];
		$vis=$r['vis'];
		$x_srv=$r['x_srv'];
		$status=$r['status'];
		if($doc==$thisUser && $status!=2){
			if(mysql_q("DELETE from den_x_visits_services_levels_w where id='$id'")){
				echo 1;
				$lw=getTotalCO('den_x_visits_services_levels_w',"x_lev='$x_lev'");
				if($status==1 && $lw==0){
					mysql_q("UPDATE den_x_visits_services_levels SET status=0 where id='$x_lev'");
				}				
			}
		}
	}
}?>