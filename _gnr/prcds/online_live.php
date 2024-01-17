<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from _log ";
$res=mysql_q($sql);
$rows=mysql_n($res);
$data=array();
while($r=mysql_f($res)){
	$t=$r['s_out']-$r['s_in'];
	//if($t<20){
		$d= $r['user'].','.clockStr($t,0);
		array_push($data,$d);
	//}
}
echo implode('|',$data);
?>