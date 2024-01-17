<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p'],$_POST['c'],$_POST['v'],$_POST['p'])){
	$pat=pp($_POST['p']);
	$c=pp($_POST['c']);//clinic
	$vis=pp($_POST['v']);
	$mood=pp($_POST['m']);
	if($vis && $mood){
        list($c,$pat)=get_val($visXTables[$mood],'clinic,patient',$vis);
        echo Script('actNVClinic='.$c.';');        
    }
	list($name,$photo,$mood)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);	    
    $ph_src='';
    if($photo){
        $ph_src=viewImage($photo,1,30,30,'img','clinic.png');
    }
	echo biludWiz(3,1);
    $SkipDoc=0;
    $x_doctor=[];
    $gfx='';
    $selDocArrReq=explode(',',_set_8i5cy9v6t);
    $thisClinicCode=$clinicCode[$mood];
    if(!in_array($thisClinicCode,$selDocArrReq)){$SkipDoc=1;$gfx='50px';}
    ?>		
    <div class="fxg " fxg="gtc:1fr 3fr|gtc:1fr 2fr:1400|gtc:1fr 1fr:950" fix="wp:0|hp:50">
		<div class="fl pd10 ofx so"><?
			$r=getRec('gnr_m_patients',$pat);
			if($r['r']){
				$photo=$r['photo'];
				$sex=$r['sex'];
				$title=$r['title'];
				$birth_date=$r['birth_date'];
                $emplo=$r['emplo'];
                $empTxt='';
                if($emplo){$empTxt='<span class="clr5 f1"> ('.k_employee.')</span>';}
				$birthCount=birthCount($birth_date);
				$bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
				$titles=modListToArray('czuwyi2kqx');
				$patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');				
				$pName=$titles[$title].' : '.$r['f_name'].' '.$r['ft_name'].' '.$r['l_name'].$empTxt;
			}?>
			<div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
				<div class="fl pd5"><?=$patPhoto?></div>
				<div class="fl pd10f">
					<div class="lh20 f1 fs14 clr1111 Over" editPat="doc"><?=$pName?></div>
					<div class=" lh20 f1 fs14 clr1"><?=$bdTxt?></div>
				</div>
			</div>
			<div class="fl w100 uLine pd5v fxg" fxg="gtc:30px 1fr 30px">
				<div class="fl lh30 " fix="h:30"><?=$ph_src?></div>
				<div class="fl lh30 f1 fs12 pd10 "><?=k_clinic.' : '.$name?></div>
                <div class="fr ic30x cbg4 ic30_info icc1" clinS n="<?=$name?>" title="دوام الأطباء"></div>
			</div><?
			$r2=getRecCon($visXTables[$mood]," patient='$pat' and clinic='$c' and id!='$vis' "," order by d_start DESC");
			if($r2['r']){
				$date=$r2['d_start'];
				$doc=$r2['doctor'];?>
                <div class="f1  f1 clr6">معلومات أخر زيارة للعيادة</div>
                <div class="fl w100 ofx so cbg666 pd10 mg10v bord br5">
                    <div class="f1 lh30 f1  ">الطبيب : <span class="f1 clr55"><?=get_val('_users','name_'.$lg,$doc)?></span></div>
                    <div class="f1 lh30 f1">تاريخ الزيارة : <ff14 dir="ltr" class="clr55"><?=date('Y-m-d',$date)?></ff14></div>
                </div>
                <?
			}?>
            <div class="ic40 ic40_info icc22 ic40Txt mg10v" patVishis="<?=$pat?>">تاريخ الزيارات السابقة</div>
		</div>
        <div class="of l_bord w100 fxg" fxg="gtr:1fr <?=$gfx?>">
            <div class=" w100 pd10f ofx so  cbg444"><?
                $dayNo=date('w');
                $date=date('Y-m-d');
                if($mood!=4){
                    $sql="select doc from gnr_x_arc_stop_doc where `date`='$date' ";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows>0){
                        while($r=mysql_f($res)){
                            $doc=$r['doc'];
                            array_push($x_doctor,$doc);
                        }
                    }
}
                $x_doctor_str=implode(',',$x_doctor);
                $selClnc=getAllLikedClinics($c);
                $q=" CONCAT(',', `subgrp`, ',') REGEXP ',($selClnc),' ";
                if($mood==4 ){$q=" u.grp_code='$docsGrpMood[$mood]' ";}
                $sql="select * , u.id as uid from _users u , gnr_m_users_times d where u.id=d.id and u.act=1 and $q  ";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                $docs_data=array();
                if($rows>0){
                    $i=0;
                    while($r=mysql_f($res)){
                        $docs_data[$i]['doc']=$r['uid'];
                        $docs_data[$i]['subgrp']=$r['subgrp'];
                        $docs_data[$i]['clinic']='';
                        if($mood==4){
                             $docs_data[$i]['clinic']=get_val_arr('gnr_m_clinics','name_'.$lg,$r['subgrp'],'c');
                        }                    
                        $docs_data[$i]['name']=$r['name_'.$lg];					
                        $docs_data[$i]['days']=$r['days'];
                        $docs_data[$i]['type']=$r['type'];
                        $docs_data[$i]['data']=$r['data'];
                        $docs_data[$i]['photo']=$r['photo'];
                        $docs_data[$i]['sex']=$r['sex'];
                        $i++;
                    }
                }
                echo '<section  class="reDocList fxg" fxg="gtbf:280px|gap:10px"  >';
                foreach($docs_data as $data){
                    $doc=$data['doc'];
                    $doctor=$data['name'];
                    $photo=$data['photo'];
                    $clinic=$data['clinic'];
                    $sex=$data['sex'];
                    $days=$data['days'];
                    $times=$data['data'];
                    $type=$data['type'];
                    if(in_array($dayNo,explode(',',$days))){
                        $d_time=get_doc_Time($type,$times,$days);
                        $d_realTime=$d_time[1]-$d_time[0];
                        $docStatus='<div class="f1 clr5 fs12">'.k_navailble.'</div>';
                        $docPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');
                        $sel='';
                        if(in_array($doc,$x_doctor)){
                            $docStatus='<div class="f1 clr6 fs12">'.k_dnt_attnd.'</div>';
                        }
                        if(getTotalCO('_log'," user='".$doc."'")){
                            $docStatus='<div class="f1 clr6 fs12">'.k_available.'</div>';
                        }
                        echo showDocBlc($mood,$doc,$docPhoto,$doctor,$docStatus,$clinic);
                        if(!in_array($doc,$x_doctor)){
                            if($d_time[0]<$min_time || $min_time==0)$min_time=$d_time[0];
                            if($d_time[1]>$max_time || $max_time==0)$max_time=$d_time[1];
                        }
                    }
                }
                foreach($docs_data as $data){
                    $doc=$data['doc'];
                    $doctor=$data['name'];
                    $clinic=$data['clinic'];
                    $photo=$data['photo'];
                    $sex=$data['sex'];
                    $days=$data['days'];
                    $docStatus='<div class="f1 clr5 fs12">'.k_tday_dnt_word.'</div>';
                    $docPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');
                    if(!in_array($dayNo,explode(',',$data['days']))){
                        echo showDocBlc($mood,$doc,$docPhoto,$doctor,$docStatus,$clinic);
                    }
                }
                echo '</section>';?>
            </div>        
            <?            
            if($SkipDoc){
                echo '<div class="cbg4 t_bord">
                    <div  class="fl lh50 cbg5 clrw f1 fs14 pd20 Over" skipDoc>تخطي الطبيب</div>
                </div>';
            }?>
        </div>
	</div><?
}?>