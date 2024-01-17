<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$r=getRec('gnr_m_offers',$id);
	if($r['r']){
		$sql="select * from gnr_m_offers_items where offers_id ='$id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=$r['name']?> <ff> ( <?=$rows?> ) </ff>
		<div class="fr ic40 icc1 ic40_add" onclick="addSrvToOffer(<?=$id?>)"></div>
		<div class="fr ic40 icc1 ic40_ref" onclick="offerItemes(<?=$id?>)"></div>
		</div>
		<div class="form_body so" type="full_pd0"><?
			$totPrice=0;
			if($rows){
				$type=$r['type'];?>				
				<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">
					<tr><th><?=k_department?></th>
					<th><?=k_service?></th>
					<th><?=k_price?></th>					
					<th>نسبة الحسم</th>
					<th>السعر الجديد</th>					
					<th width="100"></th></tr><?
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$mood=$r['mood'];
						$srv=$r['service'];
						$price=$r['price'];
						$dis_percent=$r['dis_percent'];
						$finPrice=($price*(100-$dis_percent))/100;
						if($type==1){
							$finPrice=$price;
							//$finPrice=($price/100*$dis_percent)+$price;						
							if($mood==2){
								list($serTxt,$unit)=get_val_arr($srvTables[$mood],'name_'.$lg.',unit',$srv,'srv'.$mood);
								$price=$unit*_set_x6kmh3k9mh;
							}else{									
								list($serTxt,$hos_part,$doc_part)=get_val_arr($srvTables[$mood],'name_'.$lg.',hos_part,doc_part',$srv,'srv'.$mood);
								$price=$hos_part+$doc_part;
							}
							
							if($price){
								$dis_percent=100-($finPrice*100/$price);
							}else{
								$dis_percent=0;
							}
							
						}else{
							$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);
						}
						if($type==2){
								$finPrice=$price;
							if($mood==2){
								$unit=get_val($srvTables[$mood],'unit',$srv);
								$price=$unit*_set_x6kmh3k9mh;
							}else{
								list($hos_part,$doc_part)=get_val($srvTables[$mood],'hos_part,doc_part',$srv);
								$price=$hos_part+$doc_part;								
							}
							if($price){
								$dis_percent=100-($finPrice*100/$price);
							}else{
								$dis_percent=0;
							}
						}
						$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
						$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);						
						$totPrice+=$price;
						$totPrice2+=$finPrice;
						echo '<tr><td txt>'.$clinicTypes[$mood].'</td>
						<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>
						<td><ff class="clr6">'.number_format($price).'</ff></td>
						<td><ff class="clr1">%'.number_format($dis_percent,2).'</ff></td>
						<td><ff class="clr5">'.number_format($finPrice).'</ff></td>
						<td>
							<div class="fr ic40 icc1 ic40_edit" title="'.k_edit.'" onclick="editOfferSrv('.$s_id.','.$id.','.$mood.','.$srv.')"></div>
							<div class="fr ic40 icc2 ic40_del" title="حذف" onclick="delOffSrv('.$s_id.')"></div>
						</td></tr>';
					}
					if($type==1){
						echo '<tr fot><td txt colspan="2">'.k_total_offer_val.'</td>
						<td><ff class="clr6">'.number_format($totPrice).'</ff></td>
						<td></td>
						<td><ff class="clr5">'.number_format($totPrice2).'</ff></td>
						<td></td></tr>';
					}?>					
					
				</table><?
			}?>
		</div>
		<div class="form_fot fr"><? fixOfferMood($id);?>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');loadModule('v1n0krhfvd');"><?=k_close?></div>     
		</div>
		</div><?
		fixOfferMood($id);
	}
}?>