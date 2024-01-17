<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['id'])) {
    $id = pp($_POST['id']);
    $r = getRec('api_x_promotion', $id);
    if ($r['r']) {
        $msg_title = $r['msg_title'];
        $msg_desc = $r['msg_desc'];
        $title = $r['title'];
        $body = $r['body'];
        $url = $r['url'];
        $url_text = $r['url_text'];
        $photo = $r['photo'];
        $audience = $r['audience'];
        $status = $r['status'];
        $cat = $r['cat'];

        $sex = 0;
        $age_from = '';
        $age_to = '';
        $areas_sel = [];
        $b_date = date('Y-m-d');

        if ($audience) {
            $audience_arr = json_decode($audience, true);
            $age_from = $audience_arr['age_from'];
            $age_to = $audience_arr['age_to'];
            $b_date = $audience_arr['b_date'];
            if ($audience_arr['area']) {
                $areas_sel = explode(',', $audience_arr['area']);
            }
        }
        if ($status < 3) {
            $areas = get_arr('gnr_m_areas', 'id', 'name');
?>

            <div class="win_body">
                <div class="form_body of" type="pd0">
                    <div class="fxg h100" fxg="gtc:1fr 1fr">
                        <div class="pd20f r_bord h100 ofx so" style="background-color: #eee">
                            <div class="pd20b">
                                <div class="f1 lh30 fs14"><?= k_sex ?></div>
                                <select id="sex" t>
                                    <option value="0"><?= k_both_sex ?></option>
                                    <option value="1" <? if ($sex == 1) {
                                                            echo 'selected';
                                                        } ?>><?= k_male ?></option>
                                    <option value="2" <? if ($sex == 2) {
                                                            echo 'selected';
                                                        } ?>><?= k_female ?></option>
                                </select>
                            </div>
                            <? if ($cat == 2) { ?>
                                <div class="pd20b">
                                    <div class="f1 lh30 fs14">يوم الميلاد</div>
                                    <div>
                                        <div>
                                            <input type="text" class="Date" id="b_date" placeholder="<?= k_birth_day ?>" value="<?= $b_date ?>" />
                                        </div>
                                    </div>
                                </div>
                            <? } else { ?><input class="hide" id="b_date" value="0" /><? } ?>
                            <div class="pd20b">
                                <div class="f1 lh30 fs14"><?= k_age ?></div>
                                <div class="fxg" fxg="gtc:1fr 1fr|gap:10px">
                                    <div>
                                        <input type="number" id="age_from" placeholder="<?= k_from ?>" value="<?= $age_from ?>" />
                                    </div>
                                    <div>
                                        <input type="number" id="age_to" placeholder="<?= k_to ?>" value="<?= $age_to ?>" />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="f1 lh30 fs14">المناطق</div>
                                <select name="area[]" t1 sel2m id="area" multiple>
                                    <? foreach ($areas as $id => $name) {
                                        $sel = '';
                                        if (in_array($id, $areas_sel)) {
                                            $sel = ' selected ';
                                        }
                                        echo '<option value="' . $id . '" ' . $sel . '>' . $name . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="ic40 ic40_search ic40Txt icc4 mg20v" onclick="viwaUdience()"><?= k_search ?></div>
                        </div>
                        <div class="pd20f h100 ofx so " id="udienceRes">
                            ---
                        </div>
                    </div>
                </div>
                <div class="form_fot fr ">
                    <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info');"><?= k_close ?></div>
                </div>
            </div><?
                }
            }
        } ?>