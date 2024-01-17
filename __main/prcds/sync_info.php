<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['type'])) {
    $type = pp($_POST['type']);
    $date = $now;
    $dateTxt = date('Y-m-d', $now);
    if ($type == 1) {
        $table = 'gnr_r_cash';
        $table2 = 'gnr_x_acc_payments';
        $date_filed = 'date';
    }
    if ($type == 2) {
        $table = 'gnr_r_clinic';
        $table2 = 'gnr_x_acc_payments';
        $date_filed = 'date';
    }
    if ($type == 3) {
        $table = 'gnr_r_docs';
        $table2 = 'cln_x_visits_services';
        $date_filed = 'date';
    }
    if ($type == 4) {
        $table = 'gnr_r_charities';
        $table2 = 'gnr_x_charities_srv';
        $date_filed = 'date';
    }
    if ($type == 5) {
        $table = 'gnr_r_insurance';
        $table2 = 'gnr_x_insurance_rec';
        $date_filed = 'date';
    }
    if ($type == 6) {        
        $date_filed = 'd_start';
    }
    if ($type == 8) {
        $table = 'gnr_r_recepion';
        $table2 = 'cln_x_visits';
        $date_filed = 'date';
    }
    if ($type == 9) {
        $table = 'den_r_docs';
        $table2 = 'den_x_visits';
        $date_filed = 'd_start';
    }
    if ($type == 10) {
        $table = 'gnr_r_docs_details';
        $table2 = 'gnr_r_docs_details';
        $date_filed = 'date';
    }
    /*
    if(!in_array($type,[6,7])){
        if($type!=6 || $type!=7){
            $sql="select date from $table order by date DESC limit 1";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){
                $r=mysql_f($res);
                $date=$r['date'];
                $dateTxt=date('Y-m-d',$date);
                echo '<div class="f1 fs14 clr1">'.k_lst_syc_dn.' <ff>'.$dateTxt.'</ff></div>';
            }else{
                echo '<div class="f1 fs16 clr5 lh30">'.k_sc_scyh_pre.'</div>';
                $sql="select $date_filed from $table2 where $date_filed!=0 order by $date_filed ASC limit 1";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){
                    $r=mysql_f($res);				
                    $date=$r[$date_filed];
                    $dateTxt=$date;
                    if($type!=4){$dateTxt=date('Y-m-d',$date);}
                    echo '<div class="f1 fs14 clr55"> '.k_scyh_d_d.' <ff>'.$dateTxt.'</ff></div>';
                }
            }
        }else{
            if($type==6){
                $sql="select id,d_start from cln_x_visits where senc=0 and status !=3 order by d_start ASC limit 1";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){
                    $r=mysql_f($res);
                    $date=$r['d_start'];
                    $vis_id=$r['id'];
                    $dateTxt=$date;
                    $dateTxt=date('Y-m-d',$date);
                    echo '<div class="f1 fs14 clr55"> '.k_scyh_d_d.' <ff>'.$dateTxt.'</ff> <ff class="clr1" > (  '.$vis_id. ')</ff></div>';
                }
            }
            if($type==7){
                $sql="select d_start from lab_x_visits where senc=0 order by d_start ASC limit 1";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){
                    $r=mysql_f($res);
                    $date=$r['d_start'];
                    $dateTxt=$date;
                    $dateTxt=date('Y-m-d',$date);
                    echo '<div class="f1 fs14 clr55"> '.k_scyh_d_d.' <ff>'.$dateTxt.'</ff></div>';
                }
            }
        }
    }*/

    switch ($type) {
        case 1:
            $lastSync = get_val_con($table, $date_filed, "1=1", 'order by date');
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . date('Y-m-d', $lastSync) . '</div>
                </div>';
            }
            $options = get_arr('_users', 'id', 'name_' . $lg, " grp_code in ('pfx33zco65','buvw7qvpwq','kzfr3ekg3') ", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($options as $k => $v) {
                $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_box . ':</div>
            <select id="filter"><option value="0">' . k_alboxs . '</option>' . $optionsList . '</select>
            </div>';
            break;
        case 2:
            $lastSync = get_val_con($table, $date_filed, "1=1", 'order by date DESC');
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . date('Y-m-d', $lastSync) . '</div>
                </div>';
            }
            $options = get_arr('gnr_m_clinics', 'id', 'name_' . $lg, "", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($options as $k => $v) {
                $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_tclinic . ':</div>
            <select id="filter"><option value="0">' . k_alclincs . '</option>' . $optionsList . '</select>
            </div>';
            break;
        case 3:
            $lastSync = get_val_con($table, $date_filed, "1=1", 'order by date DESC');
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . date('Y-m-d', $lastSync) . '</div>
                </div>';
            }
            $options = get_arr('_users', 'id', 'name_' . $lg, " grp_code in($docsGrpStr)", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($options as $k => $v) {
                $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_doctor . ':</div>
            <select id="filter"><option value="0">' . k_aldrs . '</option>' . $optionsList . '</select>
            </div>';
            break;
        case 4:
            $lastSync = get_val_con($table, $date_filed, "1=1", 'order by date DESC');
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . date('Y-m-d', $lastSync) . '</div>
                </div>';
            }
            $options = get_arr('gnr_m_charities', 'id', 'name_' . $lg, "1=1", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($options as $k => $v) {
                $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_the_charity . ':</div>
            <select id="filter"><option value="0">' . k_alchrt . '</option>' . $optionsList . '</select>
            </div>';
            break;
        case 5:
            $lastSync = get_val_con($table, $date_filed, "1=1", 'order by date DESC');
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . date('Y-m-d', $lastSync) . '</div>
                </div>';
            }
            $options = get_arr('gnr_m_insurance_prov', 'id', 'name_' . $lg, "1=1", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($options as $k => $v) {
                $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_insure_comp . ':</div>
            <select id="filter"><option value="0">' . k_all_comps . '</option>' . $optionsList . '</select>
            </div>';
            break;
        case 6:
            $lastSync = get_val_con('cln_x_visits', $date_filed, "1=1", "order by $date_filed DESC");
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . date('Y-m-d', $lastSync) . '</div>
                </div>';
            }
            $options = get_arr('_users', 'id', 'name_' . $lg, " grp_code in('pfx33zco65')", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($clinicTypes as $k => $v) {
                if (in_array($k, [1, 3, 5, 6, 7])) {
                    $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
                }
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_the_sec . ':</div>
            <select id="filter"><option value="0">' . k_all_deps . '</option>' . $optionsList . '</select>
            </div>';
            break;
        case 8:
            $lastSync = get_val_con($table, $date_filed , "1=1", " order by $date_filed DESC ");
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . date('Y-m-d', $lastSync) . '</div>
                </div>';
            }
            $options = get_arr('_users', 'id', 'name_' . $lg, " grp_code in('pfx33zco65')", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($options as $k => $v) {
                $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_reception . ':</div>
            <select id="filter"><option value="0">' . k_all_res . '</option>' . $optionsList . '</select>
            </div>';
            break;
        case 10:
            $lastSync = get_val_con($table, $date_filed, "1=1", 'order by date');
            if ($lastSync) {
                echo '<div class="b_bord" id="lastSync">
                    <div class="f1 lh20 fs14">' . k_lst_syc_dn . ':</div>
                    <div class="ff fs18 B lh30 clr1">' . $dateTxt . '</div>
                </div>';
            }
            $options = get_arr('_users', 'id', 'name_' . $lg, " grp_code in($docsGrpStr)", 1, " order by name_$lg ASC");
            $optionsList = '';
            foreach ($options as $k => $v) {
                $optionsList .= '<option value="' . $k . '">' . $v . '</option>';
            }
            $filter = '<div class="pd5v b_bord">
            <div class="f1 fs14 lh30">' . k_doctor . ':</div>
            <select id="filter"><option value="0">' . k_aldrs . '</option>' . $optionsList . '</select>
            </div>';
            break;
    }
    //$dateTxt='2022-12-5';
    $dateEnd = date('Y-m-d', $now);
    //$dateEnd='2022-12-21';
?>
    <div id="syncForm">
        <div class="pd5v ">
            <div class="f1 fs14 lh30" width="120"><?= k_from ?>:</div>
            <div><input type="text" id="snc_s" class="Date" value="<?= $dateTxt ?>" /></div>
        </div>
        <div class="pd5v b_bord">
            <div class="f1 fs14 lh30"><?= k_to ?>:</div>
            <div><input type="text" id="snc_e" class="Date" value="<?= $dateEnd ?>" /></div>
        </div>
        <?= $filter ?>
        <div class="mg20v ">
            <div class="ic40 ic40_set ic40Txt icc1" syncStart><?= k_st_syc ?></div>
        </div>
    </div>
    <div id="syncData"></div><?
                            } ?>