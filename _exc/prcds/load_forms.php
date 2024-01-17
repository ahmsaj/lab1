<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['state'])){
	$id=0;
	$state=pp($_POST['state'],'s');?>
	<div class="win_body">
	<? if($state=='info_level1'){?>
			<div class="form_header so lh40 f1 fs18 fl">
				<div class="ic40 ic40_exc_report fl"></div>
				<div class="lh40 f1 fs18 fl pd10"><?=k_procedure_props?>:</div>
		</div>
	<?}?>
	<div comp class="form_body so">
	<? if($state=='info_level1' && isset($_POST['id'])){
		$id=pp($_POST['id']);
		$r=getRecCon('exc_import_processes',"id=$id");
		if($r['r']>0){
			$date_s=$r['p_start_date'];
			$level=$r['level'];
			$last_import_date=$r['last_import_date'];
			$file_id=$r['file_id'];
			$upFile=getUpFiles($file_id)[0];
			$fileName=splitNo($upFile['name']);
			$countRows=$r['count_rows'];
			$rejectRows=$r['reject_rows'];
			$start_req=$r['start_line'];
			$end_req=$r['end_line'];
			$countRows_req=$end_req-$start_req+1;
			
		}?>
		<table class="fTable" width="100%" cellpadding="3" cellspacing="3" border="0">
			<tr>
				<td n><?=k_file_name?> :</td>
				<td width="60%"><div class="f1 fs16 clr6 "><?=$fileName?></div></td>
			</tr>
			<tr>
				<td n><?=k_procedure_sate?>:</td>
				<td width="60%"><ff class="fs16" dir="ltr"><?=date('Y-m-d   h:mA',$date_s)?></ff></td>
			</tr>
			<tr>
				<td n><?=k_last_import_date?>:</td>
				<td width="60%"><ff class="fs16" dir="ltr"><?=date('Y-m-d   h:mA',$last_import_date)?></ff></td>
			</tr>
			<tr>
				<td n colspan="2">
					<div class="TC fs14 f1 lh30 clr1"> <?=k_imported?>
						( <ff class="fs16 clr6 "><?=$countRows_req?></ff> )
						 <?=k_out_of?>
						( <ff class="fs16 clr6 "><?=$countRows?></ff> )
						<?=k_recs?>  
					</div>
					<div class="TC fs14 f1 lh30 clr1">
						<?=k_from_line?>
						( <ff class="fs16 clr6"><?=$start_req?></ff> )
						=> <?=k_line?> 
						( <ff class="fs16 clr6 "><?=$end_req?></ff> )
					</div>
					<div class="TC fs14 f1 lh30 clr1">
						<?=k_declined_recs?>
						( <ff class="fs16 clr5"><?=$rejectRows?></ff> )
 					</div>
				</td>
			</tr>
		</table>
	<?}else if(isset($_POST['level'],$_POST['cb'])){
		$lev=pp($_POST['level']);
		$cb=pp($_POST['cb'],'s');
		if($lev==1){?>
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td n width="20%"> <?=k_file?> :</td>
						<td>
							<div style="margin-top:15px;">
								<?=upFile('ex','',1,$cb)?>
							</div>
						</td>
					</tr>
			</table>
		<?}
	}
	?>	
	</div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>   
		<? if($state=='info_level1'){?>
				<div class="bu bu_t3 fl" onclick="goLevel(<?=$id?>)"><?=k_import_again?></div>
		<?}?>
    </div>
    </div>
<?}?>
