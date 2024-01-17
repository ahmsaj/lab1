<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$birth=get_val('gnr_m_patients','birth_date',$id);
	$birthCount=birthCount($birth);?>
	<div class="win_body">
	<div class="form_header">
		<div class="fl f1 fs16 lh40"><?=get_p_name($id)?></div>
           <div class="fr f1 fs16 lh40"><?=' [ <ff>'.$birthCount[0].'</ff> '.$birthCount[1].' ] '?></div>
	</div>
    <div class="form_body so"><?
	$sql="select * from lab_x_visits where patient='$id' order by d_start DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<div class="f1 fs18 clr1 lh40">'.k_visits.' <ff>[ '.$rows.' ] </ff></div>';
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
		<tr><th>#</th><th>'.k_date.'</th><th>'.k_status.'</th><th>'.k_tests.'</th></tr>'; 
		while($r=mysql_f($res)){
			$v_id=$r['id'];
			$patient=$r['patient'];
			$d_start=$r['d_start'];
			$type=$r['type'];				
			$v_status=$r['status'];
			$total=getTotalCO('lab_x_visits_services'," visit_id ='$v_id' ");
			if($total==0){
				$anal='<div class="f1 fs14 clr5">'.k_ntest.'</div>';
			}else{
				$anal='<div class="child_link fl" onclick="viwLabAnals('.$v_id.')">
				<div t>'.$total.'</div>'.k_analysis.'</div>';
			}				
			echo '
			<tr>
			<td><ff>'.$v_id.'</ff></td>
			<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
			<td class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'">'.$lab_vis_s[$v_status].'</td>
			<td>'.$anal.'</td>
			</tr>';
		}
		echo '</table>';
           
	}
	if($rows==0){echo '<div class="f1 fs14 clr5 lh40">'.k_no_vis_pat.' </div>';}
	/****************************************************************/?>
	</div>
	<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div></div>
	</div><?	
}
?>