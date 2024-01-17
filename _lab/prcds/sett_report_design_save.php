<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['grv'])){
	$id=pp($_POST['id']);
	$grv=pp($_POST['grv'],'s');
	if(mysql_q("UPDATE lab_m_services SET report_de='$grv' where id='$id'"))echo 1;
}?>
