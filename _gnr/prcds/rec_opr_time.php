<? include("../../__sys/prcds/ajax_header.php");
$t = pp($_POST['t']);
$q = '';
$serTitle = k_sr_pa;
if ($t == 1) {
    $serTitle = k_find_doctor;
    $q = " and linked =0 ";
} ?>
<div class="fxg h100" fxg="gtc:200px 1fr|gtr:40px 1fr">
    <div class=" b_bord TC lh40 f1 fs14 r_bord "><? k_clinics ?></div>
    <div class=" lh40 cbg4 ">
        <input type="text" placeholder="<?= $serTitle ?>" class="cbgw" id="recOprsrc" />
    </div>
    <div class="r_bord h100 ofx so pd10f clnLis" actButt="act"><?
                                                                $clinics = get_vals('dts_x_dates_temp', 'clinic');
                                                                $sql = "select id,name_$lg from gnr_m_clinics where  act=1 $q order by ord";
                                                                $res = mysql_q($sql);
                                                                $rows = mysql_n($res);
                                                                if ($rows) {
                                                                    echo '<div cc="0" act>' . k_alclincs . '</div>';
                                                                    while ($r = mysql_f($res)) {
                                                                        $c_id = $r['id'];
                                                                        $name = $r['name_' . $lg];
                                                                        echo '<div cc="' . $c_id . '" >' . $name . '</div>';
                                                                    }
                                                                } ?>
    </div>
    <div class="ofx so pd10 cbg4" datCLis></div>
</div>