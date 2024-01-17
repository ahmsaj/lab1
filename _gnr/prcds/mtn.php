<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'])){
	$vis=pp($_POST['v']);
    $mood=pp($_POST['m']);
    $amount=pp($_POST['pay']);
    $r=getRec($visXTables[$mood],$vis);
    if($vis && $mood){
        $r=getRec($visXTables[$mood],$vis);
        if($r['r']){           
           $pat=$r['patient'];          
           $pay_type=$r['pay_type'];
           $sub_status=$r['sub_status'];   
           list($f_name,$l_name,$ft_name,$mobile)=get_val('gnr_m_patients','f_name,l_name,ft_name,mobile',$pat);
           $patName=$f_name.' '.$ft_name.' '.$l_name;
        }?>
        <div class="fxg h100 " fxg="gtr:1fr 50px">
            <div class="h100 r_bord pd20f">
                <div id="payData">
                    <div class="lh40 f1 fs14">حدد رقم الموبايل والمبلغ المراد دفعه</div>                
                    <? if($amount){?>
                        <table style="max-width:400px;" border="0" type="static" cellspacing="0" cellpadding="6" class="grad_s holdH mg10v w100" over="0">
                            <tr>
                                <td txt width="150">رقم الموبايل:</td>
                                <td><input type="number" value="<?=$mobile?>" id="mp_moble"/></td>
                            </tr>
                            <tr>
                                <td txt>المبلغ: ( <?=number_format($amount)?> ) :</td>
                                <td><input type="number" value="<?=$amount?>" max="<?=$amount?>" id="mp_amount"/></td>
                            </tr>
                            <tr>
                                <td txt></td>
                                <td><div class="ic40 ic40_send icc22 ic40Txt mg10f br0" onclick="createMTNPay()">إنشاء دفعة</div> </td>
                            </tr>
                        </table>
                    <?}?>
                </div>
                <div id="payDataOPT" class="hide">
                    <table style="max-width:400px;" border="0" type="static" cellspacing="0" cellpadding="6" class="grad_s holdH mg10v w100" over="0">
                        <tr>
                            <td txt width="150">أدخل رمز التأكيد:</td>
                            <td><input type="number" id="mp_OTP"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="ic40 ic40_send icc22 ic40Txt mg10f br0" onclick="sendMTNotp()">إرسال</div></td>
                        </tr>
                    </table>                    
                </div>
                <div class="f1 fs14 clr5 lh40" id="payErr"></div>
                <div class="loadeText hide" id="payDataLoader">جار انشاء الدفعة يرجى الانتظار</div>             
            </div>
            <div class="cbg4 t_bord">
                <div class="fl ic50_back icc1 flip wh50 wh50" onclick="recNewVisSrvSta(<?=$vis?>,<?=$mood?>)" title="عودة"></div>            
            </div>
        </div><?
    }
}?>