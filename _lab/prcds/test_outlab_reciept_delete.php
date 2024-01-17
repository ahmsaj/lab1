<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
 	$id=pp($_POST['id']);
	$sql="DELETE FROM `lab_x_receipt_items` where id=".$id;
	mysql_q($sql);
}?>