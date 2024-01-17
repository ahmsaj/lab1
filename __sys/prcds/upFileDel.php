<? include("ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	echo deleteFiles($id);
}
?>