<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	if(mysql_q("DELETE from  cln_x_pro_x_operations where id='$id' and doc='$thisUser' limit 1")){
		echo $id;
	}
}?>