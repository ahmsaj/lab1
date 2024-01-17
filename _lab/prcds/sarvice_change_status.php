<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['srv'] , $_POST['sample'])){
	$id=pp($_POST['srv']);
	$sample=pp($_POST['sample']);
	$ch1=getTotal('lab_x_visits_services','id',$id);
	$ch2=getTotal('lab_m_samples','id',$sample);
	if($ch1 && $ch2){
		mysql_q("update lab_x_visits_services set sample='$sample' where id='$id'");
		echo 1;
	}else{
		echo 0;
	}
}?>