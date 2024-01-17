<? include("../../__sys/mods/protected.php"); ?>
<?
$time = 3600 * 24; //24 ساعة لحذف العمليات العالقة
mysql_q("delete from gnr_x_temp_oprs where $now-date>$time");
$time = 3600 * 1; //1 ساعة لحذف المواعيد العالقة
mysql_q("delete from dts_x_dates where $now-date>$time and status=0");
?>
<div class="recOprWin h100 r_bord" fix="wp:0|hp:0">
    <div h>
        <div class="fl f1 fs16 pd10 rwTitle"></div>
        <div class="fr ic30 ic30_x icc2 mg10f " closeWin></div>
    </div>
    <div class="fl of rwBody" fix="wp:0|hp:51"></div>
</div>
<div class="centerSideInFull of fxg" fxg="gtc:200px 1fr 280px|gtr:100%|gtc:200px 1fr 200px:1100|gtc:50px 1fr 200px:800">
    <div class="h100 r_bord cbg2 fxg" fxg="gtr:auto 31px|gtr:auto 100px:800">
        <div class="ofx so">
            <div class="recTabs" actButt="act">
                <div v act>
                    <div></div><?= k_operations ?>
                </div>
                <? if (proAct('dts')) { ?><div d>
                        <div></div><?= k_appointments
                                    ?>
                    </div><? } ?>
            </div>
            <div class="addRecOpr">
                <div d><?= k_new_appoi ?></div>
                <div v><?= k_new_visit ?></div>
            </div>
            <div class="of recOprs">
                <? if (proAct('dts')) { ?><div t="dates"><?= k_today_appo ?></div><? } ?>
                <? if (proAct('den')) { ?><div t="acount"><?= k_account_stats ?></div><? } ?>
                <? if (modPer('b8kpe202f3', '0')) { ?><div t="docs"><?= k_documents ?></div><? } ?>
                <? if (_set_9iaut3jze) { ?><div t="offer"><?= k_offers ?></div><? } ?>
                <? if (_set_m1hizmddit) { ?><div t="lab"><?= k_ana_requests ?></div><? } ?>
                <? if (_set_f59o2tik4f) { ?><div t="xry"><?= k_xray_orders ?></div><? } ?>
                <div t="visits"><?= k_patients_visits ?></div>
                <div t="time"><?= k_schdl_wrk ?></div>
                <div t="role"><?= k_role_info ?></div>
            </div>
        </div>
        <div class=" recStatus w100">
            <div i m></div>
            <div v boxInc HhB="0bd25">0</div>
            <div i p></div>
            <div v patsN HhB="a3mcw">0</div>
        </div>
    </div>
    <div class="fxg of" fxg="gtr:50px 1fr 33px">
        <div class="fl lh50 b_bord">
            <div class="fl recMaTitle lh50 pd10 f1 fs16 "></div>
            <? if (_set_tauv8g02) {
                if ($thisGrp == 'pfx33zco65') {
                    $po_name = $_SESSION['pos_name'];
                    if (!$po_name) {
                        $po_name = k_site_sel;
                    } ?>
                    <div class="fr ic40x mg5f br0 ic40Txt icc33 ic40_loc" recPos="0" locAct><?= $po_name ?></div>
            <? }
            } ?>
        </div>
        <div class="fl recMaCont ofx so"></div>
        <div class="fl lh40 cbg4 t_bord ofx so">
            <div class="notsTab" bi="1">
                <div class="fl f1" s11><?= k_new_visits ?></div>
                <div class="fl f1" s12><?= k_new_appo ?></div>
                <div class="fl f1" s13><?= k_ins_request ?></div>
                <div class="fl f1" s14><?= k_chr_rq ?></div>
                <div class="fl f1" s15><?= k_req_exmp ?> </div>
                <div class="fl f1" s16><?= k_tst_req ?></div>
                <div class="fl f1" s17><?= k_xry_order ?></div>
            </div>
            <div class="notsTab hide" bi="2">
                <div class="fl f1" s1><?= k_not_attend ?></div>
                <div class="fl f1" s2><?= k_attended ?></div>
                <div class="fl f1" s5><?= k_wait_to_enter ?></div>
                <div class="fl f1" s6><?= k_late_entry ?></div>
                <div class="fl f1" s3><?= k_in_ser ?></div>
                <div class="fl f1" s4><?= k_service_done ?></div>
            </div>
        </div>

    </div>

    <div class="fxg of" fxg="gtr:50px 1fr">
        <div class="ticketIn b_bord">
            <div class="fl loaderT "></div>
            <input type="text" ticketIn placeholder="<?= k_ent_tik_num ?>" fix="wp:50" dir="ltr" />
        </div>
        <div class="ofx so cbg4 alertSec pd10f"></div>
    </div>
    <div class="notsTab hide" bi="2">
        <div class="fl f1" s1><?= k_not_attend ?></div>
        <div class="fl f1" s2><?= k_attended ?></div>
        <div class="fl f1" s5><?= k_wait_to_enter ?></div>
        <div class="fl f1" s6><?= k_late_entry ?></div>
        <div class="fl f1" s3><?= k_in_ser ?> </div>
        <div class="fl f1" s4><?= k_service_done ?></div>
    </div>
</div>
</div>
<div class="fxg of" fxg="gtr:50px 1fr">
    <div class="ticketIn b_bord">
        <div class="fl loaderT "></div>
        <input type="text" ticketIn placeholder="<?= k_ent_tik_num ?>" fix="wp:50" dir="ltr" />
    </div>
    <div class="ofx so cbg4 alertSec pd10f"></div>
</div>

</div>
<script>
    sezPage = 'RespNew';
</script>