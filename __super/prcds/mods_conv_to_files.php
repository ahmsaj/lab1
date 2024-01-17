<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'],$_POST['mod'])){
	$type=pp($_POST['type']);
	$mod=pp($_POST['mod'],'s');
	echo moduleGen($type,$mod,1);
}