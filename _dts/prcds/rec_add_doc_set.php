<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $s=pp($_POST['s']);
    $e=pp($_POST['e']);
    $doc=pp($_POST['doc']);
	$r=getRec('dts_x_dates',$id);
    if($r['r']){
        //$doctor=$r['doctor'];
        
        $pat=$r['patient'];
        $p_type=$r['p_type'];
        $c=$r['clinic'];
        $mood=$r['type'];
        //$d_start=$r['d_start'];
        //$d_end=$r['d_end'];
        $status=$r['status'];
        if($status<2 || $status==9){
            if($doctor){$doc=$doctor;}            
            if($mood==4){                
                list($c,$docName)=get_val('_users','subgrp,name_'.$lg,$doc);                
            }else{
                $docName=get_val('_users','name_'.$lg,$doc);
            }
            list($name,$photo,$mood)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);
            
            $ph_src=viewImage($photo,1,30,30,'img','sys/clinic.png');
            $srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
            if($mood==4){
                $timeN=get_val_c('dts_x_dates_services','ser_time',$id,'dts_id' );
                $price=0;
            }else{
                list($timeN,$price)=get_docTimePrice($doc,$srvs,$mood);
            }
            $d_val=$s-($s%86400);
            $s_val=$s%86400;
            $e_val=$s_val+($timeN*60);
            $timeH=$s%86400;//block time start by secunds
            $startM=($s%86400)/60;
            $endM=($e%86400)/60;
            $timeA=$endM-$startM;        
            $hourWidth=60*100/$timeA;?>
            <form name="n_d_d" id="n_d_d" fix="hp:0" action="<?=$f_path?>X/dts_new_date_in_save.php" method="post"  cb="checkDateStatusN('[1]',<?=$id?>,<?=$pat?>);" bv="a">
            <div class="fxg w100 h100" fxg="gtc:260px 1fr" fix="">
                <div class="fl pd10 ofx so  r_bord"><?
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
                    }?> 
                    <div class="fl w100 uLine pd5v fxg" fxg="gtc:30px 1fr 30px">
                        <div class="fl lh30 " fix="h:30"><?=$ph_src?></div>
                        <div class="fl fs14 lh30 f1 fs12 pd10 "><?=k_clinic.' : '.$name?></div>
                    </div>
                    <div class="f1 fs14 lh30"><?=k_dr.' : '.$docName?></div>
                    <div class="f1 fs14 lh30 ">مدة الموعد: <ff class="clr5"><?=$timeN?></ff> <?=k_minute?></div>
                    <div class="f1 fs14 lh30 ">قيمة الخدمات : <ff class="clr5"><?=number_format($price)?></ff></div><?
                    $prvPayments=DTS_PayBalans($id);                
                    if($prvPayments){?>
                        <div class="f1 fs14 lh30">المدفوعات السابقة: <ff class="clr6"><?=number_format($prvPayments)?></ff></div><? 
                    }
                    $price-=$prvPayments;?>
                    <div class="cb bord cbg666 pd20f br5 mg10v">
                        <div class="f1 fs16 lh30 clr66 ">الوقت المتوفر :</div>
                        <div class="f1 fs14 lh30 "><?=$wakeeDays[date('w',$s)].' - <ff>'.	date('d',$s).'</ff> - '.$monthsNames[date('n',$s)].' - <ff>'.date('Y',$s).'</ff>';
                            $s_h=date('A h:i',$s);
                            $e_h=date('A h:i',$e);
                            $w_h=date('A h:i',$e_val);?>
                        </div>
                        <div class="f1 fs12 lh30"><?='<ff dir="ltr" class="clr55">'.$s_h.'-'.$e_h.'</ff>'?></div>
                    </div>
                    
                </div>
                <div class="fl fxg  h100" fxg="gtr:1fr 50px">                
                    <div class="pd20f ofx so">
                        <input name="id" type="hidden" value="<?=$id?>"/>
                        <input name="dd" type="hidden" value="<?=$d_val?>"/>
                        <input name="ds" type="hidden" id="ds" value="<?=$s_val?>"/>
                        <input name="de" type="hidden" id="de" value="<?=$e_val?>"/>
                        <input name="doc" type="hidden" id="doc" value="<?=$doc?>"/>
                        <div class="fl  fl clr1 cb " dir="<?=$lg_dir?>">
                            <div class="fl fs24 slidBar_s lh40 clr6"><?=$s_h?></div>
                            <div class="fl pd10 lh40 clr6"> / </div>
                            <div class="fl fs12 slidBar_e lh40 clr6"><?=$w_h?></div>
                        </div>
                        <div class="fl w100 pr bord">
                            <div class="fl w100 dtsSliderBlcs"><?
                                $point=0;                        
                                $dtsBlk=$timeN*$hourWidth/60;
                                while($point<$endM){ 
                                    $w=$hourWidth;
                                    $clock=clockStr($point*60);
                                    if($point==0){
                                        $point=$startM;
                                        $clock=clockStr($point*60);
                                        if($startM%60==0){
                                            $point+=60;                                    
                                        }else{
                                            $blk=60-($startM%60);                                    
                                            $w=$blk/60*$w;
                                            $point=$startM+$blk;
                                        }
                                    }else{
                                        if($endM-$point<60){                                    
                                            $blk=60-($point%60);
                                            $w=$blk/100*$w;
                                        }
                                        $point+=60;
                                    }
                                    echo '<div class="fl" b style="width:'.$w.'%">'.$clock.'</div>';
                                }?>
                            </div>
                            <div class="fl w100 lh50 cbg7 dtsSlider" th="<?=$timeH?>" ta="<?=$timeA?>" tn="<?=$timeN?>" ts="<?=_set_pn68gsh6dj?>">
                                <div style="width:<?=$dtsBlk?>%" id="dSlidN">
                                    <div></div>
                                </div>
                            </div>
                            <div class="fl cbg444 w100 lh30 ">
                                <div class="fl pd5"><?=$s_h?></div>
                                <div class="fr pd5"><?=$e_h?></div>
                            </div>
                        </div>
                        <div class="fl w100 f1 fs14 lh30 mg10v">ملاحظات :</div>
                        <textarea name="note" class="so w100 cbg444 pd10f" fix="h:80"><?=$note?></textarea>
                        <div class="fl w100  f1 fs14 lh40 mg10v"><input type="checkbox" name="other"/>موعد لشخص أخر</div> 
                    </div>
                    <div class="fl w100 lh50 cbg4 t_bord">
                        <div class="lh50 cbg66 fr">
                            <div class="fr clrw f1 fs14 pd10 ">دفعة مقدمة</div><?
                            if(_set_l1acfcztzu){?>
                                <div class="fl payCard icc22" visPayCard="4" par="<?=$id?>" mood="<?=$mood?>" title="دفع الكتروني"></div><?
                            }?>
                            <div class="fr clrw f1 fs14 pd10 ">
                                <ff class="fs20">
                                    <input type="number" name="dPay" id="dPay" max="<?=$price?>" value="0" style="width:100px;">
                                </ff>
                            </div>
                            <div class="fl payBut icc22" dtspaybut  title="<?=k_save?>"></div>
                        </div>
                        <div class="fl ic50_del icc2 wh50" dtsDel title="حذف"></div>
                        <div class="fl ic50_back flip icc1 wh50" dtsBack title="عودة"></div>
                    </div>
                </div>            
            </div>
            </form><?
        }else{
            echo '<div class="f1 fs16 clr5 lh50 pd20f">لايمكن تحرير الموعد</div>';
        }
    }
}?>