<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'] , $_POST['p'], $_POST['id'])){	
	$id=pp($_POST['id']);
	$v=pp($_POST['v']);
	$p=pp($_POST['p']);
	$ch1=getTotalCO('cln_x_visits',"id='$v' and patient='$p' and doctor='$thisUser'");
	$ch2=getTotalCO('cln_m_icpc',"id='$id'");
	if($ch1 && $ch2){
		if(mysql_q("INSERT INTO cln_x_prv_icpc  (`visit`,`patient`,`opr_id`)values('$v','$p','$id') ")){
			echo 1;
		}
	}
}?>