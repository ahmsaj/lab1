<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $s=pp($_POST['s']);
    $r=getRec('gnr_x_visits_services_alert',$id);
    if($r['r']){
        $vis=$r['visit_id'];
        $clinic=$r['clinic'];
        $doc=$r['doc'];
        $amount=$r['amount'];
        $patient=$r['patient'];
        $date=$r['date'];
        $status=$r['status'];
        $mood=$r['mood'];?>
        <script>
            actNewVis='<?=$vis?>';
            actNewVisMood='<?=$mood?>';
            $('.rwTitle').append(' <ff>(<?=dateToTimeS2($now-$date)?> )</ff>');
        </script><?
        if($status<2|| $status==5){
            switch($mood){
                case 1 :echo cln_recAlert($vis,$id,$status); break;
                case 3 :echo xry_recAlert($vis,$id,$status); break;
                case 4 :echo den_recAlert($vis,$amount,$id,$status); break;
                case 5 :echo bty_recAlert($vis,$id,$status); break;
                case 6 :echo lzr_recAlert($vis,$id,$status); break;
            }
        }else if($status==2){
            echo '<div class="ofx h100 so pd10f">
            <div class="f1 fs14 clr1 lh40">'.k_conflict_appoints.'</div>';
            $dates_arr=array();
            $clinic_arr=array();
            $sql="select * from dts_x_dates where status=9 and d_start>$ss_day order by d_start ASC";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){
                echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" over="0" >
                <tr><th>'.k_dr.'</th><th>'.k_patient.'</th><th>'.k_appointment.'</th><th width="30"></th></tr>';
                while($r=mysql_f($res)){
                    $d_id=$r['id'];
                    $doctor=$r['doctor'];
                    $patient=$r['patient'];
                    $p_type=$r['p_type'];
                    $date=$r['date'];
                    $status=$r['status'];
                    $name=$r['name_'.$lg];	
                    $d_status=$r['status'];
                    $c_type=$r['type'];
                    $d_start=$r['d_start'];
                    $other=$r['other'];
                    $ds=$r['d_start']-$ss_day;
                    $de=$r['d_end']-$ss_day;
                    $p_name=get_p_dts_name($patient,$p_type);
                    $p_note='';
                    $action='confirmDate('.$d_id.','.$c_type.');';
                    $docNanme=get_val_arr('_users','name_'.$lg,$doctor,'doc');
                    $d_t=$de-$ds;
                    echo '<tr>
                        <td class="f1 fs14">'.$docNanme.'</td>
                        <td class="f1 fs14">'.$p_name.$p_note.'</td>
                        <td><ff dir="ltr">'.date('Y-m-d A h:i',$d_start).'</ff></td>
                        <td>
                            <div class="i40 i40_edit fl" title="'.k_details.'" dts="'.$d_id.'"></div>
                        </td>
                    </tr>';									
                }
                echo '</table>';
            }
            echo '</div>';
        }
    }
}?>