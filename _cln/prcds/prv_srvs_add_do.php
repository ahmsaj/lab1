<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$srv=$_POST['ser'];
	foreach($srv as $k => $v){$srv[$k]=pp($v);}
	$srvs=implode(',',$srv);	
	$mood=1;
	list($c,$p,$pay_type,$s,$doc)=get_val_con('cln_x_visits','clinic,patient,pay_type,status,doctor'," doctor='$thisUser' and id='$id' ");
	$m_clinic=getMClinic($c);
	if($p && $srvs){
		mysql_q("DELETE from cln_x_visits_services where visit_id='$id' and status=3");
		$sql="select * from cln_m_services where clinic in($m_clinic) and act=1 and id IN($srvs) and
		(id NOT IN(select service from cln_x_visits_services where visit_id='$id') OR multi=1)";
		$res=mysql_q($sql);
		echo $rows=mysql_n($res);
		$srvCounter=0;
		if($rows>0){
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$name=$r['name_'.$lg];
				$clinic=$r['clinic'];
				$patient=$r['patient'];
				$hos_part=$r['hos_part'];
				$doc_part=$r['doc_part'];
				$price=$hos_part+$doc_part;
				$doc_percent=$r['doc_percent'];
				$rev=$r['rev'];				
				$multi=$r['multi'];
				$edit_price=$r['edit_price'];
				
				
				if($prv_Type==2 && $rev){$pay_net=0;}
				$emplo=get_val('gnr_m_patients','emplo',$p);
				//if(isset($_POST['ser_'.$s_id])){
					$m=1;
					if($edit_price){
						$hos_part=$doc_part=$total_pay=$pay_net=0;
					}else{						
						if($price && $doc){	
							$newPrice=get_docServPrice($doc,$s_id,1);
							//$newP=$newPrice[0]+$newPrice[1];							
							//if($newP){$price=$newP;}
							$hos_part=$newPrice[0];
							$doc_part=$newPrice[1];
						}
					}
					$total_pay=$hos_part+$doc_part;
					$pay_net=$hos_part+$doc_part;
					if($emplo && $pay_net){
						if(_set_osced6538u){
							$hos_part=$hos_part-($hos_part/100*_set_osced6538u);
							$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
							$doc_part=$doc_part-($doc_part/100*_set_osced6538u);
							$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
							$pay_net=$hos_part+$doc_part;
						}
					}
					
					if($multi){$m=pp($_POST['m_'.$s_id]);}
					if($m<=10){
						for($s=0;$s<$m;$s++){
							$srvCounter++;
							$sql="INSERT INTO cln_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net` ,`status`,`d_start`,`total_pay`, `patient`,doc)	values ('$id','$m_clinic','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','2','$now','$total_pay','$p','$thisUser')";
							mysql_q($sql);
                            if(_set_ruqswqrrpl==0){                                
                                payAlertBe($id,$mood);
                            }
							$srv=last_id();						
						}
					}
				//}
			}
			if(_set_ruqswqrrpl==0){payAlertBe($id,1);}
			if($pay_type==3 && $srvCounter>0){addTempOpr($p,3,1,$c,$id);}
		}
	}
}?>