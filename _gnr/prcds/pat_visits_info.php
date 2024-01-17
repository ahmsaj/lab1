<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$pat=pp($_POST['id']);
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
        $visDataArr=[];
        $labClincName=get_val_c('gnr_m_clinics','name_'.$lg,2,'type');
        foreach($visXTables as $mood=>$table){
            if($mood){
                if($mood==2){
                    list($ids,$dates,$rates)= get_vals($table,'id,d_start,rate',"patient='$pat' ",'arr',0,'Order by d_start DESC','');
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
                    list($ids,$dates,$rates,$clinics,$doctors)= get_vals($table,'id,d_start,rate,clinic,doctor',"patient='$pat' and status=2",'arr',0,'Order by d_start DESC','');
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
        ?>
        <div class="win_body">
        <div class="form_header so lh40 clr1 f1 fs18"><ff><?=$pat?> | </ff><?=$pName?></div>
        <div class="form_body so" type="full_pd0">	
            <div class="h100 fxg" fxg="gtc:1fr 2fr 3fr">            
                <div class="ofx so cbg4 r_bord pd10f" actButtE="act" ><?
                    foreach($visData as $k =>$vis){  
                        $n=count($visData[$k]);
                        if($n){
                            echo '<div mood="'.$k.'" class="visList" moodList="'.$k.'">'.$clinicTypes[$k].' <ff14> ( '.$n.' ) </ff14></div>';
                        }
                    }?>
                </div>
                <div class="ofx so pd10f h100 cbg444" actButt="act"><?  
                    foreach($visData as $k =>$vis){                         
                        foreach($vis as $k2 =>$v2){                                
                            $date=$v2[0];
                            $act=$v2[4];
                            $rate=$v2[5];
                            $rateTxt='';                            
                            $addInfo='';
                            if($k!=2){
                                $clinicName=get_val_arr('gnr_m_clinics','name_'.$lg,$v2[2],'c');
                                $docName=get_val_arr('_users','name_'.$lg,$v2[3],'d');
                                $addInfo=' - '. $docName.' ( '.$clinicName.' )';
                            }else{                                
                                $addInfo=' ( '.$labClincName.' )';
                            }
                            echo '<div mood="'.$k.'" class="visList" visList="'.$k2.'" '.$act.'>'.$rateTxt.'<ff14>'.date('Y-m-d',$date).'</ff14>'.$addInfo.'</div>';
                        }
                    }?>
                </div>
                <div class="ofx so h100" id="svhInfo" >
                    <div class="f1 fs14 clr5 pd20f">أختر الزيارة لمعرفة التفاصيل</div>
                </div>
            </div>            
        </div>
        <div class="form_fot fr">
            <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>     
        </div>
        </div><?
    }
}?>