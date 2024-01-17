<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header so lh40 clr1 f1 fs18"> <?=k_conflict_appoints?> ( <?=k_must_be_modified_for_service?> )</div>
<div class="form_body so"><?
$dates_arr=array();
$clinic_arr=array();
$sql="select * from dts_x_dates where status=9 order by d_start ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" over="0" >
	<tr><th>'.k_appointment.'</th><th>'.k_duration.'</th><th>'.k_patient.'</th><th>'.k_doctor.'</th><th>'.k_status.'</th><th width="30">'.k_operations.'</th></tr>';
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
		$d_t=$de-$ds;
		echo '<tr>
			<td><ff dir="ltr">'.date('Y-m-d A h:i',$d_start).'</ff></td>
			<td class="f1 fs14"><ff>'.($d_t/60).'</ff> '.k_minute.'</td>
			<td class="f1 fs14">'.$p_name.$p_note.'</td>
			<td class="f1 fs14">'.get_val('_users','name_'.$lg,$doctor).'</td>
			<td class="f1 fs12">'.$dateStatusInfo[$status].'</td>
			<td>
				<div>
					<div class="ic40 icc1 ic40_info fl" title="'.k_details.'" onclick="dateINfo('.$d_id.');win(\'close\',\'#m_info3\')"></div>';
					if($status==1){echo '<div class="ic40 icc2 ic40_done fl" title="'.k_pat_atten_confirm.'" onclick="'.$action.'"></div>';}
				echo '</div>
			</td>
		</tr>';									
	}
	echo '</table>';
}?>
</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>     
</div>
</div>
