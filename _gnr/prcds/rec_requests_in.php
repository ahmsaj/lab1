<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'])){    
	$type=pp($_POST['t']);
    $pars=pp($_POST['pars'],'s');
    
    $reqStatus=['غير معالج','جديد','تم طباعة الطلب سابقا','تم معالجة الطلب'];
    $table='xry_x_visits_requested';
    $col='xry_vis';
    if($type==1){
        $table='lab_x_visits_requested';
        $col='lab_vis';
    }
    /*****Patient filter*/
    $q='';    
	$q_con=[];
	$p=explode('|',$pars);
    $q1=" (status=1 or(status=2 and $col=0)) ";
	foreach($p as $p2){
		$p3=explode(':',$p2);
		$par=$p3[0];
		$val=addslashes($p3[1]);
		if($par=='p1' && $val){$q_con[]="id ='".intval($val)."%' ";}
		if($par=='p2' && $val){$q_con[]=" f_name like'%$val%' ";}
		if($par=='p3' && $val){$q_con[]=" l_name like'%$val%' ";}
		if($par=='p4' && $val){$q_con[]=" ft_name like'%$val%' ";}
		if($par=='p6' && $val){$q_con[]=" mother_name like'%$val%' ";}
		if($par=='p5' && $val){
			$f5=$val;
			$val1=$val2=$val;
			if($val[0]==0){$val2=substr($val,1);}else{$val2='0'.$val;}			
			$q_con[]=" ( mobile like'$val1%' OR mobile like'$val2%' ) ";            
		}
        if($par=='all' && $val==2){
            $q1=" $col>=0  ";
        }
	}
    if(count($q_con)){
        $q=" and patient in(select id from gnr_m_patients where ".(implode(' and ',$q_con)).")";
    }
    /*********/
    
    $sql="select * from $table where $q1 $q  order by status ASC , date DESC limit 100";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){
        echo '<div class="f1 fs16 clr1 lh40">عدد النتائج : '.$rows.'</div>';
        echo '
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH g_ord">                
        <tr>
            <th width="100">التاريخ</th>
            <th>المريض</th>
            <th>الطبيب</th>
            <th>الحالة</th>
            <th width="180"></th>';
        
        while($r=mysql_f($res)){
            $id=$r['id'];
            $date=$r['date'];
            $patient=$r['patient'];
            $doc=$r['doc'];
            $status=$r['status'];
            if( $status==3){
                if($type==1){
                    $butt='<div class=" br0 ic40 icc4 ic40_print ic40Txt mg10" onclick="printWindow(2,'.$id.')">طباعة الطلب </div>';
                }else{
                    $butt='<div class=" br0 ic40 icc4 ic40_print ic40Txt mg10" onclick="printWindow(3,'.$id.')">طباعة الطلب</div>';
                }
            }else{
                if($type==1){                    
                    $butt='<div class="ic40 icc1 ic40_set ic40Txt mg10" blcLOrd="'.$id.'" pat="'.$patient.'">معالجة الطلب</div>';
                }else{
                    $butt='<div class="ic40 icc1 ic40_set ic40Txt mg10" blcXOrd="'.$id.'" pat="'.$patient.'" cln="'.$r['x_clinic'].'">معالجة الطلب</div>';
                }
            }
            echo '<tr>
                <td><ff14>'.date('Y-m-d Ah:i',$date).'</ff14></td>
                <td txt>'.get_p_name($patient).'</td>
                <td txt>'.get_val_arr('_users','name_'.$lg,$doc,'u').'</td>
                <td><div class="f1 clr5">'.$reqStatus[ $status].'</div></td>
                <td>'.$butt.'</td>
            </tr>';
        }
        echo '</table>';
    }else{
        echo '<div class="f1 fs14 clr5 pd20f">لا يوجد نتائج</div>';
    }
    
}?>