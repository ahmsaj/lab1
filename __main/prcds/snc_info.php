<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$type=pp($_POST['type']);
	$date=$now;
	$dateTxt=date('Y-m-d',$now);
	if($type==1){$table='gnr_r_cash';$table2='gnr_x_acc_payments';$date_filed='date';}
	if($type==2){$table='gnr_r_clinic';$table2='gnr_x_acc_payments';$date_filed='date';}
	if($type==3){$table='gnr_r_docs';$table2='cln_x_visits_services';$date_filed='d_start';}
	if($type==4){$table='gnr_r_charities';$table2='gnr_x_charities_srv';$date_filed='date';}
	if($type==5){$table='gnr_r_insurance';$table2='gnr_x_insurance_rec';$date_filed='s_date';}
	if($type==8){$table='gnr_r_recepion';$table2='cln_x_visits';$date_filed='d_start';}
	if($type==9){$table='den_r_docs';$table2='den_x_visits';$date_filed='d_start';}
    if($type==10){$table='gnr_r_docs_details';$table2='gnr_r_docs_details';$date_filed='date';}
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
    }
?>
<table class="grad_s" type="static" cellpadding="4">
	<tr><td class="f1 fs16 " width="120"><?=k_from?> :</td>
	<td><input type="text" id="snc_f" class="Date" value="<?=$dateTxt?>"/></td></tr>
	<tr><td class="f1 fs16 "><?=k_to?> :</td>
	<td><input type="text" id="snc_o" class="Date" value="<?=date('Y-m-d',$now)?>"/></td></tr>
	<tr><td colspan="2"><div class="bu bu_t1" onclick="sncStart()"><?=k_st_syc?></div></td></tr>
</table><?	
}?>