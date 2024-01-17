<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'] , $_POST['prams'] , $_POST['id'])){
	$type=$_POST['type'];
	$prams=$_POST['prams'];
	$id=$_POST['id'];	
	echo getModItInput($id,$type,$prams);
}?>