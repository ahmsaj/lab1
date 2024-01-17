<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['temp'])){		
	$id=pp($_POST['id']);
	$temp=pp($_POST['temp']);
	$r=getRec('gnr_x_prescription_temp',$temp);
	if($r['r']){		
		mysql_q("delete from gnr_x_prescription_itemes where presc_id='$id' ");
		$mads=$r['mads'];
		if($mads){
			$m=explode('|',$mads);
			foreach($m as $mad){
				$m2=explode(',',$mad);
				$i1=$m2[0];
				$i2=$m2[1];
				$i3=$m2[2];
				$i4=$m2[3];
				$i5=$m2[4];
				$sql="INSERT INTO gnr_x_prescription_itemes (`presc_id`,`mad_id`,`dose`,`num`,`duration`,`dose_s`,`doc`)
				values('$id','$i1','$i2','$i3','$i4','$i5','$thisUser')";
				mysql_q($sql);
			}
		}		
	}
}?>
