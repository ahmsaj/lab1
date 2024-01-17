<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['p_id']) &&  isset($_POST['iteme']) &&  isset($_POST['price'])&&  isset($_POST['q1']) &&  isset($_POST['q2'])){	
	$id=pp($_POST['id']);
	$sh_id=pp($_POST['p_id']);
	$iteme=pp($_POST['iteme']);	
	$price=pp($_POST['price']);
	$q1=pp($_POST['q1']);
	$q2=pp($_POST['q2']);
	$storage=get_val('str_x_bill','storage',$sh_id);
	if(getTotalCO('str_x_bill',"id='$sh_id' and status=0 ") && getTotalCO('str_m_items',"id='$iteme'")){
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
			$u_price=$t_price/$q;
			$pq=$thisPac.','.$q1.','.$price.','.$q2;
		}
		if($id){
			$sql="UPDATE str_x_bill_items SET `pac_quantity`='$pq',`quantity`='$q',`qu_balans`='$q',`price`='$t_price',`unit_price` ='$u_price' where id='$id'";
		}else{
			$sql="INSERT INTO str_x_bill_items(`ship_id`,`item_id`,`pac_quantity`,`quantity`,`qu_balans`,`price`,`unit_price`,`storage` )
			values('$sh_id','$iteme','$pq','$q','$q','$t_price','$u_price','$storage')";
		}
		if(mysql_q($sql)){echo 1;}
		
	}

	
}?>