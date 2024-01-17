<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])&& isset($_POST['ana'])){
	$id=pp($_POST['id']);
	$ana=pp($_POST['ana']);
	if(mysql_q("DELETE from  cln_x_pro_analy_items where mad_id='$id' and ana_id='$ana' limit 1")){
		echo $id;
	}
}?>