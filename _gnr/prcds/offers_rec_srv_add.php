<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pat'],$_POST['vis'],$_POST['offer'],$_POST['mood'])){
	$offer=pp($_POST['offer']);
	$pat=pp($_POST['pat']);
	$vis=pp($_POST['vis']);
	$mood=pp($_POST['mood']);
	$date_off_end=$now-86400;
	$r=getRecCon('gnr_m_offers',"id ='$offer' and act =1 and date_s < $now and date_e > $date_off_end and FIND_IN_SET('$mood',`clinics`)> 0 ");
	if($r['r']){	
		$type=$r['type'];
		if($type==2){
			$srvs=implode(',',$_POST['srv']);			
			if($srvs){
				$sql="select * from gnr_m_offers_items where offers_id='$offer' and service IN($srvs)";	
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					while($r=mysql_f($res)){
						$offer_serv=$r['id'];
						$mood=$r['mood'];
						$service=$r['service'];
						$hos_part=$r['hos_part'];
						$doc_part=$r['doc_part'];						
						$doc_percent=$r['doc_percent'];	
						$table=$srvXTables[$mood];
						$doctor=0;
						if($mood==2){
							list($s_id,$s_patient,$s_status)=get_val_con($table,'id,patient,status',"service='$service' and visit_id='$vis' ");							
						}else{
							list($s_id,$s_patient,$s_status,$doctor)=get_val_con($table,'id,patient,status,doc',"service='$service' and visit_id='$vis' ");		
						}
						if($s_patient==$pat && ($s_status==0 || $mood==4 )){			
							if(offerOpr($mood,$pat,$offer,$offer_serv,$service,$vis,$s_id,$doctor)){
								echo 1;
							}
						}
					}
				}
			}
		}
		if($type==3){			
			$srvs=implode(',',$_POST['srv']);
			$table=$srvXTables[$mood];
			if($srvs){
				$sql="select * from $table where visit_id='$vis' and service IN($srvs) and status=0 and offer=0";				
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					while($r=mysql_f($res)){
						$doctor=0;
						$s_id=$r['id'];						
						$service=$r['service'];
						$s_patient=$r['patient'];
						if($mood!=2){
							$doctor=$r['doc'];
						}
						if($s_patient==$pat){			
							if(offerOpr($mood,$pat,$offer,0,$service,$vis,$s_id,$doctor)){
								echo 1;
							}
						}
					}
				}
			}
		}
		if($type==4){	   
			if(getTotalCO('gnr_x_offers_patient',"patient='$pat' and  offer='$offer'")){
				$srvs=implode(',',$_POST['srv']);
				$table=$srvXTables[$mood];
				if($srvs){
					$sql="select * from $table where visit_id='$vis' and service IN($srvs) and status=0 and offer=0";				
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows){
						while($r=mysql_f($res)){
							$s_id=$r['id'];						
							$service=$r['service'];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];						
							$doc_percent=$r['doc_percent'];
							$doctor=$r['doc'];
							$s_patient=$r['patient'];
							if($s_patient==$pat){			
								if(offerOpr($mood,$pat,$offer,0,$service,$vis,$s_id,$doctor)){
									echo 1;
								}
							}
						}
					}
				}
			}else{

			}
		}
		if($type==5){		
			$srv=pp($_POST['srv']);
			$cobon=0;
			$sett=$r['sett'];
			$o_sett_arr=explode('|',$sett);
			$o_sett_arr2=explode(',',$o_sett_arr[0]);
			if($o_sett_arr[2]){
				$cobon=pp($_POST['cobon']);
				$o_sett_arr3=explode(',',$o_sett_arr[2]);;
				$cob_s=$o_sett_arr3[0];
				$cob_e=$o_sett_arr3[1];				
				if($cobon>=$cob_s && $cobon<=$cob_e){
					$or=getRecCon('gnr_x_offers_oprations',"offer='$offer' and offer_item='$cobon' ");
					if($or['r']){
						$patient=$or['patient'];
						$date=$or['date'];
						echo 'x2^'.k_coupon_alrdy_issued.' ( '.get_p_name($patient).' ) '.k_b_date.' <ff dir="ltr">'.date('Y-m-d',$date).'</ff>';
						exit;
					}
				}else{
					echo 'x1^0'; exit;
				}
			}
			$table=$srvXTables[$mood];
			if($srv){
				$sql="select * from $table where visit_id='$vis' and service IN($srv) and status=0 and offer=0";				
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					while($r=mysql_f($res)){
						$s_id=$r['id'];						
						$service=$r['service'];
						$hos_part=$r['hos_part'];
						$doc_part=$r['doc_part'];						
						$doc_percent=$r['doc_percent'];
						$doctor=$r['doc'];
						$s_patient=$r['patient'];
						if($s_patient==$pat){			
							if(offerOpr($mood,$pat,$offer,$cobon,$service,$vis,$s_id,$doctor)){
								echo 1;
							}
						}
					}
				}
			}
		}
	}
}
?>