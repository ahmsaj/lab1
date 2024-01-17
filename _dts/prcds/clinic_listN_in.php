<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']);
	$dates_arr=array();
	$clinic_arr=array();
    $q='';
    if($id){
        $q="where clinic='$id'";
        list($s1,$e1,$s2,$e2)=getDts_SE_clinic($id);// تحديد الشفتات
        //echo '('.$s1.','.$e1.','.$s2.','.$e2.')';
        $s=$s1;
        $e=$e1;
        if($e2){
            $e=$e2;
            if($s2<=$e1){// الشفتات متداخلة
                $e1=$e2;// دمج الشفة الثاني بالاول
                $s2=$e2=0;// الغاء الشفت الثاني
            }
        }
        $blcBasy1=0;
        $blcBasy2=0;
        $blcDone1=0;
        $blcDone2=0;
        $timeLine=($now%86400)-$s;
        $nowDay=($now%86400);
    }
	$sql="select * from dts_x_dates_temp $q order by d_start ASC , reserve ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$data='';
        $datT_Basy1=0;
        $datT_Basy2=0;
		while($r=mysql_f($res)){
			$d_id=$r['id'];
			$doctor=$r['doctor'];
			$patient=$r['patient'];
			$p_type=$r['p_type'];
            $clinic=$r['clinic'];
			$date=$r['date'];
			$status=$r['status'];
			$name=$r['name_'.$lg];	
			$d_status=$r['status'];
			$c_type=$r['type'];
			$d_start=$r['d_start'];
			$ds=$r['d_start']-$ss_day;
			$de=$r['d_end']-$ss_day;
            $other=$r['other'];
			$p_name=$r['pat_name'];
            $reserve=$r['reserve'];
			$p_note='';	
			if($p_type==2 || $other){
				$p_note='<div class="f1 clr5 lh20">يجب تثبيت اسم المريض</div>';
				$p_type=2;
			}
            $d_t=$de-$ds;
            if($id){
                if(in_array($status,array(1,2,3,4,6,8))){
                    if($ds>=$s1 && $ds<$e1){
                        $blcBasy1+=$d_t;
                        if($ds<$nowDay){ // حساب الاشغال الحقيقي بعد الزمن الحالي            
                            if($de>$nowDay){
                                $datT_Basy1+=$de-$nowDay;
                            }
                        }else{
                            $datT_Basy1+=$de-$ds;
                        }
                    }
                    
                    if($ds>=$s2 && $ds<$e2){
                        $blcBasy2+=$d_t;
                        if($ds<$nowDay){ // حساب الاشغال الحقيقي بعد الزمن الحالي            
                            if($de>$nowDay){
                                $datT_Basy2+=$de-$nowDay;
                            }
                        }else{
                            $datT_Basy2+=$de-$ds;
                        }
                    }
                }
            }
			$flasher='';
			if($d_status==2 && $d_start < $now ){$flasher='flasher2';}	
			if($d_status==2 && $d_start < $now-(60*_set_d9c90np40z)){$flasher='flasher';}
            $reserveTxt='';
            if($reserve){$reserveTxt='<span class="clrw cbg5 br5 lh30 pd5v pd5 mg5">إحتياطي</span>';}
            $docName=get_val_arr('_users','name_'.$lg,$doctor,'doc');
            $clnName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'cln');
			$data.='<tr bgcolor="'.$dateStsInClrBg[$status].'" class="'.$flasher.'" dtsTr="'.$p_name.'">
				<td><ff14>'.clockStr($ds).'</ff14s></td>
				<td class="f1"><ff14>'.($d_t/60).'</ff14></td>
				<td class="f1">'.$p_name.$p_note.'</td>
				<td class="f1">'.$docName.'</td>
                <td class="f1">'.$clnName.'</td>
				<td class="f1">'.$dateStatusInfo[$status].$reserveTxt.'</td>
				<td>
					<div>
						<div class="i30 i30_info fl" title="تفاصيل" dts="'.$d_id.'"></div>';
						if($status==1 && $now<$d_start+(60*_set_d9c90np40z)){
                            $data.='<div class="i30 i30_done fl" title="تأكيد حضور المريض"  dtsCfIn="'.$c_type.'" pt="'.$p_type.'" dId="'.$d_id.'"></div>';
                        }
                   $data.='</div>
				</td>
			</tr>';
		}
        if($id){            
            if($s){
                $s_h=date('A h:i',$s);
                $e_h=date('A h:i',$e);
                $d_val=$s-($s%86400);
                $s_val=$s%86400;
                $e_val=$s_val+($timeN*60);
                $timeH=$s%86400;//block time start by secunds
                $startM=($s%86400)/60;
                $endM=($e%86400)/60;
                $timeA=$endM-$startM;        
                $hourWidth=60*100/$timeA;
                $lineWidth= 100*(($timeLine)/60)/$timeA;
                //echo clockStr(($blcBasy1+$blcBasy2),2);                
                $datT_All=$e1-$s1+$e2-$s2;
                $s11=$s1;
                $s22=$s2;
                $e11=$e1;
                $e22=$e2;
                $statPoint=$timeLine+$s1;
                if($statPoint>$s11){$s11=$statPoint;}
                if($statPoint>$e11){$s11=$e11=0;}
                if($s22){
                    if($statPoint>$s22){$s22=$statPoint;}
                    if($statPoint>$e22){$s22=$e22=0;}
                }
                $datT_AllInTime1=$e11-$s11; 
                $datT_AllInTime2=$e22-$s22; 
                $datT_AllInTime=$e11-$s11+$e22-$s22;               
                $datT_Free=clockStr($datT_Free);
                $datT_Basy=$datT_Basy1+$datT_Basy2;
                ?>
                <div class="w100 fl cbgw mg10v br5">
                <div class="fl lh40 f1 pd10 clr1">إجمالي الساعات الباقية : <ff14><?=clockStr($datT_AllInTime,2)?></ff14></div>
                <div class="fl lh40 f1 pd10 clr5">الوقت المشغول : <ff14><?=clockStr($datT_Basy,2)?></ff14></div>
                <div class="fl lh40 f1 pd10 clr6">الوقت المتوفر : <ff14><?=clockStr($datT_AllInTime-$datT_Basy,2)?></ff14></div>
                
                </div>
                <div class="fl w100 pr bord mg20v cbgw of">
                
                <div class="fl w100 lh50 cbgw dtsSlider2"><?                    
                    $bWidth= 100*(($e1-$s1)/60)/$timeA; 
                    $bWidthIn=0;
                    echo '<div class="fl cbg7" style="width:'.$bWidth.'%" title="الزمن المتوفر">';
                        if($blcBasy1){
                            $bWidthIn= 100*(($blcBasy1))/($e1-$s1);                     
                            echo '<div class="fl cbg8" style="width:'.$bWidthIn.'%" title="اجمالي المواعيد المحجوزة">&nbsp;</div>';                            
                        }
                        
                        $blcDone1=$e1-$s1-$datT_AllInTime1-$blcBasy1;
                        $bWidthIn2= 100*(($blcDone1))/($e1-$s1);
                        if($bWidthIn2){
                            echo '<div class="fl cbg5" style="width:'.$bWidthIn2.'%" title="الوقت الضائع"></div>';
                        }
                    echo '</div>';
                    if($s2){
                        $bWidthIn=0;
                        $bWidth= 100*(($s2-$e1)/60)/$timeA;
                        echo '<div class="fl cbg555" style="width:'.$bWidth.'%" title="الزمن بين الشفتين"></div>';
                        
                        $bWidth= 100*(($e2-$s2)/60)/$timeA;                     
                        echo '<div class="fl cbg7" style="width:'.$bWidth.'%" title="الزمن المتوفر">';
                        if($blcBasy2){
                            $bWidthIn= 100*(($blcBasy2))/($e2-$s2);                     
                            echo '<div class="fl cbg8" style="width:'.$bWidthIn.'%" title="اجمالي المواعيد المحجوزة"></div>';
                        }                    
                        $blcDone2=$e2-$s2-$datT_AllInTime2-$blcBasy2;
                        $bWidthIn2= 100*(($blcDone2))/($e2-$s2);
                        if($bWidthIn2){
                            echo '<div class="fl cbg5" style="width:'.$bWidthIn2.'%" title="الوقت الضائع"></div>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="fl cbg444 w100 lh20 bs">
                    <div class="timeLine bs" style="width:<?=$lineWidth?>%" title="الوقت المنقضي"></div>
                    <div class="fl pd5"><?=$s_h?></div>
                    <div class="fr pd5"><?=$e_h?></div>
                </div>
            </div> <?
            }
        }
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" type="static" over="0" >
		<tr><th>الموعد</th><th>المدة</th><th>المريض</th><th>الطبيب</th>
        <th>العيادة</th><th>الحالة</th><th width="70">العمليات</th></tr>'.$data.'
		</table>';
	}
}?>