<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
$id=pp($_POST['id']);
list($vis,$patient)=get_val('lab_x_visits_services','visit_id,patient',$id);
if($lastSample=getLastSample($patient,$vis)){
	$sql="select * , x.id as x_id , x.fast as x_fast from lab_m_services z , lab_x_visits_services x where x.service=z.id and x.visit_id='$vis' and status IN(0,2,4) and x.id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$ser_id=$r['x_id'];
		$ser_name=$r['short_name'];
		$outlab=$r['outlab'];
		$status=$r['status'];
		$sample_type=$r['sample'];
		$fast=$r['x_fast'];
		$sample_pg=get_val('lab_m_samples','name_'.$lg,$sample_type);
		?>
		<div class="win_body">
		<div class="form_header lh40 f1 fs18 clr1">
		<div class="fl f1s fs18 clr1 lh40"><?=get_p_name($patient)?></div>
		<div class="fr f1 fs18 clr1 lh40"><?=$ser_name?> <span class="clr5 f1 fs18">( <?=$sample_pg?> )</span></div></div>
		<div class="form_body so"><?
		$d=$now-86400;
		$sql="select * from lab_x_visits_samlpes where patient='$patient' and date > $d and visit_id!='$vis' and status NOT IN(4,5) and pkg_id IN($lastSample)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<div class="f1 fs18 clr1 lh40">'.k_sampels.'</div>
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s" over="0">
			<tr><th>'.k_sample.'</th><th>'.k_tests.'</th><th>'.k_status.'</th><th width="30"></th></tr>';
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$pkg_id=$r['pkg_id'];
				$services=$r['services'];
				$visit_id=$r['visit_id'];
				$no=$r['no'];
				$s_taker=$r['s_taker'];
				$status=$r['status'];
				$date=$r['date'];
				$fast=$r['fast'];
				$sub_s=$r['sub_s'];
				$fastTxt='';
				if($fast){$fastTxt='<div class="f1 clr5 lh20 cb"> '.k_emergency.' </div>';}		//		
				//if($status==0){$rrPG=1;}
				$sample_pg_v=get_samlpViewC(0,$pkg_id,4,$no);
				$sample_pg_v2='<div class="f1 clr1 Over B" onclick="slSpare('.$s_id.',0)">'.k_crt_busm.'</div>';
				echo '<tr '.$bg.'><td class="f1 fs14 lh30">'.$sample_pg_v.'</td>
				<td class="f1">'.getLinkedAna($status,$s_id,$services).'</td> 				
				<td class="f1 lh30">'.$anStatsTxt2[$status].$fastTxt.'
				<div class="cb ff clr55 fs18 "><ff>'.date('Y-m-d A h:i:s',$date).'</ff></div>
				<div class="cb f1 clr5 fs14 B">'.k_since.' : <ff>'.dateToTimeS2($now-$date).'</ff></div>
				</td>
				<td><div class="ic40 icc1 ic40_link fr" title="'.k_link_ana2this.'" onclick="marageAnaSave('.$s_id.');"></div></div></td></tr>';
			}
			echo '</table>';
			
		}
		if($err==0 && $rrPG==1){$err=1;$err_msg=k_num_tbs_ent;}
		?>
		</div>
		<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div></div>
		</div><?
	}
}?>

<? }?>