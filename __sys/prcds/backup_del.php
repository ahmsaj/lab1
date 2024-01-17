<? include("ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id'],'s');
	$type=pp($_POST['type']);
	deleleBuckup($id,$type);
	echo 1;
}?>