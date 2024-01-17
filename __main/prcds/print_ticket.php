<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){?>
<? $style_file=styleFiles('P');?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>"><?
	$cType=pp($_GET['type']);
	$id=pp($_GET['id']);
    $xPay=pp($_GET['x'],'s');
	if($cType!=44){resetRles();}
	$id_no=convTolongNo($id,8);
	if($cType==1){	
		$sql="select * from cln_x_visits where id='$id' and status not in (3,5) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];
			$dts_id=$r['dts_id'];
			$dts_date=$r['dts_date'];
			$clinic=$r['clinic'];
			$doctor=$r['doctor'];
			$pay_type_link=$r['pay_type_link'];
			$pay_type=$r['pay_type'];			
			if($x_status==0){addPay1($id,1);}
			$role_no=addRoles($id,$cType);
            $reserveTxt='';
			if($dts_id){                
                if(get_val('dts_x_dates','reserve',$dts_id)){$reserveTxt='<div class="TC B f1 fs18">موعد إحتياطي</div>';}
            }
			if($role_no){
				if(_set_2lgaamrmla){
					$image=getImages(_set_2lgaamrmla);
					$file=$image[0]['file'];
					$folder=$image[0]['folder'];
					list($w,$h)=getimagesize("sData/".$folder.$file);
					$fullfile=$m_path.'upi/'.$folder.$file;
					$logo= '<img src="'.$fullfile.'" width="100%"/>';
				}
				$clinic=$r['clinic'];
				list($clinic_code,$clinicName)=get_val('gnr_m_clinics','code,name_'.$lg,$clinic);
				$d_start=$r['d_start'];
				$patient=$r['patient'];
                $pay=get_sum('cln_x_visits_services','pay_net'," visit_id ='$id' and status not in(3,5)");
                //$pay+=get_sum('gnr_x_acc_payments','commi+differ'," vis ='$id' and mood='$cType'");?>
				<div class="pa_receipt">
					<div class="uLine"><?=$logo?></div><?					
					if($dts_id>0){?>
                        <?=$reserveTxt?>
						<div class="TC B reccp_no2"><?=$role_no?></div><? 
					}else{?>
						<div class="TC B reccp_no"><?=$clinic_code.'-'.$role_no?></div><? 
					}?>
					<div class="baarcode TC"><img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/><div dir="ltr"><?=$cType.'-'.$id?></div></div>
					<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
					<div class="f1 fs16 lh30 TC"><ff><?=$patient?></ff></div>
                    <div class="f1 fs16 lh20 TC"><?=k_clinic?> : <?=$clinicName;?></div>               
					<div class="ff fs16 lh30 TC B" dir="ltr"><?=dateToTimeS3($now)?></div>
					<? if(_set_9ivaiia87g==0){?>
						<div class=" fs12 f1 TC">
						<span class="f1 fs12"><?=k_net_mnt_pd?> :</span>
                    	<span class="ff fs16 B "><?=number_format($pay)?></span> <?=k_sp?></div>
					<? }?>
					<div class="f1 TC lh20"><? if($pay_type==3){ echo ' ----- تأمين ----- ';}?></div>
					 <? if($pay_type==2){?>
					 	<div class="f1 TC lh20"> ----- جمعية ----- </div>
						<div class="f1 TC lh20"><?=get_val('gnr_m_charities','name_'.$lg,$pay_type_link);?></div>
					 <? }?>
					<div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_0e7tea245s?></div>
                </div><?
                if($pay_type==3){
                    $inSur=getTotalCo('gnr_x_insurance_rec',"visit='$id' and status=0");
                    if($inSur){$pay_type=4;}
                }
				delTempOpr($cType,$id,$pay_type);				
			}
		}
	}
	if($cType==2){
		$ammount=pp($_GET['par']);
		$sql="select * from lab_x_visits where id='$id' and status not in (3,5) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];
			$d_start=$r['d_start'];
			$pay_type=$r['pay_type'];
			if($x_status==0){                               
                $payType=1;
                if($xPay=='x'){
                    $payType=4;
                    mysql_q("UPDATE lab_x_visits SET status=1 where status=0 and id='$id' ");
                }else{
                    if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`=1 and mood='$cType' and pay_type=1")){
                        $payType=2;
                        mysql_q("UPDATE lab_x_visits SET status=1 where status=0 and id='$id' ");
                    }
                }
                addPay2($id,$payType,$ammount);
                labJson($id);
            }else{
                //$ammount=getLabAmunt($id);
                labJsonBalUpdate($id);
                //delTempOpr($cType,$id,4);
            }
            $ammount=getLabAmunt($id);
			$req=get_visBal($id);
            //$req+=get_sum('gnr_x_acc_payments','commi+differ'," vis ='$id' and mood='$cType'");
			$role_no=addRoles($id,$cType);
			if($role_no){
				 if(_set_2lgaamrmla){
					$image=getImages(_set_2lgaamrmla);
					$file=$image[0]['file'];
					$folder=$image[0]['folder'];
					list($w,$h)=getimagesize("sData/".$folder.$file);
					$fullfile=$m_path.'upi/'.$folder.$file;
					$logo= '<img src="'.$fullfile.'" width="100%"/>';
				}
				$clinic=get_val_c('gnr_m_clinics','id',2,'type');
				$clinic_code=get_val('gnr_m_clinics','code',$clinic);
				$d_start=$r['d_start'];
				$patient=$r['patient'];				
				list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$patient);
				$birthCount=birthCount($birth);?>
				<div class="pa_receipt">
					<div class="uLine"><?=$logo?></div>
					<div class="ff fs18 lh30 TC B" dir="ltr"><?=dateToTimeS3($d_start)?></div>
					<div class="TC B reccp_no"><?=$clinic_code.'-'.$role_no?></div>
					<div class="baarcode TC">
						<img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/>
						<div dir="ltr"><?=$cType.'-'.$id?></div>
					</div>
					<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
					<div class="f1 fs12 lh20 TC "><?=$sex_types[$sex]?> - <?=$birthCount[0]?> </ff><?=$birthCount[1]?></div>
					<div class=" fs12 f1 TC">
						<span class="f1 fs12"><?=k_net_mnt_pd?> :</span>
						<span class="ff fs16 B "> <?=number_format($ammount)?></span> <?=k_sp?>
					</div><?
					if($req>0){?>
						<div class=" fs12 f1 TC"><span class="f1 fs12"><?=k_rmn_mnt?> :</span>
						<span class="ff fs16 B "> <?=number_format($req)?></span> <?=k_sp?></div><?
					}
					
					list($treq,$anlls)=get_anl_names($id);?>
					<div class="ff fs16 TC recp_note fl " style="width:100%" dir="ltr"><?=$anlls?>&nbsp;</div><?
					if(_set_ou60j0lzz6){?>
						<div class="fl uLine cutLine"><?=$logo?></div>
						<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
						<div class="baarcode TC">
							<img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/>
							<div dir="ltr"><?=$cType.'-'.$id?></div>
						</div><?
						if(_set_t9oxe0fog9){?>
							<div class=" fs12 f1 TC">
								<span class="f1 fs12"><?=k_net_mnt_pd?> :</span>
								<span class="ff fs16 B "> <?=number_format($ammount)?></span> <?=k_sp?>
							</div><?
							if($req>0){?>
								<div class=" fs12 f1 TC"><span class="f1 fs12"><?=k_rmn_mnt?> :</span>
								<span class="ff fs16 B "> <?=number_format($req)?></span> <?=k_sp?></div><?
							}
						}						
					}?>
					<div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_hsw76hw0i?></div>
					<div class="f1 fs12 TC recp_note"><?=k_dte_dlv_res?> : <ff14  dir="ltr"><?=date('Y-m-d',$d_start+(($treq+1)*86400))?></ff14></div>					
				</div><?
                if($pay_type==3){
                    $inSur=getTotalCo('gnr_x_insurance_rec',"visit='$id' and status=0");
                    if($inSur){$pay_type=4;}
                }                
				delTempOpr($cType,$id,$pay_type);                
			}
		}
	}
	if($cType==3){				
		$sql="select * from xry_x_visits where id='$id' and status not in (3,5) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];
			$dts_id=$r['dts_id'];
			$dts_date=$r['dts_date'];
			$clinic=$r['clinic'];
			$doctor=$r['doctor'];
			$pay_type_link=$r['pay_type_link'];
			$pay_type=$r['pay_type'];			
			if($x_status==0){addPay3($id,1);}
			$role_no=addRoles($id,$cType);
			if($role_no){
				if(_set_2lgaamrmla){
					$image=getImages(_set_2lgaamrmla);
					$file=$image[0]['file'];
					$folder=$image[0]['folder'];
					list($w,$h)=getimagesize("sData/".$folder.$file);
					$fullfile=$m_path.'upi/'.$folder.$file;
					$logo= '<img src="'.$fullfile.'" width="100%"/>';
				}
				$clinic=$r['clinic'];
				list($clinic_code,$clinicName)=get_val('gnr_m_clinics','code,name_'.$lg,$clinic);
				$d_start=$r['d_start'];
				$patient=$r['patient'];                
                $pay=get_sum('xry_x_visits_services','pay_net'," visit_id ='$id' and status not in (3,5)");
                //$pay+=get_sum('gnr_x_acc_payments','commi+differ'," vis ='$id' and mood='$cType'");?>
				<div class="pa_receipt">
					<div class="uLine"><?=$logo?></div><?					
					if($dts_id>0){?>
						<div class="TC B reccp_no2"><?=$role_no?></div><? 
					}else{?>
						<div class="TC B reccp_no"><?=$clinic_code.'-'.$role_no?></div><? 
					}?>
					<div class="baarcode TC"><img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/><div dir="ltr"><?=$cType.'-'.$id?></div></div>
					<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
					<div class="f1 fs16 lh30 TC"><ff><?=$patient?></ff></div>
                    <div class="f1 fs16 lh20 TC"><?=k_clinic?> : <?=$clinicName;?></div>               
					<div class="ff fs16 lh30 TC B" dir="ltr"><?=dateToTimeS3($now)?></div>
					<? if(_set_9ivaiia87g==0){?>
						<div class=" fs12 f1 TC">
						<span class="f1 fs12"><?=k_net_mnt_pd?> :</span>					
						<span class="ff fs16 B "><?=number_format($pay)?></span><?=k_sp?></div>
					<? }?>
					<div class="f1 TC lh20"><? if($pay_type==3){ echo ' ----- تأمين ----- ';}?></div>
					 <? if($pay_type==2){?>
					 	<div class="f1 TC lh20"> ----- جمعية ----- </div>
						<div class="f1 TC lh20"><?=get_val('gnr_m_charities','name_'.$lg,$pay_type_link);?></div>
					 <? }
					echo '<div class="uLine lh20">&nbsp;</div>';
					$srvs=get_vals('xry_x_visits_services','id,service'," visit_id='$id' ",'arr');
					
					//$m_srvs=get_vals('xry_m_services','id,name_'.$lg," id in($srvs)",'arr');					
					$i=0;
					foreach($srvs[0] as $n){
						$ser=$srvs[1][$i];
						$serName=get_val('xry_m_services','name_'.$lg,$ser);
						echo '<div class="lh20 f1"><span class="fs16 ">'.number_format($n).' | </span> '.$serName.'</div>';
						$i++;
					}?>					
					<div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_0e7tea245s?></div>
                </div><?
                if($pay_type==3){
                    $inSur=getTotalCo('gnr_x_insurance_rec',"visit='$id' and status=0");
                    if($inSur){$pay_type=4;}
                }
				delTempOpr($cType,$id,$pay_type);
			}
		}
	}
	if($cType==4){
		$nType=pp($_GET['par']);
		$sql="select * from den_x_visits where id='$id' and status not in (3,5) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];
			$dts_id=$r['dts_id'];
			$dts_date=$r['dts_date'];
			$type=$r['type'];
			if($type==0){mysql_q("UPDATE den_x_visits SET type='$nType' where id='$id' ");}
			if($type==0 && $nType==2){
				addPay4($id,1);				
			}
			$role_no=addRoles($id,4,$nType);
			if($role_no){
				 if(_set_2lgaamrmla){
					$image=getImages(_set_2lgaamrmla);
					$file=$image[0]['file'];
					$folder=$image[0]['folder'];
					list($w,$h)=getimagesize("sData/".$folder.$file);
					$fullfile=$m_path.'upi/'.$folder.$file;
					$logo= '<img src="'.$fullfile.'" width="100%"/>';
				}						
				$clinic=$r['clinic'];	
                list($clinic_code,$clinicName)=get_val('gnr_m_clinics','code,name_'.$lg,$clinic);
				$d_start=$r['d_start'];
				$patient=$r['patient'];?>
				<div class="pa_receipt">
					<div class="uLine"><?=$logo?></div><?					
					if($dts_id>0){?>
						<div class="TC B reccp_no2"><?=$role_no?></div><? 
					}else{?>
						<div class="TC B reccp_no"><?=$clinic_code.'-'.$role_no?></div><? 
					}?>
					<div class="baarcode TC"><img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/><div dir="ltr"><?=$cType.'-'.$id?></div></div>
					<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
                    <div class="f1 fs16 lh20 TC"><?=k_clinic?> : <?=$clinicName?></div>                    
					<div class="ff fs16 lh30 TC B" dir="ltr"><?=dateToTimeS3($now)?></div><? 
					if($type==0 && $nType==2){
						echo '<div class=" fs12 f1 TC">
						<span class="f1 fs12">'.k_net_mnt_pd.' :</span>
						<span class="ff fs16 B ">'.number_format(_set_lbza344hl).'</span> '.k_sp.'</div>';
					 }?>
					<div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_0e7tea245s?></div>
                </div><?
			}
		}
	}
	if($cType==44){
		$r=getRec('gnr_x_acc_patient_payments',$id);
		if($r['r']){
			if(_set_2lgaamrmla){
				$image=getImages(_set_2lgaamrmla);
				$file=$image[0]['file'];
				$folder=$image[0]['folder'];
				list($w,$h)=getimagesize("sData/".$folder.$file);
				$fullfile=$m_path.'upi/'.$folder.$file;
				$logo= '<img src="'.$fullfile.'" width="100%"/>';
			}
			$p_id=$r['id'];
			$ref_p_id=$r['payment_id'];
			$patient=$r['patient'];
			$sex=get_val('gnr_m_patients','sex',$patient);
			$type=$r['type'];
			$mood=$r['mood'];
			$sub_mood=$r['sub_mood'];
			$amount=$r['amount'];
            $payment_id=$r['payment_id'];
            //$amount+=get_sum('gnr_x_acc_payments','commi+differ'," id ='$payment_id' and mood='$cType'");
			$doc=$r['doc'];
			$date=$r['date'];
			$srvs=get_sum('den_x_visits_services','pay_net',"patient='$patient'");			
			$ref_p_idTxt='';
			if($ref_p_id){$ref_p_idTxt='<div class="fr"><ff class="fs14">#'.$ref_p_id.' </ff></div>';}
			?>
			<div class="pa_receipt">
				<div class="uLine"><?=$logo?></div>
				<div class="fr lh40"><ff class="fs14">#<?=$p_id?> </ff></div>
				<div class="f1 fs16 lh40">وصل استلام </div>
				<div class="f1 fs14 lh30 bord TC"><ff><?=number_format($amount)?></ff> <?=k_sp?></div>
				<div class="f1 fs14 lh30 "><?=$ref_p_idTxt?>النوع : <?=$patPayment[$type]?></div>
				<? if($doc){?><div class="f1 fs14 lh30 ">الطبيب : <?=get_val('_users','name_'.$lg,$doc);?></div><?}?>
				<? 
				if($type==1){$b_text='تم استلام  من';}
				if($type==2){$b_text='تم إرجاع  إلى';}?>
				<div class="f1 fs12 lh30"> <?=$b_text.' '.$sex_mr[$sex]?> : <?=get_p_name($patient)?></div>
				<div class="f1 fs12 lh30">مبلغ قدره : <?=writeTotal($amount).' '.k_sp?></div>
				<div class="ff fs12 lh30 t_bord"><ff class="fs14" dir="ltr"><?=dateToTimeS3($date)?></ff></div>
			</div><?
		}
	}
	if($cType==5){
		$sql="select * from bty_x_visits where id='$id' and status not in (3,5) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];
			$dts_id=$r['dts_id'];
			$dts_date=$r['dts_date'];
			$pay_type=$r['pay_type'];
			if($x_status==0){addPay5($id,1);}
			$role_no=addRoles($id,$cType);
			if($role_no){
				 if(_set_2lgaamrmla){
					$image=getImages(_set_2lgaamrmla);
					$file=$image[0]['file'];
					$folder=$image[0]['folder'];
					list($w,$h)=getimagesize("sData/".$folder.$file);
					$fullfile=$m_path.'upi/'.$folder.$file;
					$logo= '<img src="'.$fullfile.'" width="100%"/>';
				}
						
				$clinic=$r['clinic'];				
				list($clinic_code,$clinicName)=get_val('gnr_m_clinics','code,name_'.$lg,$clinic);
				$d_start=$r['d_start'];
				$patient=$r['patient'];
                $pay=get_sum('bty_x_visits_services','pay_net'," visit_id ='$id' and status not in (3,5)");
                //$pay+=get_sum('gnr_x_acc_payments','commi+differ'," vis ='$id' and mood='$cType'");?>
				<div class="pa_receipt">
					<div class="uLine"><?=$logo?></div><?
					if($dts_id>0){?>
						<div class="TC B reccp_no2"><?=$role_no?></div><? 
					}else{?>
						<div class="TC B reccp_no"><?=$clinic_code.'-'.$role_no?></div><? 
					}?>
					<div class="baarcode TC"><img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/><div dir="ltr"><?=$cType.'-'.$id?></div></div>
					<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
                    <div class="f1 fs16 lh20 TC"><?=$clinicName?></div>                    
					<div class="ff fs16 lh30 TC B" dir="ltr"><?=dateToTimeS3($now)?></div>
					<? if(_set_9ivaiia87g==0){?>
						<div class=" fs12 f1 TC">
						<span class="f1 fs12"><?=k_net_mnt_pd?> :</span>					
						<span class="ff fs16 B "><?=number_format($pay)?></span>
						 <?=k_sp?></div>
					<? }?>
					<div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_0e7tea245s?></div>
                </div><?
                if($pay_type==3){
                    $inSur=getTotalCo('gnr_x_insurance_rec',"visit='$id' and status=0");
                    if($inSur){$pay_type=4;}
                }
				delTempOpr($cType,$id,$pay_type);
			}
		}
	}
	if($cType==6){
		$sql="select * from bty_x_laser_visits where id='$id' and status not in (3,5) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];
			$dts_id=$r['dts_id'];
			$dts_date=$r['dts_date'];
			//if($x_status==0){addPay5($id,1);}
			$role_no=addRoles($id,$cType);
			if($role_no){
				mysql_q("UPDATE bty_x_laser_visits SET status=1 where id='$id' and status=0 ");
				if(_set_2lgaamrmla){
					$image=getImages(_set_2lgaamrmla);
					$file=$image[0]['file'];
					$folder=$image[0]['folder'];
					list($w,$h)=getimagesize("sData/".$folder.$file);
					$fullfile=$m_path.'upi/'.$folder.$file;
					$logo= '<img src="'.$fullfile.'" width="100%"/>';
				}
						
				$clinic=$r['clinic'];				
				list($clinic_code,$clinicName)=get_val('gnr_m_clinics','code,name_'.$lg,$clinic);				
				$d_start=$r['d_start'];
				$patient=$r['patient'];
				$total_pay=$r['total_pay'];
                //$total_pay+=get_sum('gnr_x_acc_payments','commi+differ'," vis ='$id' and mood='$cType'");?>              
				<div class="pa_receipt">
					<div class="uLine"><?=$logo?></div><?					
					if($dts_id>0){?>
						<div class="TC B reccp_no2"><?=$role_no?></div><? 
					}else{?>
						<div class="TC B reccp_no"><?=$clinic_code.'-'.$role_no?></div><? 
					}?>
					<div class="baarcode TC"><img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/><div dir="ltr"><?=$cType.'-'.$id?></div></div>
					<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
                    <div class="f1 fs16 lh20 TC"><?=$clinicName?></div>
					<? if($total_pay){?>
						<div class=" fs12 f1 TC">
                    	<span class="f1 fs12"><?=k_net_mnt_pd?> :</span>
                    	<span class="ff fs16 B "><?=number_format($total_pay)?></span><?=k_sp?>
						</div>
					<?}?>
					<div class="ff fs16 lh30 TC B" dir="ltr"><?=dateToTimeS3($now)?></div>
					<div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_0e7tea245s?></div>
                </div><?
                if($pay_type==3){
                    $inSur=getTotalCo('gnr_x_insurance_rec',"visit='$id' and status=0");
                    if($inSur){$pay_type=4;}
                }
				delTempOpr($cType,$id);
			}
		}
	}
	if($cType==7){				
		$sql="select * from osc_x_visits where id='$id' and status not in (3,5) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];
			$dts_id=$r['dts_id'];
			$dts_date=$r['dts_date'];
			$clinic=$r['clinic'];
			$doctor=$r['doctor'];
			$pay_type_link=$r['pay_type_link'];
			$pay_type=$r['pay_type'];			
			if($x_status==0){addPay7($id,1);}
			$role_no=addRoles($id,$cType);
			
			if($role_no){
				if(_set_2lgaamrmla){
					$image=getImages(_set_2lgaamrmla);
					$file=$image[0]['file'];
					$folder=$image[0]['folder'];
					list($w,$h)=getimagesize("sData/".$folder.$file);
					$fullfile=$m_path.'upi/'.$folder.$file;
					$logo= '<img src="'.$fullfile.'" width="100%"/>';
				}
				$clinic=$r['clinic'];
				list($clinic_code,$clinicName)=get_val('gnr_m_clinics','code,name_'.$lg,$clinic);
				$d_start=$r['d_start'];
				$patient=$r['patient'];
                list($amount,$doc_fees)=get_val_c('osc_x_visits_services','pay_net,doc_fees',$id,'visit_id');
                $price=$amount;
                if($pay_type==0){
                    $price=$amount+$doc_fees;
                    if(_set_qejqlfmies){
                        mysql_q("UPDATE osc_x_visits_services SET doc_percent=0 where visit_id='$id'");
                    }
                }                
                //$price+=get_sum('gnr_x_acc_payments','commi+differ'," vis ='$id' and mood='$cType'");
                if(_set_qejqlfmies){
                    if($pay_type==3){
                        mysql_q("UPDATE osc_x_visits_services SET doc_fees=0 where visit_id='$id'");
                    }
                }?>
				<div class="pa_receipt">
					<div class="uLine"><?=$logo?></div><?					
					if($dts_id>0){?>
						<div class="TC B reccp_no2"><?=$role_no?></div><? 
					}else{?>
						<div class="TC B reccp_no"><?=$clinic_code.'-'.$role_no?></div><? 
					}?>
					<div class="baarcode TC"><img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/><div dir="ltr"><?=$cType.'-'.$id?></div></div>
					<div class="f1 fs16 lh30 TC"><?=get_p_name($patient)?></div>
					<div class="f1 fs16 lh30 TC"><ff><?=$patient?></ff></div>
                    <div class="f1 fs16 lh20 TC"><?=k_clinic?> : <?=$clinicName;?></div>               
					<div class="ff fs16 lh30 TC B" dir="ltr"><?=dateToTimeS3($now)?></div>
					<? if(_set_9ivaiia87g==0){?>
						<div class=" fs12 f1 TC">
						<span class="f1 fs12"><?=k_net_mnt_pd?> :</span>
						<span class="ff fs16 B "><?=number_format($price)?> </span> <?=k_sp?></div>
					<? }?>
					<div class="f1 TC lh20"><? if($pay_type==3){ echo ' ----- تأمين ----- ';}?></div>
					 <? if($pay_type==2){?>
					 	<div class="f1 TC lh20"> ----- جمعية ----- </div>
						<div class="f1 TC lh20"><?=get_val('gnr_m_charities','name_'.$lg,$pay_type_link);?></div>
					 <? }?>
					<div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_0e7tea245s?></div>
                </div><?
                if($pay_type==3){
                    $inSur=getTotalCo('gnr_x_insurance_rec',"visit='$id' and status=0");
                    if($inSur){$pay_type=4;}
                }
				delTempOpr($cType,$id,$pay_type);
			}
		}
	}
	if($cType==9){
		$image=getImages(_set_gwp4wtk);
		$file=$image[0]['file'];
		$folder=$image[0]['folder'];
		list($w,$h)=getimagesize("sData/".$folder.$file);
		$fullfile=$m_path.'upi/'.$folder.$file;
		$logo= '<img src="'.$fullfile.'" width="100%"/>';?>
		<div class="pa_receipt">
			<div class="uLine"><?=$logo?></div><?
			$r=getRec('dts_x_dates',$id);			
			if($r['r']>0){
				$s=$r['d_start'];
				$e=$r['d_end'];
				$patient=$r['patient'];
				$p_type=$r['p_type'];
                $reserve=$r['reserve'];
				$note=$r['note'];
                $reserveTxt='';
                if($reserve){$reserveTxt='<div class="lh20 fs12 f1 TC"> ( موعد إحتياطي ) </div>';}
                $pay_rTxt='';
                $pay_r=get_val_con('gnr_x_acc_payments','amount',"type=6 and vis='$id'");                                
                ?>
				<div class="pd10">
					<div class="f1 fs18 TC lh30"><?=get_p_dts_name($patient,$p_type);?></div>
					<div class="f1 fs16 lh30 TC"><ff><?=$patient?></ff></div>
					<div class="f1 fs14 TC lh30">العيادة : <?=get_val('gnr_m_clinics','name_'.$lg,$r['clinic'])?></div>
					<div class="f1 fs14 TC lh30">الطبيب : <?=get_val('_users','name_'.$lg,$r['doctor'])?></div>
					<div class="baarcode3  TC"><img src="<?=$f_path.'bc/'.$cType.'-'.$id_no?>"/></div>
					<div class="ff B TC lh30"><?=$cType.'-'.$id?></div>
					<div class="uLine"></div>
					<div class="f1 fs16 TC lh30"><?= $wakeeDays[date('w',$s)].' : <ff>'.date('d',$s).'</ff> / '.$monthsNames[date('n',$s)].' / <ff>'.date('Y',$s).'</ff> ';?></div>
					<div class="uLine TC ff B  dateTimePrint"><?=date('A h:i',$s)?></div>
                    
                    <? if($pay_r){?>
						<div class=" fs12 f1 TC">
						<span class="f1 fs12">دفعة مقدمة :</span>
						<span class="ff fs16 B "><?=number_format($pay_r)?> </span> <?=k_sp?></div>
					<? }?>
                    <?=$reserveTxt?>
					<div class="lh20 fs12 f1 TC"><?=_info_5a3kh54bde?></div>
				</div><? 
			}?>							
		</div><?		
	}
	?>
    </body><?
}?>
<script>window.print();setTimeout(function(){window.close();},1000);</script>