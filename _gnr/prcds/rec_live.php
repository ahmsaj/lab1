<? include("../../__sys/prcds/ajax_header.php");
//$now+=3000;
if (isset($_POST['t'])) {
    $t = pp($_POST['t']);
    $tabTitle = k_appointments;
    if ($t == 1) {
        $tabTitle = k_operations;
    }
    $recPoint = 1;
    $clearTime = 3600 * 5; //توقيت حذف الزيارات المؤقتة
    $pq = '';
    $closeDate = '';
    $closDtsN = 0;
    $lineTime = _set_k2mw23g7jd;
    $last_date = get_val_con('dts_x_dates_temp', 'd_end', "1=1", "order by d_end DESC");
    $lineTime2 = date('H', $last_date) - date('H', $now) + 1;
    $lineTime2 = max($lineTime2, 1);
    $lineTime = min($lineTime, $lineTime2);

    $dayLength = $lineTime * 3600;
    if (_set_tauv8g02) { // نقطة الاستقبال
        if ($thisGrp == 'pfx33zco65') {
            if (!$_SESSION['po_id']) {
                $recPoint = 0;
                $tabTitle = k_site_sel;
                $bluks .= '
                <div class="f1 fs14 clr55 lh40 pd10">' . k_site_choose_to_show_alerts . '</div>                
                <div class="fl ic40x mg10 icc33 ic40_loc ic40Txt" recPos="0">' . k_site_sel . '</div>';
            } else {
                $serClinic = $_SESSION['po_clns'];
                if($serClinic){
                    $pq = " and (clinic IN($serClinic) OR clinic=0)";
                }
            }
        }
    }
    if ($recPoint) { // نقطة الاستقبال
        /*******************************************/
        $labRQLimit = $xryRQLimit = 5; // العدد الاقصى لعرض طلبات التحاليل والاشعة 
        $lrl = $xrl = 0;
        if ($t == 1) { // العمليات
            $tab1 = $tab2 = $tab3 = $tab4 = $tabL = $tabX = '';
            $ordRec = array();
            $sql = "select * from gnr_x_temp_oprs where user='$thisUser' or(type in(1,2,3,7,8,9))  order by type ASC , date ASC ";
            $res = mysql_q($sql);
            while ($r = mysql_f($res)) {
                $opr_id = $r['id'];
                $vis = $r['vis'];
                $clinic = $r['clinic'];
                $patient = $r['patient'];
                $pat_name = $r['pat_name'];
                $d_start = $r['date'];
                $sub_status = $r['sub_status'];
                $status = $r['status'];
                $type = $r['type'];
                $user = $r['user'];
                $mood = $r['mood'];
                if ($type == 4 && !in_array($vis, $ordRec) && $status == 0) { //زيارة جديدة غير مكتملة
                    if ($now - $d_start > $clearTime) {
                        delVis($vis, $mood, 3);
                        mysql_q("delete from gnr_x_temp_oprs where id='$opr_id'");
                    } else {
                        if ($user == $thisUser) {
                            $tab1 .= '<div class="" blcT="' . $mood . '" blcNew="' . $vis . '" >' . $pat_name . '<span class="ff fs14 B"> ( ' . dateToTimeS2($now - $d_start) . ' ) </span></div>';
                        }
                    }
                }
                if ($type == 3) { // زيارة تأمين
                    array_push($ordRec, $vis);
                    $action = '';
                    if ($status == 1) {
                        $action = ' blcSta="' . $vis . '"  ';
                    }
                    $x = 1;
                    if ($ss_day > $d_start) {
                        $x = getTotalCO($visXTables[$mood], " id='$vis'");
                        if ($x == 0) {
                            delTempOpr($mood, $vis, 3);
                        }
                    }
                    $tab2 .= '
                    <div blcT="' . $mood . '" ' . $action . ' ins_s="' . $sub_status . '" title="' . $payStatusArrRec[$sub_status] . '">
                    ' . $pat_name . ' 		
                    <span class="ff fs14 B"> ( ' . dateToTimeS2($now - $d_start) . ' ) </span>
                    </div>';
                }
                if ($type == 2) { // زيارة جمعية
                    array_push($ordRec, $vis);
                    $action = '';
                    if ($status == 1) {
                        $action = 'blcSta="' . $vis . '"  ';
                    }
                    $x = 1;
                    if ($ss_day > $d_start) {
                        $x = getTotalCO($visXTables[$mood], " id='$vis' ");
                        if ($x == 0) {
                            delTempOpr($mood, $vis, 2);
                        }
                    }
                    $tab3 .= '
                    <div blcT="' . $mood . '" ' . $action . ' chr_s="' . $status . '" title="' . $reqStatusArr[$status] . '">
                    ' . $pat_name . ' <span class="ff fs14 B"> ( ' . dateToTimeS2($now - $d_start) . ' ) </span>
                    </div>';
                }
                if ($type == 1) { // زيارة إعفاء
                    array_push($ordRec, $vis);
                    $action = '';
                    if ($status == 1) {
                        $action = ' blcSta="' . $vis . '"  ';
                    }
                    $tab4 .= '
                    <div blcT="' . $mood . '" ' . $action . ' ex_s="' . $status . '" title="' . $reqStatusArr[$status] . '" >
                    ' . get_p_name($patient) . '<span class="ff fs14 B"> ( ' . dateToTimeS2($now - $d_start) . ' ) </span>
                    </div>';
                }
                if ($type == 7) { //طلب تحليل
                    if ($lrl < $labRQLimit) {
                        array_push($ordRec, $vis);
                        $tabL .= '
                        <div blcLOrd="' . $vis . '" pat="' . $patient . '">
                            ' . $pat_name . '<span class="ff fs14 B"> ( ' . dateToTimeS2($now - $d_start) . ' ) </span>
                        </div>';
                        $lrl++;
                    }
                }
                if ($type == 8) { // طلب أشعة
                    if ($xrl < $xryRQLimit) {
                        array_push($ordRec, $vis);
                        $tabX .= '
                        <div blcXOrd="' . $vis . '" pat="' . $patient . '" cln="' . $clinic . '">
                            ' . get_p_name($patient) . '<span class="ff fs14 B"> ( ' . dateToTimeS2($now - $d_start) . ' ) </span>
                        </div>';
                        $xrl++;
                    }
                }
                if ($type == 9) { // موعد جديد
                    if ($now - $d_start > $clearTime) {
                        delDate($vis, $mood);
                    } else {
                        if ($user == $thisUser) {
                            array_push($ordRec, $vis);
                            $tabD .= '
                            <div blcDate="' . $vis . '" s="' . $status . '">
                                ' . get_p_name($patient) . '<span class="ff fs14 B"> ( ' . dateToTimeS2($now - $d_start) . ' ) </span>
                            </div>';
                        }
                    }
                }
            }
            /**************/
            $tabsTitle = array('',  k_unfish_vis, k_insure_reqs, k_insure_reqs, k_exemp_reqs, k_tests_reqs, k_xray_orders, k_incom_appo);
            $bluks .= '<div class="rec1Blc fxg pd10f"  fxg="gtbf:280px|gap:10px">';
            if ($tab1) {
                $bluks .= '<div class="fxg rec1Blc_1" fxg="gtr:50px 1fr">
                    <div ti>' . $tabsTitle[1] . '</div><div blcss>' . $tab1 . '</div>
                </div>';
            }
            if ($tabD) {
                $bluks .= '<div class="fxg rec1Blc_7" fxg="gtr:50px 1fr">
                    <div ti>' . $tabsTitle[7] . '</div><div blcss>' . $tabD . '</div>
                </div>';
            }
            if ($tab2) {
                $bluks .= '<div class="fxg rec1Blc_2" fxg="gtr:50px 1fr">
                    <div ti>' . $tabsTitle[2] . '</div><div blcss>' . $tab2 . '</div>
                </div>';
            }
            if ($tab3) {
                $bluks .= '<div class="fxg rec1Blc_3" fxg="gtr:50px 1fr">
                    <div ti>' . $tabsTitle[3] . '</div><div blcss>' . $tab3 . '</div>
                </div>';
            }
            if ($tab4) {
                $bluks .= '<div class="fxg rec1Blc_4" fxg="gtr:50px 1fr">
                    <div ti>' . $tabsTitle[4] . '</div><div blcss>' . $tab4 . '</div>
                </div>';
            }
            if ($tabL) {
                $bluks .= '<div class="fxg rec1Blc_5" fxg="gtr:50px 1fr">
                    <div ti>' . $tabsTitle[5] . '</div><div blcss>' . $tabL . '</div>
                </div>';
            }
            if ($tabX) {
                $bluks .= '<div class="fxg rec1Blc_6" fxg="gtr:50px 1fr">
                    <div ti>' . $tabsTitle[6] . '</div><div blcss>' . $tabX . '</div>
                </div>';
            }
            $bluks .= '</div>';
            //أقرب المواعيد
            if (proAct('dts')) {
                $dates_arr = [];
                $sLine = $now - (60 * _set_d9c90np40z);
                $eLine2 = $now + (60 * _set_d9c90np40z);
                $sql = "select * from dts_x_dates_temp where d_end>'$sLine' and d_start<'$eLine2' and status in(1,2,3,4) order by d_start ASC";
                $res = mysql_q($sql);
                $rows = mysql_n($res);
                if ($rows) {
                    while ($r = mysql_f($res)) {
                        $d_id = $r['id'];
                        $dates_arr[$d_id] = $r;
                    }
                    foreach ($dates_arr as $k => $d) {
                        $flasher = '';
                        $flasher2 = '';
                        $d_start = $d['d_start'];
                        $d_status = $d['status'];
                        $pat_name = $d['pat_name'];
                        if ($d_status == 1 && $d_start > $now - (60 * _set_d9c90np40z) && $d_start < $now + (60 * _set_d9c90np40z)) {
                            $flasher = '';
                            $flasher2 = '';
                            $tt = $d_start - $now;
                            $s = '';
                            if ($tt < 0) {
                                $tt = $tt * (-1);
                                $flasher = 'flasher2';
                                if ($tt > 5 * 60) {
                                    $flasher = 'flasher';
                                }
                                $s = '-';
                            }
                            $closDtsN++;
                            $closeDate .= '
                        <div class="clsDateN fl  ' . $flasher . ' Over cbg4" dts="' . $d['id'] . '">
                            <div a class="fl ff B fs16" >' . dateToTimeS2($tt, 0) . ' ' . $s . '</div>
                            <div b class="fl f1 " fix="wp:50">' . $pat_name . '</div>
                        </div>';
                        }
                    }
                }
            }
        }
        /*******************************************/
        if ($t == 2) { // المواعيد
            $sLine = $now - 3600;
            $eLine = $sLine + (3600 * ($lineTime - 1));
            $eLine2 = $eLine + (3600 * 1);
            $ssLine = $sLine % 86400;
            $eeLine = $eLine % 86400;
            $sPbh = (100 / $lineTime);
            //$bluks.='
            //<div class="w100 h100 of fxg" >
            //<div class="ofx so">            
            $bluks .= '<table class="dtsTabR holdH" cellspacing="0" cellpadding="0" width="100%" border="0">
            <tr>
            <th class="cbgw" width="40"><div class="fl viewAll" dtsClinc="0" title=" ' . k_view_all_clinics . ' "></div></th>
            <th valign="top">
            <div class="flcbg4" fix="hw:123">
            <div class="dtsPointerN fl" style="width:' . $sPbh . '%" fix1="wp%:' . $sPbh . '|hw:123">
                <div>' . date('A h:i', $now) . '</div>
            </div>';
            $thisH = $ssLine;
            while ($thisH < $eeLine) {
                $x = $thisH % 3600;
                if ($x != 0) { // الساعة الأولى
                    $thisH -= $x;
                    $pbh = $sPbh - ($x * $sPbh / 3600);
                    $thh = clockSty(($thisH / 3600) + 1);
                    if ($ssLine - $thisH > 3000) {
                        $thh = '';
                    }
                } elseif ($thisH + 3600 > $eeLine) { // الساعة الاخيرة
                    $thisH += 3600;
                    $pbh = ($sPbh - ($thisH - $eeLine) * $sPbh / 3600);
                    $thh = clockSty(($eeLine / 3600) + 1);
                    if ($thisH - $eeLine > 3000) {
                        $thh = '';
                    }
                    if ($pbh < 1) {
                        $pbh = 0;
                    }
                } else { //الساعة الوسطة الكالملة
                    $thisH += 3600;
                    $pbh = $sPbh;
                    $thh = clockSty(($thisH / 3600) + 1);
                }
                $bluks .= '<div class="fl TC of" style="width:' . $pbh . '%;" cl>' . ($thh) . '</div>';
            }
            $bluks .= '</div>
            </th></tr>';
            $dates_arr = [];
            $dates_arr2 = [];
            $clinic_arr = [];
            $reserveArr = [];
            $sql = "select * from dts_x_dates_temp where d_end>'$sLine' and d_start<'$eLine2' and status in(1,2,3,4) order by d_start ASC";
            $res = mysql_q($sql);
            $rows = mysql_n($res);
            $dtsCount = 0;
            if ($rows) {
                while ($r = mysql_f($res)) {
                    $clinic = $r['clinic'];
                    $d_id = $r['id'];
                    if ($r['reserve']) {
                        $reserveArr[$d_id] = $r['reserve'];
                        $r['reserve'] = 'x';
                        $dates_arr[$d_id] = $r;
                    } else {
                        if (!in_array($clinic, $clinic_arr)) {
                            array_push($clinic_arr, $clinic);
                        }
                        $dates_arr[$d_id] = $r;
                    }
                    if ($r['status'] == 1 && $r['d_start'] > $now - (60 * _set_d9c90np40z)) {
                        $dtsCount++;
                    }
                    if ($r['status'] == 1 && $r['token'] && $r['d_start'] > $now && ($r['d_start'] - $now) < ($todayAlertTime * 3600)) {
                        $bluks .= alertPatDts($r['id'], $r['patient'], $r['p_type'], $r['d_start']);
                    }
                }
            }
            $tabTitle .= '<ff14> ( ' . $dtsCount . ' )</ff14>';
            if (count($clinic_arr)) {
                $clnics = implode(',', $clinic_arr);
                $sql = "select id,photo,name_$lg from gnr_m_clinics where act=1 and id IN($clnics) order by ord ASC";
                $res = mysql_q($sql);
                while ($r = mysql_f($res)) {
                    $c_id = $r['id'];
                    $photo = $r['photo'];
                    $name = $r['name_' . $lg];
                    $ph_src = '';
                    if ($photo) {
                        $ph_src = viewImage($photo, 1, 30, 30, 'img', 'clinic.png');
                    }
                    $bluks .= '<tr>
                    <td title="' . $name . '" dtsClinc="' . $c_id . '"><div c>' . $ph_src . '</div></td>
                    <td dtsBlc>';
                    $pointer = $sLine;
                    foreach ($dates_arr as $k => $d) {
                        $flasher = '';
                        $flasher2 = '';
                        $d_id = $k;
                        $showBlc = 1;
                        if ($d['reserve'] != 'x') {
                            if ($d['clinic'] == $c_id) {
                                $d_start = $d['d_start'];
                                $d_end = $d['d_end'];
                                $note = $d['note'];
                                $d_status = $d['status'];
                                $d_mood = $d['type'];
                                $d_vis = $d['vis_link'];
                                $b_margin = 0;
                                $ds = $d_start;
                                $de = $d_end;
                                $d_t = $de - $ds;
                                $d_m = $ds - $pointer;
                                $x = '';
                                if ($ds < $sLine) { // الموعد أصغر من بداية الزمن                             
                                    $d_t = $de - $sLine;
                                    $d_m = $sLine - $pointer;
                                    $b_width = (($d_t / 60) * $sPbh) / 60;
                                    $b_margin = 0;
                                    if ($b_width < 0.2) {
                                        $showBlc = 0;
                                    }
                                } elseif ($de > $eLine2) { // اذا كانت نهاية الموعد اكبر من نهاية الزمن
                                    $d_t = $eLine2 - $pointer;
                                    $b_margin = $d_m * 100 / $dayLength;
                                    $b_width = ((($d_t / 60) * $sPbh) / 60) - $b_margin;
                                    if ($b_width < 1) {
                                        $showBlc = 0;
                                    }
                                } else {
                                    $b_width = (($d_t / 60) * $sPbh) / 60;
                                    $b_margin = $d_m * 100 / $dayLength;
                                }
                                $pat_name = $d['pat_name'];
                                if ($d_status == 2 && $d_start < $now) {
                                    $flasher = 'flasher2';
                                }
                                if ($d_status == 2 && $d_start < $now - (60 * _set_d9c90np40z)) {
                                    $flasher = 'flasher';
                                }
                                $title = $pat_name . '<br><ff14>' . date('A h:i', $ds) . '</ff14>';
                                if ($note) {
                                    $title .= '<br>' . $note;
                                }
                                $b_marginTxt = '';
                                if ($b_margin) {
                                    $b_marginTxt = 'margin-' . $align . ':' . $b_margin . '%';
                                }
                                $x = '';
                                if (in_array($k, $reserveArr)) {
                                    $reserv = array_search($d['id'], $reserveArr);
                                    $title2 = $dates_arr[$reserv]['pat_name'] . ' ( ' . k_backup . ' )<br><ff14>' . date('A h:i', $ds) . '</ff14>';
                                    $d_status2 = $dates_arr[$reserv]['status'];
                                    if ($d_status2 == 2 && $d_start < $now) {
                                        $flasher2 = 'flasher2';
                                    }
                                    if ($d_status2 == 2 && $d_start < $now - (60 * _set_d9c90np40z)) {
                                        $flasher2 = 'flasher';
                                    }
                                    if ($showBlc) {
                                        $bluks .= '<div style="width:' . number_format($b_width, 6) . '%; ' . $b_marginTxt . ' " class="fl dtb2  ' . $flasher . '" >
                                            <div dts="' . $k . '" class=" dtb' . $d_status . ' ' . $flasher . ' dtb_in1 Over " title="' . $title . '"></div>
                                            <div dts="' . $reserv . '" class=" dtb' . $d_status2 . ' ' . $flasher2 . ' dtb_in2 " title="' . $title2 . '"></div>
                                        </div>';
                                    }
                                } else {
                                    if ($showBlc) {
                                        $bluks .= '<div style="width:' . number_format($b_width, 6) . '%; ' . $b_marginTxt . ' " class="fl dtb dtb' . $d_status . ' ' . $flasher . ' Over clr5 of" dts="' . $k . '" title="' . $title . '"></div>';
                                    }
                                }
                                $pointer = $de;
                            }
                        }
                    }
                    $bluks .= '</td>
                    </tr>';
                }
            }
            $bluks .= '</table>';
            //</div>
            //</div>';
            /*******************************/
            if (chProUsed('dts')) {
                foreach ($dates_arr as $k => $d) {
                    $flasher = '';
                    $flasher2 = '';
                    $d_start = $d['d_start'];
                    $ds = $d_start - $ss_day;
                    $de = $d['d_end'] - $ss_day;
                    $de = $d['d_end'] - $ss_day;
                    $d_status = $d['status'];
                    $d_t = $de - $ds;
                    $b_width = $d_t * 100 / $dayLength;
                    $d_m = $ds - $pointer;
                    $b_margin = $d_m * 100 / $dayLength;

                    $pat_name = $d['pat_name'];
                    if ($d_status == 1 && $d_start > $now - (60 * _set_d9c90np40z) && $d_start < $now + (60 * _set_d9c90np40z)) {
                        $flasher = '';
                        $flasher2 = '';
                        $tt = $d_start - $now;
                        $s = '';
                        if ($tt < 0) {
                            $tt = $tt * (-1);
                            $flasher = 'flasher2';
                            if ($tt > 5 * 60) {
                                $flasher = 'flasher';
                            }
                            $s = '-';
                        }
                        $closDtsN++;
                        $closeDate .= '
                        <div class="clsDateN fl  ' . $flasher . ' Over cbg4" dts="' . $d['id'] . '">
                            <div a class="fl ff B fs16" >' . dateToTimeS2($tt, 0) . ' ' . $s . '</div>
                            <div b class="fl f1 " fix="wp:50">' . $pat_name . '</div>
                        </div>';
                    }
                }
            }
        }
        /******************* التنبيهات**********/
        $sql = "select * from gnr_x_visits_services_alert where status!=4 $pq order by date ASC";
        $res = mysql_q($sql);
        $rows = mysql_n($res);
        if ($rows > 0) {
            while ($r = mysql_f($res)) {
                $a_id = $r['id'];
                $a_visit_id = $r['visit_id'];
                $a_clinic = $r['clinic'];
                $a_doc = $r['doc'];
                $a_service = $r['service'];
                $a_patient = $r['patient'];
                $a_amount = $r['amount'];
                $a_date = $r['date'];
                $status = $r['status'];
                $mood = $r['mood'];
                $pat_name = $r['pat_name'];
                $clinic_name = $r['clinic_name'];
                $overTxt = ' O ';
                if ($status == 0) {
                    $overTxt = ' ';
                }
                if ($mood == 22) {
                    $pat_name = k_conflict_appoints . ' <ff14>( ' . $a_amount . ' )</ff14>';
                }
                $c = '';
                if ($status == 5) {
                    $c = $mood . '-' . $a_visit_id;
                }
                $alerts .= '<div class="clr5"  recAlr="' . $a_id . '" c="' . $c . '" s="' . $status . '" ' . $overTxt . ' mood="' . $mood . '">' . $pat_name . ' <ff14>(' . dateToTimeS2($now - $a_date, 0) . ')</ff14></div>';
            }
        }
        if ($alerts) {
            $alerts = '<div class="f1 fs14 lh40">' . k_alerts . ' <ff14> ( ' . $rows . ' ) </ff14></div>' . $alerts;
        }
        if ($closDtsN) {
            $alerts .= '<div class="f1 fs14 lh40"> ' . k_recent_appoints . ' <ff14> ( ' . $closDtsN . ' ) </ff14></div>' . $closeDate;
        }/*
        if($lateDate){
            $alerts.='<div class="f1 fs14 lh40">مواعيد تنتظر الدخول</div>'.$lateDate;
        }*/
    }
    /*******************************************/
    $bal = $viss = 0;
    $r = getRecCon('gnr_x_tmp_cash', " casher='$thisUser' ");
    if ($r['r']) {
        if (_set_vyo1ykjlhm) { // إذا كان الحساب كلي- حساب المسحوبات من الاستقبال
            $bal = ($r['amount_in'] - $r['amount_out']) + ($r['bal_in'] - $r['bal_out']);
        } else {
            $bal = ($r['amount_in'] - $r['amount_out']);
        }
        $viss = $r['vis'];
    }
    /*******************************************/
    echo $t . '^' . $tabTitle . '^' . $bluks . '^' . $alerts . '^' . $viss . '^' . number_format($bal);
    //$t <- تطبع للتأكد اننا بنفس النافذة
}
