<? include("../../__sys/prcds/ajax_header.php");
$rpr = 4;
if (isset($_POST['t'], $_POST['s'], $_POST['e'], $_POST['d'], $_POST['i'])) {
    $type = pp($_POST['t']);
    $start = pp($_POST['s'], 's');
    $end = pp($_POST['e'], 's');
    $today = pp($_POST['d'], 's');
    $item = pp($_POST['i'], 's');
    $newDay = pp($_POST['n']);
    $filter = pp($_POST['f']);
    $item_n = pp($_POST['it']);
    $c_item = pp($_POST['cit']);
    $all_item = pp($_POST['ait']);
    $notes = [];
    $first = 0;
    $time = 0;
    if ($today == 0) {
        $today = $start;
        $first = 1;
        $_SESSION['start_time'] = $now;
    } else {
        $time = $now - $_SESSION['start_time'];
    }
    /**************************/
    $stop = 0;
    $s = strtotime($start);
    $e = strtotime($end);
    $t = strtotime($today);
    $days = (($e - $s) / 86400) + 1;
    $done = (($t - $s) / 86400);
    if ($newDay && $first == 0) {
        $done++;
    }
    if ($item_n && $c_item) {
        $done += $c_item / $item_n;
    }
    $donePer = ($done * 100) / $days;

    $next_item = 0;
    if ($done >= $days) {
        $stop = 1;
    }

    if ($newDay && $first == 0) {
        $t += 86400;
        $today = date('Y-m-d', $t);
    }
    $next_item=0;
    $timeS=0;
    if($done){
        $next_item = $all_item * $days / $done;
    }
    $done = number_format($done, 2);
    if($all_item){
        $timeS = ($next_item * $time / $all_item) - $time;
    }
    $go_time = dateToTimeS2($time);
    $next_time = dateToTimeS2($timeS) . '<br><ff class="fs16 clr2">' . date('A h:i:s', $timeS + $now) . '</ff>';

    /********************************/
    $d_s = $t;
    $d_e = $t + 86400;
    $itemstext = [];
    $subdata = '';
    if ($stop == 0) {
        switch ($type) {
            case 1:
                $q = " date>='$d_s' and date < '$d_e' ";
                if ($filter) {
                    $q .= " and casher='$filter' ";
                }
                if ($item == 0) {
                    $itemsList=[];
                    $items = get_vals("gnr_x_acc_payments", "casher", " $q and type not in(9,11) and pay_type=1", ',', 1, "order by casher ASC");
                    if($items){
                        $itemsList = get_arr("_users", 'id', 'name_' . $lg, " id in($items) ");
                    }
                } else {
                    $subdata = 0;
                    list($note, $sub) = sync_boxes($d_s, $d_e, $item, 1);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata .= $sub;
                    list($note, $sub) = sync_boxes($d_s, $d_e, $item, 2);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata .= $sub;
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                break;
            case 2:
                $labClnId = get_val_c('gnr_m_clinics', 'id', 2, 'type');
                $q = " d_start>='$d_s' and d_start < '$d_e' ";
                if ($item == 0) {
                    $items = [];
                    $itemsList = [];
                    foreach ($visXTables as $mood => $table) {
                        if ($mood) {
                            if ($mood == 2) {
                                if ($filter == $labClnId || $filter == 0) {
                                    if (getTotalCo($table, $q)) {
                                        $items[] = $labClnId;
                                    }
                                }
                            } else {
                                if ($filter) {
                                    $items[0] = $filter;
                                } else {
                                    $qq = " status=2 ";
                                    if ($mood == 4) {
                                        $qq = " doctor!=0 ";
                                    }
                                    $sql = "select clinic from $table where $qq and $q  group by clinic  ";
                                    $res = mysql_q($sql);
                                    while ($r = mysql_f($res)) {
                                        $items[] = $r['clinic'];
                                    }
                                }
                            }
                        }
                    }
                    $items = implode(',', $items);
                    if($items){
                        $itemsList = get_arr("gnr_m_clinics", 'id', 'name_' . $lg, " id in($items) ", '1', " order by type ASC ");
                    }

                    
                } else {
                    $subdata = 0;
                    list($note, $subdata) = sync_clinics($d_s, $d_e, $item);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                break;
            case 3:
                $q = " d_start>='$d_s' and d_start < '$d_e' ";
                if ($item == 0) {
                    $items = [];
                    $itemsList = [];
                    foreach ($visXTables as $mood => $table) {
                        if ($mood && $mood !=2) {
                            if ($filter) {
                                $items[0] = $filter;
                            } else {
                                $qq = " status=2 ";
                                if ($mood == 4) {
                                    $qq = " doctor!=0 ";
                                }
                                $sql = "select doctor from $table where $qq and $q  group by doctor  ";
                                $res = mysql_q($sql);
                                while ($r = mysql_f($res)) {
                                    $items[] = $r['doctor'];
                                }
                            }
                        }
                    }
                    $items = implode(',', $items);
                    if($items){
                        $itemsList = get_arr("_users", 'id', 'name_' . $lg, " id in($items) ", '1', " order by name_$lg ASC ");
                    }
                } else {
                    $subdata = '';
                    list($note, $subdata) = sync_doctors($d_s, $d_e, $item);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                break;
            case 4:
                $itemsList=[];
                $q = " date>='$d_s' and date < '$d_e' ";
                if ($filter) {
                    $q .= " and charity='$filter' ";
                }
                if ($item == 0) {
                    $items = get_vals('gnr_x_charities_srv', "charity", " $q", ',', 1, "order by charity ASC");
                    if($items){
                        $itemsList = get_arr("gnr_m_charities", 'id', 'name_' . $lg, " id in($items) ");
                    }
                } else {
                    $subdata = 0;
                    list($note, $subdata) = sync_charity($d_s, $d_e, $item);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                break;
            case 5:
                $itemsList=[];
                $q = " s_date>='$d_s' and s_date < '$d_e' ";
                if ($filter) {
                    $q .= " and company='$filter' ";
                }
                if ($item == 0) {
                    $items = get_vals('gnr_x_insurance_rec', "company", " $q ", ',', 1, "order by company ASC");
                    if($items){
                        $itemsList = get_arr("gnr_m_insurance_prov", 'id', 'name_' . $lg, " id in($items) ");
                    }
                } else {
                    $subdata = 0;
                    list($note, $subdata) = sync_insurance($d_s, $d_e, $item);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                break;
            case 6:
                $items = [];
                $itemsList = [];
                $q = " d_start>='$d_s' and d_start < '$d_e' and status !=3 ";
                if ($filter) {
                    $moods = [$filter];
                } else {
                    $moods = [1, 3, 5, 6, 7];
                }
                if ($item == 0) {
                    foreach ($clinicTypes as $k => $v) {
                        //$n=0;
                        if (in_array($k, $moods)) {
                            //$visits=getTotalCo($visXTables[$k],$q);
                            $visits = get_vals($visXTables[$k], "id", " $q ", 'arr');
                            foreach ($visits as $visit) {
                                $items[] = $k . '-' . $visit;
                                $itemsList[] = $v . ' - ' . $visit;
                            }
                        }
                    }
                    $items = implode(',', $items);
                    //$items=get_vals('gnr_x_insurance_rec',"company"," $q ",',',1,"order by company ASC");
                    //$itemsList=get_arr("gnr_m_insurance_prov",'id','name_'.$lg," id in($items) ");
                } else {
                    $subdata = 0;
                    list($note, $subdata) = sync_visits($d_s, $d_e, $item);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                $item = $c_item;
                break;
            case 8:
                $itemsList=[];
                $q = " d_start>='$d_s' and d_start < '$d_e' ";
                $q2 = " date>='$d_s' and date < '$d_e' ";
                if ($filter) {
                    $q .= " and reg_user='$filter' ";
                    $q2 .= " and reg_user='$filter' ";
                }
                if ($item == 0) {
                    $rec = [];
                    foreach ($visXTables as $tab) {
                        if ($tab) {
                            $rec[] = get_vals($tab, "reg_user", " $q and status>0 ", ',');
                        }
                    }
                    $rec[] = get_vals("dts_x_dates", "reg_user", " $q2 and status>0 ", ',');
                    $rec2 = implode(',', $rec);
                    $rec2 = rtrim($rec2, ',');
                    $rec3 = explode(',', $rec2);
                    array_filter($rec3);
                    $rec4 = array_unique($rec3);
                    $items = implode(',', $rec4);
                    $items = str_replace(',,', ',', $items);
                    if (substr($items, 0, 1) == ',') {
                        $items = substr($items, 1);
                    }
                    $items = rtrim($items, ',');
                    if($items){                    
                        $itemsList = get_arr("_users", 'id', 'name_' . $lg, " id in($items) ");
                    }
                } else {
                    $subdata = 0;
                    list($note, $sub) = sync_rec($d_s, $d_e, $item, 1);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata += $sub;
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                break;
            case 10:
                $q = " d_start>='$d_s' and d_start < '$d_e' ";
                if ($item == 0) {
                    $items = [];
                    /*foreach($visXTables as $mood => $table){
                        if($mood){                            
                            if($filter){
                                $items[0]=$filter;
                            }else{
                                $qq=" status=2 ";
                                if($mood==4){$qq=" doctor!=0 ";}
                                $sql="select doctor from $table where $qq and $q  group by doctor  ";
                                $res=mysql_q($sql);
                                while($r=mysql_f($res)){
                                    $items[]=$r['doctor'];
                                }
                            }                            
                        }
                    }*/
                    $items = get_vals('_users', 'id', " grp_code in('nlh8spit9q','1ceddvqi3g') and act=1", 'arr', 1, " order by name_$lg ASC");

                    $items = implode(',', $items);
                    $itemsList = get_arr("_users", 'id', 'name_' . $lg, " id in($items) ", '1', " order by name_$lg ASC ");
                } else {
                    $subdata = 0;
                    list($note, $subdata) = sync_doctors_info($d_s, $d_e, $item);
                    if ($note) {
                        $notes[] = $note;
                    }
                    $subdata = ' <b>( ' . $subdata . ' ) </b>';
                }
                break;
        }
    }
    /********************************/
    if ($first == 0 && $stop == 0) {
        $all_item++;
    }
    $status = [
        's' => $start,
        'e' => $end,
        't' => $today,
        'days' => $days,
        'done' => $done,
        'donePer' => number_format($donePer, 3),
        'newDay' => $newDay,
        'all_item' => number_format($all_item),
        'next_item' => number_format($next_item),
        'go_time' => $go_time,
        'next_time' => $next_time,
        'subdata' => $subdata,
        'item' => $item,
        'stop' => $stop,
    ];

    $itemsTxt='';
    //$items=[$items];
    //$itemsArr=explode(',', $items)
    if(is_array($itemsList)){
        $itemsTxt=$items;
        if(!is_array($items)){
            $itemsTxt=explode(',', $items);
        }
    }
    $out = ['status' => $status, 'notes' => $notes, 'items' =>$itemsTxt, 'itemsList' => $itemsList];
    echo json_encode($out, JSON_UNESCAPED_UNICODE);
}
function sync_boxes($d_s, $d_e, $casher, $pay_type){ 
    global $lg;
    $table = 'gnr_r_cash';
    $table2 = 'gnr_x_acc_payments';
    $date_filed = 'date';
    $q = " date>='$d_s' and date < '$d_e' ";
    $notes = '';
    $subdata = '';
    if ($pay_type == 1 || ($pay_type == 2 && _set_l1acfcztzu)) {
        $cashTxt = '';
        $status = 0;
        $sql = "select type,amount,mood from gnr_x_acc_payments where $q and casher='$casher' and type not in(9,11) and pay_type=$pay_type ";
        $res = mysql_q($sql);
        $rows = mysql_n($res);
        $subdata = $rows;
        $a1_in = $a1_out = $a2_in = $a2_out = $a3_in = $a3_out = $a7_in = $a7_out = $a4_in = $a4_out = $a5_in = $a5_out = $a6_in = $a6_out = $card = $offer = 0;
        if ($rows > 0) {
            while ($r = mysql_f($res)) {
                $p_type = $r['type'];
                $amount = $r['amount'];
                $mood = $r['mood'];
                //echo '('.$mood.'|'.$casher.')';
                $t = 'in';
                if ($p_type == 3 || $p_type == 4 || $p_type == 8) {
                    $t = 'out';
                }
                if ($p_type == 5) {
                    $card += $amount;
                } else if ($p_type == 10) {
                    $offer += $amount;
                } else {
                    ${'a' . $mood . '_' . $t} += $amount;
                }
            }
            $amount_in = $a1_in + $a2_in + $a3_in + $a7_in + $a4_in + $a5_in + $a6_in + $card + $offer;
            $amount_out = $a1_out + $a2_out + $a3_out + $a7_out + $a4_out + $a5_out + $a6_out;
            if ($amount_in || $amount_out || $card || $offer) {
                $rec = getRecCon($table, " date='$d_s' and pay_type = '$pay_type' and casher='$casher' ");
                if ($rec['r']) {
                    $status = 3;
                    if (
                        $amount_in == $rec['amount_in'] &&
                        $amount_out == $rec['amount_out'] &&
                        $a1_in == $rec['a1_in'] &&
                        $a1_out == $rec['a1_out'] &&
                        $a2_in == $rec['a2_in'] &&
                        $a2_out == $rec['a2_out'] &&
                        $a3_in == $rec['a3_in'] &&
                        $a3_out == $rec['a3_out'] &&
                        $a7_in == $rec['a7_in'] &&
                        $a7_out == $rec['a7_out'] &&
                        $a4_in == $rec['a4_in'] &&
                        $a4_out == $rec['a4_out'] &&
                        $a5_in == $rec['a5_in'] &&
                        $a5_out == $rec['a5_out'] &&
                        $a6_in == $rec['a6_in'] &&
                        $a6_out == $rec['a6_out'] &&
                        $card == $rec['card']    &&
                        $offer == $rec['offer']
                    ) {
                    } else {
                        $sql = "UPDATE $table SET 
                        `card`='$card',`offer`='$offer',
                        `a1_in`='$a1_in',`a1_out`='$a1_out',
                        `a2_in`='$a2_in',`a2_out`='$a2_out',
                        `a3_in`='$a3_in',`a3_out`='$a3_out',
                        `a7_in`='$a7_in',`a7_out`='$a7_out',
                        `a4_in`='$a4_in',`a4_out`='$a4_out',
                        `a5_in`='$a5_in',`a5_out`='$a5_out',
                        `a6_in`='$a6_in',`a6_out`='$a6_out',
                        `amount_in`='$amount_in',`amount_out`='$amount_out'
                        where date ='$d_s' and pay_type = '$pay_type' and casher='$casher' ";
                        if (mysql_q($sql)) {
                            $notes = '<div class=" clr1 f1">غير مطابق</div>';
                        }
                    }
                } else {
                    $sql = "INSERT INTO $table (`date`,`casher`,`a1_in`,`a2_in`,`a3_in`,`a7_in`,`a4_in`,`a5_in`,`a6_in`,`a1_out`,`a2_out`,`a3_out`,`a7_out`,`a4_out`,`a5_out`,`a6_out`,`card`,`offer`,`amount_in`,`amount_out`,`pay_type`)values						('$d_s','$casher','$a1_in','$a2_in','$a3_in','$a7_in','$a4_in','$a5_in','$a6_in','$a1_out','$a2_out','$a3_out','$a7_out','$a4_out','$a5_out','$a6_out','$card','$offer','$amount_in','$amount_out','$pay_type')";
                    mysql_q($sql);
                }
            }
        } else {
            mysql_q("DELETE from $table where date ='$d_s' and  pay_type='$pay_type'  and casher='$casher'");
        }
    }

    return [$notes, $subdata];
}
function sync_clinics($d_s, $d_e, $clinc){
    global $lg, $visXTables, $srvXTables;
    $table = 'gnr_r_clinic';
    $table2 = 'gnr_x_acc_payments';
    $date_filed = 'd_start';

    $q = " date>='$d_s' and date < '$d_e' ";
    $q2 = " d_start>='$d_s' and d_start < '$d_e' ";

    $notes = '';
    $subdata = '';
    /****************/
    if($clinc){
        $visits = 0;
        $mood = get_val('gnr_m_clinics', 'type', $clinc);
        if ($mood == 2) {
            $visits = get_vals($visXTables[$mood], 'id', $q2);
        } else {
            $visits = get_vals($visXTables[$mood], 'id', $q2 . " and clinic='$clinc' ");
        }

        if ($visits) {
            $subdata = '';
            $sql = "select type,amount,mood,vis from gnr_x_acc_payments where vis in($visits) and mood='$mood' and type in(1,2,3,4,5,6,7,10)";
            $res = mysql_q($sql);
            $rows = mysql_n($res);
            if ($rows > 0) {
                while ($r = mysql_f($res)) {
                    $p_type = $r['type'];
                    $amount = $r['amount'];
                    $mood = $r['mood'];
                    $vis = $r['vis'];
                    ${'p' . $p_type} += $amount;
                }
            }
            $tableVis = $visXTables[$mood];
            $tableSrv = $srvXTables[$mood];
            if ($mood == 2) {
                $vis_free = 0;
                $dts = 0;
                $qVis = "$q2";
                $qSrv = "status not in(0,3) and $q2";
                $vis = getTotalCO($tableVis, "$qVis");
                $emplo = getTotalCO($tableVis, "$qVis and emplo=1 ");
                $pt0 = getTotalCO($tableVis, "$qVis and pay_type=0 ");
                $pt1 = getTotalCO($tableVis, "$qVis and pay_type=1 ");
                $pt2 = getTotalCO($tableVis, "$qVis and pay_type=2 ");
                $pt3 = getTotalCO($tableVis, "$qVis and pay_type=3 ");
                $new_pat = getTotalCO($tableVis, "$qVis and new_pat=1 ");

                $srv = getTotalCO($tableSrv, " $qSrv ");
                $total = get_sum($tableSrv, 'total_pay', "$qSrv");
                $pay_net = get_sum($tableSrv, 'pay_net', "$qSrv");
                $cost = 0;// get_sum($tableSrv, 'cost', "$qSrv");
                $pay_insur = get_sum($tableSrv, 'pay_net', "$qSrv and pay_type=3");
                $st0 = $srv;
                $st1 = 0;
                $st2 = 0;
                $subdata = $vis;
            } elseif ($mood == 6) {
                $vis_free = 0;
                $qVis = "status=2 and $q2 and clinic='$clinc' ";
                $qSrv = "status=5 and $q2 and clinic='$clinc' ";
                $vis = getTotalCO($tableVis, "$qVis");
                $emplo = getTotalCO($tableVis, "$qVis and emplo=1 ");
                $pt0 = getTotalCO($tableVis, "$qVis and pay_type=0 ");
                $pt1 = getTotalCO($tableVis, "$qVis and pay_type=1 ");
                $pt2 = getTotalCO($tableVis, "$qVis and pay_type=2 ");
                $pt3 = getTotalCO($tableVis, "$qVis and pay_type=3 ");
                $new_pat = getTotalCO($tableVis, "$qVis and new_pat=1 ");
                $dts = getTotalCO($tableVis, "$qVis and dts_id!=0 ");
                $srv = getTotalCO($tableSrv, " $qSrv ");
                $total = get_sum($tableVis, 'total_pay', "$qVis");
                $pay_net = $total;
                $cost = get_sum($tableSrv, 'cost', "$qSrv");
                $subdata = $vis;
            } else {
                $vis_free = 0;
                $qVis = "status=2 and $q2 and clinic='$clinc' ";
                $qSrv = "status=1 and $q2 and clinic='$clinc' ";
                $vis = getTotalCO($tableVis, "$qVis");
                $emplo = getTotalCO($tableVis, "$qVis and emplo=1 ");
                $pt0 = getTotalCO($tableVis, "$qVis and pay_type=0 ");
                $pt1 = getTotalCO($tableVis, "$qVis and pay_type=1 ");
                $pt2 = getTotalCO($tableVis, "$qVis and pay_type=2 ");
                $pt3 = getTotalCO($tableVis, "$qVis and pay_type=3 ");
                $new_pat = getTotalCO($tableVis, "$qVis and new_pat=1 ");
                if (in_array($mood, array(1, 3, 4, 5, 6, 7))) {
                    $dts = getTotalCO($tableVis, "$qVis and dts_id!=0 ");
                }

                $srv = getTotalCO($tableSrv, "$qSrv");
                $total = get_sum($tableSrv, 'total_pay', "$qSrv");
                $pay_net = get_sum($tableSrv, 'pay_net', "$qSrv");;
                $cost = get_sum($tableSrv, 'cost', "$qSrv");
                $st0 = $st1 = $st2 = 0; 
                if($mood==1){
                    $st0 = getTotalCO($tableSrv, "$qSrv and srv_type=0 ");
                    $st1 = getTotalCO($tableSrv, "$qSrv and srv_type=1 ");
                    $st2 = getTotalCO($tableSrv, "$qSrv and srv_type=2 ");
                }
                if ($mood == 1 || $mood == 3) {
                    $vis_free = getTotalCO($tableSrv, " $qSrv and total_pay=0 ");
                }
                $subdata = $vis;
            }
            //echo $table." date='$clinc' and clinic='$d_s' ";
            $rec = getRecCon($table, " date='$d_s' and clinic='$clinc' ");
            if ($vis) {
                if ($rec['r']) {
                    if (!$pay_net) {
                        $pay_net = 0;
                    }
                    if (!$pay_insur) {
                        $pay_insur = 0;
                    }
                    if (!$new_pat) {
                        $new_pat = 0;
                    }
                    if (!$vis) {
                        $vis = 0;
                    }
                    if (!$dts) {
                        $dts = 0;
                    }
                    if (!$vis_free) {
                        $vis_free = 0;
                    }
                    if (!$st0) {
                        $st0 = 0;
                    }
                    if (!$st1) {
                        $st1 = 0;
                    }
                    if (!$st2) {
                        $st2 = 0;
                    }
                    if (!$pt0) {
                        $pt0 = 0;
                    }
                    if (!$pt1) {
                        $pt1 = 0;
                    }
                    if (!$pt2) {
                        $pt2 = 0;
                    }
                    if (!$pt3) {
                        $pt3 = 0;
                    }
                    if (!$cost) {
                        $cost = 0;
                    }
                    if (!$emplo) {
                        $emplo = 0;
                    }
                    if (!$total) {
                        $total = 0;
                    }
                    $status = 3;
                    if (
                        $total == $rec['total'] &&
                        $cost == $rec['cost'] &&
                        $pay_insur == $rec['pay_insur'] &&
                        $mood == $rec['type'] &&
                        $pay_net == $rec['pay_net'] &&
                        $vis == $rec['vis'] &&
                        $srv == $rec['srv'] &&
                        $dts == $rec['dts'] &&
                        $new_pat == $rec['new_pat'] &&
                        $vis_free == $rec['vis_free'] &&
                        $st0 == $rec['st0'] &&
                        $st1 == $rec['st1'] &&
                        $st2 == $rec['st2'] &&
                        $pt0 == $rec['pt0'] &&
                        $pt1 == $rec['pt1'] &&
                        $pt2 == $rec['pt2'] &&
                        $pt3 == $rec['pt3'] &&
                        $emplo == $rec['emplo']
                    ) {
                    } else {
                        $sql = "UPDATE $table SET 							
                        srv='$srv',							
                        total='$total',
                        cost='$cost',
                        type='$mood',
                        pay_net='$pay_net',
                        pay_insur='$pay_insur',
                        vis='$vis' ,
                        dts='$dts' ,
                        new_pat='$new_pat',							
                        vis_free='$vis_free',
                        emplo='$emplo',
                        st0='$st0',
                        st1='$st1',
                        st2='$st2',
                        pt0='$pt0',
                        pt1='$pt1',
                        pt2='$pt2',						
                        pt3='$pt3'
                        where date ='$d_s' and clinic='$clinc' ";
                        if (mysql_q($sql)) {
                            $notes = '<div class=" clr1 f1">' . k_not_match . ' </div>';
                        }
                    }
                } else {
                    $status = 1;
                    $sql = "INSERT INTO $table (date,clinic,srv,total,cost,type,pay_net,pay_insur,vis,dts,
                        new_pat,st0,st1,st2,emplo,pt0,pt1,pt2,pt3) values('$d_s','$clinc' ,'$srv', '$total', '$cost', '$mood', '$pay_net', '$pay_insur','$vis' ,'$dts','$new_pat','$st0','$st1', '$st2','$emplo', '$pt0','$pt1','$pt2','$pt3' )";
                    mysql_q($sql);
                }
            } else {
                if ($rec['r']) {
                    mysql_q("DELETE from $table where date ='$d_s' and clinic='$clinc' ");
                }
            }
        }
    }
    return [$notes, $subdata];
}
function sync_doctors($d_s, $d_e, $doctor){
    global $lg, $visXTables, $srvXTables;
    $table = 'gnr_r_docs';
    $table2 = 'gnr_x_acc_payments';
    $date_filed = 'd_start';

    $q2 = " date>='$d_s' and date < '$d_e' ";
    $q = " d_start>='$d_s' and d_start < '$d_e' ";

    $mood = get_doc_mood($doctor);
    $tableVis = $visXTables[$mood];
    $tableSrv = $srvXTables[$mood];
    $notes = '';
    $subdata = '';
    /****************/
    if($doctor){
        $visits = 0;
        $qv = " and doctor='$doctor'";
        if ($mood == 2) {
            $qv = '';
        }
        if ($mood == 3) {
            $qv = " and (doctor='$doctor' or ray_tec='$doctor' ) ";
        }

        $visits = get_vals($tableVis, 'id', $q . " $qv ");
        $vis_free = $emplo = $pay_insur = $srv = $prv = $prv_d = $pro = $pro_d = $dis = $total = $hos_p = $doc_p = $pay_net = $cost = $st0 = $st1 = $st2 = 0;
        $vis = getTotalCO($tableVis, "status=2  and doctor='$doctor' and $q");
        $subdata = $vis;
        if ($vis) {
            if ($mood == 1) {
                $vis_free = getTotalCO($tableVis, "status=2 and doctor='$doctor' and id IN( select visit_id from $tableSrv where total_pay=0 )  and  $q");
            }
            if ($mood == 3) {
                $vis_free = getTotalCO($tableVis, "status=2 and ray_tec='$doctor' and id IN( select visit_id from $tableSrv where total_pay=0 )  and  $q");
            }

            if ($mood == 6) {
                $srv = getTotalCO($tableSrv, " d_start>='$d_s' and d_start < '$d_e' and visit_id in ($visits) ");
                $pt0 = $vis;
                $new_pat = getTotalCO($tableVis, "status=2 and doctor='$doctor' and new_pat='1' and $q ");
                $sql = "select * from bty_x_laser_visits  where status=2 and  doctor='$doctor' and d_start>='$d_s' and d_start < '$d_e' ";
                $res = mysql_q($sql);
                $rows = mysql_n($res);
                if ($rows > 0) {
                    while ($r = mysql_f($res)) {
                        $doc_part = $doc_percent = $doc_bal = $doc_dis = $cost = 0;
                        $v_id = $r['id'];
                        $doc = $r['doctor'];
                        $total_pay = $r['total_pay'];
                        $hos_dis = $r['dis'];

                        $hos_part = $total_pay;
                        $hos_bal = $total_pay;
                        $pay = $total_pay;
                        $prv += $hos_part;
                        $prv_d += $hos_dis;
                        $pro += $doc_part;
                        $pro_d += $doc_dis;
                        $dis += ($doc_dis + $hos_dis);
                        $total += ($hos_part + $doc_part);
                        $hos_p += $hos_bal;
                        $doc_p += $doc_bal;
                        $pay_net += $pay;
                        $cost += $cost;
                    }
                }
            } else {
                $new_pat = getTotalCO($tableVis, "status=2 and doctor='$doctor' and new_pat='1' and $q ");
                $emplo = getTotalCO($tableVis, "status=2 and doctor='$doctor' and emplo='1' and $q ");
                $pt0 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='0' and $q ");
                $pt1 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='1' and $q ");
                $pt2 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='2' and $q ");
                $pt3 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='3' and $q ");

                // $sql="select * from $tableSrv  where status=1 and  d_start>='$d_s' and d_start < '$d_e' and doc='$doctor' order by id ASC";
                if ($mood == 4) {
                    $sql = "select * from $tableSrv where status=1 and d_start>='$d_s' and d_start < '$d_e' and doc= $doctor order by id ASC";
                } else {
                    $sql = "select * from $tableSrv where status=1 and d_start>='$d_s' and d_start < '$d_e' and visit_id in ($visits) order by id ASC";
                }

                $res = mysql_q($sql);
                $rows = mysql_n($res);
                if ($rows > 0) {
                    while ($r = mysql_f($res)) {
                        $doc = $r['doc'];
                        //$vis=$r['visit_id'];
                        if ($doc) {
                            $hos_part = $r['hos_part'];
                            $doc_part = $r['doc_part'];
                            $doc_percent = $r['doc_percent'];
                            $pay = $r['pay_net'];
                            $doc_bal = $r['doc_bal'];
                            $doc_dis = $r['doc_dis'];
                            $hos_bal = $r['hos_bal'];
                            $hos_dis = $r['hos_dis'];
                            $cost = $r['cost'];
                            $total_pay = $r['total_pay'];
                            $srv_type = $r['srv_type'];
                            $pay_type = $r['pay_type'];
                            if ($pay_type == 3) {
                                $pay_insur += ($pay);
                            }
                            $srv++;
                            $prv += ($hos_part);
                            $prv_d += $hos_dis;
                            $pro += ($doc_part);
                            $pro_d += $doc_dis;
                            $dis += ($doc_dis + $hos_dis);
                            $total += ($hos_part + $doc_part);
                            $hos_p += $hos_bal;
                            $doc_p += $doc_bal;
                            $pay_net += $pay;
                            $cost += $cost;
                            ${'st' . $srv_type}++;
                        }
                    }
                }
                $doc_per=0;
                if($pro){
                    $doc_per = $doc_p * 100 / $pro;
                }
            }
            if ($srv) {
                $rec = getRecCon($table, " date='$d_s' and doc='$doctor' ");
                if ($rec['r']) {
                    $status = 3;
                    $x = '';
                    if ($hos_p != $rec['hos_p']) {
                        $x .= ' hos_p';
                    }
                    if ($doc_p != $rec['doc_p']) {
                        $x .= ' doc_p';
                    }
                    if ($cost != $rec['cost']) {
                        $x .= ' cost';
                    }
                    if ($pay_insur != $rec['pay_insur']) {
                        $x .= ' pay_insur';
                    }
                    if ($mood != $rec['clinic_type']) {
                        $x .= ' clinic_type';
                    }
                    if ($pay_net != $rec['pay_net']) {
                        $x .= ' pay_net (' . $pay_net . '=' . $rec['pay_net'] . ')';
                    }
                    if ($vis_free != $rec['vis_free']) {
                        $x .= ' vis_free';
                    }
                    if ($st0 != $rec['st0']) {
                        $x .= ' st0';
                    }
                    if ($st1 != $rec['st1']) {
                        $x .= ' st1';
                    }
                    if ($st2 != $rec['st2']) {
                        $x .= ' st2';
                    }
                    if ($vis != $rec['vis']) {
                        $x .= ' vis';
                    }
                    if ($new_pat != $rec['new_pat']) {
                        $x .= ' new_pat';
                    }
                    if ($pt0 != $rec['pt0']) {
                        $x .= ' pt0';
                    }
                    if ($emplo != $rec['emplo']) {
                        $x .= ' emplo';
                    }

                    if (
                        $hos_p == $rec['hos_p'] &&
                        $doc_p == $rec['doc_p'] &&
                        $cost == $rec['cost'] &&
                        $pay_insur == $rec['pay_insur'] &&
                        $mood == $rec['clinic_type'] &&
                        $pay_net == $rec['pay_net'] &&
                        $vis == $rec['vis'] &&
                        $new_pat == $rec['new_pat'] &&
                        //$vis_free==$rec['vis_free'] &&
                        $st0 == $rec['st0'] &&
                        $st1 == $rec['st1'] &&
                        $st2 == $rec['st2'] &&
                        $pt0 == $rec['pt0'] &&
                        $emplo == $rec['emplo']
                    ) {
                        $status = 2;
                    } else {
                        $sql = "UPDATE $table SET date='$d_s',
                        doc='$doctor',
                        srv='$srv',
                        prv='$prv',
                        prv_d='$prv_d',
                        opr='$pro',
                        por_d='$por_d',
                        dis='$dis',
                        total='$total',
                        hos_p='$hos_p',
                        doc_p='$doc_p',
                        doc_per='$doc_per',
                        cost='$cost',
                        clinic_type='$mood',
                        pay_net='$pay_net',
                        pay_insur='$pay_insur',
                        vis='$vis' ,
                        new_pat='$new_pat',							
                        vis_free='$vis_free',
                        emplo='$emplo',
                        st0='$st0',
                        st1='$st1',
                        st2='$st2',
                        pt0='$pt0',
                        pt1='$pt1',
                        pt2='$pt2',						
                        pt3='$pt3'
                        where date ='$d_s' and doc='$doctor' ";
                        if (mysql_q($sql)) {
                            $notes = '<div class=" clr1 f1">' . k_not_match . '(' . $x . ')</div>';
                        }
                    }
                } else {
                    $status = 1;
                    $sql = "INSERT INTO $table (date,doc,srv,prv,prv_d,opr,por_d,dis,total,hos_p,doc_p,doc_per,cost,clinic_type,pay_net,pay_insur,vis,
                        new_pat,st0,st1,st2,emplo,pt0,pt1,pt2,pt3)						values('$d_s','$doctor','$srv','$prv','$prv_d','$pro','$por_d','$dis','$total','$hos_p','$doc_p','$doc_per','$cost','$mood','$pay_net','$pay_insur','$vis','$new_pat','$st0','$st1','$st2','$emplo','$pt0','$pt1','$pt2','$pt3' )";
                    mysql_q($sql);
                }
            } else {
                mysql_q("DELETE from $table where date ='$d_s' and doc='$doctor' ");
            }
        } else {
            mysql_q("DELETE from $table where date ='$d_s' and doc='$doctor' ");
        }
    }
    return [$notes, $subdata];
}
function sync_doctors_info($d_s, $d_e, $doctor){
    global $lg, $visXTables, $srvXTables, $srvTables;
    $table = 'gnr_r_docs_details';
    $table2 = 'gnr_x_acc_payments';
    $date_filed = 'd_start';
    $q2 = " date>='$d_s' and date < '$d_e' ";
    $q = " d_start>='$d_s' and d_start < '$d_e' ";

    $mood = get_doc_mood($doctor);
    $tableVis = $visXTables[$mood];
    $tableSrv = $srvXTables[$mood];
    $tableMSrv = $srvTables[$mood];
    $notes = '';
    $subdata = '';
    /***************/
    $visits = 0;
    $estimat = getDocTimeDay($doctor, date('w', $d_s));
    list($clinic, $grp) = get_val('_users', 'subgrp,grp_code', $doctor);
    $qv = " and doctor='$doctor'";
    if ($mood == 2) {
        $qv = '';
    }
    if ($mood == 3) {
        $qv = " and ( doctor='$doctor' or ray_tec='$doctor' ) ";
    }

    $visits = get_vals($tableVis, 'id', " $q $qv ");
    $vis_free = $emplo = $pay_insur = $srv = $prv = $prv_d = $pro = $pro_d = $dis = $total = $hos_p = $doc_p = $pay_net = $cost = $st0 = $st1 = $st2 = $serviceTime = $v_cash = 0;
    $vis = getTotalCO($tableVis, "status=2  and doctor='$doctor' and $q ");
    $subdata = $vis;
    if ($vis) {
        /*if($mood==1){
            $vis_free=getTotalCO($tableVis,"status=2 and doctor='$doctor' and id IN( select visit_id from $tableSrv where total_pay=0 )  and  $q");
        }
        if($mood==3){*/
        $vis_free = getTotalCO($tableVis, "status=2 and $qv and id IN( select visit_id from $tableSrv where total_pay=0 )  and  $q");
        //}
        $v_cash = $vis - $vis_free;
        if ($mood == 6) {
            $srv = getTotalCO($tableSrv, " d_start>='$d_s' and d_start < '$d_e' and visit_id in ($visits) ");
            $pt0 = $vis;
            $new_pat = getTotalCO($tableVis, "status=2 and doctor='$doctor' and new_pat='1' and $q ");
            $sql = "select * from bty_x_laser_visits  where status=2 and  doctor='$doctor' and d_start>='$d_s' and d_start < '$d_e' ";
            $res = mysql_q($sql);
            $rows = mysql_n($res);
            if ($rows > 0) {
                while ($r = mysql_f($res)) {
                    $doc_part = $doc_percent = $doc_bal = $doc_dis = $cost = 0;
                    $v_id = $r['id'];
                    $doc = $r['doctor'];
                    $total_pay = $r['total_pay'];
                    $hos_dis = $r['dis'];

                    $hos_part = $total_pay;
                    $hos_bal = $total_pay;
                    $pay = $total_pay;
                    $prv += $hos_part;
                    $prv_d += $hos_dis;
                    $pro += $doc_part;
                    $pro_d += $doc_dis;
                    $dis += ($doc_dis + $hos_dis);
                    $total += ($hos_part + $doc_part);
                    $hos_p += $hos_bal;
                    $doc_p += $doc_bal;
                    $pay_net += $pay;
                    $cost += $cost;
                }
            }
        } else {
            $new_pat = getTotalCO($tableVis, "status=2 and doctor='$doctor' and new_pat='1' and $q ");
            $emplo = getTotalCO($tableVis, "status=2 and doctor='$doctor' and emplo='1' and $q ");
            $pt0 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='0' and $q ");
            $pt1 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='1' and $q ");
            $pt2 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='2' and $q ");
            $pt3 = getTotalCO($tableVis, "status=2 and doctor='$doctor' and pay_type='3' and $q ");

            if ($mood == 4) {
                $sql = "select * from $tableSrv where status=1 and d_start>='$d_s' and d_start < '$d_e' and doc= $doctor order by id ASC";
            } else {
                $sql = "select * from $tableSrv where status=1 and d_start>='$d_s' and d_start < '$d_e' and visit_id in ($visits) order by id ASC";
            }

            $res = mysql_q($sql);
            $rows = mysql_n($res);
            if ($rows > 0) {
                $srvTimes = get_arr($tableMSrv, 'id', 'ser_time', "1=1");
                while ($r = mysql_f($res)) {
                    /*********/
                    $service = $r['service'];
                    $serviceTime += $srvTimes[$service] * _set_pn68gsh6dj;
                    $total += $r['total_pay'];
                    $srv_type = $r['srv_type'];
                    $srv++;
                    ${'st' . $srv_type}++;
                    /*********/
                    $hos_part = $r['hos_part'];
                    $doc_part = $r['doc_part'];
                    $doc_percent = $r['doc_percent'];
                    /*$pay=$r['pay_net'];
                    $doc_bal=$r['doc_bal'];
                    $doc_dis=$r['doc_dis'];
                    $hos_bal=$r['hos_bal'];
                    $hos_dis=$r['hos_dis'];
                    $cost=$r['cost'];
                    $pay_type=$r['pay_type'];
                    if($pay_type==3){$pay_insur+=($pay);}*/

                    //$prv+=($hos_part);
                    //$prv_d+=$hos_dis;
                    //$pro+=($doc_part);
                    //$pro_d+=$doc_dis;
                    //$dis+=($doc_dis+$hos_dis);
                    //$total+=$total_pay;
                    //$hos_p+=$hos_bal;
                    //$doc_p+=$doc_bal;
                    //$pay_net+=$pay;
                    //$cost+=$cost;
                }
            }
            $doc_per = $doc_p * 100 / $pro;
        }
    }
    if ($total || $estimat) {
        /*************/
        $rec = getRecCon($table, " date='$d_s' and doc='$doctor' ");
        if ($rec['r']) {
            if (
                $total != $rec['s_total']
            ) {
                $x = '';
                /*if($pay_net!=$rec['pay_net']){$x.= ' pay_net ('.$pay_net.'='.$rec['pay_net'].')';}						
                if($vis_free!=$rec['vis_free']){$x.= ' vis_free';}                
                if($st0!=$rec['st0']){$x.= ' st0';}
                if($st1!=$rec['st1']){$x.= ' st1';}
                if($st2!=$rec['st2']){$x.= ' st2';}
                if($vis!=$rec['vis']){$x.= ' vis';}
                if($new_pat!=$rec['new_pat']){$x.= ' new_pat';}
                if($pt0!=$rec['pt0']){$x.= ' pt0';}
                if($emplo!=$rec['emplo']){$x.= ' emplo';}*/

                $sql = "UPDATE $table SET 
                estimated='$estimat',
                v_total='$vis',
                v_normal='$pt0',
                v_exemption='$pt1',
                v_charity='$pt2',
                v_insurance='$pt3',
                v_cash='$v_cash',
                v_free='$vis_free',
                v_employee='$emplo',
                v_new_pat='$new_pat',
                s_total='$srv',
                s_preview='$st0',
                s_procedure='$st1',
                s_review='$st2',
                s_total_time='$serviceTime',
                total_revenue='$total'
                where date ='$d_s' and doc='$doctor' ";
                if (mysql_q($sql)) {
                    $notes = '<div class=" clr1 f1">غير مطابق (' . $x . ')</div>';
                }
            }
        } else {
            $sql = "INSERT INTO $table (date,doc,doc_type,estimated,v_total,v_normal,v_exemption,v_charity,v_insurance,v_cash,v_free,v_employee,v_new_pat,s_total,s_preview,s_procedure,s_review,s_total_time,total_revenue,grp,clinic)						values('$d_s','$doctor','$mood','$estimat','$vis','$pt0','$pt1','$pt2','$pt3','$v_cash','$vis_free','$emplo','$new_pat','$srv','$st0','$st1','$st2','$serviceTime','$total','$grp','$clinic')";
            mysql_q($sql);
        }
    } else {
        //if($rec['r']){mysql_q("DELETE from $table where date ='$d_s' and doc='$doctor' ");}
    }

    return [$notes, $subdata];
    /******************************************/

    // CLN
    $sql = "select * from cln_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
    $res = mysql_q($sql);
    $rows = mysql_n($res);
    if ($rows > 0) {
        while ($r = mysql_f($res)) {
            $doc = $r['doc'];
            $vis = $r['visit_id'];
            if ($doc) {
                $service = $r['service'];
                $serviceTime = get_val('cln_m_services', 'ser_time', $service) * _set_pn68gsh6dj;
                $total_pay = $r['total_pay'];
                $srv_type = $r['srv_type'];
                $doc_data[$doc]['srv']++;
                $doc_data[$doc]['total'] += $total_pay;
                $doc_data[$doc]['srvTime'] += $serviceTime;
                $doc_data[$doc]['st' . $srv_type]++;
            }
        }
    }
    // XRY
    $sql = "select * from xry_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
    $res = mysql_q($sql);
    $rows = mysql_n($res);
    if ($rows > 0) {
        while ($r = mysql_f($res)) {
            $doc = $r['doc'];
            $vis = $r['visit_id'];
            $doc = get_val('xry_x_visits', 'ray_tec', $vis);
            if ($doc) {
                $service = $r['service'];
                $serviceTime = get_val('cln_m_services', 'ser_time', $service) * _set_pn68gsh6dj;
                $total_pay = $r['total_pay'];
                $srv_type = $r['srv_type'];
                $doc_data[$doc]['srv']++;
                $doc_data[$doc]['total'] += $total_pay;
                $doc_data[$doc]['srvTime'] += $serviceTime;
                $doc_data[$doc]['st' . $srv_type]++;
            }
        }
    }
    // DEN
    $sql = "select * from den_x_visits_services  where status=1 and  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
    $res = mysql_q($sql);
    $rows = mysql_n($res);
    if ($rows > 0) {
        while ($r = mysql_f($res)) {
            $doc = $r['doc'];
            $vis = $r['visit_id'];
            if ($doc) {
                $service = $r['service'];
                $serviceTime = get_val('den_m_services', 'ser_time', $service) * _set_pn68gsh6dj;

                $total_pay = $r['total_pay'];
                $srv_type = $r['srv_type'];

                $doc_data[$doc]['srv']++;
                $doc_data[$doc]['total'] += $total_pay;
                $doc_data[$doc]['srvTime'] += $serviceTime;
                $doc_data[$doc]['st' . $srv_type]++;
            }
        }
    }
    // BTY
    $sql = "select * from bty_x_visits_services  where status=1 and  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
    $res = mysql_q($sql);
    $rows = mysql_n($res);
    if ($rows > 0) {
        while ($r = mysql_f($res)) {
            $doc = $r['doc'];
            $vis = $r['visit_id'];
            if ($doc) {
                $service = $r['service'];
                $serviceTime = get_val('bty_m_services', 'ser_time', $service) * _set_pn68gsh6dj;

                $total_pay = $r['total_pay'];
                $srv_type = $r['srv_type'];

                $doc_data[$doc]['srv']++;
                $doc_data[$doc]['total'] += $total_pay;
                $doc_data[$doc]['srvTime'] += $serviceTime;
                $doc_data[$doc]['st' . $srv_type]++;
            }
        }
    }
    // LSR
    $sql = "select * from bty_x_laser_visits  where status=2 and  doctor!=0 and d_start>='$d_s' and d_start < '$d_e' ";
    $res = mysql_q($sql);
    $rows = mysql_n($res);
    if ($rows > 0) {
        while ($r = mysql_f($res)) {
            $v_id = $r['id'];
            $doc = $r['doctor'];

            $serviceTime = get_sum('bty_m_services', 'ser_time', " id IN ( select service from bty_x_laser_visits_services where visit_id='$v_id')") * _set_pn68gsh6dj;
            $srvTotalCo = getTotal('bty_x_laser_visits_services', " visit_id='$v_id')");

            $total_pay = $r['total_pay'];
            $hos_dis = $r['dis'];

            $hos_part = $total_pay;
            $hos_bal = $total_pay;
            $pay_net = $total_pay;

            $doc_data[$doc]['srv'] += $srvTotal;
            $doc_data[$doc]['total'] += $total_pay;
            $doc_data[$doc]['srvTime'] += $serviceTime;
            $doc_data[$doc]['st0']++;
        }
    }
    // OSC
    $sql = "select * from osc_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
    $res = mysql_q($sql);
    $rows = mysql_n($res);
    if ($rows > 0) {
        while ($r = mysql_f($res)) {
            $doc = $r['doc'];
            $vis = $r['visit_id'];
            if ($doc) {
                $service = $r['service'];
                $serviceTime = get_val('osc_m_services', 'ser_time', $service) * _set_pn68gsh6dj;
                $total_pay = $r['total_pay'];
                $srv_type = $r['srv_type'];
                $doc_data[$doc]['srv']++;
                $doc_data[$doc]['total'] += $total_pay;
                $doc_data[$doc]['srvTime'] += $serviceTime;
                $doc_data[$doc]['st' . $srv_type]++;
            }
        }
    }
    /******************************/
    foreach ($doc_data as $k => $d) {
        $d_id = $k;
        $doc_type = $docClnicType[$k];
        $estimat = $d['estimat'];
        $v_total = $d['vis'];
        $d_grp = $d['grp'];
        $d_clinic = $d['clinic'];
        $v_cash = $d['v_cash'];
        $v_free = $d['v_free'];
        $v_employee = $d['v_employee'];
        $v_new_pat = $d['v_new_pat'];
        $s_total = $d['srv'];
        $s_total_time = $d['srvTime'];
        $total_revenue = $d['total'];
        $st0 = $d['st0'];
        $st1 = $d['st1'];
        $st2 = $d['st2'];
        $pt0 = $d['pt0'];
        $pt1 = $d['pt1'];
        $pt2 = $d['pt2'];
        $pt3 = $d['pt3'];
        $rec = getRecCon($table, " date='$d_s' and doc='$d_id' ");

        if ($s_total || $estimat) {
            if (!$v_employee) {
                $v_employee = 0;
            }
            if (!$v_new_pat) {
                $v_new_pat = 0;
            }
            if (!$estimat) {
                $estimat = 0;
            }
            if (!$v_cash) {
                $v_cash = 0;
            }
            if (!$v_free) {
                $v_free = 0;
            }
            if (!$v_total) {
                $v_total = 0;
            }
            if (!$s_total) {
                $s_total = 0;
            }
            if (!$s_total_time) {
                $s_total_time = 0;
            }
            if (!$total_revenue) {
                $total_revenue = 0;
            }
            if (!$st0) {
                $st0 = 0;
            }
            if (!$st1) {
                $st1 = 0;
            }
            if (!$st2) {
                $st2 = 0;
            }
            if (!$pt0) {
                $pt0 = 0;
            }
            if (!$pt1) {
                $pt1 = 0;
            }
            if (!$pt2) {
                $pt2 = 0;
            }
            if (!$pt3) {
                $pt3 = 0;
            }
            if ($rec['r']) {
                if (
                    $doc_type != $rec['doc_type'] ||
                    $v_total != $rec['v_total'] ||
                    $v_new_pat != $rec['v_new_pat'] ||
                    $v_free != $rec['v_free'] ||
                    $v_cash != $rec['v_cash'] ||
                    $estimat != $rec['estimated'] ||
                    $s_total != $rec['s_total']
                ) {
                    $sql = "UPDATE $table SET 
					estimated='$estimat',
					v_total='$v_total',
					v_normal='$pt0',
					v_exemption='$pt1',
					v_charity='$pt2',
					v_insurance='$pt3',
					v_cash='$v_cash',
					v_free='$v_free',
					v_employee='$v_employee',
					v_new_pat='$v_new_pat',
					s_total='$s_total',
					s_preview='$st0',
					s_procedure='$st1',
					s_review='$st2',
					s_total_time='$s_total_time',
					total_revenue='$total_revenue'
					where date ='$d_s' and doc='$d_id' ";
                    mysql_q($sql);
                }
            } else {
                $sql = "INSERT INTO $table (date,doc,doc_type,estimated,v_total,v_normal,v_exemption,v_charity,v_insurance,v_cash,v_free,v_employee,v_new_pat,s_total,s_preview,s_procedure,s_review,s_total_time,total_revenue,grp,clinic)						values('$d_s','$d_id','$doc_type','$estimat','$v_total','$pt0','$pt1','$pt2','$pt3','$v_cash','$v_free','$v_employee','$v_new_pat','$s_total','$st0','$st1','$st2','$s_total_time','$total_revenue','$d_grp','$d_clinic')";
                mysql_q($sql);
            }
        } else {
            if ($rec['r']) {
                mysql_q("DELETE from $table where date ='$d_s' and doc='$d_id' ");
            }
        }
    }
    mysql_q("DELETE from gnr_x_temp_oprs where date < '$d_s' ");
    foreach ($visXTables as $k => $table) {
        if ($k) {
            $tableSrv = $srvXTables[$k];
            $vis = get_vals($table, 'id', " status=0 and d_start < '$d_e'");
            if ($vis) {
                mysql_q("delete from $table where id in($vis)");
                mysql_q("delete from $tableSrv where visit_id in($vis)");
            }
        }
    }
}

function get_doc_mood($doc){
    $mood = 0;
    $grp = get_val('_users', 'grp_code', $doc);
    $moods = [
        '7htoys03le' => 1,
        'nlh8spit9q' => 3,
        '1ceddvqi3g' => 3,
        'fk590v9lvl' => 4,
        '9yjlzayzp' => 5,
        '66hd2fomwt' => 6,
        '9k0a1zy2ww' => 7,
    ];
    if (isset($moods[$grp])) {
        $mood = $moods[$grp];
    }
    return $mood;
}
function sync_charity($d_s, $d_e, $char){
    $table = 'gnr_r_charities';
    $table2 = 'gnr_x_charities_srv';
    $q = " date>='$d_s' and date<'$d_e' and charity='$char' ";
    $srvs = getTotalCO($table2, $q);
    $price = get_sum($table2, 'srv_price', $q);
    $covered = get_sum($table2, 'srv_covered', $q);
    $notes=[];
    if($char){
        $rec = getRecCon($table, " date='$d_s' and charity='$char' ");
        if ($srvs) {
            if ($rec['r']) {
                if (
                    $srvs == $rec['srvs'] &&
                    $price == $rec['price'] &&
                    $covered == $rec['covered']
                ) {
                } else {
                    $x = '';
                    if ($srvs != $rec['srvs']) {
                        $x .= '<br> ' . k_srvcs_num . '  (' . $srvs . '-' . $rec['srvs'] . ')';
                    }
                    if ($price != $rec['price']) {
                        $x .= '<br> ' . k_srvcs_prices . '  (' . $price . '-' . $rec['price'] . ')';
                    }
                    if ($covered != $rec['covered']) {
                        $x .= '<br> ' . k_includ . ' (' . $covered . '-' . $rec['covered'] . ')';
                    }

                    $sql = "UPDATE $table SET srvs='$srvs' , price='$price' , covered='$covered' 
                    where date ='$d_s' and charity='$char' ";
                    if (mysql_q($sql)) {
                        $notes = '<div class=" clr1 f1"> ' . k_not_match . $x . '</div>';
                    }
                }
            } else {
                mysql_q("INSERT INTO $table (date,charity,srvs,price,covered)	values('$d_s','$char','$srvs','$price','$covered')");
            }
        } else {
            if ($rec['r']) {
                mysql_q("DELETE from $table where date ='$d_s' and charity='$char' ");
            }
        }
    }
    return [$notes, $srvs];
}
function sync_insurance($d_s, $d_e, $company){
    $table = 'gnr_r_insurance';
    $table2 = 'gnr_x_insurance_rec';
    $notes=[];
    $rows=0;
    if($company){
        $apps = $price_srv = $price_in = $price_in_in = $not_caver = $accepted = $reject = 0;

        $sql = "select * from $table2  where s_date>='$d_s' and s_date < '$d_e' and status =1 and company='$company'";
        $res = mysql_q($sql);
        $rows = mysql_n($res);
        if ($rows > 0) {
            while ($r = mysql_f($res)) {
                $price = $r['price'];
                $in_price = $r['in_price'];
                $in_price_includ = $r['in_price_includ'];
                $res_status = $r['res_status'];
                $apps++;
                $price_srv += $price;
                $price_in += $in_price;
                $price_in_in += $in_price_includ;
                if ($res_status == 1) {
                    $not_caver += $in_price - $in_price_includ;
                    $accepted++;
                }
                if ($res_status == 2) {
                    $reject++;
                }
            }
        }

        $rec = getRecCon($table, " date='$d_s' and company='$company' ");
        if ($price_in_in) {
            if ($rec['r']) {
                if (
                    $rec['apps'] == $apps &&
                    $rec['price_srv'] == $price_srv &&
                    $rec['price_in'] == $price_in &&
                    $rec['price_in_in'] == $price_in_in &&
                    $rec['not_caver'] == $not_caver &&
                    $rec['accepted'] == $accepted &&
                    $rec['reject'] == $reject
                ) {
                } else {
                    $x = '';
                    if ($apps != $rec['apps']) {
                        $x .= '<br>  ' . k_srvcs_num . ' (' . $apps . '-' . $rec['apps'] . ')';
                    }
                    if ($price_srv != $rec['price_srv']) {
                        $x .= '<br> ' . k_srvcs_prices . '(' . $price_srv . '-' . $rec['price_srv'] . ')';
                    }
                    if ($price_in != $rec['price_in']) {
                        $x .= '<br>  ' . k_ins_price . ' (' . $price_in . '-' . $rec['price_in'] . ')';
                    }
                    if ($price_in_in != $rec['price_in_in']) {
                        $x .= '<br> ' . k_includ . ' (' . $price_in_in . '-' . $rec['price_in_in'] . ')';
                    }
                    if ($not_caver != $rec['not_caver']) {
                        $x .= '<br> ' . k_not_included . '  (' . $not_caver . '-' . $rec['not_caver'] . ')';
                    }
                    if ($accepted != $rec['accepted']) {
                        $x .= '<br> ' . k_acpt . ' (' . $accepted . '-' . $rec['accepted'] . ')';
                    }
                    if ($reject != $rec['reject']) {
                        $x .= '<br> ' . k_rjct . ' (' . $reject . '-' . $rec['reject'] . ')';
                    }

                    $sql = "UPDATE $table SET 
                    apps='$apps' ,	price_srv='$price_srv' , price_in='$price_in' ,	price_in_in='$price_in_in' ,
                    not_caver='$not_caver' , accepted='$accepted' , reject='$reject' 
                    where date ='$d_s' and company='$company' ";
                    if (mysql_q($sql)) {
                        $notes = '<div class=" clr1 f1">  ' . k_not_match . $x . '</div>';
                    }
                }
            } else {
                mysql_q("INSERT INTO $table (date, company,apps,price_srv, price_in, price_in_in, not_caver, accepted, reject  )	
                values('$d_s','$company','$apps','$price_srv','$price_in', '$price_in_in', '$not_caver', '$accepted', '$reject' )");
            }
        } else {
            if ($rec['r']) {
                mysql_q("DELETE from $table where date ='$d_s' and company='$company' ");
            }
        }
    }
    return [$notes, $rows];
}
function sync_rec($d_s, $d_e, $resp){
    global $visXTables;
    $table = 'gnr_r_recepion';
    //$table2='gnr_x_insurance_rec';
    $vis_total = $vis_def = $vis_cash = $vis_cancel = $vis_act = $bal = $dts_cancel = $dts_act = $dts_ok = $dts_do = $dts_delay = $dts_do_not = 0;
    foreach ($visXTables as $tab) {
        if ($tab) {
            $sql = "select * from $tab  where reg_user='$resp' and d_start>='$d_s' and d_start < '$d_e' and status>0 ";
            $res = mysql_q($sql);
            while ($r = mysql_f($res)) {
                $reg_user = $r['reg_user'];
                $t = $r['pay_type'];
                $stat = $r['status'];
                $vis_total++;
                if ($t) {
                    $vis_def++;
                } else {
                    $vis_cash++;
                }
                if ($stat == 3) {
                    $vis_cancel++;
                } else {
                    $vis_act++;
                    $bal++;
                }
            }
        }
    }
    $sql = "select * from dts_x_dates where reg_user='$resp' and date>='$d_s' and date < '$d_e' and status>0 ";
    $res = mysql_q($sql);
    $dts_total = mysql_n($res);
    while ($r = mysql_f($res)) {
        $stat = $r['status'];
        if (in_array($stat, array(5, 7))) {
            $dts_cancel++;
        } else {
            $dts_act++;
            $bal++;
        }
        if (in_array($stat, array(2, 3, 4))) {
            $dts_ok++;
            $dts_do++;
        }
        if (in_array($stat, array(8))) {
            $dts_delay++;
            $dts_do++;
        }
        if (in_array($stat, array(6))) {
            $dts_do_not++;
        }
    }
    $rows = $bal;

    $rec = getRecCon($table, " date='$d_s' and rec='$resp' ");
    if ($vis_total || $dts_total) {
        if ($rec['r']) {
            if (
                $vis_cash == $rec['vis_cash'] &&
                $vis_def == $rec['vis_def'] &&
                $vis_cancel == $rec['vis_cancel'] &&
                $vis_total == $rec['vis_total'] &&
                $vis_act == $rec['vis_act'] &&
                $dts_total == $rec['dts_total'] &&
                $dts_cancel == $rec['dts_cancel'] &&
                $dts_act == $rec['dts_act'] &&
                $dts_ok == $rec['dts_ok'] &&
                $dts_delay == $rec['dts_delay'] &&
                $dts_do == $rec['dts_do'] &&
                $dts_do_not == $rec['dts_do_not'] &&
                $bal == $rec['bal']
            ) {
            } else {
                $x = '';
                if ($vis_cash != $rec['vis_cash']) {
                    $x .= '<br> ' . k_cash_visits . '   (' . $vis_cash . '-' . $rec['vis_cash'] . ')';
                }
                if ($vis_def != $rec['vis_def']) {
                    $x .= '<br>  ' . k_non_cash_visits . '(' . $vis_def . '-' . $rec['vis_def'] . ')';
                }
                if ($vis_cancel != $rec['vis_cancel']) {
                    $x .= '<br>   ' . k_canceled_visits . ' (' . $vis_cancel . '-' . $rec['vis_cancel'] . ')';
                }
                if ($vis_total != $rec['vis_total']) {
                    $x .= '<br>  ' . k_visits_total . ' (' . $vis_total . '-' . $rec['vis_total'] . ')';
                }
                if ($vis_act != $rec['vis_act']) {
                    $x .= '<br>  ' . k_actual_visits . '  (' . $vis_act . '-' . $rec['vis_act'] . ')';
                }
                if ($dts_total != $rec['dts_total']) {
                    $x .= '<br> ' . k_total_appo . '  (' . $dts_total . '-' . $rec['dts_total'] . ')';
                }
                if ($dts_cancel != $rec['dts_cancel']) {
                    $x .= '<br> ' . k_canceled_appo . '  (' . $dts_cancel . '-' . $rec['dts_cancel'] . ')';
                }
                if ($dts_act != $rec['dts_act']) {
                    $x .= '<br>  ' . k_actual_appo . ' (' . $dts_act . '-' . $rec['dts_act'] . ')';
                }
                if ($dts_ok != $rec['dts_ok']) {
                    $x .= '<br> ' . k_completed_appo . '  (' . $dts_ok . '-' . $rec['dts_ok'] . ')';
                }
                if ($dts_delay != $rec['dts_delay']) {
                    $x .= '<br> ' . k_late_attendance_appo . '   (' . $dts_delay . '-' . $rec['dts_delay'] . ')';
                }
                if ($dts_do != $rec['dts_do']) {
                    $x .= '<br>  ' . k_appo_visits . '  (' . $dts_do . '-' . $rec['dts_do'] . ')';
                }
                if ($dts_do_not != $rec['dts_do_not']) {
                    $x .= '<br>  ' . k_not_attend . ' (' . $dts_do_not . '-' . $rec['dts_do_not'] . ')';
                }
                if ($bal != $rec['bal']) {
                    $x .= '<br>  ' . k_all_operations . ' (' . $bal . '-' . $rec['bal'] . ')';
                }

                $sql = "UPDATE $table SET                 
                `vis_cash`='$vis_cash',
                `vis_def`='$vis_def',
                `vis_cancel`='$vis_cancel',
                `vis_total`='$vis_total',
                `vis_act`='$vis_act',
                `dts_total`='$dts_total',
                `dts_cancel`='$dts_cancel',
                `dts_act`='$dts_act',
                `dts_ok`='$dts_ok',
                `dts_delay`='$dts_delay',
                `dts_do`='$dts_do',
                `dts_do_not`='$dts_do_not',
                `bal`='$bal'
                where `date` ='$d_s' and `rec`='$resp' ";
                if (mysql_q($sql)) {
                    $notes = '<div class=" clr1 f1">' . k_not_match . $x . '</div>';
                }
            }
        } else {
            mysql_q("INSERT INTO $table (`date`,`rec`,`vis_cash`,`vis_def`,`vis_cancel`,`vis_total`,`vis_act`,`dts_total`,`dts_cancel`,`dts_act`,`dts_ok`,`dts_delay`,`dts_do`,`dts_do_not`,`bal`)values	('$d_s','$resp','$vis_cash','$vis_def','$vis_cancel','$vis_total','$vis_act','$dts_total','$dts_cancel','$dts_act','$dts_ok','$dts_delay','$dts_do','$dts_do_not','$bal')");
        }
    } else {
        if ($rec['r']) {
            mysql_q("DELETE from $table where date ='$d_s' and rec='$d_s' ");
        }
    }
    return [$notes, $rows];
}
function sync_visits($d_s, $d_e, $item){
    global $visXTables, $srvXTables, $rpr;    
    $notes = [];
    $syncStatus = k_no_errors;
    if($item){
        $q_d = explode('-', $item);
        $mood = $q_d[0] ?? 0;
        $vis = $q_d[1] ?? 0;
        $table = $visXTables[$mood];
        $table2 = $srvXTables[$mood];
        $s4 = 0;
        if($mood){
            $q = " d_start>='$d_s' and d_start < '$d_e' and status !=3 ";
            $r = getRec($table, $vis);
            if ($r['r']) {
                if ($mood != 6) {
                    $senc = $r['senc'];
                    $v_status = $r['status'];
                    $o_doc_bal = $r['t_doc_bal'];
                    $o_hos_bal = $r['t_hos_bal'];
                    $o_doc_dis = $r['t_doc_dis'];
                    $o_hos_dis = $r['t_hos_dis'];
                    $pay_type = $r['pay_type'];
                    $o_total_pay = $r['t_total_pay'];
                    $o_pay_net = $r['t_pay_net'];
                    $o_d_start = $r['d_start'];

                    $class = " clr2 f1 lh20 Over ";
                    /***********************************/
                    $cash = getVisCashBal($mood, $vis);
                    if (defPayDate($mood, $vis, $d_s) > 0) {
                        $notes[] = '<div class="' . $class . '" onclick="showAcc(' . $vis . ',' . $mood . ')">' . k_pay_with_incorrect . ' </div>';
                    }
                    /***********************************/
                    if ($v_status == 1) {
                        $notes[] = '<div class="' . $class . ' n' . $vis . '" onclick="endVisAcc(' . $mood . ',' . $vis . ')">' . k_not_finished . ' </div>';
                    }
                    /***********************************/
                    /***********************************/

                    $sql2 = "select * from $table2 where visit_id='$vis' ";
                    $res2 = mysql_q($sql2);
                    $rows2 = mysql_n($res2);
                    $t_doc_bal = $t_hos_bal = $t_doc_dis = $t_hos_dis = $t_total_pay = $t_pay_net = 0;
                    $srvCash = 0;
                    if ($rows2 > 0) {
                        while ($r2 = mysql_f($res2)) {
                            $srv_id = $r2['id'];
                            $hos_part = $r2['hos_part'];
                            $doc_part = $r2['doc_part'];
                            $o_total_pay = $r2['total_pay'];
                            $doc_percent = $r2['doc_percent'];
                            $pay_net = $r2['pay_net'];
                            $srv_status = $r2['status'];
                            $doc_bal = $r2['doc_bal'];
                            $doc_dis = $r2['doc_dis'];
                            $hos_bal = $r2['hos_bal'];
                            $hos_dis = $r2['hos_dis'];
                            $srv_pay_type = $r2['pay_type'];
                            $cost = $r2['cost'];
                            $total_pay = $doc_part + $hos_part;
                            $dis = $doc_dis + $hos_dis;
                            if ($pay_type == 2 || $pay_type == 3) {
                                $dis = 0;
                            }
                            $c_doc_bal = $doc_bal;
                            $c_hos_bal = $hos_bal;

                            $c_dis_h = $hos_dis;
                            $c_dis_d = $doc_dis;

                            if ($hos_part + $doc_part > 0) {
                                if ($doc_percent && $doc_part) {
                                    $c_doc_bal = intval(($doc_part * $doc_percent) / 100);
                                }
                                $c_hos_bal = $total_pay - $c_doc_bal;
                                if ($dis) {
                                    $c_dis_h = intval(($c_hos_bal * $dis) / $total_pay);
                                    $c_dis_d = $dis - $c_dis_h;

                                    $c_dis_d = intval(($c_doc_bal * $dis) / $total_pay);
                                    $c_dis_h = $dis - $c_dis_d;

                                    $c_hos_bal = $c_hos_bal - $c_dis_h;
                                    $c_doc_bal = $c_doc_bal - $c_dis_d;
                                    $pay_net = $total_pay - $dis;
                                }
                            }
                            /*******************************/
                            /*$dis=$doc_dis+$hos_dis;
                            $c_fp_dd=0;
                            $c_fp_hh=0;
                            if($pay_type==2 || $pay_type==3){$dis=0;}
                            /*if($dis==0){
                                $c_doc_bal= intval($doc_percent*$doc_part/100);
                                $c_hos_bal= $total_pay-$doc_bal;				 
                            }else{
                                $c_dis_d=0;
                                $c_dis_h=0;
                                if($hos_part==0){ 
                                    $c_dis_d=$dis;
                                }elseif($doc_part==0){
                                    $c_dis_h=$dis;
                                }else{
                                    $dis_x=$hos_part/$doc_part;
                                    $c_dis_d=intval($dis/($dis_x+1));
                                    $c_dis_h=$dis-$c_fp_dd;
                                }
                                //477685
                            }*/
                            /*************************************/
                            if ($mood == 3 && $cost > 0) {
                                $c_doc_bal = (($doc_part - $cost) / 100 * $doc_percent);
                            }
                            /*************************************/
                            if ($pay_type == 3 && $total_pay && $srv_pay_type == 3) {
                                $insurVal = $total_pay - $pay_net;
                                $r3 = getRecCon('gnr_x_insurance_rec', " service_x='$srv_id' and mood='$mood' ");
                                if ($r3['r']) {
                                    $i_price = $r3['price'];
                                    $i_in_price = $r3['in_price'];
                                    $i_in_price_includ = $r3['in_price_includ'];
                                    $i_in_cost = $r3['in_cost'];
                                    $i_res_status = $r3['res_status'];
                                    $i_status = $r3['status'];
                                    $ins_rVal = $i_in_price - $i_in_price_includ;
                                    if ($ins_rVal != $pay_net) {
                                        $notes[] = '<div class="' . $class . ' n' . $vis . '" onclick="showAcc(' . $vis . ',' . $mood . ')"> ' . k_ins_amount_not_match . '</div>';
                                    }
                                } else {
                                    $notes[] = '<div class="' . $class . ' n' . $vis . '" onclick="showAcc(' . $vis . ',' . $mood . ')">'.k_no_ins_record.'</div>';
                                }
                            }
                            /*************************************/
                            if ($srv_status != 3) {
                                $srvCash += $pay_net;
                                $t_doc_bal += $doc_bal;
                                $t_hos_bal += $hos_bal;
                                $t_doc_dis += $doc_dis;
                                $t_hos_dis += $hos_dis;
                                $t_total_pay += $total_pay;
                                $t_pay_net += $pay_net;
                            }
                            if ($v_status != 3) {
                                if (($doc_bal == $c_doc_bal &&
                                        $hos_bal == $c_hos_bal &&
                                        $doc_dis == $c_dis_d &&
                                        $hos_dis == $c_dis_h &&
                                        $total_pay == $o_total_pay)
                                    || $v_status == 1
                                ) {
                                } else {
                                    if ($mood != 7) {
                                        if (
                                            !in_array($doc_bal - $c_doc_bal, array(0, 1, -1)) &&
                                            !in_array($hos_bal - $c_hos_bal, array(0, 1, -1))
                                        ) {
                                            $notes[] = '<div class="cbg7 pd10f bord" dir="ltr">
                                            doc_bal=' . $doc_bal . '->' . $c_doc_bal . '<br>
                                            hos_bal=' . $hos_bal . '->' . $c_hos_bal . '<br>
                                            doc_dis=' . $doc_dis . '->' . $c_dis_d . '<br>
                                            hos_dis=' . $hos_dis . '->' . $c_dis_h . '<br>
                                            total_pay=' . $o_total_pay . '->' . $total_pay . '</div>';

                                            $notes[] = '<div class="' . $class . '" onclick="showAcc(' . $vis . ',' . $mood . ')"><ff>' . $srv_id . ' | </ff>'.k_account_ser_not_match.'( '.k_corrected.')</div>';
                                        }
                                        $sql5 = "UPDATE $table2 SET 
                                        doc_bal='$c_doc_bal',
                                        hos_bal='$c_hos_bal',
                                        doc_dis='$c_dis_d',
                                        hos_dis='$c_dis_h',                        
                                        pay_net='$pay_net',
                                        total_pay='$total_pay'
                                        where id='$srv_id' ";
                                        mysql_q($sql5);
                                    }
                                }
                            }
                            /*************************************/
                            if ($srv_status == 6) {
                                $notes[] = '<div class="' . $class . '" onclick="showAcc(' . $vis . ',' . $mood . ')"><ff> ' . $srv_id . ' | </ff>'.k_incomplete_x_report.'</div>';
                                $s4++;
                                $thisVisErr = 1;
                            }
                        }
                    } else {
                        $notes[] = '<div class="' . $class . ' " onclick="showAcc(' . $vis . ',' . $mood . ')"> '.k_visit_without_ser.'</div>';
                    }
                    /***********************************/
                    if ($srvCash != $cash) {
                        $notes[] = '<div class="' . $class . ' " onclick="showAcc(' . $vis . ',' . $mood . ')">'.k_no_fin_balance.'</div>';
                    }
                    /***********************************/

                    /***********************************/
                    $sql5 = "UPDATE $table SET 
                    t_doc_bal='$t_doc_bal',
                    t_hos_bal='$t_hos_bal',
                    t_doc_dis='$t_doc_dis',
                    t_hos_dis='$t_hos_dis',
                    t_total_pay='$t_total_pay',
                    t_pay_net='$t_pay_net',
                    senc=1
                    where id='$vis'";
                    mysql_q($sql5);
                } else {
                    $clinic = $r['clinic'];
                    $v_status = $r['status'];
                    $vis_shoot = $r['vis_shoot_r'];
                    $price = $r['price'];
                    $dis = $r['dis'];
                    $total = $r['total'];
                    $total_pay = $r['total_pay'];

                    $o_d_start = $r['d_start'];
                    $o_d_start = $o_d_start - ($o_d_start % 86400);

                    ${'st' . $v_status}++;
                    $cash = getVisCashBal($mood, $vis);
                    if (defPayDate($mood, $vis, $o_d_start) > 0) {
                        $notes[] = '<div class="' . $class . '" onclick="showAcc(' . $vis . ',' . $mood . ')">'.k_visit_defe_pay.'</div>';
                        $s4++;
                        $thisVisErr = 1;
                    }
                    $srvCash = $total_pay;
                    $thisVisErr = 0;
                    //if($v_status==1){$notes[]='<div class="'.$class.'" onclick="endVisAcc('.$mood.','.$vis.')"><ff>'.$vis.'</ff></div>';}
                    if ($srvCash != $cash) {
                        $notes[] = '<div class="' . $class . '" onclick="showAcc(' . $vis . ',' . $mood . ')">'.k_no_fin_balance.' </div>';
                    }
                    /*******************************/
                    $ss_d = $o_d_start;
                    $ee_d = $ss_d + 86400;
                    if (getTotalCO('gnr_x_acc_payments', "mood like '$mood%' and vis='$vis' and (date >= '$ee_d' or date < '$ss_d') ") > 0) {
                        $notes[] = '<div class="' . $class . '" onclick="showAcc(' . $vis . ',' . $mood . ')">'.k_pay_date_not_match.'</div>';
                    }
                    /*******************************/
                    if (intval(($vis_shoot * $price) - $total) > 1) {
                        $notes[] = '<div class="' . $class . '" onclick="showAcc(' . $vis . ',' . $mood . ')"><ff>' . $srv_id . '| </ff>'.k_account_ser_not_match.' <ff>(' . (intval($vis_shoot * $price) - $total) . ')</ff>-</div>';
                    }
                    /********************************/
                }
            }
            if (count($notes)) {
                $syncStatus = '<span class="clr5">  '. k_errors . count($notes) . '</span>';
            }
        }
    }
    return [$notes, $syncStatus];
}
function getVisCashBal($mood, $vis){
    $in = get_sum('gnr_x_acc_payments', 'amount', " mood like '$mood%' and vis='$vis' and type IN(1,2,7,11)");
    $out = get_sum('gnr_x_acc_payments', 'amount', " mood like '$mood%' and vis='$vis' and type IN(3,4)");
    return $in - $out;
}
function defPayDate($cType, $vis, $s_date){
    $e_date = $s_date + 86400;
    $con = "mood like '$cType%' and vis='$vis' and type!=10 and (date < '$s_date' OR date > '$e_date' ) ";
    return getTotalCO('gnr_x_acc_payments', $con);
}
