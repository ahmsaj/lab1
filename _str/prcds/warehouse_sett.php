<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'] , $_POST['f'])){
	$v=pp($_POST['v'],'s');
	$f=pp($_POST['f'],'s');
	echo get_str_str_set($v,$f,'');	
}
?>