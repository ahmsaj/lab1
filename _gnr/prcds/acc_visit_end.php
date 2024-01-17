<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['mod'])){
	$v_id=pp($_POST['vis']);
	$mood=pp($_POST['mod']);
	$table=$visXTables[$mood];
	$table2=$srvXTables[$mood];
	$table3=$srvTables[$mood];
	$visData=getRec($table,$v_id);
	if($visData['r']){
		$patient=$visData['patient'];
		$clinic=$visData['clinic'];
		$doc=$visData['doctor'];
		$ray_tec=$visData['ray_tec'];
		$d_start=$visData['d_start'];
		$v_pay_type=$visData['pay_type'];
		$reg_user=$visData['reg_user'];
		$dts_id=$visData['dts_id'];
		$status=$visData['status'];
		
		if(isset($_POST['opr'])){
			$opr=pp($_POST['opr']);
			$p1=pp($_POST['p1'],'s');
			if(isset($_POST['save'])){
				if($opr==1){
					$oldS=get_val($table2,'status',$p1);
					$s=$_POST['s'];
					$sql="UPDATE $table2 set status ='$s' where id='$p1' and visit_id='$v_id'";
					mysql_q($sql);
					if($oldS==2 && $s==5){
						servPayAler($p1,$mood);
					}
				}
				if($opr==2){
					$q='';
					if(in_array($mood,array(1,5,6))){$q=" ,doc='$doc' ";}
					$sql="UPDATE $table2 set status =1 $q where status=0 and visit_id='$v_id' ";
					mysql_q($sql);
				}
				if($opr==3){
					$s=$_POST['s'];
					$sql="UPDATE $table set pay_type='$s' where status=1 and id='$v_id'";
					mysql_q($sql);
				}
				if($opr==4){					
					if(mysql_q("UPDATE $table set status=2 , d_finish='$now' where id='$v_id' and status!=3")){
                        fixWorkTime($v_id,$mood);
						mysql_q("UPDATE $table2 set d_finish='$now' where visit_id='$v_id' ");
						if(_set_ruqswqrrpl){makeSerPayAlert($v_id,$mood);}
						mysql_q("UPDATE gnr_x_roles set status=4 where vis='$v_id' and mood='$mood' ");
						mysql_q("delete FROM  $table2 where visit_id='$v_id' and status=2 ");
						mysql_q("DELETE from gnr_x_visits_timer where visit_id='$v_id' and mood='$mood' ");					
						if($dts_id>0){mysql_q("UPDATE dts_x_dates SET status='4' , d_end_r='$now' where id ='$dts_id' ");}						
						mysql_q("INSERT INTO gnr_x_visit_end (vis,doc,user,clinic,vis_date,end_date)values('$v_id','$doc','$thisUser','$clinic','$d_start','$now')");
						if($mood==1){fixVisitSevesCln($v_id);}
						if($mood==3){fixVisitSevesXry($v_id);}
						if($mood==5){fixVisitSevesBty($v_id,5);}
						if($mood==7){fixVisitSevesOsc($v_id);}
					}
				}
				if($opr==5){
					$doc=$_POST['doc'];
					$sql="UPDATE $table set doctor='$doc' where status=1 and id='$v_id'";
					mysql_q($sql);					
				}
				if($opr==6){
					$tec=$_POST['tec'];
					$sql="UPDATE $table set ray_tec='$tec' where status=1 and id='$v_id'";
					mysql_q($sql);					
				}
			}else{
				$oprTitle=array('',
				k_srv_status_chng
				,k_end_vis_srvcs
				,k_visit_pay_type_chng
				,k_vis_no_end
				,k_edit_vis_no_doc
				,k_vis_no_tech_edit)?>
				<div class="win_body">
				<div class="form_header so lh40 clr1 f1 fs18 "><?=$oprTitle[$opr]?> <ff class="clr5"> ( <?=$p1?> ) </ff></div>
				<div class="form_body" type="static">
				<form name="accVis" id="accVis" action="<?=$f_path?>X/gnr_acc_visit_end.php" method="post" cb="accvisOprDone(<?=$mood?>,<?=$v_id?>,<?=$opr?>)" >
					<input type="hidden" name="mod" value="<?=$mood?>"/>
					<input type="hidden" name="vis" value="<?=$v_id?>"/>
					<input type="hidden" name="opr" value="<?=$opr?>"/>
					<input type="hidden" name="save" value="1"/>
					<input type="hidden" name="p1" value="<?=$p1?>"/>
					<?
					if($opr==1){
						$r=getRec($table2,$p1);
						if($r['r']){
							$s_status=$r['status'];
							$service=get_val($table3,'name_'.$lg,$r['service']);
							$ss=array(k_undone,
							k_complete,
							k_srv_req_paym,
							k_cncled,
							k_request_cancellation,
							k_postpaid_srv
							);
							echo '<div class="f1 fs16 lh40 ">'.$service.'</div>
							<div class="radioBlc">';
							foreach($ss as $k=>$s){
								$ck='';
								if($k==$s_status){$ck=' checked ';}
							 echo '<input type="radio" name="s" '.$ck.' value="'.$k.'"/><label>'.$s.'</label>';
							}
							echo '</div>';
						}
					}
					if($opr==2){
						$r=getRec($table,$v_id);
						if($r['r']){
							echo '<div class="f1 fs18 clr5">'.k_save_all_new_srvcs.'</div>';}
						}
					if($opr==3){
						$r=getRec($table,$v_id);
						if($r['r']){
							$pay_type=$r['pay_type'];							
							$ss=array(k_vnorm,
							k_exemption,
							k_charity,
							k_insurance,
							);
							echo '
							<div class="radioBlc">';
							foreach($ss as $k=>$s){
								$ck='';
								if($k==$pay_type){$ck=' checked ';}
							 echo '<input type="radio" name="s" '.$ck.' value="'.$k.'"/><label>'.$s.'</label>';
							}
							echo '</div>';
						}
					}
					if($opr==4){
						$r=getRec($table,$v_id);
						if($r['r']){
							echo '<div class="f1 fs18 clr5">'.k_save_visit_note_ctrl.'</div>';}
						}					
					if($opr==5){
						$r=getRec($table,$v_id);
						if($r['r']){
							$doctor=$r['doctor'];
							$clinic=$r['clinic'];
							echo make_Combo_box('_users','name_'.$lg,'id'," where grp_code in('7htoys03le','nlh8spit9q') and FIND_IN_SET($clinic,`subgrp`) >0 ",'doc',0,$doctor,' t ');
						}
					}
					if($opr==6){
						$r=getRec($table,$v_id);
						if($r['r']){
							$doctor=$r['doctor'];
							$clinic=$r['clinic'];
							echo make_Combo_box('_users','name_'.$lg,'id'," where grp_code in('1ceddvqi3g','nlh8spit9q') and  FIND_IN_SET($clinic,`subgrp`) > 0",'tec',1,$ray_tec,' t ');
						}
					}
					?>
				<form>
				</div>
				<div class="form_fot fr">
					<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
					<div class="bu bu_t3 fl" onclick="sub('accVis');"><?=k_save?></div>
				</div>
				</div><?
			}
			
		}else{
			$msg='';?>
			<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs18 "><ff class="clr5"><?=$v_id?> | </ff><?=get_p_name($patient)?>
			<div class="fr ic40 icc1 ic40_ref" onclick="endVisAcc(<?=$mood?>,<?=$v_id?>)"></div></div>
			<div class="form_body" type="static">
				<div class="fr l_bord pd10" fix="wp%:40|hp:0">
					<div class="f1 fs18 b_bord lh40 clr1" fix="wp:40|h:40"><?=k_payms?></div>
					<div class="fl ofx so" fix="wp:0|hp:80">
						<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
						<tr><th><?=k_date?></th><th><?=k_box?></th><th><?=k_type?></th><th><?=k_amount?></th></tr>
						<?
						$pt=0;
						$sql="select * from gnr_x_acc_payments where vis='$v_id' and type !=5 and mood like '$mood%' order by id ASC ";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){			
							while($r=mysql_f($res)){
								$p_id=$r['id'];
								$type=$r['type'];
								$amount=$r['amount'];
								$date=$r['date'];
								$casher=$r['casher'];
								if(in_array($type,array(1,2,6,7))){
									$pay_o=1;
									$pt+=$amount;
								}
								if(in_array($type,array(3,4,8))){
									$pt-=$amount;
									$pay_o=2;
								}
								?>
								<tr>
								<td><ff><?=dateToTimeS3($date)?></ff></td>
								<td class="f1"><?=get_val('_users','name_'.$lg,$casher)?></td>
								<td><span class="f1" style="color:<?=$payArry_col[$type]?>"><?=$payArry[$type]?></span></td>
								<td><? 
								
								echo '<ff>'.$amount.'</ff>';
								?></td>
								</tr><?
							}
						}		
						?>
						</table>
					</div>
					<div class="fl t_bord cbg4 lh40 clr1 TC" fix="wp:0|h:40"><ff><?=number_format($pt)?></ff></div>
				</div>
				<div class="fr l_bord pd10" fix="wp%:40|hp:0">
					<div class="f1 fs18 b_bord lh40  clr1" fix="wp:0|h:40"><?=k_services?>
					<? if($status!=2){
						if(getTotalCO($table2,"visit_id='$v_id' and  status=0 ")){
							echo '<div class="ic40x icc1 ic40_done fr" onclick="accvisOpr(2,'.$v_id.')"></div>';
						}
					}?>
					</div>
					<div class="fl ofx so" fix="wp:0|hp:80"><?
					$openServices=0;
					$sql="select * from $table2 where visit_id='$v_id' order by id ASC ";			
					$res=mysql_q($sql);
					$rows=mysql_n($res);	
					if($rows>0){?>
						<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
						<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_total?></th><th><?=k_monetary?></th><th><?=k_status?></th></tr>
						<?
												
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
								$pay_type=$r['pay_type'];
								if(in_array($s_status,array(0,4))){$openServices++;}
								$revTxt=$insurTxt='';
								if($rev){$revTxt='<div class="clr5 f1">'.k_review.'</div>';}
								if($pay_type==3){$insurTxt='<div class="clr6 f1">'.k_review.'</div>';}
								if(in_array($s_status,array(0,1,4))){
									$srv_total+=$pay_net;
								}
								$action='';
								if($status!=2){$action ='onclick="accvisOpr(1,'.$s_id.')"';}?>
								<tr bgcolor="<?=$ser_status_color[$s_status]?>">
								<td><ff>#<?=$s_id?></ff></td>
								<td class="f1 fs14"><?=get_val($table3,'name_'.$lg,$service).$revTxt.$insurTxt?>
								<? if($cType==3){echo '<div class="f1 clr5">'.get_val('_users','name_'.$lg,$s_doc).'</div>';}?></td>

								<td><ff class="clr1"><?=$total_pay?></ff></td>
								<td><ff class="clr5"><?=$pay_net?></ff></td>
								<td class="f1 Over" <?=$action?> bgcolor="<?=$ser_status_color[$s_status]?>"><?=$ser_status_Tex[$s_status]?></td>
								</tr><?
							}
						}
						?>
						</table>
						<? 
						/*if($pay_type==3){
							$sql="select * from gnr_x_insur_pay_back where visit='$v_id' and mood=$cType  order by id ASC ";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){	
								?><div class="f1 fs18 clr5 lh40">مستحقات المريض التأمينية</div>
								<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
								<tr>
									<th>التاريخ</th>
									<th>رقم الخدمة</th>					
									<th>الرقم التأميني</th>					
									<th>المبلغ</th>
								</tr><?
								while($r=mysql_f($res)){			
									$amount=$r['amount'];
									$mood=$r['mood'];
									$date=$r['date'];
									$insur_rec=$r['insur_rec'];
									$service_x=$r['service_x'];														
									?>
									<tr>
									<td><ff><?=dateToTimeS3($date)?></ff></td>
									<td><ff>#<?=$service_x?></ff></td>
									<td><ff>#<?=get_val('gnr_x_insurance_rec','insur_no',$insur_rec)?></ff></td>
									<td><ff><?=$amount?></ff></td>
									</tr><?
								}
								?></table><?
							}

							$sql="select * from gnr_x_insurance_rec where visit='$v_id' and mood=$cType  order by id ASC ";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){	
								?><div class="f1 fs18 clr1 lh40">السجلات التأمنية</div>
								<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
								<tr>
									<th>التاريخ</th>
									<th>رقم الخدمة</th>					
									<th>الرقم التأميني</th>					
									<th>سعر الخدمة</th>
									<th>السعر التأميني</th>
									<th>المشمول</th>
									<th>رقم الفاتورة</th>
									<th>حالة التأمين</th>					
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
									$in_status=$r['status'];
									$service_x=$r['service_x'];
									$res_status=$r['res_status'];
									if($res_status){$res_statusTxt='<div></div>';}
									?>
									<tr>
									<td><ff><?=dateToTimeS3($date)?></ff></td>
									<td><ff>#<?=$service_x?></ff></td>
									<td><ff>#<?=$insur_no?></ff></td>
									<td><ff><?=$price?></ff></td>
									<td><ff><?=$in_price?></ff></td>
									<td><ff><?=$in_price_includ?></ff></td>
									<td><ff><?=$ref_no?></ff></td>
									<td><ff class="f1 fs16 <?=$insurStatusColArr[$res_status]?>"><?=$reqStatusArr[$res_status]?></ff></td>
									</tr><?
								}
								?></table><?
							} 
						}*/
					}
	?>.
					</div>
					<div class="fl t_bord cbg4 lh40 clr1 TC" fix="wp:0|h:40"><ff><?=number_format($srv_total)?></ff></div>
				</div>
				<div class="fr pd10" fix="wp%:20|hp:0">
					<div class="f1 fs18 b_bord lh40  clr1" fix="wp:0|h:40"><?=k_visit_details?></div>
					<div class="fl ofx so" fix="wp:0|hp:40">
						<div class="f1 fs16 lh30"><?=k_tclinic?> : <span class="f1 fs16 clr5 lh40"><?=get_val('gnr_m_clinics','name_'.$lg,$clinic)?></span></div>
						<?
						$action='';
						if($status!=2){$action ='accvisOpr(5,'.$s_id.')';}?>
						<div class="f1 fs16 lh30"><?=k_doctor?> : <span class="f1 fs16 clr5 lh40 Over" onclick="<?=$action?>">[<?=get_val('_users','name_'.$lg,$doc)?>]</span></div>
						<? if($mood==3){
							if(!$ray_tec){$msg.=k_must_choose_tech;}
							$action='';
							if($status!=2){$action ='accvisOpr(6,'.$s_id.')';}?>
						<div class="f1 fs16 lh30"><?=k_technician?> : <span class="f1 fs16 clr5 lh40 Over" onclick="<?=$action?>">[<?=get_val('_users','name_'.$lg,$ray_tec)?>]</span></div>
						<? }else{
							if(!$doc){$msg.=k_must_choose_doc;}
						}?>
						<div class="f1 fs16 lh30"><?=k_date?>  : <ff class="clr5 lh40" dir="ltr"><?=date('Y-m-d A h:i ',$d_start)?></ff></div>
						<? $action='';
						if($status!=2){$action ='onclick="accvisOpr(3,'.$v_id.')"';}?>
						<div class="f1 fs16 lh30 b_bord"><?=k_pay_type?> : <span class="f1 fs16 clr6 lh40 Over" <?=$action?> ><?=$pay_types[$v_pay_type]?></span></div>
						<?
						if($pt-$srv_total!=0){
							echo '<div class="f1 fs16 lh40 clr5">'.k_visit_unblncd.'</div>';
						}else{
							if($openServices==0 && $status==1){echo '<div class="bu buu bu_t3" onclick="accvisOpr(4,'.$v_id.')">'.k_endvis.'</div>';}else{
							echo '<div class="f1 fs14 clr5 lh30">'.$msg.'</div>';
							}
						}
						?>
					</div>
				</div>			
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
			</div>
			</div><?
		}
	}
}?>