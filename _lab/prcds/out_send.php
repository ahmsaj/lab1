<? include("../../__sys/prcds/ajax_header.php");
	if(isset($_POST['fil'] , $_POST['p'])){
		$pars=explode('|',$_POST['fil']);
		$q='';
		$q2='';
		$pat_q='';
		foreach($pars as $p){
			if($p!=''){
				$pp=explode(':',$p);
				$cal=$pp[0];
				$val1=$pp[1];
				$val2=$pp[2];			
				if($cal=='p1'){$q.=" AND name_$lg like '%$val1%' ";}
				if($cal=='p5'){$q.=" AND m.code='$val1' ";}
				if($cal=='p6'){$q.=" AND m.short_name like '%$val1%' ";}
				
				if($cal=='p2'){if($pat_q){$pat_q.=" AND ";}$pat_q.=" f_name like '%$val1%' ";}
				if($cal=='p3'){if($pat_q){$pat_q.=" AND ";}$pat_q.=" ft_name like '%$val1%' ";}
				if($cal=='p4'){if($pat_q){$pat_q.=" AND ";}$pat_q.=" l_name like '%$val1%' ";}
				if($cal=='p7'){if($pat_q){$pat_q.=" AND ";}$pat_q.=" sex = '$val1' ";}
				
				if($cal=='d1'){
					if($val1){$q2=" and x.sample_link in(select id from lab_x_visits_samlpes where  date > ". strtotime($val1).")";}
					if($val2){$q2=" and x.sample_link in (select id from lab_x_visits_samlpes where  date < ".(strtotime($val2)+86400).")";}
					if($val1 && $val2){
						$q2=" and x.sample_link in(select id from lab_x_visits_samlpes where  
						date > ". strtotime($val1)." and
						date < ".(strtotime($val2)+86400).")";
					}					
				}
			}
		}
		if($pat_q){$pat_q=" AND x.patient in (select id from gnr_m_patients where $pat_q )";}
		
		$sql="select count(*)rq from lab_x_visits_services x ,lab_m_services m where  x.service=m.id and x.out_lab=0 and m.outlab=1 and x.sample_link!=0  $q2 $q $pat_q";		
		$res=mysql_q($sql);	
		$r=mysql_f($res);		
		$all_total=$r['rq'];
		$pagination=pagination('','',25,$all_total); 
		$page_view=$pagination[0];
		$q_limit=$pagination[1];	
		$all_rows=$pagination[2];

		echo ' '.number_format($all_total).' <!--***-->';?>
		<form name="outlabf" id="outlabf" method="post" action="<?=$f_path?>X/lab_out_send_export.php" target="_blank">
		<input type="hidden" name="pars_sams_s" value="<?=$_POST['fil']?>"/>
		 
		<?	
		$sql="select * ,x.id as x_id  from lab_x_visits_services x ,lab_m_services m where  x.service=m.id and x.out_lab=0 and m.outlab=1 and x.sample_link!=0  $q2 $q $pat_q $q_limit ";
	
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
			<tr><th style="width: 30px;"><input type="checkbox" class="" par="check_all" name="ti_send"/></th><th>'.k_sample_date.'</th><th>'.k_num_serv.'</th><th>'.k_visit_num.'</th><th>'.k_patient.'</th><th width="100">'.k_test_code.'</th><th>'.k_short_name.'</th></tr>
			';
			while($r=mysql_f($res)){
				$x_id=$r['x_id'];
				$visit_id=$r['visit_id'];
				$code=$r['code'];
				$short_name=$r['short_name'];
				$patient=$r['patient'];				
				$price=$r['total_pay'];
				$sample=$r['sample'];
				$sample_link=$r['sample_link'];
				$samplDate=get_val('lab_x_visits_samlpes','date',$sample_link);
				if($samplDate){$samplDate=date('Y-m-d',$samplDate);}
				echo'<tr>
				<td params="'.$x_id.'">
				<input name="rec[]" type="checkbox" par="grd_chek" value="'.$x_id.'" /></td>
				<td class="ws"><ff>'.$samplDate.'</ff></td>
				<td><ff>'.$x_id.'</ff></td>
				<td><ff>'.$visit_id.'</ff></td>
				<td class="f1s">'.get_p_name($patient).'</td>
				<td>'.$code.'</td>
				<td>'.$short_name.'</td>							
				</tr>';
			}
			echo'</table></form>';
		}
		else{echo '<div class="f1 fs14 clr1>'.k_no_results.'</div>';}?>
		<script>$(document).ready(function(){fixPage();fixForm();loadFormElements('#outlabf');})</script><?
		echo '<!--***-->'.$page_view;
}
?>
