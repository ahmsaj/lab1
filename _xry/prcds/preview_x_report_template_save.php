<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['name'],$_POST['rep'])){
	$id=pp($_POST['id']);
	$name=pp($_POST['name'],'s');
	$rep=pp($_POST['rep'],'s');
	$id=pp($_POST['id']);
	$r=getRec('xry_x_visits_services',$id);
	if($r['r']){
		$doc=$r['doc'];
		$status=$r['status'];
		$pat=$r['patient'];
		$srv=$r['service'];
		$rep=str_replace('<br>','',$rep);
		if(($status==0 || $status==6) && ($doc==$thisUser || $doc==0)){
			$clinic=get_val('xry_m_services','clinic',$srv);
			$sql="INSERT INTO xry_m_pro_radiography_report_templates (doc,def,title,content,srv,clinic) VALUE ('$thisUser',1,'$name','$rep','$srv','$clinic')";
			$res=mysql_q($sql);
			echo last_id();
		}
	}
}?>