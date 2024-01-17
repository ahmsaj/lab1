<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['id'])) {
    $id = pp($_POST['id']);
    $conf = pp($_POST['conf']);
    $r = getRec('dts_x_dates', $id);
    if ($r['r']) {
        $c = $r['clinic'];
        $pat = $r['patient'];
        $doc = $r['doctor'];
        $mood = $r['type'];
        $d_start = $r['d_start'];
        $d_end = $r['d_end'];
        $c = $r['clinic'];
        $status = $r['status'];
        if ($status < 2) {
            $docName = get_val('_users', 'name_' . $lg, $doc);
            if ($pat && $conf == 1) {
                echo 1;
                exit;
            }
            list($name, $photo, $mood) = get_val('gnr_m_clinics', 'name_' . $lg . ',photo,type', $c);
            $ph_src = '';
            if ($photo) {
                $ph_src = viewImage($photo, 1, 30, 30, 'img', 'clinic.png');
            }
            $srvs = get_vals('dts_x_dates_services', 'service', "dts_id='$id'");
            if ($mood == 4) {
                $price = 0;
                $timeN = get_val_c('dts_x_dates_services', 'ser_time', $id, 'dts_id');
            } else {
                list($timeN, $price) = get_docTimePrice($doc, $srvs, $mood);
            }
            echo biludWiz(4, 2); ?>
            <div class="fl of fxg" fxg="gtc:220px 200px 1fr" fix="wp:0|hp:50">
                <div class="fl pd10 ofx so"><?
                                            if ($p_type == 1) {
                                                $r = getRec('gnr_m_patients', $pat);
                                                if ($r['r']) {
                                                    $photo = $r['photo'];
                                                    $sex = $r['sex'];
                                                    $title = $r['title'];
                                                    $mobile = $r['mobile'];
                                                    $birth_date = $r['birth_date'];
                                                    $birthCount = birthCount($birth_date);
                                                    $bdTxt = '<div class="f1 clr5 fs12 lh30">' . k_age . ' : <ff14 class="clr5">' . $birthCount[0] . '</ff14> <span class="clr5 f1">' . $birthCount[1] . '</span></div>';
                                                    $titles = modListToArray('czuwyi2kqx');
                                                    $patPhoto = viewPhotos_i($photo, 1, 40, 60, 'css', 'nophoto' . $sex . '.png');
                                                    $pName = $titles[$title] . ' : ' . $r['f_name'] . ' ' . $r['ft_name'] . ' ' . $r['l_name']; ?>
                            <div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
                                <script>
                                    actNVPat = <?= $pat ?>
                                </script>
                                <div class="fl pd5"><?= $patPhoto ?></div>
                                <div class="fl pd10f">
                                    <div class="lh20 f1 fs14 clr1111 Over" editPat="dts"><?= $pName ?>
                                        <br>
                                        <ff14><?= $mobile ?></ff14>
                                    </div>
                                    <div class=" lh20 f1 fs14 clr1"><?= $bdTxt ?></div>
                                </div>
                            </div><?
                                                }
                                            } else {
                                                $r = getRec('dts_x_patients', $pat);
                                                if ($r['r']) {
                                                    $pName = $r['f_name'] . '  ' . $r['l_name']; ?>
                            <div class="lh20 f1 fs16 clr1111 lh40 uLine"><?= $pName ?></div><?
                                                                                        }
                                                                                    } ?>
                    <div class="fl w100 uLine pd5v fxg" fxg="gtc:30px 1fr 30px">
                        <div class="fl lh30 " fix="h:30"><?= $ph_src ?></div>
                        <div class="fl fs14 lh30 f1 fs12 pd10 "><?= k_clinic . ' : ' . $name ?></div>
                    </div>
                    <div class="f1 fs14 lh30"><?= k_dr . ' : ' . $docName ?></div>
                    <div class="f1 fs14 lh30 "><?= k_duration_appoint ?>: <ff class="clr5"><?= $timeN ?></ff> <?= k_minute ?></div>
                    <div class="f1 fs14 lh30 "> <?= k_val_srvs ?> : <ff class="clr5"><?= number_format($price) ?></ff>
                    </div><?
                            $prvPayments = DTS_PayBalans($id);
                            if ($prvPayments) { ?>
                        <div class="f1 fs14 lh30"><?= k_pre_pay ?>: <ff class="clr6"><?= number_format($prvPayments) ?></ff>
                        </div><?
                            } ?>
                    <div class="f1 fs14 lh30 cbg666 pd10f br5 mg10v">
                        <div class="f1 fs14 lh30 "><?= $wakeeDays[date('w', $d_start)] . ': <ff>' .    date('d', $d_start) . '</ff> - ' . $monthsNames[date('n', $d_start)] . ' - <ff>' . date('Y', $d_start) . '</ff>';
                                                    $s_h = date('A h:i', $d_start);
                                                    $e_h = date('A h:i', $d_end); ?>
                        </div>
                        <div class="f1 fs14 lh30 "><?= k_thhour ?>: <?= '<ff  class="clr55"> ' . $s_h . '</ff>' ?></div>
                    </div>
                </div>
                <div class="of cbg4 l_bord fxg pd10" fxg="gtr:40px 1fr ">
                    <div class="f1 fs14 lh40 b_bord w100 "><?= k_sr_pa ?></div>
                    <div class="ofx so">
                        <?= patForm() ?>
                    </div>
                </div>
                <div class="of cbg444 l_bord fxg " fxg="gtr:1fr 50px">
                    <div class="ofx so pd10" patList>
                        <script>
                            actNVClinic = <?= $c ?>;
                            actClanType = <?= $mood ?>;
                        </script>
                    </div>
                    <div class="cbg4 t_bord">
                        <div class="fl ic50_del icc2 wh50" dtsDel title="<?= k_delete ?>"></div>
                        <div class="fl ic50_back icc1 flip wh50" dtsBackTime="<?= $doc ?>" title="<?= k_back ?>"></div>
                    </div>
                </div>
            </div><?
                } else {
                    echo '<div class="f1 fs16 clr5 lh50 pd20f">' . k_appo_cannot_edited . '</div>';
                    delTempOpr(0, $id, 9);
                }
            } else {
                delTempOpr(0, $id, 9);
            }
        } ?>