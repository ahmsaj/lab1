<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pat'],$_POST['offer'])){
	$pat=pp($_POST['pat']);
	$offer=pp($_POST['offer']);
    $payType=pp($_POST['pt']);
    $bank=pp($_POST['bank']);
	$ch1=getTotalCO('gnr_m_patients',"id='$pat'");
	$date_off_end=$now-86400;
	$r=getRecCon('gnr_m_offers',"id='$offer' and act=1 and date_s < $now and date_e > $date_off_end ");
	if($ch1 && $r['r']){
		$type=$r['type'];
		$date_s=$r['date_s'];
		$date_e=$r['date_e'];
		$clinics=$r['clinics'];
		$sett=$r['sett'];
		$s=explode(',',$sett);
		if($type==1){
			$amount=get_sum('gnr_m_offers_items','(price*quantity)'," offers_id='$offer' ");					
		}else if($type==6){			
			$amount=$s[3]*$s[2];
		}
		
		if(mysql_q("INSERT INTO gnr_x_offers (offer_id,date,date_s,date_e,patient,price) values ('$offer','$now','$date_s','$date_e','$pat','$amount')")){
			$ofId=last_id();
			echo $ofId;
            $commission=$differ=0;
            if($payType==2){// الدفع الالكتروني
                $perc=get_val('gnr_m_banks','perc',$bank);
                $commission=($amount*$perc)/100;
                //$commission=($amount/(1-($perc/100)))-$amount;
                //$total=ceil(($amount+$commission)/100) * 100;
                //$commission=($total/100)*$perc;
                //$differ=$total-$amount-$commission;
            }
			addPay($ofId,10,0,$amount,10,$payType,$commission,$perc,$bank);
			if($type==1){
				$sql="select * from gnr_m_offers_items where offers_id='$offer' ";
				$res2=mysql_q($sql);
				while($r2=mysql_f($res2)){
					$mood=$r2['mood'];
					$service=$r2['service'];
					$hos_part=$r2['hos_part'];
					$doc_part=$r2['doc_part'];
					$doc_percent=$r2['doc_percent'];
					$amount=$r2['price'];					
					mysql_q("INSERT INTO gnr_x_offers_items (offer_id,x_offer_id,patient,mood,service,hos_part,doc_part,doc_percent,price) values ('$offer','$ofId','$pat','$mood','$service','$hos_part','$doc_part','$doc_percent','$amount')");					
				}
			}else if($type==6){
				$mood=$clinics;
				$service=$s[1];
				if($mood==2){
					$unit=get_val($srvTables[$mood],'unit',$service);
                    list($unit,$cus_unit_price)=get_val($srvTables[$mood],'unit,cus_unit_price',$service);				    
					$hos_part=$unit;
					$doc_part=$s[2]/$unit;
                    //if($cus_unit_price){$doc_part=$cus_unit_price*$unit;}
					$doc_percent=0;
					
				}else{
					list($hos_p,$doc_p,$doc_pc)=get_val($srvTables[$mood],'hos_part,doc_part,doc_percent',$service);				
					$hos_part=$hos_p*100/$s[2];
					$doc_part=$doc_pc*100/$s[2];
					$doc_percent=$doc_pc;
				}
				$newPrice=$s[2];
				for($i=0;$i<$s[3];$i++){
					mysql_q("INSERT INTO gnr_x_offers_items (offer_id,x_offer_id,patient,mood,service,hos_part,doc_part,doc_percent,price) values ('$offer','$ofId','$pat','$mood','$service','$hos_part','$doc_part','$doc_percent','$newPrice')");
				}
			}
		}				
	}
}?>