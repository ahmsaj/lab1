<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['ds'],$_POST['de'],$_POST['days'])){
	$ds=strtotime(pp($_POST['ds'],'s'));
    $de=strtotime(pp($_POST['de'],'s'));
    $days=pp($_POST['days']);
    $user=pp($_POST['user']);
    $serInfo=$qDate=$qMood=$qBank=$qUser='';   
    if($ds && $de && $days && $de>=$ds){
        if($user){
            $qUser=" and id = '$user' ";
             $serInfo.='<div class="fl f1 pd10 bord mg5 cbg444 br5">الطبيب: <span class="f1 clr1 lh30"> '.get_val('_users','name_'.$lg,$user).'</span></div>';
        }
        /*********************************/    
        $qDate="and  d_start >= $ds and d_start<$de";

        echo '<div class="f1 fs14 clr1 lh50 b_bord">التقرير<ff14 dir="ltr">'.date('Y-m-d',$ds).' | '.date('Y-m-d',$de).'</ff14></div>
        <div class="fl w100 f1 pd10v">'.$serInfo.'</div>';        
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
            $docs=get_arr('_users','id','name_'.$lg," act=1 and grp_code='fk590v9lvl' $qUser ");?>
            <table  border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
                <tr>
                    <th>الطبيب</th>
                    <th width="100">الاستشارات</th>
                    <th width="100">المستمرين</th>
                    <th width="100">غير المستمرين</th>
                    <th width="200">أقل من ( <?=$days?> ) أيام</th>
                    <th width="200">الملخص</th>
                </tr>
                <?
                $total=[0,0,0,0];
                foreach($docs as $docId=>$doc){
                    $cons=$yes=$no=$x=0;
                    foreach($vidData as $id=>$v){
                        if($v['type']==2 && $v['doc']==$docId){
                            $cons++;
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
                                if(getTotalCo('den_x_visits_services',"visit_id='$id'")>1){
                                    $ok=1;
                                }
                            }
                            if($ok){
                                $yes++;
                            }else{if($now-$date>$days*86400){$no++;}else{$x++;}}
                        }
                    }

                    $total[0]+=$cons;
                    $total[1]+=$yes;
                    $total[2]+=$no;
                    $total[3]+=$x;
                    $acu=$cons-$x;
                    $s=$yes*100/$acu;
                    $status='<div class="f1" dir="ltr">'.$acu.'/'.$yes.' ('.number_format($s,2).'%)</div>';
                    if($cons){?>
                        <tr>
                            <td txtS><?=$doc?></td>
                            <td><ff14 class="clr8"><?=number_format($cons)?></ff14></td>
                            <td><ff14 class="clr6"><?=number_format($yes)?></ff14></td>
                            <td><ff14 class="clrw br5 icc22 pd10 pd5v" onclick="coDos_send(<?=$docId?>)"><?=number_format($no)?></ff14></td>
                            <td><ff14 class="clr77"><?=number_format($x)?></ff14></td>
                            <td><ff14 class="clr2"><?=$status?></ff14></td>
                        </tr><?
                    }
                }
                $acu=$total[0]-$total[3];
                $s=$total[1]*100/$acu;
                $status='<div class="f1" dir="ltr">'.$acu.'/'.$total[1].' ('.number_format($s,2).'%)</div>';?>
                <tr fot>                
                    <td txtS><?=k_total?></td>
                    <td><ff14 class="clr8"><?=number_format($total[0])?></ff14></td>
                    <td><ff14 class="clr6"><?=number_format($total[1])?></ff14></td>
                    <td><ff14 class="clr5"><?=number_format($total[2])?></ff14></td>
                    <td><ff14 class="clr77"><?=number_format($total[3])?></ff14></td>
                    <td><ff14 class="clr2"><?=$status?></ff14></td>
                </tr>
            </table><?
        }else{
            echo '<div class="f1 fs14 clr5 lh40">لايوجد نتائج</div>';
        }        
    }else{
        echo '<div class="f1 fs14 clr5 lh40">خطأ بإدخال البيانات</div>';
    }
}?>