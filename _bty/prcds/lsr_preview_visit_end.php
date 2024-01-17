<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$vis=pp($_POST['vis']);
	$r=getRec('bty_x_laser_visits',$vis);
	echo '<div class="pd10f">';
	if($r['r']){
		$status=$r['status'];
		$doctor=$r['doctor'];
		$patient=$r['patient'];
        $clinic=$r['clinic'];
        $device=$r['device'];
		$mac_type=$r['mac_type'];
                
        $r=getRecCon('bty_m_laser_device',"id = '$device' ");
        if($r['r']){        
            $device_id=$r['id'];            
            if($mac_type==1){$macC=$r['count1'];}
            if($mac_type==2){$macC=$r['count2'];}
        
            $f=1;
            if($doctor!=$thisUser){out();exit;}
            if($status==1){
                $c=getTotalCO('bty_x_laser_visits_services',"visit_id='$vis' and  status=0 ");
                $shots=get_sum('bty_x_laser_visits_services_vals','counter',"visit_id='$vis' and  status=1 ");
                if($c==0 && $shots){				
                    $lP=getLastLsrPrice($patient)?>
                    <table class="vs_table f9"  cellpadding="4" cellspacing="4" width="600">
                        <tr>
                            <th class="f1 fs14 TC" width="160"><?=k_prev_count?> </th>
                            <th class="f1 fs14 TC" width="160"><?=k_curr_count?> </th>
                            <th class="f1 fs14 TC" width="160"><?=k_num_of_strikes?> </th>
                        </tr>
                        <tr>
                            <td class="TC"><ff class="fs20 TC" macC="<?=$macC?>">
                                <? if(_set_h9i176pni4==1){
                                    echo '<input type="number" id="l_cS" dir="ltr" value="'.$macC.'" class="cbg7" btyInp/>';
                                }else{
                                    echo '<input type="hidden" id="l_cS" value="'.$macC.'" />';
                                    echo number_format($macC);
                                }?>
                            </ff></td>
                            <td><input type="number" id="l_c" dir="ltr" value="<?=$macC+$shots?>" class="cbg7" btyInp/></td>
                            <td  class="TC"><ff class="fs20 clr1" id="l_cT"><?=$shots?></ff></td>
                        </tr>
                    </table>
                    <div class="f1 clr55 lh40 fs14"><?=k_enter_price_val?></div>
                    <table class="vs_table f9"  cellpadding="4" cellspacing="4" width="600">
                        <tr>
                            <th class="f1 fs14 TC" width="200"><?=k_price?> ( <ff class="fs12" id="l_pT">0</ff> )</th>
                            <td width="200">
                                <? if($emplo){?>
                                    <input type="hidden" id="l_p" value="<?=_set_wqbnsuc8za?>"/><ff class="clr5"><?=_set_wqbnsuc8za?><ff><?
                                }else{?>
                                    <input type="number" id="l_p" dir="ltr" value="<?=$lP?>"  class="cbg7" btyInp/><?
                                }?>
                            </td>
                            <td class="TC" width="200">
                                <ff class="fs20 clr1" id="l_pT2">0</ff>

                            </td>
                        </tr>
                    </table>
                    <div class="f1 clr55 lh40 fs14"><?=k_enter_multi_num?> <ff>50</ff></div>
                    <table class="vs_table f9"  cellpadding="4" cellspacing="4" width="600">					
                        <tr>
                            <th class="f1 fs14 TC" width="160"><?=k_discount?></th>
                            <td class="f1 fs14 TC" width="160"><input type="number" id="l_d" value="0" class="cbg7" btyInp/>
                            <!--<div class="f1 clr5 lh20"><?=k_discount_shld_50?><br><?=k_no_grt_or_less_dis?></div>-->
                            </td>
                            <td class="f1 fs14 TC" width="160"><ff class="clr66 fs20" id="l_pF">0</ff></td>
                        </tr>
                    </table>
                    <div class="f1 clr55 lh40 fs14"><?=k_recep_pay_notes?></div>
                    <table class="vs_table f9"  cellpadding="4" cellspacing="4" width="600">
                        <tr><td>
                            <input type="text" id="l_note" class="cbg7" btyInp2 /></td></tr>
                    </table><?
                }else{
                    echo '<div class="f1 fs16  lh40">'.k_srv_fsh_fr.'</div>';	$f=getTotalCO('bty_x_laser_visits_services_vals',"visit_id='$vis' and  status=1 ");
                    if($f==0){?>
                        <div class="f1  lh20 fs14"><?=k_m_would_like_cancel_visit?></div>
                        <div class="ic30 ic30_x icc2 ic30Txt fl mg10v" onclick="bty_cancel(<?=$vis?>,1);"><?=k_cancel?></div><? 
                    }else{
                        echo '<div class="f1 fs16  lh40">'.k_or_can_reopen.'</div>';	
                    }
                }
                if($c==0 && $shots){?><div class="ic30 ic30_save icc2 ic30Txt fl mg10v" onclick="bty_finshLsrDo();"><?=k_save?></div><? }
            }else{loc('_Laser-Visit');}
        }
	}
	echo'</div>';
}?>