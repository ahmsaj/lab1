<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mood'])){
	$id=pp($_POST['id']);
    $mood_s=pp($_POST['mood']);
    $pat=get_val($visXTables[$mood_s],'patient',$id);
    if($pat){
        $rPat=getRec('gnr_m_patients',$pat);        
        if($rPat['r']){
            $photo=$rPat['photo'];
            $sex=$rPat['sex'];
            $title=$rPat['title'];
            $birth_date=$rPat['birth_date'];
            $mobile=$rPat['mobile'];
            $phone=$rPat['phone'];
            $date=$rPat['date'];
            $birthCount=birthCount($birth_date);
            $bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
            $titles=modListToArray('czuwyi2kqx');
            $patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');				
            $pName=$titles[$title].' : '.$rPat['f_name'].' '.$rPat['ft_name'].' '.$rPat['l_name'];
            /*******************************************/
            $visDataArr=[];
            $labClincName=get_val_c('gnr_m_clinics','name_'.$lg,2,'type');
            foreach($visXTables as $mood=>$table){
                if($mood){
                    if($mood==2){
                        list($ids,$dates,$rates)= get_vals($table,'id,d_start,rate',"patient='$pat' ",'arr',0,'Order by d_start DESC','limit 3');
                        foreach($ids as $k =>$v){
                            $v_id=$v;
                            $date=$dates[$k];
                            $rate=$rates[$k];
                            $clinic=0;
                            $doctor=0;
                            $act='';
                            if($id==$v_id && $mood==$mood_s){$act='act';}
                            $visData[$mood][$v_id]=[$date,$rate,$clinic,$doctor,$act,$rate];                            
                        }
                    }else{                        
                        list($ids,$dates,$rates,$clinics,$doctors)= get_vals($table,'id,d_start,rate,clinic,doctor',"patient='$pat' and status=2",'arr',0,'Order by d_start DESC','limit 6');
                        foreach($ids as $k =>$v){                            
                            $v_id=$v;
                            $date=$dates[$k];
                            $rate=$rates[$k];
                            $clinic=$clinics[$k];
                            $doctor=$doctors[$k];
                            $rate=$rates[$k];
                            $act='';
                            if($id==$v_id && $mood==$mood_s){$act='act';}
                            $visData[$mood][$v_id]=[$date,$rate,$clinic,$doctor,$act,$rate];
                        }
                    }
                }
            }
            /*******************************************/?>
            <div class="winButts"><div class="wB_x fr" onclick="actCavOrd=0;win('close','#full_win1');"></div></div>
            <div class="win_free">
                <div class="win_free fxg" fxg="gtc:1fr 300px 1fr:1000|gtc:1fr 300px 2fr">
                    <div class="ofx so r_bord pd10 cbg444">                         
                        <div class="fl w100 uLine fxg" fxg="gtc:50px 1fr">
                            <div class="fl pd5"><?=$patPhoto?></div>
                            <div class="fl pd10f">
                                <div class="lh20 f1 fs14 clr1111 Over" editPat="sta"><?=$pName?></div>
                                <div class="lh20 f1 fs12 clr1"><?=$bdTxt?></div>
                            </div>
                        </div><? 
                        echo '<div class="f1 lh40 fs14" >رقم المريض: <ff14 class="clr66" dir="ltr">'.$pat.'</ff14></div>';  
                        if($mobile){
                            echo '<div class="f1 lh30 fs14">الموبايل: <ff14 class="clr66">'.$mobile.'</ff14></div>'; 
                        }
                        if($phone){
                            echo '<div class="f1 lh40 fs14">الهاتف: <ff14 class="clr66">'.$phone.'</ff14></div>';
                        }
                        echo '<div class="f1 lh40 fs14" >تاريج التسجيل: <ff14 class="clr66" dir="ltr">'.date('Y-m-d',$date).'</ff14></div>';                        
                        ?>
                    </div>
                    <div class="of cbg4 r_bord fxg" fxg="gtr:50px 1fr">
                        <div class="lh50 f1 fs16 clrw pd10 b_bord cbg2 TC">قائمة الزيارات</div>
                        <div class="ofx so pd10f" actButt="act"><?  
                        foreach($visData as $k =>$vis){ 
                            echo '<section class="f1 fs14 lh40">'.$clinicTypes[$k].'</section>';
                            foreach($vis as $k2 =>$v2){                                
                                $date=$v2[0];
                                $act=$v2[4];
                                $rate=$v2[5];
                                $rateTxt='';
                                if($rate){$rateTxt='<div r'.$rate.'>'.$rate.'</div>';}
                                $addInfo='';
                                if($k!=2){
                                    $clinicName=get_val_arr('gnr_m_clinics','name_'.$lg,$v2[2],'c');
                                    $docName=get_val_arr('_users','name_'.$lg,$v2[3],'d');
                                    $addInfo=' - '. $docName.' ( '.$clinicName.' )';
                                }else{
                                    $addInfo=' ( '.$labClincName.' )';
                                }
                                echo '<div mood="'.$k.'" class="visList" eveList="'.$k2.'" '.$act.'>'.$rateTxt.'<ff14>'.date('Y-m-d',$date).'</ff14>'.$addInfo.'</div>';
                            }
                        }?>
                        </div>
                    </div>
                    <div class="of r_bord fxg" fxg="gtr:50px 1fr">
                        <div class="lh50 f1 fs16 clr1 pd10 b_bord">تفاصيل الزيارة </div>
                        <div  class="of" id="rateInfo">
                            <div class="f1 fs14 clr5 lh40 pd20f">أختر زيارة من قائمة الزيارة </div>
                        </div>
                    </div>
                </div>
            </div><?
        }
    }
}?>