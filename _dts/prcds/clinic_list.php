<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$name=get_val('gnr_m_clinics','name_'.$lg,$id)?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=$name?> <ff><?=date('d-m-Y')?></ff></div>
	<div class="form_body so"><?
	$dates_arr=array();
	$clinic_arr=array();
	$sql="select * from dts_x_dates where d_start>='$ss_day' and d_start<'$ee_day' and clinic='$id' order by d_start ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" over="0" >
		<tr><th>الموعد</th><th>المدة</th><th>المريض</th><th>الطبيب</th><th>الحالة</th><th>العمليات</th></tr>';
		while($r=mysql_f($res)){
			$d_id=$r['id'];
			$doctor=$r['doctor'];
			$patient=$r['patient'];
			$p_type=$r['p_type'];
			$date=$r['date'];
			$status=$r['status'];
			$name=$r['name_'.$lg];	
			$d_status=$r['status'];
			$c_type=$r['type'];
			$d_start=$r['d_start'];
			$ds=$r['d_start']-$ss_day;
			$de=$r['d_end']-$ss_day;
            $other=$r['other'];
			$p_name=get_p_dts_name($patient,$p_type);
						
			$p_note='';
			$action='confirmDate('.$d_id.','.$c_type.')';
			if($p_type==2 || $other){
				$p_note='<div class="f1 clr5 lh20">يجب تثبيت اسم المريض</div>';
				$action='selDaPat('.$d_id.',2,'.$c_type.')';
			}
			$d_t=$de-$ds;
			
			$flasher='';
			
			if($d_status==2 && $d_start < $now ){$flasher='flasher2';}	
			if($d_status==2 && $d_start < $now-(60*_set_d9c90np40z ) ){
				$flasher='flasher';				
			}
			echo '<tr bgcolor="'.$dateStatusInfoClr[$status].'" class="'.$flasher.'">
				<td><ff>'.clockStr($ds).'</ff></td>
				<td class="f1 fs14"><ff>'.($d_t/60).'</ff> '.k_minute.'</td>
				<td class="f1 fs14">'.$p_name.$p_note.'</td>
				<td class="f1 fs14">'.get_val('_users','name_'.$lg,$doctor).'</td>
				<td class="f1 fs12">'.$dateStatusInfo[$status].'</td>
				<td>
					<div>
						<div class="ic40 icc1 ic40_info fl" title="تفاصيل" onclick="dateINfo('.$d_id.')"></div>';
						if($status==1){echo '<div class="ic40 icc2 ic40_done fl" title="تأكيد حضور المريض" onclick="'.$action.'"></div>';}
					   echo '</div>
				</td>
			</tr>';									
		}
		echo '</table>';
	}?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
    </div>
    </div><?
}?>