<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['bank'],$_POST['type'],$_POST['mood'],$_POST['par'])){	
    $type=pp($_POST['type']);
    $mood=pp($_POST['mood']);
    $par=pp($_POST['par'],'s');
    $bank=pp($_POST['bank']);
    $amount=pp($_POST['amount']);
    //$customPay=pp($_POST['c']);
    $table=$visXTables[$mood];
    $table2=$srvXTables[$mood];
    $r=getRec('gnr_m_banks',$bank);
    if($r['r']){
        $perc=$r['perc'];
        $mount=0;
        switch($type){
            case 1://الدفعة الزيارة الاساسية
                $vis=$par;                
                $bal=visBalPay($vis,$mood);                
                if($mood==7){                                        
                    $bal+=get_val_c('osc_x_visits_services','doc_fees',$vis,'visit_id');                
                }
                $t=1;
            break;
            case 2://دفعة التنبيهات
                $r=getRec('gnr_x_visits_services_alert',$par);
                if($r['r']){
                    $vis=$r['visit_id'];                                    
                    $bal=$r['amount'];
                    $mood=$r['mood'];
                }
                if($mood==4){
                    $bal=$amount;
                    if($customPay){$bal=$customPay;}
                }elseif($mood==6){
                    $bal=get_val('bty_x_laser_visits','total_pay',$vis);
                }else{
                    $bal=visBalPayAlert($vis,$mood);
                }
                //$amount=$bal;
                $t=2;
            break;
            case 3://الدفع من معلومات الزيارة
                $vis=$par;                
                $bal=visBalPay($vis,$mood);
                //$amount=$bal;
                $t=2;
            break;
            case 4://دفعة موعد مقدمة 
                $pars=explode(',',$par);
                $dat_id=$pars[0];
                $r=getRec('dts_x_dates',$dat_id);
                if($r['r'] && $amount){
                    $clinic=$r['clinic'];
                    $mood=$r['type'];
                    //$amount=$customPay;
                    $commission=($amount*$perc)/100;//حساب عمولة البنك
                    //$total=ceil(($amount+$commission)/100) * 100;// مجموع المبلغ + العمولة باقل 100
                    //$commission=round(($total/100)*$perc,2);// حساب العمولة بعد الجمع 
                    //$differ=$total-$amount-$commission;// حساب الفرق
                    echo addPay($dat_id,6,$clinic,$amount,$mood,2,$commission,$perc,$bank);
                    echo '^0';
                }
            break;
            case 5:// دفعة أسنان مستقلة 
                $pars=explode(',',$par);                
                $pat_id=$pars[0];
                $payType=$pars[1];
                if($payType==0){$payType=1;}
                $payDoc=$pars[2];
                $mood=4;
                $r=getRec('gnr_m_patients',$pat_id);
                if($r['r'] && $amount){                    
                    //$amount=$customPay;
                    $commission=($amount*$perc)/100;//حساب عمولة البنك
                    //$total=ceil(($amount+$commission)/100) * 100;// مجموع المبلغ + العمولة باقل 100
                    //$commission=round(($total/100)*$perc,2);// حساب العمولة بعد الجمع 
                    //$differ=$total-$amount-$commission;// حساب الفرق
                    echo savePatPayment($pat_id,$mood,$payType,$amount,$payDoc,2,$commission,$perc,$bank);
                    echo '^0';
                }
            break;
            case 6:// دفعة العروض 
                $pars=explode(',',$par);                
                $amount=$pars[0];
                $ofId=$pars[1];                
                $r=getRec('gnr_m_offers',$ofId);
                if($r['r']){                    
                    $commission=($amount*$perc)/100;//حساب عمولة البنك
                    //$total=ceil(($amount+$commission)/100) * 100;// مجموع المبلغ + العمولة باقل 100
                    //$commission=round(($total/100)*$perc,2);// حساب العمولة بعد الجمع 
                    //$differ=$total-$amount-$commission;// حساب الفرق
                    //echo addPay($ofId,10,0,$amount,10,2,$commission,$perc,$bank);
                    echo $bank;
                }
            break;
        }
        /**********************************/
        if($partAmount){if($partAmount>$bal){exit;}else{$amount=$partAmount;}}
        if(in_array($type,array(1))){            
            $commission=($amount*$perc)/100;//حساب عمولة البنك
            //$total=ceil(($amount+$commission)/100) * 100;// مجموع المبلغ + العمولة باقل 100
            //$commission=round(($total/100)*$perc,2);// حساب العمولة بعد الجمع 
            //$differ=$total-$amount-$commission;// حساب الفرق 
            if($amount<=$bal){
                switch($mood){
                    case 1:echo addPay1($vis,$t,$amount,2,$commission,$perc,$bank);break;
                    case 2:echo addPay2($vis,$t,$amount,2,$commission,$perc,$bank);break;
                    case 3:echo addPay3($vis,$t,$amount,2,$commission,$perc,$bank);break;
                    case 5:echo addPay5($vis,$t,$amount,2,$commission,$perc,$bank);break;
                    case 7:echo addPay7($vis,$t,$amount,2,$commission,$perc,$bank);break;
                }
                echo '^'.($bal-$amount);
            }else{
                echo '0^0';
            }
        }
        if(in_array($type,array(2,3))){            
            //$commission=($amount/(1-($perc/100)))-$amount;
            $commission=($amount*$perc)/100;//حساب عمولة البنك
            //$total=ceil(($amount+$commission)/100) * 100;// مجموع المبلغ + العمولة باقل 100
            ///$commission=round(($total/100)*$perc,2);// حساب العمولة بعد الجمع 
            //$differ=$total-$amount-$commission;// حساب الفرق
            
            list($p,$s)=get_val($table,'patient,status',$vis);
            if($p){
                if($mood==6){
                    echo addPay6($vis,$amount,2,$commission,$perc,$bank);
                }else if($mood==4){
                    $doc=get_val('den_x_visits','doctor',$vis);
                    echo addPay4($vis,11,$amount,$doc,2,$commission,$perc,$bank);
                    mysql_q("delete from gnr_x_visits_services_alert where visit_id='$vis' and patient='$p'and mood=4");
                }else{
                    echo addBankPay2($vis,$mood,$amount,$commission,$perc,$bank);
                }
            }  
            echo '^'.$p;
        }
    }
}?>