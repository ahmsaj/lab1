<? include("../../__sys/mods/protected.php"); ?>
<div class="centerSideInFull of">
    <div class="fxg h100" fxg="gtc:minmax(200px , 1fr) minmax(250px , 1.5fr) 2.5fr|gtr:auto 1fr 40px">
        <div class="r_bord b_bord f1 lh50 pd10 fs14 cbg4"><?= k_sr_pa ?></div>
        <div class="r_bord b_bord cbg444 f1 lh50 pd10 pd5r fs14 cbg4">
            <div class="fr i30 i30_res icc122 mg10v mg5" title="<?= k_refresh ?>" id="mainKistRef"></div><? k_prescs_list ?>
            <span id="pr_total" class="fs14">(0)</span>
        </div>
        <div class="b_bord f1 lh50 pd10 fs14">
            <div class="fr pd10v hide" id="pr_actions">
                <div class="fr ic30 ic30Txt ic30_send icc22" givePres><?= k_dis_the_pre ?></div>
                <div class="fr ic30 ic30Txt ic30_print icc11 mg10" printPres><?= k_print_pres ?></div>
            </div>
            <?= k_prescription_details ?>
        </div>
        <div class="r_bord cbg4 pd10f ofx so" fxg="grs:2" id="patForm">
            <div class="f1 mg5b"><?= k_pres_status ?>:</div>
            <div class="mg10b">
                <select type="number" name="type">
                    <option value="1"><?= k_untreated_pres ?></option>
                    <option value="2"><?= k_printed_pres ?></option>
                    <option value="3"><?= k_all_pres ?></option>
                </select>
            </div>
            <div class="f1 mg5b"><?= k_pres_time ?>:</div>
            <div class="mg10b">
                <select type="number" name="time">
                    <option value="1"><?= k_pres_today_only ?></option>
                    <option value="2"><?= k_month_ago ?></option>
                    <option value="3"><?= k_all_pres ?></option>
                </select>
            </div>
            <div class="f1 mg5b"><?= k_pat_num ?>:</div>
            <div class="mg10b"><input type="number" name="no" /></div>

            <div class="f1 mg5b"><?= k_name ?>:</div>
            <div class="mg10b"><input type="text" name="name" /></div>

            <div class="f1 mg5b"><?= k_l_name ?>:</div>
            <div class="mg10b"><input type="text" name="l_name" /></div>

            <div class="f1 mg5b"><?= k_fth_name ?>:</div>
            <div class="mg10b"><input type="text" name="father" /></div>

            <div class="f1 mg5b"><?= k_mobile_num ?>:</div>
            <div class="mg10b"><input type="number" name="phone" /></div>
        </div>
        <div class="r_bord fxg cbg444 pd10f ofx so" fxg="grs:2">
            <div id="per_list"></div>
        </div>
        <div class="pd10f ofx so" id="per_info"></div>
        <div class="t_bord cbg4"></div>
    </div>
</div>