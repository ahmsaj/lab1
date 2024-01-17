<? include("../../__sys/prcds/ajax_header.php");
$clinic=$userSubType;
$sql="select code,name_$lg,req from cln_m_addons where 
((clinic=0 AND service=0) OR (clinic='$clinic')) and act=1 order by ord ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){
	$dataArr=array();
	while($r=mysql_f($res)){
		$code=$r['code'];
		$name=$r['name_'.$lg];		
		$dataArr[$code]=$name;
	}
	$sel=get_val_con('cln_x_addons_per','addons'," user='$thisUser'");
	echo "co_selMultiArray('".arrayToJsObj($dataArr)."','".$sel."','setAddonsSave(\'[id]\')')";
}?>