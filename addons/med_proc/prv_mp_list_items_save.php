<? include("../header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$table=$mp_table[$t];
	$table_tmp=$mp_table[$t].'_tmp';
	list($doc,$val)=get_val($table,'doc,val',$id);
	if($doc==$thisUser){
		if(mysql_q("INSERT INTO $table_tmp (doc,val)values('$doc','$val')")){echo 1;}
	}
}?>