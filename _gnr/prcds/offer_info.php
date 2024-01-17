<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_m_offers',$id);
	if($r['r']){
		$type=$r['type'];
		$clinics=$r['clinics'];
		$sett=$r['sett'];
		$sett_arr=explode('|',$sett);
		$subTitle='';
		if($type==6){
			$s=explode(',',$sett);}
			$subTitle=' <span class="f1 fs14 clr5">( '.get_val($srvTables[$clinics],'name_'.$lg,$id).' )</span> ';
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=$r['name'].$subTitle?>
		<div class="fr ic40 icc1 ic40_ref" onclick="offerInfo(<?=$id?>)" title="تحديث"></div></div>
		<div class="form_body so" type="pd0"><?
		if($type==1){?>
			<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">
			<tr><th><?=k_department?></th>
			<th><?=k_service?></th>			
			<th><?=k_sold?></th>
			<th><?=k_consumed?></th>
			<th><?=k_recev?></th>
            <? if($thisGrp!='o9yqmxot8'){?>
			<th><?=k_recv_amount?></th>
			<th><?=k_bfr_offer?></th>
			<th><?=k_aftr_offer?></th>
 			<th><?=k_difference?></th>
            <? }?>
			</tr><?
			
			$t1=$t2=$t3=$t4=$t5=$t6=$t7=0;
			$sql="select * from gnr_m_offers_items where offers_id ='$id'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$mood=$r['mood'];
				$srv=$r['service'];
				$price=$r['price'];
				$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
				$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
				$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
				
				$soled=getTotalCO('gnr_x_offers_items',"mood='$mood' and offer_id='$id' and service='$srv'");
				$no=getTotalCO('gnr_x_offers_oprations',"mood='$mood' and offer='$id' and service='$srv'");
				$bal=$soled-$no;
				$bal_val=get_sum('gnr_x_offers_items','price',"mood='$mood' and offer_id='$id' and service='$srv' and status=0");
				$visPrice=get_sum('gnr_x_offers_oprations','visit_srv_price',"mood='$mood' and offer='$id' and service='$srv'");
				$offerPrice=get_sum('gnr_x_offers_oprations','offer_srv_price',"mood='$mood' and offer='$id' and service='$srv'");
				$def=$visPrice-$offerPrice;
				
				$t1+=$soled;
				$t2+=$no;
				$t3+=$bal;
				$t4+=$bal_val;
				$t5+=$visPrice;
				$t6+=$offerPrice;
				$t7+=$def;
				echo '<tr><td txt>'.$clinicTypes[$mood].'</td>
				<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>				
				<td><ff class="clr6">'.number_format($soled).'</ff></td>
				<td><ff class="clr1">'.number_format($no).'</ff></td>
				<td><ff class="clr5">'.number_format($bal).'</ff></td>';
                if($thisGrp!='o9yqmxot8'){
                    echo '<td><ff class="clr5">'.number_format($bal_val).'</ff></td>
                    <td><ff class="clr1">'.number_format($visPrice).'</ff></td>
                    <td><ff class="clr6">'.number_format($offerPrice).'</ff></td>
                    <td><ff class="clr5">'.number_format($def).'</ff></td>';
                }
				echo '</tr>';
			}			
			echo '<tr fot><td txt colspan="2">'.k_total.'</td>
				<td><ff class="clr6">'.number_format($t1).'</ff></td>
				<td><ff class="clr1">'.number_format($t2).'</ff></td>
				<td><ff class="clr5">'.number_format($t3).'</ff></td>';
                if($thisGrp!='o9yqmxot8'){
                    echo '<td><ff class="clr5">'.number_format($t4).'</ff></td>
                    <td><ff class="clr1">'.number_format($t5).'</ff></td>
                    <td><ff class="clr6">'.number_format($t6).'</ff></td>
                    <td><ff class="clr5">'.number_format($t7).'</ff></td>';
                }
			echo '</tr>';?>
			</table><?
		}else if($type==2){?>
			<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">
			<tr><th><?=k_department?></th>
			<th><?=k_service?></th>			
			<th><?=k_beneficiaries?></th> 
            <? if($thisGrp!='o9yqmxot8'){?>
			<th><?=k_bfr_offer?></th>
			<th><?=k_aftr_offer?></th>
			<th><?=k_difference?></th>
            <? }?>
			</tr><?
			
			$t1=$t2=$t3=$t4=0;
			$sql="select * from gnr_m_offers_items where offers_id ='$id'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$mood=$r['mood'];
				$srv=$r['service'];
				$price=$r['price'];
				$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
				$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
				$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
				
				$no=getTotalCO('gnr_x_offers_oprations',"mood='$mood' and offer='$id' and service='$srv'");
				$visPrice=get_sum('gnr_x_offers_oprations','visit_srv_price',"mood='$mood' and offer='$id' and service='$srv'");
				$offerPrice=get_sum('gnr_x_offers_oprations','offer_srv_price',"mood='$mood' and offer='$id' and service='$srv'");
				$def=$visPrice-$offerPrice;
				
				$t1+=$no;$t2+=$visPrice;$t3+=$offerPrice;$t4+=$def;
				echo '<tr><td txt>'.$clinicTypes[$mood].'</td>
				<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>				
				<td><ff class="clr1111">'.number_format($no).'</ff></td>';
                if($thisGrp!='o9yqmxot8'){
                    echo '<td><ff class="clr1">'.number_format($visPrice).'</ff></td>
                    <td><ff class="clr6">'.number_format($offerPrice).'</ff></td>
                    <td><ff class="clr5">'.number_format($def).'</ff></td>';
                }
				echo '</tr>';
			}			
			echo '<tr fot><td txt colspan="2">'.k_total.'</td>											
			<td><ff class="clr1">'.number_format($t1).'</ff></td>';
            if($thisGrp!='o9yqmxot8'){
                echo '<td><ff class="clr1">'.number_format($t2).'</ff></td>
                <td><ff class="clr6">'.number_format($t3).'</ff></td>
                <td><ff class="clr5">'.number_format($t4).'</ff></td>';
            }
			echo '</tr>';?>
			</table><?
		}else if($type==6){
			$a1=getTotalCO('gnr_x_offers',"offer_id='$id' ");
			$a2=getTotalCO('gnr_x_offers_items',"offer_id='$id' ");
			$a3=getTotalCO('gnr_x_offers_items',"offer_id='$id' and status=1");
			$a4=get_sum('gnr_x_offers_items','price',"offer_id='$id' and status=0");
			$a5=get_sum('gnr_x_offers_oprations','visit_srv_price',"offer='$id'");
			$a6=get_sum('gnr_x_offers_oprations','offer_srv_price',"offer='$id'");
			$a7=$visPrice-$offerPrice;?>
			
			<table width="400" border="0"  class="grad_s holdH mg10f TC" type="static" cellspacing="0" cellpadding="4">
			<tr><td txt>عدد العروض المباعة</td><td><ff class="clr6"><?=number_format($a1)?></ff></td></tr>
			<tr><td txt>عدد الخدمات المباعة</td><td><ff class="clr6"><?=number_format($a2)?></ff></td></tr>			
			<tr><td txt><?=k_consumed?></td><td><ff class="clr1"><?=number_format($a3)?></ff></td></tr>
            <? if($thisGrp!='o9yqmxot8'){?>
			<tr><td txt><?=k_recv_amount?></td><td><ff class="clr5"><?=number_format($a4)?></ff></td></tr>
			<tr><td txt><?=k_bfr_offer?></td><td><ff class="clr1"><?=number_format($a5)?></ff></td></tr>
			<tr><td txt><?=k_aftr_offer?></td><td><ff class="clr6"><?=number_format($a6)?></ff></td></tr>
			<tr><td txt><?=k_difference?></td><td><ff class="clr5"><?=number_format($a7)?></ff></td></tr>
            <? }?>
			</table>
			
			<?
			$t1=$t2=$t3=$t4=$t5=$t6=$t7=0;
			$sql="select * from gnr_m_offers_items where offers_id ='$id'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$mood=$r['mood'];
				$srv=$r['service'];
				$price=$r['price'];
				$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);						
				$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
				$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
				
				$soled=getTotalCO('gnr_x_offers_items',"mood='$mood' and offer_id='$id' and service='$srv'");
				$no=getTotalCO('gnr_x_offers_oprations',"mood='$mood' and offer='$id' and service='$srv'");
				$bal=$soled-$no;
				$bal_val=get_sum('gnr_x_offers_items','price',"mood='$mood' and offer_id='$id' and service='$srv' and status=0");
				$visPrice=get_sum('gnr_x_offers_oprations','visit_srv_price',"mood='$mood' and offer='$id' and service='$srv'");
				$offerPrice=get_sum('gnr_x_offers_oprations','offer_srv_price',"mood='$mood' and offer='$id' and service='$srv'");
				$def=$visPrice-$offerPrice;
				
				$t1+=$soled;
				$t2+=$no;
				$t3+=$bal;
				$t4+=$bal_val;
				$t5+=$visPrice;
				$t6+=$offerPrice;
				$t7+=$def;
				echo '<tr><td txt>'.$clinicTypes[$mood].'</td>
				<td txt class="ta_n"><span class="f1 clr1 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>				
				<td><ff class="clr6">'.number_format($soled).'</ff></td>
				<td><ff class="clr1">'.number_format($no).'</ff></td>
				<td><ff class="clr5">'.number_format($bal).'</ff></td>';
                if($thisGrp!='o9yqmxot8'){
				echo '<td><ff class="clr5">'.number_format($bal_val).'</ff></td>
                    <td><ff class="clr1">'.number_format($visPrice).'</ff></td>
                    <td><ff class="clr6">'.number_format($offerPrice).'</ff></td>
                    <td><ff class="clr5">'.number_format($def).'</ff></td>';
                }
				echo '</tr>';
			}
		}else{
			$sett_arrPear=explode(',',$sett_arr[0]);
			if($type==4){?>
				<div class="f1 fs16 clr1 lh40"><?=k_reg_pat?> : <ff>( <?=getTotalCO('gnr_x_offers_patient',"offer='$id'")?> )</ff></div><? 
			}
			if($type==5){
				$xCobon=getTotalCO('gnr_x_offers_oprations',"offer='$id'");?>
				<div class="f1 fs18 lh40">
				<div class="fl f1 fs16 lh40 clr1 pd10"><?=k_coupons?> : <ff>( <?=number_format($sett_arr[1])?> ) </ff></div>
				<div class="fl f1 fs16 lh40 clr6 pd10 l_bord r_bord"><?=k_consumed?> : <ff> ( <?=number_format($xCobon)?> )</ff> </div> 
				<div class="fl f1 fs16 lh40 clr5 pd10"><?=k_lft?> : <ff> ( <?=number_format($sett_arr[1]-$xCobon)?> )</ff></div>
				</div><? 
			}?>
			<table width="100%" border="0"  class="grad_s" type="static" cellspacing="0" cellpadding="4">
			<tr><th><?=k_department?></th>
			<th><?=k_ratio?></th>			
			<th><?=k_beneficiaries?></th>
            <? if($thisGrp!='o9yqmxot8'){?>
			<th><?=k_bfr_offer?></th>
			<th><?=k_aftr_offer?></th>
			<th><?=k_difference?></th>
            <? }?>
			</tr><?
			foreach($clinicTypes  as $k=>$c){ 
				if($k && $sett_arrPear[$k-1]){
					$mood=$k;
					$no=getTotalCO('gnr_x_offers_oprations',"mood='$mood' and offer='$id'");
					$visPrice=get_sum('gnr_x_offers_oprations','visit_srv_price',"mood='$mood' and offer='$id' ");
					$offerPrice=get_sum('gnr_x_offers_oprations','offer_srv_price',"mood='$mood' and offer='$id' ");
					$def=$visPrice-$offerPrice;

					$t1+=$no;$t2+=$visPrice;$t3+=$offerPrice;$t4+=$def;
					echo '<tr><td txt>'.$c.'</td>
					<td><ff>'.$sett_arrPear[$k-1].'%</ff></td>				
					<td><ff class="clr1111">'.number_format($no).'</ff></td>';
                    if($thisGrp!='o9yqmxot8'){
                        echo '<td><ff class="clr1">'.number_format($visPrice).'</ff></td>
                        <td><ff class="clr6">'.number_format($offerPrice).'</ff></td>
                        <td><ff class="clr5">'.number_format($def).'</ff></td>';
                    }
                    echo '</tr>';
				}
			}			
			echo '<tr fot><td txt colspan="2">'.k_total.'</td>											
			<td><ff class="clr1">'.number_format($t1).'</ff></td>';
            if($thisGrp!='o9yqmxot8'){
                echo '<td><ff class="clr1">'.number_format($t2).'</ff></td>
                <td><ff class="clr6">'.number_format($t3).'</ff></td>
                <td><ff class="clr5">'.number_format($t4).'</ff></td>';
            }
            echo '</tr>';
			?>
			</table><?
		}?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
	}
}?>