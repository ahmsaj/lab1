<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['opr'],$_POST['vis'],$_POST['srv'],$_POST['add'])){
	$opr=pp($_POST['opr']);
	$vis=pp($_POST['vis']);
	$srv=pp($_POST['srv']);
	$add=pp($_POST['add'],'s');
	$out=1;
	$action='';
	list($vis,$pay_type)=get_val_con("cln_x_visits",'id,pay_type'," id='$vis' and doctor='$thisUser' and status=1");
	if($vis){
		if(in_array($opr,array(1,11,2,3))){
			$r=getRec("cln_x_visits_services",$vis);			
			list($srv,$srv_status,$offer,$pay_type,$pay_net,$service)=get_val_con('cln_x_visits_services','id,status,offer,pay_type,pay_net,service'," id='$srv' and visit_id='$vis' ");			
			if(!$srv){$out=0;}
		}
		if($out){
			if($opr==1){//Done ----- check Store				
				if($userStore){
					$data=getServItem($srv);
					if($data){
						$action="newCons(".$userStore.",'".$data."','endSrvDo(11,".$srv.",'[data]')',' ( ".get_val('cln_m_services','name_'.$lg,$srv)." )')";
					}else{
						$opr=11;
					}
				}else{
					$opr=11;
				}				
			}
			if($opr==11){//Done				
				if(in_array($srv_status,array(0,2))){
					$new_status=1;					
					if($srv_status==2){
						if(_set_ruqswqrrpl==1){
							$new_status=5;
						}else{
							out();exit;
						}
					}
					if(mysql_q("UPDATE cln_x_visits_services set status='$new_status' where id='$srv'")){
						if($new_status==5){servPayAler($srv,1);}			
						actItemeConsCln($vis,$srv,$add);
					}
				}
			}
			if($opr==2){//Cancel
                $ActiveSrvs=getTotalCo('cln_x_visits_services',"visit_id='$vis' and status IN(0,1,2)");
                if($ActiveSrvs>1){
                    if($pay_type==3){
                        $res_status=get_val_con('gnr_x_insurance_rec','res_status',"service_x='$srv' and mood=1 ");
                        if($res_status!='' || $res_status==2){$insurStopCancel=1;}
                    }					
                    if($srv_status==2){
                        if($insurStopCancel==0){
                            mysql_q("DELETE from cln_x_visits_services where status='2' and id='$srv'");
                            if($offer){
                                mysql_q("DELETE from gnr_x_offers_oprations where visit_srv='$srv' and mood=1 ");
                            }
                        }
                    }else if($srv_status==0){
                        mysql_q("UPDATE cln_x_visits_services set status='4' where id='$srv'");
                    }
                }else{
                    $out=0;
                    $action="nav(3,'".k_not_possible_del." ')";
                }
			}			
			if($opr==3){//reset	
				$newStatus=0;
				if($srv_status==5){
					$newStatus=2;
                    if(getTotalCo('cln_x_visits_services',"status=5 and visit_id='$vis' ")==1){
                        mysql_q("delete from gnr_x_visits_services_alert where mood=1 and visit_id='$vis' and status=0");
                    }
				}
				if($srv_status==1 || $srv_status==4 || $srv_status==5){
					mysql_q("UPDATE cln_x_visits_services set status='$newStatus' where id='$srv'");
				}				
			}
			if($opr==4){//Done All
				$sql="select * from cln_x_visits_services where visit_id ='$vis'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					while($r=mysql_f($res)){
						$ok=1;
						$srv=$r['id'];
						$srv_status=$r['status'];
						$offer=$r['offer'];
						$insur=$r['pay_type'];
						$pay_net=$r['pay_net'];
						$total_pay=$r['total_pay'];
						$service=$r['service'];
						$new_status=1;
						if($userStore){
							$data=getServItem($srv);
							if($data){$ok=0;}
						}
						if(!in_array($srv_status,array(1,5))){
							if($ok==1){
								if(in_array($srv_status,array(0,2))){
									if($srv_status==2){
										if(_set_ruqswqrrpl==1){
											$new_status=5;
										}else{
											$ok=0;
										}
									}
								}
							}
							if($ok==1 && $total_pay==0){
								if(get_val($srvTables[1],'edit_price',$service)){$ok=0;}
							}
							if($ok==1){
								if(mysql_q("UPDATE cln_x_visits_services set status='$new_status' where id='$srv'")){
									if($new_status==5){servPayAler($srv,1);}			
									actItemeConsCln($vis,$srv,$add);
								}
							}
						}
					}
				}
			}
		}
	}
	if(_set_ruqswqrrpl==0){payAlertBe($vis,1);}
	echo $out.'^'.$action;
}?>