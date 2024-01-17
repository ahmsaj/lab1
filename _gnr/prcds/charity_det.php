<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){$id=pp($_POST['id']);echo getCharInfo($id);}?>