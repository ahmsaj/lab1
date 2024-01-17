<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(mysql_q("DELETE FROM gnr_m_offers_items where id='$id' ")){echo 1;}
}?>