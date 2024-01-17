<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
$r_id=pp($_POST['id']);?>
<div class="win_body">
<div class="form_header lh40 f1 fs18 clr1">
<div class="fl f1 fs18 clr1111 lh40">
<? 
$sendetOut=get_val('lab_m_racks','out_lab',$id);
if($sendetOut==0){
	$sql="select * from lab_m_external_Labs where act=1 order by name_$lg asc";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<div class="f1 fs18 fl pd10">'.k_sel_ext_lab.'</div><div class="fl">
		<select id="outLab" style="width:200px;" class="fs18">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			echo '<option value="'.$id.'">'.$name.'</option>';
		}
		echo '</select></div>';
	}
}else{
	echo '<div class="lh40 clr5 f1 fs16">'.k_dn_ext_rack_snd.' ( '.get_val('lab_m_external_Labs','name_'.$lg,$sendetOut).' )</div>';
}
?>
</div>
<div class="fr printIcon" title="<?=k_print_sams?>" onclick="rackPrint(<?=$r_id?>)"> </div>
</div>
<div class="form_body so" style="padding-top:0px"><?
$sql="select * from lab_x_visits_samlpes where rack='$r_id' order by rack_pos ASC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$i=0;
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
	<tr><th>#</th><th>'.k_sample.'</th><th>'.k_patient.'</th><th>'.k_tests.'</th></tr>';
	$thisP=0;
	$outX=0;
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
		
		$RXY=getSAddrXY($r_id);
		$serv=getLinkedAna(2,0,$services,3);
		$cspan=count($serv);
		for($s=0;$s<$cspan;$s++){
			echo '<tr>';
			if($s==0){
				echo '						
				<td rowspan="'.$cspan.'" class="ff fs20 B">'.getSAView($rack_pos,$RXY[0],$RXY[1]).'</td>
				<td rowspan="'.$cspan.'">'.get_samlpViewC(0,$pkg_id,2,$no).'</td>
				<td rowspan="'.$cspan.'"><div class="f1 lh20 fs14">'.$p_data[0].' <br>'.$sex_types[$p_data[4]].' ( '.$p_data[1].' )</div></td>';		
			}
			$sss=explode(',',$serv[$s]);
			$xMsg='';$coll='';
			if($sss[0]==0){$xMsg='<div class="f1 clr5">'.k_tes_no_ext.'</div>';$coll='#ffeee';$outX++;}
			echo '<td bgcolor="'.$coll.'">'.$sss[1].$xMsg.'</td>';
			echo '</tr>';
		}
	}
	echo '</table>';
}?>
</div>
<div class="form_fot fr">
<? if($outX>0){echo '<div class="f1 fs16 clr5 lh40">'.k_rack_no_se_int.' <ff>( '.$outX.' )</ff></div>';}else{
	if($sendetOut==0){echo '<div class="bu bu_t3 fl" onclick="sendToOutLab()">'.k_send.'</div>';}
}?>
<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div></div>
</div>
<? }?>