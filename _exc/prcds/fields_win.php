<? include("../../__sys/prcds/ajax_header.php");
//include("../__sys/excel/func.php");
if(isset($_POST['id'],$_POST['fields'])){
	$process_id=pp($_POST['id']);
	$choosenFields=$_POST['fields'];
	$choosenFields=explode(',',$choosenFields);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=k_choos_fields?>:</div>
	<div class="form_body so of">
	<?$fileFields=getFileFields($process_id);?>
		<div class="fl r_bord"  fix="hp:0|w:250">
			<div  class="lh40 f1 fs18 clr1 TC uLine"><?=k_file_fields?> </div>
			<div fix="hp:50" class="ofx so" all>
			<? foreach($fileFields as $rank=>$name){
					?>
					<div field_rank="<?=$rank?>" onclick="choiceField(<?=$rank?>,'<?=$name?>')">
						<div rr class="fl h100 lh30" fix="w:40"><?=$rank?></div>
						<div n class="fl h100 lh30" fix="wp:40"><?=$name?></div>
					</div>
			<?}?>
			</div>
		</div>
		
		<div class="fl" fix="wp:250|hp:0">
			<div class="lh40 f1 fs18 clr1 TC uLine"><?=k_chosen_fields?></div>
			<div class="ofx so pd10" fix="hp:50" choosen>
			<?  foreach($fileFields as $rank=>$name){
				$hide='class="hide"';
				 if(in_array($rank,$choosenFields)){$hide='exist';}?>
					<div field_rank="<?=$rank?>" onclick="delChoosenField(<?=$rank?>)" <?=$hide?> >
						<div rr class="fl h100 lh30" fix="w:40"><?=$rank?></div>
						<div n class="fl h100 lh30" fix="wp:40"><?=$name?></div>
					</div>
				<?}?>
			</div>
		</div>
		
		
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
        <div class="bu bu_t1 fl" onclick="emptyFieldSave();"><?=k_save?></div>     
    </div>
    </div><?
}?>