<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['v'])){
	$id=pp($_POST['id']);	
	$v=pp($_POST['v']);
	$r=getRec('den_x_opr_teeth',$id);
	if($r['r']){
		$t=$r['teeth_part'];
		$opr=$r['opr'];
		$ch=0;
		if($t==1){ $ch=getTotalCO('den_m_set_teeth_sub',"status_id='$opr' and id='$v' "); }
		if($t==2){ $ch=getTotalCO('den_m_set_roots_sub',"status_id='$opr' and id='$v' "); }
		if($ch){
			if(mysql_q("UPDATE den_x_opr_teeth SET opr_sub='$v' where id='$id' ")){echo 1 ;}
		}
	}
}?>