<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	if(addRoles($id,$t)){echo 1;}
}?>

