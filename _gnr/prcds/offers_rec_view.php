<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_m_offers',$id);
	if($r['r']){
		$type=$r['type'];
		if($type==1){
			$sql="select * from gnr_m_offers_items where offers_id='$id' ";
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
			echo '<div class="uLine" fix="h:90">
				<div class="fr ic40 icc1 ic40_print" onclick="print4(3,'.$id.')"></div>
				<div class="f1 fs18 clr1 lh40">'.$r['name'].' <ff>( '.$rows.' )</ff> </div>
				<div class="fl f1 fs16 clr6 lh40 pd10">'.k_offer_val.' <ff>[ '.number_format($totPrice).' ]</ff></div> 
				<div class="fl f1 fs16 clr5 lh40 pd10"> '.k_bfr_offer.' <ff>[ '.number_format($totM_price).' ]</ff></div>
			</div>
			<div class="ofx so" fix="hp:90">';
			if($rows){			
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" >
				<tr><th>'.k_department.'</th><th>'.k_service.'</th><th>'.k_price_serv.'</th></tr>'.$rowTxt.'</table>';
			}
			echo '</div>';
		}
		if($type==6){
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
	}
}?>