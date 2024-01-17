<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['o'],$_POST['id'])){	
	$s=1;
	$data='';
	$o=pp($_POST['o']);
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$r=getRec('lab_x_visits_services',$id);
	if($r['r']){		
		$srv_status=$r['status'];
		$pat=$r['patient'];
		$sample_link=$r['sample_link'];
		$service=$r['service'];
		$visStatus=get_val('lab_x_visits','status',$vis);
		if($visStatus==1){
			if($o==1){
				if($srv_status==5){
					if(mysql_q("UPDATE lab_x_visits_services SET sample_link='0' , status=0 where id='$id' and visit_id='$vis'")){
						$services=get_vals('lab_x_visits_services','id',"sample_link='$sample_link'");
						mysql_q("UPDATE lab_x_visits_samlpes SET services='$services' , full_tube=0 where id='$sample_link' and visit_id='$vis'");
					}
				}else{
					$s=0;
					$data=k_ser_cannot_sep;
				}
			}
			if($o==2){
				if($srv_status==0){
					$tube=pp($_POST['sam']);					list($full_tube,$fast)=get_val('lab_m_services','full_tube,fast',$service);
					$services=get_val_con('lab_x_visits_samlpes','services',"id='$tube' and visit_id='$vis'");
					
					if($full_tube && $services!=''){
						$s=0;
						$data=k_ana_needs_tube;
					}else{
						$n_services=$id;
						if($services){$n_services=$services.','.$id;}
						$q='';		
						if($fast){$q=" , fast= 1 ";}
						if($full_tube){$q.=" , full_tube= 1 ";}
						if(
						mysql_q("UPDATE lab_x_visits_samlpes set services='$n_services' $q where id='$tube'")
						){
							mysql_q("UPDATE lab_x_visits_services set sample_link='$tube' ,status=5  where id='$id' and status=0");;
						}
					}
					
				}else{
					$s=0;
					$data=k_sample_cannot_linked;
				}
			}
			if($o==3){
				if($srv_status==5){
					$tube=pp($_POST['sam']);					list($full_tube,$fast)=get_val('lab_m_services','full_tube,fast',$service);
					$services=get_val_con('lab_x_visits_samlpes','services',"id='$tube' and visit_id='$vis'");					
					if($full_tube && $services!=''){
						$s=0;
						$data=k_ana_needs_tube;
					}else{
						$n_services=$id;
						if($services){$n_services=$services.','.$id;}
						$q='';		
						if($fast){$q=" , fast= 1 ";}
						if(
						mysql_q("UPDATE lab_x_visits_samlpes set services='$n_services' $q where id='$tube'")
						){
							mysql_q("UPDATE lab_x_visits_services set sample_link='$tube'  where id='$id'");
							$services=get_vals('lab_x_visits_services','id',"sample_link='$sample_link'");
							mysql_q("UPDATE lab_x_visits_samlpes SET services='$services' where id='$sample_link' and visit_id='$vis'");
						}
					}
					
				}else{
					$s=0;
					$data=k_sample_cannot_linked
;
				}
			}
			if($o==4){
				if($srv_status==2){
					mysql_q("DELETE from  lab_x_visits_services where id='$id' ");
				}else if($srv_status==0){
					$n_status=4;
					if(_set_ruqswqrrpl){$n_status=3;}
					mysql_q("UPDATE lab_x_visits_services set status='$n_status' where id='$id'");
				}else{
					$s=0;
					$data=k_ser_cannot_del;
				}
			}
			if($o==5){
				if($srv_status==3 || $srv_status==4){					
					mysql_q("UPDATE lab_x_visits_services set status='0' where id='$id'");
				}else{
					$s=0;
					$data=k_ser_cannot_ret;
				}
			}
		}
	}
	echo $s.'^'.$data;
}?>