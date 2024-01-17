<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['part'])){
	$vis=pp($_POST['vis']);
	$part=pp($_POST['part']);
	$r=getRec('bty_x_laser_visits',$vis);
	$sTotal=0;
	if($r['r']){
		$doctor=$r['doctor'];
		$vis_status=$r['status'];
		$patient=$r['patient'];
        $device=$r['device'];
        if($device){
		    if($doctor==$thisUser){
                if(!$part){
                    $srvValArr=array();
                    $srvArr=array();
                    $srvs=array();
                    $sql="select * from bty_x_laser_visits_services_vals where visit_id='$vis'";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){while($r=mysql_f($res)){array_push($srvValArr,$r);}}			

                    $sql="select * from bty_x_laser_visits_services where visit_id='$vis'";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        while($r=mysql_f($res)){
                            array_push($srvArr,$r);
                            array_push($srvs,$r['service']);
                        }
                    }
                    $srvsTxt=get_arr('bty_m_services','id','name_'.$lg," id IN(".implode(',',($srvs)).")");	

                    echo '<table width="100%" border="0" cellspacing="5" cellpadding="4" class="vs_table f9" id="lasSrvs">';
                    echo '<tr>
                        <th>'.k_service.'</th>
                        <th>المناطق</th>
                        <th width="80" class="TC f1">'.k_energy.'</th>
                        <th width="80" class="TC f1">'.k_fist.'</th>
                        <th width="80" class="TC f1">'.k_repet.'</th>
                        <th width="80" class="TC f1">'.k_pulse_width.' </th>
                        <th width="80" class="TC f1">'.k_pulses.'</th>
                        <th width="40"></th>
                    </tr>';
                    foreach($srvArr as $srv){
                        $srvStatus=1;
                        $cParts=0;
                        foreach($srvValArr as $part){if($srv['id']==$part['serv_x']){$cParts++;}}
                        foreach($srvValArr as $part){
                            if($srv['id']==$part['serv_x']){
                                $part_id=$part['id'];
                                $serv=$part['serv'];
                                $serv_x=$part['serv_x'];
                                $s_part=$part['part'];
                                $status=$part['status'];
                                $v_fluence=$part['v_fluence'];
                                $v_pulse=$part['v_pulse'];
                                $v_rep_rate=$part['v_rep_rate'];
                                $v_wave=$part['v_wave'];
                                $counter=$part['counter'];				
                                $price=$part['price'];
                                $date=$part['date'];
                                if($vis_status!=2){
                                    if($status==0){
                                        $but='<div class="fr ic30 icc4 ic30_done" title="'.k_save.'" s="'.$part_id.'" ></div>';
                                    }else{
                                        $but='<div class="fr ic30 icc3 ic30_ref" title="'.k_rt_srv.'" r="'.$part_id.'" ></div>';
                                    }
                                }
                                echo '<tr part'.$part_id.'>';
                                if($cParts!=0){
                                    echo '
                                    <td rowspan="'.$cParts.'" valign="top">
                                        <div class="fl i30 i30_del" title="'.k_delete.'" delLsrv="'.$serv_x.'" ></div>
                                        <div class="fl fs14 f1 pd10 lh30">'.$srvsTxt[$srv['service']].'</div>
                                    </td>';
                                    $cParts=0;
                                }
                                echo '<td class="f1 fs14">
                                    <div class="fl i30 i30_ser" title="'.k_details.'" d="'.$s_part.'" ></div>
                                    <div class="fl pd10 fs14 f1 lh30 clr1111" >'.get_val_arr('bty_m_visits_services_parts','name_'.$lg,$part['part'],'srv').'</div>
                                                                                 
                                    </td>';
                                if($status==0){
                                    if($v_fluence==0){
                                        $r=getRecCon('bty_x_laser_visits_services_vals',"patient='$patient' and part='$s_part' and  id != '$part_id' ","order by id DESC");
                                        if($r['r']){
                                            $v_fluence=$r['v_fluence'];
                                            $v_pulse=$r['v_pulse'];
                                            $v_rep_rate=$r['v_rep_rate'];
                                            $v_wave=$r['v_wave'];
                                        }
                                    }
                                    echo '<td><input type="number" required name="flun" value="'.$v_fluence.'"/></td>
                                    <td><input type="number" required name="pulse" value="'.$v_pulse.'"/></td>
                                    <td><input type="number" required name="rate" value="'.$v_rep_rate.'"/></td>
                                    <td><input type="number" required name="wave" value="'.$v_wave.'"/></td>	
                                    <td><input type="number" required name="counter" value="'.$counter.'"/></td>
                                    <td>'.$but.'</td>';

                                }else{
                                    $sTotal+=$counter;
                                    echo '<td class="TC"><ff>'.$v_fluence.'</ff></td>
                                    <td class="TC"><ff>'.$v_pulse.'</ff></td>
                                    <td class="TC"><ff>'.$v_rep_rate.'</ff></td>
                                    <td class="TC"><ff>'.$v_wave.'</ff></td>	
                                    <td class="TC"><ff>'.$counter.'</ff></td>		
                                    <td class="TC"><ff>'.$but.'</ff></td>';
                                }
                                echo '</tr>';
                            }
                        }
                    }
                    echo '<tr>					
                        <th colspan="6" class="TR">مجموع الضرابات</th>
                        <th class="TC f1 clr1"><ff>'.$sTotal.'</ff></th>
                        <th width="40"></th>
                        </tr>';
                    echo '</table>';				
                }else{
                    $sql="select * from bty_x_laser_visits_services_vals where patient='$patient' and  part='$part' order by id  DESC";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        $partTxt=get_val('bty_m_visits_services_parts','name_'.$lg,$part);	
                        echo '
                        <div class="fl mg10v w100" fix="w:700">
                            <div class="fl f1 lh40 fs18 f1">'.$partTxt.'</div>
                            <table width="100%" border="0" cellspacing="5" cellpadding="4" class="vs_table f9" id="lasSrvs">
                            <tr>					
                            <th>'.k_date.'</th>
                            <th width="80" class="TC f1">'.k_energy.'</th>
                            <th width="80" class="TC f1">'.k_fist.'</th>
                            <th width="80" class="TC f1">'.k_repet.'</th>
                            <th width="80" class="TC f1">'.k_pulse_width.' </th>
                            <th width="80" class="TC f1">'.k_pulses.'</th>
                            <th width="40"></th>
                            </tr>';
                            while($r=mysql_f($res)){						
                                $part_id=$r['id'];
                                $serv=$r['serv'];
                                $s_part=$r['part'];
                                $status=$r['status'];
                                $visit_id=$r['visit_id'];
                                $v_fluence=$r['v_fluence'];
                                $v_pulse=$r['v_pulse'];
                                $v_rep_rate=$r['v_rep_rate'];
                                $v_wave=$r['v_wave'];
                                $counter=$r['counter'];				
                                $price=$r['price'];
                                $date=$r['date'];
                                $but='';
                                if($visit_id==$vis){
                                    $dateTxt='الزيارة الحالية';
                                    if($status==0){
                                        $but='<div class="fr ic30 icc4 ic30_done" title="'.k_save.'" s="'.$part_id.'" ></div>';
                                    }else{
                                        $but='<div class="fr ic30 icc3 ic30_ref" title="'.k_rt_srv.'" r="'.$part_id.'" ></div>';
                                    }
                                }else{
                                    $dateTxt='<ff>'.date('Y-m-d',$date).'</ff>';
                                }
                                echo '<tr part'.$part_id.'>';
                                if($cParts!=0){
                                    echo '
                                        <div class="fl i30  i30_del" title="'.k_delete.'" s="'.$part_id.'" ></div>
                                        <div class="fs14 f1 lh30">'.$srvsTxt[$srv['service']].'</div>
                                    </td>';
                                    $cParts=0;
                                }
                                echo '<td class="f1 fs14">'.$dateTxt.'</td>';
                                if($status==0){
                                    if($v_fluence==0){
                                        $r=getRecCon('bty_x_laser_visits_services_vals',"patient='$patient' and part='$s_part' and  id != '$part_id' ","order by id DESC");
                                        if($r['r']){
                                            $v_fluence=$r['v_fluence'];
                                            $v_pulse=$r['v_pulse'];
                                            $v_rep_rate=$r['v_rep_rate'];
                                            $v_wave=$r['v_wave'];
                                        }
                                    }
                                    echo '<td><input type="number" required name="flun" value="'.$v_fluence.'"/></td>
                                    <td><input type="number" required name="pulse" value="'.$v_pulse.'"/></td>
                                    <td><input type="number" required name="rate" value="'.$v_rep_rate.'"/></td>
                                    <td><input type="number" required name="wave" value="'.$v_wave.'"/></td>	
                                    <td><input type="number" required name="counter" value="'.$counter.'"/></td>
                                    <td>'.$but.'</td>';
                                }else{
                                    echo '<td class="TC"><ff>'.$v_fluence.'</ff></td>
                                    <td class="TC"><ff>'.$v_pulse.'</ff></td>
                                    <td class="TC"><ff>'.$v_rep_rate.'</ff></td>
                                    <td class="TC"><ff>'.$v_wave.'</ff></td>	
                                    <td class="TC"><ff>'.$counter.'</ff></td>		
                                    <td class="TC"><ff>'.$but.'</ff></td>';
                                }
                                echo '</tr>';
                            }
                            echo '</table>
                            <div class="fr ic30 ic30_ref ic30Txt icc1 mg10v" onclick="loadLaserServ(1,0)">عودة</div>';
                            if($vis_status==1){
                                //echo '<div class="fl ic30 ic30_del ic30Txt icc2 mg10v" delPart>حذف هذا القسم</div>';
                            }
                        echo '</div>';
                    }
                }
            }
        }
            echo '<div class="f1 fs18 clr1 lh40">أختر جهاز الليزر:</div>';
            $sql="select * from bty_m_laser_device where act =1  ";
            $res=mysql_q($sql);            
            while($r=mysql_f($res)){
                /*echo '<div class="fl pd10f mg5f bord cbg1 clrw Over br5" fix="w:200" LDN="'.$r['id'].'">
                <div class="f1 fs14 uLine lh30 TC">'.$r['name'].' </div>
                <div class="ff B fs14 lh20" dir="ltr">Alex: '.number_format($r['count1']).' <br> NdYag:'.number_format($r['count2']).'</div>
                </div>';*/
                echo '<div class="fl bu bu_t1" fix="w:200" LDN="'.$r['id'].'">'.$r['name'].' 
                </div>';
            }
        
	}
}?>

	