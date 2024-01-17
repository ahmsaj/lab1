<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mood'])){
	$vis=pp($_POST['id']);
	$mood=pp($_POST['mood']);
	if($mood==1){
		$sql="select * from cln_x_visits where id='$vis' and status=2";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){echo addPay1($vis,4);}	
	}
	if($mood==3){
		$sql="select * from xry_x_visits where id='$vis' and status=2";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){echo addPay3($vis,4);}	
	}
	if($mood==5){
		$sql="select * from bty_x_visits where id='$vis' and status=2";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){echo addPay5($vis,4);}	
	}
}
?>