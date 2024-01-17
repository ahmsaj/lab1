<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');loadModule();"></div></div><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="shItTree fl">
		<div class="strItitle lh50"><input type="text" id="treeSer" onkeyup="treeSear(1)"/></div>
		<div id="itreeD"><?=drowTree('',1,1);?></div>
	</div>
	<div class="shItDet fl">
		<div class="strIttitle f1 fs16 clr1 lh50"><?=k_number_invoice?> <ff> #<?=get_val('str_x_bill','no',$id)?> </ff></div>
		<div class="strItDetIn so" id="shipItems"></div>
	</div><?
}?>
</div>