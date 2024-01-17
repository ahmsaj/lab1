<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['status'],$_POST['id'])){
	$id=pp($_POST['id']);
	$status=pp($_POST['status'],'s');
	if($status=='medicin'){
		$table='gnr_x_prescription_itemes';
	}elseif($status=='presc'){
		$table='gnr_x_prescription';
	}
	$note=get_val($table,'note',$id);?>
	<div class="win_body">
		<div class="form_header so lh40 clr1 ff fs18 B TC" ></div>
		<div class="form_body so">
		<div class="f1 fs16 lh30">أدخل الملاحظة :</div>
		<textarea class="fs18 w100" t id="maNote"><?=$note?></textarea>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t3 fl" onclick="presc_save_note(<?=$id?>,'<?=$status?>');"><?=k_save?></div>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>    
		</div>
	</div><?
}?>