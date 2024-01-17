<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);echo "UPDATE xry_x_pro_radiography view='1' where id='$id'";
	mysql_q("UPDATE xry_x_pro_radiography set view='1' where id='$id'");
	echo $id;
}?>