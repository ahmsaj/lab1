<? include("../../__sys/prcds/ajax_header.php");
$act=pp($_POST['act']);
$data=$_POST['data'];
$no=pp($data['no']); 
$name=pp($data['name'],'s'); 
$l_name=pp($data['l_name'],'s'); 
$father=pp($data['father'],'s'); 
$phone=pp($data['phone']); 
$type=pp($data['type']); 
$time=pp($data['time']);
$q='';

/************Type*********************/
if($type==1){$q.=" and process_status = 0";}
if($type==2){$q.=" and process_status in(0,1)";}
/************Time*********************/
if($time==1){$q.=" and add_date>= $ss_day";}
if($time==2){$q.=" and add_date>= ".($ss_day+(86400*30));}

/************Patient******************/
$p_q=[];
if($no){
    $q.=" and patient = $no";
}else{    
    if($name){$p_q[]=" f_name like '%$name%'";}
    if($l_name){$p_q[]=" l_name like '%$l_name%'";}
    if($father){$p_q[]=" ft_name like '%$father%'";}
    if($phone){$p_q[]=" mobile like '$phone%'";}
    if(count($p_q)){
        $q.= " and patient in(select id from gnr_m_patients where ".(implode(' and ',$p_q)).")";
    }
}
/****************************/
$sql="select * from gnr_x_prescription where sending_status=1 $q order by add_date DESC limit 100";
$res=mysql_q($sql);
echo $rows=mysql_n($res);
echo '^';
//echo $sql;
if($rows){
    while($r=mysql_f($res)){
        $id=$r['id'];
        $patient=$r['patient'];
        $date=$r['add_date'];
        $sending_status=$r['sending_status'];
        $process_status=$r['process_status'];
        $status_txt='';
        
        $status_txt='<div class="f1 fs10 pd5t '.$presc_pr_status[$process_status][1].'">
            '.$presc_pr_status[$process_status][0].'
        </div>';
        $actCls='cbgw';
        if($act==$id){$actCls='cbg7';}
        echo '<div class="bord  pd10f mg10b br5 f1 Over '.$actCls.'" prec="'.$id.'">
            <div class="fr f1 clr1">'.dateToTimeS2($now-$date).'</div>
            '.get_p_name($patient).'
            '.$status_txt.'
        </div>';
    }
}else{
    echo '<div class="f1 clr5 fs14">لايوجد نتائج</div>';
}
?>
