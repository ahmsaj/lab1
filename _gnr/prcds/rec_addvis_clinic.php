<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['t'])) {
    $t = pp($_POST['t']);
    echo biludWiz(1, $t);
?>
    <div class="fxg " fxg="gtc:1fr 4fr|gtc:1fr 3fr:1400|gtc:1fr 2fr:1100" fix="wp:0|hp:50">
        <div class="fl pd10f ofx so">
            <input type="text" placeholder="<?= k_search_clinics ?>" srcClin />
            <div class="recClcType" actButt="act"><?
                                                    echo '<div class="f1 fs12" t="0" act>' . k_all_deps . '</div>';
                                                    if (proAct('cln')) {
                                                        echo '<div class="f1 fs12" t="1" style="border-' . $align . '-color:' . $clinicTypesCol[1] . '">' . k_clinics . '</div>';
                                                    }
                                                    if (proAct('lab') && $t == 1) {
                                                        echo '<div class="f1 fs12" t="2" style="border-' . $align . '-color:' . $clinicTypesCol[2] . '">' . k_thlab . '</div>';
                                                    }
                                                    if (proAct('xry')) {
                                                        echo '<div class="f1 fs12" t="3" style="border-' . $align . '-color:' . $clinicTypesCol[3] . '">' . k_xray . '</div>';
                                                    }
                                                    if (proAct('den')) {
                                                        echo '<div class="f1 fs12" t="4" style="border-' . $align . '-color:' . $clinicTypesCol[4] . '">' . k_dentistry . '</div>';
                                                    }
                                                    if (proAct('bty')) {
                                                        echo '<div class="f1 fs12" t="5" style="border-' . $align . '-color:' . $clinicTypesCol[5] . '">' . k_beauty . '</div>';
                                                    }
                                                    if (proAct('osc')) {
                                                        echo '<div class="f1 fs12" t="7" style="border-' . $align . '-color:' . $clinicTypesCol[7] . '">' . k_endoscopy . '</div>';
                                                    } ?>
            </div>
        </div>
        <div class="fl pd10f ofx so cbg444 l_bord"><?
                                                    $sql = "select * from gnr_m_clinics where act=1 and type NOT IN (2) and linked=0 order by type ASC , ord ASC";
                                                    if ($t == 1) {
                                                        if (_set_p7svouhmy5) {
                                                            $serClinic = $_SESSION['po_clns'];
                                                        } else {
                                                            $serClinic = get_val('_users', 'subgrp', $thisUser);
                                                        }
                                                        $x_clinic = get_vals('gnr_x_arc_stop_clinic', 'clic', "e_date=0", 'arr');
                                                        $res = mysql_q($sql);
                                                        $rows = mysql_n($res);
                                                        if ($rows > 0) {
                                                            while ($r = mysql_f($res)) {
                                                                $clic = $r['clic'];
                                                                array_push($x_clinic, $clic);
                                                            }
                                                        }
                                                        /***********************************************************************/
                                                        $sql = "select * from gnr_m_clinics where act=1 and linked =0 order by type ASC , ord ASC";
                                                    }

                                                    $res = mysql_q($sql);
                                                    $rows = mysql_n($res);
                                                    if ($rows > 0) {
                                                        $act_type = 0;
                                                        $den_type = 0;
                                                        echo '<section class="cliBlc fxg" fxg="gtbf:220px|gap:10px">';
                                                        while ($r = mysql_f($res)) {
                                                            $c_id = $r['id'];
                                                            $name = $r['name_' . $lg];
                                                            $photo = $r['photo'];
                                                            $type = $r['type'];
                                                            $ph_src = '';
                                                            if ($photo) {
                                                                $ph_src = viewImage($photo, 1, 50, 50, 'img', 'sys/clinic30.png');
                                                            }
                                                            /****************************/
                                                            $xClnTxt = '';
                                                            $xClr = '';
                                                            $action = ' c="' . $c_id . '" ';
                                                            if ($t == 1) {
                                                                if ($actVisClinic[$c_id]['n']) {
                                                                    $xClnTxt = ' <span class="ff B fs14">( ' . clockStr($actVisClinic[$c_id]['t'], 0) . ' 
                            <span class="ff B fs14">/ ' . $actVisClinic[$c_id]['n'] . ' )</span>';
                                                                }
                                                                if ($type == 4) {
                                                                    $teethClin = 1;
                                                                    $name = k_dentistry;
                                                                }
                                                                $x_style = '';
                                                                if (in_array($c_id, $x_clinic)) {
                                                                    $xClr = ' cbg555 ';
                                                                    $action = '';
                                                                    $xClnTxt = '<div class="clr5 f1 fs12 pd10">' . k_clnc_clsd . '</div>';
                                                                } else {
                                                                    $xClnTxt = '';
                                                                }
                                                                if ($x_style == 0) {
                                                                    if (checkWorkingClinic($c_id) == 0) {
                                                                        $x_style = 2;
                                                                    }
                                                                }
                                                            } else {
                                                                $clns = getAllLikedClinics($c_id, ',');
                                                                if ($type == 4) {
                                                                    $clns = get_vals('gnr_m_clinics', 'id', " type=4 and act=1");
                                                                }
                                                                $xClnTxt = checkFreeTimeToday($clns);
                                                            }
                                                            /****************************/
                                                            if ($type != 4 || ($type == 4 && $den_type == 0)) {
                                                                if ($act_type != $type) {
                                                                    $act_type = $type;
                                                                    if ($type == 4) {
                                                                        $den_type = 1;
                                                                    }
                                                                }
                                                                $partType = $type;
                                                                if ($type == 6) {
                                                                    $partType = 5;
                                                                }
                                                                $blc = '
                        <div class="' . $xClr . ' " style="border-' . $align . ':5px ' . $clinicTypesCol[$type] . ' solid" t="' . $partType . '" tv="' . $type . '" s="x' . $x_style . '" ' . $action . ' Ctxt="' . $name . '" >
                        <div class="fl" i>' . $ph_src . '</div>	
                        <div class="fl" >
                            <div class="fs14 f1 lh40 clr1111" n>' . $name . '</div>' . $xClnTxt . '
                        </div>
                        </div>';

                                                                echo $blc;
                                                            }
                                                        }
                                                        echo '</section>';
                                                    } ?>
        </div>
    </div>
<?
} ?>