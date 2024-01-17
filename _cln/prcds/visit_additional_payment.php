<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'] , $_POST['p'] , $_POST['mood'])){
	$vis=pp($_POST['id']);
	$t=pp($_POST['t']);
	$p=pp($_POST['p']);
	$mood=pp($_POST['mood']);
	$q='status=1';
	if($mood==1){$table='cln_x_visits';}
	if($mood==2){$table='lab_x_visits';$q='status>=1';}
	if($mood==3){$table='xry_x_visits';}
	//if($mood==4){$table='den_x_visits';}
	if($mood==5){$table='bty_x_visits';}
	if($mood==6){$table='bty_x_laser_visits';}
	
	$sql="select * from $table where id='$vis' and $q ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		if($mood==1){echo addPay1($vis,2);}
		if($mood==2){echo addPay2($vis,$t,$p);}
		if($mood==3){echo addPay3($vis,2);}
		//if($mood==4){echo addPay4($vis,2);}
		if($mood==5){echo addPay5($vis,2);}
		if($mood==6){echo addPay6($vis,2);}
	}
}
?>