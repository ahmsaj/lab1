<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['price'])){
	$id=pp($_POST['id']);
	$price=pp($_POST['price']);
	if($price){
		$r=getRec('cln_x_visits_services',$id);
		$rows=$r['r'];
		if($rows>0){
			$s_id=$r['id'];			
			$service=$r['service'];
			$s_status=$r['status'];
			$doc_percent=$r['doc_percent'];
			$offer=$r['offer'];
			$doc=$r['doc'];
			if(($s_status==0 || $s_status==2) && $doc=$thisUser){
				$edit_price=get_val('cln_m_services','edit_price',$service);							
				if($edit_price){					
					if($offer){
						list($opr_id,$offer_item)=get_val_con('gnr_x_offers_oprations','id,offer_item'," visit_srv='$s_id' and mood=1 ");
						$r=getRec('gnr_m_offers_items',$offer_item);
						if($r['r']){
							$it_id=$r['id'];
							$dis_percent=$r['dis_percent'];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];
							$doc_percent=$r['doc_percent'];
							
							$oldPrice=$price;
							$price=roundNo($price-($dis_percent*$price/100),100);							
							mysql_q("UPDATE gnr_x_offers_oprations SET offer_srv_price='$price' , visit_srv_price='$oldPrice' where id='$opr_id'");
						}
					}
					
					if($doc_percent!=0){
						$hos_part=0;
						$doc_part=$price;
					}else{
						$doc_part=0;
						$hos_part=$price;
					}
					
					$sql="UPDATE  cln_x_visits_services set hos_part='$hos_part' , doc_part='$doc_part' ,doc_percent='$doc_percent', pay_net='$price' ,total_pay='$price' , status=2  where id ='$id' and status in(0,2)";
					if(mysql_q($sql)){
						echo 1;						
					}
				}
			}
		}
	}else{echo 0;}
}?>
