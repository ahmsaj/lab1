<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_offers',$id);
	if($r['r']){
		$pat=$r['patient'];
		$offer=$r['offer_id'];
		$date=$r['date'];
		$price=$r['price'];
		$status=$r['status'];	
		$srvs=[];	
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><ff><?=$pat?> |</ff>
			<?=get_p_name($pat).' <span class="so lh40 clr5 f1 fs18"> [ '.get_val('gnr_m_offers','name',$offer).' ]</span>';?>
		</div>
		<div class="form_body so">
			<?
			$newOffer=1;
			$sql3="select * from gnr_x_offers_items where x_offer_id='$id'";
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
					$serTxt=get_val_arr($srvTables[$srv_mood],'name_'.$lg,$srv,'srv'.$srv_mood);	$subVal=get_val_arr($srvTables[$srv_mood],$subTablesOfferCol[$srv_mood],$srv,'cl'.$srv_mood);
					$subTxt=get_val_arr($subTablesOfeer[$srv_mood],'name_'.$lg,$subVal,'sub'.$srv_mood);
					$cobg='';
					if($o_status==1){
						$newOffer=0;
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
			?>
		</div>
		<div class="form_fot fr">
			<? if($newOffer){?>
				<div class="bu bu_t3 fl" onclick="delSellOffer(<?=$id?>);"><?=k_delete?></div>
			<? }?>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
	}
}?>