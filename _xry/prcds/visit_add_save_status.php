<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$cType=3;
	$v_id=pp($_POST['id']);
	$editable=1;
	$sql="select * from xry_x_visits where id='$v_id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$doctor=$r['doctor'];		
		$dts_id=$r['dts_id'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];	
		$status=$r['status'];
		$sub_status=$r['sub_status'];
		if(($status>0 || $sub_status>0) && $pay_type==0){$editable=0;}
		$emplo=$r['emplo'];
		list($docName,$sex)=get_val('_users','name_'.$lg.',sex',$doctor);
		if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( موظف )</span>';}
		$p_name=get_p_name($patient);
		list($c_name,$cType)=get_val('gnr_m_clinics','name_'.$lg.',type',$clinic);
		echo script('act_clinic_type='.$cType.';');?>
        <div class="win_body">
            <div class="form_header">			
            <div class="fl f1 fs16 clr1 lh40 Over" onclick="check_card_do(<?=$patient?>)"><?=k_patient?> : <?=get_p_name($patient).' '.$emploTxt?></div>
            <div class="fr f1 fs16 clr1 lh40"><?=k_clinic?> : <?=$c_name?> </div>
			<? if($doctor){?>
			<div class="cb f1 fs16 clr1 lh30"> <?=$sex_txt[$sex].' : '.$docName?>  
				<? if($dts_id){?>
					<span class=" f1 fs14 clr5 lh30 Over" onclick="changDoc(<?=$v_id?>,<?=$cType?>)">( <?=k_chng_dr?> )</span>
				<? }?>
			</div>
			<? }
			if(_set_9iaut3jze){echo offerStatus($cType,$v_id,$patient);}?>
			
            </div>        
		<div class="form_body so"><?		
		$sql="select * from  xry_x_visits_services where visit_id='$v_id' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$gm_note=get_val_con('gnr_x_exemption','note'," vis='$v_id' and c_type=$cType "); 
             if($gm_note) echo '<div class="f1 fs16 lh30 clr1">'.k_management_notes.'</div>
			 <div class="f1 fs12 lh20 clr5">'.$gm_note.'</div>';
            ?>
            <table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s">
			<? 
			if($pay_type==3){?>
				<tr><th><?=k_services?></th><th width="80"><?=k_price?></th>
				<th width="80"><?=k_includ?></th>
				<th width="80"><?=k_must_be_paid?></th>
				<th><?=k_insurance_status?></th>
				</tr><?
			}else{?>
				<tr><th><?=k_services?></th><th width="80"><?=k_price?></th>
				<th width="80"><?=k_discount?></th>
				<th width="80"><?=k_net_amount?></th></tr><?
			}
            $total1=0;
            $total2=0;
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];
				$offer=$r['offer'];
				list($serviceName,$edit_price,$hPart,$dPart)=get_val('xry_m_services','name_'.$lg.',edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];				
				$edit_priceTxt='';
				if($edit_price){$hos_part=$doc_part=0;$edit_priceTxt='<div class="f1 clr6">'.k_price_det_by_dr.'</div>';}
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $price=$hos_part+$doc_part;					
				
				if($emplo && $price){
					$price=$srvPriceOrg;
				}
				$dis=$price-$pay_net;
				$total1+=$price;
                $total2+=$pay_net;
				//if(_set_jqqjli38k7)
				$offerText=getSrvOfeerS($offer,$cType,$v_id,$s_id);
				$msg='';
				if($rev && $pay_net==0){$msg='<div class="f1 clr5">'.k_review.'</div>';}
                echo '<tr>					
                <td class="f1">'.$serviceName.$msg.$edit_priceTxt.$offerText.'</td>
                <td><ff>'.number_format($price).'</ff></td>
                <td><ff>'.number_format($dis).'</ff></td>
                <td><ff>'.number_format($pay_net).'</ff></td>';
				if($pay_type==3){
					$insurS='-';
					if($status==0){$insurS='<span class="clr5 f1 fs14">'.k_not_included.'</span>';}
					
					$cancelServ='';
					$sur=getRecCon('gnr_x_insurance_rec'," service_x='$s_id' and mood=3");
					$in_status=$sur['res_status'];
					$in_s_date=$sur['s_date'];
					$in_r_date=$sur['r_date'];
					$ref_no=$sur['ref_no'];
					$incPerc='';
					if($in_status==2){$cancelServ='<div class="bu2 bu_t3 buu f1 fs14 clr5" onclick="delServ('.$s_id.','.$cType.')">'.k_cncl_serv.'</div>';}
					if($in_status==1){
						$incPerc=' <ff> ('.(100-($dis*100/$price)).'%)</ff>';
					}
					if($in_status!=''){$insurS=$reqStatusArr[$in_status];}
					echo '<td><div class="f1 fs14 '.$insurStatusColArr[$in_status].'" >'.$insurS.$incPerc.' <br><ff> '.$ref_no.'<ff></div>'.$cancelServ.'</td>';
				}
                echo '</tr>';
            }?>
            <tr bgcolor="#ddd">					
            <td class="f1 B"><?=k_total?></td>
            <td class="fs18 ff B"><?=number_format($total1)?></td>
            <td class="fs18 ff B"><?=number_format($total1-$total2)?></td>
            <td class="fs18 ff B"><?=number_format($total2)?></td>
			<? if($pay_type==3){echo '<td></td>';}?>
            </tr>
            </table><?
		}
		?></div>
		<div class="form_fot fr"><? 
			if($rows>0){?>
            <div class="cb">
				<div class="bu bu_t4 fl" onclick="printReceipt(<?=$v_id?>,3)"><?=k_pymt?> <ff> ( <?=number_format($total2)?> )</ff></div>
                <? if($pay_type==0){?>
                	<? if(_set_hw3wi89dnk){?><div class="bu bu_t1 fr" onclick="chgPayType(1,<?=$v_id?>,<?=$cType?>)">إعفاء</div><? }?>
                	<div class="bu bu_t1 fr w-auto " onclick="chgPayType(2,<?=$v_id?>,<?=$cType?>)"><?=k_the_charity?></div>
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
			<div class="bu bu_t1 fl" onclick="serNPat_do(0,<?=$v_id?>)"><?=k_edit?></div>
			<?}?>
            </div>
		</div>
    	</div><?	
	}else{
		delTempOpr($cType,$v_id,'a');
		echo script("win('close','#m_info');");
		
	}
}?>