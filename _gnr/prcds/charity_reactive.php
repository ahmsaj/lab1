<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	if($t==1){$table='cln_x_visits';}
	if($t==2){$table='lab_x_visits';}
	if($t==3){$table='xry_x_visits';}
	if(mysql_q("UPDATE $table set sub_status=2 where id='$id' and pay_type=2 and status=1 and sub_status=1 ")){echo 1;}
}?>