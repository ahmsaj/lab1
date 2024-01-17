<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pt'],$_POST['t'],$_POST['src'])){
	$pt=pp($_POST['pt']);
	$t=pp($_POST['t']);
	$src=pp($_POST['src']);
	if($pt==1){
		$title='تسليم دفعة للمحاسبة';
		$title2='رصيد الصندوق الحالي ';
		$bal=getMBoxBal($thisUser);
	}
	if($pt==2){
		if($t==1){$title="دفعة من جمعية ";}
		if($t==3){$title="حسم لجمعية";}
		$title.=' ( '.get_val('gnr_m_charities','name_'.$lg,$src).' ) ';
		$title2='رصيد الجمعية';
		$bal=getCharBal(0,$src);
	}
	if($pt==3){
		if($t==1){$title="دفعة من شركة تأمين ";}
		if($t==3){$title="حسم لشركة التأمين";}
		$title.=' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$src).' ) ';
		$title2='رصيد الشركة';
		$bal=getInsrBal(0,$src);
	}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=$title?></div>
	<div class="form_body so">
			<form name="boxpay" id="boxpay" action="<?=$f_path.'X/acc_box_pay_save.php'?>" method="post" cb="boReload()">
			<input type="hidden" name="pt" value="<?=$pt?>" />
			<input type="hidden" name="t" value="<?=$t?>" />
			<input type="hidden" name="src" value="<?=$src?>" /><?			
			echo '<div class="f1 fs16 lh40 clr55">'.$title2.' :  <ff>'.number_format($bal['bal']).'</ff></div>';?>
			<div class="f1 fs16 lh40">المبلغ :</div>
			<div ><input type="number" name="amount" value="" inputHolder required></div>
			<div class="f1 fs16 lh40">ملاحظات :</div>
			<div><textarea class="w100" name="note"></textarea></div>
		</form>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="sub('boxpay');"><?=k_save?></div>
    </div>
    </div><?
}?>