<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header lh40 f1 fs18 clr1">
<!--<div class="fr printIcon" title="طباعة العينات" onclick="rackPrint(<?=$id?>)"> </div>-->
</div>
<div class="form_body so"><?
$sql="select * from lab_x_visits_services where status=9 order by date_reviwe ASC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
	<tr><th width="30">#</th><th>'.k_analysis.'</th><th>'.k_reviewer.'</th><th>'.k_date.'</th><th width="30"></th></tr>';
	$thisP=0;
	while($r=mysql_f($res)){
		$id=$r['id'];
		$report_rev=$r['report_rev'];
		$service=$r['service'];
		$date_reviwe=$r['date_reviwe'];
		//$p_data=get_p_name($p,3);
		echo '<tr>						
			<td class="ff fs20 B">'.$id.'</td>
			<td><ff>'.get_val('lab_m_services','short_name',$service).'</ff></td>
			<td class="f1 fs14">'.get_val('_users','name_'.$lg,$report_rev).'</td>
			<td><ff>'.dateToTimeS3($date_reviwe).'<br>'.dateToTimeS2($now-$date_reviwe).'</ff></td>
			<td><div class="ic40 icc1 ic40_edit " title="'.k_ent_rep_val.'" onclick="showLReport('.$id.',1)"></div></td>
			</tr>';
	}
	echo '</table>';
}?>
</div>
<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div></div>
</div>