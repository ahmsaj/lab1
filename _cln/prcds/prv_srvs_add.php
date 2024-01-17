<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($pay_type,$vis_status,$doc)=get_val('cln_x_visits','pay_type,status,doctor',$id);
	$p_id=get_val('cln_x_visits','patient',$id);	
	$c=$userSubType;
	$m_clinic=getMClinic($c);?>
	<div class="win_body">
	<div class="form_header" type="full">
		<div class="fr serTotal ff fs18 B" id="serTotal">0</div>
        <div class="f1 fs18 lh40"><?=get_p_name($p_id)?></div>
		<div class="lh50"><input type="text" placeholder="<?=k_search?>" id="servSelSrch"/></div>
        </div>
        <div class="form_body so" type="pd0"><?
		if($vis_status==1){
			$alreadyServ=array();						
			$sql="select service , status , id from cln_x_visits_services where visit_id='$id' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$i=0;
				while($r=mysql_f($res)){
					$alreadyServ[$i]['id']=$r['id'];
					$alreadyServ[$i]['service']=$r['service'];
					$alreadyServ[$i]['status']=$r['status'];
					$i++;
				}
			}
			$sql="select * from cln_m_services where clinic in($m_clinic) and act=1 order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				if($pay_type==3){
					$insur_id=get_val_con('gnr_x_insurance_rec','insur_id',"visit='$id' and mood=1 ");
					$insur_company=get_val('gnr_m_insurance_rec','provider',$insur_id);
				}
				?>
				<form name="n_visit" id="n_visit" action="<?=$f_path?>X/cln_prv_srvs_add_do.php" method="post"  cb="loadService(1);" bv="">
                <input type="hidden" name="id" value="<?=$id?>"/>
				
                <table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_multip?></th><th width="80"><?=k_price?></th>
				<? if($prv_Type==2)echo '<th width="50">'.k_free_rev.'</th>'?></tr><?
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$name=$r['name_'.$lg];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$rev=$r['rev'];					
					$multi=$r['multi'];
					$price=$hos_part+$doc_part;
					$edit_price=$r['edit_price'];
					$edit_priceTxt='';
					if($edit_price){
						$price=0;$edit_priceTxt='<div class="f1 clr6">'.k_price_det_by_dr.'</div>';
					}else{
						if($price && $doc){	
							$newPrice=get_docServPrice($doc,$s_id,1);
							$newP=$newPrice[0]+$newPrice[1];							
							if($newP){$price=$newP;}
						}
					}
					$muliTxt='-';
					if($multi){$muliTxt='<input type="number" name="m_'.$s_id.'" qunt value="1" min="1" max="15"/>';}					
					if($prv_Type==2 && $rev){$price=0;$price2='-';$price3='-';}					
					$bg='';
					$ch='';
					foreach($alreadyServ as $data){
						if($s_id==$data['service'] && $multi==0){
							if($data['status']!=3 ){$bg='#eeeeee';}
						}												
					}
					echo '<tr bgcolor="'.$bg.'" serName="'.$name.'" no="'.$s_id.'"><td>';
					if($bg==''){echo '<input type="checkbox" value="'.$s_id.'" name="ser[]" par="ceckServ" value="'.$price.'" '.$ch.' />';}
					if($pay_type==3){
						$insurMsg='';
						$insur_price=get_val_con('gnr_m_insurance_prices','price'," insur='$insur_company' and service='$s_id' and type=1 ");
						if(!$insur_price){
							$insurMsg='<div class="f1 clr5">'.k_ser_not_ins.'</div>';
						}else{$price=$insur_price;}
					}
					echo '</td>
					<td class="f1">'.$name.$insurMsg.$edit_priceTxt.'</td>
					<td class="f1">'.$muliTxt.'</td>					
					<td><ff id="p3_'.$s_id.'">'.number_format($price).'<ff></td>';
					if($prv_Type==2){
						if($rev){$r_text=k_yes;$col='clr6';}else{$r_text=k_no;$col='clr5';}
						echo '<td><div class="f1 '.$col.'">'.$r_text.'</div></td>';
					}
					echo '</tr>';
				}?>
				</table></form><?
			}	
		}
	?></div>
        <div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        <? if($vis_status==1){?>
        <div class="bu bu_t3 fl" onclick="addSrvDo();"><?=k_save?></div><? }?>
		</div>
        </div><?
	}
?>