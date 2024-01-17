<? include("../../__sys/prcds/ajax_header.php");
$userStor=get_val('_users','subgrp',$thisUser);?>
<div class="win_body">
<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');loadModule();"></div></div><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$str_rec=get_val('str_x_transfers','str_rec',$id);
	list($name,$part,$s_part)=get_val('str_m_stores','name_'.$lg.',part,s_part',$str_rec);
	?>
	<div class="shItTree fl">
		<div class="strItitle lh50"><input type="text" id="treeSer" onkeyup="treeSear(2)"/></div>
		<div id="itreeD"><div class="loadeText"><?=k_loading?></div></div>
	</div>
	<div class="shItDet fl">
		<div class="strIttitle f1 fs16 clr1 lh50"><?=k_items_sent_to?> ( <?=$name?> )</div>
		<div class="strItDetIn so" id="transItems"></div>
	</div><?
}?>
</div>