<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['mood'],$_POST['offer'],$_POST['srv'],$_POST['cubon'])){
	$vis=pp($_POST['vis']);
	$mood=pp($_POST['mood']);
	$offer=pp($_POST['offer']);
	$srv=pp($_POST['srv']);
	$cubon=pp($_POST['cubon']);
	$r=getRec($visXTables[$mood],$vis);	
	if($r['r']){
		$pat=$r['patient'];
		$doctor=$r['doctor'];
		$date_off_end=$now-86400;
		$sql="SELECT * from gnr_m_offers where type=5 and act= 1 and date_s < $now and date_e > $date_off_end and FIND_IN_SET('$mood',`clinics`)> 0 and id='$offer' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$r=mysql_f($res);
			$o_id=$r['id'];			
			$sett=$r['sett'];
			$o_sett_arr=explode('|',$sett);
			$o_sett_arr2=explode(',',$o_sett_arr[0]);
			if($o_sett_arr[2]){				
				$o_sett_arr3=explode(',',$o_sett_arr[2]);;
				$cub_s=$o_sett_arr3[0];
				$cub_e=$o_sett_arr3[1];				
				if($cubon>=$cub_s && $cubon<=$cub_e){
					$or=getRecCon('gnr_x_offers_oprations',"offer='$offer' and offer_item='$cubon' ");
					if($or['r']){
						$patient=$or['patient'];
						$date=$or['date'];
						echo 'x2^'.k_coupon_alrdy_issued.' ( '.get_p_name($patient).' ) '.k_b_date.' <ff dir="ltr">'.date('Y-m-d',$date).'</ff>';
						exit;
					}
				}else{
					echo 'x1^0'; exit;
				}			
				$table=$srvXTables[$mood];
				$sql="select * from $table where visit_id='$vis' and status=0 and pay_net>0 and id='$srv'" ;
				$res=mysql_q($sql);
				$rows=mysql_n($res);			
				if($rows){
					$r2=mysql_f($res);				
					$service=$r2['service'];
					$sOf=$r2['offer'];
					if($sOf){delOfferSrv($mood,$vis,$srv);}
					if(offerOpr($mood,$pat,$offer,$cubon,$service,$vis,$srv,$doctor)){
						echo 1;
					}
				}
			}
		}	
	}
}?>