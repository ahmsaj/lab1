<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['doc'],$_POST['t'])){
	$id=pp($_POST['id']);
	$selDoc=pp($_POST['doc']);    
	$w_type=pp($_POST['t']);
	$q='';
	if($selDoc){$q=" and doc='$selDoc' ";}
	fixPatintAcc($id);
	$docs=get_vals("den_x_visits_services_levels",'doc'," patient ='$id' ");
	$dd=explode(',',$docs);	
	$refTxt='أرصدة الأطباء';
	$st=2;
	if($w_type==2){$refTxt='أرصدة الخدمات';$st=1;}
    $patName=get_p_name($id);
	?>
    <script>recWinTitle('<ff><?=$id.'</ff> | '.$patName?>');</script>
    <div class="w100 h100 fxg" fxg="gtr:1fr 40px">
        <div class="w100 h100 of"><?
        if($w_type==1){?>
            <div class="of h100 fxg" fxg="gtc:3fr 3fr|gtr:40px 1fr 40px">
                <div class="f1 fs16 lh50 b_bord pd10 clr1 r_bord"><?=k_srvs_prvd?></div>
                <div class="f1 fs16 lh50 b_bord pd10 clr1"><?=k_payms?></div>
                <div class="ofx pd10f so r_bord"><?
                    $sql="select * from den_x_visits_services where patient='$id' $q order by d_start DESC";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows>0){
                        $t1=$t2=$t3=$srvDone=0;
                        while($r=mysql_f($res)){
                            $s_id=$r['id'];
                            $vis=$r['visit_id'];
                            $service=$r['service'];
                            $doc=$r['doc'];
                            $total_pay=$r['total_pay'];
                            $pay_net=$r['pay_net'];
                            $dts_dis=$total_pay-$pay_net;
                            $d_start=$r['d_start'];
                            $end_percet=$r['end_percet'];
                            $teeth=$r['teeth'];
                            $teethTxt='';
                            if($teeth){$teethTxt='<ff14 class="clrw cbg8 pd5f" dir="ltr"> '.$teeth.'</ff14>';}
                            $srvTxt=get_val_arr('den_m_services','name_'.$lg,$service,'s');
                            $docTxt=get_val_arr('_users','name_'.$lg,$doc,'doc');
                            $srvNet=0;
                            if($end_percet){$srvNet=$pay_net*$end_percet/100;}
                            $t1+=$pay_net;
                            $t2+=$end_percet;
                            $t3+=$srvNet;
                            $srvDone+=$srvNet;
                            ?>
                            <div class="fl w100 lh30">
                                <div class="fl lh30">
                                    <ff class="clr1">#<?=$vis?> | </ff> 
                                    <ff class="clr5">#<?=$s_id?> | </ff> 
                                    <ff><?=date('Y-m-d',$d_start)?></ff>
                                    <span class="f1 fs14"> | <?=$docTxt?></span>
                                </div>
                                <div class="fr lh30"><?=$teethTxt?></div>
                            </div>
                            <div class="fl w100 lh30">
                                <div class="fl f1 fs14 lh30 clr1">
                                    <?=$srvTxt?> <ff14 class="clr5">(<?=number_format($pay_net)?>)</ff14>
                                </div>
                                <div class="fr lh30">
                                    <ff14 class="cbg6 clrw pd5f" title="<?=k_complete_percent?>">%<?=$end_percet?></ff14>
                                    <ff14 class="cbg66 clrw pd5f" title="<?=k_dsv_mnt?>"><?=number_format($srvNet)?></ff14>
                                </div>
                            </div>
                            <table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">
                            <?

                            $sql2="select * from den_x_visits_services_levels where x_srv='$s_id' $q order by id ASC";
                            $res2=mysql_q($sql2);
                            $rows2=mysql_n($res2);
                            if($rows2>0){						
                                while($r2=mysql_f($res2)){
                                    $l_id=$r2['id'];
                                    $lev=$r2['lev'];
                                    $docl=$r2['doc'];
                                    $total_pay=$r2['total_pay'];
                                    $pay_net=$r2['pay_net'];
                                    $dts_dis=$total_pay-$pay_net;
                                    $le_date=$r2['date_e'];
                                    $lev_perc=$r2['lev_perc'];
                                    $l_status=$r2['status'];

                                    $levTxt=get_val_arr('den_m_services_levels','name_'.$lg,$lev,'lev');
                                    $docTxtLev=get_val_arr('_users','name_'.$lg,$docl,'doc');

                                    $recCol="cbg4";
                                    $statusTxt=k_level_not_worked_on;
                                    $docDone='';
                                    if($docl){
                                        $docDone=$docTxtLev;
                                    }
                                    if($l_status==1){
                                        $recCol="cbg7";
                                        $statusTxt=k_wrkng;								
                                    }
                                    if($l_status==2){
                                        $recCol="cbg666";
                                        $statusTxt=k_ended_on.' <ff dir="ltr" class="fs14">'.date('Y-m-d',$le_date).'</ff>';								
                                    }?>
                                    <tr class="<?=$recCol?>">								
                                        <td><ff>#<?=$l_id?></ff></td>
                                        <td class="f1 fs12 "><?=$levTxt?>
                                        <? if($dts_dis){ 
                                            echo 'حسم موعد: <ff14 class="clr5">('.number_format($dts_dis).')</ff14>';
                                        }?>
                                        </td>
                                        <td><ff14>%<?=$lev_perc?></ff14></td>
                                        <td class="f1 fs12"><?=$docDone?></td>
                                        <td class="f1 fs12"><?=$statusTxt?></td>								
                                    </tr><?
                                }
                            }?>
                            </table><?
                        }
                    }else{?>
                        <div class="f1 fs16 clr5 lh40"><?=k_no_srvcs?></div><?
                    }
                    $pay=patDenPay($patient);
                    $bal=$t3-$pay;
                    $balPay=$bal;
                    if($balPay<0){$balPay=0;}
                    $maxPay=$t1-$pay;
                    ?>
                </div>
                <div class="ofx pd10 so"><?
                    $sql="select * from gnr_x_acc_patient_payments where patient='$id' $q order by date DESC";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows>0){?>				
                        <table class="grad_s holdH mg10v" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">	
                        <tr>
                            <th>#</th>
                            <th width="120"><?=k_date?></th>
                            <th><?=k_pay_type?></th>
                            <th><?=k_doctor?></th>					
                            <th><?=k_paym?></th>
                            <? if($thisGrp=='pfx33zco65'){?><th width="40"></th><? }?>
                        </tr><?
                        $pay=0;
                        while($r=mysql_f($res)){
                            $pay_id=$r['id'];
                            $amount=$r['amount'];
                            $sub_mood=$r['sub_mood'];
                            $mood=$r['mood'];
                            $date=$r['date'];
                            $type=$r['type'];
                            $p_doc=$r['doc'];
                            $PdocTxt=get_val_arr('_users','name_'.$lg,$p_doc,'doc');
                            $srvNet=0;
                            $typeTxt='';
                            if($type==2){
                                $pay-=$amount;
                            }else{
                                $pay+=$amount;
                            }
                            if($type==3){
                                $char=get_val_con('gnr_x_charities_srv','charity'," vis='$sub_mood' and mood='$mood'");
                                $typeTxt='<div class="ws clr5 f1">'.get_val('gnr_m_charities','name_'.$lg,$char).'</div>';
                            }
                            if($type==4){
                                $insr=get_val_c('gnr_x_insurance_rec','company',$sub_mood,'vis');
                                $typeTxt='<div class="ws clr5 f1">'.get_val('gnr_m_insurance_comp','name',$insr).'</div>';
                            }?>
                            <tr>
                            <td><ff>#<?=$pay_id?></ff></td>
                            <td><ff14><?=date('Y-m-d',$date)?></ff14></td>
                            <td><div class="f1 fs12 <?=$patPaymentClr[$type]?>"><?=$patPayment[$type].' '.$typeTxt?></td>
                            <td class="f1 fs12"><?=$PdocTxt?></td>
                            <td><ff class="clr1 <?=$patPaymentClr[$type]?>"><?=number_format($amount)?></ff></td>
                            <? if($thisGrp=='pfx33zco65'){?>
                                <td><div class="ic30 icc11 ic30_print" printPay="<?=$pay_id?>"></div></td><? 
                            }?>
                            </tr><?
                        }?>
                        </table><?
                    }else{?>
                        <div class="f1 fs16 clr5 lh40"><?=k_no_payms?></div><?
                    }	
                    ?>
                </div>            
                <?
                $fbClr='clr5';
                $finBal=$srvDone-$pay;
                if($finBal<=0){$fbClr='clr6';}
                ?>
                <div class="w100 t_bord lh40 cbg44 fxg " fxg="gcs:2|gtb:25%">			
                    <div class="fl f1 fs14 lh40 clr9 r_bord TC"><?=k_services?> : <ff><?=number_format($t1)?></ff></div>
                    <div class="fl f1 fs14 lh40 clr5 r_bord TC"><?=k_deserv_acheiv?> : <ff><?=number_format($srvDone)?></ff></div>

                    <div class="fl f1 fs14 lh40 clr1 r_bord TC"><?=k_payms?> : <ff><?=number_format($pay)?></ff></div>
                    <div class="fl f1 fs14 lh40 <?=$fbClr?> TC"><?=k_balance?> : <ff><?=number_format($finBal)?></ff></div>

                </div>                
            </div>
            <?
        }else{
            echo '<div class="w100 h100 ofx so pd10">';
            $sql="select * from den_x_visits_services where patient='$id' and doc!=0 order by doc ASC , d_start ASC ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                $actDoc='';
                $t1=$t2=0;
                while($r=mysql_f($res)){
                    $s_id=$r['id'];
                    $doc=$r['doc'];
                    $d_start=$r['d_start'];
                    $service=$r['service'];
                    $teeth=$r['teeth'];
                    $total_pay=$r['total_pay'];
                    $pay_net=$r['pay_net'];
                    $dts_dis=$total_pay-$pay_net;
                    $doc_percent=$r['doc_percent'];
                    $end_percet=$r['end_percet'];
                    $doneSrv=$pay_net*$end_percet/100;

                    $teethTxt='';
                    $srvName=get_val_arr('den_m_services','name_'.$lg,$service,'srv');				
                    if($teeth){$teethTxt='('.$teeth.')';}
                    if($doc!=$actDoc){
                        if($actDoc!=''){
                            $paments=patDenBal($id,$actDoc);
                            echo '                            
                            <tr fot>
                                <td colspan="3" class="f1 fs14">'.k_total.'</td>
                                <td><ff class="clr1">'.number_format($t1).'</ff></td>
                                <td><ff class="clr6">'.number_format($t2).'</ff></td>
                                <td><ff class="clr5">'.number_format($t1-$t2).'</ff></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="f1 fs14">الدفعات</td>
                                <td class="cbg6"><ff class="clrw">'.number_format($paments).'</ff></td>
                                <td><ff class="clr6">'.number_format($t2).'</ff></td>
                                <td class="cbg1"><ff class="clrw">'.number_format($paments-$t2).'</ff></td>
                            </tr></table>';
                            $t1=$t2=0;
                        }
                        echo '<div class="f1 fs18 lh40 clr1">'.get_val('_users','name_'.$lg,$doc).'</div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH " type="static" >
                        <tr>
                            <th width="60">#</th>
                            <th>التاريخ</th>						
                            <th>الخدمة</th>
                            <th width="100">السعر</th>
                            <th width="100">المنجز</th>
                            <th width="100">الباقي</th>
                        </tr>';
                        $t1=$t2=0;
                        $actDoc=$doc;
                    }
                    $t1+=$pay_net;
                    $t2+=$doneSrv;	
                    echo '<tr>
                        <td><ff>#'.$s_id.'</ff></td>
                        <td><ff14>'.date('Y-m-d',$d_start).'</ff14></td>						
                        <td class="f1 fs12">'.$srvName.' <ff14>'.$teethTxt;
                        if($dts_dis){ 
                            echo '<div class="f1 fs12 clr5">حسم موعد: <ff14 class="clr5">('.number_format($dts_dis).')</ff14></div>';
                        }
                        echo '</ff14></td>
                        <td><ff class="clr1">'.number_format($pay_net).'</ff></td>
                        <td><ff class="clr6">'.number_format($doneSrv).'</ff></td>
                        <td><ff class="clr5">'.number_format($pay_net-$doneSrv).'</ff></td>
                    </tr>';
                }
                $paments=patDenBal($id,$actDoc);
                echo '
                <tr fot>
                    <td colspan="3" class="f1 fs14">'.k_total.'</td>
                    <td><ff class="clr1">'.number_format($t1).'</ff></td>
                    <td><ff class="clr6">'.number_format($t2).'</ff></td>
                    <td><ff class="clr5">'.number_format($t1-$t2).'</ff></td>
                </tr>
                <tr>
                    <td colspan="3" class="f1 fs14">الدفعات</td>
                    <td class="cbg6"><ff class="clrw">'.number_format($paments).'</ff></td>
                    <td><ff class="clr6">'.number_format($t2).'</ff></td>
                    <td class="cbg1"><ff class="clrw">'.number_format($paments-$t2).'</ff></td>
                </tr></table>';
            }
            echo '</div>';
        }?>
        </div>
        <div class="cbg4 t_bord">
            <div class="ic40x icc22 ic40_ref fr br0 ic40Txt" swViewPC><?=$refTxt?></div>
            <?
            if($w_type==1){?><div class="fl ic40 icc4 br0 ic40_print ic40Txt" printPatAcc>كشف حساب</div> <?}
            if($thisGrp=='pfx33zco65'){?>
                <div class="fl ic40 icc2 br0 ic40_print ic40Txt" printInvice >طباعة فاتورة</div><? 
            }
            if($w_type==1){                
                if(count($dd)>1){
                    echo '<div class="fr " fix="w:150">'.		
                    make_Combo_box('_users','name_'.$lg,'id'," where id IN ($docs) ",'doc',0,$selDoc,'t patAccDoc ',$text=k_doc_choos).'	
                    </div>';
                }
            }
            if($thisGrp=='pfx33zco65'){?>
                <div class="ic40x icc33 ic40_price fl br0 ic40Txt" newPatPay>دفعة مستقلة</div><? 
                $charVis=get_val_con('den_x_visits','id',"patient='$id' ",'order by d_start DESC');
                if($charVis){?>
                    <div class="ic40x icc11 ic40_price fl br0 ic40Txt" charPayChang="<?=$charVis?>" onclick1="chgPayType(2,<?=$charVis?>,4)">دفعة جمعية</div><?
                }
            }?>
        </div>
	</div><?
		
	
}