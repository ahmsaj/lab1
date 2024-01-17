<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['mood'], $_POST['vis'])) {
    $mood = pp($_POST['mood']);
    $vis = pp($_POST['vis']);
    $table = $visXTables[$mood];
    $sTable = $srvXTables[$mood];
    $mTable = $srvTables[$mood];
    $visInfo = getRec($table, $vis);
    echo '<form name="dis_fix_form" id="dis_fix_form" action="' . $f_path . 'X/dts_dis_fix_save.php" method="post" cb="sendDataDisFix()">
    <input type="hidden" name="mood" value="' . $mood . '"/>
    <input type="hidden" name="vis" value="' . $vis . '"/>';
    if ($visInfo['r']) {
        $doctor = $visInfo['doctor'];
        $patient = $visInfo['patient'];
        $clinic = $visInfo['clinic'];
        $d_start = $visInfo['d_start'];
        $pay_type = $visInfo['pay_type'];
        $status = $visInfo['status'];
        $reg_user = $visInfo['reg_user'];
        $dts_id = $visInfo['dts_id'];
        $app = $visInfo['app'];
        $pay_type_link = $visInfo['pay_type_link'];
        echo '<div>
            <div class="f1 fs16 clr1 uLine lh40">
            <div class="fr"><ff14 class="clr5 lh40" dir="ltr">' . date('Y-m-d Ah:i:s', $d_start) . '</ff14></div>
            ' . get_p_name($patient) . '               
            |  ' . get_val('_users', 'name_' . $lg, $doctor) . ' ( ' . get_val('gnr_m_clinics', 'name_' . $lg, $clinic) . ' ) 
            </div>
        </div>';
        echo '
        <div class="f1 lh30">' . k_reception . ': ' . get_val('_users', 'name_' . $lg, $reg_user) . '</div>
        <div class="f1 lh30 pd10v">' . k_num_of_appointment . ' : ';
        if ($app) {
            echo $dts_id;
        } else {
            echo '<input type="text" name="dts" value="' . $dts_id . '" fix="w:200"/>';
        }
        echo '</div>';

        $err = 0;
        $msg = '';
        if ($status == 0) {
            $err = 1;
            $msg = k_visit_not_modified;
        }
        if ($pay_type != 0) {
            $err = 1;
            $msg =  k_visit_not_visit . '( ' . $pay_types[$pay_type] . ' ) ';
        }
        if ($err) {
            echo '<div class="f1 fs14 clr5">' . $msg . '</div>';
        } else {
            $sql = "select * from $sTable where visit_id='$vis' ";
            $res = mysql_q($sql);
            $rows = mysql_n($res);
            if ($rows) {
                echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s g_ord">
                <tr>';
                if (!$app) {
                    echo '<th></th>';
                }
                echo '
                    <th>' . k_service . '</th>
                    <th>' . k_thpreview . '</th>
                    <th>' . k_proced . '</th>
                    <th>' . k_perc_doc . '</th>
                    <th>' . k_net_mnt_pd . '</th>
                    <th>' . k_doctor_share . '</th>
                    <th>' . k_doc_discount . '</th>
                    <th>' . k_center_share . '</th>
                    <th>' . k_center_dis . '</th>
                </tr>';
                $sel = ' checked ';
                while ($r = mysql_f($res)) {
                    $sid = $r['id'];
                    $doc_part = $r['doc_part'];
                    $hos_part = $r['hos_part'];
                    $service = $r['service'];
                    $doc_percent = $r['doc_percent'];
                    $pay_net = $r['pay_net'];
                    $doc_bal = $r['doc_bal'];
                    $doc_dis = $r['doc_dis'];
                    $hos_bal = $r['hos_bal'];
                    $hos_dis = $r['hos_dis'];
                    $sevApp = $r['app'];
                    echo '<tr>';
                    if ($app) {
                        if ($sevApp) {
                            echo '  
                            <input type="hidden" name="srv_id" value="' . $sid . '"/>
                            <td txt>' . get_val($mTable, 'name_' . $lg, $service) . '</td>
                            <td><input type="number" value="' . ($hos_part) . '" name="hos_part"></td>
                            <td><input type="number" value="' . ($doc_part) . '" name="doc_part" /></td>
                            <td><input type="number" value="' . ($doc_percent) . '" name="doc_percent" /></td>
                            <td><input type="number" value="' . ($pay_net) . '" name="pay_net" /></td>
                            <td><input type="number" value="' . ($doc_bal) . '" name="doc_bal" /></td>
                            <td><input type="number" value="' . ($doc_dis) . '" name="doc_dis" /></td>
                            <td><input type="number" value="' . ($hos_bal) . '" name="hos_bal" /></td>
                            <td><input type="number" value="' . ($hos_dis) . '" name="hos_dis" /></td>';
                        }
                    } else {
                        echo '
                            <td><input type="radio" name="service" value="' . $sid . '" ' . $sel . '/></td>
                            <td txt>' . get_val($mTable, 'name_' . $lg, $service) . '</td>
                            <td><ff>' . number_format($hos_part) . '</ff></td>
                            <td><ff>' . number_format($doc_part) . '</ff></td>
                            <td><ff>%' . number_format($doc_percent) . '</ff></td>
                            <td><ff>' . number_format($pay_net) . '</ff></td>
                            <td><ff>' . number_format($doc_bal) . '</ff></td>
                            <td><ff>' . number_format($doc_dis) . '</ff></td>
                            <td><ff>' . number_format($hos_bal) . '</ff></td>
                            <td><ff>' . number_format($hos_dis) . '</ff></td>';
                    }
                    echo '</tr>';
                    $sel = '';
                }
                echo '</table>';
                if ($app) {
                    echo '<div class="fl ic40 icc2 ic40Txt ic40_save mg20v" saveDis>' . k_save . '</div>';
                } else {
                    echo '<div class="fl ic40 icc4 ic40Txt ic40_ref mg20v" saveDis>' . k_convert_app_dis . '</div>';
                }
            }
        }
    } else {
        echo '<div class="f1 clr5 fs14">' . k_nvis_num . '</div>';
    }
    echo '</form>';
}
