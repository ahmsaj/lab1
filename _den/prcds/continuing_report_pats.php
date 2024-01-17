<? include("../../__sys/prcds/ajax_header.php");
?>
<script>
function copyContent(sel){
    txt=$(sel).html();    
    loader_msg(1,'',1);
    loader_msg(0,'تم نسخ البيانات بنجاح',1);
    navigator.clipboard.writeText(txt);
}
</script><?
if(isset($_POST['ds'],$_POST['de'],$_POST['days'])){ ?>
	<div class="win_body">	    
	    <div class="form_body so" id="patlist"><?
            $ds=strtotime(pp($_POST['ds'],'s'));
            $de=strtotime(pp($_POST['de'],'s'));
            $days=pp($_POST['days']);
            $user=pp($_POST['user']);
            $serInfo=$qDate=$qMood=$qBank=$qUser='';
            $patList=[];  
            if($ds && $de && $days && $de>=$ds){                                
                $qDate="and  d_start >= $ds and d_start<$de and doctor = '$user' ";
                $sql="select * from den_x_visits where status=2 $qDate order by d_start ASC";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){
                    $vidData=[];
                    while($r=mysql_f($res)){
                        $id=$r['id'];
                        $vidData[$id]['type']=$r['type'];            
                        $vidData[$id]['doc']=$r['doctor'];
                        $vidData[$id]['pat']=$r['patient'];
                        $vidData[$id]['date']=$r['d_start'];
                    }
                    $docs=get_arr('_users','id','name_'.$lg," act=1 and grp_code='fk590v9lvl' $qUser ");
                    foreach($docs as $docId=>$doc){                            
                        foreach($vidData as $id=>$v){
                            if($v['type']==2 && $v['doc']==$docId){                                    
                                $ok=0;
                                $pat=$v['pat'];
                                $date=$v['date'];
                                foreach($vidData as $id2=>$v2){
                                    if($id2>$id && $ok==0){
                                        if($pat==$v2['pat'] && $v2['type']==1){
                                            $date2=$v2['date'];
                                            if($date2-$date<($days*86400)){$ok=1;}
                                        }                                    
                                    }
                                }
                                if($ok==0){
                                    if(getTotalCo('den_x_visits_services',"visit_id='$id'")>1){$ok=1;}
                                }
                                if($ok==0){                          
                                    if($now-$date>$days*86400){
                                        $patList[]=$pat;
                                    }
                                }
                            }
                        }                            
                    }                   
                }
                if(count($patList)){
                    $pats=implode(',',$patList);
                    $sql="select * from gnr_m_patients where id in($pats)";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){?>                    
                        <div class="f1 fs14 clr1 lh30">
                            التقرير<ff14 dir="ltr"><?=date('Y-m-d',$ds).' | '.date('Y-m-d',$de)?></ff14>
                            |<span class="f1 pd10 ">الطبيب: <span class="f1 clr1 lh30"> <?=get_val('_users','name_'.$lg,$user)?></span></sapn>
                            <ff14> ( <?=$rows?> )</ff14>
                        </div>
                        <table  border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" width="100%">
                            <tr>                            
                                <th width="50">الرقم</th>
                                <th width="200">المريض</th>
                                <th width="100">تاريخ أخر زيارة</th>
                                <th width="200">الموبايل</th>
                                <th >ملاحظات</th>
                            </tr><?
                            while($r=mysql_f($res)){
                                $id=$r['id'];
                                $full_name=$r['f_name'].' '.$r['ft_name'].' '.$r['l_name'];
                                $lastVisit=get_val_con('den_x_visits_services','d_start'," patient='$id' " ,"order by d_start DESC");
                                ?>
                                <tr>
                                <td><ff14><?=$r['id']?></ff14></td>
                                    <td txtS><?=$full_name?></td>
                                    <td><ff14><?=date('Y-m-d',$lastVisit)?></ff14></td>                                    
                                    <td><ff14><?=$r['mobile']?></ff14></td>
                                    <td></td>
                                </tr><?
                            }?>
                        </table><?
                    }
                }    
            }else{
                echo '<div class="f1 fs14 clr5 lh40">لايوجد نتائج</div>';
            }
        ?>
        </div>
        <div class="form_fot fr">        
            <div class="fl ic40 ic40_save icc33 ic40Txt mg10f br0" onclick="copyContent('#patlist')">نسخ القائمة للذاكرة</div>        
            <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info');"><?=k_close?></div>
        </div>
    </div><?
}?>