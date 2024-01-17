<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$mad_id=get_val_con('gnr_x_prescription_itemes','mad_id',"id='$id' and doc='$thisUser'");
	if($mad_id){
		if(mysql_q("DELETE from gnr_x_prescription_itemes where id='$id' limit 1")){
			echo $mad_id;
		}
	}else{
		echo 0;
	}
}?>