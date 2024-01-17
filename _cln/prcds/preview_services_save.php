<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$x=getTotalCO('cln_x_visits'," doctor='$thisUser' and id='$id'");
	list($c,$p,$pay_type,$s)=get_val('cln_x_visits','clinic,patient,pay_type,status',$id);
	$m_clinic=getMClinic($c);
	if($x){
		mysql_q("DELETE from cln_x_visits_services where visit_id='$id' and status=3");
		$sql="select * from cln_m_services where clinic='$m_clinic' and act=1 and 
		(id NOT IN(select service from cln_x_visits_services where visit_id='$id') OR multi=1)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$srvCounter=0;
		if($rows>0){
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$name=$r['name_'.$lg];
				$clinic=$r['clinic'];
				$patient=$r['patient'];
				$hos_part=$r['hos_part'];
				$doc_part=$r['doc_part'];
				$doc_percent=$r['doc_percent'];
				$rev=$r['rev'];				
				$multi=$r['multi'];				
				$pay_net=$hos_part+$doc_part;
				$total_pay=$hos_part+$doc_part;
				if($prv_Type==2 && $rev){$pay_net=0;}
				
				$type=get_val('gnr_m_clinics','type',$m_clinic);
				$emplo=get_val('gnr_m_patients','emplo',$p);
				
				if(isset($_POST['ser_'.$s_id])){					
					if($type==1){
						if($emplo && $pay_net){
							if(_set_osced6538u){
								$hos_part=$hos_part-($hos_part/100*_set_osced6538u);
								$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
								$doc_part=$doc_part-($doc_part/100*_set_osced6538u);
								$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
								$pay_net=$hos_part+$doc_part;
							}
						}
					}
					if($type==3){
						if($emplo && $pay_net){
							if(_set_z4084ro8wc){
								$hos_part=$hos_part-($hos_part/100*_set_z4084ro8wc);
								$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
								$doc_part=$doc_part-($doc_part/100*_set_z4084ro8wc);
								$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
								$pay_net=$hos_part+$doc_part;
							}
						}
					}
					$m=1;
					if($multi){$m=pp($_POST['m_'.$s_id]);}
					for($s=0;$s<$m;$s++){
						$srvCounter++;
						$sql="INSERT INTO cln_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net` ,`status`,`d_start`,`total_pay`, `patient`,doc)	values ('$id','$m_clinic','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','2','$now','$total_pay','$p','$thisUser')";
						mysql_q($sql);
					}
				}
			}
			if($pay_type==3 && $srvCounter>0){addTempOpr($p,3,1,$c,$id);}
		}
	}
}?>