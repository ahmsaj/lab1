<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mdc']) &&  isset($_POST['ana'])){
	$mdc=pp($_POST['mdc']);
	$ana=pp($_POST['ana']);	
	if(mysql_q("INSERT INTO cln_x_pro_analy_items (`ana_id`,`mad_id`)values('$ana','$mdc')")){
		echo $mdc;
	}
}?>