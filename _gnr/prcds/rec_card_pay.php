<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'])){
    //$id=pp($_POST['id']);
    $type=pp($_POST['t']);
    $mood=pp($_POST['mood']);
    $par=pp($_POST['par'],'s');
    //$partAmount=pp($_POST['a']);
    $customPay=pp($_POST['c']);
	$hideInput='';
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
            //$customPay
            if($customPay){$bal=$customPay;}
            $amount=$customPay;
        break;
        case 5:
            $pars=explode(',',$par);
            //$vis=$par[0];                
            if($customPay){$bal=$customPay;}
            $amount=$bal;
            
        break;
        case 6:
            $pars=explode(',',$par);
            //$bal=$par;
            $amount=$pars[0];
            $ofId=$pars[1]; 
            $hideInput='hide';
        break;
    }?>
    <div class="fxg h100 " fxg="gtr:1fr 50px">
        <div class="h100 r_bord pd20f">
            <form name="saveCP" id="saveCP" action="<?=$f_path?>X/gnr_rec_card_pay_do.php" method="post" cb="cardPayment_save('[1]');" bv="data">
                <input type="hidden" name="type" value="<?=$type?>" />
                <input type="hidden" name="mood" value="<?=$mood?>" />
                <input type="hidden" name="par" value="<?=$par?>" />
                <table style="max-width:400px;" border="0" type="static" cellspacing="0" cellpadding="6" class="grad_s holdH mg10v w100" over="0">
                    <tr>
                        <td txt width="150">البنك:</td>
                        <td>
                            <select name="bank" required>
                                <option value="0">--- أختر البنك ---</option><?
                                $sql="select * from gnr_m_banks where act=1 order by ord ASC";
                                $res=mysql_q($sql);
                                $rows=mysql_n($res);
                                if($rows){
                                    while($r=mysql_f($res)){
                                        $id=$r['id'];
                                        $name=$r['name'];
                                        echo '<option value="'.$id.'">'.$name.'</option>';
                                    }
                                }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td txt>المبلغ المستحق :</td>
                        <td txt><ff><?=number_format($amount)?></ff></td>
                    </tr>
                    <tr class="<?=$hideInput?>">
                        <td txt>المبلغ الممدفوع :</td>
                        <td txt><input type="number" name="amount" value="<?=$amount?>" cp_amount="<?=$amount?>" required /></td>
                    </tr>
                    <tr>
                        <td txt></td>
                        <td txt><div class="ic40 icc2 ic40_save ic40Txt " saveCPpay>حفظ</div></td>
                    </tr>
                </table>
            </form>
        </div>        
        <div class="cbg4">
            <div class="fl ic50_back icc1 flip wh50 wh50" payBack="<?=$type?>" title="عودة"></div>
            <div class="fr lh50 pd20 icc33 f1 fs14 clrw hide" pds payDo>إتمام عملية الدفع</div><? 
            if($type<4){?>
                <div class="fl hide" pds><input type="number" value="0" class="cbgw" id="prtPay" fix="w:80|h:50"/></div>
                <div class="fl lh50 icc22 f1 fs14 clrw pd10 hide" pds payPart>دفعة جزئية</div><? 
            }?>
        </div>
    </div><?
}?>