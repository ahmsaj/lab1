<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'])){
	$v=pp($_POST['t'],'s');
	$vv=explode('-',$v);
	if(count($vv)==2){
		$vis=intval($vv[1]);
		$c_type=$vv[0];
		if($thisGrp=='5j218rxbn0'){
			if($c_type==2){
				$m_table='lab_x_visits';$m_table2='lab_x_visits_services';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
				$r=mysql_f($res);
				$doctor=$r['doctor'];
				$patient=$r['patient'];
				$clinic=get_val_c('gnr_m_clinics','id',2,'type');
				$type=$r['type'];
				$d_start=$r['d_start'];
				$d_check=$r['d_check'];
				$d_finish=$r['d_finish'];
				$pay_type=$r['pay_type'];
				$v_status=$r['status'];
				$reg_user=$r['reg_user'];				
				?>				
				<div class="fl f1s fs16 lh40"><ff>#<?=$vis?> | </ff><?=get_p_name($patient)?></div>
                <div class="ic40 icc1 ic40_ref fr" title="<?=k_refresh?>" onclick="reftekLab();"></div>
				<div class="fr ff B fs20  lh40"></div>
				<div class="uLine cb"></div<?	
				$Vbal=get_visBal($vis);
				if($Vbal){
					echo '<div class="fl f1 fs16 clr5 lh40">'.k_rmning_amnt_pd.' <ff>( '.$Vbal.' )</ff></div>';
				}else{
					if($v_status==2){
						echo '<div class="fl f1 fs16 clr1 lh40">'.k_tst_dlvrd.'</div>';
					}else{
						echo '<div class="fl f1 fs16 clr6 lh40">'.k_val_tst_pd.'</div>';
					}
				}
			 	$sql="select * , x.id as xid from lab_m_services z , lab_x_visits_services x where x.service=z.id and x.visit_id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){					
					if($rows>1){						
						echo '<div class="ic40 icc2 iconPrint fr" title="'.k_custm_prnt.'" onclick="customPrint('.$vis.')"></div>';						
					}
					if(getTotalCO('lab_x_visits_services'," visit_id ='$vis' and status=8")){
						echo '<div class="ic40 icc4 iconDelv fr" onclick="lRepDlv(2,'.$vis.',0)" title="'.k_delivery_results.'"></div>';
					}
					echo '
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th>'.k_analysis.'</th><th>'.k_status.'</th><th width="100">'.k_operations.'</th></tr>';					
					$rrSrv=0;
					$pkg_ids='';
					$total=0;
					while($r=mysql_f($res)){
						$ser_id=$r['xid'];
						$ser_name=$r['short_name'];
						$status=$r['status'];
						$pay_net=$r['pay_net'];						
						$sample_type=$r['sample'];
						$total+=$pay_net;
						$a_opers='';
						$printButt='<div class="ic40 icc1 iconPrint fr" title="'.k_print.'" onclick="printLabRes(1,'.$ser_id.')"></div>';
						if($status==8){
							$a_opers=$printButt.'<div class="ic40 icc1 iconDelv fr" onclick="lRepDlv(1,'.$ser_id.','.$vis.')" title="'.k_dlivrd.'"></div>';
						}
						if($status==1){$a_opers=$printButt;}
						echo '<tr>
						<td class="ff fs16 B lh30">'.$ser_name.'</td>											
						<td><div class="f1" style="color:'.$anStatus_col[$status].'">'.$anStatus[$status].'</div></td>
						<td>'.$a_opers.'</td>
						</tr>';
					}					
					echo '</table>';
				}
			}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}else{
				echo '0^<div class="f1 fs14 clr5 lh40">'.k_tik_nspecfc_lab.'</ff></div>';
			}			
		}else{
			if($c_type==1){
				$m_table='cln_x_visits';$m_table2='cln_x_visits_services';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];
					$c_type=get_val('gnr_m_clinics','type',$clinic);
					$type=$r['type'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];
					$pay_type=$r['pay_type'];
					$v_status=$r['status'];
					$reg_user=$r['reg_user'];
					$sub_status=$r['sub_status'];

					$r_status='x';
					if(getTotalCO('gnr_x_roles'," vis='$vis' and mood='$c_type' ")>0){
						$r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$c_type'");
					}
					?>
					<div class="win_body">
					<div class="form_header">
						<div class="fl f1 fs16 lh40 Over" onclick="check_card_do(<?=$patient?>)">
						<ff><?=$patient?> | </ff><?=get_p_name($patient)?>
						</div>
						<? if($v_status==1){echo '<div class="fl pd5 f1 clr5 lh40 Over" onclick="changePatVisit('.$c_type.','.$vis.')">[ '.k_modify_patient.' ]</div>';}?>
						<div class="fr ff B fs20  lh40">#<?=$vis?></div>            
					</div>
					<div class="form_body so">
						<div class=" lh40"><?
						$photo=get_val('gnr_m_clinics','photo',$clinic);						
						$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
						echo '<div class="lh40 fl">'.$ph_src.'</div>';			
						echo '<div class="fl lh40 f1 fs18 clr1">&nbsp;'.get_val('gnr_m_clinics','name_'.$lg,$clinic);
						if($doctor){echo ' [ '.get_val('_users','name_'.$lg,$doctor).' ]';}
						echo '</div>';
						?>&nbsp;
						</div>
						<div class="uLine"></div><?			
						$d_s=0;
						$d_c=0;
						$d_e=0;
						$opr_cancel=0;
						$or_add=0;
						$opr_return=0;
						$opr_x_roles=0;
						$opr_new_roles=0;
						$opr_show_service=0;
						$opr_show_service2=0;
						$opr_pay_add=0;	
						$opr_pay_back=0;
						$opr_print=1;
						$opr_srv_cancle=0;
						$chariButt=0;
						if($v_status==3){$opr_print=0;}
						if($r_status=='x' && $v_status==1){$d_s=1;$opr_cancel=1;$opr_new_roles=1;}
						if($v_status==1){if($r_status<2){$d_s=1;$opr_cancel=1;}
							if($r_status==2){$opr_show_service=1;$d_c=1;
											 echo '<div class="f1 fs18 clr1 lh40">'.k_srv_curciving.'</div>';}
							if($r_status==3){$d_s=1;$opr_x_roles=1;$opr_cancel=1;}
						}
						if($v_status==2){$d_e=1;$opr_show_service2=1;}
						if($v_status==3){
							$opr_show_service=1;
							echo '<div class="f1 fs16 clr5">'.k_prv_cncld.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
							<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';
						}			

						if($d_s){echo '<div class="f1 fs16 ">'.k_inf_ent.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_start).' )</ff> '.k_since.'
						<ff> ( '.dateToTimeS2($now-$d_start).' )</ff></div>';}
						if($d_c){echo '<div class="f1 fs16">'.k_prv_start.' : <ff>'.dateToTimeS2($now-$d_check).'</ff></div>';}
						if($d_e){echo '<div class="f1 fs16 ">'.k_prv_cmpt.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
						<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';}
						/****************************************************************/
						$addPay=0;
						$XPay=0;
						if($opr_show_service){				
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from cln_m_services z , $m_table2 x where 
							z.id=x.service and x.visit_id='$vis' and x.status=2 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_i=mysql_n($res);
							if($rows_i>0){							
								$totalPrice=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_addtn_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$edit_price=$r['edit_price'];

									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}
									$tr_color=$ser_status_color[$s_status];
									$addDes='';						
									//if($edit_price){$addDes='<div class="fs12 clr5 f1 cur" onclick="changeDocPrice('.$s_id.');"> '.k_srv_prcd_doc.'  [ '.k_edit_price.' ]</div>';
									$tr_color='#faa';
									echo '<tr bgcolor="'.$tr_color.'">	
									<td class="f1">'.$name.$addDes.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
								<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
								<td><ff>'.number_format($totalPrice).'</ff></td>
								</tr>';
								echo '</table>';
							}
								if($pay_type==2 && $sub_status!=3 ){
									echo '<div class="bu bu_t3 fl w-auto" onclick="chrFixSrv('.$vis.','.$c_type.')">'.k_settle_srvc_charty.'</div><div class="cb"></div>';
								}
							}	
							$addPay=$totalPrice;
							$totalPrice2=0;
							/***********************************/							
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from cln_m_services z , cln_x_visits_services x where 
							z.id=x.service and x.visit_id='$vis' and x.status=4 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_o=mysql_n($res);
							if($rows_o>0){
								$totalPrice2=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_srvcs_cncld.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice2+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
								<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
								<td><ff>'.number_format($totalPrice2).'</ff></td>
								</tr>';
								echo '</table>';				
							}
							$XPay=$totalPrice2;
							if($rows_o && $rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
								echo '<div class="f1 fs18 lh40 clr5" >'.$pay_title.' <ff>( '.$x_pay.' )</ff></div>';
							}
						

						/****************************************************************/
						if($opr_show_service2){			
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from cln_m_services z , cln_x_visits_services x where 
							z.id=x.service and x.visit_id='$vis' and x.status IN(0,4) order by z.ord ASC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){
								$totalPrice=0;
								$opr_pay_back=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_unfinshd_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$rev=$r['rev'];
									$price=$hos_part+$doc_part;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
									<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
									<td><ff>'.number_format($totalPrice).'</ff></td>
									</tr>';
								echo '</table>';				
							}						
						}
						/****************************************************************/?>
						<div class="lh20">&nbsp;</div>            
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
						<?
						if($opr_print){echo '<div class="bu bu_t1 fr" onclick="printTicket('.$c_type.','.$vis.')">'.k_print.'</div>';}
						if($opr_cancel){echo '<div class="bu bu_t3 fl" onclick="cancelVis('.$vis.','.$c_type.')">'.k_cancel.'</div>';}						
						if($or_add){echo '<div class="bu bu_t1 fl" onclick="">'.k_add_srvs.'</div>';}
						if($opr_return){echo '<div class="bu bu_t1 fl" onclick="">'.k_reversn.'</div>';}
						if($opr_x_roles){  
							echo '<div class="bu bu_t1 fl" onclick="roelAct('.$vis.','.$c_type.')">'.k_act_rol.'</div>';}
						if($opr_new_roles){
							echo '<div class="bu bu_t1 fl" onclick="newRoels('.$vis.','.$c_type.')">'.k_nw_rol.'</div>';}
						if($rows_o){
							if($rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
							}else{
								$pay_title=k_rvltin_cncld_srvs;
								$set=4;
								$x_pay=$XPay;
							}
							echo '<div class="bu bu_t3 fl w-auto" onclick="changePay('.$vis.','.$x_pay.','.$set.','.$c_type.')">'.$pay_title.'</div>';
						}else{
						if($opr_pay_add){  echo '<div class="bu bu_t3 fl w-auto" onclick="addPay('.$vis.','.$totalPrice.',1,'.$c_type.')">'.k_py_extval.'</div>';}
						if($opr_pay_back){ echo '<div class="bu bu_t3 fl w-auto" onclick="backPay('.$vis.','.$totalPrice.','.$c_type.')">'.k_rturn_val.' </div>';}
						}

						?>
					</div>
					</div><?
				}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}
			if($c_type==2){
				$m_table='lab_x_visits';$m_table2='lab_x_visits_services';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=get_val_c('gnr_m_clinics','id',2,'type');
					$type=$r['type'];
					$pay_type=$r['pay_type'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];
					$pay_type=$r['pay_type'];
					$v_status=$r['status'];
					$reg_user=$r['reg_user'];
					$sub_status=$r['sub_status'];

					$r_status='x';
					if(getTotalCO('gnr_x_roles'," vis='$vis' and mood='$c_type' ")>0){
						$r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$c_type'");
					}
					?>
					<div class="win_body">
					<div class="form_header">
						<div class="fl f1 fs16 lh40 Over" onclick="check_card_do(<?=$patient?>)"><ff><?=$patient?> | </ff><?=get_p_name($patient)?></div>
						<? if($v_status!=6){echo '<div class="fl pd5 f1 clr5 lh40 Over" onclick="changePatVisit(2,'.$vis.')">[ '.k_modify_patient.' ]</div>';}?>						
						<div class="fr ic40 icc1 ic40_ref" onclick="check_tik_do('<?=$v?>')"></div>
						<div class="fr ff B fs20 lh40">#<?=$vis?></div>
					</div>
					<div class="form_body so">
						<div class=" lh40"><?
						$photo=get_val('gnr_m_clinics','photo',$clinic);
						$ph_src=viewImage($photo,1,40,40,'img','clinic.png');		
						echo '<div class="lh40 fl">'.$ph_src.'</div>';			
						echo '<div class="fl lh40 f1 fs18 clr1">&nbsp;'.get_val('gnr_m_clinics','name_'.$lg,$clinic);
						if($doctor){echo ' [ '.get_val('_users','name_'.$lg,$doctor).' ]';}
						echo '</div>';
						?>&nbsp;
						</div>
						<div class="uLine"></div><?	
						
						$d_s=0;
						$d_c=0;
						$d_e=0;
						$opr_cancel=0;
						$or_add=0;
						$opr_return=0;
						$opr_x_roles=0;
						$opr_new_roles=0;
						$opr_show_service=0;
						$opr_show_service2=0;
						$opr_pay_add=0;	
						$opr_pay_back=0;
						$opr_print=0;
						$opr_srv_cancle=0;

						
						if($r_status=='x' && $v_status==1){$d_s=1;$opr_cancel=1;$opr_new_roles=1;}else{if($v_status==1){$opr_print=1;}}
						if($v_status==1){if($r_status<2){$d_s=1;$opr_cancel=1;}
							if($r_status==2){
								$opr_show_service=1;$d_c=1;
								 echo '<div class="f1 fs18 clr1 lh40">'.k_ent_sam_sctn.'</div>';}
							if($r_status==3){
								$d_s=1;$opr_x_roles=1;$opr_cancel=1;
							}
							if($r_status==4){
								$opr_show_service=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_samples_taken.'</div>';
							}
							if($r_status==6){
								$opr_show_service=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_res_tst_dlvrd.'</div>';
							}
						}/*
						if($v_status==2){$d_e=1;$opr_show_service2=1;}
						if($v_status==3){
							$opr_show_service2=1;
							echo '<div class="f1 fs16 clr5">'.k_tst_cncld.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
							<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';
						}
						$EndPay=0;
						if($v_status==4){
							$opr_show_service=1;
							$opr_show_service2=1;
							$EndPay=1;
							echo '<div class="f1 fs16 clr1">'.k_inprgrss.'</div>';
							$ss_all=getTotalCO('lab_x_visits_services', "visit_id='$vis'");
							if($ss_all){echo '<div class="f1 fs14 lh30">'.k_number_of_tests.' : <ff> ( '.$ss_all.' )</ff></div>';}
							$ss_work=getTotalCO('lab_x_visits_services', "visit_id='$vis'  and status IN(5,6,7) ");
							if($ss_work){echo '<div class="f1 fs14 lh30">'.k_wrkng.' : <ff> ( '.$ss_work.' )</ff></div>';}
							$ss_y=getTotalCO('lab_x_visits_services', "visit_id='$vis'  and status IN(8) ");
							if($ss_y){echo '<div class="f1 fs14 lh30">'.k_actd_tsts.' : <ff> ( '.$ss_y.' )</ff></div>';}
							$ss_x=getTotalCO('lab_x_visits_services', "visit_id='$vis'  and status IN(9) ");
							if($ss_x){echo '<div class="f1 fs14 lh30">'.k_rjct_tsts.' : <ff> ( '.$ss_x.' )</ff></div>';}

						}
						if($v_status==5){$EndPay=1;echo '<div class="f1 fs16 clr1">'.k_tsts_prfrmd.'</div>';}
						if($v_status==6){$EndPay=1;echo '<div class="f1 fs16 clr1">'.k_res_tst_dlvrd.'</div>';}
						$Vbal=get_visBal($vis);
						
						if($d_s){echo '<div class="f1 fs16 ">'.k_inf_ent.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_start).' )</ff> '.k_since.'
						<ff> ( '.dateToTimeS2($now-$d_start).' )</ff></div>';}
						if($d_c){echo '<div class="f1 fs16">'.k_ent_sams_sctin.' : <ff>'.dateToTimeS2($now-$d_check).'</ff></div>';}
						if($d_e){echo '<div class="f1 fs16 ">'.k_sams_cpmt_on.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
						<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';}
						*/
						$srvs=get_sum('lab_x_visits_services','total_pay'," visit_id='$vis' and status not in(3,4)");
						//$peyments=get_sum('lab_x_visits_services','pay_net'," visit_id='$vis' and status not in(3,4)");
						$payIN=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(1,2,7) ");
						$payOUT=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(3,4) ");
						//$chrPart=get_val_c('gnr_x_referral_charities','rece_amount',$vis,'vis');
						
						$peyments=$payIN-$payOUT;
						$visBla=$srvs-$peyments;
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
							<tr>
								<td class="f1 fs16 lh40">قيمة التحاليل :</td>
								<td> <ff>'.number_format($srvs).'</ff></td>
							</tr>
							<tr>
								<td class="f1 fs16 lh40">المدفوعات:</td>
								<td><ff>'.number_format($peyments).'</ff></td>
							</tr>';
							if($pay_type==1){
								$exePart=get_sum('gnr_x_exemption_srv','srv_covered'," vis= '$vis' and mood =2");
								echo '<tr>
									<td class="f1 fs16 lh40">الإعفاء:</td>
									<td><ff>'.number_format($exePart).'</ff></td>
								</tr>';
								$visBla-=$exePart;
							}
							if($pay_type==2){								
								$chrPart=get_sum('gnr_x_charities_srv','srv_covered'," vis= '$vis' and mood=2");
								echo '<tr>
									<td class="f1 fs16 lh40">الجمعية:</td>
									<td><ff>'.number_format($chrPart).'</ff></td>
								</tr>';
								$visBla-=$chrPart;
							}
							if($pay_type==3){								
								$insurPart=get_sum('gnr_x_insurance_rec','in_price_includ'," visit= '$vis' and mood=2");
								echo '<tr>
									<td class="f1 fs16 lh40">التأمين:</td>
									<td><ff>'.number_format($insurPart).'</ff></td>
								</tr>';
								$visBla-=$insurPart;
							}
							/*echo '<tr>
								<td class="f1 fs16 lh40">الفرق:</td>
								<td><ff>'.number_format($visBla).'</ff></td>
							</tr>';*/
							$totalPrice12=$visBla;							
							if($visBla>0){
								$butt=k_rcv_diff_pat;								
								echo '<tr bgcolor="'.$clr555.'">			
								<td class="f1 fs14 B">المطلوب من المريض</td>
								<td><ff>'.number_format($visBla).'</ff></td>
								</tr>';
							}else if($visBla<0){
								$butt=k_py_diff_fpat;
								$totalPrice12=$visBla*(-1);
								echo '<tr bgcolor="'.$clr666.'">			
								<td class="f1 fs14 B">المبلغ المستحق للمرض</td>
								<td><ff>'.number_format($totalPrice12).'</ff></td>
								</tr>';
							}
							echo '</table>';
							
							/*	
							$totalPrice12=$totalPrice;
							$addPay=$totalPrice;
							$totalPrice2=0;*/
													
							/*$sql="select * , x.id as xid from lab_m_services z , lab_x_visits_services x where 
							z.id=x.service and x.visit_id='$vis' and x.status=4 order by z.ord ASC";
							$res=mysql_q($sql); 
							$rows_o=mysql_n($res);
							
							if($rows_o>0){
								$totalPrice2=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_tsts_cncld.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['short_name'];
									//$units=$r['units'];
									//$units_price=$r['units_price'];
									$price=$r['total_pay'];
									if($pay_type){$price=$r['pay_net'];}
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="ff B fs16">'.$name.'</td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;									
									$totalPrice2+=$price;
									$i++;
								}
								$chrPart=get_val_c('gnr_x_referral_charities','rece_amount',$vis,'vis');
								echo '<tr bgcolor="#f5f5f5">			
								<td class="f1 fs14 B" >'.k_total.'</td>
								<td><ff>'.number_format($totalPrice2).'</ff></td>
								</tr>';
								if($visBla!=0){								
									$totalPrice2-=$visBla;
									echo '<tr bgcolor="#ffaaaa">			
									<td class="f1 fs14 B">'.k_pr_amnt.'</td>
									<td><ff>'.number_format($visBla).'</ff></td>
									</tr>';
								}
								//$totalPrice2-=$chrPart;
								echo '<tr bgcolor="#f5f5f5">';
									if($totalPrice2>=0){
										$butt=k_rturn_val_tsts;
										$msg=k_rmn_amnt_rtrnd;
										$totalPrice12=$totalPrice2;
										if($chrPart){
											$totalPrice12-=$chrPart;								
											if($totalPrice12<0){$totalPrice12=0;}					
										}
										$hideInput=' hide ';
										$payType=4;
									}else{
										$totalPrice12=intval($totalPrice2)*(-1);
										$butt=k_rcv_rmn_amnt;
										$msg=k_amnt_due_cncltst;
										$payType=2;
									}

									echo '<td class="f1 fs14 B">'.$msg.'</td>
									<td><ff>'.number_format($totalPrice12).'</ff></td>
									</tr>';								
								echo '</table>';				
							}*/
							/*$XPay=$totalPrice2;
							if($rows_o && $rows_i){
								$pay_title=k_switc_tsts;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay -$visBla){
									$pay_title=k_pat_py_tst;
									$butt=k_rcv_diff_pat;
									//$set=2;
									$x_pay=$addPay-$XPay-$visBla;
									$opr_pay_add=1;
									$hideInput='';
									$totalPrice12=$x_pay;
									$payType=2;
								}
								if($addPay < $XPay -$visBla){
									$pay_title=k_rtrn_diff_tsts;
									$butt=k_py_diff_fpat;
									//$set=3;
									$x_pay=$XPay-$addPay+$visBla;
									$totalPrice12=$x_pay;
									$hideInput=' hide ';
									$payType=4;
								}
								
							}*/
						//}
						echo '</table>';
						
						/****************************************************************/?>
						<div class="lh20">&nbsp;</div>            
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
						<?
						//$amount=get_sum('gnr_x_acc_payments','amount'," type =1 and mood=2 and vis='$vis'");
						if($opr_print){    echo '<div class="bu bu_t1 fr" onclick="printTicket('.$c_type.','.$vis.','.$amount.')">'.k_print.'</div>';}
						if($opr_cancel){   echo '<div class="bu bu_t3 fr" onclick="cancelVis('.$vis.','.$c_type.')">'.k_cancel.'</div>';}						
						if($opr_x_roles){  
							echo '<div class="bu bu_t1 fl" onclick="roelAct('.$vis.','.$c_type.')">'.k_act_rol.'</div>';}
						if($opr_new_roles){
							echo '<div class="bu bu_t1 fl" onclick="newRoels('.$vis.','.$c_type.')">'.k_nw_rol.'</div>';}
						if($visBla>0){
							echo '<div class="bu bu_t4 fl w-auto" onclick="addPay('.$vis.','.$totalPrice12.',2,'.$c_type.')">'.$butt.'</div> 
							<input type="number" class="'.$hideInput.'" id="l_pay" max="'.$totalPrice12.'" value="'.$totalPrice12.'" style="width:100px; margin:10px; color:#090"/>';
						}else if($visBla<0){
							//if($EndPay && $Vbal>0){
							//if($Vbal>0){
							echo '<div class="bu bu_t3 fl w-auto" onclick="addPay('.$vis.','.$totalPrice12.',4,'.$c_type.')">'.k_py_rst_due.'</div> 
							<input type="number" disabled class="'.$hideInput.'" id="l_pay" max="'.$totalPrice12.'" value="'.$totalPrice12.'" style="width:100px; margin:10px; color:#f00"/>';
						}					
						?>
					</div>
					</div><?
				}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}
			if($c_type==3){
				$m_table='xry_x_visits';$m_table2='xry_x_visits_services';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];					
					$type=$r['type'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];
					$pay_type=$r['pay_type'];
					$v_status=$r['status'];
					$reg_user=$r['reg_user'];
					$sub_status=$r['sub_status'];

					$r_status='x';
					if(getTotalCO('gnr_x_roles'," vis='$vis' and mood='$c_type' ")>0){
						$r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$c_type'");
					}
					?>
					<div class="win_body">
					<div class="form_header">
						<div class="fl f1 fs16 lh40 Over" onclick="check_card_do(<?=$patient?>)">
						<ff><?=$patient?> | </ff><?=get_p_name($patient)?>
						</div>
						<? if($v_status==1){echo '<div class="fl pd5 f1 clr5 lh40 Over" onclick="changePatVisit('.$c_type.','.$vis.')">[ '.k_modify_patient.' ]</div>';}?>
						<div class="fr ff B fs20  lh40">#<?=$vis?></div>            
					</div>
					<div class="form_body so">
						<div class=" lh40"><?
						$photo=get_val('gnr_m_clinics','photo',$clinic);						
						$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
						echo '<div class="lh40 fl">'.$ph_src.'</div>';			
						echo '<div class="fl lh40 f1 fs18 clr1">&nbsp;'.get_val('gnr_m_clinics','name_'.$lg,$clinic);
						if($doctor){echo ' [ '.get_val('_users','name_'.$lg,$doctor).' ]';}
						echo '</div>';
						?>&nbsp;
						</div>
						<div class="uLine"></div><?			
						$d_s=0;
						$d_c=0;
						$d_e=0;
						$opr_cancel=0;
						$or_add=0;
						$opr_return=0;
						$opr_x_roles=0;
						$opr_new_roles=0;
						$opr_show_service=0;
						$opr_show_service2=0;
						$opr_pay_add=0;	
						$opr_pay_back=0;
						$opr_print=1;
						$opr_srv_cancle=0;
						$chariButt=0;
						if($v_status==3){$opr_print=0;}
						if($r_status=='x' && $v_status==1){$d_s=1;$opr_cancel=1;$opr_new_roles=1;}
						if($v_status==1){if($r_status<2){$d_s=1;$opr_cancel=1;}
							if($r_status==2){$opr_show_service=1;$d_c=1;
											 echo '<div class="f1 fs18 clr1 lh40">'.k_srv_curciving.'</div>';}
							if($r_status==3){$d_s=1;$opr_x_roles=1;$opr_cancel=1;}
						}
						if($v_status==2){$d_e=1;$opr_show_service2=1;}
						if($v_status==3){
							$opr_show_service=1;
							echo '<div class="f1 fs16 clr5">'.k_prv_cncld.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
							<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';
						}			

						if($d_s){echo '<div class="f1 fs16 ">'.k_inf_ent.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_start).' )</ff> '.k_since.'
						<ff> ( '.dateToTimeS2($now-$d_start).' )</ff></div>';}
						if($d_c){echo '<div class="f1 fs16">'.k_prv_start.' : <ff>'.dateToTimeS2($now-$d_check).'</ff></div>';}
						if($d_e){echo '<div class="f1 fs16">'.k_prv_cmpt.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
						<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';}
						/****************************************************************/
						$addPay=0;
						$XPay=0;
						if($opr_show_service){				
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from xry_m_services z , $m_table2 x where 
							z.id=x.service and x.visit_id='$vis' and x.status=2 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_i=mysql_n($res);
							if($rows_i>0){					
								$totalPrice=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_addtn_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$edit_price=$r['edit_price'];

									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}
									$tr_color=$ser_status_color[$s_status];
									$addDes='';						
									//if($edit_price){$addDes='<div class="fs12 clr5 f1 cur" onclick="changeDocPrice('.$s_id.');"> '.k_srv_prcd_doc.'  [ '.k_edit_price.' ]</div>';
									//$tr_color='#faa';
									//}
									echo '<tr bgcolor="'.$tr_color.'">	
									<td class="f1">'.$name.$addDes.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
									<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
									<td><ff>'.number_format($totalPrice).'</ff></td>
									</tr>';
								echo '</table>';
								if($pay_type==2 && $sub_status!=3 ){
									echo '<div class="bu bu_t3 fl w-auto" onclick="chrFixSrv('.$vis.','.$c_type.')">'.k_settle_srvc_charty.'</div><div class="cb"></div>';
								}
							}	
							$addPay=$totalPrice;
							$totalPrice2=0;
							/***********************************/							
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from xry_m_services z , $m_table2 x where 
							z.id=x.service and x.visit_id='$vis' and x.status=4 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_o=mysql_n($res);
							if($rows_o>0){
								$totalPrice2=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_srvcs_cncld.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice2+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
								<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
								<td><ff>'.number_format($totalPrice2).'</ff></td>
								</tr>';
								echo '</table>';				
							}
							$XPay=$totalPrice2;
							if($rows_o && $rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
								echo '<div class="f1 fs18 lh40 clr5" >'.$pay_title.' <ff>( '.$x_pay.' )</ff></div>';
							}
						}

						/****************************************************************/
						if($opr_show_service2){			
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from xry_m_services z , $m_table2 x where 
							z.id=x.service and x.visit_id='$vis' and x.status IN(0,4) order by z.ord ASC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){
								$totalPrice=0;
								$opr_pay_back=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_unfinshd_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$rev=$r['rev'];
									$price=$hos_part+$doc_part;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
									<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
									<td><ff>'.number_format($totalPrice).'</ff></td>
									</tr>';
								echo '</table>';				
							}						
						}
						/****************************************************************/?>
						<div class="lh20">&nbsp;</div>            
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
						<?
						if($opr_print){echo '<div class="bu bu_t1 fr" onclick="printTicket('.$c_type.','.$vis.')">'.k_print.'</div>';}
						if($opr_cancel){echo '<div class="bu bu_t3 fl" onclick="cancelVis('.$vis.','.$c_type.')">'.k_cancel.'</div>';}						
						if($or_add){echo '<div class="bu bu_t1 fl" onclick="">'.k_add_srvs.'</div>';}
						if($opr_return){echo '<div class="bu bu_t1 fl" onclick="">'.k_reversn.'</div>';}
						if($opr_x_roles){  
							echo '<div class="bu bu_t1 fl" onclick="roelAct('.$vis.','.$c_type.')">'.k_act_rol.'</div>';}
						if($opr_new_roles){
							echo '<div class="bu bu_t1 fl" onclick="newRoels('.$vis.','.$c_type.')">'.k_nw_rol.'</div>';}
						if($rows_o){
							if($rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
							}else{
								$pay_title=k_rvltin_cncld_srvs;
								$set=4;
								$x_pay=$XPay;
							}
							echo '<div class="bu bu_t3 fl w-auto" onclick="changePay('.$vis.','.$x_pay.','.$set.','.$c_type.')">'.$pay_title.'</div>';
						}else{
						if($opr_pay_add){  echo '<div class="bu bu_t3 fl w-auto" onclick="addPay('.$vis.','.$totalPrice.',1,'.$c_type.')">'.k_py_extval.'</div>';}
						if($opr_pay_back){ echo '<div class="bu bu_t3 fl w-auto" onclick="backPay('.$vis.','.$totalPrice.','.$c_type.')">'.k_rturn_val.' </div>';}
						}

						?>
					</div>
					</div><?
				}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}			
			if($c_type==4){
				$m_table='den_x_visits';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];
					$type=$r['type'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];					
					$v_status=$r['status'];
					$reg_user=$r['reg_user'];
					$r_status='x';
					if(getTotalCO('gnr_x_roles'," vis='$vis' and mood='$c_type' ")>0){
						$r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$c_type'");
					}
					?>
					<div class="win_body">
					<div class="form_header">
						<div class="fl f1 fs16 lh40 Over" onclick="check_card_do(<?=$patient?>)">
						<ff><?=$patient?> | </ff><?=get_p_name($patient)?>
						</div>
						<? if($v_status==1){echo '<div class="fl pd5 f1 clr5 lh40 Over" onclick="changePatVisit(4,'.$vis.')">[ '.k_modify_patient.' ]</div>';}?>
						<div class="fr ff B fs20  lh40">#<?=$vis?></div>            
					</div>
					<div class="form_body so">
						<div class=" lh40"><?
						$photo=get_val('gnr_m_clinics','photo',$clinic);						
						$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
						echo '<div class="lh40 fl">'.$ph_src.'</div>';			
						echo '<div class="fl lh40 f1 fs18 clr1">&nbsp;'.get_val('gnr_m_clinics','name_'.$lg,$clinic);
						if($doctor){echo ' [ '.get_val('_users','name_'.$lg,$doctor).' ]';}
						echo '</div>';
						?>&nbsp;
						</div>
						<div class="uLine"></div><?			
						$d_s=0;
						$d_c=0;
						$d_e=0;
						$opr_cancel=0;
						
						$opr_return=0;
						$opr_x_roles=0;
						$opr_new_roles=0;
						$opr_show_service=0;
						$opr_show_service2=0;
						$opr_pay_add=0;	
						$opr_pay_back=0;
						$opr_print=1;
						$opr_srv_cancle=0;
						$chariButt=0;
						if($v_status==3){$opr_print=0;}
						if($r_status=='x' && $v_status==1){$d_s=1;$opr_cancel=1;$opr_new_roles=1;}
						if($v_status==0){
							$opr_cancel=1;
							if($r_status==3){$d_s=1;$opr_x_roles=1;$opr_cancel=1;}
						}
						if($v_status==1){
							if($r_status<2){$d_s=1;$opr_cancel=1;}
							if($r_status==2){
								$opr_show_service=1;
								$d_c=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_srv_curciving.'</div>';
							}
							if($r_status==3){$d_s=1;$opr_x_roles=1;$opr_cancel=1;}
						}
						if($v_status==2){$d_e=1;$opr_show_service2=1;}
						if($v_status==3){
							echo '<div class="f1 fs16 clr5">'.k_prv_cncld.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
							<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';
						}			

						if($d_s){echo '<div class="f1 fs16 ">'.k_inf_ent.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_start).' )</ff> '.k_since.'
						<ff> ( '.dateToTimeS2($now-$d_start).' )</ff></div>';}
						if($d_c){echo '<div class="f1 fs16">'.k_prv_start.' : <ff>'.dateToTimeS2($now-$d_check).'</ff></div>';}
						if($d_e){echo '<div class="f1 fs16 ">'.k_prv_cmpt.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
						<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';}						
						echo '&nbsp;';
						/****************************************************************/?>
						            
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
						<?
						if($opr_print){echo '<div class="bu bu_t1 fr" onclick="printTicket('.$c_type.','.$vis.')">'.k_print.'</div>';}
						if($opr_cancel){echo '<div class="bu bu_t3 fl" onclick="cancelVis('.$vis.','.$c_type.')">'.k_cancel.'</div>';}
						
						if($opr_return){echo '<div class="bu bu_t1 fl" onclick="">'.k_reversn.'</div>';}
						if($opr_x_roles){  
							echo '<div class="bu bu_t1 fl" onclick="roelAct('.$vis.','.$c_type.')">'.k_act_rol.'</div>';
						}
						if($opr_new_roles){
							echo '<div class="bu bu_t1 fl" onclick="newRoels('.$vis.','.$c_type.')">'.k_nw_rol.'</div>';
						}?>
					</div>
					</div><?
				}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}
			if($c_type==5){
				$m_table='bty_x_visits';$m_table2='bty_x_visits_services';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];
					$type=$r['type'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];
					$pay_type=$r['pay_type'];
					$v_status=$r['status'];
					$reg_user=$r['reg_user'];
					$sub_status=$r['sub_status'];

					$r_status='x';
					if(getTotalCO('gnr_x_roles'," vis='$vis' and mood='$c_type' ")>0){
						$r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$c_type'");
					}
					?>
					<div class="win_body">
					<div class="form_header">
						<div class="fl f1 fs16 lh40 Over" onclick="check_card_do(<?=$patient?>)">
						<ff><?=$patient?> | </ff><?=get_p_name($patient)?>
						</div>
						<? if($v_status==1){echo '<div class="fl pd5 f1 clr5 lh40 Over" onclick="changePatVisit(1,'.$vis.')">[ '.k_modify_patient.' ]</div>';}?>
						<div class="fr ff B fs20  lh40">#<?=$vis?></div>            
					</div>
					<div class="form_body so">
						<div class=" lh40"><?
						$photo=get_val('gnr_m_clinics','photo',$clinic);						
						$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
						echo '<div class="lh40 fl">'.$ph_src.'</div>';			
						echo '<div class="fl lh40 f1 fs18 clr1">&nbsp;'.get_val('gnr_m_clinics','name_'.$lg,$clinic);
						if($doctor){echo ' [ '.get_val('_users','name_'.$lg,$doctor).' ]';}
						echo '</div>';
						?>&nbsp;
						</div>
						<div class="uLine"></div><?			
						$d_s=0;
						$d_c=0;
						$d_e=0;
						$opr_cancel=0;
						$or_add=0;
						$opr_return=0;
						$opr_x_roles=0;
						$opr_new_roles=0;
						$opr_show_service=0;
						$opr_show_service2=0;
						$opr_pay_add=0;	
						$opr_pay_back=0;
						$opr_print=1;
						$opr_srv_cancle=0;
						$chariButt=0;						
						if($v_status==3){$opr_print=0;}
						if($r_status=='x' && $v_status==1){$d_s=1;$opr_cancel=1;$opr_new_roles=1;}
						if($v_status==1){if($r_status<2){$d_s=1;$opr_cancel=1;}
							if($r_status==2){$opr_show_service=1;$d_c=1;$opr_show_service2=1;
											 echo '<div class="f1 fs18 clr1 lh40">'.k_srv_curciving.'</div>';}
							if($r_status==3){$d_s=1;$opr_x_roles=1;$opr_cancel=1;$opr_show_service2=1;}
						}
						if($v_status==2){$d_e=1;$opr_show_service2=1;$opr_show_service2=1;}
						if($v_status==3){
							echo '<div class="f1 fs16 clr5">'.k_prv_cncld.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
							<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';
						}			

						if($d_s){echo '<div class="f1 fs16 ">'.k_inf_ent.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_start).' )</ff> '.k_since.'
						<ff> ( '.dateToTimeS2($now-$d_start).' )</ff></div>';}
						if($d_c){echo '<div class="f1 fs16">'.k_prv_start.' : <ff>'.dateToTimeS2($now-$d_check).'</ff></div>';}
						if($d_e){echo '<div class="f1 fs16 ">'.k_prv_cmpt.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
						<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';}
						/****************************************************************/
						$addPay=0;
						$XPay=0;
						if($opr_show_service){				
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from bty_m_services z , bty_x_visits_services x where 
							z.id=x.service and x.visit_id='$vis' and x.status=2 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_i=mysql_n($res);
							if($rows_i>0){							
								$totalPrice=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_addtn_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$edit_price=$r['edit_price'];

									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}
									$tr_color=$ser_status_color[$s_status];
									$addDes='';						
									//if($edit_price){$addDes='<div class="fs12 clr5 f1 cur" onclick="changeDocPrice('.$s_id.');"> '.k_srv_prcd_doc.'  [ '.k_edit_price.' ]</div>';
									$tr_color='#faa';}
									echo '<tr bgcolor="'.$tr_color.'">	
									<td class="f1">'.$name.$addDes.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
									<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
									<td><ff>'.number_format($totalPrice).'</ff></td>
									</tr>';
								echo '</table>';
								if($pay_type==2 && $sub_status!=3 ){
									echo '<div class="bu bu_t3 fl w-auto" onclick="chrFixSrv('.$vis.','.$c_type.')">'.k_settle_srvc_charty.'</div><div class="cb"></div>';
								}
							}	
							$addPay=$totalPrice;
							$totalPrice2=0;
							/***********************************/							
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from bty_m_services z , bty_x_visits_services x where 
							z.id=x.service and x.visit_id='$vis' and x.status=4 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_o=mysql_n($res);
							if($rows_o>0){
								$totalPrice2=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_srvcs_cncld.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice2+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
								<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
								<td><ff>'.number_format($totalPrice2).'</ff></td>
								</tr>';
								echo '</table>';				
							}
							$XPay=$totalPrice2;
							if($rows_o && $rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
								echo '<div class="f1 fs18 lh40 clr5" >'.$pay_title.' <ff>( '.$x_pay.' )</ff></div>';
							}
						

						/****************************************************************/
						if($opr_show_service2){			
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from bty_m_services z , bty_x_visits_services x where 
							z.id=x.service and x.visit_id='$vis' and x.status IN(0,4) order by z.ord ASC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){
								$totalPrice=0;
								$opr_pay_back=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_unfinshd_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$rev=$r['rev'];
									$price=$hos_part+$doc_part;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
									<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
									<td><ff>'.number_format($totalPrice).'</ff></td>
									</tr>';
								echo '</table>';				
							}						
						}
						/****************************************************************/?>
						<div class="lh20">&nbsp;</div>            
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
						<?
						if($opr_print){echo '<div class="bu bu_t1 fr" onclick="printTicket('.$c_type.','.$vis.')">'.k_print.'</div>';}
						if($opr_cancel){echo '<div class="bu bu_t3 fl" onclick="cancelVis('.$vis.','.$c_type.')">'.k_cancel.'</div>';}						
						if($or_add){echo '<div class="bu bu_t1 fl" onclick="">'.k_add_srvs.'</div>';}
						if($opr_return){echo '<div class="bu bu_t1 fl" onclick="">'.k_reversn.'</div>';}
						if($opr_x_roles){  
							echo '<div class="bu bu_t1 fl" onclick="roelAct('.$vis.','.$c_type.')">'.k_act_rol.'</div>';}
						if($opr_new_roles){
							echo '<div class="bu bu_t1 fl" onclick="newRoels('.$vis.','.$c_type.')">'.k_nw_rol.'</div>';}
						if($rows_o){
							if($rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
							}else{
								$pay_title=k_rvltin_cncld_srvs;
								$set=4;
								$x_pay=$XPay;
							}
							echo '<div class="bu bu_t3 fl w-auto" onclick="changePay('.$vis.','.$x_pay.','.$set.','.$c_type.')">'.$pay_title.'</div>';
						}else{
						if($opr_pay_add){  echo '<div class="bu bu_t3 fl w-auto" onclick="addPay('.$vis.','.$totalPrice.',1,'.$c_type.')">'.k_py_extval.'</div>';}
						if($opr_pay_back){ echo '<div class="bu bu_t3 fl w-auto" onclick="backPay('.$vis.','.$totalPrice.','.$c_type.')">'.k_rturn_val.' </div>';}
						}

						?>
					</div>
					</div><?
				}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}
			if($c_type==6){
				$m_table='bty_x_laser_visits';$m_table2='bty_x_laser_visits_services';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];
					$type=$r['type'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];
					$pay_type=$r['pay_type'];
					$v_status=$r['status'];
					$reg_user=$r['reg_user'];
					$sub_status=$r['sub_status'];
					

					$r_status='x';					
					if(getTotalCO('gnr_x_roles'," vis='$vis' and mood='$c_type' ")>0){
						$r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$c_type'");
					}
					?>
					<div class="win_body">
					<div class="form_header">
						<div class="fl f1 fs16 lh40 Over" onclick="check_card_do(<?=$patient?>)">
						<ff><?=$patient?> | </ff><?=get_p_name($patient)?>
						</div>
						<? if($v_status==1){echo '<div class="fl pd5 f1 clr5 lh40 Over" onclick="changePatVisit(1,'.$vis.')">[ '.k_modify_patient.' ]</div>';}?>
						<div class="fr ff B fs20  lh40">#<?=$vis?></div>            
					</div>
					<div class="form_body so">
						<div class=" lh40"><?
						$photo=get_val('gnr_m_clinics','photo',$clinic);						
						$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
						echo '<div class="lh40 fl">'.$ph_src.'</div>';			
						echo '<div class="fl lh40 f1 fs18 clr1">&nbsp;'.get_val('gnr_m_clinics','name_'.$lg,$clinic);
						if($doctor){echo ' [ '.get_val('_users','name_'.$lg,$doctor).' ]';}
						echo '</div>';
						?>&nbsp;
						</div>
						<div class="uLine"></div><?			
						$d_s=0;
						$d_c=0;
						$d_e=0;
						$opr_cancel=0;
						$or_add=0;
						$opr_return=0;
						$opr_x_roles=0;
						$opr_new_roles=0;
						$opr_show_service=0;
						$opr_show_service2=0;
						$opr_pay_add=0;	
						$opr_pay_back=0;
						$opr_print=1;
						$opr_srv_cancle=0;
						$chariButt=0;
						if($v_status==3){$opr_print=0;}
						if($r_status=='x' && $v_status==1){$d_s=1;$opr_cancel=1;$opr_new_roles=1;}
						if($v_status==1){if($r_status<2){$d_s=1;$opr_cancel=1;}
							if($r_status==2){$opr_show_service=1;$d_c=1;
											 echo '<div class="f1 fs18 clr1 lh40">'.k_srv_curciving.'</div>';}
							if($r_status==3){$d_s=1;$opr_x_roles=1;$opr_cancel=1;}
						}
						if($v_status==2){$d_e=1;$opr_show_service2=1;}
						if($v_status==3){
							echo '<div class="f1 fs16 clr5">'.k_prv_cncld.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
							<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';
						}

						if($d_s){echo '<div class="f1 fs16 ">'.k_inf_ent.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_start).' )</ff> '.k_since.'
						<ff> ( '.dateToTimeS2($now-$d_start).' )</ff></div>';}
						if($d_c){echo '<div class="f1 fs16">'.k_prv_start.' : <ff>'.dateToTimeS2($now-$d_check).'</ff></div>';}
						if($d_e){echo '<div class="f1 fs16 ">'.k_prv_cmpt.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
						<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';}						
						
						/****************************************************************/?>
						<div class="lh20">&nbsp;</div>            
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
						<?
						if($opr_print){echo '<div class="bu bu_t1 fr" onclick="printTicket('.$c_type.','.$vis.')">'.k_print.'</div>';}
						if($opr_cancel){echo '<div class="bu bu_t3 fl" onclick="cancelVis('.$vis.','.$c_type.')">'.k_cancel.'</div>';}						
						if($or_add){echo '<div class="bu bu_t1 fl" onclick="">'.k_add_srvs.'</div>';}
						if($opr_return){echo '<div class="bu bu_t1 fl" onclick="">'.k_reversn.'</div>';}
						if($opr_x_roles){  
							echo '<div class="bu bu_t1 fl" onclick="roelAct('.$vis.','.$c_type.')">'.k_act_rol.'</div>';}
						if($opr_new_roles){
							echo '<div class="bu bu_t1 fl" onclick="newRoels('.$vis.','.$c_type.')">'.k_nw_rol.'</div>';}
						if($rows_o){
							if($rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
							}else{
								$pay_title=k_rvltin_cncld_srvs;
								$set=4;
								$x_pay=$XPay;
							}
							echo '<div class="bu bu_t3 fl w-auto" onclick="changePay('.$vis.','.$x_pay.','.$set.','.$c_type.')">'.$pay_title.'</div>';
						}else{
						if($opr_pay_add){  echo '<div class="bu bu_t3 fl w-auto" onclick="addPay('.$vis.','.$totalPrice.',1,'.$c_type.')">'.k_py_extval.'</div>';}
						if($opr_pay_back){ echo '<div class="bu bu_t3 fl w-auto" onclick="backPay('.$vis.','.$totalPrice.','.$c_type.')">'.k_rturn_val.' </div>';}
						}

						?>
					</div>
					</div><?
				}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}
			if($c_type==7){
				$m_table='osc_x_visits';$m_table2='osc_x_visits_services';
				$sql="select * from $m_table where id='$vis' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo $rows.'^';
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];					
					$type=$r['type'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];
					$pay_type=$r['pay_type'];
					$v_status=$r['status'];
					$reg_user=$r['reg_user'];
					$sub_status=$r['sub_status'];

					$r_status='x';
					if(getTotalCO('gnr_x_roles'," vis='$vis' and mood='$c_type' ")>0){
						$r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$c_type'");
					}
					?>
					<div class="win_body">
					<div class="form_header">
						<div class="fl f1 fs16 lh40 Over" onclick="check_card_do(<?=$patient?>)">
						<ff><?=$patient?> | </ff><?=get_p_name($patient)?>
						</div>
						<? if($v_status==1){echo '<div class="fl pd5 f1 clr5 lh40 Over" onclick="changePatVisit('.$c_type.','.$vis.')">[ '.k_modify_patient.' ]</div>';}?>
						<div class="fr ff B fs20  lh40">#<?=$vis?></div>            
					</div>
					<div class="form_body so">
						<div class=" lh40"><?
						$photo=get_val('gnr_m_clinics','photo',$clinic);						
						$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
						echo '<div class="lh40 fl">'.$ph_src.'</div>';			
						echo '<div class="fl lh40 f1 fs18 clr1">&nbsp;'.get_val('gnr_m_clinics','name_'.$lg,$clinic);
						if($doctor){echo ' [ '.get_val('_users','name_'.$lg,$doctor).' ]';}
						echo '</div>';
						?>&nbsp;
						</div>
						<div class="uLine"></div><?			
						$d_s=0;
						$d_c=0;
						$d_e=0;
						$opr_cancel=0;
						$or_add=0;
						$opr_return=0;
						$opr_x_roles=0;
						$opr_new_roles=0;
						$opr_show_service=0;
						$opr_show_service2=0;
						$opr_pay_add=0;	
						$opr_pay_back=0;
						$opr_print=1;
						$opr_srv_cancle=0;
						$chariButt=0;
						if($v_status==3){$opr_print=0;}
						if($r_status=='x' && $v_status==1){$d_s=1;$opr_cancel=1;$opr_new_roles=1;}
						if($v_status==1){if($r_status<2){$d_s=1;$opr_cancel=1;}
							if($r_status==2){
								$opr_show_service=1;$d_c=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_srv_curciving.'</div>';
							}
							if($r_status==3){$d_s=1;$opr_x_roles=1;$opr_cancel=1;}
						}
						if($v_status==2){$d_e=1;$opr_show_service2=1;}
						if($v_status==3){
							$opr_show_service=1;
							echo '<div class="f1 fs16 clr5">'.k_prv_cncld.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
							<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';
						}			

						if($d_s){echo '<div class="f1 fs16 ">'.k_inf_ent.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_start).' )</ff> '.k_since.'
						<ff> ( '.dateToTimeS2($now-$d_start).' )</ff></div>';}
						if($d_c){echo '<div class="f1 fs16">'.k_prv_start.' : <ff>'.dateToTimeS2($now-$d_check).'</ff></div>';}
						if($d_e){echo '<div class="f1 fs16">'.k_prv_cmpt.' : <ff dir="ltr"> ( '.date('Y-m-d',$d_finish).' )</ff> '.k_since.' 
						<ff> ( '.dateToTimeS2($now-$d_finish).' ) </ff></div>';}
						/****************************************************************/
						$addPay=0;
						$XPay=0;
						if($opr_show_service){				
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from osc_m_services z , $m_table2 x where 
							z.id=x.service and x.visit_id='$vis' and x.status=2 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_i=mysql_n($res);
							if($rows_i>0){					
								$totalPrice=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_addtn_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$edit_price=$r['edit_price'];

									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}
									$tr_color=$ser_status_color[$s_status];
									$addDes='';						
									//if($edit_price){$addDes='<div class="fs12 clr5 f1 cur" onclick="changeDocPrice('.$s_id.');"> '.k_srv_prcd_doc.'  [ '.k_edit_price.' ]</div>';
									//$tr_color='#faa';
									//}
									echo '<tr bgcolor="'.$tr_color.'">	
									<td class="f1">'.$name.$addDes.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
									<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
									<td><ff>'.number_format($totalPrice).'</ff></td>
									</tr>';
								echo '</table>';
								if($pay_type==2 && $sub_status!=3 ){
									echo '<div class="bu bu_t3 fl w-auto" onclick="chrFixSrv('.$vis.','.$c_type.')">'.k_settle_srvc_charty.'</div><div class="cb"></div>';
								}
							}	
							$addPay=$totalPrice;
							$totalPrice2=0;
							/***********************************/							
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from osc_m_services z , $m_table2 x where 
							z.id=x.service and x.visit_id='$vis' and x.status=4 order by z.ord ASC";
							$res=mysql_q($sql);
							$rows_o=mysql_n($res);
							if($rows_o>0){
								$totalPrice2=0;
								$opr_pay_add=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_srvcs_cncld.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$pay_net=$r['pay_net'];
									$rev=$r['rev'];
									$price=$pay_net;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice2+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
								<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
								<td><ff>'.number_format($totalPrice2).'</ff></td>
								</tr>';
								echo '</table>';				
							}
							$XPay=$totalPrice2;
							if($rows_o && $rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
								echo '<div class="f1 fs18 lh40 clr5" >'.$pay_title.' <ff>( '.$x_pay.' )</ff></div>';
							}
						}

						/****************************************************************/
						if($opr_show_service2){			
							$sql="select * , 
							x.id as xid , 
							x.hos_part as x_hos_part ,
							x.doc_part as x_doc_part 
							from osc_m_services z , $m_table2 x where 
							z.id=x.service and x.visit_id='$vis' and x.status IN(0,4) order by z.ord ASC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){
								$totalPrice=0;
								$opr_pay_back=1;
								echo '<div class="f1 fs18 clr1 lh40">'.k_unfinshd_srvs.'</div>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
								echo '<tr><th>'.k_service.'</th><th>'.k_tim.'</th><th>'.k_price.'</th></tr>';
								$i=0;
								while($r=mysql_f($res)){
									$s_id=$r['xid'];
									$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
									$s_status=$r['status'];
									$name=$r['name_'.$lg];
									$hos_part=$r['x_hos_part'];
									$doc_part=$r['x_doc_part'];
									$rev=$r['rev'];
									$price=$hos_part+$doc_part;
									if($prv_Type==2 && $rev){$price=0;}				
									echo '<tr bgcolor="'.$ser_status_color[$s_status].'">	
									<td class="f1">'.$name.'</td>
									<td><ff>'.dateToTimeS2($s_time).'</ff></td>
									<td><ff>'.number_format($price).'</ff></td>
									</tr>';			
									$ser_times[$i]['time']=$s_time;
									$ser_times[$i]['name']=$name;
									$ser_times[$i]['status']=$s_status;
									$totalPrice+=$price;
									$i++;
								}
								echo '<tr bgcolor="#f5f5f5">			
									<td class="f1 fs14 B" colspan="2">'.k_total.'</td>
									<td><ff>'.number_format($totalPrice).'</ff></td>
									</tr>';
								echo '</table>';				
							}						
						}
						/****************************************************************/?>
						<div class="lh20">&nbsp;</div>            
					</div>
					<div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
						<?
						if($opr_print){echo '<div class="bu bu_t1 fr" onclick="printTicket('.$c_type.','.$vis.')">'.k_print.'</div>';}
						if($opr_cancel){echo '<div class="bu bu_t3 fl" onclick="cancelVis('.$vis.','.$c_type.')">'.k_cancel.'</div>';}						
						if($or_add){echo '<div class="bu bu_t1 fl" onclick="">'.k_add_srvs.'</div>';}
						if($opr_return){echo '<div class="bu bu_t1 fl" onclick="">'.k_reversn.'</div>';}
						if($opr_x_roles){  
							echo '<div class="bu bu_t1 fl" onclick="roelAct('.$vis.','.$c_type.')">'.k_act_rol.'</div>';}
						if($opr_new_roles){
							echo '<div class="bu bu_t1 fl" onclick="newRoels('.$vis.','.$c_type.')">'.k_nw_rol.'</div>';}
						if($rows_o){
							if($rows_i){
								$pay_title=k_swt_srvs;
								$set=1;
								$x_pay=0;
								if($addPay > $XPay){
									$pay_title=k_pay_defrnc;
									$set=2;
									$x_pay=$addPay-$XPay;
								}
								if($addPay < $XPay){
									$pay_title=k_restor_dfrnc;
									$set=3;
									$x_pay=$XPay-$addPay;
								}
							}else{
								$pay_title=k_rvltin_cncld_srvs;
								$set=4;
								$x_pay=$XPay;
							}
							echo '<div class="bu bu_t3 fl w-auto" onclick="changePay('.$vis.','.$x_pay.','.$set.','.$c_type.')">'.$pay_title.'</div>';
						}else{
						if($opr_pay_add){  echo '<div class="bu bu_t3 fl w-auto" onclick="addPay('.$vis.','.$totalPrice.',1,'.$c_type.')">'.k_py_extval.'</div>';}
						if($opr_pay_back){ echo '<div class="bu bu_t3 fl w-auto" onclick="backPay('.$vis.','.$totalPrice.','.$c_type.')">'.k_rturn_val.' </div>';}
						}

						?>
					</div>
					</div><?
				}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' <ff>'.$vis.'</ff></div>';}
			}
			if($c_type==9){echo '0^'.script('dateINfo('.$vis.',1)');}
		}
	}else{echo '0^'.'<div class="f1 fs16 lh30 clr5">'.k_cod_incrr.'</div>';}
}
?>