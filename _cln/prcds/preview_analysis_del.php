<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	mysql_q("DELETE from  cln_x_pro_analy_items where ana_id='$id'");
	mysql_q("DELETE from  cln_x_pro_analy where id='$id'");
}?>