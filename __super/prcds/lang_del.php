<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$effectedTable=array();	
	$sql="select m.table , i.colum , i.type from _modules m  , _modules_items i where m.code=i.mod_code and i.lang=1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$thisTable=$r['m.table'];
			$colum=$r['i.colum'];
			$colum=str_replace('(L)','',$colum);
			$type=$r['i.type'];
			array_push($effectedTable,array($thisTable,$colum,$type));
		}
	}
	
	$id=$_POST['id'];
	$sql="select * from `_langs` where `id`='$id' and def=0";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$l=$r['lang'];
		if(mysql_q("DELETE FROM  `_langs` where  `id`='$id'")){
			for($e=0;$e<count($effectedTable);$e++){
				$e_table=$effectedTable[$e][0];
				$e_colume=$effectedTable[$e][1];
				lang_effect('del',$e_table,$e_colume,$l);
			}
		}
	}
}?>