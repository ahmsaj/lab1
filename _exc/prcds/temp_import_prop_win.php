<? include("../../__sys/prcds/ajax_header.php");

if(isset($_POST['state'])){
	$state=pp($_POST['state'],'s');
	if($state=="info"){
		if(isset($_POST['id'])){
		$id=pp($_POST['id']);
	?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=$title?></div>
		<div class="form_body so">
		<? 
		$process=getRecCon('exc_import_processes',"id=$id");
		if($process['r']){
			$file=$process['file_id'];
			$upFile=getUpFiles($file)[0];
			$file_name=$upFile['name'];
			$countRows=$process['count_rows'];
			$countCols=$process['count_cols'];
			$start_line=$process['start_line'];
			$end_line=$process['end_line'];
			$reject_rows=$process['reject_rows'];
			$last_import_date=$process['last_import_date'];
			$imp_end=$process['imported_end'];
			$rejectShow=0;
			$clr='clr5';
			$imported_rows=$imp_end;
			if($last_import_date>0 && $imp_end==0 ){
				 $clr='clr1'; $rejectShow=1;
				$imported_rows=$end_line-$start_line-$reject_rows;
			}else if($last_import_date>0 && $imp_end>0){
				 $clr='clr6'; $rejectShow=1;
			}
		?>
			<table class="fTable" width="100%" cellpadding="2" cellspacing="2">
				<tr>
					<td n><?=k_file_name?>:</td>
					<td class="fs14 B <?=$clr?>"><?=$file_name?></td>
				</tr>
				<tr>
					<td n><?=k_file_lines?>:</td>
					<td><ff><?=number_format($countRows)?></ff></td>
				</tr>
				<tr>
					<td n><?=k_file_cols?>:</td>
					<td><ff><?=number_format($countCols)?></ff></td>
				</tr>
				<tr>
					<td n colspan="2"> <?=k_from_line?>
						<ff class="<?=$clr?> pd10">(<?=number_format($start_line)?>)</ff>
						=>  <?=k_line?> 
						<ff class="<?=$clr?> pd10">(<?=number_format($end_line)?>)</ff></td>
				</tr>
				<? if(!$rejectShow){?>
				 <tr>
					 <td n><?=k_lines_to_import?>:</td>
					 <td><ff class="<?=$clr?>"><?=number_format($end_line-$start_line)?></ff></td>
				</tr>
				<? }
				   else{?> 
					<tr>
						<td n><?=k_last_import_date?>:</td>
						<td width="55%"><ff dir="ltr"><?=date('Y-m-s  h:sA',$last_import_date)?></ff></td>
					</tr>
					<tr>
						<td n><?=k_imported_lines?></td>
						<td width="55%"><ff class="<?=$clr?>"><?=number_format($imported_rows)?></ff></td>
					</tr>
					<tr class="clr5">
						<td class="f1 fs14"><?=k_declined_lines?>:</td>
						<td><ff><?=number_format($reject_rows)?></ff></td>
					</tr>
				<? } ?>

			</table>
		<?}
		?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div> 
		</div>
		</div>

	<?}
	}elseif($state=="import"){
		if(isset($_POST['file'])){
			$file=pp($_POST['file']);
			$upFile=getUpFiles($file)[0];
			$path='../sFile/'.$upFile['folder'].$upFile['file'];
			if(file_exists($path)){
				$code =file_get_contents_utf8($path);
				eval($code);

				$id=getMaxMin('max','exc_templates','id');
				list($name,$date)=get_val('exc_templates','name,addition_date',$id);
				echo $id.'^'.$name.' - <span dir=\\\'ltr\\\'>'.date('Y-m-d   h:mA',$date).'</span>';
			}
		}
	}
}





?>