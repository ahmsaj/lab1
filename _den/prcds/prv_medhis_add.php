<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['id'], $_POST['vis'], $_POST['pat'])) {
    $id = pp($_POST['id']);
    $vis = pp($_POST['vis']);
    $pat = pp($_POST['pat']);
    $r = getRec('den_x_visits', $vis);
    if ($r['r']) {
        $status = $r['status'];
        if ($status == 1) { ?>
            <div class="h100 fxg " fxg="gtc:minmax(200px,1fr) 2fr">
                <div class="of fxg h100 r_bord cbg444" fxg="gtr:40px 40px 40px 1fr">
                    <div><input type="text" class="cbg44454" placeholder="<?= k_search ?>" id="his_src" /></div>
                    <div class="fl w100 cbg4 "><?
                                                $options = '';
                                                $sql = "select * from  cln_m_medical_his_cats order by ord ASC";
                                                $res = mysql_q($sql);
                                                $rows = mysql_n($res);
                                                if ($rows > 0) {
                                                    while ($r = mysql_f($res)) {
                                                        $id = $r['id'];
                                                        $catname = $r['name_' . $lg];
                                                        $options .= '<option  value="' . $id . '">' . $catname . '</option>';
                                                    }
                                                } ?>
                        <select class="cbg4" id="addCat" t>
                            <option value="0"><?= k_all_cats ?></option><?= $options ?>
                        </select>
                    </div>
                    <div class="fl  lh40 cbg666 t_bord  f1">
                        <div class="fl lh40  f1" id="his_ItTot"></div>
                        <div class="fr i30 i30_add mg5f" addHisNItDen title="<?= k_add_new_item ?>"></div>
                    </div>
                    <div class="fl ofx so pd10f prvHislistDen t_bord" id="his_ItData"></div>
                    <?
                    ?>
                </div>
                <div class="pd10f" id="denHsform">
                    <div class="f1 fs14 clr55 cbg555 br5 bord pd10f"><?= k_can_search_list ?></div>
                </div>
            </div>
<?
        } else {
            echo '<div class="f1 fs14 clr5 lh40 pd10f ">' . k_visit_ended . '</div>';
        }
    }
} ?>