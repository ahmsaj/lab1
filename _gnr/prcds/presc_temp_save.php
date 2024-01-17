<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['tamp'])){	
	$id=pp($_POST['id']);
	$tamp=pp($_POST['tamp'],'s');	
	$mads='';
	$sql="select * from gnr_x_prescription_itemes where presc_id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$mad_id=$r['mad_id'];
			$dose=$r['dose'];
			$num=$r['num'];
			$duration=$r['duration'];
			$dose_s=$r['dose_s'];
			if($mads){$mads.='|';}
			$mads.=$mad_id.','.$dose.','.$num.','.$duration.','.$dose_s;
		}
		if($mads!=''){
			if(mysql_q("INSERT INTO gnr_x_prescription_temp (name,mads,doc)values('$tamp','$mads','$thisUser')")){echo 1;}
		}
	}
}
?>
