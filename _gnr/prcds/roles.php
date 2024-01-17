<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from gnr_x_roles where  status < 3  order by vis ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);?>
<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=k_waiting?> <ff> ( <?=$rows?> ) </ff></div>
	<div class="form_body so"><?
		if($rows){	
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr>
				<th>'.k_clinic.'</th>
				<th width="180">'.k_num.'</th>
				<th>'.k_patient.'</th>
				<th>'.k_tim.'</th>
				<th>'.k_status.'</th>
			</tr>';
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$patient=$r['pat'];
				$clinic=$r['clic'];
				$mood=$r['mood'];
				$no=$r['no'];
				$date=$r['date'];
				$type=$r['type'];				
				$v_status=$r['status'];
				$fast=$r['fast'];
				$clinicTxt=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c1');
				$clinicC=get_val_arr('gnr_m_clinics','code',$clinic,'c2');							
				$statusCol=$status;										
				$textCode=$clinicC.'-'.$no;
				if($fast && $status==0){$statusCol='9'.$fast;}
				if($fast==2){$textCode=clockStr($no);}
				
				echo '				
				<tr>
				<td class="f1 fs18">'.$clinicTxt.'</td>
				<td><div rr sr="s'.$statusCol.'" class="pd10">'.$textCode.'</div></td>
				<td><div class="f1 fs18 clr1">'.get_p_name($patient).'</div></td>
				<td><ff>'.date('A h:i',$date).'</ff></td>
				<td><span class="f1 fs14" style="color:'.$stats_arr_col[$v_status].'"></td>
				</tr>';
			}
			echo '</table>';            
		}else{echo '<div class="f1 fs14 clr5 lh40">'.k_npat_wait.'</div>';}
	?>
	</div>
	<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div></div>
</div>