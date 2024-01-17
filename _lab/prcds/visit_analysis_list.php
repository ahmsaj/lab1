<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$vis=pp($_POST['id']);
	$patient=get_val('lab_x_visits','patient',$vis);
	$d_start=get_val('lab_x_visits','d_start',$vis);
	$err=0;
	$err_msg='';?>
	<div class="win_body">
	<div class="form_header">
	<div class="fr"><ff clr5><?=date('Y-m-d',$d_start)?></ff></div>
	<div class="fl">

		<div class="lh20 fs16 f1 clr1111 ws Over" onclick="editPat2(<?=$patient?>,<?=$vis?>);"><?=get_p_name($patient)?></div>
		<div class="f1 fs14 clr1 lh30"><?=k_tst_vis?> <ff> ( <?=$vis?> )</ff></div>
	</div>
	</div>
	<div class="form_body so"><?		
	$sql="select * , x.id as x_id ,sample from lab_m_services z , lab_x_visits_services x where x.service=z.id and x.visit_id='$vis' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
		<tr><th>'.k_analysis.'</th><th>'.k_sample.'</th><th>'.k_tubs.'</th><th>'.k_status.'</th></tr>';
		$rrSrv=0;
		$pkg_ids='';
		while($r=mysql_f($res)){
			// echo show_array($r);
			$ser_id=$r['x_id'];
			$ser_name=$r['short_name'];
			$status=$r['status'];
			$sample_type=$r['sample'];
			$pkg_id=$r['tube'];
			$sample_pg=get_val('lab_m_samples','pg',$sample_type);
			$sample_pg_v=get_samlpViewC(0,$pkg_id,4,$r['no']);

			echo '<tr bgcolor="'.$anStatsTxt_Col[$status].'"><td class="ff fs16 B lh30">'.$ser_name.'</td>
			<td class="f1">'.get_val('lab_m_samples','name_'.$lg,$sample_type).'</td> 
			<td>'.$sample_pg_v.'</td>
			<td class="f1">'.$anStatsTxt[$status].'</td>				
			</tr>';
		}			
		echo '</table>';			
	}
	?>	
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>
	</div>
	</div><?
}?>