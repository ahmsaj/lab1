<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['id'])) {
    $id = pp($_POST['id']); ?>
    <div class="fxg h100" fxg="gtc:200px 1fr|gtr:40px 1fr">
        <div class=" b_bord TC lh40 f1 fs14 r_bord "><?= k_clinics ?></div>
        <div class=" lh40 cbg4 ">
            <input type="text" placeholder="<?= k_search_today_appo ?>" class="cbgw" id="dDsrc" />
        </div>
        <div class="r_bord h100 ofx so pd10f clnLis" actButt="act"><?
                                                                    $clinics = get_vals('dts_x_dates_temp', 'clinic');
                                                                    if ($clinics) {
                                                                        $sql = "select id,name_$lg from gnr_m_clinics where id IN($clinics) order by ord";
                                                                        $res = mysql_q($sql);
                                                                        $rows = mysql_n($res);
                                                                        if ($rows) {
                                                                            $act = '';
                                                                            if ($id == 0) {
                                                                                $act = 'act';
                                                                            }
                                                                            echo '<div c="0" ' . $act . '>' . k_alclincs . '</div>';
                                                                            while ($r = mysql_f($res)) {
                                                                                $c_id = $r['id'];
                                                                                $name = $r['name_' . $lg];
                                                                                $act = '';
                                                                                if ($c_id == $id) {
                                                                                    $act = 'act';
                                                                                }
                                                                                echo '<div c="' . $c_id . '" ' . $act . '>' . $name . '</div>';
                                                                            }
                                                                        }
                                                                    } ?>
        </div>
        <div class="ofx so pd10 cbg4" datCLis></div>
    </div>
<?
} ?>