<? include("../header.php");
if(isset($_POST['pat'],$_POST['vis'])){	
	$pat=pp($_POST['pat']);
	$vis=pp($_POST['vis']);
	$sex=pp($_POST['sex']);
	$birth=pp($_POST['birth'],'s');
	$f_hi=pp($_POST['f_hi']);
	$m_hi=pp($_POST['m_hi']);	
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		if($sex && $birth && $f_hi && $m_hi){
			$t=getTotalCO('gnr_m_patients_medical_info'," patient = '$pat' ");	
			if($t){			
				$sql="UPDATE gnr_m_patients_medical_info SET `sex`='$sex' ,`birth_date`='$birth' ,`father_height`='$f_hi',`mother_height`='$m_hi' where patient='$pat'";
			}else{
				$sql="INSERT INTO gnr_m_patients_medical_info (`sex`,`birth_date`,`father_height`,`mother_height`,`patient`) values ('$sex','$birth','$f_hi','$m_hi','$pat')";
			}
			if(mysql_q($sql)){
				giPatUpdate($pat);
			}
		}
	}else{
		exit; out();	
	}
}?>
