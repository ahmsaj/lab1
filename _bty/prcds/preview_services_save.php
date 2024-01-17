<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$x=getTotalCO('bty_x_visits'," doctor='$thisUser' and id='$id'");	
    list($c,$p,$pay_type,$s)=get_val('bty_x_visits','clinic,patient,pay_type,status',$id);
    $c=getMClinic($c);
    $emplo=get_val('gnr_m_patients','emplo',$p);
	if($x){
		mysql_q("DELETE from bty_x_visits_services where visit_id='$id' and status=3");
		$sql="select * from bty_m_services where cat IN(select id from bty_m_services_cat where  clinic='$c') and act=1 and id NOT IN(select service from bty_x_visits_services where visit_id='$id')";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$name=$r['name_'.$lg];
				$hos_part=$r['hos_part'];
				$doc_part=$r['doc_part'];
				$doc_percent=$r['doc_percent'];
				$pay_net=$hos_part+$doc_part;
				$total_pay=$hos_part+$doc_part;
				if($prv_Type==2 && $rev){$pay_net=0;}					
				if(isset($_POST['ser_'.$s_id])){
                    if($emplo && $pay_net){
                        if(_set_jqqjli38k7){
                            $hos_part=$hos_part-($hos_part/100*_set_jqqjli38k7);
                            $hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
                            $doc_part=$doc_part-($doc_part/100*_set_jqqjli38k7);
                            $doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
                            $pay_net=$hos_part+$doc_part;
                        }
                    }					
                    $srvCounter++;
					mysql_q("INSERT INTO bty_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net` ,`status`,`d_start`,`total_pay`, `patient`,doc)	values ('$id','$c','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','2','$now','$total_pay','$p','$thisUser')");
				}
			}
            if($pay_type==3 && $srvCounter>0){addTempOpr($p,3,1,$c,$id);}
            if(_set_ruqswqrrpl==0){payAlertBe($id,5);}
		}
	}
}?>