<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['v'])){
	$id=pp($_POST['id']);
	$v=pp($_POST['v'],'s');
	$ch=getTotalCO('cln_m_vital'," id='$id'");	
	if($ch){
		if(mysql_q("UPDATE cln_m_vital set `equation`='$v' where id='$id' ")){echo 1;}
	}	
}