<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr_sub'])){
	$id=pp($_POST['id']);
	$opr_sub=pp($_POST['opr_sub']);
	list($opr_id,$doc)=get_val('den_x_opr_teeth','opr,doctor',$id);
	$ch1=getTotalCO('den_x_opr_teeth',"id='$id'");
	$ch2=getTotalCO('den_m_set_teeth_sub'," id='$opr_sub' and status_id='$opr_id' ");
	if($ch1 && $ch2 && $doc=$thisUser){
		if(mysql_q("UPDATE den_x_opr_teeth SET opr_sub='$opr_sub'  where id='$id' ")){echo 1;}
	}
	
}?>