<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){
	$id=pp($_POST['id']);
	$cType=pp($_POST['t']);
	echo delVis($id,$cType,2);	
}?>