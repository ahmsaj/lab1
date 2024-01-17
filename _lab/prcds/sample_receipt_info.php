<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header lh40 f1 fs18 clr1">
<div class="fl f1 fs18 clr1111 lh40"><?=k_sampels?></div>
<div class="fr printIcon" title="<?=k_print_sams?>" onclick="printLab(1,1)"> </div>
</div>
<div class="form_body so"><?
$sql="select * from lab_x_visits_samlpes where status=2 order by patient ASC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$i=0;
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
	<tr><th>'.k_sample.'</th><th>'.k_patient.'</th><th>'.k_tk_sams.'</th><th>'.k_tests.'</th><th>'.k_tim.'</th></tr>';
	$thisP=0;
	while($r=mysql_f($res)){
		$visit_id=$r['visit_id'];
		$pkg_id=$r['pkg_id'];
		$services=$r['services'];
		$no=$r['no'];
		$s_taker=$r['s_taker'];
		$date=$r['date'];
		$status=$r['status'];		
		$fast=$r['fast'];
		$sub_s=$r['sub_s'];
		$per_s=$r['per_s'];
		$p=$r['patient'];
		$p_data=get_p_name($p,3);
		
		$fastTxt='';if($fast){$fastTxt='<div class="cb f1 clr5">'.k_emergency.'</div>';}
		$perTxt='';if($per_s){$perTxt='<div class="cb f1 clr5">'.k_bu_sam.'</div>';}
		
		echo '<tr>
		<td>'.get_samlpViewC(0,$pkg_id,2,$no).$fastTxt.$perTxt.'</td>';
		if($p!=$thisP){
			$pT=getTotalCO('lab_x_visits_samlpes',"status=2 and patient='$p'");
			echo '<td rowspan="'.$pT.'"><div class="f1 lh20">'.$p_data[0].' ('.$p_data[1].')</div></td>';
		}
		echo '<td class="f1 fs14">'.get_val('lab_m_samples_takers','name',$s_taker).'</td>
		<td>'.getLinkedAna(2,0,$services).'</td>
		<td>'.dateToTimeS2($now-$date).'</td>
		</tr>';
		$thisP=$p;
	}
	echo '</table>';
}?>
</div>
<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div></div>
</div>