<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['s'] , $_POST['itemsIds'] , $_POST['bc'])){
	$storage=pp($_POST['s']);
	$ids=pp($_POST['itemsIds'],'s');
	$bc=pp($_POST['bc'],'s');
	$bc_data='';
	if($ids){
		$ids_arr=explode(',',$ids);
		foreach($ids_arr as $this_id){
			if(isset($_POST['i'.$this_id])){
				$q=pp($_POST['i'.$this_id]);
				$q2=$q;
				$balans=getItemBal($this_id,$storage);
				if($q<=$balans && $q>0){
					$t_price=0;					
					$sql="select * from str_x_transfers_items where str_rec='$storage' and  item_id='$this_id' and status<3 order by date ASC ";//check recives items by date
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){							
							$sh_it_id=$r['sh_it_id'];
							$quantity=$r['quantity'];
							$item_id=$r['item_id'];
							$unit_price=$r['unit_price'];	$lastSend=get_sum('str_x_transfers_items','quantity',"item_id='$this_id' and str_send='$userStore' and sh_it_id='$sh_it_id' ");//count send items from this storge in the same record
							$lastCons=get_sum('str_x_consumption_items','quantity',"item_id='$this_id' and strorage='$userStore' and sh_it_id='$sh_it_id' ");//count cons items from this storge in the same record
							$this_itme_balans=$quantity-$lastSend-$lastCons;//this record balans
							$newQ=$q;
							if($this_itme_balans<$q){//check if balans enough to caver quantity
								$newQ=$this_itme_balans;						
							}
							$q-=$newQ;
							$total=$newQ*$unit_price;
							$sql3="INSERT INTO str_x_consumption_items 
							(`strorage`, `user`, `sh_it_id`, `item_id`, `quantity`, `unit_price` ,`total`,`date`)	values('$storage','$thisUser','$sh_it_id','$item_id','$newQ','$unit_price','$total','$now')";
							mysql_q($sql3);
							$t_price+=$total;							
							setNewBalShipIt($sh_it_id);
							fixBalIteme($item_id);
							if($q==0){
								if($bc_data){$bc_data.='|';}
								$bc_data.=$this_id.':'.$q2.':'.$t_price;
								 break;
							}
						}						
					}
				}
			}
		}
		if($bc){echo "'".$bc_data."'";}else{echo 1;}
	}
}?>