<? include("../../__sys/prcds/ajax_header.php");
//$thisGrp="x";echo '<div class="f1 fs14 lh40 clr5 pd20f">'.k_mntr_scr_psd.'</div>';exit;
//echo script('dashTime=300000;');
//fixWorkTime($vis,$mood);
$n = pp($_POST['n']);
$s = pp($_POST['s']);
$h = '';
if ($thisGrp == 's' && $s == 0) {
    $h = 'hide';
}
if ($thisGrp == 'vlfbm7eoi' || $thisGrp == 's') {
    $actArr = array();
    $actArr[$n] = 'act';
    echo '<div class="w100 rep_header fl uLine pd10 ' . $h . '" s>
        <div class="fl ' . $actArr[1] . '" onclick="dash(1,1);">' . k_fin_details . '</div>
        <div class="fl ' . $actArr[2] . '" onclick="dash(1,2);">' . k_pat_stat . '</div>
        <div class="fl ' . $actArr[3] . '" onclick="dash(1,3);">' . k_clinics . '</div>
    </div>^
    <div class="fl w100 ' . $h . '" s>';
    if ($n == 1) {
        $all_cash_net = get_sum('gnr_x_tmp_cash', 'amount_in-amount_out', " date >'$ss_day' ");
        list($viss, $srv_total, $srv_cash, $srv_total_done, $srv_cash_done) = get_sum('gnr_x_tmp_dash', 'vis,srv_total,srv_cash,srv_total_done,srv_cash_done', " date >'$ss_day' ");

        $textData = '';
        $sql = "select c_type,sum(srv_total)st , sum(srv_total_done) std from gnr_x_tmp_dash group by c_type order by st DESC";
        $res = mysql_q($sql);
        $pDataN = $pDataSt = $pDataStd = array();
        $i = 0;
        while ($r = mysql_f($res)) {
            $type = $r['c_type'];
            $srv_t = $r['st'];
            $srv_td = $r['std'];
            $pCode = $clinicCode[$type];
            $icon = get_val_c('_programs', 'icon', $pCode, 'code');
            $name = $clinicTypes[$type];
            $pDataN[$i] = $name;
            $pDataSt[$i] = $srv_t - $srv_td;
            $pDataStd[$i] = $srv_td;

            $ph_src = '';
            if ($icon) {
                $ph_src = viewImage($icon, 1, 80, 80, 'img', 'clinic.png');
            }
            $textData .= '
            <div class="fl biin" c_ord style="border-bottom-color:' . $clinicTypesCol[$type] . '">
                <div class="TC fsB clr5">' . number_format($srv_t) . '</div>
                <div class="TC fsB2 B clr6">' . number_format($srv_td) . '</div>
                <div class="f1 TC lh20 cbg777 t_bord">' . $name . '</div>
            </div>';
            $i++;
        } ?>
        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 "><?= k_center_stat ?></div>
            <div class="fl dashBlockIn" fix="h:330">
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_cash r_bord"></div>
                    <div num class="fl clr8" fix="wp:101"><?= number_format($all_cash_net) ?></div>
                    <div txt class="fl clr88 f1" fix="wp:101"><?= k_cash_total ?></div>
                </div>
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_srv r_bord"></div>
                    <div num class="fl clr5" fix="wp:101"><?= number_format($srv_total) ?></div>
                    <div txt class="fl clr55 f1" fix="wp:101"><?= k_over_per_center ?></div>
                </div>
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_srv_d r_bord"></div>
                    <div num class="fl clr6" fix="wp:101"><?= number_format($srv_total_done) ?></div>
                    <div txt class="fl clr66 f1" fix="wp:101"><?= k_total_ach_center ?></div>
                </div>
            </div>
        </div>

        <div class="dbi ">
            <div class="f1 fs18 clr1 TC lh30 "><?= k_sec_chart ?></div>
            <div class="fl dashBlockIn " fix="wp:0|h:330">
                <script>
                    fixPage();
                    $('#rep_container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: ''
                        },
                        xAxis: {
                            categories: ['<?= implode("','", $pDataN) ?>'],
                            labels: {
                                rotation: -45,
                                style: {
                                    fontFamily: 'f1,Verdana'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            },
                            labels: {
                                style: {
                                    fontSize: '14px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        tooltip: {
                            pointFormat: '<div>{point.y}<div>',
                            //shared: true,						
                        },
                        plotOptions: {
                            column: {
                                stacking: 'column'
                            }
                        },
                        series: [{
                                name: '<?= k_not_fini ?>',
                                data: [<?= implode(',', $pDataSt) ?>],
                                animation: false
                            },
                            {
                                name: '<?= k_finished ?>',
                                data: [<?= implode(',', $pDataStd) ?>],
                                animation: false
                            },

                        ],
                        colors: ['<?= $clr5 ?>', '<?= $clr6 ?>']
                    });
                </script>
                <div id="rep_container" class="rep_cont" fix="h:280" dir="ltr"></div>
            </div>
        </div>

        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 "><?= k_dep_status ?></div>
            <div class="fl dashBlockIn ofx so" fix="h:330|wp:0">
                <section w="120" m="15" c_ord class="cb"><?= $textData ?></section>
            </div>
        </div>
    <?

    }
    if ($n == 2) {
        $q = "d_start >='$ss_day' and d_start <$ee_day";
        $viss = get_sum('gnr_x_tmp_dash', 'vis', " date >'$ss_day' ");
        $dates = getTotalCO('dts_x_dates_temp', " $q ");
        $srv_total_wait = getTotalCO('gnr_x_roles', "status in(0,1,2) ");
        $d1 = getTotalCO('dts_x_dates_temp', "status in(2,3,4)");
        $d2 = getTotalCO('dts_x_dates_temp', "status in(5,6,7) or (status=1 AND d_start<$now )");
        $d3 = getTotalCO('dts_x_dates_temp', "status in(8) ");

        $r_st0 = getTotalCO('gnr_x_roles', "status=0 ");
        //$r_st1=getTotalCO('gnr_x_roles',"status=1 ");
        $r_st2 = getTotalCO('gnr_x_roles', "status=2 ");
        //$r_st3=getTotalCO('gnr_x_roles',"status=3 ");
        $r_st4 = getTotalCO('gnr_x_roles', "status=4 ");
        $allst = $r_st0 + $r_st1 + $r_st2 + $r_st3 + $r_st4;
    ?>
        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 "><?= k_vis_status ?></div>
            <div class="fl dashBlockIn" fix="h:330">
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_pat r_bord"></div>
                    <div num class="fl clr9" fix="wp:101"><?= number_format($viss) ?></div>
                    <div txt class="fl clr2 f1" fix="wp:101"><?= k_vis_no ?></div>
                </div>
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_appo r_bord"></div>
                    <div num class="fl clr5" fix="wp:101"><?= number_format($dates) ?></div>
                    <div txt class="fl clr55 f1" fix="wp:101"> <?= k_all_appoints ?></div>
                </div>

                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_wait r_bord"></div>
                    <div num class="fl clr8" fix="wp:101"><?= number_format($srv_total_wait) ?></div>
                    <div txt class="fl clr8 f1" fix="wp:101"><?= k_pres_patients ?></div>
                </div>
            </div>
        </div>
        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 "><?= k_appo_status ?></div>
            <div class="fl dashBlockIn" fix="h:330">
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_srv_d r_bord"></div>
                    <div num class="fl clr6" fix="wp:101"><?= number_format($d1) ?></div>
                    <div txt class="fl clr66 f1" fix="wp:101"><?= k_attended ?></div>
                </div>
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_xdate r_bord"></div>
                    <div num class="fl clr5" fix="wp:101"><?= number_format($d2) ?></div>
                    <div txt class="fl clr55 f1" fix="wp:101"><?= k_not_attend ?></div>
                </div>

                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_date2 r_bord"></div>
                    <div num class="fl clr8" fix="wp:101"><?= number_format($d3) ?></div>
                    <div txt class="fl clr88 f1" fix="wp:101"><?= k_late_attend ?></div>
                </div>
            </div>

        </div>
        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 "><?= k_role_status ?></div>
            <div class="fl dashBlockIn" fix="wp:0|h:330">
                <script type="text/javascript">
                    fixPage();
                    $('#rep_container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: ''
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                rotation: -45,
                                style: {
                                    fontFamily: 'f1,Verdana'
                                }
                            }
                        },
                        yAxis: {
                            title: {
                                text: '',
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '<span style="font-size:18px;>{point.y}</span>'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span>',
                            pointFormat: '<span style="color:{point.color}"></span>: <b>{point.y}</b>'
                        },

                        series: [{
                            name: k_nums,
                            colorByPoint: true,
                            data: [{
                                    name: <?= k_wting ?>,
                                    y: <?= $r_st0 ?>
                                },
                                /*{name :"مطلوب للخدمة",y:<?= $r_st1 ?>},*/
                                {
                                    name: "يؤدي الخدمة",
                                    y: <?= $r_st2 ?>
                                },
                                /*{name :"تم التخطي",y:<?= $r_st3 ?>},*/
                                {
                                    name: "منتهية",
                                    y: <?= $r_st4 ?>
                                }

                            ],
                            animation: false,
                        }],
                        //colors:['#ccc','#ea2f2f','#2a78c1','#ffff33','#3bbf34']
                        colors: ['#ccc', '#2a78c1', '#3bbf34']
                    });
                </script>
                <div id="rep_container" class="rep_cont" fix="h:280" dir="ltr"></div>
            </div>
        </div>

    <?
    }
    if ($n == 3) {
        $sql = "select clinic,srv_total as st ,srv_total_done as std from gnr_x_tmp_dash order by st DESC";
        $res = mysql_q($sql);
        $pDataN = $pDataSt = $pDataStd = array();
        $i = 0;
        while ($r = mysql_f($res)) {
            $clinic = $r['clinic'];
            $srv_t = $r['st'];
            $srv_td = $r['std'];
            $name = get_val('gnr_m_clinics', 'name_' . $lg, $clinic);
            $pDataN[$i] = $name;
            $pDataSt[$i] = $srv_t - $srv_td;
            $pDataStd[$i] = $srv_td;
            $i++;
        } ?>
        <div class=" " fix="hp:20">
            <div class="f1 fs18 clr1 TC lh30 ">حالة العيادات</div>
            <div class="fl dashBlockIn " fix="wp:0|hp:10">
                <script>
                    fixPage();
                    $('#rep_container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: ''
                        },
                        xAxis: {
                            categories: ['<?= implode("','", $pDataN) ?>'],
                            labels: {
                                rotation: -45,
                                style: {
                                    fontFamily: 'f1,Verdana'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            },
                            labels: {
                                style: {
                                    fontSize: '14px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        tooltip: {
                            pointFormat: '{point.y}<br>',
                            //shared: true,						
                        },
                        plotOptions: {
                            column: {
                                stacking: 'column'
                            }
                        },
                        series: [{
                                name: 'غير منتهي',
                                data: [<?= implode(',', $pDataSt) ?>],
                                animation: false
                            },
                            {
                                name: 'منتهي',
                                data: [<?= implode(',', $pDataStd) ?>],
                                animation: false
                            },

                        ],
                        colors: ['<?= $clr5 ?>', '<?= $clr6 ?>']
                    });
                </script>
                <div id="rep_container" class="rep_cont" fix="hp:0" dir="ltr"></div>
            </div>
        </div>


    <?

    }
    echo '</div>';
} elseif ($thisGrp == 'hrwgtql5wk' || $thisGrp == 'vlfbm7eoi-') {
    $actArr = array();
    $actArr[$n] = 'act';
    echo '
	<div class="w100 rep_header fl uLine pd10">
        <div class="fl ' . $actArr[1] . '" onclick="dash(1,1);">الصناديق</div>
        <div class="fl ' . $actArr[2] . '" onclick="dash(1,2);">العيادات</div>
		<div class="fl ' . $actArr[3] . '" onclick="dash(1,3);">الحالة العامة</div>
    </div>^<div class="pd10">';
    $cashTable = 'gnr_x_tmp_cash';
    $dashTable = 'gnr_x_tmp_dash';
    if ($n == 1) {
        $d_s = $now - ($now % 86400);
        $d_e = $d_s + 86400;
        $all_cash_in = get_sum($cashTable, 'amount_in', " date >'$d_s' ");
        $all_cash_ou = get_sum($cashTable, 'amount_out', " date >'$d_s' ");
        $all_cash_net = $all_cash_in - $all_cash_ou;

        echo '
		<div class="fl cbg3 pd10 clrw f1 lh40 fs14 br5">' . k_tot_fund_mov . ' <ff> [ ' . number_format($all_cash_net) . ' ] </ff></div>
		<div class="w100 pd20v TC fxg" fxg="gtbf:180px|gap:10px">';
        foreach ($clinicTypes as $k => $v) {
            if (proAct($clinicCode[$k])) {
                $all = get_sum($dashTable, 'amount', " c_type=$k ");
                if ($all) {
                    echo '<div class="CMbg' . $k . ' clrw f1 lh40 fs14 br5 pd10v" > ' . $clinicTypes[$k] . ' <ff class="clrW"> | ' . number_format($all) . '</ff></div>';
                }
            }
        }
        if (_set_gypwynoss == 1) {
            $all_cards = get_sum($cashTable, 'card', '');
            if ($all_cards) {
                echo '<div class="cbg8 clrw f1 lh40 fs14 br5 pd10v"> البطاقات <ff class="clrw"> | ' . number_format($all_cards) . ' </ff></div>';
            }
        }
        if (_set_9iaut3jze == 1) {
            $all_offers = get_sum($cashTable, 'offer', '');
            if ($all_offers) {
                echo '<div class="cbg77 clrw f1 lh40 fs14 br5 pd10v"> العروض <ff class="clrw"> | ' . number_format($all_offers) . '</ff></div>';
            }
        }
        echo '</div>
		<div class="cb"></div>';

        $sql = "select u.id as uid , u.name_$lg ,x.* from _users u , $cashTable x where `grp_code` IN('buvw7qvpwq','pfx33zco65') and u.id=x.casher ";
        $res = mysql_q($sql);
        $rows = mysql_n($res);
        if ($rows > 0) {
            echo '<div class="in fxg cbg1 br10 bord pd20f" fxg="gtbf:240px|gap:10px">';
            while ($r = mysql_f($res)) {
                $u_id = $r['uid'];
                $pay_type = $r['pay_type'];
                $name = $r['name_' . $lg];
                $cash_in = $r['amount_in'];
                $cash_ou = $r['amount_out'];

                $a1_in = $r['a1_in'];
                $a1_out = $r['a1_out'];
                $a2_in = $r['a2_in'];
                $a2_out = $r['a2_out'];
                $a3_in = $r['a3_in'];
                $a3_out = $r['a3_out'];
                $a7_in = $r['a7_in'];
                $a7_out = $r['a7_out'];
                $a4_in = $r['a4_in'];
                $a4_out = $r['a4_out'];
                $a5_in = $r['a5_in'];
                $a5_out = $r['a5_out'];
                $a6_in = $r['a6_in'];
                $a6_out = $r['a6_out'];
                $card = $r['card'];
                $offer = $r['offer'];

                $cash_net = $cash_in - $cash_ou;
                $totTxt = '';

                $title = '';
                if (proAct('cln') && ($a1_in or $a1_out)) {
                    $title .= "<div> العيادات |   
                        <sapn class='clr6'>" . number_format($a1_in) . "</sapn>
                        <sapn class='clr5'>" . number_format($a1_out) . "</sapn>
                        <sapn class='clr1'>" . number_format($a1_in - $a1_out) . "</sapn>
                    </diiv>";
                }
                if (proAct('lab') && ($a2_in || $a2_out)) {
                    $title .= "<div> المخبر |  
                    <sapn class='clr6'>" . number_format($a2_in) . "</sapn>
                    <sapn class='clr5'>" . number_format($a2_out) . "</sapn>	
                    <sapn class='clr1'>" . number_format($a2_in - $a2_out) . "</sapn>
                    </div>";
                }
                if (proAct('xry') && ($a3_in || $a3_out)) {
                    $title .= "<div> الأشعة | 
                    <sapn class='clr6'>" . number_format($a3_in) . "</sapn>
                    <sapn class='clr5'>" . number_format($a3_out) . "</sapn>
                    <sapn class='clr1'>" . number_format($a3_in - $a3_out) . "</sapn>
                    </div>";
                }
                if (proAct('den') && ($a4_in || $a4_out)) {
                    $title .= "<div> الأسنان |  
                    <sapn class='clr6'>" . number_format($a4_in) . "</sapn>
                    <sapn class='clr5'>" . number_format($a4_out) . "</sapn>
                    <sapn class='clr1'>" . number_format($a4_in - $a4_out) . "</sapn>
                    </div>";
                }
                if (proAct('bty') && ($a5_in || $a5_out || $a6_in || $a6_out)) {
                    $title .= "<div> التجميل |  
                    <sapn class='clr6'>" . number_format($a5_in + $a6_in) . "</sapn>
                    <sapn class='clr5'>" . number_format($a5_out + $a6_out) . "</sapn>
                    <sapn class='clr1'>" . number_format($a5_in + $a6_in - $a5_out - $a6_out) . "</sapn>
                    </div>";
                }
                if (proAct('osc') && ($a7_in || $a7_out)) {
                    $title .= "<div> التنظير |  
                    <sapn class='clr6'>" . number_format($a7_in) . "</sapn>
                    <sapn class='clr5'>" . number_format($a7_out) . "</sapn>
                    <sapn class='clr1'>" . number_format($a7_in - $a7_out) . "</sapn>
                    </sadivpn>";
                }
                if (_set_9iaut3jze == 1 && $offer) {
                    $title .= "<div>العروض | <sapn class='clr6'>" . number_format($offer) . "</sapn></div>";
                }
                if (_set_gypwynoss == 1 && $card) {
                    $title .= "البطاقات | <sapn><sapn class='clr6'>" . number_format($card) . "</sapn></sapn>";
                }

                if ($cash_net) {
                    echo '<div class="cbgw fl bord br5 sh pd10 Over2" title="' . $title . '" onclick="loadDashData(1,' . $u_id . ')">
					<div class="fxg pd10v" fxg="gtc:1fr 1fr">
                        <div class="cbg6664 clr6 TC ff B fs22 pd5f r_bord">' . number_format($cash_in) . '</div>
                        <div class="cbg5554 clr5 TC ff B fs22 pd5f ">' . number_format($cash_ou) . '</div>
                    </div>
					<div class="clr1 TC fs24 ff  pd10f B t_bord b_bord">' . number_format($cash_net) . '</div>
                    <div class="TC f1 fs14 lh40 clr2">' . $name . ' <span class="clr5 f1 fs12" style="color:' . $payTypePClr[$pay_type] . '">( ' . $payTypeP[$pay_type] . ' )</span></div>';

                    echo '</div>';
                }
            }
            echo '</div>';
        }
        /************************************************/
    }
    if ($n == 2) {
        echo '<section  w="60" m=32" c_ord class="cb">';
        $sql = "select * , c.id as cid from gnr_m_clinics c , $dashTable d where c.act=1 and c.id=d.clinic order by c.ord ASC";
        $res = mysql_q($sql);
        $rows = mysql_n($res);
        $bf = '../';
        $labAvl = 1;
        if ($rows > 0) {
            while ($r = mysql_f($res)) {
                $c_id = $r['cid'];
                $photo = $r['photo'];
                $name = $r['name_' . $lg];
                $amount = $r['amount'];
                $ph_src = viewImage($photo, 1, 150, 150, 'img', 'clinic.png');
                if ($amount) {
                    echo '<div class="dashBloc dB2 fl TC " c_ord onclick="loadDashData(2,' . $c_id . ')">
						<div b>' . $ph_src . '</div>
						<div nn id="clic' . $c_id . '">' . number_format($amount) . '</div>
						<div tt>' . $name . '</div>				
					</div>';
                }
                if ($cType == 2) {
                    $labAvl = 0;
                }
            }
            echo '</section>';
        }
    }
    if ($n == 3) {
        $q = "d_start >='$ss_day' and d_start <$ee_day";
        $viss = get_sum('gnr_x_tmp_dash', 'vis', " date >'$ss_day' ");
        $dates = getTotal('dts_x_dates_temp');

    ?>
        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 ">حالة الزيارات</div>
            <div class="fl dashBlockIn" fix="h:330">
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_pat r_bord"></div>
                    <div num class="fl clr9" fix="wp:101"><?= number_format($viss) ?></div>
                    <div txt class="fl clr2 f1" fix="wp:101">عدد الزيارات</div>
                </div>
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_appo r_bord"></div>
                    <div num class="fl clr5" fix="wp:101"><?= number_format($dates) ?></div>
                    <div txt class="fl clr55 f1" fix="wp:101">عدد المواعيد</div>
                </div>
            </div>
        </div>
        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 ">حالة المواعيد</div>
            <?
            $d1 = getTotalCO('dts_x_dates_temp', "status in(2,3,4)");
            $d2 = getTotalCO('dts_x_dates_temp', "status in(5,6,7) or (status=1 AND d_start<$now )");
            $d3 = getTotalCO('dts_x_dates_temp', "status in(8)"); ?>
            <div class="fl dashBlockIn" fix="h:330">
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_srv_d r_bord"></div>
                    <div num class="fl clr6" fix="wp:101"><?= number_format($d1) ?></div>
                    <div txt class="fl clr66 f1" fix="wp:101">تم الحضور</div>
                </div>
                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_xdate r_bord"></div>
                    <div num class="fl clr5" fix="wp:101"><?= number_format($d2) ?></div>
                    <div txt class="fl clr55 f1" fix="wp:101">لم يحضر</div>
                </div>

                <div class="dashLineInfo fl">
                    <div ico class="fl dash_icon_date2 r_bord"></div>
                    <div num class="fl clr8" fix="wp:101"><?= number_format($d3) ?></div>
                    <div txt class="fl clr88 f1" fix="wp:101">حضر متأخرا</div>
                </div>
            </div>

        </div>
        <div class="dbi">
            <div class="f1 fs18 clr1 TC lh30 ">حالة الدور</div>
            <div class="fl dashBlockIn" fix="wp:0|h:330"><?
                $r_st0 = getTotalCO('gnr_x_roles', "status=0 ");
                $r_st1 = getTotalCO('gnr_x_roles', "status=1 ");
                $r_st2 = getTotalCO('gnr_x_roles', "status=2 ");
                $r_st3 = getTotalCO('gnr_x_roles', "status=3 ");
                $r_st4 = getTotalCO('gnr_x_roles', "status=4 ");
                $allst = $r_st0 + $r_st1 + $r_st2 + $r_st3 + $r_st4;

                $res = mysql_q("select count(*)c from gnr_m_patients where sex=2 and  $q");
                $r = mysql_f($res);
                echo $sex2 = $r['c']; ?>
                <script type="text/javascript">
                    fixPage();
                    $('#rep_container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: ''
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                rotation: -45,
                                style: {
                                    fontFamily: 'f1,Verdana'
                                }
                            }
                        },
                        yAxis: {
                            title: {
                                text: '',
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '<span style="font-size:18px;>{point.y}</span>'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span>',
                            pointFormat: '<span style="color:{point.color}"></span>: <b>{point.y}</b>'
                        },

                        series: [{
                            name: k_nums,
                            colorByPoint: true,
                            data: [{
                                    name: "انتظار",
                                    y: <?= $r_st0 ?>
                                },
                                {
                                    name: "مطلوب للخدمة",
                                    y: <?= $r_st1 ?>
                                },
                                {
                                    name: "يؤدي الخدمة",
                                    y: <?= $r_st2 ?>
                                },
                                {
                                    name: "تم التخطي",
                                    y: <?= $r_st3 ?>
                                },
                                {
                                    name: "منتهية",
                                    y: <?= $r_st4 ?>
                                }

                            ],
                            animation: false,
                        }],
                        //colors:['#ccc','#ea2f2f','#2a78c1','#ffff33','#3bbf34']
                        colors: ['#ccc', '#2a78c1', '#3bbf34']
                    });
                </script>
                <div id="rep_container" class="rep_cont" fix="h:280" dir="ltr"></div>
            </div>
        </div>

    <?
    }
    echo '</div>';
} elseif ($thisGrp == 'buvw7qvpwq'  || $thisGrp == 'pfx33zco65') {
    $d_s = $now - ($now % 86400);
    $d_e = $d_s + 86400;
    echo '<div class="pd10">';
    list($in, $out, $viss) = get_val_c('gnr_x_tmp_cash', 'amount_in,amount_out,vis', $thisUser, 'casher');
    echo '<div class="dashBloc dB2 fl" c_ord onclick="loadDashData(1,' . $thisUser . ')">
	<div n>' . number_format($in - $out) . '</div><div t>' . k_fnd_blnc . '</div></div>';
    if ($thisGrp == 'pfx33zco65') {
        echo '<div class="dashBloc dB2 fl" c_ord onclick="loadDashData(1,' . $thisUser . ')">
	<div n>' . number_format($viss) . '</div><div t>' . k_num_pats . '</div></div>';
    }
    echo '</div>';
} elseif ($thisGrp == 7777) {
    $typeD = array(k_cmpt_srvcs, k_srvcs_cncld, k_unfinshd_srvs, k_srv_skpd);
    $ee_d = $now;
    $ss_d = $now - ($now % 86400); //-rand(10000,1000000);
    $sql = "select * from gnr_m_clinics where act=1 order by name_$lg ";
    $res = mysql_q($sql);
    $rows = mysql_n($res);
    $clinic = array();
    $clinics = array();
    $c_t1 = array();
    $c_t2 = array();
    $c_t3 = array();
    $c_t4 = array();
    if ($rows > 0) {
        $t11 = $t22 = $t33 = $t44 = 0;
        while ($r = mysql_f($res)) {
            $c_id = $r['id'];
            $c_name = $r['name_' . $lg];
            $photo = $r['photo'];
            $qqq = " and  clinic='$c_id' and d_start > '$ss_d' and d_start < '$ee_d' ";
            $t0 = getTotalCO('cln_x_visits', "clinic='$c_id' and d_start > '$ss_d' and d_start < '$ee_d'");
            if ($t0) {
                $t1 = getTotalCO('cln_x_visits_services', " status=1 $qqq");
                $t2 = getTotalCO('cln_x_visits_services', " status=3 $qqq");
                $t3 = getTotalCO('cln_x_visits_services', " status=0 $qqq");
                $t4 = getTotalCO('cln_x_visits_services', " status=0 $qqq and visit_id IN(select vis from gnr_x_roles where status=3 and clic='$c_id')");
                $t3 = $t3 - $t4;
                if ($t1 || $t2 || $t3 || $t4) {
                    $t11 += $t1;
                    $t22 += $t2;
                    $t33 += $t3;
                    $t44 += $t4;
                    array_push($clinic, $c_name);
                    array_push($c_t1, $t1);
                    array_push($c_t2, $t2);
                    array_push($c_t3, $t3);
                    array_push($c_t4, $t4);
                    $clinics[$c_id]['name'] = $c_name;
                    $clinics[$c_id]['t0'] = $t0;
                    $clinics[$c_id]['t1'] = $t1;
                    $clinics[$c_id]['t2'] = $t2;
                    $clinics[$c_id]['t3'] = $t3;
                    $clinics[$c_id]['t4'] = $t4;

                    $q = "select id from cln_x_visits where clinic='$c_id'";
                    $cash_in = get_sum('gnr_x_acc_payments', 'amount', " type IN(1,2)and date>'$ss_d' and date < '$ee_d' and vis IN($q)");
                    $cash_ou = get_sum('gnr_x_acc_payments', 'amount', " type IN(3,4) and date>'$ss_d' and date < '$ee_d'  and vis IN($q)");
                    $cash_net = $cash_in - $cash_ou;
                    $clinics[$c_id]['cash'] = $cash_net;
                }
            }
        }
        $c_id = get_val_c('gnr_m_clinics', 'id', 2, 'type');
        $c_name = get_val('gnr_m_clinics', 'name_' . $lg, $c_id);
        $photo = $r['photo'];
        $qqq = " and visit_id IN (select id from lab_x_visits where d_start > '$ss_d' and d_start < '$ee_d') ";
        $t0 = getTotalCO('lab_x_visits', "d_start > '$ss_d' and d_start < '$ee_d'");
        if ($t0) {
            $t1 = getTotalCO('lab_x_visits_services', " status=1 $qqq");
            $t2 = getTotalCO('lab_x_visits_services', " status=3 $qqq");
            $t3 = getTotalCO('lab_x_visits_services', " status=0 $qqq");
            $t4 = getTotalCO('lab_x_visits_services', " status=0 $qqq and visit_id IN(select vis from gnr_x_roles where status=3 and clic='$c_id')");
            $t3 = $t3 - $t4;
            if ($t1 || $t2 || $t3 || $t4) {
                $t11 += $t1;
                $t22 += $t2;
                $t33 += $t3;
                $t44 += $t4;
                array_push($clinic, $c_name);
                array_push($c_t1, $t1);
                array_push($c_t2, $t2);
                array_push($c_t3, $t3);
                array_push($c_t4, $t4);
                $clinics[$c_id]['name'] = $c_name;
                $clinics[$c_id]['t0'] = $t0;
                $clinics[$c_id]['t1'] = $t1;
                $clinics[$c_id]['t2'] = $t2;
                $clinics[$c_id]['t3'] = $t3;
                $clinics[$c_id]['t4'] = $t4;

                $q = "select id from lab_x_visits ";
                $cash_in = get_sum('gnr_x_acc_payments', 'amount', " type IN(1,2)and date>'$ss_d' and date < '$ee_d' and vis IN($q)");
                $cash_ou = get_sum('gnr_x_acc_payments', 'amount', " type IN(3,4) and date>'$ss_d' and date < '$ee_d'  and vis IN($q)");
                $cash_net = $cash_in - $cash_ou;
                $clinics[$c_id]['cash'] = $cash_net;
            }
        }
    }
    $clinec_text = implode("','", $clinic);
    $t1_text = implode(',', $c_t1);
    $t2_text = implode(',', $c_t2);
    $t3_text = implode(',', $c_t3);
    $t4_text = implode(',', $c_t4);
    ?>
    <script type="text/javascript">
        $(function() {
            // Create the chart
            $('#chart1').highcharts({
                chart: {
                    type: 'pie',
                    backgroundColor: "<?= $clr44 ?>",
                },

                title: {
                    text: false
                },

                plotOptions: {
                    borderWidth: 10,
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        },
                        animation: false,
                        colors: ['#0a0', '#a00', '#ccc', '#ff0']
                    },
                    pie: {
                        borderWidth: 0
                    },
                },

                tooltip: {
                    headerFormat: '',
                    pointFormat: '<span class="f1" dir="ltr" style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>'
                },
                series: [{
                    name: '',
                    colorByPoint: true,
                    data: [{
                            name: '<?= $typeD[0] ?>',
                            y: <?= $t11 ?>
                        },
                        {
                            name: '<?= $typeD[1] ?>',
                            y: <?= $t22 ?>
                        },
                        {
                            name: '<?= $typeD[2] ?>',
                            y: <?= $t33 ?>
                        },
                        {
                            name: '<?= $typeD[3] ?>',
                            y: <?= $t44 ?>
                        },
                    ]
                }],
            });
        });

        $(function() {
            $('#chart2').highcharts({
                chart: {
                    type: 'column',
                    backgroundColor: "<?= $clr44 ?>",
                    plotBorderWidth: 0,
                },
                title: {
                    text: false
                },
                xAxis: {
                    categories: ['<?= $clinec_text ?>']
                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: false
                    }
                },
                tooltip: {
                    headerFormat: '<b>{point.key}</b><br>',
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        borderWidth: 0
                    },
                    series: {
                        animation: false
                    },
                },
                series: [{
                        name: '<?= $typeD[2] ?>',
                        data: [<?= $t3_text ?>],
                        color: '#aaa'
                    },
                    {
                        name: '<?= $typeD[3] ?>',
                        data: [<?= $t4_text ?>],
                        color: '#ff0'
                    },
                    {
                        name: '<?= $typeD[1] ?>',
                        data: [<?= $t2_text ?>],
                        color: '#a00'
                    },
                    {
                        name: '<?= $typeD[0] ?>',
                        data: [<?= $t1_text ?>],
                        color: '#0a0'
                    }
                ]
            });
        });
    </script>
    <div id="chart1" class="chrCon fl" dir="ltr"></div>
    <div id="chart2" class="chrCon fl" dir="ltr"></div><?

                                                        $d_s = $now - ($now % 86400);
                                                        $d_e = $d_s + 86400;

                                                        /***************************************************/
                                                        $dayNo = date('w');
                                                        $h_time = get_host_Time();
                                                        $h_realTime = $h_time[1] - $h_time[0];
                                                        $thisDay2 = $now - ($now % 86400);
                                                        if (($h_realTime + $thisDay2 + $h_time[0]) < $now) {
                                                            $h_realTime = ($now % 86400) - $h_time[0];
                                                        }
                                                        $x_doctor = array();
                                                        $date = date('Y-m-d');
                                                        $sta_txt = array('', k_lft_doc_attend, k_rmn_tm_fsh, k_tm_fsh, '');
                                                        $sta_color = array('', $clr6, $clr1, $clr5, '');
                                                        $sta_txt2 = array('', k_avl_time, k_dely);
                                                        $sta_color2 = array('', $clr6, $clr1);
                                                        /********************************************************************************/
                                                        $sql = "select doc from gnr_x_arc_stop_doc where `date`='$date' ";
                                                        $res = mysql_q($sql);
                                                        $rows = mysql_n($res);
                                                        if ($rows > 0) {
                                                            $i = 0;
                                                            while ($r = mysql_f($res)) {
                                                                $doc = $r['doc'];
                                                                array_push($x_doctor, $doc);
                                                            }
                                                        }
                                                        $x_doctor_str = implode(',', $x_doctor);
                                                        /*********************************************************************************/
                                                        $x_clinic = array();
                                                        $sql = "select clic from gnr_x_arc_stop_clinic where e_date=0";
                                                        $res = mysql_q($sql);
                                                        $rows = mysql_n($res);
                                                        if ($rows > 0) {
                                                            while ($r = mysql_f($res)) {
                                                                $clic = $r['clic'];
                                                                array_push($x_clinic, $clic);
                                                            }
                                                        }
                                                        /*********************************************************************************/
                                                        echo '<div class="f1 fs18 TC lh40 clr1111">' . k_clinics . '</div><div class="uLine"></div>
    <section  w="260" m=10" c_ord>';
                                                        $user_clinic = explode(',', get_val('_users', 'subgrp', $thisUser));
                                                        $other_blc = '';
                                                        $sql = "select * from gnr_m_clinics where act=1 order by ord ASC";
                                                        $res = mysql_q($sql);
                                                        $rows = mysql_n($res);
                                                        if ($rows > 0) {
                                                            while ($r = mysql_f($res)) {
                                                                $c_id = $r['id'];
                                                                $name = $r['name_' . $lg];
                                                                $photo = $r['photo'];
                                                                $type = $r['type'];
                                                                $ph_src = viewImage($photo, 1, 30, 30, 'img', 'clinic.png');
                                                                $x_style = 0;
                                                                if (in_array($c_id, $x_clinic)) {
                                                                    $x_style = 1;
                                                                }
                                                                $qqq = " and visit_id IN (select id from cln_x_visits where clinic='$c_id' and d_start > '$ss_d' and d_start < '$ee_d') ";
                                                                $t0 = $clinics[$c_id]['t0'];

                                                                if ($t0) {
                                                                    $t1 = $clinics[$c_id]['t1'];
                                                                    $t2 = $clinics[$c_id]['t2'];
                                                                    $t3 = $clinics[$c_id]['t3'];
                                                                    /**************/
                                                                    $action = '';
                                                                    $sst = '';
                                                                    if ($x_style) {
                                                                        $sst = 'background-color:#fcc';
                                                                    }
                                                                    $blc = '
                <div class="cli_blc of fl" type="n" c_ord style="height:90px;' . $sst . '">
                <div class="fr ff fs18 lh40 clr6 B pd10">' . number_format($clinics[$c_id]['cash']) . '</div>';

                                                                    $blc .= '<div class="fl cli_icon">' . $ph_src . '</div>
                <div class="fl "><div class="fs16 f1 cli_name">' . $name . '</div></div>
                <table width="100%" class="dashTable">
                    <tr><th class="f1" >' . k_visits . '</th>
        <th class="f1">' . k_services . '</th><th class="f1">' . k_cmpt_srvcs . '</th><th class="f1">' . k_srvcs_cncld . '</th><th class="f1">' . k_in_wait . '</th></tr>
                    <tr>
                    <td><ff>' . number_format($t0) . '</ff></td>
                    <td><ff>' . number_format($t1 + $t2 + $t3) . '</ff></td>
                    <td><ff>' . number_format($t1) . '</ff></td>
                    <td><ff>' . number_format($t2) . '</ff></td>
                    <td><ff>' . number_format($t3) . '</ff></td>
                    </tr>
                </table>
                </div>';
                                                                    echo $blc;
                                                                }
                                                            }
                                                        }
                                                        echo '</section>';
                                                    } elseif ($thisGrp == 'oiz49vigr') {
                                                        $d_s = $now - ($now % 86400);
                                                        $d_e = $d_s + 86400;
                                                        $visitStatus = array('', 'بالانتظار حالياَ', '', '', 'تم اخذ العينات', 'تم انجاز الخدمات', 'تم استلام التحاليل');
                                                        /*$fastAna=getTotalCO('lab_x_visits_services',"visit_id in (select id from lab_x_visits where d_start>='$d_s' 
	and d_start<'$d_e')  and fast=1 and status!=3");*/
                                                        $fastPat = getTotalCO('lab_x_visits', "d_start>='$d_s' and d_start<'$d_e' and fast=1");
                                                        $fastPat = getTotalCO('lab_x_visits', "d_start>='$d_s' and d_start<'$d_e' and fast=1 and status!=3");
                                                        //count of outLab anaylsis
                                                        $outLabAna = getTotalCO('lab_x_visits_services', "visit_id in (select id from lab_x_visits where d_start>='$d_s' 
	and d_start<'$d_e' and service in (select id from lab_m_services where outlab=1))");
                                                        //count of internal anaylsis
                                                        $InternalAna = getTotalCO('lab_x_visits_services', "visit_id in (select id from lab_x_visits where d_start>='$d_s' 
	and d_start<'$d_e' and service in (select id from lab_m_services where outlab=0))"); ?>
    <div class="emegncySide r_bord fl" fix="hp:0">
        <div class="f1 lh40 clr5 fs16 uLine"> المرضى الاسعافيين [<ff><?= $fastPat ?></ff>] - [<ff><?= $fastPat ?></ff>]</div>
        <div class="ofx so fl pd10" fix="wp%:98|hp:50">
            <?
                                                        $fastTime = _set_6bu0m3quf2;
                                                        $sql = "select * from  lab_x_visits  where  d_start>='$d_s' and d_start < '$d_e' and fast=1 and status!=3";
                                                        $res = mysql_q($sql);
                                                        while ($r = mysql_f($res)) {
                                                            $patient = $r['patient'];
                                                            $time = $r['d_start'];
                                                            $visit_id = $r['id'];
                                                            $sttus = $r['status'];
                                                            $style = '';
                                                            $SampleDate = "select MIN(take_date) as tke_dt from `lab_x_visits_samlpes` where visit_id=$visit_id";
                                                            $SampleDate = mysql_q($SampleDate);
                                                            $SampleDate = mysql_f($SampleDate);
                                                            if ($SampleDate['tke_dt']) {
                                                                $time = $SampleDate['tke_dt'];
                                                                if (number_format(($now - $time) / 60) > $fastTime) {
                                                                    $style = 'fast_ana_dash';
                                                                }
                                                            }
                                                            echo '<div class="emergncy_block ' . $style . '" fix="wp:10" onclick="loadDashData(7,' . $visit_id . ')">
				<div class="f1 fs14 lh30 TC w100">' . get_p_name($patient) . '</div>
				<div class="f1  clr1 TC w100">' . $visitStatus[$sttus] . '</div>
				<div class="ff fs16 B lh20 TC" dir="ltr">
					<span class="ff fs14 clr5">' . dateToTimeS2($now - $time) . ' </span>
				</div>	
			</div>';
                                                        }
            ?>
        </div>
    </div>
    <div class="ofx so mg10 fl" fix="wp:280|hp:0"><?
                                                        echo '<div class="cb"></div>
	<section  w="140" m=32" c_ord>';
                                                        //عدد المرضى الاجمالي
                                                        $totalPat = getTotalCO('lab_x_visits', "d_start>'$d_s' and d_start < '$d_e'");
                                                        //عدد المرضى الملغاة
                                                        $totalCanceld = getTotalCO('lab_x_visits', "d_start>'$d_s' and d_start < '$d_e' and status=3");
                                                        //عدد المرضى الصافي
                                                        $totalWorking = $totalPat - $totalCanceld;
                                                        if ($totalPat > 0) {
                                                            echo '<div class="dashBloc  fl " c_ord onclick="loadDashData(4,0)">
				<div n >' . number_format($totalPat) . '</div>
				<div t class="dashDet">
					<div class="fl" style="width:50%;">
						<div class="f1">الفعلي</div>
						<div class="clr6"><ff>' . number_format($totalWorking) . '</ff></div>
					</div>
					<div class="fl" style="width:50%">
						<div class="f1">الملغاة </div>
						<div class="clr5"><ff>' . number_format($totalCanceld) . '</ff></div>
					</div>
				</div>
				<div t class="cb"> إجمالي المرضى اليوم</div>				
			</div>';
                                                        }
                                                        //عدد التحاليل الاجمالي
                                                        $total_ana = getTotalCO('lab_x_visits_services', "visit_id in (select id from lab_x_visits where d_start>='$d_s' 
	and d_start<'$d_e')");
                                                        //عدد التحاليل الفعلية
                                                        $totalWorkAna = getTotalCO('lab_x_visits_services', "visit_id in (select id from lab_x_visits where d_start>='$d_s' 
	and d_start<'$d_e' and status!=3)");
                                                        //عدد التحاليل الملغاة
                                                        $totalCancelAna = getTotalCO('lab_x_visits_services', "visit_id in (select id from lab_x_visits where d_start>='$d_s' 
	and d_start<'$d_e' and status=3)");
                                                        $totalAllAna = $outLabAna + $InternalAna;
                                                        if ($totalAllAna > 0) {
                                                            echo '<div class="dashBloc  fl " c_ord onclick="loadDashData(5,0)">
            <div n >' . number_format($totalWorkAna) . '</div>
            <div t class="dashDet">
                    <div class="fl" style="width:50%;">
                        <div class="f1" >الاجمالي</div>
                        <div class="clr6"><ff>' . number_format($totalAllAna) . '</ff></div>
                    </div>
                    <div class="fl"  style="width:50%;">
                        <div class="f1">الملغاة</div>
                        <div class="clr5"><ff>' . number_format($totalCancelAna) . '</ff></div>
                    </div>
            </div>
            <div t class="cb">إجمالي التحاليل الفعلي</div>				
        </div>';
                                                        }
                                                        if ($totalAllAna > 0) {
                                                            echo '<div class="dashBloc  fl " c_ord onclick="loadDashData(6,0)">
            <div n >' . number_format($totalWorkAna) . '</div>
            <div t class="dashDet">
                    <div class="fl" style="width:50%;">
                        <div class="f1">داخلي</div>
                        <div class="clr6"><ff>' . number_format($InternalAna) . '</ff></div>
                    </div>
                    <div class="fl" style="width:50%;">
                        <div class="f1">خارجي</div>
                        <div class="clr5"><ff>' . number_format($outLabAna) . '</ff></div>
                    </div>
            </div>
            <div t class="cb">أنواع التحاليل</div>				
        </div>';
                                                        }
                                                        echo '</section>';
                                                        /************************************************/
                                                        echo '<div class="cb"></div>';
                                                    ?>
    </div>
<?
                                                    } else {
                                                        echo '<div class="ff fs24 B pd10f mg10f bord fl">' . date('A h:i', $now) . '</div>';
                                                    }
                                                    if ($thisGrp == 's' && $s == 0) { ?>
    <script>
        $('.top_title').dblclick(function() {
            showDashS = 1;
            dash();
        })
    </script><?
                                                    } ?>