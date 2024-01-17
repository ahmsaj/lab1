<? include("api__ajax_header.php"); 
if(isset($_POST['s'],$_POST['i'],$_POST['c'],$_POST['p'],$_POST['ac'])){
	$sql="select * from api_noti_set where user='$thisUser' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$s=pp($_POST['s'],'s');
		$i=pp($_POST['i'],'s');
		$c=pp($_POST['c'],'s');
		$p=pp($_POST['p'],'s');
		$ac=pp($_POST['ac'],'s');
		$sms=pp($_POST['sms'],'s');
		if($s && $i && $c && $p && $ac){
			if(mysql_q("UPDATE api_noti_set SET sound='$s' ,icon='$i' ,color='$c', priority='$p', channal='$ac' ,sms='$sms' where user='$thisUser' limit 1 ")){echo 1;}			
		}
	}
}?>