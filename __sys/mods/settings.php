<? include("../../__sys/mods/protected.php");
$q = "where pro IN($proActStr) ";
if ($thisGrp != 's') {
    $q .= " and admin=1 ";
}
$sql = "select * from _settings $q order by ord ASC";
$res = mysql_q($sql);
$rows = mysql_n($res);
?>
<div class="centerSideInFull of">
    <div class="fxg h100" fxg="gtc:280px 1fr|gtr:53px 1fr">
        <div class="f1 fs18 clr2 lh50 b_bord r_bord pd10"><?= k_set_cat ?></div>
        <div class="f1 fs18 clr2 lh50 b_bord pd10">
            <div class="fr ic40x ic40_save icc2 mg5v" onclick="sub('setForm')" title="<?= k_save ?>"></div><?= k_set_items ?>
        </div>
        <div class="ofx so pd10f setCat r_bord" actButt="act">
            <?
            if ($thisGrp == 's') {
                echo '<div class="f1 fs16 lf20 pd10f cbg44" onclick="selSetCat(\'sys\')">' . k_sys_pro . '</div>';
            }
            $sql2 = "select * from _programs where  act =1 order by ord ASC";
            $res2 = mysql_q($sql2);
            while ($r2 = mysql_f($res2)) {
                $code = $r2['code'];
                $name = $r2['name_' . $lg];
                $act = '';
                if ($code == 'gnr') {
                    $act = 'act';
                }
                echo '<div class="f1 fs16 lf20 pd10f cbg44" ' . $act . ' onclick="selSetCat(\'' . $code . '\')">' . $name . '</div>';
            }
            ?>
        </div>
        <div class="ofx so pd10f">
            <form name="setForm" id="setForm" action="<?= $f_path ?>S/sys_setting_save.php" method="post" class="pd0">
                <input type="hidden" name="_set_" value="10" /><?
                                                                if ($rows > 0) {
                                                                ?><table border="0" cellspacing="0" cellpadding="4" class="fTable setTab"><?
                                                                                                                                            while ($r = mysql_f($res)) {
                                                                                                                                                $id = $r['id'];
                                                                                                                                                $name = $r['set_' . $lg];
                                                                                                                                                $note = $r['note_' . $lg];
                                                                                                                                                $type = $r['type'];
                                                                                                                                                $code = $r['code'];
                                                                                                                                                $val = $r['val'];
                                                                                                                                                $defult = $r['defult'];
                                                                                                                                                $pars = $r['pars'];
                                                                                                                                                $required = $r['required'];
                                                                                                                                                $pro = $r['pro'];
                                                                                                                                                $admin = $r['admin'];
                                                                                                                                                if (!$admin) {
                                                                                                                                                    $pro = 'sys';
                                                                                                                                                }
                                                                                                                                                $req = '';
                                                                                                                                                if ($required) {
                                                                                                                                                    $req = ' required ';
                                                                                                                                                }
                                                                                                                                                if ($type != 0) { ?>
                                <tr pro="<?= $pro ?>">
                                    <td width="250">
                                        <div class="f1 fs14 ws "><?= splitNo($name) ?> :</div>
                                    </td>
                                    <td class=""><?
                                                                                                                                                    $val = str_replace('"', "'", $val);
                                                                                                                                                    switch ($type) {
                                                                                                                                                        case 1:
                                                                                                                                                            echo '<input name="set_' . $code . '" type="text" value="' . $val . '" ' . $req . ' />';
                                                                                                                                                            break;
                                                                                                                                                        case 2:
                                                                                                                                                            echo '<input name="set_' . $code . '" type="text" value="' . $val . '" ' . $req . ' class="Date" />';
                                                                                                                                                            break;
                                                                                                                                                        case 3:
                                                                                                                                                            $ch = '';
                                                                                                                                                            if ($val == 1) {
                                                                                                                                                                $ch = " checked ";
                                                                                                                                                            }
                                                                                                                                                            echo '<input name="set_' . $code . '" value="1" type="checkbox" ' . $ch . '><div class="cb"></div>';
                                                                                                                                                            break;
                                                                                                                                                        case 4:
                                                                                                                                                            //echo imageUp("set_".$id,$val,1);
                                                                                                                                                            echo imageUpN($id, "set_" . $code, $code, $val, $required);
                                                                                                                                                            break;
                                                                                                                                                        case 5:
                                                                                                                                                            if ($pars) {
                                                                                                                                                                $p = explode('|', $pars);
                                                                                                                                                                $table = $p[0];
                                                                                                                                                                $c_id = $p[1];
                                                                                                                                                                $column = convLangCol($p[2]);
                                                                                                                                                                $con = $p[3];
                                                                                                                                                                $multi = $p[4];
                                                                                                                                                                if ($multi != 1) {
                                                                                                                                                                    $multi = 0;
                                                                                                                                                                }
                                                                                                                                                                $data_rows = array();
                                                                                                                                                                if ($con) {
                                                                                                                                                                    $con = " WHERE $con ";
                                                                                                                                                                }
                                                                                                                                                                $sql2 = "select $c_id,$column from $table $con order by $column ";
                                                                                                                                                                $res2 = mysql_q($sql2);
                                                                                                                                                                $rows2 = mysql_n($res2);
                                                                                                                                                                if ($rows2 > 0) {
                                                                                                                                                                    $ii = 0;
                                                                                                                                                                    while ($r2 = mysql_f($res2)) {
                                                                                                                                                                        $c_id2 = $r2[$c_id];
                                                                                                                                                                        $column2 = $r2[$column];
                                                                                                                                                                        $data_rows[$ii] = array('val' => $c_id2, 'name' => $column2);
                                                                                                                                                                        $ii++;
                                                                                                                                                                    }
                                                                                                                                                                }
                                                                                                                                                                echo selelectOrradio('set', 'set_' . $code, $data_rows, $val, $required, 0, '', $multi);
                                                                                                                                                            }
                                                                                                                                                            break;
                                                                                                                                                        case 8:
                                                                                                                                                            echo upFile("set_" . $code, $val, 1);
                                                                                                                                                            break;
                                                                                                                                                        case 6:
                                                                                                                                                            echo '<select name="set_' . $code . '" >';
                                                                                                                                                            if (!$required) {
                                                                                                                                                                echo '<option value=""></option>';
                                                                                                                                                            }
                                                                                                                                                            $list = explode(',', $pars);
                                                                                                                                                            foreach ($list as $li) {
                                                                                                                                                                $li_data = explode(':', $li);
                                                                                                                                                                $ch = '';
                                                                                                                                                                if ($val == $li_data[0]) {
                                                                                                                                                                    $ch = " selected ";
                                                                                                                                                                }
                                                                                                                                                                echo '<option value="' . $li_data[0] . '" ' . $ch . '>' . get_key($li_data[1]) . '</option>';
                                                                                                                                                            }
                                                                                                                                                            echo '</select>';
                                                                                                                                                            break;
                                                                                                                                                        case 7:
                                                                                                                                                            echo '<textarea class="w100" name="set_' . $code . '">' . $val . '</textarea>';
                                                                                                                                                            break;
                                                                                                                                                    }
                                                    ?>
                                        <div class="fs12 f1 lh30 clr1111 fl"><?= splitNo($note) ?></div>
                                    </td>
                                </tr><?
                                                                                                                                                }
                                                                                                                                            }
                                        ?>
                    </table><?
                                                                } ?>
            </form>
        </div>
    </div>

    <script>
        setupForm('setForm', '');
        loadFormElements('#setForm');
        selSetCat('gnr');
    </script>
</div><?
        ?>