<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$cType=2;
	$v_id=pp($_POST['id']);
	$sql="select * from lab_x_visits where id='$v_id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$type=$r['type'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];
		$status=$r['status'];
		$emplo=$r['emplo'];
		if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';}
		$p_name=get_p_name($patient);
		$c_name=k_lab;?>
        <div class="win_body">
            <div class="form_header">
            <div class="fl f1 fs16 clr1 lh40"><?=k_patient?> : <?=get_p_name($patient).$emploTxt?></div>
            <div class="fr f1 fs16 clr1 lh40"><?=$c_name?></div>
			<? if(_set_9iaut3jze){echo offerStatus($cType,$v_id,$patient);}?>
            </div>        
		<div class="form_body so"><?		
		$sql="select * , x.id as x_id , x.fast as x_fast from  lab_m_services z , lab_x_visits_services x where x.visit_id='$v_id' and  x.service=z.id order by x.id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$gm_note=get_val_con('gnr_x_exemption','note'," vis='$v_id' and c_type=2 "); 
             if($gm_note) echo '<div class="f1 fs16 lh30 clr1">'.k_management_notes.'</div>
			 <div class="f1 fs12 lh20 clr5">'.$gm_note.'</div>';
            ?>
            <table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s"><?			
			if($pay_type==3){?>
				<tr><th><?=k_analysis?></th><th width="80"><?=k_tim?></th>
				<th width="80"><?=k_price?></th>
				<th width="80"><?=k_includ?></th>
				<th width="80"><?=k_must_be_paid?></th>
				<th><?=k_insurance_status?></th>
				</tr><?
			}else{?>
				<tr><th><?=k_analysis?></th><th width="80"><?=k_tim?></th>
				<th width="80"><?=k_price?></th>
				<th width="80"><?=k_discount?></th>
				<th width="80"><?=k_net_amount?></th></tr><?
			}
            $total1=0;
            $total2=0;
			$time_max=0;
            while($r=mysql_f($res)){				
                $s_id=$r['x_id'];
                $service=$r['service'];
                $units=$r['units'];
                $units_price=$r['units_price'];
                $pay_net=$r['pay_net'];
				$sample=$r['sample'];
				$fast=$r['x_fast'];
				$name=$r['short_name'];
				$time_req=$r['time_req'];
				$con=$r['conditions'];
				$offer=$r['offer'];
				$time_max=max($time_max,$time_req);
                $price=$units_price*$units;
				
				if($emplo && $price){
					 $price=_set_x6kmh3k9mh*$units;
				}
                $total1+=$price;
                $total2+=$pay_net;
				$dis=$price-$pay_net;
				$msg='';
				$cons='';
				if($con){$cons=get_lab_con($con);}
				$offerText=getSrvOfeerS($offer,$cType,$v_id,$s_id);
				if($fast){$msg='<div class="f1 clr5">'.k_emergency.'</div>';}
                echo '<tr>					
                <td class="f1"><ff>'.$name.$msg.$cons.$offerText.'</ff></td>
                <td><ff>'.number_format($time_req).'</ff></td>
				<td><ff>'.number_format($price).'</ff></td>
                <td><ff>'.number_format($dis).'</ff></td>
                <td><ff>'.number_format($pay_net).'</ff></td>';
				if($pay_type==3){
					$insurS='-';
					$cancelServ='';
					$sur=getRecCon('gnr_x_insurance_rec'," visit='$v_id' and service_x='$s_id' and mood=2 ");
					$in_status=$sur['res_status'];
					$in_s_date=$sur['s_date'];
					$in_r_date=$sur['r_date'];
					$ref_no=$sur['ref_no'];
					if($in_status==2){$cancelServ='<div class="bu2 bu_t3 buu f1 fs14 clr5" onclick="delServ('.$s_id.',2)">'.k_cncl_serv.'</div>';}
					$incPerc='';
					if($in_status==1){$incPerc=' <ff> ('.(100-($dis*100/$price)).'%)</ff>'; }
					if($in_status!=''){$insurS=$reqStatusArr[$in_status];}
					echo '<td><div class="f1 fs14 '.$insurStatusColArr[$in_status].'" >'.$insurS.$incPerc.' <br><ff> '.$ref_no.'<ff></div>'.$cancelServ.'</td>';
				}
                echo '</tr>';
				
            }?>
            <tr bgcolor="#ddd">					
            <td class="f1 B"><?=k_total?></td>
            <td class="fs18 ff B"><?=number_format($time_max)?></td>
            <td class="fs18 ff B"><?=number_format($total1)?></td>            
            <td class="fs18 ff B"><?=number_format($total1-$total2)?></td>
            <td class="fs18 ff B"><?=number_format($total2)?></td>
			<? if($pay_type==3){echo '<td></td>';}?>
            </tr>
            </table>
			
			<?
		}
		?></div>

    <div class="form_fot fr">
    	<div class="cb">
		<div class="bu bu_t4 fl" onclick="printReceipt(<?=$v_id?>,2)"><?=k_pymt?></div>
            <div class="fl"><input type="number" id="l_pay" max="<?=$total2?>" value="<?=$total2?>" style="width:100px; margin:10px; color:#f00"/></div>
            <? if($pay_type==0){
				if(_set_hw3wi89dnk){?>
				<div class="bu bu_t1 fr" onclick="chgPayType(1,<?=$v_id?>,2)"><?=k_req_exmp?></div>
				<? } ?>
				<div class="bu bu_t1 fr w-auto" onclick="chgPayType(2,<?=$v_id?>,2)"><?=k_frw_chrty?></div>
				<? if(_set_rkq2s40u5g){?>
					<div class="bu bu_t1 fr w-auto" onclick="chgPayType(3,<?=$v_id?>,2)"><?=k_insurance?></div>
				<? }?>
            <? }?>
         </div>
		<div class="cb">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
			<div class="bu bu_t3 fl" id="saveButt" onclick="delVis(<?=$v_id?>,2)"><?=k_delete?></div>
		</div>
    </div><?
	}else{
		delTempOpr($cType,$v_id,'a');
		echo script("win('close','#m_info');");
		
	}
}?>