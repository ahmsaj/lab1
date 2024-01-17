<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'])){	
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	echo ' ( '.getTotalCO('cln_x_vital',"patient ='$pat'").' )^';
	if($r['r']){echo getVSData($pat);}
}?>