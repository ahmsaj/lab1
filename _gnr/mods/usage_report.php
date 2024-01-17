<? include("../../__sys/mods/protected.php");?>
<?
$satrtDate=date('Y-m-d');
$endDate=date('Y-m-d');?>
<div class="centerSideInFull of">
<div class="fl r_bord ofx so pd10f cbg444" fix="w:320|hp:0" id="su_input">
	<div class="f1 fs18 clr1 lh40 uLine"><?=$def_title?></div>	
	<div class="f1 clr1111 lh40 fs14"><?=k_deprts?> :</div>
	<select name="part" t><?
		foreach($clinicTypes as $k => $p){
			if($k && in_array($k,array(1)) ){
				echo '<option value="'.$k.'">'.$p.'</option>';
			}
		}?>
	</select>	
	<div class="fl " fix="wp%:50">
		<div class="f1 clr1111 lh40 fs14"><?=k_frm_dte?> :</div>
		<input type="text" value="<?=$satrtDate?>" name="ds" class="Date" fix=""/>
	</div>
	<div class="fr" fix="wp%:50">
		<div class="f1 clr1111 lh40 fs14"><?=k_tdate?> :</div>
		<input type="text" value="<?=$endDate?>" name="de"  class="Date"/>
	</div>	
	<div class="cb w100 lh20"> </div>
	<div class="ic40 icc2 ic40Txt ic40_send mg10v" onclick="su_send()"><?=k_res_rev?></div>
</div>
<div class="fl ofx so pd10f" fix="wp:320|hp:0" id="su_rep_data"></div>
</div>
<script>sezPage='';
$(document).ready(function(e){fixForm();fixPage();});</script>