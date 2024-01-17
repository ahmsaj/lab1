<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($doc,$status)=get_val('xry_x_visits_requested','doc,status',$id);
	if($doc==$thisUser && $status==0){	
		mysql_q("DELETE from xry_x_visits_requested_items where r_id='$id'");
		if(mysql_q("DELETE from xry_x_visits_requested where id='$id'")){
			echo 1;
		}
	}
}?>