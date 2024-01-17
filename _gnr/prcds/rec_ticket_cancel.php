<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'],$_POST['m'])){
    $mood=pp($_POST['m']);
    $vis=pp($_POST['v']);;
    $r=getRec($visXTables[$mood],$vis);
    if($r['r']){
        $visInfo=$r;        
        $c=$r['clinic'];
        $pat=$r['patient'];
        $doc=$r['doctor'];
        $status=$r['status'];
        if($mood==3){$doc=$r['ray_tec'];}
        $pay_type=$r['pay_type'];
        $sub_status=$r['sub_status'];
        $msg='';
        $delAct=1;
        if($mood==6){
            $vis_shoot=$r['vis_shoot'];
            $vis_shoot_r=$r['vis_shoot_r'];
            if($vis_shoot && $vis_shoot_r){
                $msg= '<div class="f1 fs14 pd20f lh30 clr5">لايمكن حذف هذه الزيارة لوجود ضربات محتسبة</div>';
                $delAct=0;
            }else{
                $msg= '<div class="f1 fs14 pd20f lh30 clr5">سيتم حذف الزيارة بالكامل</div>';
            }
        }
        if($status==1){
            if(_set_9iaut3jze){$offersAv=offersList($mood,$pat);}
            $offerTxt='';            
            $offerTxt=showBtySrvOffer($id,$offerSrv,$bupOffer,$price);                
            $price=$offerTxt[0];

        }
        if($mood==2){
            $pat=get_val($visXTables[$mood],'patient',$vis);
            list($name,$photo)=get_val_con('gnr_m_clinics','name_'.$lg.',photo',"type=2");
        }else{
            list($name,$photo,$mood)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);
        }
        $ph_src=viewImage($photo,1,30,30,'img','clinic.png');?>
        <div class="fl of fxg" fxg="gtc:1fr 2fr" fix="wp:0|hp:0">
            <div class="fl pd10 of fxg" fxg="gtr:auto auto 1fr" ><?
                $rPat=getRec('gnr_m_patients',$pat);
                if($rPat['r']){
                    $photo=$rPat['photo'];
                    $sex=$rPat['sex'];
                    $title=$rPat['title'];
                    $birth_date=$rPat['birth_date'];
                    $birthCount=birthCount($birth_date);
                    $bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
                    $titles=modListToArray('czuwyi2kqx');
                    $patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');				
                    $pName=$titles[$title].' : '.$rPat['f_name'].' '.$rPat['ft_name'].' '.$rPat['l_name'];
                }?>
                <div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
                    <div class="fl pd5"><?=$patPhoto?></div>
                    <div class="fl pd10f">
                        <div class="lh20 f1 fs14 clr1111 Over" editPat="sta"><?=$pName?></div>
                        <div class="lh20 f1 fs12 clr1"><?=$bdTxt?></div>
                    </div>
                </div>
                <div class="fl w100 b_bord pd5v pd10">				
                    <div class=" lh30 f1 fs12 "><?=k_clinic.' : '.$name?></div><?
                    if($doc){
                        list($dName,$dPhoto,$sex)=get_val('_users','name_'.$lg.',photo,sex',$doc);?>
                        <div class=" lh30 f1 fs12  "><?=k_doctor.' : '.$dName?></div><?
                    }
                    if($mood==2 || $mood==3){
                        $doc_ord=$r['doc_ord'];
                        $visit_link=$r['visit_link'];
                        if($doc_ord){
                            if($visit_link){
                                $docAsc=get_val('_users','name_'.$lg,$doc_ord);
                            }else{
                                $docAsc=get_val('gnr_m_doc_req','name',$doc_ord);
                            }
                        }                         
                        if($docAsc){
                            $docTxt='<div class="f1 clr3 fs12" reqDoc >'.k_requester_doctor.' : '.$docAsc.'</div>';	
                        }
                        echo $docTxt;
                    }?>
                </div>
                <div class="fl w100 ofx so mg10v" >
                    <div class="f1 fs14 lh30">رقم الزيارة : <ff14 class=" clr1"><?=$vis?></ff14></div>
                    <div class="f1 fs14 lh30">حالة الزيارة : <span class="f1 fs14 clr1"><?=$stats_arr[$status]?></span></div><?
                if($pay_type){?>
                    <div class="f1 fs14 lh30">نوع الزيارة : <span class="f1 fs14 clr1"><?=$pay_types[$pay_type]?></span></div><?
                }?>
                <div class="fl ic40 ic40_ref icc1" onclick="cancelVisInfo(<?=$vis?>,<?=$mood?>)"></div>
            </div>
            </div>
            <div class="of cbg444 l_bord fxg " fxg="gtr:1fr auto"><?
                echo $msg;
                if($delAct){
                    switch($mood){
                        case 1:echo cln_ticket_cancel($visInfo);break;
                        case 2:echo lab_ticket_cancel($visInfo);break;
                        case 3:echo xry_ticket_cancel($visInfo);break;
                        //case 4:echo den_selSrvsSta($vis);break;
                        case 5:echo bty_ticket_cancel($visInfo);break; 
                        case 6:echo lzr_ticket_cancel($visInfo);break; 
                        case 7:echo osc_ticket_cancel($visInfo);break;
                    }
                }?>
            </div>
        </div><?
    }
    
}?>