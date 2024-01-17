<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'] , $_POST['code'])){
	$p_id=pp($_POST['p_id']);
	$code=pp($_POST['code'],'s');
	$bloadType=array('o+','o-','a+','a-','b+','b-','ab+','ab-','');
	if(in_array($code,$bloadType)){
		mysql_q("UPDATE gnr_m_patients SET blood='$code' where id='$p_id'");
	}
}?>