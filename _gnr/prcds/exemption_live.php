<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from gnr_x_temp_oprs where type=1  order by status ASC , date ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){	
	while($r=mysql_f($res)){
		$id=$r['id'];
		$type=$r['type'];
		$pat_name=$r['pat_name'];
		$status=$r['status'];
		//$sub_status=$r['sub_status'];
		$date=$r['date'];
		$col='';		
		$statusTxt=k_since.' <ff14> '.dateToTimeS2($now-$date);
		if($status==1){$col='cbg7';$statusTxt=k_request_succes;}
		echo'
		<div class="chrBlc '.$col.'" onclick="exe_det('.$id.')">
			<div class="f1 fs14 clr1">'.$pat_name.'</div>
			<div class="fs14 lh20">'.$statusTxt.'</ff14></div>
		</div>';
	}
}else{
	echo '<div class="f1 fs14 clr5 lh40">'.k_no_req_chart.'</div>';
}?>
<? 
/*include("../../__sys/prcds/ajax_header.php");
$dayNo=date('w');
$h_time=get_host_Time();
$h_realTime=$h_time[1]-$h_time[0];
$x_doctor=array();
$date=date('Y-m-d');

$sql="select * from gnr_x_temp_oprs where type=1  order by sub_status ASC ,date  ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){
	echo '<table width="100%" border="0" class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">';
    echo '<tr><th width="30">#</th><th>'.k_patient.'</th><th>'.k_clinic.'</th><th>'.k_status.'</th><th width="150">'.k_operations.'</th></tr>';
	while($r=mysql_f($res)){
		$id=$r['id'];
		$v_id=$r['vis'];
		$clinic=$r['clinic'];
		$patient=$r['patient'];
		$d_start=$r['date'];
		$status=$r['status'];
		$mood=$r['mood'];
		$sub_status=$r['sub_status'];
		$pat_name=$r['pat_name'];
		$status_txt='';
		if($sub_status==0){$col='';$status_txt=k_request_applied_since.' <ff> ( '.dateToTimeS2($now-$d_start).' ) </ff>';}
		if($sub_status==1){$col='#efe';$status_txt=k_done_waiting_fund_review;}
		echo'
		<tr bgcolor="'.$col.'"><td><ff>'.$v_id.'</ff></td>
		<td class="f1">'.$pat_name.'</td>
		<td class="f1">'.get_val('gnr_m_clinics','name_'.$lg,$clinic).'</td>
		<td class="f1">'.$status_txt.'</td><td class="f1 fs14">';
		echo '<div class="bu2 bu_t1 fl" onclick="e_det('.$v_id.','.$mood.')">'.k_details.'</div>';
		if($now-$date>3600 && $status==0){
			echo '<div class="bu2 bu_t3 fl" onclick="delVis('.$v_id.','.$mood.')">'.k_delete.'</div>';
		}
		
		echo '</td></tr>';
	}	
    echo '</table>';
}else{
	echo '<div class="f1 fs18 clr1">'.k_no_exemption_requests.'</div>';	
}*/

?>