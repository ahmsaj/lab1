<? include("ajax_header.php");
$sql="select * from _log order by user ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
$data=array();
while($r=mysql_f($res)){
	$t=$r['s_out']-$r['s_in'];
    $title=$r['mod_title'];
    $user=$r['user'];
    $status=$r['status'];
    if(!$title){$title='-';}    
	$data[]=array($user,$t,$title,$status);
}
echo $json=json_encode($data,JSON_UNESCAPED_UNICODE);

?>