<? include("../../__sys/prcds/ajax_header.php");?>
<div class="pd10" style="max-width:600px"><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRecCon('gnr_x_temp_oprs'," type=2 and id='$id' ");
	if($r['r']){
		$id=$r['id'];
		$type=$r['type'];
		$pat_name=$r['pat_name'];
		$pat=$r['patient'];
		$mood=$r['mood'];
		$clinic=$r['clinic'];
		$vis=$r['vis'];
		$status=$r['status'];
		$sub_status=$r['sub_status'];
		$sx_table=$srvXTables[$mood];
		$sm_table=$srvTables[$mood];
		if($status==0){echo '<div class="fr ic30 ic30_del icc2 ic30Txt mg10v" onclick="payTypeReqCancle(2,'.$id.')">'.k_req_del.'</div>';}
		echo '<div class="f1 fs16 clr1111 lh50 uLine">'.$pat_name.'</div>';	
		list($actChr,$unhcr_num)=get_val_con('gnr_x_charities_srv','charity,unhcr_num'," patient='$pat' "," order by id DESC");
		if($status==0){?>		
			<form name="ch_form" id="ch_form" action="<?=$f_path?>X/gnr_charity_save.php" method="post"  cb="chr_ref(1,<?=$id?>);" bv="">
			<input type="hidden" name="id" value="<?=$id?>"/>			
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td n><?=k_the_charity?><span> *</span> :</td>
					<td i><?=make_Combo_box('gnr_m_charities','name_'.$lg,'id'," ",'char',1,$actChr,' t onchange="showChar(this.value)"');?></td>
				</tr>
				<tr>
					<td n><?=k_unhcr_num?> :</td>
					<td i><input type="text" name="unhcr_num" value="<?=$unhcr_num?>"/></td>
				</tr>
				<tr>
					<td n><?=k_referral_num?> :</td>					
					<td i><input type="text" name="rec_no" value=""/></td>
				</tr>
			</table>		
			<div class="lh10 cb">&nbsp;</div>
			<div id="charInfo" class="fl w100"></div>
			<?
			$sql="select * from  $sx_table where visit_id='$vis' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$saveButt=0;
			if($rows>0){
				$subPart='';
				if($mood!=2 && $clinic){$subPart=' - '.get_val('gnr_m_clinics','name_'.$lg,$clinic);}
				echo '<div class="f1 lh40 fs16 fl " fix="wp:0">'.$clinicTypes[$mood].$subPart.'</div>';
				?>
				<div class="f1 fs14 clr5 lh30">يمكنك تغيير قيمة التغطية</div>
				<table width="100%" border="0" type="static" cellspacing="10" cellpadding="0" class="disTable">
					<tr><?
					$dis_arr=array(0,10,15,20,25,30,35,40,50,60,80,100);
					$actDis=100;
					foreach($dis_arr as $d){
						$act='';
						if($actDis==$d){$act='act';}
						echo '<td width="'.(100/count($dis_arr)).'%" no="'.$d.'" '.$act.'>'.$d.'%</td>';
					}
					?>
					</tr>
					<tr>
					<td colspan="<?=count($dis_arr)?>">
						<input type="number" disInp placeholder="نسبة مخصصة"/></td>
					</tr>
				</table>
				<table border="0" width="100%" type="static" cellspacing="0" cellpadding="2" class="grad_s">
				<tr><th><?=k_service?></th><th width="80"><?=k_price?></th>
					<th width="80"><?=k_char_coverage?></th>
					<th width="80"><?=k_pat_share?></th>			
				</tr><?
				$total1=0;
				$total2=0;
				while($r=mysql_f($res)){			
					$s_id=$r['id'];
					$service=$r['service'];
					$price=$r['total_pay'];
					$pay_net=$r['pay_net'];
					$s_status=$r['status'];
					if($sub_status==0){$pay_net=0;}				
					$total1+=$price;
					$total2+=$pay_net;
					echo '<tr>					
					<td class="f1">'.get_val($sm_table,'name_'.$lg,$service).'</td>
					<td><ff>'.number_format($price).'</ff></td>
					<td>';				
					if($sub_status==0 || $s_status==2 ){
						$saveButt=1;								
						echo '<input type="number" name="ser'.$s_id.'" class="TC cbg7" 
						value="'.($price-$pay_net).'"  price="'.$price.'" no="'.$s_id.'" dis/>';
					}else{
						echo '<ff>'.number_format($price-$pay_net).'</ff>';
						echo '<input type="hidden" value="'.($price-$pay_net).'"  price="'.$price.'" no="'.$s_id.'" dis/>';
					}
					echo'<td class="ff fs18 B" tot="'.$s_id.'"> '.number_format($pay_net).'</td>				
					</tr>';
				}?>
				<tr bgcolor="#ddd">					
					<td class="f1 B"><?=k_total?></td>
					<td class="fs18 ff B"><?=number_format($total1)?></td>			
					<td class="fs18 ff B" id="dis_total"><?=number_format($total1-$total2)?></td>
					<td class="fs18 ff B" id="net_total"><?=number_format($total2)?></td>
				</tr>
				</table><?
			}?>
			</form>
			<div class="bu bu_t3 fl" id="saveButt" onclick="DisChange();sub('ch_form')"><?=k_save?></div><?
		}else{
			echo '<div class="fl w100">'.getCharInfo($sub_status).'</div>';
			$sql="select * from gnr_x_charities_srv where vis='$vis' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$saveButt=0;
			if($rows>0){
				$subPart='';
				if($mood!=2 && $clinic){$subPart=' - '.get_val('gnr_m_clinics','name_'.$lg,$clinic);}
				echo '<div class="f1 lh40 fs16 fl " fix="wp:0">'.$clinicTypes[$mood].$subPart.'</div>';
				?>
				<table border="0" width="100%" type="static" cellspacing="0" cellpadding="2" class="grad_s">
				<tr><th><?=k_service?></th><th width="80"><?=k_price?></th>
					<th width="80"><?=k_char_coverage?></th>
					<th width="80"><?=k_pat_share?></th>			
				</tr><?
				$total1=0;
				$total2=0;
				while($r=mysql_f($res)){				
					$s_id=$r['id'];
					$service=$r['m_srv'];
					$price=$r['srv_price'];
					$srv_covered=$r['srv_covered'];
					$s_status=$r['status'];
					$total1+=$price;
					$total2+=$srv_covered;
					echo '<tr>					
					<td class="f1">'.get_val($sm_table,'name_'.$lg,$service).'</td>
					<td><ff class="clr1">'.number_format($price).'</ff></td>
					<td><ff class="clr5">'.number_format($srv_covered).'</ff></td>
					<td><ff class="clr6">'.number_format($price-$srv_covered).'</ff></td>
					</tr>';
				}?>
				<tr bgcolor="#ddd">					
					<td class="f1 B"><?=k_total?></td>
					<td><ff class="clr1"><?=number_format($total1)?></ff></td>			
					<td><ff class="clr5"><?=number_format($total2)?></ff></td>
					<td><ff class="clr6"><?=number_format($total1-$total2)?></ff></td>
				</tr>
				</table><?
			}
		}
	}
}?>
</div>