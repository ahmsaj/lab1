<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['related_id'],$_POST['view'])){
	$related_id=pp($_POST['related_id'],'s');
	$win=pp($_POST['view'],'s');
	$code='';
	if(isset($_POST['code'])){
		$code=pp($_POST['code'],'s');
		$code2=stripcslashes($code);
		$code=str_replace("\\'",'"',$code2);
	}
?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18">
		<div class="fl ic40 ic40_code"></div> 
		<div class="fl lh50 clrb f1 fs18 pd10"><?=k_write_code?></div>
	</div>
	<div class="form_body so">
			<div class="f1 fs16 clr5 pd10"><?=k_write_code_to_apply_on_field?><span class="fs18" dir="ltr">($input)</span> <?=k_returned_in_variable?> <span class="fs18" dir="ltr">($output)</span> </div>
		
			<div style="margin-left:50px; margin-bottom:10px" class="fs14 clr1 B" dir="ltr">function custom($input){</div>
			<center><textarea class="fs14 so" fix="w:600|h:250" dir="ltr" name="exc_code"><?=$code?></textarea></center>
			<div style="margin-left:50px;" class="fs14 clr1 B" dir="ltr"><div style="margin-left:20px; margin-top:10px">return $output;</div>}</div>
		
		
		
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','<?=$win?>');"><?=k_close?></div>     
        <div class="bu bu_t1 fl" onclick="saveCustomField('<?=$related_id?>','<?=$win?>')"><?=k_save?></div>     
    </div>
    </div><?
}?>