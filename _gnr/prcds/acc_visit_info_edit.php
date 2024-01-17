<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$editAct=$chPer[2];
	$delAct=$chPer[3];
	?><div class="win_body"><?
	$cType=pp($_POST['type']);
	$table=$visXTables[$cType];
	$table2=$srvXTables[$cType];
	$table3=$srvTables[$cType];
	if($cType==1){$page='cln_acc_visit_review';$delMod='j6jsbp9aoo';}	
	if($cType==3){$page='xry_acc_visit_review';$delMod='naqdmumgtz';}
	if($cType==4){$page='den_acc_visit_review';$delMod='bct9ym02ku';}
	if($cType==5){$page='bty_acc_visit_review';$delMod='9m2i13k75r';}
	if($cType==7){$page='osc_acc_visit_review';$delMod='ntno1memur';}
    
	if(isset($_POST['v_id'],$_POST['type'])){
        $v_id=pp($_POST['v_id']);
        logOpr($v_id,2,$delMod);		
		if(isset($_POST['missDoc'])){		
			$missDoc=pp($_POST['missDoc']);
			if($missDoc && $editAct){
				$clinic=get_val($table,'clinic',$v_id);
				$doc_clinic=get_val('_users','subgrp',$missDoc);
				if($clinic== $doc_clinic){
					if(mysql_q("UPDATE $table SET doctor='$missDoc' where doctor=0 and id='$v_id' ")){
						mysql_q("UPDATE $table2 SET doc='$missDoc' where  visit_id='$v_id' ");
						echo 1;
					}
				}
			}
		}else{
			$sql="select * from $table where id='$v_id'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);	
			if($rows>0){
				$r=mysql_f($res);
				$pay_type=$r['pay_type'];
				$clinic=$r['clinic'];
				//$cType=get_val('gnr_m_clinics','type',$clinic);
				$status=$r['status'];
				if($pay_type==0 && $status==2){
					$sql="select * from $table2 where visit_id='$v_id' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$s_id=$r['id'];					
							$hp=pp($_POST['ser_'.$s_id.'_hp']);
							$dp=pp($_POST['ser_'.$s_id.'_dp']);
							$dpr=pp($_POST['ser_'.$s_id.'_dpr'],'f');
							$net=$hp+$dp;
							$total_pay=$hp+$dp;					
							mysql_q("UPDATE $table2 set hos_part='$hp' ,doc_part='$dp' ,doc_percent='$dpr' , pay_net='$net' , total_pay='$total_pay' where id='$s_id'");
							
						}
						if($cType==1){fixVisitSevesCln($v_id);}
						if($cType==3){fixVisitSevesXry($v_id);}
						if($cType==5){fixVisitSevesBty($v_id,5);}
						if($cType==7){fixVisitSevesOsc($v_id);}
					}
				}
				$sql="select * from gnr_x_acc_payments where vis='$v_id' and mood=$cType and type not in(5,10) order by id ASC ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$p_id=$r['id'];
						$am=$_POST['pay_'.$p_id];
						mysql_q("UPDATE gnr_x_acc_payments set amount='$am'  where id='$p_id' and mood=$cType ");
					}
				}
				//fixVisitSevesCln($v_id);
			}echo 1;
		}
		exit;
	}else{
		if(isset($_POST['id'],$_POST['type'])){
			if($cType==2){
				$table='lab_x_visits';
				$table2='lab_x_visits_services';
				$table3='lab_m_services';
				if(isset($_POST['id'],$_POST['type'])){
				$v_id=pp($_POST['id']);
				$sql="select * from $table where id='$v_id'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$pay_type=$r['pay_type'];
					$d_start=$r['d_start'];
					$emplo=$r['emplo'];
					$pay_type_link=$r['pay_type_link'];
					if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';}
					$charTxt='';
					if($pay_type==2){
						$charTxt=' ( '.get_val('gnr_m_charities','name_'.$lg,$pay_type_link).' )';
					}
					$status=$r['status'];?>
					<div class="form_header f1 fs16 lh30">
					<div class="fr"><ff14 class="clr5" <? if($editAct){echo 'v_id="'.$v_id.'" t="'.$cType.'"';}?>><?=date('Y-m-d A h:i',$d_start)?></ff14></div>
					<ff14><?=$v_id?></ff14> | <?=k_patient?> : <?=get_p_name($patient).$emploTxt?> | 
						<span style="color:<?=$lab_vis_sClr[$status]?>" class="f1 fs16"><?=$lab_vis_s[$status]?></span>
						<? if($pay_type){echo'<div class="f1 fs16 clr5 lh30">'.k_pay_type.' : '.$pay_types[$pay_type].$charTxt.'</div>';}?>
					</div>
					<div class="form_body so" type="full">
					<form name="acc_form" id="acc_form" action="<?=$f_path.'X/gnr_acc_visit_info_edit.php'?>" method="post"
					 cb="loadFitterCostom('<?=$page?>')" bv="">
					<input type="hidden" name="v_id" value="<?=$v_id?>" />
					<input type="hidden" name="type" value="<?=$cType?>" />
					<table width="100%" border="0" cellspacing="0" cellpadding="10" class="bord">
					<tr>
                        <td class="f1 fs16 cbg4 TC"><?=k_thtests?></td>
                        <td  class="f1 fs16 cbg4 TC l_bord"><?=k_payms?></td></tr>
                    <tr>                        
                    <td valign="top" class=" cbg444"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th width="30">#</th><th><?=k_analysis?></th><th><?=k_num_of_units?></th>
					<th><?=k_price_unit?></th><th><?=k_price?></th><th><?=k_paid_up?></th><th><?=k_status?></th></tr>
					<?
					$sql="select * from $table2 where visit_id='$v_id' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){				
						$unitsTotal=0;
						$total_payTotal=0;
						$pay_netTotal=0;
						while($r=mysql_f($res)){
							$s_id=$r['id'];
							$service=$r['service'];
							$units=$r['units'];
							$units_price=$r['units_price'];
							$total_pay=$r['total_pay'];
							$s_status=$r['status'];					
							$pay_net=$r['pay_net'];                            
							if($s_status!=3){
								$unitsTotal+=$units;
								$total_payTotal+=$total_pay;
								$pay_netTotal+=$pay_net;
							}
							list($aName,$anCode)=get_val($table3,'name_'.$lg.',short_name',$service);
							$anaName=$aName.'<div class="ff fs14 clr5 B">'.$anCode.'</div>';
							?>
							<tr>
							<td><ff14>#<?=$s_id?></ff14></td>
							<td class="f1"><?=$anaName?></td>
							<td><ff14><?=number_format($units)?></ff14></td>
							<td><ff14><?=number_format($units_price)?></ff14></td>					
							<td><ff14 class="clr1"><?=number_format($total_pay)?></ff14></td>
							<td><ff14 class="clr6"><?=number_format($pay_net)?></ff14></td>
							<td><div class="f1" style="color:<?=$anStatus_col[$s_status]?>"><?=$anStatus[$s_status]?></div></td>
							</tr><?
						}
					}?>
						<tr bgcolor="#eee">
						<td colspan="2" txt><?=k_total?></td>				
						<td><ff14><?=number_format($unitsTotal)?></ff14></td>
						<td>-</td>					
						<td><ff14 class="clr1"><?=number_format($total_payTotal)?></ff14></td>
						<td><ff14 class="clr6"><?=number_format($pay_netTotal)?></ff14></td>
						<td>-</td>
						</tr>
					</table>
					</td><td valign="top"  class=" cbg444 l_bord">
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th><?=k_date?></th><th><?=k_box?></th><th><?=k_type?></th><th><?=k_amount?></th></tr>
					<?
					$pay_total=0;
					$sql="select * from gnr_x_acc_payments where vis='$v_id' and type not in(5,10) and mood='$cType' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){			
						while($r=mysql_f($res)){
							$p_id=$r['id'];
							$type=$r['type'];
							$amount=$r['amount'];
							$date=$r['date'];
							$casher=$r['casher'];
                            $p_type=$r['pay_type'];
							if(in_array($type,array(1,2))){
								$pay_o=1;
								$pay_total+=$amount;
							}
							if(in_array($type,array(3,4))){
								$pay_total-=$amount;
								$pay_o=2;
							}
							?>
							<tr>
							<td><ff14><?=dateToTimeS3($date)?></ff14></td>
							<td class="f1"><?=get_val('_users','name_'.$lg,$casher)?></td>
							<td><span class="f1" style="color:<?=$payArry_col[$type]?>"><?=$payArry[$type]?></span>
                                <div class="f1" style="color:<?=$payTypePClr[$p_type]?>"><?=$payTypeP[$p_type]?></div></td>
							<td><? 
							if($pay_type || $status!=2){
								echo '<ff14 style="color:'.$payTypePClr[$p_type].'">'.number_format($amount).'</ff14>';
							}else{
								?><input name="pay_<?=$p_id?>" pay="<?=$pay_o?>" type="number" value="<?=$amount?>" style="width:220px;"/><? 
							}?></td>
							</tr><?
						}
					}		
					?>
					</table>
					</td></tr>
					<tr><td  class="cbg4 TC"><ff14 id="ser_tot"><?=number_format($pay_netTotal)?></ff14></td>
                        <td class="cbg4 TC l_bord"><ff14 id="pay_tot"><?=number_format($pay_total)?></ff14></td></tr>
					</table>
					</form>
					<? if($pay_type==3){
						$sql="select * from gnr_x_insur_pay_back where visit='$v_id' and mood=$cType  order by id ASC ";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){	
							?><div class="f1 fs18 clr5 lh40"><?=k_pat_insure_benefits?></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
							<tr>
								<th><?=k_date?></th>
								<th><?=k_num_serv?> </th>					
								<th><?=k_insurance_no?> </th>					
								<th><?=k_amount?></th>
							</tr><?
							while($r=mysql_f($res)){			
								$amount=$r['amount'];
								$mood=$r['mood'];
								$date=$r['date'];
								$insur_rec=$r['insur_rec'];
								$service_x=$r['service_x'];														
								?>
								<tr>
								<td><ff14><?=dateToTimeS3($date)?></ff14></td>
								<td><ff14>#<?=$service_x?></ff14></td>
								<td><ff14>#<?=get_val('gnr_x_insurance_rec','insur_no',$insur_rec)?></ff14></td>
								<td><ff14><?=$amount?></ff14></td>
								</tr><?
							}
							?></table><?
						}

						$sql="select * from gnr_x_insurance_rec where visit='$v_id' and mood=$cType  order by id ASC ";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){	
							?><div class="f1 fs18 clr1 lh40"><?=k_insure_recs?></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
							<tr>
								<th><?=k_date?></th>
								<th><?=k_num_serv?></th>					
								<th><?=k_insurance_no?> </th>					
								<th><?=k_price_serv?> </th>
								<th><?=k_insure_price?></th>
								<th><?=k_includ?></th>
								<th><?=k_bill_number?></th>
								<th><?=k_insurance_status?></th>					
							</tr><?
							while($r=mysql_f($res)){			
								$amount=$r['amount'];
								$mood=$r['mood'];
								$date=$r['s_date'];
								$insur_no=$r['insur_no'];
								$price=$r['price'];
								$in_price=$r['in_price'];
								$in_price_includ=$r['in_price_includ'];
								$ref_no=$r['ref_no'];
								$status=$r['status'];
								$service_x=$r['service_x'];
								$res_status=$r['res_status'];
								if($res_status){$res_statusTxt='<div></div>';}
								?>
								<tr>
								<td><ff14><?=dateToTimeS3($date)?></ff14></td>
								<td><ff14>#<?=$service_x?></ff14></td>
								<td><ff14>#<?=$insur_no?></ff14></td>
								<td><ff14><?=number_format($price)?></ff14></td>
								<td><ff14><?=number_format($in_price)?></ff14></td>
								<td><ff14><?=number_format($in_price_includ)?></ff14></td>
								<td><ff14><?=$ref_no?></ff14></td>
								<td><ff14 class="f1 <?=$insurStatusColArr[$res_status]?>"><?=$reqStatusArr[$res_status]?></ff14></td>
								</tr><?
							}
							?></table><?
						} 
					}?>
					</div><?
				}
			}

			}else 
			if($cType==6){
				$v_id=pp($_POST['id']);
				$sql="select * from $table where id='$v_id'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);	
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];
					//$cType=get_val('gnr_m_clinics','type',$clinic);
					$pay_type=$r['pay_type'];
					$d_start=$r['d_start'];
					$emplo=$r['emplo'];
					$vis_shoot=$r['vis_shoot'];
					$vis_shoot_r=$r['vis_shoot_r'];
					$price=$r['price'];
					$dis=$r['dis'];
					$total=$r['total'];
					$total_pay=$r['total_pay'];
					$mac_s=$r['mac_s'];
					$mac_e=$r['mac_e'];
					if($mac_s!=$mac_e){$delAct=0;}
					if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span> ';}
					$charTxt='';
					/*if($pay_type==2){
						$charTxt=' ( '.get_val('gnr_m_charities','name_'.$lg,$pay_type_link).' )';
					}*/
					$status=$r['status'];
					
					echo '
					<div class="form_header f1 fs16 lh30">
					<div class="fr ic40 icc1 ic40_ref" onclick="showAcc('.$v_id.','.$cType.')" title="'.k_refresh.'"></div>
					<div class="fr lh40"><ff14 class="clr5" ';
					if($editAct){echo 'v_id="'.$v_id.'" t="'.$cType.'"';}?> > <?=date('Y-m-d A h:i',$d_start);
					echo'</ff14></div>
					<ff14>'.$v_id.'</ff14> | '.k_patient.' : '.get_p_name($patient).$emploTxt.' | 
					<span class="f1 fs16 clr1"';
					if($editAct){echo 'dv_id="'.$v_id.'" t="'.$cType.'"';}
					echo '>';
					if($doctor){echo k_doctor.' : '.get_val('_users','name_'.$lg,$doctor).' | ';}					
					echo ' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ] 
					</span>|
						<span style="color:'.$stats_arr_col[$status].'" class="f1 fs16">'.$stats_arr[$status].'</span> ';
						if($pay_type){echo'<div class="f1 fs16 clr5 lh30">'.k_pay_type.' : '.$pay_types[$pay_type].$charTxt.'</div>';}

					echo '</div>';?>
					
					<div class="form_body of" type="full">
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
					<tr><th><?=k_services?></th><th><?=k_payms?></th></tr><tr><td valign="top">        
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th><?=k_counters?></th><th><?=k_act_num_strks?></th><th><?=k_tot_strikes?></th><th> <?=k_strike_price?></th>
					<th><?=k_val_of_strks?></th><th><?=k_discount?></th><th> <?=k_final_amnt?></th></tr>
					
					<tr no="<?=$s_id?>" set bgcolor="<?=$ser_status_color[$s_status]?>">
					<td><ff14><?=number_format($mac_s).'<br>'.number_format($mac_e)?></ff14></td>
					<td><ff14><?=number_format($vis_shoot)?></ff14></td>
					<td><ff14><?=number_format($vis_shoot_r)?></ff14></td>
					<td><ff14><?=number_format($price,2)?></ff14></td>
					<td><ff14><?=number_format($total)?></ff14></td>
					<td><ff14 class="clr5"><?=number_format($dis)?></ff14></td>					
					<td><ff14 class="clr6"><?=number_format($total_pay)?></ff14></td>
					</tr>
					</table>
					</td><td valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th><?=k_date?></th><th><?=k_box?></th><th><?=k_type?></th><th><?=k_amount?></th></tr>
					<?
					$pay_total=0;
					$sql="select * from gnr_x_acc_payments where vis='$v_id' and type not in(5,10) and mood='$cType' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){			
						while($r=mysql_f($res)){
							$p_id=$r['id'];
							$type=$r['type'];
							$amount=$r['amount'];
							$date=$r['date'];
							$casher=$r['casher'];
							if(in_array($type,array(1,2))){
								$pay_o=1;
								$pay_total+=$amount;
							}
							if(in_array($type,array(3,4))){
								$pay_total-=$amount;
								$pay_o=2;
							}
							?>
							<tr>
							<td><ff14><?=dateToTimeS3($date)?></ff14></td>
							<td class="f1"><?=get_val('_users','name_'.$lg,$casher)?></td>
							<td><span class="f1" style="color:<?=$payArry_col[$type]?>"><?=$payArry[$type]?></span></td>
							<td><ff14><?=number_format($amount)?></ff14></td>
							</tr><?
						}
					}		
					?>
					</table>
					</td></tr>
					<tr>
                        <td><ff14 id="ser_tot"><?=number_format($total_pay)?></ff14></td>
                        <td><ff14 id="pay_tot"><?=number_format($pay_total)?></ff14></td></tr>
					</table>
					
					<div class="f1 fs18 clr1 lh40"><?=k_dtl_srv?> </div>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th width="30">#</th><th><?=k_service?></th>
					<th> <?=k_body_parts?></th>
					<th>Fluence</th>
					<th><?=k_pulse?></th>
					<th><?=k_rate?></th>
					<th><?=k_wave?></th>
					<th><?=k_num_of_strikes?> </th>
					<th><?=k_tot_strikes?> </th>
					</tr>
					<?
					$sql="select * from $table2 where visit_id='$v_id' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$srv_total=0;
						while($r=mysql_f($res)){
							$s_id=$r['id'];
							$s_doc=$r['doc'];
							$service=$r['service'];
							$s_status=$r['status'];
							$srv_shoots=$r['srv_shoots'];
							$sql2="select * from bty_x_laser_visits_services_vals where serv_x='$s_id' order by id ASC ";
							$res2=mysql_q($sql2);
							$rows2=mysql_n($res2);
							$ii=0;
							while($r2=mysql_f($res2)){
								$part=$r2['part'];
								$v_fluence=$r2['v_fluence'];
								$v_pulse=$r2['v_pulse'];
								$v_rep_rate=$r2['v_rep_rate'];
								$v_wave=$r2['v_wave'];
								$counter=$r2['counter'];
								echo '<tr>';
								if($ii==0){
									echo '<td rowspan="'.$rows2.'"><ff14>#'.$s_id.'</ff14></td>
									<td class="f1"  rowspan="'.$rows2.'">'.get_val($table3,'name_'.$lg,$service).'</td>';
								}
								echo '
								<td class="f1">'.get_val('bty_m_visits_services_parts','name_'.$lg,$part).'</td>
								<td><ff14>'.$v_fluence.'</ff14></td>
								<td><ff14>'.$v_pulse.'</ff14></td>
								<td><ff14>'.$v_rep_rate.'</ff14></td>
								<td><ff14>'.$v_wave.'</ff14></td>
								<td><ff14>'.number_format($counter).'</ff14></td>
								';
								if($ii==0){
									echo '<td rowspan="'.$rows2.'"><ff14 class="clr1">'.number_format($srv_shoots).'</ff14></td>';
								}
								echo '</tr>';
								$ii++;
							}		
						}
					}
					?>
					</table>
					</div>
					<?
				}
			}else 
			if($cType==4){
				$v_id=pp($_POST['id']);
				$sql="select * from $table where id='$v_id'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);	
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];
					//$cType=get_val('gnr_m_clinics','type',$clinic);
					$pay_type=$r['pay_type'];
					$d_start=$r['d_start'];
					$emplo=$r['emplo'];
					$pay_type_link=$r['pay_type_link'];
					if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';}
					$charTxt='';
					if($pay_type==2){
						$charTxt=' ( '.get_val('gnr_m_charities','name_'.$lg,$pay_type_link).' )';
					}
					$status=$r['status'];?>
					<div class="form_body so" type="pd0">				
					<div class="r_bord  fl " fix="wp%:20|hp:0">
						<div class="lh50 clr1 uLine f1 fs18 pd10"><?=k_thvisit?>  [ <?=get_val('gnr_m_clinics','name_'.$lg,$clinic)?> ] <ff14>( <?=$v_id?> )</ff14>
							<div class="fr ic40x icc1 ic40_ref" onclick="showAcc(<?=$v_id?>,<?=$cType?>)" title="<?=k_refresh?>"></div>
						</div>
						<div class="fox so pd10" fix="hp:70"><? 
							echo '<div class="lh30 f1 fs16"><ff14>'.$patient.'</ff14> | '.get_p_name($patient).$emploTxt.'
							</div>';							
							echo '<div class="lh30 f1 fs16 " denOpr="4" n="'.$v_id.'" a="'.$editAct.'" v="'.$v_id.'
							">'.k_doctor.' : ';
							if($doctor){echo get_val('_users','name_'.$lg,$doctor);}
							echo'</div>';											
							echo '<div class="lh30 f1 fs16 ">'.k_date.' : <ff14 class="clr5" dir="ltr" denOpr="1" 
							n="'.$v_id.'" a="'.$editAct.'" v="'.$v_id.'">'.date('Y-m-d',$d_start).'</ff14></div>';
							
							echo '<div class="lh30 f1 fs16 ">'.k_status.' : 
								<span style="color:'.$stats_arr_col[$status].'" class="f1 fs16">'.$stats_arr[$status].'</span> 
							</div>';
							
							if($pay_type){
							echo '<div class="lh30 f1 fs16">'.k_pay_type.' : 
							'.$pay_types[$pay_type].$charTxt.'
							</div>';
							}

							?>
						</div>
					</div>
					<div class="r_bord fl" fix="wp%:40|hp:0">
						<div class="lh50 clr1 uLine f1 fs18 pd10"><?=k_the_proced?></div>
						<div class="fox so pd10" fix="hp:70"><?
							$sql="select * from den_x_visits_services where visit_id='$v_id' order by d_start DESC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){								
								while($r=mysql_f($res)){
									$s_id=$r['id'];
									$service=$r['service'];
									$doc=$r['doc'];									
									$d_start=$r['d_start'];
									$d_finish=$r['d_finish'];
									$teeth=$r['teeth'];
									$srv_status=$r['status'];
									$teethTxt='';
									if($teeth){$teethTxt=' <ff14 class="clr5" dir="ltr"> ('.$teeth.')</ff14>';}
									$srvTxt=get_val_arr('den_m_services','name_'.$lg,$service,'s');
									$docTxt=get_val_arr('_users','name_'.$lg,$doc,'doc');
									?>
									<div class="f1 fs16 lh30 clr1"><ff14><?=$s_id?></ff14> | <?=$srvTxt.$teethTxt?></div>
									<div class="fl f1 fs16 lh40 w100">
										<div class="fl f1 fs16 lh30 r_bord pd5" denOpr="5" n="<?=$s_id?>" a="<?=$editAct?>" v="<?=$v_id?>"><?=k_doctor?> : <?=$docTxt?> </div>
										<? if($srv_status==1){?>
										<div class="fl f1 fs16 lh30 pd5"><?=k_ending?> : 
										<ff14 class="clr5" dir="ltr" denOpr="2" 
							n="<?=$s_id?>" a="<?=$editAct?>" v="<?=$v_id?>"><?=date('Y-m-d',$d_finish)?></ff14></div>
										<? }?>
									</div>
									<div class="fl w100 uLine"><?
									$sql2="select * from den_x_visits_services_levels where x_srv='$s_id' order by id ASC";
									$res2=mysql_q($sql2);
									$rows2=mysql_n($res2);
									if($rows2>0){						
										while($r2=mysql_f($res2)){
											$l_id=$r2['id'];
											$lev=$r2['lev'];
											$docl=$r2['doc'];											
											$le_date=$r2['date'];
											$le_date_e=$r2['date_e'];											
											$l_status=$r2['status'];

											$levTxt=get_val_arr('den_m_services_levels','name_'.$lg,$lev,'lev');
											$docTxtLev=get_val_arr('_users','name_'.$lg,$docl,'doc');

											$recCol="cbg4";
											$statusTxt=k_level_not_worked_on;
											if($l_status==1){
												$recCol="cbg7";
												$statusTxt=k_wrkng;
												$statusTxt.='<br>'.k_doctor.' : '.$docTxtLev;
											}
											if($l_status==2){
												$recCol="cbg666";
												$statusTxt=k_ended_on.'  <ff14 dir="ltr" class="fs14">'.date('Y-m-d',$le_date).'</ff14>';
												$statusTxt.='<br>'.k_doctor.' : '.$docTxtLev;
											}?>
											<div class="fl w100 lh30  b_bord <?=$recCol?>">
												<div class="fl f1 fs14 lh30 r_bord pd5"><ff14>#<?=$l_id?> | </ff14><?=$levTxt?></div>
												<? if($l_status==2){?>				
												<div class="fl f1 fs14 lh30 r_bord pd5" denOpr="6" n="<?=$l_id?>" a="<?=$editAct?>" v="<?=$v_id?>"><?=k_doctor?> : <?=$docTxtLev?> </div>
												<div class="fl f1 fs14 lh30 pd5"><?=k_ending?> : <ff14 class="clr5" dir="ltr" denOpr="3" 
							n="<?=$l_id?>" a="<?=$editAct?>" v="<?=$v_id?>"><?=date('Y-m-d',$le_date_e)?></ff14> </div>
												<? }?>
											</div><?
										}
									}
									?></div><?
								}
							}else{?>
								<div class="f1 fs16 clr5 lh40"><?=k_no_srvcs?></div><?
							}?>							
						</div>
					</div>
					<div class="fl ofx so" fix="wp%:35|hp:0">
						<div class="lh50 clr1 uLine f1 fs18 pd10"> <?=k_pat_payms?></div>
						<div class="fox so" fix="hp:70"><?
							$sql="select * from gnr_x_acc_patient_payments where patient='$patient' order by date DESC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){?>				
								<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">	
								<tr>
									<th>#</th>
									<th width="120"><?=k_date?></th>
									<th><?=k_doctor?></th>
									<th><?=k_pay_type?></th>
									<th><?=k_paym?></th>
									<? if($thisGrp=='pfx33zco65'){?><th width="40"></th><? }?>
								</tr><?
								$pay=0;
								while($r=mysql_f($res)){
									$pay_id=$r['id'];
									$amount=$r['amount'];
									$date=$r['date'];
									$type=$r['type'];
									$p_doc=$r['doc'];
									$PdocTxt=get_val_arr('_users','name_'.$lg,$p_doc,'doc');
									$srvNet=0;
									if($type==2){$pay-=$amount;}else{$pay+=$amount;}?>
									<tr>
										<td><ff14>#<?=$pay_id?></ff14></td>
										<td><ff14 denOpr="7" n="<?=$pay_id?>" a="<?=$editAct?>" v="<?=$v_id?>"><?=date('Y-m-d',$date)?></ff14></td>
										<td><div class="f1 fs14 <?=$patPaymentClr[$type]?>"><?=$patPayment[$type]?></td>
										<td txt denOpr="8" n="<?=$pay_id?>" a="<?=$editAct?>" v="<?=$v_id?>"><?=$PdocTxt?></td>
										<td><ff14 class="clr1" denOpr="9" n="<?=$pay_id?>" a="<?=$editAct?>" v="<?=$v_id?>"><?=number_format($amount)?></ff14></td>
									</tr><?
								}?>
								</table><?
							}else{?>
								<div class="f1 fs16 clr5 lh40"><?=k_no_payms?> </div><?
							}?>
							
						</div>
					</div>
					
					<?
					$editDoc=0;
					if($doctor==0 && $editAct){
						if(get_val('gnr_m_clinics','type',$clinic)!=3){
							$editDoc=1;
							echo '<div class="f1 fs16 clr1">'.k_doc_choos.'</div>';
							echo  make_Combo_box('_users','name_'.$lg,'id'," where subgrp='$clinic' ",'missDoc');
							echo '<div class="bu bu_t1 " onclick="sub(\'acc_form\')" fix="w:150">'.k_save.'</div>';
						}
					}?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
					<tr><th><?=k_services?></th><th><?=k_payms?></th></tr><tr><td valign="top">        
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_perc_doc?></th>
					<th><?=k_thpreview?></th><th><?=k_procedure?></th><th><?=k_total?></th><th><?=k_monetary?></th><th><?=k_status?></th></tr>
					<?
					$sql="select * from $table2 where visit_id='$v_id' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$srv_total=0;
						while($r=mysql_f($res)){
							$s_id=$r['id'];
							$s_doc=$r['doc'];
							$service=$r['service'];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];
							$doc_percent=$r['doc_percent'];
							$s_status=$r['status'];
							$total_pay=$r['total_pay'];
							$pay_net=$r['pay_net'];
							$rev=$r['rev'];
							$revTxt='';
							if($rev){$revTxt='<div class="clr5 f1">'.k_review.'</div>';}
							//$net_pay=$hos_part+$doc_part;				
							if($s_status!=3){
								$srv_total+=$pay_net;
								if($pay_type || $status!=2){?>
									<tr bgcolor="<?=$ser_status_color[$s_status]?>">
									<td><ff14>#<?=$s_id?></ff14></td>
									<td class="f1 fs14"><?=get_val($table3,'name_'.$lg,$service).$revTxt?>
									<? if($cType==3){echo '<div class="f1 clr5">'.get_val('_users','name_'.$lg,$s_doc).'</div>';}?></td>
									<td><ff14><?=$doc_percent?>%</ff14></td>
									<td><ff14><?=number_format($hos_part)?></ff14></td>
									<td><ff14><?=number_format($doc_part)?></ff14></td>
									<td><ff14 class="clr1"><?=number_format($total_pay)?></ff14></td>
									<td><ff14 class="clr5"><?=number_format($pay_net)?></ff14></td>
									<td class="f1" bgcolor="<?=$ser_status_color[$s_status]?>"><?=$ser_status_Tex[$s_status]?></td>
									</tr><?
								}else{?>
									<tr no="<?=$s_id?>" set bgcolor="<?=$ser_status_color[$s_status]?>">
									<td><ff14>#<?=$s_id?></ff14></td>
									<td class="f1 fs14"><?=get_val($table3,'name_'.$lg,$service).$revTxt?>
									<? if($cType==3){echo '<div class="f1 clr5">'.get_val('_users','name_'.$lg,$s_doc).'</div>';}?></td>
									<td>%<input name="ser_<?=$s_id?>_dpr" type="number" value="<?=$doc_percent?>" style="width:50px;"/></td>
									<td><input name="ser_<?=$s_id?>_hp" t="srv" type="number" value="<?=$hos_part?>" style="width:100px;"/></td>
									<td><input name="ser_<?=$s_id?>_dp" t="srv" type="number" value="<?=$doc_part?>" style="width:100px;"/></td>							
									<td class="ff fs18 f1 B clr1" id="t_<?=$s_id?>"><?=$total_pay?></td>
									<td><ff14 class="clr5"><?=number_format($pay_net)?></ff14></td>
									<td class="f1" ><?=$ser_status_Tex[$s_status]?></td>
									</tr><?
								}
							}else{?>
								<tr bgcolor="#FFCCCC">
								<td><ff14>#<?=$s_id?></ff14></td>
								<td class="f1"><?=get_val($table3,'name_'.$lg,$service)?>
								<? if($cType==3){echo '<div class="f1 clr5">'.get_val('_users','name_'.$lg,$s_doc).'</div>';}?></td>
								<td><ff14><?=$doc_percent?>%</ff14></td>
								<td><ff14><?=number_format($hos_part)?></ff14></td>
								<td><ff14><?=number_format($doc_part)?></ff14></td>						
								<td><ff14 class="clr1"><?=number_format($total_pay)?></ff14></td>
								<td><ff14 class="clr5"><?=number_format($pay_net)?></ff14></td>
								<td class="f1" bgcolor="<?=$ser_status_color[$s_status]?>"><?=$ser_status_Tex[$s_status]?></td>
								</tr><?
							}
						}
					}
					?>
					</table>
					</td><td valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th><?=k_date?></th><th><?=k_box?></th><th><?=k_type?></th><th><?=k_amount?></th></tr>
					<?
					$pay_total=0;
					$sql="select * from gnr_x_acc_payments where vis='$v_id' and type not in(5,10) and mood like '$cType%' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){			
						while($r=mysql_f($res)){
							$p_id=$r['id'];
							$type=$r['type'];
							$amount=$r['amount'];
							$date=$r['date'];
							$casher=$r['casher'];
							if(in_array($type,array(1,2))){
								$pay_o=1;
								$pay_total+=$amount;
							}
							if(in_array($type,array(3,4))){
								$pay_total-=$amount;
								$pay_o=2;
							}
							?>
							<tr>
							<td><ff14><?=dateToTimeS3($date)?></ff14></td>
							<td class="f1"><?=get_val('_users','name_'.$lg,$casher)?></td>
							<td><span class="f1" style="color:<?=$payArry_col[$type]?>"><?=$payArry[$type]?></span></td>
							<td><? 
							if($pay_type || $status!=2){
								echo '<ff14>'.$amount.'</ff14>';
							}else{
								?><input name="pay_<?=$p_id?>" pay="<?=$pay_o?>" type="number" value="<?=$amount?>" style="width:60px;"/><? 
							}?></td>
							</tr><?
						}
					}		
					?>
					</table>
					</td></tr>
					<tr>
                        <td><ff14 id="ser_tot"><?=$srv_total?></ff14></td>
                        <td><ff14 id="pay_tot"><?=$pay_total?></ff14></td></tr>
					</table>
					
					<? if($pay_type==3){
						$sql="select * from gnr_x_insur_pay_back where visit='$v_id' and mood=$cType  order by id ASC ";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){	
							?><div class="f1 fs18 clr5 lh40"><?=k_pat_insure_benefits?></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
							<tr>
								<th><?=k_date?></th>
								<th><?=k_num_serv?></th>					
								<th><?=k_insurance_no?></th>					
								<th><?=k_amount?></th>
							</tr><?
							while($r=mysql_f($res)){			
								$amount=$r['amount'];
								$mood=$r['mood'];
								$date=$r['date'];
								$insur_rec=$r['insur_rec'];
								$service_x=$r['service_x'];														
								?>
								<tr>
								<td><ff14><?=dateToTimeS3($date)?></ff14></td>
								<td><ff14>#<?=$service_x?></ff14></td>
								<td><ff14>#<?=get_val('gnr_x_insurance_rec','insur_no',$insur_rec)?></ff14></td>
								<td><ff14><?=number_format($amount)?></ff14></td>
								</tr><?
							}
							?></table><?
						}

						$sql="select * from gnr_x_insurance_rec where visit='$v_id' and mood=$cType  order by id ASC ";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){	
							?><div class="f1 fs18 clr1 lh40"><?=k_insure_recs?></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
							<tr>
								<th><?=k_date?></th>
								<th><?=k_num_serv?></th>					
								<th><?=k_insurance_no?></th>					
								<th><?=k_price_serv?></th>
								<th><?=k_insure_price?></th>
								<th><?=k_includ?></th>
								<th><?=k_bill_number?></th>
								<th><?=k_insurance_status?></th>					
							</tr><?
							while($r=mysql_f($res)){			
								$amount=$r['amount'];
								$mood=$r['mood'];
								$date=$r['s_date'];
								$insur_no=$r['insur_no'];
								$price=$r['price'];
								$in_price=$r['in_price'];
								$in_price_includ=$r['in_price_includ'];
								$ref_no=$r['ref_no'];
								$status=$r['status'];
								$service_x=$r['service_x'];
								$res_status=$r['res_status'];
								if($res_status){$res_statusTxt='<div></div>';}
								?>
								<tr>
								<td><ff14><?=dateToTimeS3($date)?></ff14></td>
								<td><ff14>#<?=$service_x?></ff14></td>
								<td><ff14>#<?=$insur_no?></ff14></td>
								<td><ff14><?=number_format($price)?></ff14></td>
								<td><ff14><?=number_format($in_price)?></ff14></td>
								<td><ff14><?=number_format($in_price_includ)?></ff14></td>
								<td><ff14><?=$ref_no?></ff14></td>
								<td><ff14 class="f1 <?=$insurStatusColArr[$res_status]?>"><?=$reqStatusArr[$res_status]?></ff14></td>
								</tr><?
							}
							?></table><?
						} 
					}?>
					</div><?
				}
			}else{
				$v_id=pp($_POST['id']);
				$sql="select * from $table where id='$v_id'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);	
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$clinic=$r['clinic'];
					//$cType=get_val('gnr_m_clinics','type',$clinic);
					$pay_type=$r['pay_type'];
					$d_start=$r['d_start'];
					$emplo=$r['emplo'];			
					$pay_type_link=$r['pay_type_link'];
					if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';}
					$charTxt='';
					if($pay_type==2){
						$charTxt=' ( '.get_val('gnr_m_charities','name_'.$lg,$pay_type_link).' )';
					}
					$status=$r['status'];

					echo '
					<div class="form_header f1 fs16 lh30">
					<div class="fr ic40 icc1 ic40_ref" onclick="showAcc('.$v_id.','.$cType.')" title="'.k_refresh.'"></div>
					<div class="fr lh40"><ff14 class="clr5"';
					if($editAct){echo 'v_id="'.$v_id.'" t="'.$cType.'"';}?>><?=date('Y-m-d A h:i',$d_start);
					echo'</ff14></div>
					<ff14>'.$v_id.'</ff14> | '.k_patient.' : '.get_p_name($patient).$emploTxt.' | 
					<span class="f1 fs16 clr1"';
					if($editAct){echo 'dv_id="'.$v_id.'" t="'.$cType.'"';}
					echo '>';
					if($doctor){echo k_doctor.' : '.get_val('_users','name_'.$lg,$doctor).' | ';}
					if($cType==3){echo k_technician.' : '.get_val('_users','name_'.$lg,$ray_tec);}
					echo ' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ] 
					</span>|
						<span style="color:'.$stats_arr_col[$status].'" class="f1 fs16">'.$stats_arr[$status].'</span> ';
						if($pay_type){echo'<div class="f1 fs16 clr5 lh30">'.k_pay_type.' : '.$pay_types[$pay_type].$charTxt.'</div>';}

					echo '</div>';?>
					<div class="form_body so" type="full">
					<form name="acc_form" id="acc_form" action="<?=$f_path.'X/gnr_acc_visit_info_edit.php'?>" method="post"
					 cb="loadFitterCostom('<?=$page?>')" bv="">
					<input type="hidden" name="v_id" value="<?=$v_id?>" />
					<input type="hidden" name="type" value="<?=$cType?>" /><?
					$editDoc=0;
					if($doctor==0 && $editAct){
						if(get_val('gnr_m_clinics','type',$clinic)!=3){
							$editDoc=1;							
							echo '<div class="f1 fs16 clr1">'.k_doc_choos.'</div>';
							echo  make_Combo_box('_users','name_'.$lg,'id'," where subgrp='$clinic' ",'missDoc');
							echo '<div class="bu bu_t1 " onclick="sub(\'acc_form\')" fix="w:150">'.k_save.'</div>';
						}
					}?>
					<table width="100%" border="0" cellspacing="0" cellpadding="10" class="bord">
					<tr>
                        <td class="f1 fs16 cbg4 TC"><?=k_services?></td>
                        <td  class="f1 fs16 cbg4 TC l_bord"><?=k_payms?></td></tr><tr>
                    <td valign="top" class=" cbg444">        
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_perc_doc?></th>
					<th><?=k_thpreview?></th><th><?=k_procedure?></th><th><?=k_total?></th><th><?=k_monetary?></th><th><?=k_status?></th></tr>
					<?
					$sql="select * from $table2 where visit_id='$v_id' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$srv_total=0;
						while($r=mysql_f($res)){
							$s_id=$r['id'];
							$s_doc=$r['doc'];
							$service=$r['service'];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];
							$doc_percent=$r['doc_percent'];
							$s_status=$r['status'];
							$total_pay=$r['total_pay'];
							$pay_net=$r['pay_net'];
							$rev=$r['rev'];
							$revTxt='';
							if($rev){$revTxt='<div class="clr5 f1">'.k_review.'</div>';}
							//$net_pay=$hos_part+$doc_part;				
							if($s_status!=3){
								$srv_total+=$pay_net;
								if($pay_type || $status!=2){?>
									<tr bgcolor="<?=$ser_status_color[$s_status]?>">
									<td><ff14>#<?=$s_id?></ff14></td>
									<td txtS><?=get_val($table3,'name_'.$lg,$service).$revTxt?>
									<? if($cType==3){echo '<div class="f1 clr5">'.get_val('_users','name_'.$lg,$s_doc).'</div>';}?></td>
									<td><ff14><?=$doc_percent?>%</ff14></td>
									<td><ff14><?=number_format($hos_part)?></ff14></td>
									<td><ff14><?=number_format($doc_part)?></ff14></td>
									<td><ff14 class="clr1"><?=number_format($total_pay)?></ff14></td>
									<td><ff14 class="clr5"><?=number_format($pay_net)?></ff14></td>
									<td txtS class="f1" bgcolor="<?=$ser_status_color[$s_status]?>"><?=$ser_status_Tex[$s_status]?></td>
									</tr><?
								}else{?>
									<tr no="<?=$s_id?>" set bgcolor="<?=$ser_status_color[$s_status]?>">
									<td><ff14>#<?=$s_id?></ff14></td>
									<td txtS><?=get_val($table3,'name_'.$lg,$service).$revTxt?>
									<? if($cType==3){echo '<div class="f1 clr5">'.get_val('_users','name_'.$lg,$s_doc).'</div>';}?></td>
									<td>%<input name="ser_<?=$s_id?>_dpr" type="number" value="<?=$doc_percent?>" style="width:50px;"/></td>
									<td><input name="ser_<?=$s_id?>_hp" t="srv" type="number" value="<?=$hos_part?>" style="width:100px;"/></td>
									<td><input name="ser_<?=$s_id?>_dp" t="srv" type="number" value="<?=$doc_part?>" style="width:100px;"/></td>							
                                        <td>
                                            <ff14 id="t_<?=$s_id?>"><?=number_format($total_pay)?></ff14>
                                        </td>
									<td><ff14 class="clr5"><?=number_format($pay_net)?></ff14></td>
									<td txtS><?=$ser_status_Tex[$s_status]?></td>
									</tr><?
								}
							}else{?>
								<tr bgcolor="#FFCCCC">
								<td><ff14>#<?=$s_id?></ff14></td>
								<td class="f1"><?=get_val($table3,'name_'.$lg,$service)?>
								<? if($cType==3){echo '<div class="f1 clr5">'.get_val('_users','name_'.$lg,$s_doc).'</div>';}?></td>
								<td><ff14><?=$doc_percent?>%</ff14></td>
								<td><ff14><?=number_format($hos_part)?></ff14></td>
								<td><ff14><?=number_format($doc_part)?></ff14></td>						
								<td><ff14 class="clr1"><?=number_format($total_pay)?></ff14></td>
								<td><ff14 class="clr5"><?=number_format($pay_net)?></ff14></td>
								<td txtS bgcolor="<?=$ser_status_color[$s_status]?>"><?=$ser_status_Tex[$s_status]?></td>
								</tr><?
							}
						}
					}
					?>
					</table>
					</td><td valign="top" class=" cbg444 l_bord">
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					<tr><th><?=k_date?></th><th><?=k_box?></th><th><?=k_type?></th><th><?=k_amount?></th></tr>
					<?
					$pay_total=0;
					$sql="select * from gnr_x_acc_payments where vis='$v_id' and type not in(5,10) and mood like '$cType%' order by id ASC ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){			
						while($r=mysql_f($res)){
							$p_id=$r['id'];
							$type=$r['type'];
							$amount=$r['amount'];
							$date=$r['date'];
							$casher=$r['casher'];
                            $p_type=$r['pay_type'];
							if(in_array($type,array(1,2,7))){
								$pay_o=1;
								$pay_total+=$amount;
							}
							if(in_array($type,array(3,4))){
								$pay_total-=$amount;
								$pay_o=2;
							}
							?>
							<tr>
							<td><ff14><?=dateToTimeS3($date)?></ff14></td>
							<td txtS><?=get_val('_users','name_'.$lg,$casher)?></td>
							<td txtS><span class="f1" style="color:<?=$payArry_col[$type]?>"><?=$payArry[$type]?></span>
                                <div class="f1" style="color:<?=$payTypePClr[$p_type]?>"><?=$payTypeP[$p_type]?></div></td>
							<td><? 
							if($pay_type || $status!=2){
								echo '<ff14 style="color:'.$payTypePClr[$p_type].'">'.number_format($amount).'</ff14>';
							}else{
								?><input name="pay_<?=$p_id?>" pay="<?=$pay_o?>" type="number" value="<?=$amount?>" style="width:100px;"/><? 
							}?></td>
							</tr><?
						}
					}		
					?>
					</table>
					</td></tr>
					<tr>
                        <td class=" cbg4 TC"><ff14 id="ser_tot"><?=number_format($srv_total)?></ff14></td>
                        <td class=" cbg4 TC l_bord"><ff14 id="pay_tot"><?=number_format($pay_total)?></ff14></td></tr>
					</table>
					</form>
					<? if($pay_type==3){
						$sql="select * from gnr_x_insur_pay_back where visit='$v_id' and mood=$cType  order by id ASC ";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){	
							?><div class="f1 fs18 clr5 lh40"><?=k_pat_insure_benefits?></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
							<tr>
								<th><?=k_date?></th>
								<th><?=k_num_serv?></th>					
								<th><?=k_insurance_no?></th>					
								<th><?=k_amount?></th>
							</tr><?
							while($r=mysql_f($res)){			
								$amount=$r['amount'];
								$mood=$r['mood'];
								$date=$r['date'];
								$insur_rec=$r['insur_rec'];
								$service_x=$r['service_x'];														
								?>
								<tr>
								<td><ff14><?=dateToTimeS3($date)?></ff14></td>
								<td><ff14>#<?=$service_x?></ff14></td>
								<td><ff14>#<?=get_val('gnr_x_insurance_rec','insur_no',$insur_rec)?></ff14></td>
								<td><ff14><?=$amount?></ff14></td>
								</tr><?
							}
							?></table><?
						}

						$sql="select * from gnr_x_insurance_rec where visit='$v_id' and mood=$cType  order by id ASC ";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){	
							?><div class="f1 fs18 clr1 lh40"><?=k_insure_recs?></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
							<tr>
								<th><?=k_date?></th>
								<th><?=k_num_serv?></th>					
								<th><?=k_insurance_no?></th>					
								<th><?=k_price_serv?></th>
								<th><?=k_insure_price?></th>
								<th><?=k_includ?></th>
								<th><?=k_bill_number?></th>
								<th><?=k_insurance_status?></th>					
							</tr><?
							while($r=mysql_f($res)){			
								$amount=$r['amount'];
								$mood=$r['mood'];
								$date=$r['s_date'];
								$insur_no=$r['insur_no'];
								$price=$r['price'];
								$in_price=$r['in_price'];
								$in_price_includ=$r['in_price_includ'];
								$ref_no=$r['ref_no'];
								$status=$r['status'];
								$service_x=$r['service_x'];
								$res_status=$r['res_status'];
								if($res_status){$res_statusTxt='<div></div>';}
								?>
								<tr>
								<td><ff14><?=dateToTimeS3($date)?></ff14></td>
								<td><ff14>#<?=$service_x?></ff14></td>
								<td><ff14>#<?=$insur_no?></ff14></td>
								<td><ff14><?=number_format($price)?></ff14></td>
								<td><ff14><?=number_format($in_price)?></ff14></td>
								<td><ff14><?=number_format($in_price_includ)?></ff14></td>
								<td><ff14><?=($ref_no)?></ff14></td>
								<td><div class="f1  <?=$insurStatusColArr[$res_status]?>"><?=$reqStatusArr[$res_status]?></div></td>
								</tr><?
							}
							?></table><?
						} 
					}?>
					</div><?
				}
			}
		}
	}?>
	<div class="form_fot fr" >
		<? if($pay_type==0 && $status==2 && $editDoc==0 && $editAct && $cType!=6 && $cType!=4){?><div class="bu bu_t1 fl" onclick="chechAccCal()"><?=k_save?></div><? }?>
		<? if($delAct){?><div class="bu bu_t3 fl" onclick="delVisAcc(<?=$v_id?>,<?=$cType?>,0);" ><?=k_delete?></div><? }?>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');" ><?=k_close?></div>
	</div>
	</div><?
}
?>
