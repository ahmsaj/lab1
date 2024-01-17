<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$code=$_POST['id'];
	$sql="select * from _modules_list where code='$code' or p_code='$code' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){			
			if(mysql_q("DELETE from _modules_list where code='$code' or p_code='$code' ")){
				mysql_q("DELETE FROM _perm where m_code='$code'");				
			}
		}
	}
	echo 1;
}?>
