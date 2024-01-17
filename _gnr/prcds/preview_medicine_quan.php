<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_prescription_itemes',$id);
	if($r['r']){
		$mad_id=$r['mad_id'];
		$quantity=$r['presc_quantity'];
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 ff fs18 B TC" ><?=get_val('gnr_m_medicines','name',$mad_id)?></div>
		<div class="form_body so">
			<div class="f1 fs16 lh30">أدخل الكمية :
			<input type="number" id="maQun" value="<?=$quantity?>" style="width:120px"></input>
			</div>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t3 fl" onclick="editMdcQsave(<?=$id?>);"><?=k_save?></div>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>    
		</div>
		</div><?
	}
}?>