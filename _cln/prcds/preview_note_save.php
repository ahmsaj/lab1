<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'])&& isset($_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	$r=pp($_POST['r'],'s');
	mysql_q("UPDATE cln_x_visits set note='$r' where id='$v_id' and patient='$p_id'");

}?>