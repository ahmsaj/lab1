<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mood'],$_POST['vis'])){
	$pat=pp($_POST['id']);
	$mood=pp($_POST['mood']);
	$vis=pp($_POST['vis']);
	if(isset($_POST['o'])){ 
		$offer=$_POST['o'];
		$sql="SELECT * from gnr_m_offers where id='$offer' and act= 1 ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$r=mysql_f($res);
			$id=$r['id'];
			$name=$r['name'];
			$type=$r['type'];
			$date_e=$r['date_e'];
			$sett=$r['sett'];
			$sett_arr=explode('|',$sett);
			$srvs=get_vals($srvXTables[$mood],'service',"visit_id='$vis'",'arr');
			echo '<div class="b_bord f1 fs18 clr1 lh40 mg10" fix="h:40">'.$name.' <span class="f1 fs14 clr5"> [ 
			 '.k_offer_valid_until.' : <ff dir="ltr">'.date('Y-m-d',$date_e).'</ff> ]</span></div>
			<div class="ofx so mg10" fix="hp:40">';			
			if($type==1){
				$r2=getRecCon('gnr_x_offers'," patient='$pat' and offer_id='$offer' and status=0 ");
				if($r2['r']){
					$x_id=$r2['id'];
					$price=$r2['price'];
					$sql3="select * from gnr_x_offers_items where  patient='$pat' and offer_id='$offer'";
					$res3=mysql_q($sql3);
					$rows3=mysql_n($res3);
					if($rows3){
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" over="0">
						<tr><th>'.k_department.'</th><th>'.k_service.'</th><th>'.k_status.'</th></tr>';
						while($r3=mysql_f($res3)){
							$statusTxt=k_srv_not_disbursed;
							$col='clr1';
							$srv_id=$r3['id'];
							$srv_mood=$r3['mood'];
							$srv=$r3['service'];
							$o_vis=$r3['vis'];
							$date=$r3['date'];
							$o_status=$r3['status'];
							$serTxt=get_val_arr($srvTables[$srv_mood],'name_'.$lg,$srv,'srv'.$srv_mood);						
							$subVal=get_val_arr($srvTables[$srv_mood],$subTablesOfferCol[$srv_mood],$srv,'cl'.$srv_mood);
							$subTxt=get_val_arr($subTablesOfeer[$srv_mood],'name_'.$lg,$subVal,'sub'.$srv_mood);
							$cobg='';
							if($o_status==1){
								$statusTxt=k_srv_bought_on.' <ff dir="ltr">'.date('Y-m-d',$date).'</ff>';
								$statusTxt.='<br>'.k_visit_num.' <ff dir="ltr"> ( '.$o_vis.' )</ff>';
								$col='clr5';
								$cobg='cbg44';
							}							
							if(in_array($srv,$srvs) && $mood==$srv_mood && $o_status==0){
								$statusTxt='<div class="fr bu2 buu bu_t4" onclick="offTakeSrv('.$srv_id.','.$vis.','.$offer.')">'.k_srv_exchng.'</div>';
								$col='clr6';
							}
							echo '<tr class="'.$cobg.'">							
							<td txt>'.$clinicTypes[$srv_mood].'</td>
							<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
							<td><div class="f1 fs14 '.$col.' ">'.$statusTxt.'</div></td>						
							</tr>';
						}
						echo '</table>';
					}
				}else{
					$sql="select * from gnr_m_offers_items where offers_id='$offer' ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					$rowTxt='';
					if($rows){
						$totPrice=0;
						$totM_price=0;
						while($r2=mysql_f($res)){
							$totPrice+=$r2['price'];
							$mood=$r2['mood'];
							$srv=$r2['service'];
							$mood=$r2['mood'];
							$m_price=getSrvPrice($mood,$srv);
							$totM_price+=$m_price;
							$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
							$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
							$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
							
							$rowTxt.='<tr>
								<td txt>'.$clinicTypes[$mood].'</td>
								<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
								<td><ff>'.number_format($m_price).'</ff></td>
							</tr>';
						}			
					}
					echo '<div class="" fix="h:50">
						<div class="fl ic40x icc1 ic40_print" onclick="print4(3,'.$id.')"></div>
						<div class="fr bu bu_t4 buu " onclick="saveOffer('.$pat.','.$offer.',2)">'.k_buy.'</div>
						<div class="fl f1 fs16 clr6 lh40 pd10">'.k_offer_val.'<ff>[ '.number_format($totPrice).' ]</ff></div> 
						<div class="fl f1 fs16 clr5 lh40 pd10"> '.k_bfr_offer.' <ff>[ '.number_format($totM_price).' ]</ff></div>
						</div>
					';
					if($rows){			
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
						<tr><th>'.k_department.'</th><th>'.k_service.'</th><th>'.k_price_serv.'</th></tr>'.$rowTxt.'</table>';
					}
					
				}
			}
			if($type==2){
				$qs='';
				if($mood!=4){$qs=' and status=0 ';}				
				$visSevice=get_vals($srvXTables[$mood],'service',"visit_id='$vis' $qs and offer=0",' , ');
				if($visSevice){
					$sql="select * from gnr_m_offers_items where offers_id='$offer'  and service in($visSevice) ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					$rowTxt='';
					if($rows){
						echo '
						<div class="f1 fs18 clr1 lh40">'.k_offer_srvcs.'</div>
						<form id="offSave" name="offSave" action="'.$f_path.'X/gnr_offers_rec_srv_add.php" method="post" cb="showOfferD('.$offer.')">
						<input type="hidden" name="offer" value="'.$offer.'"/>
						<input type="hidden" name="pat" value="'.$pat.'"/>
						<input type="hidden" name="vis" value="'.$vis.'"/>
						<input type="hidden" name="mood" value="'.$mood.'"/>

						<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
						<tr><th width="30"></th><th>'.k_department.'</th><th>'.k_service.'</th></tr>';	
						while($r2=mysql_f($res)){ 							
							$off_id=$r2['id'];
							$mood=$r2['mood'];
							$srv=$r2['service'];
							$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
							$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
							$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
							echo '<tr>
								<td txt><input type="checkbox" name="srv[]" value="'.$srv.'" checked /></td>
								<td txt>'.$clinicTypes[$r2['mood']].'</td>
								<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
							</tr>';
						}	
							
						echo '</table>
						</form>
						<div class="fl bu bu_t3 " onclick="saveOfferT2()">'.k_offer_act_on_sel_srvcs.'</div>';
					}else{
						echo '<div class="f1 fs18 clr5 lh40">'.k_no_srvcs_match_visit_in_offer.'</div>';
					}
				}
				
			}
			if($type==3){
				$table=$srvXTables[$mood];
				$sett_arr2=explode(',',$sett_arr[0]);
				$disPerc=$sett_arr2[$mood-1];
				$sql="select * from $table where visit_id='$vis' and status=0 and offer=0" ;
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$rowTxt='';
				if($rows){				
					echo '
					<div class="f1 fs18 clr1 lh40">'.k_offer_srvcs.'</div>
					<div class="f1 fs16 clr5 lh20">'.k_discount_percent.' <ff>( '.$disPerc.'% )</ff></div>
					<form id="offSave" name="offSave" action="'.$f_path.'X/gnr_offers_rec_srv_add.php" method="post" cb="showOfferD('.$offer.')">
					<input type="hidden" name="offer" value="'.$offer.'"/>
					<input type="hidden" name="pat" value="'.$pat.'"/>
					<input type="hidden" name="vis" value="'.$vis.'"/>
					<input type="hidden" name="mood" value="'.$mood.'"/>

					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
					<tr><th width="30"></th><th>'.k_department.'</th><th>'.k_service.'</th></tr>';	
					while($r2=mysql_f($res)){							
						$srv_id=$r2['id'];						
						$srv=$r2['service'];
						$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
						$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
						$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
						echo '<tr>
							<td txt><input type="checkbox" name="srv[]" value="'.$srv.'" checked /></td>
							<td txt>'.$clinicTypes[$mood].'</td>
							<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
						</tr>';
					}	

					echo '</table>
					</form>
					<div class="fl bu bu_t3 " onclick="saveOfferT2()">'.k_offer_act_on_sel_srvcs.'</div>';
				}else{
					echo '<div class="f1 fs18 clr5 lh40">'.k_no_srvcs_in_visit_without_offrs.'</div>';
				}
				
				
			}
			if($type==4){
				if(getTotalCO('gnr_x_offers_patient',"patient='$pat' and  offer='$offer'")){
					$table=$srvXTables[$mood];
					$sett_arr2=explode(',',$sett_arr[0]);
					$disPerc=$sett_arr2[$mood-1];
					$sql="select * from $table where visit_id='$vis' and status=0 and offer=0" ;
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					$rowTxt='';
					if($rows){				
						echo '
						<div class="f1 fs18 clr1 lh40">'.k_offer_srvcs.'</div>
						<div class="f1 fs16 clr5 lh20">'.k_discount_percent.'  <ff>( '.$disPerc.'% )</ff></div>
						<form id="offSave" name="offSave" action="'.$f_path.'X/gnr_offers_rec_srv_add.php" method="post" cb="showOfferD('.$offer.')">
						<input type="hidden" name="offer" value="'.$offer.'"/>
						<input type="hidden" name="pat" value="'.$pat.'"/>
						<input type="hidden" name="vis" value="'.$vis.'"/>
						<input type="hidden" name="mood" value="'.$mood.'"/>

						<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
						<tr><th width="30"></th><th>'.k_department.'</th><th>'.k_service.'</th></tr>';	
						while($r2=mysql_f($res)){							
							$srv_id=$r2['id'];						
							$srv=$r2['service'];
							$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
							$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
							$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
							echo '<tr>
								<td txt><input type="checkbox" name="srv[]" value="'.$srv.'" checked /></td>
								<td txt>'.$clinicTypes[$mood].'</td>
								<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
							</tr>';
						}	

						echo '</table>
						</form>
						<div class="fl bu bu_t3 " onclick="saveOfferT2()">'.k_offer_act_on_sel_srvcs.'</div>';
					}else{
						echo '<div class="f1 fs18 clr5 lh40">'.k_no_srvcs_in_visit_without_offrs.'</div>';
					}
				}else{
					echo '<div class="f1 fs16 clr5 lh40">'.k_can_identify_pat.' ( '.get_p_name($pat).' ) '.k_offer_beneficiary.'</div>';
					echo '<div class="fl bu buu bu_t4" onclick="linkPatOffer('.$pat.','.$offer.')">'.k_identify_pat.' </div>';
				}			
			}
			if($type==5){				
				$table=$srvXTables[$mood];
				$sett_arr2=explode(',',$sett_arr[0]);
				$disPerc=$sett_arr2[$mood-1];
				$sql="select * from $table where visit_id='$vis' and status=0 and offer=0" ;
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$rowTxt='';
				if($rows){				
					echo '
					<div class="f1 fs18 clr1 lh40">'.k_offer_srvcs.'</div>
					<div class="f1 fs16 clr5 lh20">'.k_discount_percent.'<ff>( '.$disPerc.'% )</ff></div>
					<form id="offSave" name="offSave" action="'.$f_path.'X/gnr_offers_rec_srv_add.php" method="post" cb="cobonAddOut(\'[1]\','.$offer.')" bv="id" >
					<input type="hidden" name="offer" value="'.$offer.'"/>
					<input type="hidden" name="pat" value="'.$pat.'"/>
					<input type="hidden" name="vis" value="'.$vis.'"/>
					<input type="hidden" name="mood" value="'.$mood.'"/>
					<div class="f1 fs18 clr1 lh40">'.k_srv_chos.' </div>
					<div inputHolder class="lh50 pd10">
					<select name="srv" t >';
					while($r2=mysql_f($res)){							
						$srv_id=$r2['id'];						
						$srv=$r2['service'];
						$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
						$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
						$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
						echo '<option value="'.$srv.'" t>							
							'.$clinicTypes[$mood].' | '.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</option>
						</option>';
					}
					echo '</select>
					</div>';
					if($sett_arr[1]){
						echo '<div class="f1 fs18 clr1 lh40">'.k_coupon_num.'</div>
						<div inputHolder class="lh50 pd10">
						<input type="text" name="cobon" value=""  required  />
						</div>';
					}
					echo '</form>
					<div class="fl bu bu_t3 " onclick="sub(\'offSave\')">'.k_coupno_exchng.'</div>';
				}else{
					echo '<div class="f1 fs18 clr5 lh40">'.k_no_srvcs_in_visit_without_offrs.'</div>';
				}
							
			}
			if($type==6){
				$r2=getRecCon('gnr_x_offers'," patient='$pat' and offer_id='$offer' and status=0 ");
				if($r2['r']){
					$x_id=$r2['id'];
					$price=$r2['price'];
					$sql3="select * from gnr_x_offers_items where  patient='$pat' and offer_id='$offer'";
					$res3=mysql_q($sql3);
					$rows3=mysql_n($res3);
					if($rows3){
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" over="0">
						<tr><th>'.k_department.'</th><th>'.k_service.'</th><th>'.k_status.'</th></tr>';
						while($r3=mysql_f($res3)){
							$statusTxt=k_srv_not_disbursed;
							$col='clr1';
							$srv_id=$r3['id'];
							$srv_mood=$r3['mood'];
							$srv=$r3['service'];
							$o_vis=$r3['vis'];
							$date=$r3['date'];
							$o_status=$r3['status'];
							$serTxt=get_val_arr($srvTables[$srv_mood],'name_'.$lg,$srv,'srv'.$srv_mood);
							$subVal=get_val_arr($srvTables[$srv_mood],$subTablesOfferCol[$srv_mood],$srv,'cl'.$srv_mood);
							$subTxt=get_val_arr($subTablesOfeer[$srv_mood],'name_'.$lg,$subVal,'sub'.$srv_mood);
							$cobg='';
							if($o_status==1){
								$statusTxt=k_srv_bought_on.' <ff dir="ltr">'.date('Y-m-d',$date).'</ff>';
								$statusTxt.='<br>'.k_visit_num.' <ff dir="ltr"> ( '.$o_vis.' )</ff>';
								$col='clr5';
								$cobg='cbg44';
							}							
							if(in_array($srv,$srvs) && $mood==$srv_mood && $o_status==0 ){
								$statusTxt='<div class="fr bu2 buu bu_t4" onclick="offTakeSrv('.$srv_id.','.$vis.','.$offer.')">'.k_srv_exchng.'</div>';
								$col='clr6';
							}
							echo '<tr class="'.$cobg.'">							
							<td txt>'.$clinicTypes[$srv_mood].'</td>
							<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
							<td><div class="f1 fs14 '.$col.' ">'.$statusTxt.'</div></td>						
							</tr>';
						}
						echo '</table>';
					}
				}else{
					$sql="select * from gnr_m_offers_items where offers_id='$offer' ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					$rowTxt='';
					if($rows){
						$totPrice=0;
						$totM_price=0;
						while($r2=mysql_f($res)){
							$totPrice+=$r2['price'];
							$mood=$r2['mood'];
							$srv=$r2['service'];
							$mood=$r2['mood'];
							$m_price=getSrvPrice($mood,$srv);
							$totM_price+=$m_price;
							$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
							$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
							$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
							
							$rowTxt.='<tr>
								<td txt>'.$clinicTypes[$mood].'</td>
								<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
								<td><ff>'.number_format($m_price).'</ff></td>
							</tr>';
						}			
					}
					echo '<div class="" fix="h:50">
						<div class="fl ic40x icc1 ic40_print" onclick="print4(3,'.$id.')"></div>
						<div class="fr bu bu_t4 buu " onclick="saveOffer('.$pat.','.$offer.',2)">'.k_buy.'</div>
						<div class="fl f1 fs16 clr6 lh40 pd10">'.k_offer_val.'<ff>[ '.number_format($totPrice).' ]</ff></div> 
						<div class="fl f1 fs16 clr5 lh40 pd10"> '.k_bfr_offer.' <ff>[ '.number_format($totM_price).' ]</ff></div>
						</div>
					';
					if($rows){			
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
						<tr><th>'.k_department.'</th><th>'.k_service.'</th><th>'.k_price_serv.'</th></tr>'.$rowTxt.'</table>';
					}
					
				}
			}
			if($type==66){
				$clinics=$r['clinics'];
				$sett=$r['sett'];
				if($sett){
					$s=explode(',',$sett);
					$clnTxt=get_val($subTablesOfeer[$clinics],'name_'.$lg,$s[0]);
					if($clinics==2){
						list($srvTxt,$unit)=get_val($srvTables[$clinics],'name_'.$lg.',unit',$s[1]);
						$price=$unit*_set_x6kmh3k9mh;
					}else{		list($srvTxt,$hos_part,$doc_part)=get_val($srvTables[$clinics],'name_'.$lg.',hos_part,doc_part',$s[1]);
						$price=$hos_part+$doc_part;
					}?>
					<div class="f1 fs16 lh40 uLine"><?=$clinicTypes[$clinics]?> - <?=$clnTxt?> - <?=$srvTxt?> <ff> ( <?=number_format($price)?> )</ff></div>
					<div class="f1 lh40 fs16 clr1 ">عدد الخدمات : <ff> ( <?=$s[3]?> )</ff></div>
					<div class="f1 lh30 fs16 clr1">السعر الجديد : <ff> ( <?=number_format($s[2])?> )</ff></div>

					<div class="f1 lh40 fs16 clr5">السعر قبل العرض : <ff><?=number_format($price*$s[3])?></ff></div>
					<div class="f1 lh40 fs16 clr6">السعر بعد العرض : <ff><?=number_format($s[2]*$s[3])?></ff></div>
					<?

				}
			}
			echo '</div>';
		}
	}else{
		$date_off_end=$now-86400;
		$sql="SELECT * from gnr_m_offers where act=1 and  date_s < $now and date_e > $date_off_end and FIND_IN_SET('$mood',`clinics`)> 0 order by type ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($id)?></div>
		<div class="form_body" type="static">
			<? if($rows){?>
			<div class="fl r_bord" fix="w:300|hp:0">
			<div class="b_bord f1 fs18 clr1 lh40 mg10" fix="h:40"><?=k_offers_avbl?> <ff>( <?=$rows?> )</ff></div>
				<div class="ofx so mg10" fix="hp:40"><?
					$patOffer=get_vals('gnr_x_offers_patient','offer'," patient='$pat'",'arr');
					while($r=mysql_f($res)){
						$id=$r['id'];
						$name=$r['name'];
						$clr='cbg1';
						if(in_array($id,$patOffer)){$clr='cbg66';}
						echo '<div class="offerList f1 fs14 Over '.$clr.'" onclick="showOfferD('.$id.')">'.$name.'</div>';
					}?>
				</div>
			</div>
			<div class="fl" fix="wp:300|hp:0" id="offDet">
				<div class="f1 fs18 clr1 lh40 mg10"><?=k_click_on_offer_for_details?></div>
			</div>
			<?}else{
				echo '<div class="f1 fs18 lh40 clr5">'.k_no_offers.'</div>';
			}?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info3');viSts(<?=$mood?>,<?=$vis?>)"><?=k_close?></div>     
		</div>
		</div><?
	}
}?>