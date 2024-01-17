<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'])){
	$m_code=pp($_POST['code'],'s');
	$sql="select code,title from _modules_items where mod_code='$m_code' and act = 1 order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$dataArr=array();
		while($r=mysql_f($res)){
			$code=$r['code'];
			$name=get_key($r['title']);		
			$dataArr[$code]=$name;
		}
		$sel=get_val_con('_ex_col','cols'," mod_code='$m_code'");
		echo "co_selMultiArray('".arrayToJsObj($dataArr)."','".$sel."','exColSave(\'$m_code\',\'[id]\')')";
	}
}?>
