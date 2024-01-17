<? /*include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['in'])){
	$id=pp($_POST['id']);
	$insur=pp($_POST['in']);
	$r_req=getRec('gnr_x_temp_oprs',$id);
	if($r_req['r']){
		$mood=$r_req['mood'];
		$clinic=$r_req['clinic'];
		$patient=$r_req['patient'];
		$vis=$r_req['vis'];
		$addNewServis=0;
		$table=$visXTables[$mood];
		$r_visit=getRec($table,$vis);
		$doctor=$r_visit['doctor'];
		$pay_type=$r_visit['pay_type'];
		if($pay_type==3){$addNewServis=1;}
		$acc=0;
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($patient)?></div>
		<div class="form_body so">
			<form name="in_rec" id="in_rec" action="<?=$f_path?>X/gnr_insur_rec_save.php" method="post" cb="ins_ref(1)">
				<input type="hidden" name="id" value="<?=$id?>" />
				<div class="f1 fs16 lh40 uLine"><?=k_insure_account?> : <?		
				$sql="select * from gnr_m_insurance_rec where patient='$patient' order by valid DESC";
				$res=mysql_q($sql);
				if(mysql_n($res)){
					$acc=1;
					echo '<select name="p_insure" onchange="insurNewRec('.$id.',this.value)">';
					while($r=mysql_f($res)){				
						$insur_id=$r['id'];
						$prov_id=$r['provider'];
						if(!$insur){$insur=$insur_id;}
						$in_prov=get_val('gnr_m_insurance_prov','name_'.$lg,$prov_id);
						$in_com=get_val('gnr_m_insurance_comp','name',$r['company']);
						$text=$r['no'].' | '.$r['valid'].' | '.$in_prov.' | '.$in_com.' | '.$r['class'];
						$sel=" ";
						if($insur==$insur_id){
							$sel=" selected ";
							$insue_name=$in_prov.' ( '.$in_com.' )';
						}
						echo '<option value="'.$insur_id.'" '.$sel.' >'.$text.'</option>';
					}
					echo '</select>';
					echo '<div class="f1 fs14 clr1">'.k_accounts_dont_match_pat_account.' <span class="f1 fs16 clr5 Over" onclick="newInsurAcc('.$id.','.$patient.')"> ( '.k_add_account.' ) </span></div>';

				}else{
					echo '<span class="f1 fs14 clr1">'.k_pat_dont_has_account.' <span class="f1 fs16 clr5 Over" onclick="newInsurAcc('.$id.','.$patient.')"> ( '.k_add_account.' ) </span></span>';
				}?>
				</div><?				
				if($acc){
					echo '<div class="f1 fs16 lh40">'.k_insure_comp_prices.' : '.$insue_name.'</div>';
					echo '<div class="f1 fs14 lh20 clr5">'._info_c142m975tv.'</div>';

				}		
				if($mood==1){					
					$q='';
					if($addNewServis){
						$lastSrvs=get_vals('gnr_x_insurance_rec','service_x',"visit='$vis' and mood='$mood' ");
						if($lastSrvs){$q=" and id NOT IN ($lastSrvs)";}
					}
					$sql="select * from cln_x_visits_services where visit_id='$vis' $q ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows){
						if($acc && $rows>1){$ch='<th width="30"></th>';}
						if($acc){$ch2='<th width="30">
							<input type="checkbox" name="" value="1" par="chAll"/></th>';
						}
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">';
						echo '<tr>'.$ch2.'<th>'.k_service.'</th><th>'.k_price_serv.'</th><th>'.k_insure_price.' </th>'.$ch.'</tr>';
						while($r=mysql_f($res)){
							$serv_id=$r['id'];
							$service=$r['service'];							
							$pay_net=$r['pay_net'];
							list($sarvice_name,$hos_part,$doc_part)=get_val('cln_m_services','name_'.$lg.',hos_part,doc_part',$service);
							
							$price=$hos_part+$doc_part;					
							if($doctor){			
								$newPrice=get_docServPrice($doctor,$service,$mood);
								$newP=$newPrice[0]+$newPrice[1];							
								if($newP){$price=$newP;}
							}
							
							$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");
							$oprs='';
							if($price>0 && $pay_net){
								echo '<tr>';
									if($acc){
										echo '<td>';
										if($insurPrice){echo '<input type="checkbox" name="s_'.$serv_id.'"  value="1" par="s"/>';}else{echo '-';}
										echo '</td>';
									}
									
									echo '<td txt>'.$sarvice_name.'</td>
									<td><ff>'.number_format($price).'</ff></td>
									<td><ff>'.number_format($insurPrice).'</ff></td>';
									if($acc && $rows>1){
										echo '<td>';
										if($insurPrice){echo '<div class="ic40 icc2 ic40_del" onclick="delSerINsur('.$serv_id.','.$vis.','.$mood.')"></div>';}
										echo '</td>';
									}
								echo'</tr>';
							}
						}
						echo '</table>';
					}
				}
				if($mood==2){
					$sql="select * from lab_x_visits_services where visit_id='$vis' ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows){
						if($acc && $rows>1){$ch='<th width="30"></th>';}
						if($acc){$ch2='<th></th>';}
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">';
						echo '<tr>'.$ch2.'<th>'.k_service.'</th><th>'.k_test_price.'</th>'.$ch.'</tr>';
						while($r=mysql_f($res)){
							$serv_id=$r['id'];
							$service=$r['service'];				list($sarvice_name,$unit)=get_val('lab_m_services','name_'.$lg.',unit',$service);
							//$unitPrice=_set_5sz4zqpy6k;
							$unitPrice=get_val('gnr_m_insurance_prov','lab_unit_price',$prov_id);
							$price=$unit*$unitPrice;
							
							$oprs='';							
							echo '<tr>';
								if($acc){echo '<td><input type="checkbox" name="s_'.$serv_id.'"  value="1" par="s"/></td>';}
								echo '<td txt>'.$sarvice_name.'</td>
								<td><ff>'.number_format($price).'</ff></td>';					
								if($acc && $rows>1){
									echo '<td><div class="ic40 icc2 ic40_del" onclick="delSerINsur('.$serv_id.','.$vis.','.$mood.')"></div></td>';
								}
							echo'</tr>';
						}
						echo '</table>';
					}
				}
				if($mood==3){
					$q='';
					if($addNewServis){
						$lastSrvs=get_vals('gnr_x_insurance_rec','service_x',"visit='$vis' and mood='$mood' ");
						if($lastSrvs){$q=" and id NOT IN ($lastSrvs)";}
					}
					$sql="select * from xry_x_visits_services where visit_id='$vis' $q ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows){
						if($acc && $rows>1){$ch='<th width="30"></th>';}
						if($acc){$ch2='<th width="30"></th>';}
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">';
						echo '<tr>'.$ch2.'<th>'.k_service.'</th><th>'.k_price_serv.'</th><th>'.k_insure_price.'</th>'.$ch.'</tr>';
						while($r=mysql_f($res)){
							$serv_id=$r['id'];
							$service=$r['service'];							
							
							$pay_net=$r['pay_net'];
							
							list($sarvice_name,$hos_part,$doc_part)=get_val('xry_m_services','name_'.$lg.',hos_part,doc_part',$service);
							
							$price=$hos_part+$doc_part;	$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");
							$oprs='';
							if($price>0 && $pay_net){
								echo '<tr>';
									if($acc){
										echo '<td>';
										if($insurPrice){echo '<input type="checkbox" name="s_'.$serv_id.'"  value="1" par="s"/>';}else{echo '-';}
										echo '</td>';
									}
									
									echo '<td txt>'.$sarvice_name.'</td>
									<td><ff>'.number_format($price).'</ff></td>
									<td><ff>'.number_format($insurPrice).'</ff></td>';
									if($acc && $rows>1){
										echo '<td>';
										if($insurPrice){echo '<div class="ic40 icc2 ic40_del" onclick="delSerINsur('.$serv_id.','.$vis.','.$mood.')"></div>';}
										echo '</td>';
									}
								echo'</tr>';
							}
						}
						echo '</table>';
					}
				}
				if($mood==4){					
					$q='';
					if($addNewServis){
						$lastSrvs=get_vals('gnr_x_insurance_rec','service_x',"visit='$vis' and mood='$mood' ");
						if($lastSrvs){$q=" and id NOT IN ($lastSrvs)";}
					}
					$sql="select * from den_x_visits_services where visit_id='$vis' $q ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows){
						if($acc && $rows>1){$ch='<th width="30"></th>';}
						if($acc){$ch2='<th width="30">
							<input type="checkbox" name="" value="1" par="chAll"/></th>';
						}
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">';
						echo '<tr>'.$ch2.'<th>'.k_service.'</th><th>'.k_price_serv.'</th><th>'.k_insure_price.'</th>'.$ch.'</tr>';
						while($r=mysql_f($res)){
							$serv_id=$r['id'];
							$service=$r['service'];
							$pay_net=$r['pay_net'];
							list($sarvice_name,$hos_part,$doc_part)=get_val('den_m_services','name_'.$lg.',hos_part,doc_part',$service);
							$price=$hos_part+$doc_part;					
							if($doctor){			
								$newPrice=get_docServPrice($doctor,$service,1);
								$newP=$newPrice[0]+$newPrice[1];							
								if($newP){$price=$newP;}
							}
							
							$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");
							$oprs='';
							if($price>0 && $pay_net){
								echo '<tr>';
									if($acc){
										echo '<td>';
										if($insurPrice){echo '<input type="checkbox" name="s_'.$serv_id.'" value="1" par="s"/>';}else{echo '-';}
										echo '</td>';
									}
									
									echo '<td txt>'.$sarvice_name.'</td>
									<td><ff>'.number_format($price).'</ff></td>
									<td><ff>'.number_format($insurPrice).'</ff></td>';
									if($acc && $rows>1){
										echo '<td>';
										if($insurPrice){echo '<div class="ic40 icc2 ic40_del" onclick="delSerINsur('.$serv_id.','.$vis.','.$mood.')"></div>';}
										echo '</td>';
									}
								echo'</tr>';
							}
						}
						echo '</table>';
					}
				}
				if($mood==7){
					$q='';
					if($addNewServis){
						$lastSrvs=get_vals('gnr_x_insurance_rec','service_x',"visit='$vis' and mood='$mood' ");
						if($lastSrvs){$q=" and id NOT IN ($lastSrvs)";}
					}
					$sql="select * from osc_x_visits_services where visit_id='$vis' $q ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows){
						if($acc && $rows>1){$ch='<th width="30"></th>';}
						if($acc){$ch2='<th width="30"></th>';}
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">';
						echo '<tr>'.$ch2.'<th>'.k_service.'</th><th>'.k_price_serv.'</th><th>'.k_insure_price.' </th>'.$ch.'</tr>';
						while($r=mysql_f($res)){
							$serv_id=$r['id'];
							$service=$r['service'];							
							
							$pay_net=$r['pay_net'];
							
							list($sarvice_name,$hos_part,$doc_part)=get_val('osc_m_services','name_'.$lg.',hos_part,doc_part',$service);
							
							$price=$hos_part+$doc_part;	$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$prov_id' and type='$mood' and service='$service' ");
							$oprs='';
							if($price>0 && $pay_net){
								echo '<tr>';
									if($acc){
										echo '<td>';
										if($insurPrice){echo '<input type="checkbox" name="s_'.$serv_id.'"  value="1" par="s"/>';}else{echo '-';}
										echo '</td>';
									}
									
									echo '<td txt>'.$sarvice_name.'</td>
									<td><ff>'.number_format($price).'</ff></td>
									<td><ff>'.number_format($insurPrice).'</ff></td>';
									if($acc && $rows>1){
										echo '<td>';
										if($insurPrice){echo '<div class="ic40 icc2 ic40_del" onclick="delSerINsur('.$serv_id.','.$vis.','.$mood.')"></div>';}
										echo '</td>';
									}
								echo'</tr>';
							}
						}
						echo '</table>';
					}
				}
				
				?>
			</form>
		</div>
		<div class="form_fot fr">
			<? if($acc){?>
				<div class="bu bu_t1 fl" onclick="sendInsurReq()"><?=k_create?></div>
			<? }?>
			<div class="bu bu_t3 fl" onclick="insurReqCancle(<?=$id?>,<?=$mood?>)"><?=k_cancel?></div>					
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
	}
}*/?>