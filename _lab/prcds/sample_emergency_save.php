<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$sql="select * from lab_x_visits_services where visit_id='$id' and status IN(0,2,4,5)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$ser_id=$r['id'];
			$fast=$r['fast'];
			$f='x';
			if(isset($_POST['s_'.$ser_id]) && $fast==0){$f='1';}
			if(!isset($_POST['s_'.$ser_id]) && $fast==1){$f='0';}
			if($f!='x'){mysql_q("UPDATE lab_x_visits_services SET fast='$f' where id ='$ser_id' ");}
		}
	}
	echo 1;
}?>