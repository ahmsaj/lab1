<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p'] , $_POST['c'])){
	$p=pp($_POST['p']);
	$c=pp($_POST['c']);
	$doc=pp($_POST['d']);
	$vis=pp($_POST['vis']);
	$type=pp($_POST['t']);
	$vis_id=$vis;
	$fast=0;if(isset($_POST['fast'])){$fast=1;}
	$pp=getTotalCO('gnr_m_patients'," id='$p'");
	$emplo=get_val('gnr_m_patients','emplo',$p);
	$cc=getTotalCO('gnr_m_clinics'," id='$c'");
	$m_clinic=getMClinic($c);
	if($doc){		
		$doc_clin=get_val('_users','subgrp',$doc);
		$docArr=explode(',',$doc_clin);		
		if(!in_array($c,$docArr)){exit;}
	}
	if($pp&&$cc){
		if($type==1){
			/****************************/
			if($vis_id==0){
				$doc_ord=0;
				/*$insert=1;
				if(isset($_POST['xry_req'])){
					$doc_ord=pp($_POST['xry_req']);
					if(get_val('xry_x_visits_requested','status',$doc_ord)!=1){
						$insert=0;
					}
				}
				if($insert){*/
					$new_pat=isNewPat($p,$doc,$type);
					$sql="INSERT INTO cln_x_visits(`patient`,`clinic`,`d_start`,`reg_user`,`fast`,`emplo`,`doctor`,`new_pat`)values ('$p','$c','$now','$thisUser','$fast','$emplo','$doc','$new_pat')";
					if(mysql_q($sql)){			
						$vis_id=last_id();
					}
				//}
			}else{
				delOfferVis($type,$vis_id);
				mysql_q("DELETE from cln_x_visits_services where `visit_id`='$vis_id' ");				
			}
			/****************************/
			if($vis_id){ 
				$sql="select * from cln_m_services where clinic='$m_clinic' and act=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					echo $vis_id;
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						if(isset($_POST['ser_'.$s_id])){
							$name=$r['name_'.$lg];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];
							$edit_price=$r['edit_price'];
							$opr_type=$r['opr_type'];
							
							if($edit_price){$hos_part=$doc_part=0;}
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
									$doc_percent=$newPrice[2];
									$hos_part=$newPrice[0];
									$doc_part=$newPrice[1];
									$pay_net=$newP;$total_pay=$newP;
								}
							}
							
							if($emplo && $pay_net){
								if(_set_osced6538u){
									$hos_part=$hos_part-($hos_part/100*_set_osced6538u);
									$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
									$doc_part=$doc_part-($doc_part/100*_set_osced6538u);
									$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
									$pay_net=$hos_part+$doc_part;
								}
							}
							
							/*$insert2=1;							
							if($doc_ord){
								if(get_val_con('xry_x_visits_requested','status'," r_id='$doc_ord' and xphoto='$s_id' and action=2 ")!=0){
									$insert2=0;
								}
							}						
							if($insert2){*/
								$m=1;
								if($multi){$m=pp($_POST['m_'.$s_id]);}
								for($s=0;$s<$m;$s++){							
									mysql_q("INSERT INTO cln_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`, `patient`,`doc`,`srv_type`)	values ('$vis_id','$m_clinic','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','$ch_p','$now','$total_pay','$p','$doc','$opr_type')");
									$srv_x_id=last_id();									
									if($doc_ord){
										mysql_q("UPDATE xry_x_visits_requested_items set status=1 , service_id='$srv_x_id'  where r_id='$doc_ord' and action=1 and status=0 and xphoto='$s_id' ");
									}
									mysql_q("UPDATE gnr_x_roles set status=2  where vis='$vis_id' and mood=3 and  status=4");
									//endLabVist($vis_id);
								}
							//}
						}
					}
					if($doc_ord){
						mysql_q("UPDATE xry_x_visits_requested set status=2 where id='$doc_ord' and status in(1,2) ");
					}
				}else{echo '0';}
			}
		}
		if($type==2){
			/****************************/
			if($vis_id==0){
				$doc_ord=0;
				$insert=1;
				if(isset($_POST['lab_req'])){
					$doc_ord=pp($_POST['lab_req']);
					if(get_val('lab_x_visits_requested','status',$doc_ord)!=1){
						$insert=0;
					}
				}
				if($insert){
					$new_pat=isNewPat($p,'',$type);
					$code=getRandString(32,3);
					$sql="INSERT INTO lab_x_visits(`patient`,`d_start`,`reg_user`,`doc_ord`,`emplo`,`new_pat`,`code`)values ('$p','$now','$thisUser','$doc_ord','$emplo','$new_pat','$code')";
					if(mysql_q($sql)){$vis_id=last_id();}
				}
			}
			/****************************/
			if($vis_id){ echo $vis_id;
				$status=0;
				if($vis && _set_ruqswqrrpl==0){$status=2;}
				$isFast=0;
				$sql="select * from lab_m_services where act=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$name=$r['name_'.$lg];
						$unit=$r['unit'];
						$s_type=$r['type'];
						$s_cat=$r['cat'];					
						$unit_price=_set_x6kmh3k9mh;
						$cus_unit_price=$r['cus_unit_price'];
						if($cus_unit_price){$unit_price=$cus_unit_price;}
						if($emplo){
							if(_set_fk9p1pamop){
								$unit_price=$unit_price-($unit_price/100*_set_fk9p1pamop);
								$unit_price=round($unit_price,-1,PHP_ROUND_HALF_DOWN);
							}
						}
						$pay_net=$unit_price*$unit;
						$total_pay=$unit_price*$unit;
						if(isset($_POST['s_'.$s_id])){
							$sample=pp($_POST['s_'.$s_id]);						
							$fast=0;
							if(isset($_POST['f_'.$s_id])){$fast=1;$isFast=1;}							
							$insert2=1;							
							if($doc_ord){
								if(get_val_con('lab_x_visits_requested','status'," r_id='$doc_ord' and ana='$s_id' and action=2 ")!=0){
									$insert2=0;
								}
							}						
							if($insert2){
								$code=getRandString(32,3);
								$visDate=get_val('lab_x_visits','d_start',$vis_id);
								if(mysql_q("INSERT INTO lab_x_visits_services (`visit_id`,`service`,`units`,`units_price`,`pay_net`,`sample`,`fast`,`status`,`type`,`srv_cat`,`patient`,`total_pay`,`code`,`d_start`)						values('$vis_id','$s_id','$unit','$unit_price','$pay_net','$sample','$fast','$status','$s_type','$s_cat','$p','$total_pay','$code','$visDate')")){
									$srv_x_id=last_id();									
									if($doc_ord){
										mysql_q("UPDATE lab_x_visits_requested_items set status=1 , service_id='$srv_x_id'  where r_id='$doc_ord' and action=1 and status=0 and ana='$s_id' ");
									}
									mysql_q("UPDATE gnr_x_roles set status=2  where vis='$vis_id' and mood=2 and  status=4");
									endLabVist($vis_id);
								}
							}
						}
					}
					if($doc_ord){
						mysql_q("UPDATE lab_x_visits_requested set status=2 , lab_vis ='$vis_id' where id='$doc_ord' and status in(1,2) ");
					}
				}else{echo '0';}
				if($isFast){mysql_q("UPDATE lab_x_visits set fast=1 where id='$vis_id' ");}
			}else{echo '0';}		
		}		
		if($type==3){
			/****************************/
			if($vis_id==0){
				$doc_ord=0;
				$insert=1;
				if(isset($_POST['xry_req'])){
					$doc_ord=pp($_POST['xry_req']);
					if(get_val('xry_x_visits_requested','status',$doc_ord)!=1){
						$insert=0;
					}
				}
				if($insert){					
					$new_pat=isNewPat($p,$doc,$type);
					$sql="INSERT INTO xry_x_visits(`patient`,`clinic`,`d_start`,`reg_user`,`fast`,`emplo`,`ray_tec`,`doc_ord`,`new_pat`)values ('$p','$c','$now','$thisUser','$fast','$emplo','$doc','$doc_ord','$new_pat')";
					if(mysql_q($sql)){			
						$vis_id=last_id();
					}
				}
			}else{
				delOfferVis($type,$vis_id);
				mysql_q("DELETE from xry_x_visits_services where `visit_id`='$vis_id' ");
			}
			/****************************/
			if($vis_id){ echo $vis_id;
				$sql="select * from xry_m_services where clinic='$c' and act=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						if(isset($_POST['ser_'.$s_id])){
							$name=$r['name_'.$lg];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];
							$edit_price=$r['edit_price'];
							$opr_type=$r['opr_type'];
							
							if($edit_price){$hos_part=$doc_part=0;}
							$total_pay=$hos_part+$doc_part;
							$doc_percent=$r['doc_percent'];
							$multi=$r['multi'];
							$rev=$r['rev'];					
							$ch_p=ch_prv($s_id,$p,$doc);
							if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}
							$pay_net=$hos_part+$doc_part;							
							 
							if($pay_net && $doc){								
								$newPrice=get_docServPrice($doc,$s_id,$type);
								$newP=$newPrice[0]+$newPrice[1];
								if($newP){
									$doc_percent=$newPrice[2];
									$hos_part=$newPrice[0];
									$doc_part=$newPrice[1];
									$pay_net=$newP;$total_pay=$newP;
								}
							}
							if($emplo && $pay_net){
								if(_set_z4084ro8wc){
									$hos_part=$hos_part-($hos_part/100*_set_z4084ro8wc);
									$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
									$doc_part=$doc_part-($doc_part/100*_set_z4084ro8wc);
									$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
									$pay_net=$hos_part+$doc_part;
								}
							}
							
							$insert2=1;							
							if($doc_ord){
								if(get_val_con('xry_x_visits_requested','status'," r_id='$doc_ord' and xphoto='$s_id' and action=2 ")!=0){
									$insert2=0;
								}
							}						
							if($insert2){
								$m=1;
								if($multi){$m=pp($_POST['m_'.$s_id]);}								
								for($s=0;$s<$m;$s++){							
									mysql_q("INSERT INTO xry_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`, `patient`,`doc`,`srv_type`)	values ('$vis_id','$c','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','$ch_p','$now','$total_pay','$p',0,'$opr_type')");
									$srv_x_id=last_id();									
									if($doc_ord){
										mysql_q("UPDATE xry_x_visits_requested_items set status=1 , service_id='$srv_x_id'  where r_id='$doc_ord' and action=1 and status=0 and xphoto='$s_id' ");
									}
									mysql_q("UPDATE gnr_x_roles set status=2 where vis='$vis_id' and mood=3 and  status=4");
									//endLabVist($vis_id);
								}
							}
						}
					}
					if($doc_ord){
						mysql_q("UPDATE xry_x_visits_requested set status=2 where id='$doc_ord' and status in(1,2) ");
					}
				}else{echo '0';}
			}
		}
		if($type==5){
			/****************************/
			if($vis_id==0){
				$new_pat=isNewPat($p,$doc,$type);
				$sql="INSERT INTO bty_x_visits(`patient`,`clinic`,`d_start`,`reg_user`,`emplo`,`doctor`,`new_pat`)values ('$p','$c','$now','$thisUser','$emplo','$doc','$new_pat')";
				if(mysql_q($sql)){$vis_id=last_id();}
			}else{
				delOfferVis($type,$vis_id);
				mysql_q("DELETE from bty_x_visits_services where `visit_id`='$vis_id' ");
			}
			if($vis_id){echo $vis_id;
				/****************************/
				$sql="select * from bty_m_services where cat IN(select id from bty_m_services_cat where clinic='$m_clinic') and act=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						if(isset($_POST['ser_'.$s_id])){
							$name=$r['name_'.$lg];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];
							$total_pay=$hos_part+$doc_part;
							$doc_percent=$r['doc_percent'];						
							$pay_net=$hos_part+$doc_part;
							if($pay_net && $doc){								
								$newPrice=get_docServPrice($doc,$s_id,$type);
								$newP=$newPrice[0]+$newPrice[1];
								if($newP){
									$doc_percent=$newPrice[2];
									$hos_part=$newPrice[0];
									$doc_part=$newPrice[1];
									$pay_net=$newP;$total_pay=$newP;
								}
							}
							if($emplo && $pay_net){
								if(_set_jqqjli38k7){
									$hos_part=$hos_part-($hos_part/100*_set_jqqjli38k7);
									$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
									$doc_part=$doc_part-($doc_part/100*_set_jqqjli38k7);
									$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
									$pay_net=$hos_part+$doc_part;
								}
							}
							$sql="INSERT INTO bty_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`,`d_start`,`total_pay`, `patient`,`doc`)values ('$vis_id','$m_clinic','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','$now','$total_pay','$p','$doc')";
							mysql_q($sql);

						}
					}
				}else{echo '0';}
			}
			
		}
		if($type==6){
			/****************************/
			if($vis_id==0){
				$new_pat=isNewPat($p,$doc,$type);
				$sql="INSERT INTO bty_x_laser_visits(`patient`,`clinic`,`d_start`,`reg_user`,`emplo`,`doctor`,`new_pat`)values ('$p','$c','$now','$thisUser','$emplo','$doc','$new_pat')";
				if(mysql_q($sql)){$vis_id=last_id();}
			}else{
				delOfferVis($type,$vis_id);
				mysql_q("DELETE from bty_x_laser_visits_services where `visit_id`='$vis_id' ");
			}
			/****************************/
			if($vis_id){echo $vis_id;
				$sql="select * from bty_m_services where cat IN(select id from bty_m_services_cat where clinic='$m_clinic') and act=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						if(isset($_POST['ser_'.$s_id])){
							$name=$r['name_'.$lg];						
							$sql="INSERT INTO bty_x_laser_visits_services (`visit_id`, `clinic`, `service`,`d_start`, `patient`,`doc`)values ('$vis_id','$c','$s_id','$now','$p','$doc')";
							mysql_q($sql);

						}
					}
				}else{echo '0';}
			}		
		}
		if($type==7){
			/****************************/
			$oscSrv=pp($_POST['oscSrv']);
            $fee=0;
			if($vis_id==0){
				$new_pat=isNewPat($p,$doc,$type);
				$sql="INSERT INTO osc_x_visits(`patient`,`clinic`,`d_start`,`reg_user`,`fast`,`emplo`,`doctor`,`doc_ord`,`new_pat`)values ('$p','$c','$now','$thisUser','$fast','$emplo','$doc','$doc_ord','$new_pat')";
				if(mysql_q($sql)){			
					$vis_id=last_id();
				}
				
			}else{
				delOfferVis($type,$vis_id);
				mysql_q("DELETE from osc_x_visits_services where `visit_id`='$vis_id' ");
			}
			/****************************/
			if($vis_id){ echo $vis_id;
				$sql="select * from osc_m_services where clinic='$c' and act=1 and id='$oscSrv'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					$r=mysql_f($res);
                    $s_id=$oscSrv;						
                    $name=$r['name_'.$lg];
                    $hos_part=$r['hos_part'];
                    $doc_part=$r['doc_part'];
                    $edit_price=$r['edit_price'];
                    $opr_type=$r['opr_type'];

                    if($edit_price){$hos_part=$doc_part=0;}
                    $total_pay=$hos_part+$doc_part;
                    $doc_percent=$r['doc_percent'];
                    $multi=$r['multi'];
                    $rev=$r['rev'];					
                    $ch_p=ch_prv($s_id,$p,$doc);
                    if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}
                    $pay_net=$hos_part+$doc_part;
                    if($pay_net && $doc){								
                        $newPrice=get_docServPrice($doc,$s_id,7);
                        $newP=$newPrice[0]+$newPrice[1];
                        if($newP){
                            $doc_percent=$newPrice[2];
                            $hos_part=$newPrice[0];
                            $doc_part=$newPrice[1];
                            $pay_net=$newP;$total_pay=$newP;
                        }
                    }

                    if($emplo && $pay_net){
                        if(_set_z4084ro8wc){
                            $hos_part=$hos_part-($hos_part/100*_set_z4084ro8wc);
                            $hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
                            $doc_part=$doc_part-($doc_part/100*_set_z4084ro8wc);
                            $doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
                            $pay_net=$hos_part+$doc_part;
                        }
                    }
                    if(_set_qejqlfmies){                        
                        $fee=pp($_POST['fee']);
                    }
                    mysql_q("INSERT INTO osc_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`, `patient`,`doc`,`srv_type`,`doc_fees`)	values ('$vis_id','$c','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','$ch_p','$now','$total_pay','$p','$doc','$opr_type','$fee')");
                    $srv_x_id=last_id();
                    mysql_q("UPDATE gnr_x_roles set status=2  where vis='$vis_id' and mood=7 and  status=4");
                        //endLabVist($vis_id);
									
				}else{echo '0';}
			}
		}
		if($vis_id){addTempOpr($p,4,$type,$c,$vis_id);}
	}else{echo '0';}
}?>