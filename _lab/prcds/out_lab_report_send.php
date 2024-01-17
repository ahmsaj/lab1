<? include("../../__sys/prcds/ajax_header.php");
	if(isset($_POST['fil'] , $_POST['p'])){
		$pars=explode('|',$_POST['fil']);
		$q='';
		$q2='';
		$pat_q='';
		$q3='';
		foreach($pars as $p){
			if($p!=''){
				$pp=explode(':',$p);
				$cal=$pp[0];
				$val1=$pp[1];
				$val2=$pp[2];			
				if($cal=='p1'){$q.=" AND id ='$val1' ";}
				//if($cal=='p7'){$q.=" AND status ='$val1' ";}
				
				if($cal=='p3'){if($pat_q){$pat_q.=" AND ";}$pat_q.=" f_name like '%$val1%' ";}
				if($cal=='p5'){if($pat_q){$pat_q.=" AND ";}$pat_q.=" ft_name like '%$val1%' ";}
				if($cal=='p6'){if($pat_q){$pat_q.=" AND ";}$pat_q.=" l_name like '%$val1%' ";}
				
				if($cal=='p2'){if($q3){$q3.=" AND ";}$q3.=" short_name like '%$val1%' ";}
				
				if($cal=='d1'){
					if($val1){$q2=" and date_send > ". strtotime($val1);}
					if($val2){$q2=" and date_send < ".(strtotime($val2)+86400);}
					if($val1 && $val2){
						$q2=" and date_send > ". strtotime($val1)." and
						date_send < ".(strtotime($val2)+86400);
					}					
				}
			}
		}
		if($pat_q){$pat_q=" AND patient in (select id from gnr_m_patients where $pat_q )";}
		if($q3){$q3=" AND service in (select id from lab_m_services where $q3 )";}
		
		$sql="select count(*)rq from lab_x_visits_services_outlabs where out_lab>0 $q2 $q $pat_q $q3";
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
		$sql="select * from lab_x_visits_services_outlabs where out_lab>0 $q2 $q $pat_q $q3 order by date_send DESC $q_limit  ";
	
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
			<tr><th style="width: 30px;">#</th><th>'.k_send_date.'</th><th>'.k_thlab.'</th><th>'.k_analysis.'</th><th>'.k_patient.'</th><th width="100">'.k_sample_date.'</th><th>'.k_price.'</th><th>'.k_lab_price.'</th></tr>
			';
			while($r=mysql_f($res)){
				$x_id=$r['id'];
				$patient=$r['patient'];
				$out_lab=$r['out_lab'];
				$out_l_n=get_val('lab_m_external_labs','name_'.$lg,$out_lab);
				$status=$r['status'];
				$date_send=$r['date_send'];				
				$service=$r['service'];
				list($code,$shortName)=get_val('lab_m_services','code,short_name',$service);
				$price=$r['price'];
				$lab_price=$r['lab_price'];
				if($date_send){$date_send=dateToTimeS3($date_send);}
				$sample_d=lab_getout_sdate($x_id);
				echo'<tr>
				<td><ff>'.$x_id.'</ff></td>
				<td class="ff fs18">'.$date_send.'</td>
				<td class="f1">'.$out_l_n.'</td>
				<td class=""><div><ff class="clr1" dir="ltr">'.$code.' </ff> - <ff>'.$shortName.'</ff></div></td>
				<td class="f1s">'.get_p_name($patient).'</td>
				<td><ff>'.$sample_d.'</ff></td>
				<td><ff>'.$price.'</ff></td>
				<td><ff>'.$lab_price.'</ff></td>
				</tr>';
			}
			echo'</table></form>';
		}
		else{echo '<div class="f1 fs14 clr1>'.k_no_results.'</div>';}?>
		<script>$(document).ready(function(){loadFormElements('#outlabf');fixPage();fixForm();})</script><?
		echo '<!--***-->'.$page_view;
}
?>
