<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$rec=getRec('str_x_transfers',$id);
	if($rec['r']){ 
		$new_status=0;
		$status=$rec['status'];
		$str_send=$rec['str_send'];
		$str_rec=$rec['str_rec'];				
		if($status==0 && $str_send==$userStore){$new_status=1;}
		if($status==1 && $str_rec==$userStore){$new_status=2;}
		if($new_status){		
			if(mysql_q("UPDATE str_x_transfers SET status=$new_status , user_rec='$thisUser'  where status=$status and id='$id'")){
			if(mysql_q("UPDATE str_x_transfers_items SET status=$new_status where status=$status and trans_id='$id'")){echo 1;}
			}
		}
		fixBal_trns($id);
	}
}?>
