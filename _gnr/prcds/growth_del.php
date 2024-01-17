<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(getTotalCO('gnr_x_growth_indicators',"id='$id' and user='$thisUser' ")){
		if(mysql_q("DELETE from gnr_x_growth_indicators where id ='$id' limit 1")){echo 1;}
	}
}?>