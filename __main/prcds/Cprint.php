<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){?>
	<? $style_file=styleFiles('P');?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>">
	<body dir="<?=$l_dir?>"><?
	$type=pp($_GET['type']);
	$id=pp($_GET['id']);
	$par=pp($_GET['par']);
	$id_no=convTolongNo($id,7);
	$thisCode=$type.'-'.$id;
	if($type==1){
		$id_no=convTolongNo($id,7);
		$sql="select * from gnr_m_patients where id='$id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$f_name=$r['f_name'];
			$l_name=$r['l_name'];
			$ft_name=$r['ft_name'];
			$mother_name=$r['mother_name'];
			$no=$r['no'];
			$mobile=$r['mobile'];
			$birth_date=$r['birth_date'];
			$print_card=$r['print_card'];
			$last_print=$r['last_print'];
			$sex=$r['sex'];
			$phone=$r['phone'];
			$date=$r['date'];			
			if($print_card==0 && (($now-$last_print)>60000)){exit;}?>
			<div class="pa_card">
				<div class="f1 lh30 TC" style="font-size:11px;"><?=$f_name.' '.$ft_name.' '.$l_name?></div>
                <div class="baarcode3 TC"><img src="<?=$f_path.'bc/'.$id_no?>"/></div>
                <div class="ff B fs14 lh20 TC" style="letter-spacing:1px;width:100%;"><?=$id_no?></div>
				<? if(_set_8ouru2zkpw){?>
					<div class="f1 fs14 lh20 TC fl"><ff dir="ltr"><?=$birth_date?></ff></div>
					<div class="f1 fs14 lh20 TC fr"><ff  class="fs14"><?=$mobile?></ff></div>
				<? }?>
			</div><?
		}	
	}
	if($type==3){
		if(_set_14jk4yqz3w){
			$image=getImages(_set_14jk4yqz3w);
			$file=$image[0]['file'];
			$folder=$image[0]['folder'];
			list($w,$h)=getimagesize("sData/".$folder.$file);
			$fullfile=$m_path.'upi/'.$folder.$file;
			$logo= '<img width="100%" src="'.$fullfile.'"/>';
		}
		echo '<div class="print_pageW5"><div class="print_pageIn">		
		<div class="LP4Head" style="height:auto">		
			<div class=" fr w100">'.$logo.'</div>      	
		</div>';
		$sql="select * from cln_x_visits where id='$id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$patient=$r['patient'];
			$clinic=$r['clinic'];
			$type=$r['type'];		
			$pay_type_link=$r['pay_type_link'];
			$pay_type=$r['pay_type'];
			$d_finish=$r['d_finish'];		
			$status=$r['status'];
			
			$p_name=get_p_name($patient);
			list($c_name,$cType)=get_val('gnr_m_clinics','name_'.$lg.',type',$clinic);
			$sex=get_val('gnr_m_patients','sex',$patient);
			
			$p_txt=' '.k_male_pat.' ';
			$p_txt2=k_patient;
			if($sex==2){$p_txt=' '.k_fmle_pat.' '; $p_txt2=k_s_patient;}	
			if($pay_type==2){				
				$CHR_TEXT='<div class="f1 fs18 ">'.k_the_charity.' : '.get_val('gnr_m_charities','name_'.$lg,$pay_type_link).'</div>';
			}
			if($pay_type==3){
				$insur=get_val_con('gnr_x_insurance_rec','insur_id'," mood=1  and visit=$id ");
				list($insurPrv,$insurCom)=get_val('gnr_m_insurance_rec','provider,company',$insur);
				$CHR_TEXT='<div class="f1 fs16 ">السادة المحترمين : '.get_val('gnr_m_insurance_prov','name_'.$lg,$insurPrv).'</div>';
			}
			?>
            
            <div class="fr f1 TC fs24"><ff dir="ltr"><?=date('Y / m / d',$d_finish)?></ff></div>
			<div class="f1 fs20"><?=k_bill?></div><?=$CHR_TEXT?>
            <div class="f1 fs14 lh40">
            <?=k_cln_provd?> <span class="f1 fs16 lh30"> ( <?=$c_name?> ) </span> <?=k_flw_srvs?> <?=$p_txt?>
            	<span class="f1 fs14 lh40"><?=get_p_name($patient)?></span>            	
            </div>
			<div class="fs12 lh30">
			<?=$p_txt2?> : <span class="ff"><?=$patient?></span> / الزيارة : <span class="ff"> <?=$cType.'-'.$id?> </span>
            </div><?		
			$sql="select * from  cln_x_visits_services where visit_id='$id' order by id ASC";
			$sql="select *, count(service)c from cln_x_visits_services where visit_id='$id' GROUP BY service ";	
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				?>
				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s22">
				<tr bgcolor="#cccccc"><? 
				if($pay_type==2){ 
					echo '<th>'.k_service.'</th><th>'.k_number.'</th><th>'.k_val_srv.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
				}else if($pay_type==3){ 
					echo '<th>'.k_service.'</th><th>'.k_number.'</th><th>'.k_val_srv.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
				}else{
					echo '<th>'.k_service.'</th><th>'.k_number.'</th><th width="120">'.k_val_srv.'</th>';
				}?>
				</tr><?
				$total1=0;
				$total2=0;
				$total3=0;
				while($r=mysql_f($res)){					
					$s_id=$r['id'];
					$service=$r['service'];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$srv_count=$r['c'];
					$total_pay=$r['total_pay']*$srv_count;					
					$pay_net=$r['pay_net']*$srv_count;
					$rev=$r['rev'];
					//$price=$hos_part+$doc_part;					
					$total1+=$total_pay;
					$total2+=$pay_net;
					if($pay_type==2 || $pay_type==3){
						$total3+=$total_pay-$pay_net;
						echo '<tr>
						<td class="f1" style="font-size:13px;" >'.get_val('cln_m_services','name_'.$lg,$service).'</td>
						<td><ff>'.number_format($srv_count).'</ff></td>
						<td><ff>'.number_format($total_pay).'</ff></td>
						<td><ff>'.number_format($pay_net*$srv_count).'</ff></td>
						<td><ff>'.number_format($total_pay-$pay_net).'</ff></td>
						</tr>';
						$colspan=5;
					}else{
						$total3+=$pay_net;
						echo '<tr>					
						<td class="f1" style="font-size:13px;">'.get_val('cln_m_services','name_'.$lg,$service).'</td>
						<td><ff>'.number_format($srv_count).'</ff></td>
						<td><ff>'.number_format($pay_net).'</ff></td></tr>';
						$colspan=3;
					}
				}?>
				<tr bgcolor="#cccccc"><td class="fs16 f1" colspan="2"><?=k_total?></td>
               	<? if($pay_type==2 || $pay_type==3){echo '<td class="fs18 ff B">'.number_format($total1).'</td>';}?>
               	<td class="fs18 ff B"><?=number_format($total2)?></td>
               	<? if($pay_type==2 || $pay_type==3){echo '<td class="fs18 ff B">'.number_format($total3).'</td>';}?>
               	</tr>
                <tr><td class="f1 fs16" colspan="<?=$colspan?>"><?=k_only.' '?> <?=writeTotal($total3)?> <?=' '.k_sp?> </td></tr>
				</table>
				<?
			}		
		}
		echo '</div>
		</div>';
	}
	if($type==33){
		if(_set_14jk4yqz3w){
			$image=getImages(_set_14jk4yqz3w);
			$file=$image[0]['file'];
			$folder=$image[0]['folder'];
			list($w,$h)=getimagesize("sData/".$folder.$file);
			$fullfile=$m_path.'upi/'.$folder.$file;
			$logo= '<img width="100%" src="'.$fullfile.'"/>';
		}
		echo '<div class="print_pageW5"><div class="print_pageIn">		
		<div class="LP4Head" style="height:auto">		
			<div class=" fr w100">'.$logo.'</div>      	
		</div>';
		$sql="select * from xry_x_visits where id='$id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$patient=$r['patient'];
			$clinic=$r['clinic'];
			$type=$r['type'];		
			$pay_type_link=$r['pay_type_link'];
			$pay_type=$r['pay_type'];
			$d_finish=$r['d_finish'];		
			$status=$r['status'];
			
			$p_name=get_p_name($patient);
			list($c_name,$cType)=get_val('gnr_m_clinics','name_'.$lg.',type',$clinic);
			$sex=get_val('gnr_m_patients','sex',$patient);
			
			$p_txt=' '.k_male_pat.' ';
			$p_txt2=k_patient;
			if($sex==2){$p_txt=' '.k_fmle_pat.' '; $p_txt2=k_s_patient;}	
			if($pay_type==2){				
				$CHR_TEXT='<div class="f1 fs18 ">'.k_the_charity.' : '.get_val('gnr_m_charities','name_'.$lg,$pay_type_link).'</div>';
			}
			if($pay_type==3){
				$insur=get_val_con('gnr_x_insurance_rec','insur_id'," mood=1  and visit=$id ");
				list($insurPrv,$insurCom)=get_val('gnr_m_insurance_rec','provider,company',$insur);
				$CHR_TEXT='<div class="f1 fs16 ">السادة المحترمين : '.get_val('gnr_m_insurance_prov','name_'.$lg,$insurPrv).'</div>';
			}
			?>
            
            <div class="fr f1 TC fs24"><ff dir="ltr"><?=date('Y / m / d',$d_finish)?></ff></div>
			<div class="f1 fs20"><?=k_bill?></div><?=$CHR_TEXT?>
            <div class="f1 fs14 lh40">
            <?=k_cln_provd?> <span class="f1 fs16 lh30"> ( <?=$c_name?> ) </span> <?=k_flw_srvs?> <?=$p_txt?>
            	<span class="f1 fs14 lh40"><?=get_p_name($patient)?></span>            	
            </div>
			<div class="fs12 lh30">
			<?=$p_txt2?> : <span class="ff"><?=$patient?></span> / الزيارة : <span class="ff"> <?=$cType.'-'.$id?> </span>
            </div><?		
			$sql="select * from  xry_x_visits_services where visit_id='$id' order by id ASC";
			$sql="select *, count(service)c from xry_x_visits_services where visit_id='$id' GROUP BY service ";	
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				?>
				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s22">
				<tr bgcolor="#cccccc"><? 
				if($pay_type==2){ 
					echo '<th>'.k_service.'</th><th>'.k_number.'</th><th>'.k_val_srv.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
				}else if($pay_type==3){ 
					echo '<th>'.k_service.'</th><th>'.k_number.'</th><th>'.k_val_srv.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
				}else{
					echo '<th>'.k_service.'</th><th>'.k_number.'</th><th width="120">'.k_val_srv.'</th>';
				}?>
				</tr><?
				$total1=0;
				$total2=0;
				$total3=0;
				while($r=mysql_f($res)){					
					$s_id=$r['id'];
					$service=$r['service'];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$srv_count=$r['c'];
					$total_pay=$r['total_pay']*$srv_count;					
					$pay_net=$r['pay_net']*$srv_count;
					$rev=$r['rev'];
					//$price=$hos_part+$doc_part;					
					$total1+=$total_pay;
					$total2+=$pay_net;
					if($pay_type==2 || $pay_type==3){
						$total3+=$total_pay-$pay_net;
						echo '<tr>
						<td class="f1" style="font-size:13px;" >'.get_val('cln_m_services','name_'.$lg,$service).'</td>
						<td><ff>'.number_format($srv_count).'</ff></td>
						<td><ff>'.number_format($total_pay).'</ff></td>
						<td><ff>'.number_format($pay_net*$srv_count).'</ff></td>
						<td><ff>'.number_format($total_pay-$pay_net).'</ff></td>
						</tr>';
						$colspan=5;
					}else{
						$total3+=$pay_net;
						echo '<tr>					
						<td class="f1" style="font-size:13px;">'.get_val('cln_m_services','name_'.$lg,$service).'</td>
						<td><ff>'.number_format($srv_count).'</ff></td>
						<td><ff>'.number_format($pay_net).'</ff></td></tr>';
						$colspan=3;
					}
				}?>
				<tr bgcolor="#cccccc"><td class="fs16 f1" colspan="2"><?=k_total?></td>
               	<? if($pay_type==2 || $pay_type==3){echo '<td class="fs18 ff B">'.number_format($total1).'</td>';}?>
               	<td class="fs18 ff B"><?=number_format($total2)?></td>
               	<? if($pay_type==2 || $pay_type==3){echo '<td class="fs18 ff B">'.number_format($total3).'</td>';}?>
               	</tr>
                <tr><td class="f1 fs16" colspan="<?=$colspan?>"><?=k_only.' '?> <?=writeTotal($total3)?> <?=' '.k_sp?> </td></tr>
				</table>
				<?
			}		
		}
		echo '</div>
		</div>';
	}
    if($type==4){
		$ammount=pp($_GET['par']);
		$id_no=convTolongNo($id,8);
		$sql="select * from lab_x_visits where id='$id' and status!=3 ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$x_status=$r['status'];			
			$clinic=get_val_c('gnr_m_clinics','id',2,'type');
			$clinic_code=get_val('gnr_m_clinics','code',$clinic);
			$d_start=$r['d_start'];
			$patient=$r['patient'];?>
			<div class="pa_receipt"  style="height:auto;">
				<div class="p1_title">
					<div class="f1 fl" style="font-size:15px;"><?=_info_7dvjz4qg9g?></div>
					<div class="fr"><? 
					if(_set_2lgaamrmla){
						$image=getImages(_set_2lgaamrmla);
						$file=$image[0]['file'];
						$folder=$image[0]['folder'];
						list($w,$h)=getimagesize("sData/".$folder.$file);
						$fullfile=$m_path.'upi/'.$folder.$file;
						echo '<img src="'.$fullfile.'" />';
					}?>
					</div>
				</div>
				
				<div class="f1 fs16 lh30"><?=get_p_name($patient)?></div>
                <?
                $sql="select * from lab_x_visits_services where visit_id='$id'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$priceAll=0;
				if($rows>0){
					echo '<table width="100%" class="grad_s22" cellpadding="3">';					
					$amount=get_sum('gnr_x_acc_payments','amount'," vis ='$id' and mood=2 and type=1 ");
					$fastTime=0;
					while($r=mysql_f($res)){
						$service=$r['service'];
						$units=$r['units'];
						$units_price=$r['units_price'];
						$pay_net=$r['pay_net'];
						$fast=$r['fast'];
						if($fast){$fastTime=1;}
						$priceAll+=$pay_net;
						echo '<tr><td class="f1">'.get_val('lab_m_services','name_'.$lg,$service).'</td><td><ff>'.$pay_net.'</ff></td></tr>';
					}
					if($fastTime){
						$timeN=intval(_set_6bu0m3quf2)*60;
						$recTime=date('A h:m',$now+$timeN);
					}else{
						$timeN=get_max_resTime($id);
						$recTime=date('Y-m-d',$now+($timeN*86400));
					}
					echo '<tr><td class="f1">'.k_total.'</td><td><ff>'.$priceAll.'</ff></td></tr>';
					echo '<tr><td class="f1">'.k_dsv_mnt.'</td><td><ff>'.($priceAll-$amount).'</ff></td></tr>
					</table>';
				}?>                
				<div class="f1 fs14 lh30 TC"><?=k_dlvr_tm?> : <ff dir="ltr"><?=$recTime?></ff></div>                    
				<div class="baarcode TC"><img src="<?=$f_path.'bc/2-'.$id_no?>"/><div dir="ltr"><?='2-'.$id?></div></div>               
                <div class="f1 fs12 TC recp_note" dir="ltr"><?=_info_hsw76hw0i?></div>
			</div><?			
		}
	}
	if($type==44){
		if(_set_14jk4yqz3w){
			$image=getImages(_set_14jk4yqz3w);
			$file=$image[0]['file'];
			$folder=$image[0]['folder'];
			list($w,$h)=getimagesize("sData/".$folder.$file);
			$fullfile=$m_path.'upi/'.$folder.$file;
			$logo= '<img width="100%" src="'.$fullfile.'"/>';
		}
		echo '<div class="print_pageW5"><div class="print_pageIn">		
		<div class="LP4Head" style="height:auto">				
			<div class=" fr w100">'.$logo.'</div>      	
		</div>';
		$sql="select * from lab_x_visits where id='$id' and status in(1,2,4,5,6)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$patient=$r['patient'];
			$clinic=$r['clinic'];
			$type=$r['type'];		
			$pay_type_link=$r['pay_type_link'];
			$pay_type=$r['pay_type'];
			$d_start=$r['d_start'];
			//$d_finish=$r['d_finish'];
			$status=$r['status'];
			
			$p_name=get_p_name($patient);
			$c_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
			$sex=get_val('gnr_m_patients','sex',$patient);
			$p_txt=' '.k_male_pat.' ';
			$p_txt2=k_patient;
			if($sex==2){$p_txt=' '.k_fmle_pat.' '; $p_txt2=k_s_patient;}	
			if($pay_type==2){				
				$CHR_TEXT='<div class="f1 fs18 ">'.k_the_charity.' : '.get_val('gnr_m_charities','name_'.$lg,$pay_type_link).'</div>';
			}
			if($pay_type==3){
				$insur=get_val_con('gnr_x_insurance_rec','insur_id'," mood=2  and visit=$id ");
				list($insurPrv,$insurCom)=get_val('gnr_m_insurance_rec','provider,company',$insur);
				$CHR_TEXT='<div class="f1 fs16 ">السادة المحترمين : '.get_val('gnr_m_insurance_prov','name_'.$lg,$insurPrv).'</div>';
			}
			?>
            
            <div class="fr f1 TC fs24"><ff dir="ltr"><?=date('Y / m / d',$d_start)?></ff></div>
			<div class="f1 fs20"><?=k_bill?></div><?=$CHR_TEXT?>
            <div class="f1 fs14 lh40">
            أنجز المخبر في مركز دمر الطبي التحاليل أدناه <span class="f1 fs16 lh30"><?=$c_name?></span> <?=$p_txt?> 
			<span class="f1 fs16 lh40"><?=get_p_name($patient)?> </span>
			</div>
			<div class="fs12 lh30">
			<?=$p_txt2?> : <span class="ff"><?=$patient?></span> / الزيارة : <span class="ff"><?='2-'.$id?></span>
            </div><?		
			$sql="select * from  lab_x_visits_services where visit_id='$id' and status not IN(3,4) order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				?>
				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s22">
				<tr bgcolor="#cccccc">
				<? if($pay_type==2){ 
					echo '<th>'.k_service.'</th><th>'.k_val_srv.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
				}else if($pay_type==3){ 
					echo '<th>'.k_service.'</th><th>'.k_val_srv.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
				}else{
					echo '<th>'.k_service.'</th><th width="120">'.k_val_srv.'</th>';
				}?>
				</tr><?
				$total1=0;
				$total2=0;
				$total3=0;
				while($r=mysql_f($res)){					
					$s_id=$r['id'];
					$service=$r['service'];
					$units=$r['units'];
					$units_price=$r['units_price'];
					$total_pay=$r['total_pay'];
					$pay_net=$r['pay_net'];
					$rev=$r['rev'];
					$price=$units_price*$units;					
					$total1+=$price;
					$total2+=$pay_net;
					$total3+=$price-$pay_net;
					$totalText=0;
					if($pay_type==2){
						echo '<tr>
						<td class="f1" style="font-size:13px;" >'.splitNo(get_val('lab_m_services','name_'.$lg,$service)).'</td>
						<td><ff>'.number_format($price).'</ff></td>
						<td><ff>'.number_format($pay_net).'</ff></td>
						<td><ff>'.number_format($price-$pay_net).'</ff></td>
						</tr>';
						$colspan=5;
						$totalText=$total3;
					}else if($pay_type==3){
						echo '<tr>
						<td class="f1" style="font-size:13px;" >'.splitNo(get_val('lab_m_services','name_'.$lg,$service)).'</td>
						<td><ff>'.number_format($price).'</ff></td>
						<td><ff>'.number_format($pay_net).'</ff></td>
						<td><ff>'.number_format($price-$pay_net).'</ff></td>
						</tr>';
						$colspan=5;
						$totalText=$total3;
					}else{
					
						echo '<tr>					
						<td class="f1" style="font-size:13px;">'.splitNo(get_val('lab_m_services','name_'.$lg,$service)).'</td>
						<td><ff>'.number_format($pay_net).'</ff></td></tr>';
						$colspan=3;
						$totalText=$total1;
					}
				}?>
				<tr bgcolor="#cccccc"><td class="fs16 f1"><?=k_total?></td>
               	<? if($pay_type==2 || $pay_type==3){echo '<td class="fs18 ff B">'.number_format($total1).'</td>';}?>
               	<td class="fs18 ff B"><?=number_format($total2)?></td>
               	<? if($pay_type==2 | $pay_type==3){echo '<td class="fs18 ff B">'.number_format($total3).'</td>';}?>
               	</tr>
                <tr><td class="f1 fs16" colspan="<?=$colspan?>"><?=k_only.' '?> <?=writeTotal($totalText)?> <?=' '.k_sp?> </td></tr>
				</table>
				<?
			}		
		}
		echo '</div>
		</div>';
	}
	if($type==5){
		$s_width=4;
		$s_height=2.5;
		$bar_height=1;
		$border=0;
		$st_size=explode(',',_set_ltvpe14fud);
		if(count($st_size)==4){
			$s_width=$st_size[0];
			$s_height=$st_size[1];
			$bar_height=$st_size[2];
			$border=$st_size[3];
		}
		$padd=($s_height-$bar_height-2)/2;
		$r=getRec('lab_x_visits',$id);
		if($r['r']){
			$status=$r['status'];
			$pat=$r['patient'];
			$patName=get_p_name($pat);
			$q='';
			if($par){$q=" and id='$par'";}
			if($status==1){
				$sql="select * from lab_x_visits_samlpes where visit_id='$id' $q ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){					
						$pkg_id=$r['pkg_id'];
						$take_date=$r['take_date'];
						$no=$r['no'];
						$status=$r['status'];
						$per_s=$r['per_s'];
						$services=$r['services'];
						$m_service='';
						$codes='';
						if($services){
							$m_service=get_vals('lab_x_visits_services','service'," id in($services)");
							$codes=get_vals('lab_m_services','tube_code'," id in($m_service) and tube_code!=''",' . ');
						}
						
						if($codes){$codes=' - <sapn class="f2 fs10 B"> '.$codes.'</span>';}
						$per_sTxt='';
						if($per_s){$per_sTxt='*';}
						$pak=get_val_arr('lab_m_samples_packages','name_ar',$pkg_id,'p');?>
						<div class="stcker" style="width:<?=$s_width?>cm;height:<?=$s_height?>cm;border:<?=$border?>px #000 solid; padding-top:<?=$padd?>cm">
						<div class="B ws of lh30 TC" style="font-size:10px;"><?=$patName?></div>
						<div class="f1 fs10 TC"><?=$per_sTxt.$pak.$per_sTxt.$codes?></div>
						<div class="baarcode3 TC" >
							<img src="<?=$f_path.'bc/'.$no?>" style="height:<?=$bar_height?>cm;"/>
						</div>
						<div class="ff B fs14 lh20 TC" style="letter-spacing:1px;width:100%;"><?=$no?></div>
						</div><?
					}
				}
			}
		}		
	}?>
    </body><?
}?>
<script>window.print();setTimeout(function(){window.close();},1000);</script>