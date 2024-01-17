<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']);
    $r=getRec('dts_x_dates',$id);
    if($r['r']){
        $c=$r['clinic'];
        $pat=$r['patient'];
        $doc=$r['doctor'];
        $mood=$r['type'];
        $d_start=$r['d_start'];
        $d_end=$r['d_end'];
        $dts_date=$r['date'];
        $p_type=$r['p_type'];
        $c=$r['clinic'];
        $reg_user=$r['reg_user'];
        $status=$r['status'];
        $sub_status=$r['sub_status'];
        $note=$r['note'];
        $pat_note=$r['pat_note'];
        $other=$r['other'];
        $reserve=$r['reserve'];
        $docName=get_val('_users','name_'.$lg,$doc);
        $min=($d_end-$d_start)/60;
        list($name,$photo,$mood)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);
        $ph_src=viewImage($photo,1,30,30,'img','clinic.png');
        $srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
        if($mood==4){            
            $price=0;
        }else{
            list($timeN,$price)=get_docTimePrice($doc,$srvs,$mood);
        }
        if($status<2 || $status==9){?>
	        <div class="fl of fxg w100 h100" fxg="gtr:1fr 50px" >
            <div class="fl pd10 ofx so" ><?
                if($p_type==1){
                    $r=getRec('gnr_m_patients',$pat);
                    if($r['r']){
                        $photo=$r['photo'];
                        $sex=$r['sex'];
                        $title=$r['title'];
                        $birth_date=$r['birth_date'];
                        $birthCount=birthCount($birth_date);
                        $bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
                        $titles=modListToArray('czuwyi2kqx');
                        $patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');				
                        $pName=$titles[$title].' : '.$r['f_name'].' '.$r['ft_name'].' '.$r['l_name'];?>
                        <div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
                            <div class="fl pd5"><?=$patPhoto?></div>
                            <div class="fl pd10f">
                                <div class="lh20 f1 fs14 clr1111 Over" editPat="doc"><?=$pName?></div>
                                <div class=" lh20 f1 fs14 clr1"><?=$bdTxt?></div>
                            </div>
                        </div><?
                    }
                }else{
                    $r=getRec('dts_x_patients',$pat);
                    if($r['r']){                        
                        $pName=$r['f_name'].'  '.$r['l_name'];?>
                        <div class="lh20 f1 fs16 clr1111 lh40 uLine"><?=$pName?></div><?
                    }
                }
                $prvPayments=DTS_PayBalans($id);                
                if($prvPayments){?>
                    <div class="f1 fs14 lh30">المدفوعات السابقة: <ff class="clr6"><?=number_format($prvPayments)?></ff></div><? 
                }?>                
                
                <div><?
                    $cData=getColumesData('fa4axv3mqg',1);
                    echo '
                    <form name="CanD" id="CanD" action="'.$f_path.'X/dts_cancel_do.php" method="post" cb="dateInfoN('.$id.')" bv="">
                    <input type="hidden" name="id" value="'.$id.'"/>
                    <div class="w100 fl cbg888 pd20f br5 mg10v">
                    <table  border="0" cellspacing="0" cellpadding="4" class="grad_s2" width="100%">
                        <tr>                            
                        <td class="f1 pd10" width="160">'.k_canceler.'</td>
                        <td class="f1 pd10">'.co_getFormInput(0,$cData['6hu8l19gcw'],'',1,1).'</td>
                        </tr>
                        <tr>                            
                        <td class="f1 pd10">سبب الالغاء</td>
                        <td class="f1 pd10">'.co_getFormInput(0,$cData['h31yxgck'],'',1,1).'</td>
                        </tr>
                        <tr>                            
                        <td class="f1 pd10">'.k_notes.'</td>
                        <td class="f1 pd10">'.co_getFormInput(0,$cData['511v6h1aci'],'',1,1).'</td>
                        </tr>
                    </table>
                    </div>
                    </form>';?>
                    <script>loadSuns(',h31yxgck');barCDataSet=''</script>
                </div>                
            </div>
            <div class="cbg4 t_bord">
                <div class="fr lh50 f1 fs14 cbg55 clrw pd20 Over" dtsCancelDo >الغاء الموعد</div>
            </div>
        </div><?
        }else{
            echo '<div class="f1 fs16 clr5 lh50 pd20f">لايمكن تحرير الموعد</div>';
        }
    }else{
        delTempOpr(0,$id,9);
    }
}?>