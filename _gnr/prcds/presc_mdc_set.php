<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'],$_POST['id'],$_POST['dd'],$_POST['nu'],$_POST['du'],$_POST['ds'])){
	$id=pp($_POST['id']);
	$r=getRecCon('gnr_x_prescription_itemes'," id='$id' and doc='$thisUser'");
	if($r['r']){
		$type=pp($_POST['type']);
		$dd=pp($_POST['dd']);
		$nu=pp($_POST['nu']);
		$du=pp($_POST['du']);
		$ds=pp($_POST['ds']);
		if($type==1){
			if(mysql_q("Update gnr_x_prescription_itemes set `dose`='$dd',`num`='$nu',`duration`='$du',`dose_s`='$ds' where id='$id' ")){echo 1;}	
		}
		if($type==2){
			$mad_id=$r['mad_id'];
			if(mysql_q("Update gnr_m_medicines set dose='$dd',num='$nu',duration='$du',`dose_s`='$ds' where id ='$mad_id' ")){echo 1;}			
		}
	}
}?>

