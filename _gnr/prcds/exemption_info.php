<? include("../../__sys/prcds/ajax_header.php");?>
<div class="pd10" style="max-width:600px"><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRecCon('gnr_x_temp_oprs'," type=1 and id='$id' ");
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
		$vx_table=$visXTables[$mood];
		$sx_table=$srvXTables[$mood];
		$sm_table=$srvTables[$mood];
        list($reason,$reg_user)=get_val($vx_table,'pay_type_link,reg_user',$vis);
		if($status==0){echo '<div class="fr ic30 ic30_del icc2 ic30Txt mg10v" onclick="payTypeReqCancle(1,'.$id.')">'.k_req_del.'</div>';}
		echo '<div class="f1 fs16 clr1111 lh50 uLine">'.$pat_name.'</div>';
		if($status==0){?>		
			<form name="ex_form" id="ex_form" action="<?=$f_path?>X/gnr_exemption_accept.php" method="post"  cb="exe_det(<?=$id?>);" bv="">
			<input type="hidden" name="id" value="<?=$id?>"/>					
			
			<?
			$sql="select * from  $sx_table where visit_id='$vis' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$saveButt=0;
			if($rows>0){
				$subPart='';
				$cData=getColumesData('bvuuurmscw',1);
				if($mood!=2 && $clinic){$subPart=' - '.get_val('gnr_m_clinics','name_'.$lg,$clinic);}
				echo '<div class="f1 lh30 fs16 fl clr66" fix="wp:0">'.$clinicTypes[$mood].$subPart.'</div>';
                if($reg_user){
                    echo '<div class="f1 lh30 fs12 fl clr66" fix="wp:0">'.k_user.': '.get_val('_users','name_'.$lg,$reg_user).'</div>';                    
                }
				?>
				<div class="f1 fs16 lh30 clr1"><?=k_ent_reas_exmpt?></div>
				<div class=" fl w100 uLine">
				<?=make_Combo_box('gnr_m_exemption_reasons','reason','id','','reason',0,'','','')?>
				</div>
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
					<th width="80"><?=k_discount?></th>
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
				</table>
				<div class="note_contt">
					<div class="f1 fs16 lh30 clr1"><?=k_management_notes?></div>
					<textarea name="note" t class="w100" fix="h:120"></textarea>
				</div><?
			}?>
			</form>
			<div class="bu bu_t3 fl" id="saveButt" onclick="DisChange();sub('ex_form')"><?=k_save?></div><?
		}else{			
			$sql="select * from gnr_x_exemption_srv where vis='$vis' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$saveButt=0;
			if($rows>0){
				$subPart='';
				if($mood!=2 && $clinic){$subPart=' - '.get_val('gnr_m_clinics','name_'.$lg,$clinic);}
				echo '<div class="f1 lh40 fs16 fl " fix="wp:0">'.$clinicTypes[$mood].$subPart.'</div>';
				if($reg_user){
                    echo '<div class="f1 lh30 fs12 fl clr66" fix="wp:0">'.k_user.': '.get_val('_users','name_'.$lg,$reg_user).'</div>';
                    
                }
				if($reason){
					$reasonsTxt=get_val('gnr_m_exemption_reasons','reason',$reason);
					echo '<div class=" f1 fs14 clr5 fl w100 lh40">'.k_reason_exemption.' : '.$reasonsTxt.'</div>';
				}                ?>
				
				<table border="0" width="100%" type="static" cellspacing="0" cellpadding="2" class="grad_s">
				<tr><th><?=k_service?></th><th width="80"><?=k_price?></th>
					<th width="80"><?=k_discount?></th>
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
				$note=get_val_con('gnr_x_exemption_notes','note'," vis='$vis' and mood='$mood' ");
				if($note){					
					echo '<div class=" f1 fs14 clr55 fl w100 lh40">'.k_management_notes.' : '.$note.'</div>';
				}	
			}
		}
	}
}
?>
</div>