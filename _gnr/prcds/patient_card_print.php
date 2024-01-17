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
		if(($now-$last_print)>60000 || $pay<$print_card){
			if($print_card==$pay){
				$print_card++;
			}			
			mysql_q("UPDATE gnr_m_patients set print_card='$print_card' , last_print='$now' where id='$id'");
			if($print_card==1){echo _set_pwnlndtt;}
			if($print_card>1){echo _set_o3rzlow59o;}		
		}else{
			echo 0;
		}
		
	}else{echo 'x';}
}else{echo 'x';}?>