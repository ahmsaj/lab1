<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['id'])) {
    $id = pp($_POST['id']);
    $dtsType = pp($_POST['t']);
    $r = getRec('dts_x_dates', $id);
    $s = $r['d_start'];
    $e = $r['d_end'];
    $date = $r['date'];
    $p_type = $r['p_type'];
    $note = $r['note'];
    $c_type = $r['type'];
    $status = $r['status'];
    $vis_link = $r['vis_link'];
    $reg_user = $r['reg_user'];
    $other = $r['other'];

    if ($dtsType == 3) {
        echo '<div class="f1 fs14 lh30 clr5">' . k_reserve_appo_ava . '</div>';
    } else {
        $str = '';
        if ($dtsType == 2) {
            $str = ' <ff class="clr5"> ( ' . k_backup . ' )</ff>';
        }
        echo '<div class="f1 fs16 lh20 clr1">' . get_p_dts_name($r['patient'], $p_type, 2) . $str . '</div>';
    }
    echo '<div class="f1 lh20">' . $wakeeDays[date('w', $s)] . '<ff14> ' . date('d', $s) . ' </ff14> ' . $monthsNames[date('n', $s)] . ' | <ff14>' . date('A h:i', $s) . '</ff14></div>
    <div class="f1 lh20">' . k_doctor . ': ' . get_val('_users', 'name_' . $lg, $r['doctor']) . '</div>';
    if ($dtsType != 3) {
        echo '<div class="f1 lh20"> ' . k_reserv_date . ': <ff14>' . date('Y-m-d A h:i', $date) . '</ff14></div>
        <div class="f1 lh20">' . k_reception . ': ' . get_val('_users', 'name_' . $lg, $reg_user) . '</div>
        <div class="f1 lh20">' . k_status . ': ' . $dateStatus[$status] . dateSubStatus($r) . '</div>';
        if ($note) {
            echo '<div class="f1">' . k_notes . ': ' . nl2br($note) . '</div>';
        }
    }
}
