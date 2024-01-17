<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $blans=patDenPay($id);
    $srvDone=get_sum('den_x_visits_services_levels','price'," status=2 and patient='$id' ");
    $cashIn=get_sum('gnr_x_acc_patient_payments','amount',"patient='$id' and type in(0,1,3,4) and mood=4");
    $cashOut=get_sum('gnr_x_acc_patient_payments','amount',"patient='$id' and type in(2) and mood=4");
    $pay=$cashIn-$cashOut;
    $bal=$srvDone-$pay;	?>
	<div class="w100 h100 fxg" fxg="gtr:1fr 50px">
	    <div class="pd10">
            <div class="lh50 clr1 f1 fs16 "><?=get_p_name($id)?></div>	        
	        <form id="patPaySave" name="patPaySave" action="<?=$f_path?>X/gnr_patient_pay_save.php" method="post" cb="accStatN(<?=$id?>)" bv="">
            <input type="hidden" name="id" value="<?=$id?>"/>
            <table width="" border="0" cellspacing="0" cellpadding="0" class="infoTable" type="static" >     <tr>
                    <td txt width="180">قيمة الخدمات المنجزة:</td>
                    <td class="TC"><ff class="clr8"><?=number_format($srvDone)?></ff></td> 
                </tr>
                <tr>
                    <td txt>الدفعات:</td>
                    <td class="TC"><ff class="clr6"><?=number_format($pay)?></ff></td> 
                </tr>
                <tr>
                    <td txt>المستحق:</td>
                    <td class="TC"><ff class="clr5"><?=number_format($bal)?></ff></td> 
                </tr>
                <tr>
                    <td txt><?=k_pay_type?>:<ff class="clr5"> *</ff></td>
                    <td txt><?=selectFromArrayByKey('payTypeSel',$payPatTypes,1,'','t')?></td> 
                </tr>
                <tr>
                    <td txt><?=k_doctor?>:<ff class="clr5"> *</ff></td>
                    <td txt>
                        <? $docs=get_vals('den_x_visits_services','doc',"patient='$id'",'arr');?>
                        <select name="doc" required t id="payDoc"><option value="0"></option><?
                            $sql="select * from _users  where grp_code='fk590v9lvl' and act=1 ";
                            $res=mysql_q($sql);
                            while($r=mysql_f($res)){
                                $doc_id=$r['id'];
                                $doc_name=$r['name_'.$lg];
                                $c='clr6';
                                if(!in_array($doc_id,$docs)){$c='clr5';}
                                echo '<option value="'.$doc_id.'" class="'.$c.'">'.$doc_name.'</option>';
                            }?>
                        </select>
                    </td>				
                </tr>
                <tr>
                    <td txt><?=k_paym?>:<ff class="clr5"> *</ff></td>
                    <td txt><input type="number" name="pay" value="" id="ppay" required/></td>				
                </tr>
            </table>
            </form>
        </div>
        <div class="cbg4 t_bord">
            
            <div class="fr payBut icc22" savePatPay  title="تنفيذ الدفعة نقدا"></div><?
            if(_set_l1acfcztzu){?>
                <div class="fr payCard icc22" visPayCard="5" par="<?=$id?>" id="payCar5" mood="0" title="دفع الكتروني"></div><?
            }?>
            
            <div class="fl ic50_back icc1 flip wh50" backPatAcc title="عودة"></div>
        </div>
    </div>
    <?
}?>