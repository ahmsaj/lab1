<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['teeth'],$_POST['cav'],$_POST['cavS'])){
	$vis=pp($_POST['vis']);
	$teeth=pp($_POST['teeth']);
	$cav=pp($_POST['cav']);
	$cavS=pp($_POST['cavS']);
	$r=pp($_POST['r'])-1;
	$cavN=getCavNo($teeth,$r);
	list($status,$doctor,$patient)=get_val('den_x_visits','status,doctor,patient',$vis);
	if($stats==0){
		mysql_q("UPDATE den_x_opr_teeth SET `last_opr`=0 where `patient`='$patient' and `teeth`='$teeth' and teeth_part=2 and opr_sub='$cav' ");
		$sql="INSERT INTO den_x_opr_teeth (teeth_part,visit,doctor,patient,teeth,opr_type,opr,opr_sub,opr_part,date)
		values(2,'$vis','$doctor','$patient','$teeth',2,'$cavS','$cav','$cavN','$now')";
		if(mysql_q($sql)){
			echo 1;
		}
	}
}?>