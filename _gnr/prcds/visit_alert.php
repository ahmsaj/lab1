<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['mood'])){
	$vis=pp($_POST['vis']);
	$mood=pp($_POST['mood']);
	$balans=0;
	$err=0;
	
	$table=$visXTables[$mood];
	$table2=$srvXTables[$mood];
	$r=getRec($table,$vis);
	if($r['r']){
		$p=$r['patient'];
		$s=$r['status'];
		$c=$r['clinic'];
		$d=$r['doctor'];
		$pt=$r['pay_type'];
		$ss=$r['sub_status'];
		?>
		<div class="win_body"><?
			if($mood==4){?>
				<div class="form_header so lh40 clr1 f1 fs18">
                    <div class="fr ic40 icc1 ic40_ref" title="<?=k_refresh?>"  onclick="srvAlertPay(<?=$vis?>,<?=$mood?>)"></div>
                    <div class="fr ic40 icc2 ic40_report" title="<?=k_account_stats?>" onclick="accStat(<?=$p?>)"></div><ff><?=$p?> | </ff>
                    <?=get_p_name($p)?>
				</div>
				<div class="form_body of" type="pd0"><?
					if($p){
						$ptTxt='';
						if($pt){$ptTxt=' [ '.$pay_types[$pt].' ] '; }?>
						<div class="fr l_bord pd10" fix="wp%:70|hp:0">
						<div class="f1 fs16 lh50 clr11 uLine"> <?=k_visit_srvcs?> <ff> ( <?=$vis?> ) </ff> 
						<span class="f1 fs16 clr5"><?=$ptTxt?></span></div>
							<div class="f1 fs16 lh50 clr11 ofx so" fix="hp:124">
							<?
							$sql="select * from den_x_visits_services where visit_id='$vis' order by d_start DESC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){?>				
								<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">		
								<tr>
									<th width="120"><?=k_date?></th>
									<th><?=k_service?></th>
									<th><?=k_val_srv?> </th>
								</tr><?
								$t1=$t2=$t3=0;
								while($r=mysql_f($res)){
									$service=$r['service'];
									$total_pay=$r['total_pay'];
									$d_start=$r['d_start'];
									$end_percet=$r['end_percet'];
									$srvTxt=get_val_arr('den_m_services','name_'.$lg,$service,'s');
									$srvNet=0;
									if($end_percet){
										$srvNet=$total_pay*$end_percet/100;
									}
									$t1+=$total_pay;
									$t2+=$end_percet;
									$t3+=$srvNet;
									?>
									<tr>
									<td><ff><?=date('Y-m-d',$d_start)?></ff></td>
									<td txt><?=$srvTxt?></td>
									<td><ff class="clr1"><?=number_format($total_pay)?></ff></td>
									</tr><?
								}?>
								</table><?
							}else{?>
								<div class="f1 fs16 clr5 lh40"><?=k_no_srvcs?></div><?
							}?>
							</div>
							<div class="f1 fs16 lh50 t_bord">
								<? if($pt==0 && $rows){?>
								<div class="bu bu_t1 fl w-auto " onclick="chgPayType(2,<?=$vis?>,<?=$mood?>)"><?=k_charity?></div>
								<div class="bu bu_t1 fl w-auto" onclick="chgPayType(3,<?=$vis?>,<?=$mood?>)"><?=k_insurance?></div>
								<div class="bu bu_t1 fl w-auto" onclick="patOfferWin(<?=$mood?>,<?=$vis?>,<?=$p?>)"><?=k_offers?></div>
								<? } ?>
							</div>
						</div>
						<div class="fl pd10" fix="wp%:30|hp:0">
							<div class="f1 fs16 lh50 clr11 uLine"><?=k_pat_balance?></div>
							<div class="f1 fs16 lh50 clr11 ofx so" fix="hp:174"><?
							$sql="select * from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood' order by date ASC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);

							$srvs=get_sum('den_x_visits_services','total_pay',"patient='$p'");
							$lastPay=patDenPay($p);
							$bal=$srvs-$lastPay;
							$r=mysql_f($res);
							$balans=$r['amount'];					
							if($balans>0){$text=k_pat_shld_pay;$c="4";}
							if($balans<0){$text=k_ret_amnt_to_pat;$c="3"; $balans=$balans*(-1);}
							if($balans==0){$text=k_pat_shld_pay;$c="4";}
							?>
							<table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s holdH">
							<tr>
								<td class="f1 fs14 lh40 b_bord"><?=k_val_srvs?> : </td>
								<td class="TC" width="100"><ff class="clr1"><?=number_format($srvs)?></ff></td>
							</tr>					
							<tr>
								<td class="f1 fs14 lh40 b_bord"><?=k_prev_pays?>  :</td>
								<td class="TC"><ff class="clr5"><?=number_format($lastPay)?></ff></td>
							</tr>
							<tr>
								<td class="f1 fs14 lh40 b_bord"><?=k_balance?> :</td>
								<td class="TC"><ff class="clr6"><?=number_format($bal)?></ff></td>
							</tr>
							<tr fot>
								<td class="f1 fs14 lh40 b_bord"><?=k_proposed_amount_by_doc?>  :</td>
								<td class="TC"><ff><?=$balans?></ff></td>
							</tr>
							</table>
							</div>

							<div class="f1 fs16 lh50 t_bord">
								<? 
								if($pt==0 || ($pt!=0 && $ss==1)){
									$payIn=min($balans,$bal);
									if($payIn<0){$payIn=0;}
									?>
									<div class="fl f1 fs16 lh40 TC" fix="w:120"><?=k_doctor?> : </div>
									<? 
									$docs=get_vals('den_x_visits_services','doc',"patient='$p'");
									$docs.=','.$d;?>
									<div class="fl lh50" fix="wp:120"><?
										echo make_Combo_box('_users','name_'.$lg,'id'," where id IN($docs)",'docs',1,$d,'t');?>		
									</div>

									<div class="fl bu bu_t4  fl" fix="w:120" onclick="denForwardPay(<?=$vis?>,<?=$p?>);"> <?=k_pymt?> </div>
									<div class="fl" fix="wp:120" style="padding-top: 6px"><input type="number" value="<?=$payIn?>" fix="h:43" id="denPay" max="<?=$bal?>"/></div><? 
								}else{
									echo '<div class="f1 fs16 clr5 lh60">'.k_req_in_prgrs.'</div>';
								}?>
							</div>

						</div><?
					}else{
						$err=1;
						mysql_q("DELETE from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood'");
						echo '<div class="fs18 f1 clr5 lh40">'.k_missing_visit_alert_delete.'</div>';
					}?>
				</div>
				<div class="form_fot fr">
					<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
				</div><?
			}else{?>
				<div class="form_header so lh40 clr1 f1 fs18">
				<?=get_p_name($p)?>
				<div class="f1 fs16 lh30 clr11"><?=k_visit_status?> <ff>(<?=$vis?>)</ff>: <?=$stats_arr[$s]?></div>
				</div>
				<div class="form_body so"><?
					if($p){?>
						<div class="f1 fs16 lh40 clr1"><?=get_val('_users','name_'.$lg,$d).' [ '.get_val('gnr_m_clinics','name_'.$lg,$c).' ]'?></div><?
						$q="and  status=1";
						
                        if($mood==6){	
                            $sql="select * from gnr_x_visits_services_alert where $aq visit_id='$vis' $q and mood='$mood' order by date ASC";
                            $sql="select * from $table2 where visit_id='$vis' and status=5 ";
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows>0){												
								$r=getRec('bty_x_laser_visits',$vis);
								$all_total=$r['total'];
								$all_amount=$r['total_pay'];
								$dis=$r['dis'];
								$pay_type=$r['pay_type'];
								$note=$r['note'];
								$all_total-=$dis;
								if($note){echo '<div class="f1 fs14 clr5">'.k_notes.' : '.$note.'</div>';}
								?>
								<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static">
									<tr><td txt><?=k_prev_count?> </td>
									<td><ff class="fs24"><?=number_format($r['mac_s'])?></ff></td></tr>
									<tr><td txt> <?=k_curr_count?></td>
									<td><ff class="fs24"><?=number_format($r['mac_e'])?></ff></td></tr>
									<tr><td txt><?=k_num_of_strikes?> </td>
									<td><ff class="fs24 clr1"><?=number_format($r['vis_shoot_r'])?></ff></td></tr>
									<tr><td txt><?=k_strike_price?> </td>
									<td><ff class="fs24 clr11"><?=number_format($r['price'])?></ff></td></tr>
									<? if($dis){?>
									<tr><td txt><?=k_discount?></td>
									<td><ff class="fs24 clr5"><?=number_format($dis)?></ff></td></tr>
									<?}?>
									<tr><td txt> <?=k_tot_amount?> </td>
									<td><?=number_format($all_total)?>
									<ff class="fs24 clr5"><?=number_format($all_amount)?></ff></td></tr>
								</table><?
                            }
						}else{
                            $sql="select * from $table2 where visit_id='$vis' and status=5 ";
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows>0){
								$all_add=0;
								$all_del=0;
								$all_insur=0;
								echo '
								<div class="f1 fs14 clr1111 lh40">'.k_postpaid_srvcs.'</div>
								<table width="100%" type="static" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0">
								<tr><th>'.k_service.'</th><th width="120">'.k_amount.'</th></tr>';						
								while($r=mysql_f($res)){			
									$a_visit_id=$r['visit_id'];
									$a_clinic=$r['clinic'];
									$a_doc=$r['doc'];
									$a_service=$r['service'];
									$a_amount=$r['pay_net'];
									$a_patient=$r['patient'];
									$a_date=$r['date'];
									$status=$r['status'];									
									$serName=get_val($srvTables[$mood],'name_'.$lg,$a_service);
									
									$all_add+=$a_amount;
									echo '<tr >														
										<td class="f1 fs14">'.$serName.'</td>
										<td><ff>'.number_format($a_amount).'</ff></td>
										</tr>';		
								}
								echo '<tr class="cbg4">									
									<td class="f1 fs14">'.k_total.'</td>							
									<td class="cbg6"><ff class="clrw">'.number_format($all_add).'</ff></td>

								</tr>';	
								echo '</table>';
                            }
                            /*****************************/
                            $sql="select * from $table2 where visit_id='$vis' and status=4 ";
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows){
                                echo '
                                <div class="f1 fs14 clr1111 lh40">'.k_srvcs_cncld.' </div>
                                <table width="100%" type="static" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0">
                                <tr><th></th><th>'.k_service.'</th><th width="120">'.k_amount.'</th></tr>';						
                                while($r=mysql_f($res)){			
                                    $a_visit_id=$r['visit_id'];
                                    $a_clinic=$r['clinic'];
                                    $a_doc=$r['doc'];
                                    $a_service=$r['service'];
                                    $a_amount=$r['pay_net'];
                                    $a_patient=$r['patient'];
                                    $a_date=$r['d_finish'];														
                                    if($mood==1){$serName=get_val('cln_m_services','name_'.$lg,$a_service);}
                                    if($mood==3){$serName=get_val('xry_m_services','name_'.$lg,$a_service);}
                                    if($mood==5){$serName=get_val('bty_m_services','name_'.$lg,$a_service);}
                                    $all_del+=$a_amount;
                                    echo '<tr >				
                                        <td><ff class="clr5">'.dateToTimeS2($now-$a_date).'</ff></td>
                                        <td class="f1 fs14">'.$serName.'</td>
                                        <td><ff>'.number_format($a_amount).'</ff></td>
                                        </tr>';		
                                }
                                echo '<tr class="cbg4">				
                                    <td></td>
                                    <td class="f1 fs14">'.k_total.'</td>								
                                    <td class="cbg5"><ff class="clrw">'.number_format($all_del).'</ff></td>
                                </tr>';	
                                echo '</table>';
                            }
                            /*****************************/
                            $sql="select * from gnr_x_insur_pay_back where patient='$p' ";
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows){
                                echo '
                                <div class="f1 fs14 clr1111 lh40"> '.k_insure_benefits.'</div>
                                <table width="100%" type="static" border="0" cellspacing="0" cellpadding="4" class="grad_s"over="0" >
                                <tr><th></th><th>'.k_service.'</th><th width="120">'.k_amount.'</th></tr>';						
                                while($r=mysql_f($res)){			
                                    $visit=$r['visit'];
                                    $insur_rec=$r['insur_rec'];
                                    $mood=$r['mood'];
                                    $service_x=$r['service_x'];
                                    $amount=$r['amount'];
                                    $date=$r['date'];
                                    $a_service=get_val($table2,'service',$service_x);
                                    $serName=get_val($srvTables[$mood],'name_'.$lg,$a_service);
                                    $all_insur+=$amount;
                                    echo '<tr >				
                                        <td><ff class="clr5">'.dateToTimeS2($now-$date).'</ff></td>
                                        <td class="f1 fs14">'.$serName.'</td>
                                        <td><ff>'.number_format($amount).'</ff></td>
                                        </tr>';		
                                }
                                echo '<tr class="cbg4">				
                                    <td></td>
                                    <td class="f1 fs14">'.k_total.'</td>
                                    <td class="cbg5"><ff class="clrw">'.number_format($all_insur).'</ff></td>
                                </tr>';	
                                echo '</table>';
                            }
                            /*****************************/
                            $balans=$all_add-$all_del-$all_insur;
                            if($balans>0){$text=k_pat_shld_pay;$c="4";}
                            if($balans<0){$text=k_ret_amnt_to_pat;$c="3"; $balans=$balans*(-1);}
                            if($balans==0){$text=k_stlmnt;$c="1";}							
						}
					}else{
						$err=1;
						mysql_q("DELETE from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood'");
						echo '<div class="fs18 f1 clr5 lh40">'.k_missing_visit_alert_delete.'</div>';

					}?>
					</div>
				<div class="form_fot fr">
					<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div><? 
					if($err==0){
						if($mood==6){
							$chrButt=1;
							$payButt='<div class="bu bu_t4 fl" onclick="forwardPayment('.$vis.','.$all_amount.','.$mood.',0);"> دفع <ff>( '.number_format($all_amount).' )</ff></div>';

							if($pay_type!=0){
								$chrButt=0;
								$ordStatus=getTotalCO('gnr_x_temp_oprs'," vis='$vis' and  mood='$mood' and type=2 ");
								if($ordStatus>0){$payButt='<div class="f1 fs14 clr5 lh40">'.k_cant_get_amnt_bfr_cmplt_char_req.'</div>';}
							}
							echo $payButt;
							/*if($chrButt){
								echo '<div class="bu bu_t1 fl" onclick="chgPayType(2,charities('.$vis.','.$mood.')">'.k_charity.'</div>';
							}
							if($chrButt ){
								echo '<div class="bu bu_t1 fl" onclick="chgPayType(2,'.$vis.','.$mood.')">'.k_charity.'</div>';
							}*/

						}else{?>
							<div class="bu bu_t<?=$c?> fl" onclick="forwardPayment(<?=$vis?>,<?=$balans?>,<?=$mood?>,0);"> <?=$text?> <ff>( <?=number_format($balans)?> )</ff></div><?
						}
					}?>
				</div>
			<? }?>
		</div><?
	}
	
}?>