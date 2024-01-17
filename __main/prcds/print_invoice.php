<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){?>
<? $style_file=styleFiles('P');?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>"><?
	$cType=pp($_GET['type']);
	$id=pp($_GET['id']);
	$q=" visit_id='$id' ";
	$denInv=0;
	if($cType==44){
		$cType=4;
		$par=$_GET['par'];
		$srv=str_replace('A',',',$par);
		$q=" id in($srv) ";
		$denInv=1;
	}
	$id_no=convTolongNo($id,8);
	$table_m=$srvTables[$cType];
	$table=$visXTables[$cType];
	$table2=$srvXTables[$cType];	
	$headImg=printHeaderImg(_set_14jk4yqz3w); 
	echo '<div class="print_pageW5"><div class="print_pageIn">		
	<div class="LP4Head" style="height:auto"><div class=" fr w100">'.$headImg.'</div></div>';
	if($denInv==0){
		$r_v=getRec($table,$id);
		if($r_v['r']){
			$r=mysql_f($res);
			$patient=$r_v['patient'];
			$clinic=$r_v['clinic'];
			$type=$r_v['type'];		
			$pay_type_link=$r_v['pay_type_link'];
			$pay_type=$r_v['pay_type'];
			$d_start=$r_v['d_start'];		
			$status=$r_v['status'];
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
				//list($insurPrv,$insurCom)=get_val('gnr_m_insurance_rec','provider,company',$pay_type_link);
				$CHR_TEXT='<div class="f1 fs16 ">السادة المحترمين : '.get_val('gnr_m_insurance_prov','name_'.$lg,$pay_type_link).'</div>';
			}
		}	
	}else{
		$patient=$id;
		$c_name="السنية";
		$d_start=$now;
	}
	if($r_v['r'] || $denInv){
        echo '<div class="fr f1 TC fs24"><ff dir="ltr">'.date('Y / m / d',$d_start).'</ff></div>
		<div class="f1 fs20">'.k_bill.'</div>'.$CHR_TEXT;
		if($cType==2){			
			echo '<div class="f1 fs14 lh40">
			أنجز المخبر التحاليل أدناه <span class="f1 fs16 lh30">'.$c_name.'</span> '.$p_txt.' 
			<span class="f1 fs16 lh40">'.get_p_name($patient).' </span>
			</div>';
		}else{
			echo '<div class="f1 fs14 lh40">'.k_cln_provd.' <span class="f1 fs16 lh30"> ( '.$c_name.' ) </span> '.k_flw_srvs.' '.$p_txt.'<span class="f1 fs14 lh40">'.get_p_name($patient).'</span></div>';
		}
		if($denInv==0){?>
			<div class="fs12 lh30">
			<?=$p_txt2?> : <span class="ff"><?=$patient?></span> / الزيارة : <span class="ff"> <?=$cType.'-'.$id?> </span>
			</div><?
		}
		if($cType==6){
			$total_pay=$r_v['total_pay'];
			$dis=$r_v['dis'];
			$total=$total_pay+$dis;
			$sql="select * from  $table2 where $q order by id ASC";
			if($denInv==0){$sql="select *, count(service)c from $table2 where $q GROUP BY service ";}
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s22">
					<tr bgcolor="#cccccc"><? 
					if($pay_type==2){ 
						echo '<th>'.k_services.'</th><th>'.k_val_srvs.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
					}else if($pay_type==3){ 
						echo '<th>'.k_services.'</th><th>'.k_val_srvs.'</th><th>'.k_paid_up.'</th><th>'.k_includ.'</th>';
					}else{
						echo '<th>'.k_services.'</th><th width="120">'.k_val_srvs.'</th>';
					}?>
					</tr><?
					$i=0;
					while($r=mysql_f($res)){					
						$s_id=$r['id'];
						$service=$r['service'];
						if($pay_type==2 || $pay_type==3){
							echo '<tr>
							<td class="f1" style="font-size:13px;" >'.get_val($table_m,'name_'.$lg,$service).'</td>';
							if($i==0){
								echo '<td><ff>'.number_format($total_pay).'</ff></td>
								<td><ff>'.number_format($pay_net).'</ff></td>
								<td><ff>'.number_format($total_pay-$pay_net).'</ff></td>
								</tr>';
							}
							$colspan=4;
						}else{
							echo '<tr>					
							<td class="f1" style="font-size:13px;">'.get_val($table_m,'name_'.$lg,$service).'</td>';
							if($i==0){
								echo '<td rowspan="'.$rows.'"><ff>'.number_format($total).'</ff></td></tr>';
							}
							$colspan=2;
						}
						$i++;
					}
					if($dis){?>
						<tr><td class="f1" style="font-size:13px;"><?=k_discount?>  </td>
							<td><ff><?=number_format($dis)?></ff></td></tr>
						<tr bgcolor="#cccccc"><td class="f1 fs16" ><?=k_total?></td>
							<td><ff><?=number_format($total_pay)?></ff></td></tr>						
					<?}?>
					<tr><td class="f1 fs16" colspan="<?=$colspan?>"><?=k_only.' '?> <?=writeTotal($total_pay)?> <?=' '.k_sp?> </td></tr>
				</table><?
			}
		}else{
			$sql="select * from  $table2 where $q order by id ASC";
			if($denInv==0){$sql="select *, count(service)c from $table2 where $q GROUP BY service,pay_type ";}
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
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
						if($denInv){$srv_count=1;}						
						$total_pay=$r['total_pay']*$srv_count;					
						$pay_net=$r['pay_net']*$srv_count;					
						$rev=$r['rev'];
						$offer=$r['offer'];
						//$price=$hos_part+$doc_part;					
						$total1+=$total_pay;

						if($pay_type==2 || $pay_type==3){
							$total3+=$total_pay-$pay_net;
							$total2+=$pay_net;
							echo '<tr>
							<td class="f1" style="font-size:13px;" >'.get_val($table_m,'name_'.$lg,$service).'</td>
							<td><ff>'.number_format($srv_count).'</ff></td>
							<td><ff>'.number_format($total_pay).'</ff></td>
							<td><ff>'.number_format($pay_net).'</ff></td>
							<td><ff>'.number_format($total_pay-$pay_net).'</ff></td>
							</tr>';
							$colspan=5;
						}else{
                            
							$finPrice=$pay_net;
							if($offer){
								$finPrice=$total_pay;
								$pay_net=$total_pay;
							}
                            if($cType==7){
                                $pay_net+=$r['doc_fees'];
                                $finPrice+=$r['doc_fees'];
                            }
							$total2+=$pay_net;
							$total3+=$finPrice;
							echo '<tr>					
							<td class="f1" style="font-size:13px;">'.get_val($table_m,'name_'.$lg,$service).'</td>
							<td><ff>'.number_format($srv_count).'</ff></td>
							<td><ff>'.number_format($finPrice).'</ff></td></tr>';
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
                    <div class=" fr lh30 fs10 clr9 " dir="ltr"><?=date('Y-m-d Ah:i:s')?></div><?
			}
		}
	}
	echo '</div>
	</div>';?>
    </body><?
}?>
<script>window.print();setTimeout(function(){window.close();},1000);</script>