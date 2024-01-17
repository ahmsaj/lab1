<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['p_id']) &&  isset($_POST['iteme']) &&  isset($_POST['q1']) &&  isset($_POST['q2'])){	
	$id=pp($_POST['id']);
	$trans_id=pp($_POST['p_id']);
	$iteme=pp($_POST['iteme']);
	$q1=pp($_POST['q1']);
	$q2=pp($_POST['q2']);
	$str_rec=get_val('str_x_transfers','str_rec',$trans_id);
	if(getTotalCO('str_x_transfers',"id='$trans_id' and status=0 ")){
		$pq='';
		$q=$q1;
		$t_price=$q1*$price;
		$u_price=$price;
		if($q2>0){
			$iPac=get_val('str_m_items','packing',$iteme);
			$pp=explode('-',$iPac);
			if($q2==1){
				$thisPac=$pp[0];
				$q=$pp[1]*$pp[3]*$q1;				
			}else{
				$thisPac=$pp[2];
				$q=$pp[3]*$q1;				
			}			
		}
		$ib=getItemBal($iteme,$userSubType);//item balans
		if($ib>=$q){
			if($id){mysql_q("DELETE FROM str_x_transfers_items where trans_id='$trans_id' and item_id='$iteme' ");}//if edit
			$prv_q=get_sum('str_x_transfers_items','quantity',"trans_id='$trans_id' and item_id='$iteme'");//check:same itemes
			$q+=$prv_q;//marage quantity
			mysql_q("DELETE FROM str_x_transfers_items where trans_id='$trans_id' and item_id='$iteme' ");//delete:same items
			$sql="select * from str_x_transfers_items where str_rec='$userSubType' and  item_id='$iteme' and status<3 order by date ASC ";//check recives items by date
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$sh_it_id=$r['sh_it_id'];
					$quantity=$r['quantity'];
					$item_id=$r['item_id'];
					$unit_price=$r['unit_price'];									
					$lastSend=get_sum('str_x_transfers_items','quantity',"item_id='$item_id' and str_send='$userSubType' and sh_it_id='$sh_it_id' ");//count send items from this storge in the same record
					$lastCons=get_sum('str_x_consumption_items','quantity',"item_id='$item_id' and strorage='$userSubType' and sh_it_id='$sh_it_id' ");//count cons items from this storge in the same record
					$this_itme_balans=$quantity-$lastSend-$lastCons;//this record balans
					$newQ=$q;
					if($this_itme_balans<$q){//check if balans enough to caver quantity
						$newQ=$this_itme_balans;						
					}
					$q-=$newQ;
					$date=get_val('str_x_transfers','date',$trans_id);
					$price=$newQ*$unit_price;
					if($this_itme_balans>0){
						$sql3="INSERT INTO str_x_transfers_items 
						(`trans_id`, `str_send`, `str_rec`, `sh_it_id`, `item_id`, `quantity`, `unit_price` ,`price`,`date`)	values('$trans_id','$userSubType','$str_rec','$sh_it_id','$item_id','$newQ','$unit_price','$price','$date')";
						mysql_q($sql3);
					}
					if($q==0){echo 1;exit;}
				}
			}
		}
	}	
}?>