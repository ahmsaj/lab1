<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'],$_POST['mood'],$_POST['par'])){
	$id=pp($_POST['id']);
    $type=pp($_POST['t']);
    $mood=pp($_POST['mood']);
    $par=pp($_POST['par']);
    $partAmount=pp($_POST['a']);
    $customPay=pp($_POST['c']);
    $r=getRec('gnr_m_banks',$id);
    if($r['r']){
        $id=$r['id'];
        $name=$r['name'];
        $note=$r['note'];
        $perc=$r['perc'];
        $amount=0;
        $btn='';
        switch($type){
            case 1:
                $vis=$par;                
                $bal=visBalPay($vis,$mood);
                $amount=$bal;
                if($mood==2){
                    $btn=' bankLabPay="'.$bal.'" ';
                }
                if($mood==7){                                        
                    $bal+=get_val_c('osc_x_visits_services','doc_fees',$vis,'visit_id');
                    $amount=$bal;
                }
            break;
            case 2:
                $r=getRec('gnr_x_visits_services_alert',$par);
                if($r['r']){
                    $vis=$r['visit_id'];                                        
                    $amount=$r['amount'];
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
                $amount=$bal;
            break;
            case 3:
                $vis=$par;          
                $bal=visBalPay($vis,$mood);
                $amount=$bal;
            break;
            case 4:
                $pars=explode(',',$par);
                $vis=$par[0];                
                if($customPay){$bal=$customPay;}
                $amount=$bal;
            break;
            case 5:
                $pars=explode(',',$par);
                //$vis=$par[0];                
                if($customPay){$bal=$customPay;}
                $amount=$bal;
            break;
            case 6:
                $bal=$par;
                $amount=$bal;
            break;
        }
        if($partAmount){
            if($partAmount>$bal){
                $partAmount=0;
                echo Script('cp_a=0;');
            }else{
                $amount=$partAmount;
            }
        }
        $commission=($amount/(1-($perc/100)))-$amount;
        $total=ceil(($amount+$commission)/100) * 100;
        $commission=($total/100)*$perc;?>
        <div class="w100 h100 fxg" fxg="gtr:50px auto">
            <div class="lh50 f1 pd10 fs16 clr1 b_bord cbgw"><?=$name?></div>
            <div class="pd10f ofx so">
                <? if($note){echo '<div class="lh30 f1 fs14 clr5 mg10v">'.$note.'</div>';}?>
                <table  border="0" cellspacing="0" cellpadding="6" class="grad_s2 cbgw" type="static" >
                    <tr>
                        <td class="f1 TC " width="250">المبلغ :</td>
                        <td class="TC" width="150" <?=$btn?> ><ff class="clr1"><?=number_format($bal)?></ff>
                        
                    </tr><? 
                    if($partAmount){?>
                        <tr class="cbg555">
                            <td class="f1 TC " width="250">الدفعة الجزئية : </td>
                            <td class="TC" width="150"><ff class="clr2"><?=number_format($partAmount)?></ff></td>
                        </tr><? 
                    }?>
                    <tr>
                        <td class="f1 TC ">عمولة البنك : </td>
                        <td class="TC "><ff class="clr5"><?=number_format($commission)?></ff> <ff14 class="clr9"> (<?=$perc?>%)</ff14></td>
                    </tr>
                    <tr>
                        <td class="f1 TC  ">إجمالي المبلغ : </td>
                        <td class="TC "><ff class="clr1"><?=number_format($amount+$commission)?></ff></td>
                    </tr>
                    <tr>
                        <td class="f1 TC  ">الواجب دفعه : </td>
                        <td class="TC cbg666"><ff class="clr6"><?=number_format($total)?></ff></td>
                    </tr>
                </table>
            </div>
        </div><?
    }
}?>