<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRecCon('dts_x_dates'," id='$id' and status=10 and (reg_user=0 OR reg_user='$thisUser') ");
	if($r['r']){		
		$patient=$r['patient'];
		$p_type=$r['p_type'];
		$date=$r['date'];		
		$app=$r['app'];				
		$s=$r['d_start'];
		$e=$r['d_end'];
		$note=$r['pat_note'];
		$c_type=$r['type'];
		$status=$r['status'];
		$reg_user=$r['reg_user'];
		if(!$reg_user){mysql_q("UPDATE dts_x_dates SET reg_user='$thisUser' where id='$id' ");}
		$p_name=get_p_dts_name($patient,$p_type);				
		if($p_type==2){$pTxt.=' <span class="f1 clr5"> ( مريض مؤقت )</span>';}
		//$AppName=get_val_arr('api_users','name_'.$lg,$app,'a');
		$AppName='';
		?>
		<div class="win_body">
			<div class="form_header">
				<div class="fr f1 fs16">منذ <?=splitNo(dateToTimeS($now-$date))?></div>
				<div class="lh40 clr1 f1 fs18"><?=$p_name.$pTxt?></div>
				<div class="so lh40 clr1 f1 fs18 fl"><?					
					if($p_type==1){			
						list($mobile,$phone)=get_val('gnr_m_patients','mobile,phone',$patient);
						if($mobile || $phone){
							echo '<div><bdi><ff>'.$mobile.' - '.$phone.'</ff></bdi></div>';
						}
					}
					if($p_type==2){
						list($mobile,$phone)=get_val('dts_x_patients','mobile,phone',$patient);		
						if($mobile || $phone){
							echo '<div><bdi><ff>'.$mobile.' - '.$phone.'</ff></bdi></div>';
						}
					}?>
				</div>
				
			</div>
			<div class="form_body so">
				<div class="f1 fs16 lh40 clr1111">تم حجز الموعد عن طريق ( <?=$AppName?> ) </div>
				<table width="100%" border="0" class="grad_s" cellspacing="0" cellpadding="4" type="static">		
				<tr><td txt> الموعد</td><td><div class="f1 fs16 lh30 clr1">
				<?= $wakeeDays[date('w',$s)].' - <ff>'.	date('d',$s).'</ff> - '.$monthsNames[date('n',$s)].' - <ff>'.date('Y',$s).'</ff> | الساعة <ff dir="ltr" class="clr5">'.date('A h:i',$s).'</ff>';?></div>
				<div class="f1 fs16"><ff><?=($e-$s)/60?></ff> دقيقة</div></td></tr>
				<tr><td txt width="150">تاريخ الحجز</td><td><ff><?=date('Y-m-d A h:i',$date)?></ff></td></tr>		
				<tr><td txt>العيادة</td><td txt><?=get_val('gnr_m_clinics','name_'.$lg,$r['clinic'])?></td></tr>
				<tr><td txt>الطبيب</td><td txt><?=get_val('_users','name_'.$lg,$r['doctor'])?></td></tr>
				<? if($note){echo '<tr><td txt>ملاحظات المريض</td><td><div class="clr5 f1 ">'.nl2br($note).'</div></td></tr>';}?>
				</table><? 
				$sql="select * from dts_x_dates where patient='$patient' and p_type='$p_type' and id!='$id' order by d_start DESC ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){ ?>
					<div class="f1 clr55 fs18 lh50">المواعيد السابقة <ff> ( <?=$rows?> ) </ff></div>
					<table width="100%" border="0" class="grad_s" cellspacing="0" cellpadding="4" type="static" over="0">
					<tr>
						<th>التاريخ</th>
						<th>العيادة</th>
						<th>الطبيب</th>
						<th>الحالة</th>
					</tr><? 
					while($r=mysql_f($res)){						
						$date=$r['date'];
						$s=$r['d_start'];
						$e=$r['d_end'];
						$c_type=$r['type'];
						$clinic=$r['clinic'];
						$doctor=$r['doctor'];
						$status=$r['status'];
						$clinicTxt=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
						$docTxt=get_val_arr('_users','name_'.$lg,$doctor,'u');
						?>
						<tr bgcolor="<?=$dateStatusInfoClr[$status]?>">
						<td><ff><?=date('Y-m-d',$s)?></ff></td>
						<td txt><?=$clinicTxt?></td>
						<td txt><?=$docTxt?></td>
						<td txt><?=$dateStatusInfo[$status]?></td>
						</tr><? 
					}?>
					</table><?
				} ?>
			</div>

			<div class="form_fot fr">
				<div class="bu bu_t4 fl" onclick="dtsAppAccp(1);">تثبيت الموعد</div>
				<div class="bu bu_t3 fl" onclick="dtsAppAccp(2);">الغاء الموعد</div>
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
			</div>
		</div><?
	}else{ echo script("dtsApp(1);win('close','#m_info');");}
}?>