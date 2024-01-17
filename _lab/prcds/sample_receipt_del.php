<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['type'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['type']);
	if($type==1){
		$rack=get_val('lab_x_visits_samlpes','rack',$id);
		$rack_pos=get_val('lab_x_visits_samlpes','rack_pos',$id);
		echo AddRackPlace(0,'',$id,$rack,$rack_pos,5);
	}
	if($type==2){
		$sql="select * from lab_x_visits_samlpes where rack='$id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$rack_pos=$r['rack_pos'];
				AddRackPlace(0,'',$s_id,$id,$rack_pos,5);
			}			
		}
		echo 1;
	}
}?>