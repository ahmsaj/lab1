<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $selDoc=pp($_POST['doc']);
	$r=getRec('dts_x_dates',$id);
    if($r['r']){
        $doc=$r['doctor'];
        $pat=$r['patient'];
        $p_type=$r['p_type'];
        $c=$r['clinic'];
        $mood=$r['type'];
        
        $d_start=$r['d_start'];
        $d_end=$r['d_end'];
        $status=$r['status'];
        if($status<2 || $status==9){
            list($name,$photo,$mood)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);
            $ph_src=viewImage($photo,1,30,30,'img','sys/clinic.png');
            echo biludWiz(3,2);?>
            <div class="fxg " fxg="gtc:300px 1fr" fix="wp:0|hp:50">
                <div class="fl pd10 ofx so cbg444 r_bord" actButt="act"><?
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
                        <div class="fl lh30 f1 fs12 pd10 "><?=k_clinic.' : '.$name?></div>
                        <div class="fr ic30x cbg4 ic30_ref icc2" onclick="recNewDtsDoc(<?=$id?>)"></div>
                    </div><?
                    if(isset($visXTables[$mood])){
                        $r2=getRecCon($visXTables[$mood]," patient='$pat' and clinic='$c' and id!='$vis' "," order by d_start ASC");
                        if($r2['r']){
                            $date=$r2['d_start'];
                            $doc=$r2['doctor'];?>
                            <div class="f1  f1 clr6">معلومات أخر زيارة للعيادة</div>
                            <div class="fl w100 ofx so cbg666 pd10 mg10v bord br5">
                                <div class="f1 lh30 f1  ">الطبيب : <span class="f1 clr55"><?=get_val('_users','name_'.$lg,$doc)?></span></div>
                                <div class="f1 lh30 f1">تاريخ الزيارة : <ff14 dir="ltr" class="clr55"><?=date('Y-m-d',$date)?></ff14></div>
                            </div><?
                        }
                    }
                    /*********/
                    $srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
                    $q='';
                    switch($mood){                    
                        case 1:$q2=" ='7htoys03le' ";break;
                        case 3:$q2=" IN('1ceddvqi3g','nlh8spit9q') ";break;
                        case 4:$q2=" ='fk590v9lvl' ";$q=" and id= '$doctor' ";break;
                        case 5:$q2=" ='9yjlzayzp' ";break;
                        case 6:$q2=" ='66hd2fomwt' ";break;
                        case 7:$q2=" ='9k0a1zy2ww' ";break;
                    }
                    $docQ='';	
                    if(in_array($thisGrp,array('fk590v9lvl','1ceddvqi3g','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','9k0a1zy2ww'))){$docQ=" and id='$thisUser' ";}
                    if($mood==4){
                        $sql="select * from _users where act=1  and grp_code  $q2 $docQ order by name_$lg ASC";
                    }else{
                        $selClnc=getAllLikedClinics($c);
                        $sql="select * from _users where act=1  and grp_code  $q2 $docQ $q and CONCAT(',', `subgrp`, ',') REGEXP ',($selClnc),' order by name_$lg ASC";
                    }
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);			
                    if($rows>0){
                        $i=0;
                        while($r=mysql_f($res)){
                            //$date=$r['date'];
                            $u_id=$r['id'];
                            //--------------------------------
                            $srvs=get_vals('cln_m_services','id'," clinic='$c' and def='1'");
                            list($time,$price)=get_docTimePrice($u_id,$srvs,$c_type);
                            //--------------------------------
                            $date=get_docBestDate($u_id,$time);
                            if($date){
                                if($mood==4){
                                    $time=get_val_c('dts_x_dates_services','ser_time',$id,'dts_id' );
                                    $price=0;
                                }else{
                                    list($time,$price)=get_docTimePrice($u_id,$srvs,$mood);
                                }
                                $docs[$date.'-'.$i]['id']=$u_id;
                                $docs[$date.'-'.$i]['photo']=$r['photo'];
                                $docs[$date.'-'.$i]['clinic']=$r['subgrp'];
                                $docs[$date.'-'.$i]['name']=$r['name_'.$lg];
                                $docs[$date.'-'.$i]['sex']=$r['sex'];						
                                $docs[$date.'-'.$i]['price']=$price;
                                $docs[$date.'-'.$i]['time']=$time;
                            }
                            $i++;
                        }
                    }
                    if(is_array($docs)){
                        ksort($docs);
                        $i=1;
                        $frsDoc=0;
                        foreach($docs as $k => $d){
                            $da=explode('-',$k);
                            $date=$da[0];
                            $s_h=date('A h:i',$date);
                            $act='';
                            $doc=$d['id'];
                            if((!$frsDoc && $selDoc==0)  || $selDoc==$doc){
                                $frsDoc=$doc;
                                $act=' act '; 
                            }                                   
                            $clnicName='';
                            if($mood==4){
                                $clnicName=' ( '.get_val_arr('gnr_m_clinics','name_'.$lg,$d['clinic'],'cl').' )';
                            }
                            echo '
                            <div class=" fl w100 dts_list cbgw" '.$act.'  Dtxt="'.$name.'" dtsDoNo="'.$doc.'">
                                <div class="fs14 clr3 f1 lh30 " >'.$d['name'].$clnicName.'</div>
                                <div class="cb f1 fs12 clr9 lh20">
                                '.$wakeeDays[date('w',$date)].' - <ff class="fs14">'.date('d',$date).'</ff> - '.$monthsNames[date('n',$date)].'  
                                <ff class="fs14 clr5">'.$s_h.'</ff>
                                </div>                        
                                <div class="f1 fs12 clr1111 lh20 clr8"><ff14>'.$d['time'].'</ff14> '.k_min.' | <ff14>'.number_format($d['price']).'</ff14> '.k_sp.'</div>
                            </div>';
                            $i++;
                        }
                    }
                    /*********/?>			
                </div>
                <div class="h100 fxg" fxg="gtr:1fr 50px">
                    <div class="fl ofx so " fix="hp:50" dateListView>
                        <script>recNewDtsDocDats(<?=$frsDoc?>)</script>
                    </div>
                    <div class="cbg4 lh50 t_bord">
                        <div class="fr icc4 lh50 pd20  clrw f1 fs14 " loadDaSc>عرض المزيد من المواعيد</div>
                        <div class="fl ic50_del icc2 wh50" dtsDel title="حذف"></div>
                        <div class="fl ic50_back icc1 flip wh50" dtsBackSrv title="عودة"></div>
                    </div>
                </div>
            </div><?
        }else{
            echo '<div class="f1 fs16 clr5 lh50 pd20f">لايمكن تحرير الموعد</div>';
            delTempOpr(0,$id,9);
        }
    }else{
        delTempOpr(0,$id,9);
    }
}?>