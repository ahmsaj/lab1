<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['pat'])){
	$id=pp($_POST['id']);
    $pat=pp($_POST['pat']);
    $t=pp($_POST['t']);
    if($t==2){// أختيار عرض مباع
        $r=getRec('gnr_x_offers',$id);
        if($r['r']){
            $id_x=$r['id'];
            $id=$r['offer_id'];
            $patient=$r['patient'];            
            $date=$r['date'];
            $date_s=$r['date_s'];
            $date_e=$r['date_e'];
            $price=$r['price'];
            $status=$r['status'];            
        }else{
            exit;
        }
    }
	$r=getRec('gnr_m_offers',$id);
    echo '<div class="h100  fxg" fxg="gtr:auto 1fr auto">';
	if($r['r']){
		$type=$r['type'];
        /***************************************/
        $tekSrvs=[];
        if($t==2){// استعراض المباع
            $sql3="select * from gnr_x_offers_items where  patient='$pat' and status=1 and x_offer_id='$id_x'";
            $res3=mysql_q($sql3);
            $rows3=mysql_n($res3);
            if($rows3){                
                while($r3=mysql_f($res3)){                    
                    $col='clr1';
                    $srv_id=$r3['id'];
                    $srv_mood=$r3['mood'];
                    $srv=$r3['service'];
                    $o_vis=$r3['vis'];
                    $date=$r3['date'];                    
                    $cobg='';
                    $statusTxt=k_srv_bought_on.' <ff14 dir="ltr">'.date('Y-m-d',$date).'</ff14>';
                    $statusTxt.='<br>'.k_visit_num.' <ff14 dir="ltr"> ( '.$o_vis.' )</ff14>';
                    if($type==1){
                        $tekSrvs[$srv_mood.'-'.$srv]='<div class="f1 clr6 ">'.$statusTxt.'</div>';
                    }else if($type==6){
                        $tekSrvs[]='<div class="f1 clr6 ">'.$statusTxt.'</div>';    
                    }
                    
                }                
            }
        }
        /***************************************/
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
                    if($t==2){
                        $cbg='';
                        $statusTxt='<div class="clr1 f12 f1">'.k_srv_not_disbursed.'</div>';
                        if($tekSrvs[$mood.'-'.$srv]){
                            $statusTxt=$tekSrvs[$mood.'-'.$srv];
                            $cbg=' cbg666';
                        }
                    }
					$rowTxt.='<tr class="'.$cbg.'">
						<td class="f1 fs12">'.$clinicTypes[$mood].'</td>
						<td class="f1 fs12 ta_n"><span class="f1 clr1 fs12">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</td>';
                        if($t==2){
                            $rowTxt.='<td>'.$statusTxt.'</td>';  
                        }else{
						    $rowTxt.='<td><ff>'.number_format($m_price).'</ff></td>';
                        }
					echo '</tr>';
				}		
			}
			echo '<div class="b_bord cbgw" >
				<div class="f1 fs16 clr1 lh40 pd10">'.splitNo($r['name']).' <ff>( '.$rows.' )</ff> </div>';
                if($t==2){
                    echo '
                    <div class="fl f1  clr6 lh30 pd10">تاريخ الشراء <ff14 dir="ltr">[ '.date('Y-m-d',$date).' ]</ff14></div> 
                    <div class="fl f1  clr5 lh30 pd10"> '.k_offer_valid_until.' : <ff14 dir="ltr">[ '.date('Y-m-d',$date_e).' ]</ff14></div>';
                }else{
                    echo '<div class="fl f1 clr6 lh30 pd10">'.k_offer_val.' <ff14>[ '.number_format($totPrice).' ]</ff14></div> 
                    <div class="fl f1 clr5 lh30 pd10"> '.k_bfr_offer.' <ff14>[ '.number_format($totM_price).' ]</ff14></div>';
                }
			echo '</div>
			<div class="ofx pd10 so cbg444" >';
			if($rows){			
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" type="static" >
				<tr><th width="150">'.k_department.'</th><th>'.k_service.'</th>';
                if($t==2){                    	
                    echo '<th>حالة الخدمة</th>';
                }else{
                    echo '<th>'.k_price_serv.'</th>';                    
                }
                echo '</tr>'.$rowTxt.'</table>';
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
					list($srvTxt,$unit,$cus_unit_price)=get_val($srvTables[$clinics],'name_'.$lg.',unit,cus_unit_price',$s[1]);
					$price=$unit*_set_x6kmh3k9mh;                    
                    if($cus_unit_price){$price=$unit*$cus_unit_price;}
				}else{		
                    list($srvTxt,$hos_part,$doc_part)=get_val($srvTables[$clinics],'name_'.$lg.',hos_part,doc_part',$s[1]);
					$price=$hos_part+$doc_part;
				}?>
				<div class="f1 fs16 lh50 b_bord pd10"><?=$clinicTypes[$clinics]?> - <?=$clnTxt?> - <?=$srvTxt?> <ff> ( <?=number_format($price)?> )</ff></div>
                <div class="cbg444 pd10f"><?
                    if($t==2){
                        echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s mg10v" type="static" >
                        <tr><th>'.k_service.'</th>
                        <th>حالة الخدمة</th></tr>';
                        for($i=0;$i<$s[3];$i++){
                            $statusTxt='<div class="clr1 f12 f1">'.k_srv_not_disbursed.'</div>';
                            $cbg='';
                            if($tekSrvs[$i]){                                
                                $statusTxt=$tekSrvs[$i];
                                $cbg=' cbg666';                                
                            }
                            echo '<tr>
                            <td class="f1">'.splitNo($srvTxt).'</td>
                            <td>'.$statusTxt.'</td>
                            </tr>';
                        }
                        echo '</table>';
                    }else{?>
                        <table border="0" cellspacing="0" cellpadding="4" class="grad_s2 cbgw" type="static" >
                        <tr>
                            <td width="250" class="f1 lh30 fs12 clr1 TC">عدد الخدمات :</td>
                            <td width="150" class="cbg888 TC"><ff><?=$s[3]?></ff></td>
                        </tr>
                        <tr>
                            <td class="f1 lh30 fs12 clr1 TC">السعر الجديد :</td>
                            <td class="cbg888 TC"><ff><?=number_format($s[2])?></ff></td>
                        </tr>
                        <tr>
                            <td class="f1 lh30 fs12 clr5 TC">السعر قبل العرض :</td>
                            <td class="cbg555 TC"><ff><?=number_format($price*$s[3])?></ff></td>
                        </tr>
                        <tr>
                            <td class="f1 lh30 fs12 clr6 TC">السعر بعد العرض :</td>
                            <td class="cbg666 TC"><ff><?=number_format($s[2]*$s[3])?></ff></td>
                        </tr>
                    </table><?
                    }?>
                </div><?
			}
		}
	}
    if($t==1){
        echo '<div class="cbg4 t_bord lh50">
            <div class="fl ic50_print icc33 wh50" printOffer="'.$id.'" title="'.k_print.'"></div>';
            if($pat){
                echo '<div class="fr lh50 icc22 f1 fs14 clrw TC" fix="w:150" buyOffer>'.k_buy.'</div>';
            }
        echo '</div>';
    }
    echo '</div>';
}?>