<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['file'])){
	$file=pp($_POST['file']);
	$types=['excel'];
	$exs=['csv'];
	echo check_type_file($file,$types,$exs);
}?>