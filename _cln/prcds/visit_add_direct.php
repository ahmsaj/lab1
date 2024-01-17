<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p'] , $_POST['c'] , $_POST['d'])){
	$p=pp($_POST['p']);
	$c=pp($_POST['c']);
	$doc=pp($_POST['d']);
	if($doc){
		$doc_clin=get_val('_users','subgrp',$doc);
		if($doc_clin!=$c){exit;}
	}
	$pp=getTotalCO('gnr_m_patients'," id='$p'");
	$cc=getTotalCO('gnr_m_clinics'," id='$c'");
	if($pp&&$cc){
		$emplo=get_val('gnr_m_patients','emplo',$p);
		$sql="INSERT INTO cln_x_visits(`patient`,`clinic`,`d_start`,`reg_user`,`doctor`) values ('$p','$c','$now','$thisUser','$doc')";
			if(mysql_q($sql)){
			echo $vis_id=last_id();
			/****************************/
			$sql="select * from cln_m_services where clinic='$c' and act=1 and def=1 ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$name=$r['name_'.$lg];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$total_pay=$hos_part+$doc_part;
					$doc_percent=$r['doc_percent'];
					$multi=$r['multi'];
					$rev=$r['rev'];					
					
					$ch_p=ch_prv($s_id,$p,$doc);
					if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}					
					$pay_net=$hos_part+$doc_part;
					
					if($pay_net && $doc){						
						$newPrice=get_docServPrice($doc,$s_id,1);
						$newP=$newPrice[0]+$newPrice[1];							
						if($newP){
							$hos_part=$newPrice[0];
							$doc_part=$newPrice[1];
							$pay_net=$newP;	$total_pay=$newP;
						}
					}
					
					if($emplo && $pay_net){
						if(_set_osced6538u){
							$pay_net=$pay_net-($pay_net/100*_set_osced6538u);
							$pay_net=round($pay_net,-1,PHP_ROUND_HALF_DOWN);
						}
					}
					
					mysql_q("INSERT INTO cln_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`, `patient`,`doc`)	values ('$vis_id','$c','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','$ch_p','$now','$total_pay','$p','$doc')");
				}
			}else{echo 'x';}
		}				
	}else{echo 'x';}	
}?>