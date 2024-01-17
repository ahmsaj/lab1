<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['ids'])){
	$ids_arr=pp($_POST['ids'],'s');
	$ids_arr2=explode(',',$ids_arr);
	$l=pp($_POST['l']);
	$out=0;
	foreach($ids_arr2 as $id){
		list($patient,$price,$service)=get_val('lab_x_visits_services','patient,total_pay,service',$id);
		$lab_price=get_val_con('lab_m_external_labs_price','price',"lab='$l' and ana ='$service' " );
		if(!$lab_price){$lab_price=0;}
		
		 $sql="INSERT INTO `lab_x_visits_services_outlabs`
		 (`id`, `patient`, `out_lab`, `price`, `date_send`,`service`,`lab_price`) VALUES ('$id','$patient','$l','$price','$now','$service','$lab_price')";
		if(mysql_q($sql)){
			mysql_q("UPDATE `lab_x_visits_services` SET `out_lab`='$l' WHERE id='$id'");
			$out++;
		}
	}
	if($out>0){echo 1;}else {echo 0;}
}?>