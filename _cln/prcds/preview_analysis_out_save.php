<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	$p=pp($_POST['p']);
	$c=pp($_POST['c']);
	$v_id=get_val('xry_x_pro_radiography','v_id',$id);
	$pp=getTotalCO('gnr_m_patients'," id='$p'");
	$cc=getTotalCO('gnr_m_clinics'," id='$c'");
	if($pp&&$cc){
		$sql="select * from cln_x_pro_analy_items where ana_id='$id' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			/****************************/
			$sql33="INSERT INTO cln_x_visits(`patient`,`clinic`,`d_start`,`reg_user`,`fast`,`visit_link`,`doc_ord`)values('$p','$c','$now','0','0','$v_id','$thisUser')";
			if(mysql_q($sql33)){			
				$vis_id=last_id();
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$mad_id=$r['mad_id'];
					$photo=$r['photo'];
					$note=$r['note'];
					$status=$r['status'];
					$s_link=get_val('cln_m_pro_analysis','s_link',$mad_id);
					if($s_link){
						$sql2="select * from cln_m_services where id='$s_link' ";
						$res2=mysql_q($sql2);
						$rows2=mysql_n($res2);
						if($rows2){
							$r2=mysql_f($res2);
							$hos_part=$r2['hos_part'];
							$doc_part=$r2['doc_part'];
							$doc_percent=$r2['doc_percent'];
							$rev=$r['rev'];			
							$total_pay=$hos_part+$doc_part;
							$ch_p=ch_prv($s_link,$p,$thisUser);
							if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}
							$pay_net=$hos_part+$doc_part;					
							if(isset($_POST['srv_'.$s_id])){
								mysql_q("INSERT INTO cln_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`,`patient`)	
								values ('$vis_id','$c','$s_link','$hos_part','$doc_part','$doc_percent','$pay_net','$ch_p','$now','$total_pay','$p')");					
							}
						}
					}
				}
			}
			echo 1;
		}
	}	
}