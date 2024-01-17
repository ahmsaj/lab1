<? include("../../__sys/prcds/ajax_header.php");if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$sql="select * from str_x_bill_items where ship_id='$id' and status=0 ";
	$shipDate=get_val('str_x_bill','date',$id);
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$err=0;
	if($rows>0){
		$now3=$now;
		if(getTotalCO('str_x_transfers',"ship_id='$id'")==0){
			mysql_q("INSERT INTO str_x_transfers (`str_send`,`user_send`,`str_rec`,`user_rec`,`date`,`status`,`ship_id`)
			values(0,0,'$userSubType','$thisUser','$now3',2,'$id')");
			$trans_id=last_id();
			while($r=mysql_f($res)){
				$sh_it_id=$r['id'];
				$storage=$r['storage'];
				$item_id=$r['item_id'];
				$quantity=$r['quantity'];
				$unit_price=$r['unit_price'];
				$price=$r['price'];
				if(mysql_q("INSERT INTO str_x_transfers_items (`trans_id`, `str_send`, `str_rec`, `sh_it_id`, `item_id`, `quantity`, `unit_price` ,`price` ,`status`,`date`)			values('$trans_id','0','$userSubType','$sh_it_id','$item_id','$quantity','$unit_price','$price',2,'$now3')")){			
					if(mysql_q("UPDATE str_x_bill_items SET status=1 , date='$shipDate' where status=0 and id='$sh_it_id' and ship_id='$id'"));					
				}else{$err=1;}	
			}
			fixBal_trns($trans_id);
			if($err==0){if(mysql_q("UPDATE str_x_bill SET status=1 where status=0 and id='$id'")){echo 1;}}
		}
	}
}?>
