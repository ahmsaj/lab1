<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'] , $_POST['type'])){
	$code=$_POST['id'];
	$t=$_POST['t'];
	$type=$_POST['type'];
	if($type==1){
		$sql="select * from _modules where code='$code' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$table=$r['table'];
			mysql_q("DELETE FROM _modules where code='$code'");
			mysql_q("DELETE FROM _modules_butts where mod_code='$code'");
			mysql_q("DELETE FROM _modules_cons where mod_code='$code'");
			mysql_q("DELETE FROM _modules_items where mod_code='$code'");
			mysql_q("DELETE FROM _modules_links where mod_code='$code'"); 
			if($t){
                if(!in_array($table,$sysTableArr)){
                    mysql_q("DROP TABLE $table ");
                }
            }
			$sql="select * from _modules_list where type='$type' and mod_code= '$code'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$mml_id=$r['code'];
					mysql_q("DELETE FROM _modules_list where code='$mml_id' ");
					mysql_q("DELETE FROM _perm where m_code='$mml_id' ");
				}
			}
			echo 1;			
		}
	}
	if($type==2){
		$sql="select * from _modules_ where code='$code' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			mysql_q("DELETE FROM _modules_ where code='$code'");
			$sql="select * from _modules_list where type='$type' and  mod_code= '$code'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$mml_id=$r['code'];
					mysql_q("DELETE FROM _modules_list where code='$mml_id'");
					mysql_q("DELETE FROM _perm where m_code='$mml_id'");
				}
			}
			echo 1;			
		}
	}
}?>