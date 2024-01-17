<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['a'] , $_POST['s'])){
	$id=pp($_POST['a']);
	$sample=pp($_POST['s']);
	list($vis,$patient)=get_val('lab_x_visits_services','visit_id,patient',$id);
	if($lastSample=getLastSample($patient,$vis)){
		$d=$now-86400;
		$sql="select * from lab_x_visits_samlpes where patient='$patient' and date > $d and visit_id!='$vis' and status NOT IN(4,5) and pkg_id IN($lastSample) and id='$sample'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$pkg_id=$r['pkg_id'];
			$s_status=$r['status'];
			$ch1=getTotalCO('lab_x_visits_services'," id='$id' ");
			if($ch1){
				echo $isAdd=LabAddSample($id,$pkg_id,4,$patient,$sample);
				if($isAdd && $s_status==3){
					addToRackAlert($id,$sample);
				}
			}
		}
	}
}?>