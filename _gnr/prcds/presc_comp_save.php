<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['comp'])){
	$id=pp($_POST['id']);
	$comp=pp($_POST['comp'],'s');
	$r=getRecCon('gnr_x_prescription'," id='$id' and doc='$thisUser' ");
	if($r['r']){		
		if(mysql_q("UPDATE gnr_x_prescription SET complaint_txt='$comp' where id='$id'")){echo 1;}		
	}
}?>