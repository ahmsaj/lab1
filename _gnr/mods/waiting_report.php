<? include("../../__sys/mods/protected.php");?>
<?
$satrtDate=date('Y-m-d');
$endDate=date('Y-m-d');
$s_ang=1;
$e_ang=60;
$r_ang=10;?>
<script src="<?=$m_path?>library/highstock/js/highstock.js"></script> 
<script src="<?=$m_path?>library/highstock/js/modules/exporting.js"></script>

<div class="centerSideInFull of">
<div class="fl r_bord ofx so pd10f cbg444" fix="w:320|hp:0" id="wr_input">
	<div class="f1 fs18 clr1 lh40 uLine"><?=$def_title?></div>
	<div class="f1 clr1111 lh40 fs14"><?=k_report?> :</div>
	<select name="rep" t>
		<option value="1"><?=k_waiting?> </option>
		<option value="2"><?=k_appointments?> </option>
	</select>
	<div class="f1 clr1111 lh40 fs14"><?=k_deprts?> :</div>
	<select name="part" t><?
		foreach($clinicTypes as $k => $p){
			if(!$p){$p=k_all_deps;}
			echo '<option value="'.$k.'">'.$p.'</option>';
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
	<div class="fl w100"> </div>	
	<div class="fl " fix="wp%:50">
		<div class="f1 clr1111 lh40 fs14"><?=k_minm?> :</div>
		<input type="number" value="<?=$s_ang?>" name="min"/>
	</div>
	<div class="fr " fix="wp%:50">
		<div class="f1 clr1111 lh40 fs14"><?=k_mxm?>:</div>
		<input type="number" value="<?=$e_ang?>" name="max"/>
	</div>
	<div class="f1 clr1111 lh40 fs14"><?=k_range_calc_rep?> :</div>
	<input type="number" value="<?=$r_ang?>" name="avg"/>
	<div class="ic40 icc2 ic40Txt ic40_send mg10v" onclick="wr_send()"><?=k_res_rev?></div>
</div>
<div class="fl ofx so pd10f" fix="wp:320|hp:0" id="w_rep_data"></div>
</div>
<script>sezPage='';
$(document).ready(function(e){
	//loadFormElements('#w_rep');			
	//setupForm('w_rep','');	
	fixForm();
	fixPage();
});</script>