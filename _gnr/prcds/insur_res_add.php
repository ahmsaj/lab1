<? include("../../__sys/prcds/ajax_header.php");
echo '<div class="pd10 " style="max-width:600px">';
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r_req=getRec('gnr_x_temp_oprs',$id);
	if($r_req['r']){
		$mood=$r_req['mood'];
		$clinic=$r_req['clinic'];
		$patient=$r_req['patient'];
		$vis=$r_req['vis'];		
		$table=$visXTables[$mood];		
		echo '<div class="fl w100 lh50 f1 fs16 clr1111 uLine">'.get_p_name($patient).'</div>';
		$r=getRecCon('gnr_x_insurance_rec',"mood='$mood' and visit='$vis' order by ref_no DESC");
		if($r['r']){
			$company=$r['company'];
			$ref_no=$r['ref_no'];
			$r2=getRec('gnr_m_insurance_rec',$r['insur_id']);
			if($r2['r']){			
				$prov_id=$r2['provider'];				
				$in_prov=get_val('gnr_m_insurance_prov','name_'.$lg,$prov_id);
				$in_com=get_val('gnr_m_insurance_comp','name',$company);
				$text=$in_prov.' | '.$in_com.'  <br> 
				<span class="clr5 fs16 B ff">'.$r2['no'].'</span> | <ff14>'.$r2['class'].' | '.$r2['valid'].'</ff14>';
				echo '<div class="w100 f1 fs16 lh30 clr1">'.k_insure_account.' : '.$text.'</div>';
			
			}
		}
		$sql="select  * from gnr_x_insurance_rec where mood='$mood' and visit='$vis'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){?>
			<form name="in_rec" id="in_rec" action="<?=$f_path?>X/gnr_insur_res_save.php" method="post" cb="insurResEnter(<?=$id?>)">
			<input type="hidden" name="id" value="<?=$id?>" />
			<div class="f1 fs14 lh50 " inputHolder><?=k_insure_invoice_num?> : 
			<? if($ref_no){
				echo '<ff>'.$ref_no.'</ff><input type="hidden" fix="w:150" name="req_no" value="'.$ref_no.'" required >';
			}else{
				echo '<input type="text" fix="w:150" name="req_no" value="'.$ref_no.'" required >';
			}?>
			</div>
			<?
			if(getTotalCO('gnr_x_insurance_rec',"mood='$mood' and visit='$vis' and status=0")){?>
			<table width="100%" border="0" type="static" cellspacing="10" cellpadding="0" class="disTable">
				<tr><?
				$dis_arr=array(0,10,15,20,25,30,35,40,50,60,80,100);
				$actDis=100;
				foreach($dis_arr as $d){
					$act='';
					if($actDis==$d){$act='act';}
					echo '<td width="'.(100/count($dis_arr)).'%" no="'.$d.'" '.$act.'>'.$d.'%</td>';
				}?>
				</tr>
				<tr>
					<td colspan="<?=count($dis_arr)?>"><input type="number" disInp placeholder="نسبة مخصصة"/></td>
				</tr>
			</table>
			<? }
			$clinicName='';
			if($mood!=2){
				$clinicName=' : '.get_val('gnr_m_clinics','name_'.$lg,$clinic);
			}
			echo '<div class="lh40 fs16 clr1 w100 f1">'.$clinicTypes[$mood].$clinicName.'</div>';?>
			<table width="100%" border="0" class="grad_s selList" type="static" cellspacing="0" cellpadding="4" over="0">
			<tr>
				<th width="30"><input type="checkbox" name="" value="1" checked par="chAll"/></th>			
				<th><?=k_service?></th>
				<th><?=k_price_serv?></th>
				<th width="100"><?=k_pat_share?></th>
				<th><?=k_includ?></th>
				<th class="cbg55"><?=k_reject?></th>
				<th class="cbg66"><?=k_accept?></th>
			</tr><?	
			while($r=mysql_f($res)){
				$in_id=$r['id'];
				$insur_no=$r['insur_no'];
				$mood=$r['mood'];
				$service=$r['service'];
				$in_price=$r['in_price'];
				$res_status=$r['res_status'];
				$in_price_includ=$r['in_price_includ'];
				$s_date=$r['s_date'];
				$status=$r['status'];
				$visit=$r['visit'];
				if($in_price_includ==0){$in_price_includ=$in_price;}				
				$ser_name=get_val($srvTables[$mood],'name_'.$lg,$service);
				$inCover=$in_price-$in_price_includ;?>
				<tr>
					<td><? if($status==0){echo '<input type="checkbox" name="srv_'.$in_id.'" checked value="1" par="s"/>';}else{echo '-';}?></td>
					<td txt><?=$ser_name?></td>
					<td><ff id="oPrice"><?=$in_price?></ff></td>
					<td><?				
					if($status==0){
						$saveButt=1;							
						echo '<input type="number" name="ser'.$in_id.'" class="TC cbg7" 
						value="'.($inCover).'"  price="'.$in_price.'" no="'.$in_id.'" dis />';
					}else{
						echo '<ff>'.number_format($inCover).'</ff>';											}
					echo '<td class="ff fs18 B" tot="'.$in_id.'">'.number_format($in_price_includ).'</td>';
					if($status==0){?>
						<td class="cbg555"><input type="radio" name="s_<?=$in_id?>"  value="2" par="s"/></td>
						<td class="cbg666"><input type="radio" name="s_<?=$in_id?>"  checked value="1" par="s"/></td><? 
					}else{
						$stTxt=k_accepted;
						$cls="cbg666";
						if($res_status==2){$stTxt=k_rejected;$cls="cbg555 ";}
						echo '<td class="f1 fs12 '.$cls.'" colspan="2">'.$stTxt.'</td>';
					}?>
				</tr><?
			}?>
			</table>
			</form><?
		}
		
		/*if($status==0){?>
			<div class="bu bu_t4 fl" onclick="insurReqSave(<?=$id?>,1)"><?=k_accept?></div>			
			<div class="bu bu_t3 fl" onclick="insurReqSave(<?=$id?>,2)"><?=k_reject?></div>
		<? }*/
		if($saveButt){
			?><div class="bu bu_t1 fl" onclick="insurReqSave();"><?=k_save?></div>
			<div class="cb">&nbsp;</div><?
		}
	}
}
echo '</div>';?>
