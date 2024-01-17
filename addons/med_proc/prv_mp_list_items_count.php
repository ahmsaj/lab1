<? include("../header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$table=$mp_table[$t].'_tmp';
	mysql_q("UPDATE $table SET times=times+1 where doc='$thisUser' and id='$id'");	   
}?>