<? include("../header.php");
if(isset($_POST['id'],$_POST['t'],$_POST['val'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$val=pp($_POST['val'],'s');	
	$table_tmp=$mp_table[$t].'_tmp';
	if(mysql_q("UPDATE $table_tmp SET val='$val' where doc='$thisUser' and id='$id'")){
		if(mysql_a()){echo 1;}	
	}
}?>