<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']);    
    $r=getRec('dts_x_dates',$id);
    $rr=$r;
    datesTempUp($id);
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
        $ph_src='';
        if($photo){
            $ph_src=viewImage($photo,1,30,30,'img','clinic.png');
        }
        $srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
        if($mood==4){            
            $price=0;
        }else{
            list($timeN,$price)=get_docTimePrice($doc,$srvs,$mood);
        }?>
	    <div class="fl of fxg" fxg="gtc:260px 1fr" fix="wp:0|hp:0">
            <div class="fl pd10 ofx so" ><?
                if($p_type==1){
                    $r=getRec('gnr_m_patients',$pat);
                    if($r['r']){
                        $photo=$r['photo'];
                        $sex=$r['sex'];
                        $title=$r['title'];
                        $mobile=$r['mobile'];
                        $birth_date=$r['birth_date'];
                        $birthCount=birthCount($birth_date);
                        $bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
                        $titles=modListToArray('czuwyi2kqx');
                        $patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');				
                        $pName=$titles[$title].' : '.$r['f_name'].' '.$r['ft_name'].' '.$r['l_name'];?>
                        <div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
                            <script>actNVPat=<?=$pat?></script>
                            <div class="fl pd5"><?=$patPhoto?></div>
                            <div class="fl pd10f">
                                <div class="lh20 f1 fs14 clr1111 Over" editPat="dts"><?=$pName?>
                                    <br><ff14><?=$mobile?></ff14>
                                </div>
                                <div class=" lh20 f1 fs14 clr1"><?=$bdTxt?></div>
                            </div>
                        </div><?
                    }
                }else{
                    $r=getRec('dts_x_patients',$pat);
                    if($r['r']){                        
                        $pName=$r['f_name'].'  '.$r['l_name'];?>
                        <div class="lh20 f1 fs16 clr1111 pd10v uLine Over" editDatPat="<?=$pat?>">
                            <?=$pName?><br><ff14><?=$r['mobile']?></ff14>
                        </div><?
                    }
                }?> 
                <div class="fl w100 uLine pd5v fxg" fxg="gtc:30px 1fr 30px">
                    <div class="fl lh30 " fix="h:30"><?=$ph_src?></div>
                    <div class="fl fs14 lh30 f1 fs12 pd10 "><?=k_clinic.' : '.$name?></div>
                </div>
                <div class="f1 fs14 lh30"><?=k_dr.' : '.$docName?></div>
                <div class="f1 fs14 lh30 ">مدة الموعد: <ff class="clr5"><?=$min?></ff> <?=k_minute?></div>
                <div class="f1 fs14 lh30 ">قيمة الخدمات : <ff class="clr5"><?=number_format($price)?></ff></div><?
                $prvPayments=DTS_PayBalans($id);                
                if($prvPayments){?>
                    <div class="f1 fs14 lh30">المدفوعات السابقة: <ff class="clr6"><?=number_format($prvPayments)?></ff></div><? 
                }?>                
                <div class="f1 fs14 lh30 cbg666 pd10f br5 mg10v" >
                    <div class="f1 fs14 lh30 "><?=$wakeeDays[date('w',$d_start)].': <ff>'.	date('d',$d_start).'</ff> - '.$monthsNames[date('n',$d_start)].' - <ff>'.date('Y',$d_start).'</ff>';
                        $s_h=date('A h:i',$d_start);
                        $e_h=date('A h:i',$d_end);?>
                    </div>
                    <div class="f1 fs14 lh30 ">الساعة: <?='<ff  class="clr55"> '.$s_h.'</ff>'?></div>
                </div>                
            </div>            
            <div class="of l_bord fxg " fxg="gtr:1fr 50px">                
                <div class="ofx so pd10f"><? 
                    if($status==0){
                        if($mood==1 && $sub_status==0){//اختصار الموعد كمراجعة
                            $table=$srvXTables[$mood];
                            $date=get_val_con($table,'d_start'," patient='$pat' and clinic='$c' and rev=0 and status=1 ",' order by d_start DESC');
                            if($date){
                                $time=$dts_date-$date;
                                if($time<(8*86400)){?>
                                    <div class="f1 fs16 mg10v clr5">اختصار الموعد</div>
                                    <div class="fl w100 bord mg10v pd20 pd10v cbg555 br5 uLine">
                                        <div class="f1 fs12 lh30">تاريخ أخر زيارة <ff14 dir="ltr"><?=date('Y-m-d',$date)?></ff14>
                                        <span class="fs12 lh30"> | منذ <?=dateToTimeS($now-$date)?></span>
                                        </div>
                                        <div class="f1 fs12 lh30 ">مدة الموعد <ff14><?=$min?></ff14> دقيقة</div>
                                        <div class="f1 fs12 clr5 lh30">يعتبر هذا الموعد مراجعة يمكن تخفيض زمن الموعد لتوفير وقت الطبيب اختر زمن الموعد الجديد </div>
                                        <select id="dtsNewTime"><?
                                            for($i=$min;$i>0;$i=$i-5){echo '<option value="'.$i.'">'.$i.'</option>';}?>
                                        </select>
                                        <div class=" fl ic30 icc2 ic30_edit ic30Txt mg10v" dtsChange>تعديل الزمن</div>
                                    </div><?
                                }
                            }
                        }
                        $table='gnr_m_patients';
                        if($p_type==2){$table='dts_x_patients';}
                        $sql="select * from dts_x_dates where patient='$pat' and p_type='$p_type' order by d_start DESC  limit 10";
                        $res=mysql_q($sql);
                        $rows=mysql_n($res);
                        if($rows){
                            echo '<div class="f1 fs16 lh40 mg10v clr3">المواعيد السابقة</div>
                            <div class="cbg4 pd20f br5">
                            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s2">';
                            while($r=mysql_f($res)){
                                $h_id=$r['id'];
                                $h_date=$r['d_start'];
                                $h_status=$r['status'];
                                $h_clinic=$r['clinic'];
                                $h_mood=$r['type'];
                                $clinicName=get_val_arr('gnr_m_clinics','name_'.$lg,$h_clinic,'cc');
                                $str='';
                                if($id==$h_id){$str='<div class="clr6 f1"> ( الموعد الحالي )</div>';}
                                echo '                               
                                <tr style="background-color:'.$dateStsInClrBg[$h_status].'">
                                <td class="pd20" width="90"><ff14>'.date('Y-m-d  ',$h_date).'</ff14></td>
                                <td class="f1 pd20">'.$clinicTypes[$h_mood].'</td>
                                <td class="f1 pd20">'.$clinicName.'</td>
                                <td class="f1 pd20 TC" style="color:'.$dateStatusInfoClr[$h_status].'">'.$dateStatus[$h_status].$str.'</td>
                                </tr>';
                            }
                            echo '</table>
                            </div>'; 
                        }else{
                            echo '<div class="f1 fs16 lh40 mg10v clr5">لا يوجد مواعيد سابقة</div>';
                        }
                    }?>
                    <div class="f1 fs16 lh40 mg10v clr1">معلومات إضافية
                    <? if($reserve){echo '<span class="f1 fs16 clr5 cbg555 pd5f"> ( موعد إحتياطي )</span>';}?></div>
                    <div class="cbg888 pd20f br5">
                        <table  border="0" cellspacing="0" cellpadding="4" class="grad_s2">
                            <tr>
                                <td class="f1 pd10 " width="180">رقم الموعد</td>
                                <td class="f1 pd10"><ff14>#<?=$id?></ff14></td>
                            </tr>
                            <tr>
                                <td class="f1 pd10 " width="180">تاريخ انشاء الموعد</td>
                                <td class="f1 pd10"><ff14><?=date('Y-m-d Ah:i',$dts_date)?></ff14></td>
                            </tr>
                            <tr>
                                <td class="f1 pd10">منشئ الموعد</td>
                                <td class="f1 pd10"><?=get_val('_users','name_'.$lg,$reg_user)?></td>
                            </tr>
                            <tr>
                                <td class="f1 pd10">حالة الموعد</td>
                                <td class="f1 pd10" style="background-color:<?=$dateStsInClrBg[$status]?>">
                                    <div class=" f1 fs14 lh40 TC"><?=$dateStatus[$status]?></div><?=dateSubStatus($rr)?></td>
                            </tr>
                            <? if($note){?>
                                <tr>
                                    <td class="f1  pd20">ملاحظات</td>
                                    <td class="f1  pd20"><?=nl2br($note)?></td>
                                </tr>
                            <? }?>
                            <? if($pat_note){?>
                                <tr>
                                    <td class="f1  pd20">ملاحظات المريض</td>
                                    <td class="f1  pd20"><?=nl2br($pat_note)?></td>
                                </tr>
                            <? }?>
                            <tr>
                                <td class="f1  pd20">موعد لشخص آخر</td>
                                <td class="f1  pd20"><img src="../images/sys/act_<?=$other?>.png"/></td>
                            </tr>
                        </table>
                    </div><?
                    $sql="select * from dts_x_dates_services where dts_id='$id' ";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        echo '<div class="f1 fs16 lh40 mg10v clr6">خدمات الموعد </div>
                        <div class="cbg666 pd20f br5">
                        <table  border="0" cellspacing="0" cellpadding="0" class="grad_s2">';
                        while($r=mysql_f($res)){
                            $h_id=$r['id'];
                            $h_service=$r['service'];
                            $h_ser_time=$r['ser_time'];                            
                            $table2=$srvTables[$mood];
                            if($mood==4){
                                $SrvName='جلسة';
                            }else{
                                $SrvName=get_val_arr($table2,'name_'.$lg,$h_service,'srv');
                            }
                            echo '                               
                            <tr>                            
                            <td class="f1  pd20">'.$SrvName.'</td>
                            <td class="f1  pd20"><ff14>'.$h_ser_time.'</ff14> دقيقة</td>
                            </tr>';
                        }
                        echo '</table>
                        </div>'; 
                    }?>
                </div>
                <div class="cbg4 t_bord"><?                    
                    if($reg_user==$thisUser && $status==0){?>
                        <div class="fr lh50 f1 fs14 cbg88 clrw pd20 Over" dtsDone >انهاء حجز الموعد</div>
                        <div class="fl ic50_del icc2 wh50" dtsDel title="حذف"></div>
                        <div class="fl ic50_back icc1 flip wh50" dtsBackTime="<?=$doc?>" title="عودة"></div><? 
                    }else if($status==1 || $status==9){
                        $edit=1;
                        if($other){$p_type=2;}
                        echo '<div class="fl ic50_print icc1 wh50" dtsPrint title="طباعة"></div>';
                        if($ss_day<$d_start && $ee_day>$d_start && $thisGrp=='pfx33zco65'){
                            if($d_start<$now-(60*_set_d9c90np40z )){                                
                                echo '<div class="fl lh50 f1 fs14 clr55  pd20 ">تأخر بالحضور</div>';
                                echo '<div class="fr lh50 f1 fs14 cbg55 clrw pd20 Over" dtsConf="'.$mood.'" patT="'.$p_type.'"> تحويل الى انتظار</div>';
                                $edit=0;
                            }else{
                                echo '<div class="fr lh50 f1 fs14 cbg66 clrw pd20 Over" dtsConf="'.$mood.'" patT="'.$p_type.'" >حضر الموعد</div>';
                            }                            
                        }
                        if($edit){
                            echo '
                            <div class="fl ic50_del icc2 wh50" dtsCancel title="الغاء الموعد" ></div>
                            <div class="fl ic50_edit icc1 flip wh50" dtsBackTime="'.$doc.'" title="'.k_edit.'"></div>';
                        }
                    }
                    
                    ?>
                </div>                
            </div>
        </div><?
    }else{
        mysql_q("DELETE from dts_x_dates_temp where id='$id'");
    }
    if(!$rr['r'] || $status>0){
        delTempOpr(0,$id,9);
    }
}?>