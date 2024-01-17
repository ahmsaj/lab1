<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id'],'s');
	$dir= $folderBack.'.backup/'.$id.'/';
	$info = $folderBack.'.backup/'.$id.'/_info.php';
	$tables = $folderBack.'.backup/'.$id.'/_tables.php';
	if(file_exists($info) && file_exists($tables)){
		include($folderBack.'.backup/'.$id.'/_info.php');
		include($folderBack.'.backup/'.$id.'/_tables.php');
		$info=json_decode($BU_info,true);
		$tables=json_decode($BU_tables,true);		
		?>
		<div class="fxg h100" fxg="gtc:300px 1fr">
			<div class="h100 pd10f cbg444 r_bord ofx so">
				<div class="f1 lh30 fs14">الاسم: <?=$info['name']?></div>
				<div class="f1 lh30 fs14">الكود: <?=$info['id']?></div>
				<div class="f1 lh30 fs14">عدد السجلات: <?=number_format($info['rows'])?></div>
				<div class="f1 lh30 fs14">الحجم: <?=getFileSize($info['size'],2)?></div>
				<div class="f1 lh30 fs14">الحالة: <?=$backupStatus[$info['status']]?></div>
				<div id="saveBU_info">
				<? 
				if($info['status']==0){
					echo '<div class="ic40 ic40_save icc33 ic40Txt mg10t" saveBackup>حفظ النسخة الاحتياطية</div>';					
				}
				if($info['status']==1){
					$per=$info['finshed_row']*100/$info['rows'];
					echo '<div class="cbgw pd10f br5 mg10v">
						<div class="f1 fs16 TC lh40">'.number_format($per,3).'%</div>
						<div class="snc_prog "><div style="width:'.number_format($per,3).'%"></div></div>
						<div class="f1 fs12 TC lh20">'.number_format($info['rows']).'/'.number_format($info['finshed_row']).'</div>
					</div>';
					echo '<div class="ic40 ic40_save icc33 ic40Txt mg10t" saveBackup>اكمال النسخة الاحتياطية</div>';
				}
				echo '<div class="ic40 ic40_del mg10b icc22 ic40Txt mg10t" backupDel="1">حذف النسخة الاحتياطية</div>';
				if($info['status']==2){
					$per=$info['finshed_row']*100/$info['rows'];					
					echo '<div id="backup_res_actions" class=" bord pd10f cbgw br5 ">';
					//echo $dir.'_info_res.php';
					if(file_exists($dir.'_info_res.php')){
						echo '
						<div class="f1 fs14 ">يوجد نسخة استرداد</div>
						<div class="ic40 ic40_set icc11 ic40Txt mg10t" restorBackupDo="'.$id.'">اكمال عملية الاسترداد</div>
						<div class="ic40 ic40_del icc22 ic40Txt mg10t" backupDel="2">الغاء العملية</div>';
					}else{				
						echo '<div class="f1 fs14 pd10b">نوع الاسترداد</div>
						<select id="resType">
							<option value="1">اهمال البيانات القديمة</option>
							<option value="2">الاحتفاظ بالبيانات القديمة الاضافية</option>
						</select>				
						<div class="ic40 ic40_set icc33 ic40Txt mg10t" restorBackup>استرداد الجداول المحددة</div>';
					}
					echo '</div>';
				}?>
				</div>
				
			</div>
			<div class="h100 ofx so pd10">
			<div >
				<? 
				if($info['status']==2){
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
					<tr>
						<th><input type="checkbox" chGrp="ta" checked /></th>
						<th>الجدول</th>
						<th>عدد السجلات</th>
						<th>الحجم</th>
						<th>يبدأ</th>
						<th>ينتهي</th>						
					</tr>';
					foreach($tables as $k=>$table){
						echo'<tr>
							<td><input type="checkbox" ta resTabs="'.$k.'" checked /></td>
							<td>'.$table['table'].'</td>
							<td>'.number_format($table['rows']).'</td>
							<td>'.getFileSize($table['size']).'</td>
							<td>'.$table['start'].'</td>
							<td>'.$table['end'].'</td>							
						</tr>';
					}
					echo '</table>';
				}else{
					foreach($tables as $table){?>					
						<div class="lh20 f1 "><?=$table['table']?> - <?=number_format($table['rows'])?></div>
						<div class="bord fx mg5v lh20">							
							<? foreach ($table['oprations'] as $k => $val){
								$clr='cbg4';
								if($val['status']){$clr='cbg6';}
								echo '<div class="'.$clr.' r_bord w100 lh20" style="height: 8px;" id="s_'.$val['no'].'" n="'.$val['no'].'"></div>';
							}?>
						</div><?
					}					
				}?>				
			</div>
		</div><?
	}
}?>
