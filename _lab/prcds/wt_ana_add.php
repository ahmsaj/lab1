<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['grp'])){
	$id=pp($_POST['id']);
	$grp=pp($_POST['grp']);
	$r=getRec('lab_x_work_table',$grp);
	if($r['r']){
		$g_status=$r['status'];		
		if($g_status<2){
			$srvs=get_vals('lab_x_visits_services','id',"service='$id' and w_table=0 and status=5");
			if($srvs){				
				mysql_q("UPDATE lab_x_visits_services SET w_table='$grp' where id IN($srvs) ");		
				echo fixWTSrvs($grp);
			}
		}
	}
}?>