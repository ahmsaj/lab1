<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['state'])){
	$state=pp($_POST['state']);
	if($state==1){
		$sql="select * from exc_files_import";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
			<table class="grad_s" cellpadding="2" cellspacing="2" width="100%">
				<tr>
					<th><?=k_file_name?></th>
					<th></th>
				</tr>
			<?
			while($r=mysql_f($res)){
				$file=$r['file'];
				$fileName=getUpFiles($file)[0]['name'];
			?>
				<tr>
					<td><?=$fileName?></td>
					<td>
						<div class="ic40 icc3 ic40_save fl" onclick="importDo_client()"></div>
						<div class="ic40 icc2 ic40_del fl"></div>
					</td>
				</tr>
		<? }?>
			</table>
		<?}
	}

}?>