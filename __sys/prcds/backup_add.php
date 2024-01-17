<? include("../../__sys/prcds/ajax_header.php");
$X_table=[
	'_backup',		
	'_help','_help_details','_help_hints','_help_videos',
	'_indexes','_p404','_q_time','_themes','_tp_temps',
	//'gnr_r_cash','gnr_r_charities','gnr_r_clinic','gnr_r_docs','gnr_r_docs_details','gnr_r_insurance','gnr_r_recepion','den_r_docs',	
];


$sql="select * from _programs ";
$progs=get_data('_programs','','','code asc');
?>
<div class="fxg h100" fxg="gtc:350px 1fr">
	<div class="h100 pd10f cbg444 r_bord ofx so">
		<div class="f1 lh30">الاسم</div>
		<div class="mg10b"><input type="text" name="name" value="<?=date('Y-m-d-h:i:s',$now)?>" id="backupName"/></div>		
		<table width="100%"  cellspacing="0" cellpadding="4" class="bord cbgw" type="static" >			
			<tr>
				<td width="40"><input type="checkbox" pro="mod" t="m" s/></td>
				<td class="f1">جداول الموديولات</td>					
			</tr>
			<tr>
				<td><input type="checkbox"  pro="sys" t="m" s/></td>
				<td class="f1">جداول النظام</td>
			</tr>
		</table>
		<div class="f1 fs16 lh40">البرامج</div>
		<table width="100%"  cellspacing="0" cellpadding="4" class="bord grad_s12 cbgw" type="static" >
			<tr class="cbg4">
				<th class="f1 lh20 TL" rowspan="3">البرامج</th>
				<th width="40" colspan="2">جدول M</th>				
				<th width="40" colspan="2">جدول X</th>				
			</tr>			
			<tr class="cbg4">
				<th width="40">الجدول</th>
				<th width="40">المحتوى</th>
				<th width="40">الجدول</th>
				<th width="40">المحتوى</th>
			</tr>
			<tr class="cbg4">
				<th width="40"><input type="checkbox" checked ch_pro_all="mt"/></th>
				<th width="40"><input type="checkbox" checked ch_pro_all="mc"/></th>
				<th width="40"><input type="checkbox" checked ch_pro_all="xt"/></th>
				<th width="40"><input type="checkbox" checked ch_pro_all="xc"/></th>
			</tr><?				
			if($progs['total']){
				foreach($progs['rows'] as $prg){?>
					<tr class="Over2">						
						<td class="f1"><?=$prg['name_'.$lg].' ( '.$prg['code'].' )'?></td>
						<td class="TC"><input type="checkbox" checked pro="<?=$prg['code']?>" t="m"/></td>
						<td class="TC"><input type="checkbox" checked proc="<?=$prg['code']?>" t="m"/></td>
						<td class="TC"><input type="checkbox" checked pro="<?=$prg['code']?>" t="x"/></td>
						<td class="TC"><input type="checkbox" checked proc="<?=$prg['code']?>" t="x"/></td>				
					</tr><?
				}
			}?>
		</table>
		<div class="ic40 ic40_set icc2 ic40Txt mg10t" prepareBackup>تحضير النسخة الاحتياطة</div>
	</div>
	<div class="h100 ofx so pd10">
		<table cellspacing="0" border="0" cellpadding="2" class="grad_s holdH pd10v" type="static" >
			<tr>
				<th width="40"></th>
				<th>الجدول</th>
				<th>عدد السجلات</th>
				<th>الحجم</th>				
				<th>المحتوى</th>			
			</tr><?
			$sql="show tables";
			$res=mysql_q($sql);
			$total=mysql_n($res);
			$x=0;
			$rowTxt='';
			$rowsTotal=0;
			$sizeTotal=0;
			while($r=mysql_f($res)){	
				$table=$r['Tables_in_'._database];
				if(!in_array($table,$X_table)){
					$x++;
					$type='';
					$tableCode=$table[4];
					if($tableCode!='x' && $tableCode!='m'){$tableCode='m';}
					$ch='checked';					
					if($table[0]=='_'){
						$ch='';
						$type='sys';
						$showC='';
						if(substr($table,0,4)=='_mod'){
							$type='mod';
						}
					}else{
						$type=substr($table,0,3);
						
					}
					$showC='<input type="checkbox" _proc="'.$type.'" t="'.$tableCode.'" _proc="'.$type.'" '.$ch.' /></td>';						
					//$content=
					list($size,$rows)=getTableDate($table);
					$rowsTotal+=$rows;
					$sizeTotal+=$size;
					$rowTxt.= '
					<tr tab="'.$table.'" t="'.$tableCode.'">
						<td><input type="checkbox" _pro="'.$type.'" t="'.$tableCode.'" '.$ch.' /></td>
						<td>'.$table.'</td>
						<td><ff14 class="clr88">'.number_format($rows).'</ff14></td>
						<td><ff14 class="clr66">'.getFileSize($size,2).'</ff14></td>
						<td>'.$showC.'</td>
					</tr>';
				}
			}
			$rowTxt.= '
			<tr>
				<td></td>
				<td>All</td>
				<td><ff14 class="clr88">'.number_format($rowsTotal).'</ff14></td>
				<td><ff14 class="clr66">'.getFileSize($sizeTotal,2).'</ff14></td>
				<td></td>
			</tr>';
			echo '<div class="lh40 f1 f18 clr1">عدد الجداول: '.$x.' -> '.$total.'</div>'.$rowTxt;?>
		</table>
	</div>
</div>