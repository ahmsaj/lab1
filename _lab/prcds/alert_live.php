<? include("../../__sys/prcds/ajax_header.php");
$delDate=$now-21600;
mysql_q("DELETE from lab_x_racks_alert where status=1 and date < $delDate ");
$sql="select * from  lab_x_racks_alert order by status ASC , date ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
	<tr><th>'.k_rck.'</th><th>'.k_sample.'</th><th>'.k_analysis.'</th><th>'.k_status.'</th><th>'.k_operations.'</th></tr>';
	while($r=mysql_f($res)){
		$id=$r['id'];
		$rack=$r['rack'];
		$position=$r['position'];
		$sample=$r['sample'];
		$ana=$r['ana'];
		$date=$r['date'];
		$status=$r['status'];
		list($r_no,$r_code)=get_val('lab_m_racks','no,code',$rack);
		$ana2=get_val('lab_x_visits_services','service',$ana);
		$sta_txt=k_test_added_since;
		$clr='clr5';
		if($status==1){$sta_txt=k_printed_since; $clr='clr6';}
		echo '<tr>
		<td><ff>'.($r_code.'-'.$r_no).'</ff><br>('.$position.')</td>
		<td class="f1 fs14">'.get_val('lab_m_samples','name_'.$lg,$sample).'</td>
		<td><ff>'.get_val('lab_m_services','short_name',$ana2).'</ff></td>
		<td><div class="f1 fs12 '.$clr.'">'.$sta_txt.' <ff class="fs14">'.dateToTimeS2($now-$date).'</ff></div></td>
		<td>
		<div class="fl fs14 clr1 f1 Over lh30 mg10" onclick="rackPrint('.$rack.')">'.k_rack_print.'</div> 
		<div class="fl fs14 clr1 f1 Over lh30 mg10" onclick="rackPartPrint('.$id.')">'.k_attach_print.'</div>
		</td></tr>';
	}
	echo '<table>';
}?>