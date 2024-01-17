<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['comp'],$_POST['ip'],$_POST['ipi'])){
	$out=1;
	if($thisGrp=='hrwgtql5wk'){
		$id=pp($_POST['id']);
		$comp=pp($_POST['comp']);
		$ip=pp($_POST['ip']);
		$ipi=pp($_POST['ipi']);
		$r=getRec('gnr_x_insurance_rec',$id);	
		if($r['r']){			
			$ch1=getTotalCO('gnr_m_insurance_prov'," id ='$comp'");
			if($ch1){
				$insur_id=$r['insur_id'];
				$oldComany=$r['company'];
				$in_price=$r['in_price'];
                $mood=$r['mood'];
                $visit=$r['visit'];
				$in_price_includ=$r['in_price_includ'];
				if($comp!=$oldComany){
					mysql_q(" UPDATE gnr_x_insurance_rec SET company='$comp' where insur_id='$insur_id' ");
					mysql_q(" UPDATE gnr_m_insurance_rec SET provider='$comp' , company=0 where id='$insur_id' ");
                    $table=$visXTables[$mood];
                    mysql_q(" UPDATE $table SET pay_type_link='$comp' where id='$visit' and pay_type=3 ");
				}
				if($in_price!=$ip || $in_price_includ!= $ipi){
					if(mysql_q(" UPDATE gnr_x_insurance_rec SET in_price='$ip' , in_price_includ='$ipi' where id='$id' ")){
						$mood=$r['mood'];
						$in_res=$r['in_res'];
						$service_x=$r['service_x'];
						fixInsureServic($id,$ip,$ipi,$service_x,$mood,$in_res,$comp,1);
					}
				}
			}
			echo $out;
		}else{echo 0;}
	}else{echo 0;}
}?>