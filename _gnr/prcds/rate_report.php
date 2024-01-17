<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['mood'], $_POST['time'])) {
    $mood = pp($_POST['mood']);
    $doc = pp($_POST['doc']);
    $user = pp($_POST['user']);
    $time = pp($_POST['time']);
    $rate = pp($_POST['rate']);
    $day = pp($_POST['day'], 's');
    $month = pp($_POST['month'], 's');
    $year = pp($_POST['year']);
    $serInfo = $qDate = $qMood = $qDoc = $qUser = $qRate = '';
    if ($mood) {
        $qMood = " and type = '$mood' ";
        $serInfo .= '<div class="fl f1 pd10 bord mg5 cbg444 br5">' . k_the_sec . ': <span class="f1 clr1 lh30"> ' . $clinicTypesFull[$mood] . '</span></div>';
    }
    if ($doc) {
        $qDoc = " and doc = '$doc' ";
        $serInfo .= '<div class="fl f1 pd10 bord mg5 cbg444 br5">' . k_doctor . ': <span class="f1 clr1 lh30"> ' . get_val('_users', 'name_' . $lg, $doc) . '</span></div>';
    }
    if ($user) {
        $qUser = " and user = '$user' ";
        $serInfo .= '<div class="fl f1 pd10 bord mg5 cbg444 br5">' . k_reception . ': <span class="f1 clr1 lh30"> ' . get_val('_users', 'name_' . $lg, $user) . '</span></div>';
    }
    if ($rate) {
        $qRate = " and rate = '$rate' ";
        $serInfo .= '<div class="fl f1 pd10 bord mg5 cbg444 br5 ">' . k_assessment . ': <ff14 class="lh30 clr1">' . $rate . '</ff></div>';
    }

    $total = [0, 0, 0];
    /*********************************/
    if ($time == 1) { //يومي
        $s_d = strtotime($day);
        $e_d = $s_d + 86400;
        $qDate = "where  vis_date >= $s_d and vis_date< $e_d";
        $rates = 0;
        echo '<div class="f1 fs14 clr1 lh50 b_bord"> ' . k_daily_report . ' <ff14 dir="ltr">' . $day . '</ff14></div>
        <div class="fl w100 f1 pd10v">' . $serInfo . '</div>';
        $sql = "select * from gnr_x_visit_rate $qDate $qMood $qDoc $qUser $qRate order by date ASC";
        $res = mysql_q($sql);
        $rows = mysql_n($res);
        if ($rows) { ?>
            <div class="f1 lh40"><?= k_num_res ?> <ff14>(<?= $rows ?>)</ff14>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
                <tr>
                    <th width="60"><?= k_thvisit ?></th>
                    <th> <?= k_the_eva ?></th>
                    <th><?= k_patient ?></th>
                    <th><?= k_doctor ?></th>
                    <th><?= k_notes ?> </th>
                    <th width="60"><?= k_assessment ?></th>
                </tr>
                <?
                while ($r = mysql_f($res)) {
                    $pay_id = $r['id'];
                    $patient = $r['patient'];
                    $mood = $r['type'];
                    $visit = $r['visit'];
                    $rate = $r['rate'];
                    $note = $r['note'];
                    $doc = $r['doc'];
                    $date = $r['date'];
                    $vis_date = $r['vis_date'];
                    $user = $r['user'];
                    $clinic = $r['clinic'];
                    $recTxt = get_val_arr('_users', 'name_' . $lg, $user, 'u');
                    $docTxt = get_val_arr('_users', 'name_' . $lg, $doc, 'u');
                    $clinicTxt = '';
                    if ($mood != 2) {
                        $clinicTxt = ' ( ' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'c') . ' )';
                    }
                    $moodTxt = $clinicTypes[$mood];
                    $rates += $rate;
                ?>
                    <tr>
                        <td>
                            <ff14><?= number_format($visit) ?></ff14>
                        </td>
                        <td txtS><?= $recTxt ?><div class="clr1 ff B lh20" dir="ltr"><?= date('Y-m-d Ah:i', $date) ?></div>
                        </td>

                        <td txtS><?= get_p_name($patient) ?></td>
                        <td txtS><?= $docTxt . $clinicTxt ?></td>
                        <td><?= $note ?></td>
                        <td class="rateBg<?= $rate ?>">
                            <ff class="clrw"><?= $rate ?></ff>
                        </td>
                    </tr><?
                        } ?>
                <tr fot>
                    <td colspan="5" txtS><?= k_rate ?></td>
                    <td>
                        <ff><?= number_format($rates / $rows, 2) ?></ff>
                    </td>
                </tr>
            </table><?
                } else {
                    echo '<div class="f1 fs14 clr5 lh40"> ' . k_no_results . '</div>';
                }
            }
            if ($time == 2) { //شهري
                $name = '<ff14 dir="ltr">' . date('Y-m', $month) . '</ff14> | ' . $monthsNames[date('n', $m)];
                $y = date('Y', $month);
                $m = date('m', $month);
                $days = date('t', $month);
                echo '<div class="f1 fs14 clr1 lh50 b_bord">' . k_monthly_report . '  ' . $name . '</div>
        <div class="fl w100 f1 pd10v">' . $serInfo . '</div>'; ?>
        <table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
            <tr>
                <th><?= k_tday ?></th>
                <th><?= k_ass ?> </th>
                <th width="100"><?= k_rate ?></th>
            </tr><?
                    $numersT = $averageT = $dayX = 0;
                    for ($i = 1; $i <= $days; $i++) {
                        $s_d = strtotime($y . '-' . $m . '-' . $i);
                        $e_d = strtotime($y . '-' . $m . '-' . ($i + 1));
                        $qDate = "where vis_date >= $s_d and vis_date< $e_d";
                        $sql = "select count(*)c ,AVG(rate) a from gnr_x_visit_rate $qDate $qMood $qDoc $qUser $qRate ";
                        $res = mysql_q($sql);
                        $r = mysql_f($res);
                        $numers = $r['c'];
                        $average = $r['a'];
                        $numersT += $numers;
                        $averageT += $average;
                        if ($numers) {
                            $dayX++; ?>
                    <tr>
                        <td>
                            <ff14><?= $i ?></ff14>
                        </td>
                        <td>
                            <ff14><?= number_format($numers) ?></ff14>
                        </td>
                        <td class="rateBg<?= round($average) ?>">
                            <ff class="clrw"><?= number_format($average, 2) ?></ff>
                        </td>
                    </tr><?
                        }
                    } ?>
            <tr fot>
                <td txtS><?= k_total ?></td>
                <td>
                    <ff14><?= number_format($numersT) ?></ff14>
                </td>
                <td class="rateBg<?= round($averageT / $dayX) ?>">
                    <ff class="clrw"><?= number_format($averageT / $dayX, 2) ?></ff>
                </td>
            </tr>
        </table><?
            }
            if ($time == 3) { //سنوي
                echo '<div class="f1 fs14 clr1 lh50 b_bord">التقرير السنوي <ff14 dir="ltr">' . $year . '</ff14></div>
        <div class="fl w100 f1 pd10v">' . $serInfo . '</div>';
                $sql = "select * from gnr_x_visit_rate order by date ASC";
                //$sql="select * from gnr_x_visit_rate $qDate $qMood $qDoc $qUser $qRate order by date ASC";
                $res = mysql_q($sql);
                $rows = mysql_n($res);
                if ($rows) { ?>
            <table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
                <tr>
                    <th width="120"><?= k_thmonth ?></th>
                    <th><?= k_ass ?></th>
                    <th width="100"><?= k_rate ?></th>
                </tr><?
                        $numersT = $averageT = $dayX = 0;
                        for ($i = 1; $i < 13; $i++) {
                            $s_d = strtotime($year . '-' . $i . '-1');
                            if($i==12){
                                $e_d = strtotime(($year+1) . '-1-1');
                            }else{
                                $e_d = strtotime($year . '-' . ($i + 1) . '-1');
                            }

                            $qDate = "where vis_date >= $s_d and vis_date< $e_d";

                             $sql = "select count(*)c ,AVG(rate) a from gnr_x_visit_rate $qDate $qMood $qDoc $qUser $qRate ";                            
                            $res = mysql_q($sql);
                            $r = mysql_f($res);
                            $numers = $r['c'];
                            $average = $r['a'];
                            $numersT += $numers;
                            $averageT += $average;
                            if ($numers) {
                                $dayX++; ?>
                        <tr>
                            <td>
                                <div class="TL f1">
                                    <ff14><?= $i ?> -</ff14> <?= $monthsNames[$i]; ?>
                                </div>
                            </td>
                            <td>
                                <ff14><?= number_format($numers) ?></ff14>
                            </td>
                            <td class="rateBg<?= round($average) ?>">
                                <ff class="clrw"><?= number_format($average, 2) ?></ff>
                            </td>
                        </tr><?
                            }
                        } ?>
                <tr fot>
                    <td txtS><?= k_total ?></td>
                    <td>
                        <ff14><?= number_format($numersT) ?></ff14>
                    </td>
                    <td class="rateBg<?= round($averageT / $dayX) ?>">
                        <ff class="clrw"><?= number_format($averageT / $dayX, 2) ?></ff>
                    </td>
                </tr>
            </table><?
                } else {
                    echo '<div class="f1 fs14 clr5 lh40">' . k_no_results . ' </div>';
                }
            }
            if ($time == 4) { //شهري أطباء
                $name = '<ff14 dir="ltr">' . date('Y-m', $month) . '</ff14> | ' . $monthsNames[date('n', $m)];
                $y = date('Y', $month);
                $m = date('m', $month);
                $s_d = strtotime($y . '-' . $m . '-1');
                $e_d = strtotime($y . '-' . ($m + 1) . '-1');
                $qDate = "where vis_date >= $s_d and vis_date< $e_d";
                $rates = 0;
                $numersT = $averageT = $dayX = 0;
                echo '<div class="f1 fs14 clr1 lh50 b_bord">' . k_monthly_rep_doctors . '<ff14 dir="ltr">' . $name . '</ff14></div>
        <div class="fl w100 f1 pd10v">' . $serInfo . '</div>';
                $sql = "select id,name_$lg from _users where grp_code IN ($docsGrpStr) $qDoc order by name_$lg ASC";
                $res = mysql_q($sql);
                $rows = mysql_n($res);
                if ($rows) { ?>
            <div class="f1 lh40"><?= k_num_res ?> <ff14>(<?= $rows ?>)</ff14>
            </div>
            <table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
                <tr>
                    <th><?= k_doctor ?></th>
                    <th><?= k_ass ?> </th>
                    <th width="100"><?= k_rate ?></th>
                </tr>
                <?
                    while ($r = mysql_f($res)) {
                        $doc_id = $r['id'];
                        $name = $r['name_' . $lg];
                        $sql2 = "select count(*)c ,AVG(rate) a from gnr_x_visit_rate $qDate and doc='$doc_id' $qMood $qUser $qRate ";

                        $res2 = mysql_q($sql2);
                        $r2 = mysql_f($res2);
                        $numers = $r2['c'];
                        $average = $r2['a'];
                        $numersT += $numers;
                        $averageT += $average;
                        if ($numers) {
                            $dayX++; ?>
                        <tr>
                            <td txtS><?= $name ?></td>
                            <td>
                                <ff14><?= number_format($numers) ?></ff14>
                            </td>
                            <td class="rateBg<?= round($average) ?>">
                                <ff class="clrw"><?= number_format($average, 2) ?></ff>
                            </td>
                        </tr><?
                            }
                        } ?>
                <tr fot>
                    <td txtS><?= k_total ?></td>
                    <td>
                        <ff14><?= number_format($numersT) ?></ff14>
                    </td>
                    <td class="rateBg<?= round($averageT / $dayX) ?>">
                        <ff class="clrw"><?= number_format($averageT / $dayX, 2) ?></ff>
                    </td>
                </tr>
            </table><?
                } else {
                    echo '<div class="f1 fs14 clr5 lh40">' . k_no_results . ' </div>';
                }
            }
        } ?>