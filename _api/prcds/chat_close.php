<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    if(mysql_q("UPDATE api_chat SET status=1 where id='$id'")){echo 1;}
}?>