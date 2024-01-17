<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(mysql_q("DELETE from lab_m_services_equations  where id='$id' "))echo 1;

}