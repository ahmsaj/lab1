<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'],$_POST['f'],$_POST['val'])){
	$type=pp($_POST['t']);
    $fil=pp($_POST['f'],'s');
    $val=pp($_POST['val'],'s');
    echo getDCV($type,$fil,$val);
}?>
