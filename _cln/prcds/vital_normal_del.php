<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(mysql_q("DELETE from cln_m_vital_normal  where id='$id' "))echo 1;

}