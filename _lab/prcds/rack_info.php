<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
$id=pp($_POST['id']);?>
<div class="win_body">
<div class="form_header lh40 f1 fs18 clr1">
<div class="fl f1 fs18 clr1111 lh40"><?=k_sampels?></div>
<div class="fr printIcon" title="<?=k_print_sams?>" onclick="rackPrint(<?=$id?>)"> </div>
</div>
<div class="form_body so" style="padding-top:0px"><?
$sql="select * from lab_x_visits_samlpes where rack='$id' order by rack_pos ASC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
	<tr><th>#</th><th>'.k_sample.'</th><th>'.k_patient.'</th><th>'.k_tests.'</th></tr>';
	$thisP=0;
	while($r=mysql_f($res)){
		$visit_id=$r['visit_id'];
		$pkg_id=$r['pkg_id'];
		$services=$r['services'];
		$no=$r['no'];
		$s_taker=$r['s_taker'];
		$date=$r['date'];
		$status=$r['status'];
		$p=$r['patient'];
		$rack_pos=$r['rack_pos'];
		$p_data=get_p_name($p,3);		
		$RXY=getSAddrXY($id);
		$serv=getLinkedAna(2,0,$services,2);
		$cspan=count($serv);
		for($s=0;$s<$cspan;$s++){
			echo '<tr>';
			if($s==0){
				echo '						
				<td rowspan="'.$cspan.'" class="ff fs20 B">'.getSAView($rack_pos,$RXY[0],$RXY[1]).'</td>
				<td rowspan="'.$cspan.'">'.get_samlpViewC(0,$pkg_id,2,$no).'</td>
				<td rowspan="'.$cspan.'"><div class="f1 lh20 fs14">'.$p_data[0].' <br>'.$sex_types[$p_data[4]].' ( '.$p_data[1].' )</div></td>';		
			}
			echo '<td>'.$serv[$s].'</td>';
			echo '</tr>';
		}
	}
	echo '</table>';
}?>
</div>
<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div></div>
</div>
<? }?>