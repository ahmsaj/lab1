<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['mood'], $_POST['time'])) {
    $mood = pp($_POST['mood']);
    $bank = pp($_POST['bank']);
    $user = pp($_POST['user']);
    $time = pp($_POST['time']);
    $day = pp($_POST['day'], 's');
    $month = pp($_POST['month'], 's');
    $year = pp($_POST['year']);
    $serInfo = $qDate = $qMood = $qBank = $qUser = '';
    if ($mood) {
        if ($mood == 9) { // المواعيد
            $qMood = " and type = '6' ";
        } else if ($mood == 10) { // العروض
            $qMood = " and type = '10' ";
        } else {
            $qMood = " and mood = '$mood' ";
        }
        $serInfo .= '<div class="fl f1 pd10 bord mg5 cbg444 br5">' . k_the_sec . ': <span class="f1 clr1 lh30"> ' . $clinicTypesFull[$mood] . '</span></div>';
    }
    if ($bank) {
        $qBank = " and bank = '$bank' ";
        $serInfo .= '<div class="fl f1 pd10 bord mg5 cbg444 br5">' . k_bank . ': <span class="f1 clr1 lh30"> ' . get_val('gnr_m_banks', 'name', $bank) . '</span></div>';
    }
    if ($user) {
        $qUser = " and casher = '$user' ";
        $serInfo .= '<div class="fl f1 pd10 bord mg5 cbg444 br5">' . k_reception . ': <span class="f1 clr1 lh30"> ' . get_val('_users', 'name_' . $lg, $user) . '</span></div>';
    }

    $total = [0, 0, 0];
    /*********************************/
    if ($time == 1) { //يومي
        $s_d = strtotime($day);
        $e_d = $s_d + 86400;
        $qDate = "and  date >= $s_d and date< $e_d";

        echo '<div class="f1 fs14 clr1 lh50 b_bord">' . k_daily_report . '  <ff14 dir="ltr">' . $day . '</ff14></div>
        <div class="fl w100 f1 pd10v">' . $serInfo . '</div>';
        $sql = "select * from gnr_x_acc_payments where pay_type=2 $qDate $qMood $qBank $qUser order by date ASC";
        $res = mysql_q($sql);
        $rows = mysql_n($res);
        if ($rows) { ?>
            <div class="f1 lh40"><?= k_num_res ?> <ff14>(<?= $rows ?>)</ff14>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
                <tr>
                    <th width="60"><?= k_thnum ?></th>
                    <th width="80"><?= k_tim ?></th>
                    <th><?= k_department ?></th>
                    <th><?= k_bank ?></th>
                    <th> <?= k_pay_info ?></th>
                    <th><?= k_reception ?></th>
                    <th width="70"><?= k_paym ?></th>
                    <th width="70"><?= k_ratio ?></th>
                    <th width="60"><?= k_comm ?></th>
                </tr>
                <?
                while ($r = mysql_f($res)) {
                    $pay_id = $r['id'];
                    $date = $r['date'];
                    $mood = $r['mood'];
                    $type = $r['type'];
                    $casher = $r['casher'];
                    $recTxt = get_val_arr('_users', 'name_' . $lg, $casher, 'u');
                    $bank = $r['bank'];
                    $bankTxt = get_val_arr('gnr_m_banks', 'name', $bank, 'b');
                    $amount = $r['amount'];
                    $commi = $r['commi'];
                    $differ = $r['differ'];
                    $vis = $r['vis'];
                    $total[0] += $amount;
                    $total[1] += $commi;
                    $total[2] += $differ;
                    $payInfo = '';
                    $moodTxt = $clinicTypesFull[$mood];
                    if (in_array($type, array(1, 2, 7))) {
                        $r = getRec($visXTables[$mood], $vis);
                        if ($r['r']) {
                            $patient = $r['patient'];
                            if ($mood != 2) {
                                $clinic = $r['clinic'];
                                $clnName = ' ( ' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'c') . ' ) ';
                            }
                            $payInfo = '<ff14 class="clr1">' . number_format($vis) . ' - </ff14>' . get_p_name($patient) . $clnName;
                        }
                    }
                    if (in_array($type, array(6))) {
                        $r = getRec('dts_x_dates', $vis);
                        if ($r['r']) {
                            $patient = $r['patient'];
                            if ($mood != 2) {
                                $clinic = $r['clinic'];
                                $clnName = ' ( ' . get_val_arr('gnr_m_clinics', 'name_' . $lg, $clinic, 'c') . ' ) ';
                            }
                            $payInfo = $payInfo = '<ff14 class="clr1">' . number_format($vis) . ' - </ff14>' . get_p_name($patient) . $clnName;
                        }
                    }
                    if (in_array($type, array(10))) {
                        $r = getRec('gnr_x_offers', $vis);
                        if ($r['r']) {
                            $patient = $r['patient'];
                            $payInfo = '<ff14 class="clr1">' . number_format($vis) . ' - </ff14>' . get_p_name($patient);
                        }
                    } ?>
                    <tr>
                        <td>
                            <ff14><?= number_format($pay_id) ?></ff14>
                        </td>
                        <td>
                            <ff14><?= date('A h:i', $date) ?></ff14>
                        </td>
                        <td txtS><?= $moodTxt ?></td>
                        <td txtS><?= $bankTxt ?></td>
                        <td txtS>
                            <div class="TL f1"><?= $payInfo ?></div>
                        </td>
                        <td txtS><?= $recTxt ?></td>
                        <td>
                            <ff14 class="clr1"><?= number_format($amount) ?></ff14>
                        </td>
                        <td>
                            <ff14 class=""><?= $differ ?>%</ff14>
                        </td>
                        <td>
                            <ff14 class="clr5"><?= number_format($commi) ?></ff14>
                        </td>

                    </tr><?
                        } ?>
                <tr fot>
                    <td colspan="5"></td>
                    <td txtS><?= k_total ?></td>
                    <td>
                        <ff14 class="clr1"><?= number_format($total[0]) ?></ff14>
                    </td>
                    <td>
                        <ff14 class="">-</ff14>
                    </td>
                    <td>
                        <ff14 class="clr5"><?= number_format($total[1]) ?></ff14>
                    </td>
                </tr>
            </table><?
                } else {
                    echo '<div class="f1 fs14 clr5 lh40">' . k_no_results . ' </div>';
                }
            }
            if ($time == 2) { //شهري
                $name = '<ff14 dir="ltr">' . date('Y-m', $month) . '</ff14> | ' . $monthsNames[date('n', $m)];
                $y = date('Y', $month);
                $m = date('m', $month);
                $s_d = strtotime($y . '-' . $m . '-1');
                if ($m == 12) {
                    $m = 0;
                    $y++;
                }
                $e_d = strtotime($y . '-' . ($m + 1) . '-1');
                $qDate = "and  date >= $s_d and date< $e_d";

                echo '<div class="f1 fs14 clr1 lh50 b_bord">' . k_monthly_report . '  ' . $name . '</div>
        <div class="fl w100 f1 pd10v">' . $serInfo . '</div>';
                $sql = "select date,amount,commi,differ from gnr_x_acc_payments where pay_type=2 $qDate $qMood $qBank $qUser order by date ASC";
                $res = mysql_q($sql);
                $rows = mysql_n($res);
                if ($rows) { ?>
            <table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
                <tr>
                    <th width="80"><?= k_tday ?></th>
                    <th width="60"><?= k_num_payments ?> </th>
                    <th width="70"><?= k_total_pay ?> </th>
                    <th width="60"><?= k_comm ?></th>
                </tr>
                <?
                    $actDay = 0;
                    $dayTotla = [0, 0, 0];
                    $payments = 0;
                    while ($r = mysql_f($res)) {
                        $thisDay = date('j', $r['date']);
                        $amount = $r['amount'];
                        $commi = $r['commi'];
                        $differ = $r['differ'];
                        $total[0] += $amount;
                        $total[1] += $commi;
                        $total[2] += $differ;
                        $payments++;
                        if ($actDay != $thisDay && $actDay != 0) { ?>
                        <tr>
                            <td>
                                <ff14><?= $actDay ?></ff14>
                            </td>
                            <td>
                                <ff14><?= number_format($payments) ?></ff14>
                            </td>
                            <td>
                                <ff14 class="clr1"><?= number_format($dayTotla[0]) ?></ff14>
                            </td>
                            <td>
                                <ff14 class="clr5"><?= number_format($dayTotla[1]) ?></ff14>
                            </td>
                        </tr><?
                                $dayTotla = [0, 0, 0];
                                $payments = 1;
                                $dayTotla[0] += $amount;
                                $dayTotla[1] += $commi;
                                $dayTotla[2] += $differ;
                            } else {
                                $dayTotla[0] += $amount;
                                $dayTotla[1] += $commi;
                                $dayTotla[2] += $differ;
                            }
                            $actDay = $thisDay;
                        }
                        if ($dayTotla[0] + $dayTotla[1] + $dayTotla[2]) { ?>
                    <tr>
                        <td>
                            <ff14><?= $actDay ?></ff14>
                        </td>
                        <td>
                            <ff14><?= number_format($payments) ?></ff14>
                        </td>
                        <td>
                            <ff14 class="clr1"><?= number_format($dayTotla[0]) ?></ff14>
                        </td>
                        <td>
                            <ff14 class="clr5"><?= number_format($dayTotla[1]) ?></ff14>
                        </td>

                    </tr><?
                        } ?>
                <tr fot>
                    <td txtS><?= k_total ?></td>
                    <td>
                        <ff14><?= $rows ?></ff14>
                    </td>
                    <td>
                        <ff14 class="clr1"><?= number_format($total[0]) ?></ff14>
                    </td>
                    <td>
                        <ff14 class="clr5"><?= number_format($total[1]) ?></ff14>
                    </td>

                </tr>
            </table><?
                } else {
                    echo '<div class="f1 fs14 clr5 lh40"> ' . k_no_results . '</div>';
                }
            }
            if ($time == 3) { //سنوي
                echo '<div class="f1 fs14 clr1 lh50 b_bord">' . k_annual_report . '  <ff14 dir="ltr">' . $year . '</ff14></div>
        <div class="fl w100 f1 pd10v">' . $serInfo . '</div>';
                $sql = "select date,amount,commi,differ from gnr_x_acc_payments where pay_type=2 $qDate $qMood $qBank $qUser order by date ASC";
                $res = mysql_q($sql);
                $rows = mysql_n($res);
                if ($rows) { ?>
            <table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
                <tr>
                    <th width="120"><?= k_tday ?></th>
                    <th width="60"><?= k_payms ?></th>
                    <th width="70"><?= k_total_pay ?> </th>
                    <th width="60"><?= k_comm ?></th>
                </tr><?
                        $paymentsTot = 0;
                        for ($i = 1; $i < 13; $i++) {
                            $s_d = strtotime($year . '-' . $i . '-1');
                            $e_d = strtotime($year . '-' . ($i + 1) . '-1');
                            $qDate = "and  date >= $s_d and date < $e_d ";
                            list($amount, $commi, $differ) = get_sum('gnr_x_acc_payments', 'amount,commi,differ', " pay_type=2 $qDate $qMood $qBank $qUser ");
                            $total[0] += $amount;
                            $total[1] += $commi;
                            $total[2] += $differ;
                            $payments = getTotalCo('gnr_x_acc_payments', " pay_type=2 $qDate $qMood $qBank $qUser ");
                            $paymentsTot += $payments;
                            if ($payments) { ?>
                        <tr>
                            <td>
                                <div class="TL f1">
                                    <ff14><?= $i ?> -</ff14> <?= $monthsNames[$i]; ?>
                                </div>
                            </td>
                            <td>
                                <ff14><?= number_format($payments) ?></ff14>
                            </td>
                            <td>
                                <ff14 class="clr1"><?= number_format($amount) ?></ff14>
                            </td>
                            <td>
                                <ff14 class="clr5"><?= number_format($commi) ?></ff14>
                            </td>

                        </tr><?
                            }
                        } ?>
                <tr fot>
                    <td txtS><?= k_total ?></td>
                    <td>
                        <ff14><?= $paymentsTot ?></ff14>
                    </td>
                    <td>
                        <ff14 class="clr1"><?= number_format($total[0]) ?></ff14>
                    </td>
                    <td>
                        <ff14 class="clr5"><?= number_format($total[1]) ?></ff14>
                    </td>
                </tr>
            </table><?
                } else {
                    echo '<div class="f1 fs14 clr5 lh40">' . k_no_results . ' </div>';
                }
            }
        } ?>