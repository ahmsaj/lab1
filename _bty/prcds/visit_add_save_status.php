<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){	
	$v_id=pp($_POST['id']);
	$cType=pp($_POST['t']);
	$editable=1;
	echo script('act_clinic_type='.$cType.';');
	if($cType==5){
		$sql="select * from bty_x_visits where id='$v_id' and status=0";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$patient=$r['patient'];
			$clinic=$r['clinic'];
			$type=$r['type'];		
			$pay_type=$r['pay_type'];
			$d_start=$r['d_start'];		
			$status=$r['status'];
			$sub_status=$r['sub_status'];
			$emplo=$r['emplo'];
			if(($status>0 || $sub_status>0) && $pay_type==0){$editable=0;}
			if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';}
			$p_name=get_p_name($patient);
			$c_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);?>
			<div class="win_body">
				<div class="form_header">
				<div class="fl f1 fs16 clr1 lh40 Over" onclick="check_card_do(<?=$patient?>)"><?=k_patient?> : <?=get_p_name($patient).' '.$emploTxt?></div>
				<div class="fr f1 fs16 clr1 lh40"><?=k_clinic?> : <?=$c_name?></div>
				<? if(_set_9iaut3jze){echo offerStatus($cType,$v_id,$patient);}?>
				</div>        
			<div class="form_body so"><?		
			$sql="select * from  bty_x_visits_services where visit_id='$v_id' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s">
				<tr><th><?=k_services?></th><th width="80"><?=k_price?></th>
				<th width="80"><?=k_discount?></th>
				<th width="80"><?=k_net_amount?></th>				
				</tr><?
				$total1=0;
				$total2=0;
				while($r=mysql_f($res)){					
					$s_id=$r['id'];
					$service=$r['service'];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$offer=$r['offer'];
					$pay_net=$r['pay_net'];
					$rev=$r['rev'];
					list($cat,$name,$hPart,$dPart)=get_val('bty_m_services','cat,name_'.$lg.',hos_part,doc_part',$service);
					$srvPriceOrg=$hPart+$dPart;
					$price=$hos_part+$doc_part;	
					if($emplo && $price){
						$price=$srvPriceOrg;
					}
					$total1+=$price;
					$total2+=$pay_net;
					$dis=$price-$pay_net;
					
					$catNmae=get_val('bty_m_services_cat','name_'.$lg,$cat);
					$offerText=getSrvOfeerS($offer,$cType,$v_id,$s_id);
					$msg='';
					if($rev){$msg='<div class="f1 clr5">'.k_review.'</div>';}
					echo '<tr>					
					<td class="f1">'.$catNmae.' ( '.$name.' ) '.$msg.$offerText.'</td>
					<td><ff>'.number_format($price).'</ff></td>
					<td><ff>'.number_format($dis).'</ff></td>
					<td><ff>'.number_format($pay_net).'</ff></td>					
					</tr>';
				}?>
				<tr bgcolor="#ddd">					
				<td class="f1 B"><?=k_total?></td>
				<td class="fs18 ff B"><?=number_format($total1)?></td>
				<td class="fs18 ff B"><?=number_format($total1-$total2)?></td>
				<td class="fs18 ff B"><?=number_format($total2)?></td>				
				</tr>
				</table><?
			}
			?></div>
			<div class="form_fot fr"><? 
				if($rows>0){?>
				<div class="cb">
					<div class="bu bu_t4 fl" onclick="printReceipt(<?=$v_id?>,<?=$cType?>)"><?=k_pymt?> <ff> ( <?=number_format($total2)?> )</ff></div>
					<? if($pay_type==0){?>
						<? if(_set_hw3wi89dnk){?><div class="bu bu_t1 fr" onclick="chgPayType(1,<?=$v_id?>,<?=$cType?>)"><?=k_exemption?></div><? }?>
						<div class="bu bu_t1 fr w-auto " onclick="chgPayType(2,<?=$v_id?>,<?=$cType?>)"><?=k_charity?></div>
						<? if(_set_rkq2s40u5g){?>
						<div class="bu bu_t1 fr w-auto" onclick="chgPayType(3,<?=$v_id?>,<?=$cType?>)"><?=k_insurance?></div>
						<? }?>
					<? }?>
				</div>
				<div class="uLine cb lh1">&nbsp;</div>
				<? }?>
				<div class="cb">
					<div class="bu bu_t2 fr" onclick="res_ref(1);win('close','#m_info');"><?=k_close?></div>
					<div class="bu bu_t3 fr" id="saveButt" onclick="delVis(<?=$v_id?>,<?=$cType?>)"><?=k_delete?></div>
					<? if($editable){?>
					<div class="bu bu_t1 fl" onclick="serNPat_do(<?=$patient?>,<?=$v_id?>)"><?=k_edit?></div>
					<?}?>
				</div>
			</div>
		<?	
		}else{
			delTempOpr($cType,$v_id,'a');
			echo script("win('close','#m_info');");			
		}
	}
	if($cType==6){
		$sql="select * from bty_x_laser_visits where id='$v_id' and status=0";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$patient=$r['patient'];
			$clinic=$r['clinic'];
			$d_start=$r['d_start'];		
			$status=$r['status'];
			$emplo=$r['emplo'];
			if($status>0){$editable=0;}
			if($emplo ){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';}
			$p_name=get_p_name($patient);
			$c_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);?>
			<div class="win_body">
				<div class="form_header">
				<div class="fl f1 fs16 clr1 lh40 Over" onclick="check_card_do(<?=$patient?>)"><?=k_patient?> : <?=get_p_name($patient).' '.$emploTxt?></div>
				<div class="fr f1 fs16 clr1 lh40"><?=k_clinic?> : <?=$c_name?></div>
				</div>        
			<div class="form_body so"><?		
			$sql="select * from  bty_x_laser_visits_services where visit_id='$v_id' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s">
				<tr><th><?=k_services?></th></tr><?
				$total1=0;
				$total2=0;
				while($r=mysql_f($res)){					
					$s_id=$r['id'];
					$service=$r['service'];				
					$price=$hos_part+$doc_part;					
					$total1+=$price;
					$total2+=$pay_net;
					$dis=$price-$pay_net;
					list($cat,$name)=get_val('bty_m_services','cat,name_'.$lg,$service);
					$catNmae=get_val('bty_m_services_cat','name_'.$lg,$cat);
					$msg='';
					if($rev){$msg='<div class="f1 clr5">'.k_review.'</div>';}
					echo '<tr>					
					<td class="f1">'.$catNmae.' ( '.$name.' ) '.$msg.'</td>
					</tr>';
				}?>
				</table><?
			}
			?></div>
			<div class="form_fot fr"> 				
				<div class="cb">
				<div class="bu bu_t4 fl" onclick="printReceipt(<?=$v_id?>,<?=$cType?>)"><?=k_reserve?></div>
				<div class="bu bu_t2 fr" onclick="res_ref(1);win('close','#m_info');"><?=k_close?></div>
				<div class="bu bu_t3 fr" id="saveButt" onclick="delVis(<?=$v_id?>,<?=$cType?>)"><?=k_delete?></div>
				<? if($editable){?>
				<div class="bu bu_t1 fl" onclick="serNPat_do(0,<?=$v_id?>)"><?=k_edit?></div>
				<?}?>
				</div>
				</div>
			</div><?	
		}else{
			delTempOpr($cType,$v_id,'a');
			echo script("win('close','#m_info');");
			
		}
	}
	
}?>