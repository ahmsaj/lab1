<? include("../../__sys/prcds/ajax_header.php");
echo '<div class="pd10" style="max-width:600px">';
if(isset($_POST['id'],$_POST['in'])){
	$id=pp($_POST['id']);
	$insur=pp($_POST['in']);
	$r_req=getRec('gnr_x_temp_oprs',$id);
	if($r_req['r']){
		$mood=$r_req['mood'];
		$clinic=$r_req['clinic'];
		$patient=$r_req['patient'];
		$vis=$r_req['vis'];
		$addNewServis=0;
		$table=$visXTables[$mood];
		$r_visit=getRec($table,$vis);
		$doctor=$r_visit['doctor'];
		$pay_type=$r_visit['pay_type'];
		if($pay_type==3){$addNewServis=1;}
		$acc=0;
		echo '<div class="fl w100 lh50 uLine">';
		if($status==0){
			//echo '<div class="fr ic30 ic30_del icc2 ic30Txt mg10v" onclick="payTypeReqCancle(2,'.$id.')">'.k_req_del.'</div>';
			echo '<div class="fr ic30 ic30_del icc2 ic30Txt mg10v" onclick="insurReqCancle('.$id.','.$mood.')" > '.k_cancel.'</div>';
		}
		echo '<div class="fl f1 fs16 clr1111 lh50 ">'.get_p_name($patient).'</div>';
		echo '</div>'?>
		<form name="in_rec" id="in_rec" action="<?=$f_path?>X/gnr_insur_rec_save.php" method="post" cb="ins_ref();insurResEnter(<?=$id?>);">
			<input type="hidden" name="id" value="<?=$id?>" />
			<div class="fl w100 lh60">
				<div class="fl f1 fs16 lh40 "><?=k_insure_account?> : </div>
				<div class="fr ic30 ic30_add icc4 ic30Txt f1 fs16 clr5 Over" onclick="newInsurAcc(<?=$id.','.$patient?>)"> <?=k_add_account?></div>
			</div><?		
			$sql="select * from gnr_m_insurance_rec where patient='$patient' order by valid DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			
			if(mysql_n($res)){
				$acc=1;
				$i=0;
				$actProv=0;
				echo '<select name="p_insure" onchange="ins_det('.$id.',this.value)">';
				while($r=mysql_f($res)){				
					$insur_id=$r['id'];
					$prov_id=$r['provider'];
					if(!$insur){$insur=$insur_id;}
					$in_prov=get_val('gnr_m_insurance_prov','name_'.$lg,$prov_id);
					$in_com=get_val('gnr_m_insurance_comp','name',$r['company']);
					$text=$r['no'].' | '.$r['valid'].' | '.$in_prov.' | '.$in_com.' | '.$r['class'];
					$sel=" ";
					if($insur==$insur_id || $i==0){
						$sel=" selected ";
						$insue_name=$in_prov.' ( '.$in_com.' )';
						$actProv=$prov_id;
					}
					$i++;
					echo '<option value="'.$insur_id.'" '.$sel.' >'.$text.'</option>';
				}
				echo '</select>';
				echo '<div class="f1 fs12  lh30 clr1111 uLine">'.k_accounts_dont_match_pat_account.' '.k_add_account.'</div>
				';

			}else{
				echo '<div class="fl f1 fs14 clr1 lh40">'.k_pat_dont_has_account.' </div>';
			}			
			if($acc){
				echo '<div class="f1 fs16 lh40">'.k_insure_comp_prices.' : '.$insue_name.'</div>';
				echo '<div class="f1 fs12 lh20 pd10v clr5">'._info_c142m975tv.'</div>';
			}
			if($mood!=2){
				$q='';
				if($addNewServis){
					$lastSrvs=get_vals('gnr_x_insurance_rec','service_x',"visit='$vis' and mood='$mood' ");
					if($lastSrvs){$q=" and id NOT IN ($lastSrvs)";}
				}				
			}else{
				$q='';
				if($acc && $rows>1){$ch='<th width="30"></th>';}
				if($acc){$ch2='<th></th>';}
				$unitPriceInsur=get_val('gnr_m_insurance_prov','lab_unit_price',$actProv);
			}
			$table=$srvXTables[$mood];
			$tableM=$srvTables[$mood];
			$sql="select * from $table where visit_id='$vis' $q ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				if($acc && $rows>1){$ch='<th width="30"></th>';}
				if($acc){$ch2='<th width="30">
					<input type="checkbox" name="" value="1" par="chAll"/></th>';
				}
				$clinicName='';
				if($mood!=2){
					$clinicName=' : '.get_val('gnr_m_clinics','name_'.$lg,$clinic);
				}
				echo '<div class="lh40 fs16 clr1 w100 f1">'.$clinicTypes[$mood].$clinicName.'</div>';
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
				<tr>'.$ch2.'<th>'.k_service.'</th>';
				if($mood==2){
					echo '<th>'.k_test_price.'</th>';
				}else{
					echo '<th>'.k_price_serv.'</th><th>'.k_insure_price.'</th>';
				}
				echo $ch.'</tr>';
				while($r=mysql_f($res)){
					$serv_id=$r['id'];
					$service=$r['service'];	
					$pay_net=$r['pay_net'];
					if($mood==2){
						list($sarvice_name,$unit)=get_val($tableM,'name_'.$lg.',unit',$service);
						$unitPrice=$unitPriceInsur;
						$customPrice=get_val_con('gnr_m_insurance_prices_custom','price'," insur='$actProv' and service='$service' ");
						if($customPrice){$unitPrice=$customPrice;}
						$price=$unit*$unitPrice;
						$insurPrice=$price;
						$customPrice=get_val_con('gnr_m_insurance_prices_custom','price'," insur='$actProv' and service='$service' ");
					
					}else{
						list($sarvice_name,$hos_part,$doc_part)= get_val($tableM,'name_'.$lg.',hos_part,doc_part',$service);
						$price=$hos_part+$doc_part;
						$insurPrice=get_val_con('gnr_m_insurance_prices','price'," insur='$actProv' and type='$mood' and service='$service' ");
					}					
					if($doctor){			
						$newPrice=get_docServPrice($doctor,$service,$mood);
						$newP=$newPrice[0]+$newPrice[1];							
						if($newP){$price=$newP;}
					}					
					$oprs='';
					if($price>0 && $pay_net){
						echo '<tr>';
						if($acc){
							echo '<td>';
							if($insurPrice){
								echo '<input type="checkbox" name="s_'.$serv_id.'"  value="1" par="s"/>';
							}else{
								echo '-';
							}
							echo '</td>';
						}
						echo '<td txt>'.$sarvice_name.'</td>
						<td><ff>'.number_format($price).'</ff></td>';
						if($mood!=2){
							echo '<td><ff>'.$customPrice.''.number_format($insurPrice).'</ff></td>';
						}
						if($acc && $rows>1){
							echo '<td>';
							if($insurPrice){echo '<div class="ic30 icc2 ic30_del" onclick="delSerINsur('.$serv_id.','.$vis.','.$mood.')"></div>';}
							echo '</td>';
						}
						echo '</tr>';
					}					
				}
			}
			echo '</table>';
			?>
		</form>
		<? 
		if($acc){
			?><div class="fl bu bu_t1 fl buu mg10v uLine" onclick="sendInsurReq()"><?=k_create?></div>
			<div class="cb">&nbsp;</div><? 
		}
	}
}
echo '</div>';?>