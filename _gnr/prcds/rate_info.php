<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mood'])){
	$id=pp($_POST['id']);
    $mood=pp($_POST['mood']);
    $r=getRec($visXTables[$mood],$id);
    if($r['r']){
        $pat=$r['patient'];
        $clinic=$r['clinic'];
        $doctor=$r['doctor'];
        $d_start=$r['d_start'];
        $d_finish=$r['d_finish'];
        $pay_type=$r['pay_type'];
        $rate=$r['rate'];        
        $patName=get_p_name($pat);
        
        ?>
        <div class="of h100 fxg" fxg="gtr:1fr 180px">
            <div class="pd10f ofx so">
                <table width="100%" border="0" cellspacing="0" cellpadding="6" class="grad_s2" >
                    <tr>
                        <td class="f1 fs14 pd10" width="200"><?=k_num?>:</td>
                        <td class="f1 fs14 pd10 clr66"><ff><?=number_format($id)?></ff></td>
                    </tr><? 
                if($mood!=2){
                    $clinicName=get_val('gnr_m_clinics','name_'.$lg,$clinic);
                    $docName=get_val('_users','name_'.$lg,$doctor);?>
                    
                    <tr>
                        <td class="f1 fs14 pd10"><?=k_dr?>:</td>
                        <td class="f1 fs14 pd10 clr66"><?=$docName?></td>
                    </tr>
                    <tr>
                        <td class="f1 fs14 pd10 "><?=k_clinic?>:</td>
                        <td class="f1 fs14 pd10 clr66"><?=$clinicName?></td>
                    </tr><? 
                }?>
                <tr>
                    <td class="f1 fs14 pd10 "><?=k_date?>:</td>
                    <td class="f1 fs14 pd10 clr66">
                        <ff dir="ltr"><?=date('Y-m-d',$d_start).' <br> '.date('Ah:i',$d_start).' - '.date('Ah:i',$d_finish)?></ff>
                    </td>
                </tr>
                <tr>
                    <td class="f1 fs14 pd10 "><?=k_visit_srvcs?>:</td>
                    <td class="f1 fs14 pd10 clr66"><?
                      $srvs=get_vals($srvXTables[$mood],'service',"visit_id='$id' ");
                      echo $srvTxt=get_vals($srvTables[$mood],'name_'.$lg," id IN($srvs)",' :: ');
                    ?>
                    </td>
                </tr>
            </table>
            </div>
            <div class="ofx so pd10 t_bord cbg44"><? 
                if($rate){
                    $rRate=getRecCon('gnr_x_visit_rate'," visit='$id' and type='$mood' ");
                    if($rRate['r']){
                        $user=get_val('_users','name_'.$lg,$rRate['user']);
                        echo '<div class="f1 fs14 lh30">التقييم: <ff class="clr5">5/'.$rRate['rate'].'</ff></div>';
                        echo '<div class="f1 fs14 lh30">التاريخ: <ff dir="ltr" class="clr1">'.date('Y-m-d',$rRate['date']).'</ff></div>';
                        echo '<div class="f1 fs14 lh30">القائم بالتقييم: <span class="f1 fs14 lh30 clr1">'.$user.'</div>'; 
                        
                        if($rRate['note']){
                            echo '<div class="f1 fs14 lh30">ملاحظات:<br> 
                            <span class="f1 fs14 lh30 clr1">'.nl2br($rRate['note']).'</span></div>';
                        }
                    }
                }else{?>
                    <div class="mg10v"><textarea class="w100 so" id="rateNote" t placeholder="<?=k_notes?>" fix="h:100"></textarea></div>
                    <div>
                        <div class="fl br5 cbgw pd5f">
                            <div class="fl w100 revStars">
                                <? for($i=1;$i<6;$i++){
                                     echo '<div v="'.$i.'"><img src="../images/gnr/star.svg"/></div>';
                                }?>	
                                <div class="fl lh30 mg10 pd10"><fn2 class="fs24 clr9" n>0.0</fn2></div>
                            </div>
                        </div>
                        <div class="fr ic40 ic40_save icc2 ic40Txt" saveRate><?=k_save?></div>
                    </div><?
                }?>
            </div>
        </div><?
    }
    
}?>