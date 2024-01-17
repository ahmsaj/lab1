<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$sql="select * from gnr_m_patients where id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$print_card=$r['print_card'];
		$last_print=$r['last_print'];
		$pay=$r['pay'];		
		if($print_card>$pay){
			if(mysql_q("UPDATE gnr_m_patients set pay='$print_card' where id='$id'")){
				if(addPay1($id,5)){echo 1;}
			}
		}
	}
}?>