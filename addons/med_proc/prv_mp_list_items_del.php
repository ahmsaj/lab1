<? include("../header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);	
	$table_tmp=$mp_table[$t].'_tmp';	
	if(mysql_q("DELETE from $table_tmp where id='$id' and doc='$thisUser' ")){echo 1;}	
}?>