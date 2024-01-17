<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['mood'], $_POST['vis'])) {
    $vis = pp($_POST['vis']);
    $mood = pp($_POST['mood']);
    $vis_data = getRec($visXTables[$mood], $vis);
    if (_set_hgsa9kq373 && $vis_data['r']) {
        if (getTotalCo('gnr_x_nurses_rate', "mood=1 and vis='$v_id' ") == 0) {
?>
            <div class="winButts">
                <div class="wB_x fr" onclick="actCavOrd=0;win('close','#full_win1');"></div>
            </div>
            <div class="win_body" type="full">
                <div class="form_header so lh40 clr1 f1 fs18">
                    <div class="form_header so lh40 clr1 f1 fs18 pd10v">
                        <input type="text" class="mg10v" placeholder="<?= k_search ?>" nursSer />
                    </div>
                </div>
                <div class="form_body so ">
                    <div class="" nursList><?
                                            $sql = "select * from gnr_m_nurses where type='$mood' and act=1 order by name ASC";
                                            $res = mysql_q($sql);
                                            while ($r = mysql_f($res)) {
                                                echo '<div class="fl bord mg5f br5 Over2" fix="w:140" nursName="' . $r['name'] . '" nursNo="' . $r['id'] . '">
                                <div i class="br5 of">' . viewImage($r['photo'], 1, 140, 180, 'img', 'clinic.png') . '</div>
                                <div n class="f1 fs14 TC pd5f">' . $r['name'] . '</div>
                            </div>';
                                            } ?>
                    </div>
                    <div class="fl br5 cbgw pd5f cb">
                        <div class="fl w100 revStars hide">
                            <? for ($i = 1; $i < 6; $i++) {
                                echo '<div v="' . $i . '"><img src="../images/gnr/star.svg"/></div>';
                            } ?>
                            <div class="fl lh30 mg10 pd10">
                                <fn2 class="fs24 clr9" n>0.0</fn2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_fot fl">
                    <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0 hide" saveNRate><?= k_save ?></div>
                    <div class="fr ic40 ic40_x icc3 ic40Txt mg10f br0" cancelNRate><?= k_no_nurse ?></div>
                </div>
            </div><?
                }
            }
        } ?>