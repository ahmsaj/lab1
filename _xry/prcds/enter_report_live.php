<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from xry_x_visits_services where `status`=6 and (clinic in ($userSubType) or '$thisUser'= 's' ) order by id ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<table width="100%" border="0" class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">';
    echo '<tr><th width="30">#</th><th>'.k_patient.'</th><th>'.k_clinic.'</th><th>'.k_status.'</th><th width="150">'.k_operations.'</th></tr>';
	while($r=mysql_f($res)){
		$s_id=$r['id'];
		$clinic=$r['clinic'];
		$patient=$r['patient'];
		$d_start=$r['d_start'];
		$status=$r['status'];
		$sub_status=$r['sub_status'];	
		$status_txt='';
		if($sub_status==0){$col='';$status_txt=k_request_applied_since.' <ff> ( '.dateToTimeS2($now-$d_start).' ) </ff>';}
		if($sub_status==1){$col='#efe';$status_txt=k_done_waiting_fund_review;}
		echo'
		<tr bgcolor="'.$col.'"><td><ff>'.$s_id.'</ff></td>
		<td class="f1">'.get_p_name($patient).'</td>
		<td class="f1">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
		<td class="f1">'.$status_txt.'</td><td class="f1 fs14">';
		echo '<div class="bu2 bu_t1 fl" onclick="xry_erep('.$s_id.',0)">'.k_ent_report.'</div>';		
		echo '</td></tr>';
	}	
    echo '</table>';
}else{
	echo '<div class="f1 fs18 clr1">'.k_no_srvcs.'</div>';	
}
?>