<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'])){
	$t=pp($_POST['t']);?>	
	<div class="fxg w100 h100 " fxg="gtc:240px 1fr|" >
		<div class="fl r_bord pd10 ofx so cbg4"><?=patForm()?></div>
		<div class="fl pd10 ofx so" fix1="wp:220|hp:0" patList></div>
	</div><?
}?>