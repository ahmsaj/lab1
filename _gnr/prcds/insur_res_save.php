<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$ref_no=pp($_POST['req_no'],'s');
	if($ref_no){
		$r_req=getRec('gnr_x_temp_oprs',$id);
		if($r_req['r']){
			$mood=$r_req['mood'];
			$clinic=$r_req['clinic'];
			$patient=$r_req['patient'];
			$vis=$r_req['vis'];			
			$sql="select  * from gnr_x_insurance_rec where mood='$mood' and visit='$vis' and status=0";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){	
				while($r=mysql_f($res)){
					$in_id=$r['id'];				
					$mood=$r['mood'];
					$service=$r['service'];
					$service_x=$r['service_x'];
					$company=$r['company'];
					$in_price=$r['in_price'];
					$in_price_includ=$r['in_price_includ'];
					$s_date=$r['s_date'];
					$status=$r['status'];
					if(isset($_POST['srv_'.$in_id])){
						$in_res=pp($_POST['s_'.$in_id]);
						$amount=pp($_POST['ser'.$in_id]);
						$incPrice=$in_price-$amount;
						if(($in_res==1 || $in_res==2 ) && $ref_no && $amount<=$in_price){
							$doc=0;
							$table=$visXTables[$mood];	
							if($mood!=2){$doc=get_val($table,'doctor',$vis);}							
							if($in_res==2){$incPrice=0;}
							$sql="UPDATE gnr_x_insurance_rec SET in_price_includ='$incPrice' , res_status='$in_res' , r_date='$now', ref_no='$ref_no' , status=1 , doc='$doc' where id='$in_id' ";
							
							if(mysql_q($sql)){
								if($in_res==1){                                    
									fixInsureServic($in_id,$in_price,$incPrice,$service_x,$mood,$in_res,$company);
								}								
							}							
						}
					}
				}
			}
            $progSrvs=getTotalCo('gnr_x_insurance_rec'," mood='$mood' and visit='$vis' and status=0");
            if($progSrvs==0){
                if($mood==4){					
                    addPay4($vis,4,$incPrice);
                    delTempOpr($mood,$vis,'a');
                    mysql_q("UPDATE gnr_x_visits_services_alert SET status=1 where mood='$mood' and visit_id='$vis' ");
                }

                $vis_status=get_val($table,'status',$vis);
                if($vis_status>0){
                    if($vis_status==2){
                        makeSerPayAlert($vis,$mood);
                    }
                    delTempOpr($mood,$vis,3);                    
                }else{
                    mysql_q("UPDATE gnr_x_temp_oprs SET sub_status=2 where type=3 and mood='$mood' and vis='$vis' ");
                }
            }
		}
	}
}
