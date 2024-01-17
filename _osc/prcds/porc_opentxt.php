<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['srv'])){
	$id=pp($_POST['id']);
	$srv=pp($_POST['srv']);
	$reportTitle=get_val('osc_m_report','name_'.$lg,$id);
	$reportVal=get_val_con('osc_x_report','report_val'," srv='$srv' and report='$id' ");
	?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=$reportTitle?></div>
	<div class="form_body so">
	<textarea class="so" id="reportT2"><?=$reportVal?></textarea>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="enter_osc_openText_save(<?=$id?>);"><?=k_save?></div>
		
    </div>
    </div><?
}?>