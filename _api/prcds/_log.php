<? include("api__ajax_header.php");
logHis();
$sql="select s_out from api__log where user='$thisUser'";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$r=mysql_f($res);$s_out=$r['s_out'];	
	if(($now-$s_out)< intval($logTime/1000)+7){mysql_q("UPDATE api__log set `s_out`='$now' where `user` ='$thisUser'");}
}else{mysql_q("INSERT INTO api__log (`user`,`s_in`,`s_out`)values('$thisUser','$now','$now')");}


?>