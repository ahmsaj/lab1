<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('den_x_opr_teeth',$id);
	if($r['r']){
		$teeth_part=$r['teeth_part'];
		$visit=$r['visit'];
		$doctor=$r['doctor'];
		$patient=$r['patient'];
		$teeth=$r['teeth_no'];
		$opr_type=$r['opr_type'];
		$opr=$r['opr'];
		$opr_sub=$r['opr_sub'];
		$opr_part=$r['opr_part'];
		$last_opr=$r['last_opr'];
		//$teeth_part=get_val('den_x_opr_teeth','teeth_part',$id);
		$actOpr=0;
		if($doctor==$thisUser){
			if(mysql_q("DELETE FROM den_x_opr_teeth where id='$id'")){
				if($last_opr==1){
					$lasts=0;
					if($opr_type==2){
						$lasts=getTotalCO('den_x_opr_teeth',"patient='$patient' and teeth_no='$teeth' and teeth_part='$teeth_part' and last_opr=1 ");
					}
					if($lasts==0 || $opr_type==1){
						$sql="select * from den_x_opr_teeth where patient='$patient' and teeth_no='$teeth' and teeth_part='$teeth_part' order by date DESC";
						$res=mysql_q($sql);
						while($r=mysql_f($res)){
							$id2=$r['id'];
							$opr_type2=$r['opr_type'];
							if($actOpr==$opr_type2 || $actOpr==0){
								mysql_q("UPDATE den_x_opr_teeth SET last_opr=1 where id='$id2'");
								$actOpr=$opr_type2;
								if($actOpr==1){echo 1; exit;}
							}else{
								echo 1;exit;
							}
						}
					}
				}
				echo 1;
			}
		}
	}
}?>