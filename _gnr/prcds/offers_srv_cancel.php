<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_offers_oprations',$id);	
	if($r['r']){
		$mood=$r['mood'];
		$table=$srvTables[$mood];
		$visit_srv=$r['visit_srv'];
		$service=$r['service'];
		$vis=$r['visit'];
		$offer_type=$r['offer_type'];
		$offer_item=$r['offer_item'];			
		$r2=getRec($table,$service);
		if($r2['r']){
			if(in_array($mood,array(1,3,4,5,7))){
				list($doc,$emplo)=get_val($visXTables[$mood],'doctor,emplo',$vis);	
				$hos_part=$r2['hos_part'];
				$doc_part=$r2['doc_part'];
				$edit_price=$r2['edit_price'];
				$opr_type=$r2['opr_type'];				
				$total_pay=$hos_part+$doc_part;
				$doc_percent=$r2['doc_percent'];				
				$pay_net=$hos_part+$doc_part;
				if($pay_net && $doc && in_array($mood,[1,4])){
					$newPrice=get_docServPrice($doc,$service,$mood);
					$newP=$newPrice[0]+$newPrice[1];							
					if($newP){
						$doc_percent=$newPrice[2];
						$hos_part=$newPrice[0];
						$doc_part=$newPrice[1];
						$pay_net=$newP;$total_pay=$newP;
					}
				}

				if($emplo && $pay_net){
					if($cLlinicDis[$mood]){
						$hos_part=$hos_part-($hos_part/100*_set_osced6538u);
						$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
						$doc_part=$doc_part-($doc_part/100*_set_osced6538u);
						$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
						$pay_net=$hos_part+$doc_part;
					}
				}
				$xTable=$srvXTables[$mood];
				$sql="UPDATE   $xTable SET  `hos_part`='$hos_part', `doc_part`='$doc_part', `doc_percent`='$doc_percent', `pay_net`='$pay_net',`total_pay`='$total_pay' , `offer`=0	where id='$visit_srv' and visit_id='$vis' and service='$service'  and status=0 ";
				if(mysql_q($sql)){
					if($offer_type==1 || $offer_type==6){
						mysql_q("UPDATE gnr_x_offers_items SET  status=0 , date='' , vis=0 , srv_x_id=0 where id='$offer_item' and status=1 ");					
					}
					mysql_q("DELETE from gnr_x_offers_oprations where id='$id'");
					echo 1;
				};
			}
			if($mood==2){				
				$emplo=get_val($visXTables[$mood],'emplo',$vis);
				$s_id=$r2['id'];
				$name=$r2['name_'.$lg];
				$unit=$r2['unit'];
				$s_type=$r2['type'];
				$s_cat=$r2['cat'];					
				$unit_price=_set_x6kmh3k9mh;						
				if($emplo){
					if($cLlinicDis[$mood]){
						$unit_price=$unit_price-($unit_price/100*_set_fk9p1pamop);
						$unit_price=round($unit_price,-1,PHP_ROUND_HALF_DOWN);
					}
				}
				$pay_net=$unit_price*$unit;
				$total_pay=$unit_price*$unit;
				$xTable=$srvXTables[$mood];
				$sql="UPDATE  $xTable SET `units`='$unit', `units_price`='$unit_price', `pay_net`='$pay_net', `total_pay`='$total_pay' , `offer`=0 where id='$visit_srv' and visit_id='$vis' and service='$service'  and status=0 ";
				if(mysql_q($sql)){
					if($offer_type==1){
						mysql_q("UPDATE gnr_x_offers_items SET  status=0 , date='' , vis=0 , srv_x_id=0 where id='$offer_item' and status=1 ");					
					}
					mysql_q("DELETE from gnr_x_offers_oprations where id='$id'");
					echo 1;
				}			
			}
		}
	}	
}?>