<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['no'] , $_POST['t'] , $_POST['v'])){
	$id=pp($_POST['id']);
	$no=pp($_POST['no']);
	$t=pp($_POST['t']);
	$v=pp($_POST['v'],'s');
	$ch=getTotalCO('lab_m_services'," id='$id'");
	$item=0;
	if($ch){
		if($t==2 || $t==3){
			$value=$v;
			if($t==3){$item=$_POST['ch_type'];}
		}
		if($t==11){
			$t=1;
			$value=$v;
			$item=$_POST['f'];			
		}
		if($no){
			if(mysql_q("UPDATE lab_m_services_equations set `equations`='$value' , item='$item' where id='$no' and ana_no='$id'"))echo 1;
		}else{
			$ord=getMaxValOrder('lab_m_services_equations','ord'," where ana_no='$id' ");
			if(mysql_q("INSERT INTO lab_m_services_equations (`ana_no`,`type`,`item`,`equations`,`ord`)values('$id','$t','$item','$value','$ord')"))echo 1;
		}
	}	
}