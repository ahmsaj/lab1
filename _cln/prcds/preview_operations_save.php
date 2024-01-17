<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['p_id'] , $_POST['v_id']) ){
	$v_id=pp($_POST['v_id']);
	$p_id=pp($_POST['p_id']);
	$id=pp($_POST['id']);
	$opration=pp($_POST['cof_qrbonid0ch']);
	$hospital=pp($_POST['cof_r3d7penbgy']);
	$opr_date=pp($_POST['opr_date'],'dt');
	$duration=pp($_POST['duration'],'s');
	$price=pp($_POST['price']);
	$tools=pp($_POST['tools'],'s');	
	
	if($id){
		if(mysql_q("UPDATE cln_x_pro_x_operations set `opration`='$opration', `date`='$opr_date', `hospital`='$hospital' , `duration`='$duration' , `price`='$price' , `tools`='$tools' where id='$id'")){
			echo $id;
		}
	}else{	
		//echo "INSERT INTO cln_x_pro_x_operations (`p_id`,`v_id`,`opration`,`date`,`hospital`,`duration`,`price`,`tools`) 
		//values('$v_id','$opration','$opr_date','$hospital','$duration','$price','$tools')";	
		if(mysql_q("INSERT INTO cln_x_pro_x_operations (`p_id`,`v_id`,`opration`,`date`,`hospital`,`duration`,`price`,`tools`,`doc`) 
		values('$p_id','$v_id','$opration','$opr_date','$hospital','$duration','$price','$tools','$thisUser')")){
			echo last_id();
		}
	}
}
?>