<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['note'],$_POST['status'])){
	$id=pp($_POST['id']);
	$note=pp($_POST['note'],'s');
	$status=pp($_POST['status'],'s');
	if($status=='medicin'){
		if(mysql_q("UPDATE gnr_x_prescription_itemes SET note='$note' where id='$id'")){echo 1;}

	}elseif($status=='presc'){
	//	echo "UPDATE gnr_x_prescription SET note='$note' where id='$id' ";
		if(mysql_q("UPDATE gnr_x_prescription SET note='$note' where id='$id' ")){echo 1;}
	}
}?>