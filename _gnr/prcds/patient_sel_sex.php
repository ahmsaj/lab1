<? include("../../__sys/prcds/ajax_header.php");
if( isset($_POST['id'] , $_POST['n'])){
	$id=pp($_POST['id']);
	$n=pp($_POST['n']);
	if(mysql_q("UPDATE gnr_m_patients SET sex='$n' where id='$id'")){echo 1;}
}?>