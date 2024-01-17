<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$id=pp($_POST['id']);
	$pat=pp($_POST['pat']);
	$vis=pp($_POST['vis']);	
	$r=getRecCon('cln_x_visits'," id='$vis' and doctor='$thisUser' ");	
	if($r['r']){
		$visStatus=$r['status'];
		if($visStatus==1 || _set_whx91aq4mx){
			$sql="DELETE from cln_x_medical_his where id='$id' and patient='$pat'";	$res=mysql_q($sql);
			if(mysql_a()){echo 1;}
		}
	}
}?>