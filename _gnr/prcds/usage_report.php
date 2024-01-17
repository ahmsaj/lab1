<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['part'],$_POST['ds'],$_POST['de'])){
	$out='';	
	$part=pp($_POST['part']);
	$ds=pp($_POST['ds'],'s');
	$de=pp($_POST['de'],'s');	
	$partTxt=$clinicTypes[$part];
	$dss=strtotime($ds);
	$dee=strtotime($de)+86400;
	if($dss<$dee){
		$data=array();
		$sql="select * from gnr_m_it_set where FIND_IN_SET($part,`parts`) > 0 and act=1 ORDER BY `ord` ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){while($r=mysql_f($res)){$data[$r['id']]=$r;}}
		$title2=$ds.' - '.$de;
		echo '<div class="f1 fs18 lh40 clr1 uLine">'.$partTxt.' <ff14 dir="ltr">'.$ds.' | '.$de.'</ff14></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
		<tr>
			<th rowspan="2">الطبيب</th>
			<th rowspan="2">عدد الزيارات</th>';
			foreach($data as $d){echo '<th colspan="2">'.$d['name_'.$lg].'<br><ff14>'.$d['mark'].'</ff14></th>';}
			echo '<th  rowspan="2">مجموع العلامات</th>
			<th  rowspan="2">العلامة النهائية</th>			
		</tr>
		<tr>';
			foreach($data as $d){echo '<th>العدد</th><th>العلامة</th>';}
			echo '			
		</tr>';
		$sg=$docsGrpMood[$part];
		$v_table=$visXTables[$part];
		$sql="select * from _users where grp_code='$sg' and act=1 order by name_$lg ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			while($r=mysql_f($res)){
				$doc_id=$r['id'];
				$name=$r['name_'.$lg];
				$vis=getTotalCO($v_table," doctor='$doc_id' and d_start>='$dss' and d_start<'$dee' and status=2 and t_total_pay>0");
				$m_mark=0;
				$d_mark=0;
				if($vis){
					echo '
					<tr>
						<td txt>'.$name.'</td>
						<td><ff14 class="clr11">'.number_format($vis).'</ff14></td>';
						foreach($data as $d){
							$m_id=$d['id'];
							$mark=$d['mark'];
							$mark_total=$d['mark_total'];
							$no=getItemMark($doc_id,$m_id,$dss,$dee);
							$thisMark=($mark*$no)/$vis;
							$m_mark+=$mark_total;							
							$d_mark+=$thisMark;
							echo '<td><ff14 class="clr1">'.number_format($no).'</ff14></td>
							<td  class="fs14"><ff14 class="clr5">'.number_format($thisMark,1).'</ff14></td>';
						}
						$fin_mark=$d_mark*100/$m_mark;
						$clr="cbg666";
						if($fin_mark<=0){$clr="cbg555";}
						echo '<td class="fs14"><ff14 class="clr5">'.number_format($d_mark,1).'</ff14></td>
						<td class="'.$clr.'"><ff14 dir="ltr">%'.number_format($fin_mark,1).'</ff14></td>
					</tr>';
				}
			}
		}
		echo '</table>';
		
		
	}else{
		echo '<div class="f1 fs16 lh40 clr5 ">'.k_error_data.'</div>';
	}	
}