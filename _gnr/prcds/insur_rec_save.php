<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['p_insure'])){
	$id=pp($_POST['id']);	
	$p_insure=pp($_POST['p_insure']);
	$r_req=getRec('gnr_x_temp_oprs',$id);
	if($r_req['r']){
		$mood=$r_req['mood'];
		$clinic=$r_req['clinic'];
		$patient=$r_req['patient'];
		$vis=$r_req['vis'];
		
		$table=$visXTables[$mood];
		$r_visit=getRec($table,$vis);
		$doctor=$r_visit['doctor'];
		$vis_status=$r_visit['status'];
		$srvCounter=0;
		list($insu_no,$prov_id)=get_val('gnr_m_insurance_rec','no,provider',$p_insure);
		$unitPriceInsur=get_val('gnr_m_insurance_prov','lab_unit_price',$prov_id);
		if($insu_no){
			if($mood==1){				
				$sql="select * from cln_x_visits_services where visit_id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					$srvCounter=0;
					while($r=mysql_f($res)){
						$serv_id=$r['id'];
						$service=$r['service'];				
                        list($hos_part,$doc_part)=get_val('cln_m_services','hos_part,doc_part',$service);
						$price=$hos_part+$doc_part;					
						if($doctor){			
							$newPrice=get_docServPrice($doctor,$service,$mood);
							$newP=$newPrice[0]+$newPrice[1];							
							if($newP){$price=$newP;}
						}			
						$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");						
						$in_cost=$insurPrice*(_set_1foqr1nql3/100);
						if(isset($_POST['s_'.$serv_id])){
							if(mysql_q("INSERT INTO gnr_x_insurance_rec (`insur_id`, `insur_no`, `patient`, `mood`,`visit`, `service_x`,`service`, `price`, `in_price`, `s_date`, `user` , `in_cost`,`company`) values
							('$p_insure', '$insu_no', '$patient', '$mood', '$vis', '$serv_id', '$service', '$price', '$insurPrice', '$now', '$thisUser' , '$in_cost' ,'$prov_id')")){
								$srvCounter++;
							}
						}
					}
					mysql_q("UPDATE gnr_x_temp_oprs SET sub_status=1 where type=3 and mood='$mood' and vis='$vis' ");
				}		
			}
			if($mood==2){
				$sql="select * from lab_x_visits_services where visit_id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					$srvCounter=0;
					while($r=mysql_f($res)){
						$serv_id=$r['id'];
						$service=$r['service'];				
						$unit=get_val('lab_m_services','unit',$service);
						$unitPrice=$unitPriceInsur;
						$customPrice=get_val_con('gnr_m_insurance_prices_custom','price'," insur='$prov_id' and service='$service' ");
						if($customPrice){$unitPrice=$customPrice;}
						
						$price=$unit*$unitPrice;
						$in_cost=$price*(_set_1foqr1nql3/100);
						if(isset($_POST['s_'.$serv_id])){
							if(mysql_q("INSERT INTO gnr_x_insurance_rec (`insur_id`, `insur_no`, `patient`, `mood`,`visit`, `service_x`,`service`, `price`, `in_price`, `s_date`, `user` , `in_cost`,`company`) values
							('$p_insure', '$insu_no', '$patient', '$mood', '$vis', '$serv_id', '$service', '$price', '$price', '$now', '$thisUser' , '$in_cost','$prov_id')")){
								$srvCounter++;
							}
						}
					}
					mysql_q("UPDATE gnr_x_temp_oprs SET sub_status=1 where type=3 and mood='$mood' and vis='$vis' ");
				}		
			}
			if($mood==3){				
				$sql="select * from xry_x_visits_services where visit_id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					$srvCounter=0;
					while($r=mysql_f($res)){
						$serv_id=$r['id'];
						$service=$r['service'];				
                        list($hos_part,$doc_part)=get_val('xry_m_services','hos_part,doc_part',$service);
						$price=$hos_part+$doc_part;			
						$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");
						
						$in_cost=$insurPrice*(_set_1foqr1nql3/100);
						if(isset($_POST['s_'.$serv_id])){
							if(mysql_q("INSERT INTO gnr_x_insurance_rec (`insur_id`, `insur_no`, `patient`, `mood`,`visit`, `service_x`,`service`, `price`, `in_price`, `s_date`, `user` , `in_cost`,`company`) values
							('$p_insure', '$insu_no', '$patient', '$mood', '$vis', '$serv_id', '$service', '$price', '$insurPrice', '$now', '$thisUser' , '$in_cost' ,'$prov_id')")){
								$srvCounter++;
							}
						}
					}
					mysql_q("UPDATE gnr_x_temp_oprs SET sub_status=1 where type=3 and mood='$mood' and vis='$vis' ");
				}		
			}
			if($mood==4){				
				$sql="select * from den_x_visits_services where visit_id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					$srvCounter=0;
					while($r=mysql_f($res)){
						$serv_id=$r['id'];
						$service=$r['service'];				list($hos_part,$doc_part)=get_val('den_m_services','hos_part,doc_part',$service);
						$price=$hos_part+$doc_part;					
						if($doctor){			
							$newPrice=get_docServPrice($doctor,$service,$mood);
							$newP=$newPrice[0]+$newPrice[1];							
							if($newP){$price=$newP;}
						}			
						$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");						
						$in_cost=$insurPrice*(_set_1foqr1nql3/100);
						if(isset($_POST['s_'.$serv_id])){
							if(mysql_q("INSERT INTO gnr_x_insurance_rec (`insur_id`, `insur_no`, `patient`, `mood`,`visit`, `service_x`,`service`, `price`, `in_price`, `s_date`, `user` , `in_cost`,`company`) values
							('$p_insure', '$insu_no', '$patient', '$mood', '$vis', '$serv_id', '$service', '$price', '$insurPrice', '$now', '$thisUser' , '$in_cost' ,'$prov_id')")){
								$srvCounter++;
							}
						}
					}
					mysql_q("UPDATE gnr_x_temp_oprs SET sub_status=1 where type=3 and mood='$mood' and vis='$vis' ");
				}		
			}
			if($mood==7){				
				$sql="select * from osc_x_visits_services where visit_id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					$srvCounter=0;
					while($r=mysql_f($res)){
						$serv_id=$r['id'];
						$service=$r['service'];				list($hos_part,$doc_part)=get_val('osc_m_services','hos_part,doc_part',$service);
						$price=$hos_part+$doc_part;			
						$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");
						
						$in_cost=$insurPrice*(_set_1foqr1nql3/100);
						if(isset($_POST['s_'.$serv_id])){
							if(mysql_q("INSERT INTO gnr_x_insurance_rec (`insur_id`, `insur_no`, `patient`, `mood`,`visit`, `service_x`,`service`, `price`, `in_price`, `s_date`, `user` , `in_cost`,`company`) values
							('$p_insure', '$insu_no', '$patient', '$mood', '$vis', '$serv_id', '$service', '$price', '$insurPrice', '$now', '$thisUser' , '$in_cost' ,'$prov_id')")){
								$srvCounter++;
							}
						}
					}
					mysql_q("UPDATE gnr_x_temp_oprs SET sub_status=1 where type=3 and mood='$mood' and vis='$vis' ");
				}		
			}
			if($srvCounter){
				//if($vis_status>0){
					//delTempOpr($mood,$vis,3);
				//}else{
					editTempOpr($mood,$vis,3,1);
				//}
				//mysql_q("UPDATE $table SET sub_status=1 where id='$vis' ");
			}
		}
	}
}?>