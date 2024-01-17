<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"></div>
	<div class="form_body so">
	<?
	if($thisGrp=='hrwgtql5wk'){
		$r=getRec('gnr_x_insurance_rec',$id);	
		if($r['r']){
		$company=make_Combo_box('gnr_m_insurance_prov','name_'.$lg,'id',"",'comp',1,$r['company'])?>
		<form name="insur_edit" id="insur_edit" action="<?=$f_path?>X/gnr_insur_review_edit_save.php" method="post"  cb="insur_info(<?=$id?>);loadFitterCostom('gnr_insur_review');" bv="">
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
			<input type="hidden" name="id" value="<?=$id?>"/>
				<tr><td txt><?=k_insure_comp?></td><td><?=$company?></td></tr>
				<tr><td txt><?=k_insure_price?></td><td><input type="number" name="ip" value="<?=$r['in_price']?>"/></td></tr>
				<tr><td txt><?=k_includ?></td><td><input type="number" name="ipi" value="<?=$r['in_price_includ']?>"/></td></tr>
			</table>
		</form><? 
		}else{ echo '<div class="f1 clr5 fs16 lh40">'.k_no_rev_with_num.'</div>'; }
	}else{
		echo '<div class="f1 clr5 fs16 lh40">'.k_edit_not_allowed.'</div>';
	}?>
    </div>
    <div class="form_fot fr">
		<div class="bu bu_t3 fl" onclick="sub('insur_edit');"><?=k_save?></div>   
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
    </div>
    </div><?
}?>